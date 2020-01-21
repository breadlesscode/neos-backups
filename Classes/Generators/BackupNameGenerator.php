<?php
namespace Breadlesscode\Backups\Generators;

use Carbon\Carbon;

class BackupNameGenerator implements BackupNameGeneratorInterface
{
    public function generate(): string
    {
        $date = new Carbon();
        $filename = 'Neos_CMS_Backup_';
        $filename.= $date->format('Y-m-d_H:i:s');
        $filename.= '__'.rand(10000, 99999);

        return $filename;
    }
}
