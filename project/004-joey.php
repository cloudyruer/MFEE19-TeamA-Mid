<?php
include __DIR__ . '/partials/init.php';
$title = '活動';
$activeLi = 'joey';

// 若無登入 則返回登入葉面
if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}
?>
<?php include __DIR__ . '/partials/html-head.php';?>
<?php include __DIR__ . '/partials/navbar.php';?>
<div class="container mt-5">
<div class="jumbotron">
    <!-- NOTE php -->
  <h1 class="display-4">Hello <?=$_SESSION['user']['nickname']?></h1>
  <p class="lead">點選按鈕創建或加入隊伍👌</p>
  <hr class="my-4">
  <p>我不知道還可以打甚麼 但這裡有一條線 所以我盡量勉為其難放一些東西</p>
  <div class="d-flex justify-content-center">
    <a class="btn btn-primary btn-lg mr-5" href="./004-joey-create.php" role="button">創立組隊😎</a>
    <a class="btn btn-warning btn-lg mx-5" href="./004-joey-join.php" role="button">快速加入😆</a>
    <a class="btn btn-secondary btn-lg ml-5" href="./004-joey-datalist.php" role="button">編輯活動😁</a>
  </div>
</div>
</div>
<?php include __DIR__ . '/partials/scripts.php';?>
<?php include __DIR__ . '/partials/html-foot.php';?>