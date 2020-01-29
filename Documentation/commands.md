# Commands

## `backup:list`

Lists all available backups.

```bash
./flow backup:list
```

#### Options
`--offset`  <br />
The index where this command should start listing

`--limit` <br />
The number of backups to show


## `backup:create`

Creates a single backup.

```bash
./flow backup:create 
```


## `backup:restore`

Restores a single backup by name.

```bash
./flow backup:restore <name>
```

#### Options
`--no-confirm` <br />
If this flag is set, you don't have to confirm this action by pressing <kbd>Y</kbd> + <kbd>Return</kbd>.


## `backup:delete`

Deletes a single backup by name.

```bash
./flow backup:delete <name>
```

#### Options
`--no-confirm` <br />
If this flag is set, you don't have to confirm this action by pressing <kbd>Y</kbd> + <kbd>Return</kbd>. 



## `backup:prune`

Deletes all current backups.

```bash
./flow backup:prune
```

#### Options
`--no-confirm` <br />
If this flag is set, you don't have to confirm this action by pressing <kbd>Y</kbd> + <kbd>Return</kbd>. 

`--keep x` <br />
Keeps the latest x backups
