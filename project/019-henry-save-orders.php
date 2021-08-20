<?php
require __DIR__ . '/partials/init.php';

$pKeys = array_keys($_SESSION['cart']);

$rows = []; // 預設值
$data_ar = []; // dict

// 有登入才能結帳
if(! isset($_SESSION['user'])){
    header('Location: 019-henry-product-list.php');
    exit;
}

if(!empty($pKeys)) {
    $sql = sprintf("SELECT * FROM product_list WHERE sid IN(%s)", implode(',', $pKeys));
    $rows = $pdo->query($sql)->fetchAll();
    $total = 0;
    foreach($rows as $r){
        $r['quantity'] = $_SESSION['cart'][$r['sid']];
        $data_ar[$r['sid']] = $r;
        $total += $r['quantity'] * $r['product_price'];
    }
} else {
    header('Location: 019-henry-product-list.php');
    exit;
}

$o_sql = "INSERT INTO `order_list`(`user_id`, `grand_total`,`order_status`,`user_name`,`user_phone`,`user_email`,`pickup_store`,`pickup_way`,`user_address`,`created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,NOW())";
$o_stmt = $pdo->prepare($o_sql);
$o_stmt->execute([
    $_SESSION['user']['id'], $_POST['total'], $_POST['order_status'], $_POST['name'], $_POST['mobile'], $_POST['email'], $_POST['pickup_store'], $_POST['pickup_way'], $_POST['address']
]);

$order_sid = $pdo->lastInsertId(); // 最近新增資料的 PK

$od_sql = "INSERT INTO `order_details`(`order_id`, `user_id`, `user_name`, `product_id`,`unit_price`,`quantity`,`shipping`,`discount`,`total_price`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$od_stmt = $pdo->prepare($od_sql);

foreach($_SESSION['cart'] as $p_sid=>$qty){
    $od_stmt->execute([
        $order_sid,
        $p_sid,
        $data_ar[$p_sid]['price'],
        $qty,
        //TODO:還要補齊對應欄位
    ]);
}

unset($_SESSION['cart']); // 清除購物車內容

?>
<?php include __DIR__ . '/partials/html-head.php';?>
<?php include __DIR__ . '/partials/navbar.php';?>


<?php include __DIR__ . "/019-henry-scripts.php"; ?>

<?php include __DIR__ . '/partials/html-foot.php'; ?>