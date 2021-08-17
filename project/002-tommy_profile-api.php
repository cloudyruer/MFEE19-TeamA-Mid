<?php
include __DIR__ . '/partials/init.php';

header('Content-Type: application/json');

// 要存放圖檔的資料夾
$folder = __DIR__ . '/imgs/';

// 允許的檔案類型
$imgTypes = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

$output = [
    'success' => false,
    'error' => '資料欄位不足',
    'code' => 0,
    'postData' => $_POST,
];

if (empty($_POST['nickname'])) {
    echo json_encode($output);
    exit;
}

// 比對密碼
// $sql2 = "SELECT * FROM `members` WHERE `password`=?";
// $stmt2 = $pdo->prepare($sql2);
// $stmt2->execute([
//     $_POST['password_o'],
// ]);
// $m = $stmt2->fetch();

// if(! password_verify($_POST['password_o'], $m['password'])){
//     $output['error'] = '密碼錯誤';
//     $output['code'] = 405;
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
   
//     $output['success'] = true;
//     $output['code'] = 200;
//     $_SESSION['user'] = $m;
// }
// 預設是沒有上傳資料，沒有上傳成功
$isSaved = false;

// 如果有上傳檔案
if (!empty($_FILES) and !empty($_FILES['avatar'])) {

    $ext = isset($imgTypes[$_FILES['avatar']['type']]) ? $imgTypes[$_FILES['avatar']['type']] : null; // 取得副檔名


//     $hash = '$2y$10$Uhr03aiKJ/qROq8LdoeM/OBDmnpWUhSe33Ru0viNuwmXK4BU6/ZLu';

// password_verify('slkdflkfk34', $hash)
//     $password = password_verify($_POST['password'], PASSWORD_DEFAULT);

    // 如果是允許的檔案類型
    if (!empty($ext)) {
        $filename = sha1($_FILES['avatar']['name'] . rand()) . $ext;

        if (move_uploaded_file(
            $_FILES['avatar']['tmp_name'],
            $folder . $filename
        )) {
            // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "UPDATE `members` SET 
            `password`=?, `email`=?, `avatar`=?,
            `mobile`=?, `address`=?, `birthday`=?, `nickname`=?

            WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                // $_POST['account'],
                $_POST['password'],
                $_POST['email'],
                $filename,
                $_POST['mobile'],
                $_POST['address'],
                $_POST['birthday'],
                $_POST['nickname'],


                $_SESSION['user']['id'],
            ]);

            if ($stmt->rowCount()) {
                $isSaved = true;

                $_SESSION['user']['avatar'] = $filename;
                $_SESSION['user']['nickname'] = $_POST['nickname'];

                $output['filename'] = $filename;
                $output['error'] = '';
                $output['success'] = true;

                echo json_encode($output);
                exit;
            }
        }
    }
}


if (!$isSaved) {
    $sql = "UPDATE `members` SET 
    `password`=?, `email`=?,
    `mobile`=?, `address`=?, `birthday`=?, `nickname`=?

    WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        // $_POST['account'],
        $_POST['password'],
        $_POST['email'],
        $_POST['mobile'],
        $_POST['address'],
        $_POST['birthday'],
        $_POST['nickname'],
        $_SESSION['user']['id'],
    ]);

    if ($stmt->rowCount()) {
        $_SESSION['user']['nickname'] = $_POST['nickname'];
        $output['error'] = '';
        $output['success'] = true;
    }
}


echo json_encode($output);
