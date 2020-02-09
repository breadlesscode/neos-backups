# File systems

This package provides the following file system adapters by default:

* [Local](#local)
* [SFTP](#sftp)
* [AWS-S3](#aws-s3)
* [Azure Blob](#azure-blob)
* [Dropbox](#dropbox)
* [Google Storage](#google-storage)

::: tip
This plugin uses the `league/flysystem` package under the hood. 
:::

## Local

Example configuration:
```yaml
Breadlesscode:
  Backups:
    filesystem:
      type: 'local'
      path: '%FLOW_PATH_DATA%Persistent/Backups'
```

## SFTP

Required composer dependencies:

- `league/flysystem-sftp`

Example configuration:
```yaml
Breadlesscode:
  Backups:
    filesystem:
      type: 'sftp'
      host: 'example.com'
      port: 22
      username: 'username'
      password: 'password'
      privateKey: 'path/to/or/contents/of/privatekey'
      passphrase: 'passphrase-for-privateKey'
      root: '/path/to/root'
      timeout: 10
      directoryPerm: 0755
```
## AWS-S3

Required composer dependencies:

- `league/flysystem-aws-s3-v3`

Example configuration:
```yaml
Breadlesscode:
  Backups:
    filesystem:
      type: 'aws-s3'
      region: ''
      bucketName: ''
      credentials:
        key: ''
        secret: ''
```
## Azure Blob

Required composer dependencies:

- `league/flysystem-azure-blob-storage`

Example configuration:
```yaml
Breadlesscode:
  Backups:
    filesystem:
      type: 'azure'
      containerName: ''
      account:
        key: ''
        name: ''
```
## Dropbox

Required composer dependencies:

- `spatie/flysystem-dropbox`

Example configuration:
```yaml
Breadlesscode:
  Backups:
    filesystem:
      type: 'dropbox'
      authorizationToken: ''
```
## Google Storage

Required composer dependencies:

- `superbalist/flysystem-google-storage`

Example configuration:
```yaml
Breadlesscode:
  Backups:
    filesystem:
      type: 'google-storage'
      projectId: ''
      bucketName: ''
```
