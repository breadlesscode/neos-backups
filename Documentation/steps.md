# Backup steps

* [File/Directory copy step](#file-directory-copy-step)
* [Site export step](#site-export-step)
* [MySQL table export step](#mysql-table-export-step)
* [MySQL database export step](#mysql-database-export-step)


## File export step
This is an easy step to copy files and directories into the backup.

Example configuration:
```yaml
Breadlesscode:
  Backups:
    steps:
      'Breadlesscode\Backups\Step\FileExportStep':
        paths:
          logs: '%FLOW_PATH_DATA%Logs'
```

## Site export step
This step uses the Neos CMS site export functionality to export sites and its resources 
into an XML-File.

Example configuration:
```yaml
Breadlesscode:
  Backups:
    steps:
      'Breadlesscode\Backups\Step\SiteExportStep': []
```

## MySQL table export step

This step exports MySQL tables via the `mysqldump` binary.

Example configuration:
```yaml
Breadlesscode:
  Backups:
    steps:
      'Breadlesscode\Backups\Step\MysqlTableExportStep':
        mysqlDumpBinPath: 'mysqldump' # default value
        mysqlBinPath: 'mysql' # default value
        tables:
          - neos_flow_security_account
        mysqlDumpOptions:
          - --single-transaction
          - --skip-extended-insert
```

## MySQL database export step

This step exports a whole MySql-Database via the `mysqldump`-Binary.

Example configuration:
```yaml
Breadlesscode:
  Backups:
    steps:
      'Breadlesscode\Backups\Step\MysqlDatabaseExportStep':
        mysqlDumpBinPath: 'mysqldump'
        mysqlBinPath: 'mysql'
        mysqlDumpOptions:
          - --single-transaction
          - --skip-extended-insert
```
