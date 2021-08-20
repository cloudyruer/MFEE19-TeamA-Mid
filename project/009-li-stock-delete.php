<?php
include __DIR__. '/partials/init.php';


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


if(! empty($id)){
    $sqlStock = "DELETE FROM `stock` WHERE `stock`.`id` = $id";
    $stmtStock = $pdo->query($sqlStock);
   
}
// 從哪個頁面連過來的
// 不一定有資料
if(isset($_SERVER['HTTP_REFERER'])){
    header(("Location: ". $_SERVER['HTTP_REFERER']));
}else{
header(('Location: data_list.php'));
}




