<?php
include __DIR__. '/partials/init.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if(! empty($id)){
    $sql = "DELETE FROM `Blog` WHERE id=$id";
    $stmt = $pdo->query($sql);
}

// $_SERVER['HTTP_REFERER'] 從哪個頁面連過來的
// 不一定有資料
if(isset($_SERVER['HTTP_REFERER'])){
    header("Location: ". $_SERVER['HTTP_REFERER']);
} else {
    header('Location: 001-emma-blog-list.php');
}


