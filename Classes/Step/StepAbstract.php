<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Step;

use Neos\Utility\Files;

abstract class StepAbstract implements StepInterface
{
    /**
     * @var null|string
     */
    protected $name = null;

    /**
     * @var string
     */
    protected $backupPath;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string|null
     */
    protected $restoreWarning = null;

    public function __construct(string $backupPath, array $config)
    {
        $this->backupPath = $backupPath;
        $this->config = $config;
    }

    /**
     * simple getter for the step markdown warning message.
     * you can simply set the restoreWarning property or overwrite this getter
     */
    public function getRestoreWarning(): ?string
    {
        return $this->restoreWarning;
    }

    /**
     * return the save path for the backup step files
     */
    protected function getBackupStepPath(): string
    {
        if ($this->name ===  null) {
            $folderName = explode('\\', get_class($this));
            $folderName = end($folderName);
            $this->name = substr($folderName, 0, strpos($folderName, 'Step'));
        }

        $path = Files::concatenatePaths([$this->backupPath, $this->name]);
        Files::createDirectoryRecursively($path);

        return $path;
    }
}
