<?php
include __DIR__ . '/partials/init.php';

$sql = "SELECT * FROM `stadiumType` ORDER BY `rank`";
$rows = $pdo->query($sql)->fetchAll();

$cate1 = [];
foreach ($rows as $r) {
    if ($r['rank'] == 0) {
        $cate1[] = $r;
    }
}


// 設定第二層
foreach ($cate1 as &$c) {
    foreach ($rows as $r) {
        if ($r['rank'] == $c['sid']) {
            $c['nodes'][] = $r;
        }
    }
}



echo json_encode($cate1, JSON_UNESCAPED_UNICODE);
