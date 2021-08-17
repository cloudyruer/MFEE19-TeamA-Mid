<?php
include __DIR__ . '/partials/init.php';

header('Content-Type: application/json');

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
    'rowCount' => 0,
    'postData' => $_POST,
];


// 資料格式檢查
// if (mb_strlen($_POST['account']) < 2) {
//     $output['error'] = '姓名長度太短';
//     $output['code'] = 410;
//     echo json_encode($output);
//     exit;
// }

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $output['error'] = 'email 格式錯誤';
    $output['code'] = 420;
    echo json_encode($output);
    exit;
}

if (empty($_POST['nickname'])) {
    echo json_encode($output);
    exit;
}

$isSaved = false;

// 如果有上傳檔案
if (!empty($_FILES) and !empty($_FILES['avatar'])) {

    $ext = isset($imgTypes[$_FILES['avatar']['type']]) ? $imgTypes[$_FILES['avatar']['type']] : null; // 取得副檔名



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
                $_POST['id'],
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
        $_POST['id'],
    ]);

    if ($stmt->rowCount()) {
        $_SESSION['user']['nickname'] = $_POST['nickname'];
        $output['error'] = '';
        $output['success'] = true;
    }
}



echo json_encode($output);
