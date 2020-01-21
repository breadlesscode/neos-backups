<?php
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

            if (is_dir($path)) {
                $this->copyDirectory($path, $tmpBackupPath);
            } else {
                copy($path, $tmpBackupPath);
            }
        }

        return true;
    }

    public function restore(): bool
    {
        $copyPaths = $this->config['paths'];

        foreach ($copyPaths as $folderName => $path) {
            $tmpBackupPath = Files::concatenatePaths([$this->getBackupStepPath(), $folderName]);

            if (is_dir($path)) {
                $this->copyDirectory($tmpBackupPath, $path);
            } else {
                copy($tmpBackupPath, $path);
            }
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

    protected function copyDirectory(string $source, string $dest)
    {
        $dir = opendir($source);
        mkdir($dest);

        while(false !== ($file = readdir($dir))) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $srcFile = $source.'/'.$file;
            $destFile = $dest.'/'.$file;

            if (is_dir($srcFile)) {
                $this->copyDirectory($srcFile, $destFile);
            } else {
                copy($srcFile, $destFile);
            }
        }

        closedir($dir);
    }
}
