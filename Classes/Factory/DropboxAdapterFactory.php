<?php
namespace Breadlesscode\Backups\Factory;

use League\Flysystem\AdapterInterface;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxAdapterFactory extends AbstractAdapterFactory
{
    public function get(): AdapterInterface
    {
        $client = new Client($this->config['authorizationToken']);

        return new DropboxAdapter($client);
    }

    public function getComposerDependencies(): array
    {
        return [
            'spatie/flysystem-dropbox'
        ];
    }
}
