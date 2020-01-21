<?php
namespace Breadlesscode\Backups\Generators;

interface BackupNameGeneratorInterface
{
    public function generate(): string;
}
