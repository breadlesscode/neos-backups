<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Generators;

use Carbon\Carbon;

class BackupNameGenerator implements BackupNameGeneratorInterface
{
    public function generate(): string
    {
        $date = new Carbon();
        
        return 'Neos_CMS_Backup_'.$date->format('Y-m-d_H-i-s');
    }
}
