<?php
include __DIR__ . '/partials/init.php';
$title = '球場列表';
$activeLi = 'leo';

// leo 程式
// 搜尋功能 TODO:
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
if (!empty($keyword)) {
    header('Location: 033-leo-sports-game-search.php?keyword=' . $keyword);
    exit;
}


// 抓出本頁資料
//決定查看賽別，預設值為0
$sportsCat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

//所有的球場類別
$allSprtsCat = $pdo->query("SELECT * FROM stadiumType where `stadiumType`.`rank`=0")
    ->fetchAll();

//用戶查看第幾頁，預設值為1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//每頁幾筆資料
$perpage = 5;

$howManyList = 0;
//算出總共總資料總共幾頁
if ($sportsCat == 0) {
    //全部的資料
    $howManyList = $pdo->query(" SELECT count(1) FROM `stadium`")
        ->fetchAll(); //拿到總共幾筆資料的statement
} elseif ($sportsCat > 0) {
    //該賽別的資料
    $howManyList = $pdo->query("SELECT count(1),`stadium`.*, `stadiumType`.`name`, `stadiumType`.`rank`FROM `stadium` JOIN `stadiumType` ON `stadium`.`gymKind` = `stadiumType`.`sid` where `rank`=$sportsCat")
        ->fetchAll(); //拿到總共幾筆資料的statement
}

$totalList = $howManyList[0]["count(1)"]; //拿到總共幾筆資料的值

//計算總共會需要多少頁面
$howManyPage = ceil($totalList / 5); //

//決定第幾頁要抓第幾筆至第幾筆
$rowLimitStart = ($page - 1) * $perpage; //每一頁第一筆

// 讓 $page 的值在安全的範圍，避免用戶點到第0頁，或是超過資料筆數的頁面
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
if ($page > $howManyPage) {
    header('Location: ?page=' . $howManyPage);
    exit;
}

//取出資料庫中的資料
if ($sportsCat == 0) {
    //全部的資料
    $rows = $pdo->query("SELECT `stadium`.*, `stadiumType`.`name` FROM `stadium` JOIN `stadiumType` ON `stadium`.`gymKind` = `stadiumType`.`sid`
    LIMIT $rowLimitStart,$perpage;")
        ->fetchAll();
} elseif ($sportsCat > 0) {
    //該賽別的資料

    $rows = $pdo->query("SELECT `stadium`.*, `stadiumType`.`name`, `stadiumType`.`rank`FROM `stadium` JOIN `stadiumType` ON `stadium`.`gymKind` = `stadiumType`.`sid` where `rank`=$sportsCat LIMIT $rowLimitStart,$perpage")
        ->fetchAll();
}


?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<!-- leo css -->
<?php include __DIR__ . '/033-leo-css.php'; ?>
<!-- leo nav -->
<ul class="nav nav-tabs mt-4 pl-5 pr-5">
    <li class="nav-item">
        <a class="nav-link " href="./033-leo-sports-type.php">賽事類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="./033-leo-sports-game.php">賽事</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="./033-leo-stadium-type.php">球場類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="./033-leo-stadium-list.php">球場</a>
    </li>
</ul>


<div id="container">
    <h1>球場列表</h1>
    <div class="button_warp">
        <div>
            <a class="btn btn-primary" href="./033-leo-stadium-list-create.php">新增球場</a>
        </div>
        <div class="button_warp_search">
            <form>
                <input class="form-control" type="" placeholder="請輸入球場關鍵字" name="keyword">
                <button type="submit" class="btn btn-secondary">搜尋</button>
            </form>
        </div>
    </div>
    <div class="typeWarp">
        <nav class="nav nav-pills">
            <a class="nav-link" id="type0" href="?cat=0&page=1">全部</a>
            <?php foreach ($allSprtsCat as $r) : ?>
                <a class="nav-link" id="type<?= $r['sid'] ?>" href="?cat=<?= $r['sid'] ?>&page=1"><?= $r['name'] ?></a>
            <?php endforeach; ?>
        </nav>
    </div>
    <table class="table table-striped">
        <thead class=" thead-dark">
            <tr>
                <th scope="col">場館名稱</th>
                <th scope="col">設施類型</th>
                <th scope="col">地址</th>
                <th scope="col">編輯</th>
                <th scope="col">刪除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td class="info<?= $r['sid'] ?>"><?= $r['gymName'] ?></td>
                    <td class="info<?= $r['sid'] ?> "><?= $r['name'] ?></td>
                    <td class="info<?= $r['sid'] ?> "><?= $r['city'] . " " . $r['area'] . " " . $r['address'] ?></td>
                    <td><a class="btn btn-info" href="033-leo-stadium-list-edit.php?sid=<?= $r['sid'] ?>">編輯</a></td>
                    <td><a href="033-leo-stadium-list-deleteApi.php?sid=<?= $r['sid'] ?>" class="btn btn-danger">刪除</a></td>
                </tr>
                <tr class="infoHidden" id="info<?= $r['sid'] ?>">
                    <td colspan="7">
                        <div>室內外：<?= $r['inAndout'] ?></div>
                        <div>電話：<?= $r['phone'] ?></div>
                        <div>照片：</div>
                        <div><img src="<?= $r['photo'] ?>" alt=""></div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&cat=<?= $sportsCat ?>">
                    <i class="fas fa-arrow-circle-left"></i>
                </a>
            </li>
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) : //產生迴圈多少頁數，且每一網頁只能產生前後幾筆
                if ($i >= 1 and $i <= $howManyPage) : ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&cat=<?= $sportsCat ?>"><?= $i ?></a>
                    </li>
            <?php endif;
            endfor; ?>
            <li class="page-item <?= $page >= $howManyPage ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&cat=<?= $sportsCat ?>">
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<script>
    //決定哪個賽別要加上active
    var pageCat = <?php echo $sportsCat ?>;
    var whichNeedActive = document.getElementById("type" + pageCat)
    whichNeedActive.classList += " active"

    $("td").click(function() {
        let openTarget = "#" + this.className
        if (openTarget.includes("info")) {
            console.log(openTarget);
            $(openTarget).toggle();
        }
    });
</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>