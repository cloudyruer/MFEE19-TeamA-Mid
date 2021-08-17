# Team A 期中專題 (上次總整合: 0817)

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

### Table Ref:

| **Table Name**  | **User**  |    **Desc**     |
| :-------------: | :-------: | :-------------: |
|     members     | **Group** |  members info   |
|    geo_info     |   Joey    | geo info (Joey) |
|      blog       |   Emma    |  Emma's table   |
|   sportsGame    |    Leo    |   leo's table   |
|   sportsType    |    Leo    |   leo's table   |
|     stadium     |    Leo    |   leo's table   |
|   stadiumType   |    Leo    |   leo's table   |
|     brands      |    Li     |   Li's table    |
|   categories    |    Li     |   Li's table    |
|     images      |    Li     |   Li's table    |
|    products     |    Li     |   Li's table    |
|      stock      |    Li     |   Li's table    |
| account_address |   Tommy   |  Tommy's table  |
| account_ranking |   Tommy   |  Tommy's table  |
|     orders      |   Tommy   |  Tommy's table  |
| `orders_detail` |   Tommy   |  Tommy's table  |
| `order_details` |   Henry   |  henry's table  |
|   order_list    |   Henry   |  henry's table  |
|  product_list   |   Henry   |  henry's table  |
|  product_spec   |   Henry   |  henry's table  |

## members(table) - Structure:

### members.id

- primary key
- auto_increment

### members.account

- unique

### members.password

- 各自的座號 (before hash)
