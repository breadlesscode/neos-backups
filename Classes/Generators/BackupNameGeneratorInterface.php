<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Generators;

interface BackupNameGeneratorInterface
{
    public function generate(): string;
}
