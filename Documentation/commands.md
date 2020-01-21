# Commands

### `backup:list`

Lists backups available.

```bash
./flow backup:list
```

#### Options
`--offset`  <br />
The index where this command should start listing

`--limit` <br />
The number of backups shown


### `backup:create`

Creates a single backup.

```bash
./flow backup:create 
```


### `backup:restore`

Restores a single backup.

```bash
./flow backup:restore <name>
```

#### Options
`--no-confirm` <br />
If this flag is set, you dont have to confirm this action by pressing `Y` + `Return`.


### `backup:delete`

Deletes a single backup.

```bash
./flow backup:delete <name>
```

#### Options
`--no-confirm` <br />
If this flag is set, you dont have to confirm this action by pressing `Y` + `Return`. 
