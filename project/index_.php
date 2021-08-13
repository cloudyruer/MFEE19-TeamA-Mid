<?php
include __DIR__ . '/partials/init.php';
$title = '我是首頁的title';
$activeLi = "";
?>
<?php include __DIR__ . '/partials/html-head.php';?>
<?php include __DIR__ . '/partials/navbar.php';?>
<div class="container mt-3">
    <h2>What’s new? Team A</h2>
    <!-- dropdown btn for test -->
    <div class="dropdown">
  <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    測 試 JS 是 否 有 連 結 成 功 (●'◡'●)
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">看起來</a>
    <a class="dropdown-item" href="#">似乎是...</a>
    <a class="dropdown-item" href="#">成功了呢 ಠ_ಠ </a>
  </div>
</div>

</div>
<?php include __DIR__ . '/partials/scripts.php';?>
<?php include __DIR__ . '/partials/html-foot.php';?>