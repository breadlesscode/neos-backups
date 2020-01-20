# Custom behaviours

You have the possibility to create your own step, name generator and compressor.

- [Custom step](#custom-step)
- [Custom name generator](#custom-name-generator)
- [Custom compressor](#custom-compressor)

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
     * if a this property is not sufficient,
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

```php
<?php
namespace My\Vendor\Compressor;

class MyCompressor extends AbstractCompressor
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
