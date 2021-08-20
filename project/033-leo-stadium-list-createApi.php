<?php
include __DIR__ . '/partials/init.php';

header('Content-Type: application/json');

//處理圖片檔案
// 上傳後的檔案要放在哪裡
$folder = __DIR__ . '/imgs/';
// 如果有上傳檔案
if (!empty($_FILES)) {
    if (move_uploaded_file(
        $_FILES['stadium_list_photo']['tmp_name'],
        $folder . $_FILES['stadium_list_photo']['name']
    )) {
    } else {
        $output['success'] = false;
        $output['error'] = '上傳不成功';
    }
}

//先設定回傳的狀態，預設為出錯
$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];


//回寫至資料庫的資料格式
$sql = "INSERT INTO `stadium`(
              `gymName`,`city`,`area`,`address`,`gymKind`,`inAndout`, `lat`, `lng`, `photo`, `phone`
               ) VALUES (
                    ?, ?,?,?,?,?, ?,?,?,?
               )";
//用prepare先將資料轉換為資料庫可用格式
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['stadium_list_name'],
    $_POST['city_sel'],
    $_POST['area_sel'],
    $_POST['stadium_list_address'],
    $_POST['stadium_list_kind'],
    $_POST['stadium_list_inAndOut'],
    $_POST['stadium_list_lat'],
    $_POST['stadium_list_lng'],
    "./imgs/" . $_FILES['stadium_list_photo']['name'],
    $_POST['stadium_list_phone']
]);

//回傳給前端的值
$output['rowCount'] = $stmt->rowCount(); // 新增的筆數
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
}
//回傳給前端
echo json_encode($output);
