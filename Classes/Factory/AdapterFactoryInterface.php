<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Factory;

use League\Flysystem\AdapterInterface;

interface AdapterFactoryInterface
{
    public function setConfig(array $config): void;
    public function get(): AdapterInterface;
    //public function validateConfig(): bool; maybe in the future
    public function getComposerDependencies(): array; // @todo validate this
}
