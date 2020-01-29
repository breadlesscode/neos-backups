# Custom behaviors

You have the possibility to create your own step, name generator and compressor.

- [Custom step example](#custom-step)
- [Custom name generator example](#custom-name-generator)
- [Custom compressor example](#custom-compressor)

## Custom step

```php
<?php
namespace My\Vendor\Step;

use Breadlesscode\Backups\Step\StepAbstract;

class MyCustomExportStep extends StepAbstract
{
    /**
     * Folder name in backup file
     *
     * @var string
     */
    protected $name = 'MySqlExport';

    /**
     * your restore warning markdown string
     * if this property is not sufficient,
     * you can override the getRestoreWarning() method
     * 
     * @var string 
     */
    protected $restoreWarning = 'My custom warning';

    /**
     * @inheritDoc
     */
    public function backup(): bool
    {
        // your backup code here
        return true;
    }

    /**
     * @inheritDoc
     */
    public function restore(): bool
    {
        // your restore code here
        return true;
    }
}
```

Settings.yaml
```yaml
Breadlesscode:
  Backups:
    steps:
      'My\Vendor\Step\MyCustomExportStep':
        my: config
```

## Custom name generator
BackupNameGenerator.php
```php
<?php
namespace My\Vendor\Generators;

class BackupNameGenerator implements BackupNameGeneratorInterface
{
    public function generate(): string
    {
        return (new \DateTime())->format('Y-m-d_H:i:s');
    }
}
```

Objects.yaml
```yaml
Breadlesscode\Backups\Generators\BackupNameGeneratorInterface:
  className: 'My\Vendor\BackupNameGenerator'
```

## Custom compressor

MyCustomCompressor.php

```php
<?php
namespace My\Vendor\Compressor;

class MyCustomCompressor extends AbstractCompressor
{
    public function compress(string $source, string $targetFolder): ?string
    {
        // do your backup compressing
        return $archivePath;
    }

    public function decompress(string $source, string $targetFolder): ?string
    {
        // do your backup decompressing
        return $targetFolder;
    }

    public function generateFilename($name): string
    {
        return $name.'.tar.xyz';
    }
}
```

Settings.yaml
```yaml
Breadlesscode:
  Backups:
    compressor: My\Vendor\Compressor\MyCustomCompressor
```
