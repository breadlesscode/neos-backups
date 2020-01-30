<?php

namespace Breadlesscode\Backups\Step;

use Neos\Flow\Annotations as Flow;

class MysqlDatabaseExportStep extends StepAbstract
{
    /**
     * Folder name in backup file
     *
     * @var string
     */
    protected $name = 'MySqlDatabaseExport';

    /**
     * @Flow\InjectConfiguration(path="persistence.backendOptions", package="Neos.Flow")
     * @var array
     */
    protected $dbConfig;

    public function backup(): bool
    {
        $mysqlDumpPath = $this->config['mysqlDumpBinPath'] ?? 'mysqldump';
        $mysqlDumpOptions = $this->config['mysqlDumpOptions'] ?? [];

        $command = vsprintf('%s -h %s -u %s -p%s %s %s 2>/dev/null 1> %s', [
            $mysqlDumpPath,
            escapeshellarg($this->dbConfig['host']),
            escapeshellarg($this->dbConfig['user']),
            escapeshellarg($this->dbConfig['password']),
            escapeshellarg($this->dbConfig['dbname']),
            implode(' ', $mysqlDumpOptions),
            $this->getFilenameForBackup()
        ]);

        exec($command);

        return true;
    }

    public function restore(): bool
    {
        $mysqlPath = $this->config['mysqlBinPath'] ?? 'mysql';

        $command = vsprintf('%s -h %s -u %s -p%s %s 2>/dev/null < %s', [
            $mysqlPath,
            escapeshellarg($this->dbConfig['host']),
            escapeshellarg($this->dbConfig['user']),
            escapeshellarg($this->dbConfig['password']),
            escapeshellarg($this->dbConfig['dbname']),
            $this->getFilenameForBackup()
        ]);

        exec($command);

        return true;
    }

    public function getRestoreWarning(): ?string
    {
        return 'The database "' . $this->dbConfig['dbname'] . '" will be overwritten:' . PHP_EOL;
    }

    protected function getFilenameForBackup(): string
    {
        $backupPath = $this->getBackupStepPath();
        return $backupPath . '/' . $this->dbConfig['dbname'] . '.sql';
    }
}
