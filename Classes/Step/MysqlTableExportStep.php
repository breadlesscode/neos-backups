<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Step;

use Neos\Flow\Annotations as Flow;

class MysqlTableExportStep extends StepAbstract
{
    /**
     * Folder name in backup file
     *
     * @var string
     */
    protected $name = 'MySqlExport';

    /**
     * @Flow\InjectConfiguration(path="persistence.backendOptions", package="Neos.Flow")
     * @var array
     */
    protected $dbConfig;

    public function backup(): bool
    {
        $mysqlDumpPath = $this->config['mysqlDumpBinPath'] ?? 'mysqldump';
        $mysqlDumpOptions = $this->config['mysqlDumpOptions'] ?? [];
        $backupPath = $this->getBackupStepPath();

        foreach ($this->config['tables'] as $table) {
            $outputFileName = $backupPath.'/'.$table.'.sql';
            $command = vsprintf('%s -h %s -u %s -p%s %s %s %s 2>/dev/null 1> %s', [
                $mysqlDumpPath,
                escapeshellarg($this->dbConfig['host']),
                escapeshellarg($this->dbConfig['user']),
                escapeshellarg($this->dbConfig['password']),
                escapeshellarg($this->dbConfig['dbname']),
                $table,
                implode(' ', $mysqlDumpOptions),
                $outputFileName
            ]);
            exec($command);
        }

        return true;
    }

    public function restore(): bool
    {
        $mysqlPath = $this->config['mysqlBinPath'] ?? 'mysql';
        $backupPath = $this->getBackupStepPath();

        foreach ($this->config['tables'] as $table) {
            $tableSqlFile = $backupPath.'/'.$table.'.sql';
            // drop &  import table
            $command = vsprintf('%s -h %s -u %s -p%s %s 2>/dev/null < %s', [
                $mysqlPath,
                escapeshellarg($this->dbConfig['host']),
                escapeshellarg($this->dbConfig['user']),
                escapeshellarg($this->dbConfig['password']),
                escapeshellarg($this->dbConfig['dbname']),
                $tableSqlFile
            ]);
            exec($command);
        }

        return true;
    }

    public function getRestoreWarning(): ?string
    {
        $restoreWarning = 'The following tables will be dropped and recreated:'.PHP_EOL;

        foreach ($this->config['tables'] as $table) {
            $restoreWarning.= ' * '.$table.PHP_EOL;
        }

        return $restoreWarning;
    }
}
