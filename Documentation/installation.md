# Installation

You can easily add this package via composer. Check the requirements and run the command below.

**Requirements:**
- PHP <= 7.1
- Neos <= 4.0

Composer command:

```bash
composer require breadlesscode/neos-backups
```

## Setup configuration

First you have to choose a [file system](./filesystems.md) where you want to store the backups.
Then you have to configure which backup steps you want to use. 

Example configuration:
```yaml
Breadlesscode:
  Backups:
    filesystem:
      type: 'local'
      path: '%FLOW_PATH_DATA%Persistent/Backups'
    steps:
      'Breadlesscode\Backups\Step\SiteExportStep': []
      'Breadlesscode\Backups\Step\FileExportStep':
        paths:
          logs: '%FLOW_PATH_DATA%Logs'
      'Breadlesscode\Backups\Step\MysqlTableExportStep':
        tables:
          - neos_flow_security_account
```
