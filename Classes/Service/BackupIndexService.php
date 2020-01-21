<?php
namespace Breadlesscode\Backups\Service;

use Breadlesscode\Backups\Factory\FilesystemFactory;
use Carbon\Carbon;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;
use League\Flysystem\Filesystem;
use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope(value="singleton")
 */
class BackupIndexService
{
    /**
     * file name of the backup index file
     * it contains all backup meta data
     */
    const BACKUP_INDEX_FILENAME = 'backups.csv';

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @Flow\InjectConfiguration(path="tempPath")
     * @var string
     */
    protected $tempPath;

    /**
     * @Flow\InjectConfiguration(path="filesystem")
     * @var string
     */
    protected $filesystemConfig;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function initializeObject()
    {
        $filesystemFactory = $this->objectManager->get(FilesystemFactory::class);
        $this->filesystem = $filesystemFactory->get($this->filesystemConfig['type']);
    }

    public function getReader(): ?Reader
    {
        if (!$this->filesystem->has(self::BACKUP_INDEX_FILENAME)) {
            return null;
        }

        $indexFileStream = $this->filesystem->readStream(self::BACKUP_INDEX_FILENAME);
        $reader = Reader::createFromStream($indexFileStream);
        $reader->setDelimiter(';');

        return $reader;
    }

    protected function normalizeRow(array $csvRow)
    {
        return [
            'name' => $csvRow[0],
            'date' => Carbon::createFromFormat(Carbon::ATOM, $csvRow[1]),
            // @todo wire with neos local for right translation
            'dateHuman' => Carbon::createFromFormat(Carbon::ATOM, $csvRow[1])->diffForHumans(),
            'meta' => unserialize($csvRow[2]),
        ];
    }

    public function addBackup(string $name, \DateTime $date, array $meta)
    {
        if($this->filesystem->has(self::BACKUP_INDEX_FILENAME)) {
            file_put_contents($this->tempPath.'/'.self::BACKUP_INDEX_FILENAME, $this->filesystem->read(self::BACKUP_INDEX_FILENAME));
        }

        $localStream = fopen($this->tempPath.'/'.self::BACKUP_INDEX_FILENAME, 'a+');

        $writer = Writer::createFromStream($localStream);
        $writer->setDelimiter(';');
        $writer->insertOne([$name, $date->format(\DateTime::ATOM), serialize($meta)]);

        $this->filesystem->putStream(self::BACKUP_INDEX_FILENAME, $localStream);
        fclose($localStream);
        unlink($this->tempPath.'/'.self::BACKUP_INDEX_FILENAME);

        return true;
    }

    public function deleteBackup(string $name)
    {
        $reader = $this->getReader();
        $writer = Writer::createFromFileObject(new \SplTempFileObject());
        $writer->setDelimiter(';');
        $currentItem = 0;
        $success = false;

        while($line = $reader->fetchOne($currentItem)) {
            $currentItem++;

            if ($line[0] === $name) {
                if ($this->filesystem->has($line[0])) {
                    $this->filesystem->delete($line[0]);
                    $success = true;
                }
                continue;
            }

            $writer->insertOne($line);
        }

        if ($this->filesystem->has(self::BACKUP_INDEX_FILENAME)) {
            $this->filesystem->update(self::BACKUP_INDEX_FILENAME, $writer->getContent());
        } else {
            $this->filesystem->write(self::BACKUP_INDEX_FILENAME, $writer->getContent());
        }

        return $success;
    }

    public function getBackups(int $start = 0, int $limit = 25): array
    {
        $reader = $this->getReader();
        $backups = [];

        if($reader === null) {
            return $backups;
        }
        // calculate reverse pagination data
        $rowCount = $reader->count() - 1;
        $currentItem = $rowCount - $start;
        $limit = $currentItem - $limit;
        $limit =  $limit < 0 ? 0 : $limit;

        while($currentItem >= $limit && $line = $reader->fetchOne($currentItem)) {
            $currentItem--;
            $backups[] = $this->normalizeRow($line);
        }

        return $backups;
    }

    public function getBackup(string $name): ?array
    {
        $reader = $this->getReader();
        $rowFinder = function($row) use ($name) {
            return $row[0] == $name;
        };
        $stmt = (new Statement())->where($rowFinder)->limit(1);
        $csvRow = $stmt->process($reader)->fetchOne();

        if($csvRow === null) {
            return null;
        }

        return $this->normalizeRow($csvRow);
    }
}
