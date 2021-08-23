<?php
include __DIR__. '/partials/init.php';

header('Content-Type: application/json');

$lvnum = $_GET['lv'];
$jarray = array(); //使用array儲存結果，再以json_encode一次回傳
if ($lvnum != '') {
    //此query視table結構調整，基本上是第一層ID=第二層ID的概念
    $query = "SELECT * FROM `store` where `parents_id`= '$lvnum'";
    $result = $pdo->query($query)->fetchAll();
    foreach($result as $row) {
        $jarray[] = $row;
    }
} else {
    echo 0;
    return;
}
echo json_encode($jarray);
return;


?>