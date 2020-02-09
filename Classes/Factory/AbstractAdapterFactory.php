<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Factory;

abstract class AbstractAdapterFactory implements AdapterFactoryInterface
{
    protected $config;

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
