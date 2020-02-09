<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Step;

use Neos\Utility\Files;

class FileExportStep extends StepAbstract
{
    /**
     * Folder name in backup file
     *
     * @var string
     */
    protected $name = 'FileExport';

    public function backup(): bool
    {
        $copyPaths = $this->config['paths'];

        foreach ($copyPaths as $folderName => $path) {
            $tmpBackupPath = Files::concatenatePaths([$this->getBackupStepPath(), $folderName]);

            Files::copyDirectoryRecursively($path, $tmpBackupPath);
        }

        return true;
    }

    public function restore(): bool
    {
        $copyPaths = $this->config['paths'];

        foreach ($copyPaths as $folderName => $path) {
            $tmpBackupPath = Files::concatenatePaths([$this->getBackupStepPath(), $folderName]);

            Files::removeDirectoryRecursively($path);
            Files::createDirectoryRecursively($path);
            Files::copyDirectoryRecursively($tmpBackupPath, $path);
        }

        return true;
    }

    /**
     * @return string|null
     */
    public function getRestoreWarning(): ?string
    {
        $restoreWarning = 'The following paths will be removed and new files will be copied:';
        $restoreWarning.= PHP_EOL;

        foreach ($this->config['paths'] as $path) {
            $restoreWarning.= ' * '.$path.PHP_EOL;
        }

        return $restoreWarning;
    }
}
