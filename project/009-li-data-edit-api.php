<?php
include __DIR__. '/partials/init.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '資料欄位不足',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];

$output['error'] = '會跑到這裡嗎444';


//  練習: 避免直接拜訪表單時的錯誤訊息
// if(
// empty($_POST['name']) or
// empty($_POST['detail']) or
// empty($_POST['categoriesMain']) or
// empty($_POST['categoriesChild']) or
// empty($_POST['brands']) or
// empty($_POST['origin']) or
// empty($_POST['price']) or
// empty($_POST['sale']) or
// empty($_POST['launched'])
// ){
//     echo json_encode($output);
//     exit;
// }

$output['error'] = '會跑到這裡嗎1';



$sql = " UPDATE `products` 
SET 
`name`=?,
`detail`=?,
`categories_id`=?,
`categories_parents_id`=?, 
`brands_id`=?,
`origin`=?, 
`price`=?, 
`sale`=?,
`launched`=?
WHERE `sid`=?";


// 只要從用戶端!!!外面來要塞進資料庫的資料，一律用prepare
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'],
    $_POST['detail'],
    $_POST['categoriesMain'],
    $_POST['categoriesChild'],
    $_POST['brands'],
    $_POST['origin'],
    $_POST['price'],
    $_POST['sale'],
    $_POST['launched'],
    $_POST['sid']
]);

$sid = $pdo->lastInsertId();






$sqlStock = " UPDATE `stock` SET
`size`=?, `stock`=?  
WHERE `products_id`=?";

$stmtStock = $pdo->prepare($sqlStock);
$stmtStock->execute([    
    $_POST['size'],
    $_POST['stock'],
    $_POST['sid'],
]);




$output['rowCount'] = $stmt->rowCount(); 
// 修改的筆數

if($stmt->rowCount()==1){
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}
echo json_encode($output);
