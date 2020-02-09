<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Factory;

use League\Flysystem\AdapterInterface;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

class AzureBlobAdapterFactory extends AbstractAdapterFactory
{
    public function get(): AdapterInterface
    {
        $connectionStr = 'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s;';
        $client = BlobRestProxy::createBlobService(vsprintf($connectionStr, [
            $this->config['account']['name'],
            $this->config['account']['key'],
        ]));

        return new AzureBlobStorageAdapter($client, $this->config['containerName']);
    }

    public function getComposerDependencies(): array
    {
        return [
            'league/flysystem-azure-blob-storage'
        ];
    }
}
