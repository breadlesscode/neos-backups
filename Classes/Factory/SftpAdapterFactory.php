<?php
namespace Breadlesscode\Backups\Factory;

use League\Flysystem\AdapterInterface;
use League\Flysystem\Sftp\SftpAdapter;

class SftpAdapterFactory extends AbstractAdapterFactory
{
    public function get(): AdapterInterface
    {

        return new SftpAdapter($this->config);
    }

    public function getComposerDependencies(): array
    {
        return [
            'league/flysystem-sftp'
        ];
    }
}
