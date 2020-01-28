# Backup Steps

* [File/Directory copy step](#file-directory-copy-step)
* [Site export step](#site-export-step)
* [MySql-Table export step](#mysql-table-export-step)


## File export step
This is a easy step to copy files and directories into the backup.

Example configuration:
```yaml
Breadlesscode:
  Backups:
    steps:
      'Breadlesscode\Backups\Step\CopyStep':
        paths:
          logs: '%FLOW_PATH_DATA%Logs'
```

## Site export step
This step uses the Neos CMS site export functionality to export sites and his resources 
into a XML-File.

Example configuration:
```yaml
Breadlesscode:
  Backups:
    steps:
      'Breadlesscode\Backups\Step\SiteExportStep': []
```

## MySql-Table export step

This step exports MySql-Tables via the `mysqldump`-Binary.

Example configuration:
```yaml
Breadlesscode:
  Backups:
    steps:
      'Breadlesscode\Backups\Step\MysqlTableExportStep':
        mysqlDumpBinPath: 'mysqldump'
        mysqlBinPath: 'mysql'
        tables:
          - neos_flow_security_account
```

## MySql-Database export step

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
