<?php
include __DIR__ . '/partials/init.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$output = [
    'success' => false,
    'error' => '沒有給 id',
    'id' => $id,
];

if(! empty($id)){
    $sql = "DELETE FROM `members` WHERE id=$id";
    $stmt = $pdo->query($sql);

    if($stmt->rowCount()==1){
        $output['success'] = true;
        $output['error'] = '';
    } else {
        $output['error'] = '沒有刪除成功（可能沒有該筆資料）';
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);

