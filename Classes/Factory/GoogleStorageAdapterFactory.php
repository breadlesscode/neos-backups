<?php
namespace Breadlesscode\Backups\Factory;

use League\Flysystem\AdapterInterface;
use Google\Cloud\Storage\StorageClient;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;


class GoogleStorageAdapterFactory extends AbstractAdapterFactory
{
    public function get(): AdapterInterface
    {
        $storageClient = new StorageClient([
            'projectId' => $this->config['projectId']
        ]);
        $bucket = $storageClient->bucket($this->config['bucketName']);

        return new GoogleStorageAdapter($storageClient, $bucket);
    }

    public function getComposerDependencies(): array
    {
        return [
            'superbalist/flysystem-google-storage'
        ];
    }
}
