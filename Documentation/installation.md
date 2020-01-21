# Installation

You can easly add this package via composer. Check the requirements and run the command below.

**Requirements:**
- PHP <= 7.1
- Neos <= 4.0

Composer command:

```bash
composer require breadlesscode/neos-backups
```

## Setup configuration

First you have to choose a [filesystem](./filesystems.md) where you want to store the backups.
Than you have to configure all backup steps you want to use. 

Example Configuration:
```yaml
Breadlesscode:
  Backups:
    filesystem:
      type: 'local'
      path: '%FLOW_PATH_DATA%Persistent/Backups'
    steps: #{}
      'Breadlesscode\Backups\Step\SiteExportStep': []
      'Breadlesscode\Backups\Step\FileExportStep':
        paths:
          logs: '%FLOW_PATH_DATA%Logs'
      'Breadlesscode\Backups\Step\MysqlTableExportStep':
        tables:
          - neos_flow_security_account
```
