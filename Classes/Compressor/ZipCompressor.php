<?php
namespace Breadlesscode\Backups\Compressor;

use Neos\Utility\Files;

class ZipCompressor extends AbstractCompressor
{
    public function compress(string $source, string $targetFolder): ?string
    {
        $archive = new \ZipArchive();
        $archivePath = $targetFolder.'/'.$this->generateFilename(basename($source));
        $archive->open($archivePath, \ZipArchive::CREATE);

        $filesIterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($filesIterator as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($source) + 1);

                $archive->addFile($filePath, $relativePath);
            }
        }

        return $archive->close() ? $archivePath : null;
    }

    public function decompress(string $source, string $targetFolder): ?string
    {
        $zip = new \ZipArchive();
        $success = $zip->open($source);

        if ($success === false) {
            return null;
        }

        Files::createDirectoryRecursively($targetFolder);
        $success = $zip->extractTo($targetFolder);
        $zip->close();

        return $success ? $targetFolder : null;
    }

    public function generateFilename($name): string
    {
        return $name.'.zip';
    }
}
