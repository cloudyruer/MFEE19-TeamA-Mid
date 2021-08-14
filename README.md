# Team A 期中專題

## Database:

### Database Connection Setting:

```php
<?php

$db_host = 'localhost';
$db_name = 'team_project';
$db_user = 'root';
$db_pass = '';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // 預設FETCH關聯式陣列
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
```

### Used Table Name:

| **Table Name** | **User**  |   **Desc**    |
| :------------: | :-------: | :-----------: |
|    members     | **Group** | members info  |
|    geo_info    |   Joey    |   geo info    |
|   emma_table   |   Emma    | emma's table  |
|   leo_table    |    Leo    |  leo's table  |
|  henry_table   |   Henry   | henry's table |

## members(table) - Structure:

### members.id

- primary key
- auto_increment

### members.account

- unique

### members.password

- 各自的座號 (before hash)
