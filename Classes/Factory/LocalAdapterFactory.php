<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Factory;

use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use Neos\Flow\Annotations as Flow;

class LocalAdapterFactory extends AbstractAdapterFactory
{
    public function get(): AdapterInterface
    {
        return new Local($this->config['path']);
    }

    public function getComposerDependencies(): array
    {
        return [];
    }
}
