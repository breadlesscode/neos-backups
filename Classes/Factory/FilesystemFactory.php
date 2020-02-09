<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Factory;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Exception;
use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use Neos\Utility\Arrays;

/**
 * @Flow\Scope(value="singleton")
 */
class FilesystemFactory
{
    /**
     * @Flow\InjectConfiguration()
     * @var array
     */
    protected $config = [];

    public function get($adapterName)
    {
        $adapterFactoryClass = Arrays::getValueByPath($this->config, 'adapterFactories.'.strtolower($adapterName));

        if ($adapterFactoryClass ===  null) {
            throw new Exception('No adapter factory registered for adapter '.$adapterName.'.');
        }

        $adapterConfig = Arrays::getValueByPath($this->config, 'filesystem') ?? [];
        $factory = new $adapterFactoryClass();
        $factory->setConfig($adapterConfig);
        $adapter = $factory->get();

        return new Filesystem($adapter);
    }
}
