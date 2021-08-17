<?php
include __DIR__ . '/partials/init.php';
$title = '賽事類別';
$activeLi = 'leo';

// leo 程式
// 搜尋功能
//抓到用戶搜尋的關鍵字
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
if (empty($keyword)) {
    header('Location: 033-leo-sports-type.php');
    exit;
}

//用戶查看第幾頁，預設值為1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//每頁幾筆資料
$perpage = 5;

$howManyList = 0;
//算出總共總資料總共幾頁

$howManyList = $pdo->query("SELECT count(1) FROM sportsType  where `rank`>0 AND `name` LIKE '%$keyword%'")
    ->fetchAll(); //拿到總共幾筆資料的statement


$totalList = $howManyList[0]["count(1)"]; //拿到總共幾筆資料的值

//計算總共會需要多少頁面
$howManyPage = ceil($totalList / 5); //

//決定第幾頁要抓第幾筆至第幾筆
$rowLimitStart = ($page - 1) * $perpage; //每一頁第一筆

// 讓 $page 的值在安全的範圍，避免用戶點到第0頁，或是超過資料筆數的頁面
// if ($page < 1) {
//     header('Location: ?page=1');
//     exit;
// }
// if ($page > $howManyPage) {
//     header('Location: ?page=' . $howManyPage);
//     exit;
// }

$rows = $pdo->query("SELECT * FROM sportsType where `rank`>0 AND `name` LIKE '%$keyword%' LIMIT $rowLimitStart,$perpage")
    ->fetchAll();

$qs['keyword'] = $keyword;

?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<!-- leo css -->
<?php include __DIR__ . '/033-leo-css.php'; ?>
<!-- leo nav -->
<ul class="nav nav-tabs mt-4 pl-5 pr-5">
    <li class="nav-item">
        <a class="nav-link active" href="#">賽事類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">賽事</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">球場類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">球場</a>
    </li>
</ul>

<div id="container">
    <h1>賽事類別</h1>
    <div class="button_warp">

        <div class="button_warp_search">
            <form action="033-leo-sports-type-search.php">
                <input class="form-control" type="" placeholder="請輸入盃賽關鍵字" name="keyword" value="<?= htmlentities($keyword) ?>">
                <button type="submit" class="btn btn-secondary">搜尋</button>
                <a href="033-leo-sports-type.php" class="btn btn-outline-secondary">取消搜尋</a>

            </form>
        </div>

    </div>

    <table class="table table-striped">
        <thead class=" thead-dark">
            <tr>
                <th scope="col">盃賽名稱</th>
                <th scope="col">編輯</th>
                <th scope="col">刪除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td><?= $r['name'] ?></td>
                    <td><a class="btn btn-secondary" href="033-leo-sports-type-game-edit.php?sid=<?= $r['sid'] ?>">編輯</a></td>
                    <td><a href="033-leo-sports-type-deleteApi.php?sid=<?= $r['sid'] ?>" class="btn btn-danger">刪除</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>">
                    <i class="fas fa-arrow-circle-left"></i>
                </a>
            </li>
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) : //產生迴圈多少頁數，且每一網頁只能產生前後幾筆
                if ($i >= 1 and $i <= $howManyPage) : ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
            <?php endif;
            endfor; ?>
            <li class="page-item <?= $page >= $howManyPage ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>">
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>
<script>
    let noKeyWordAlert = <?= $totalList ?>;
    console.log(noKeyWordAlert);
    if (noKeyWordAlert == 0) {
        alert('您所輸入的關鍵字無資料，請重新輸入')
    }
</script>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<?php include __DIR__ . '/partials/html-foot.php'; ?>