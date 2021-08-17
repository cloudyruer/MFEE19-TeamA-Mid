<?php
include __DIR__. '/partials/init.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

if(! empty($sid)){
    $sql = "DELETE FROM `products` WHERE sid=$sid";
    $stmt = $pdo->query($sql);
}
// 從哪個頁面連過來的
// 不一定有資料
if(isset($_SERVER['HTTP_REFERER'])){
    header(("Location: ". $_SERVER['HTTP_REFERER']));
}else{
header(('Location: data_list.php'));
}




