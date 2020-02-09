<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Factory;

use League\Flysystem\AdapterInterface;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class AwsS3AdapterFactory extends AbstractAdapterFactory
{
    public function get(): AdapterInterface
    {
        $client = new S3Client([
            'credentials' => [
                'key'    => $this->config['credentials']['key'],
                'secret' => $this->config['credentials']['secret'],
            ],
            'region' => $this->config['region'],
            'version' => 'latest',
        ]);

        return new AwsS3Adapter($client, $this->config['bucketName']);
    }

    public function getComposerDependencies(): array
    {
        return [
            'league/flysystem-aws-s3-v3'
        ];
    }
}
