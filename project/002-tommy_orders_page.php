<?php
include __DIR__ . '/partials/init.php';
$title = '資料列表';
$activeLi = 'tommy';

// 固定每一頁最多幾筆


if (!isset($_SESSION['user'])) {
    header('Location: index_.php');
    exit;
}

$sql = "SELECT * FROM `members` WHERE id=" . intval($_SESSION['user']['id']);

$r = $pdo->query($sql)->fetch();

$sql2 = "SELECT `account_ranking`.*, `members`.*
FROM `account_ranking`
JOIN `members`
ON `account_ranking`.`members_id` = `members`.`id` WHERE `members`.id =". intval($_SESSION['user']['id']);


// $sql2 = "SELECT * FROM `account_ranking` WHERE id=" . intval($_SESSION['user']['id']);

$m = $pdo->query($sql2)->fetch();

if (empty($r)) {
    header('Location: index_.php');
    exit;
}
$perPage = 5;

// query string parameters
$qs = [];

// 關鍵字查詢
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// 用戶決定查看第幾頁，預設值為 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$where = ' WHERE 1 ';
if (!empty($keyword)) {
    // $where .= " AND `name` LIKE '%{$keyword}%' "; // sql injection 漏洞
    $where .= sprintf(" AND `account` LIKE %s ", $pdo->quote('%' . $keyword . '%'));

    $qs['keyword'] = $keyword;
}


// 總共有幾筆
$totalRows = $pdo->query("SELECT count(1) FROM members $where ")
    ->fetch(PDO::FETCH_NUM)[0];
// 總共有幾頁, 才能生出分頁按鈕
$totalPages = ceil($totalRows / $perPage); // 正數是無條件進位

$rows = [];
// 要有資料才能讀取該頁的資料
if ($totalRows != 0) {


    // 讓 $page 的值在安全的範圍
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf(
        "SELECT * FROM members %s ORDER BY id DESC LIMIT %s, %s",
        $where,
        ($page - 1) * $perPage,
        $perPage
    );

    $rows = $pdo->query($sql)->fetchAll();
}
?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<style>
    .navbar_avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover
    }
    .basic_container {
        width: 100%;
    }
    .orders_amount {
        font-size: 2rem;
    }

    .ranking_img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover
    }

    .ranking_text {
        font-size: 1.5rem;
    }
    .mypage_outsidebar {
        width: 30%;

    }

    .mypage_insidebar {
        border: 1px solid black;
        width: 100%;
        height: 300px;
    }
/* --------------以上mypage css------------------ */
    .orders_bar{
        border: 1px solid black;
        width: 65%;
        height: 752px;
    }

</style>
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <form action="002-tommy_account_list.php" class="form-inline my-2 my-lg-0 d-flex justify-content-end">
                
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" value="<?= htmlentities($keyword) ?>" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-end">

                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $qs['page'] = $page - 1;
                                                    echo http_build_query($qs); ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>

                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                            $qs['page'] = $i;
                    ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                            </li>
                    <?php endif;
                    endfor; ?>

                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $qs['page'] = $page + 1;
                                                    echo http_build_query($qs); ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
    <div class="container mt-3">
        <div class="basic_container d-flex justify-content-between">
            <?php include __DIR__ . '/002-tommy_mypage_bar.php'; ?>
            <div class="orders_bar">
                <div class="order-list">歷史訂單</div>
                <div class="order-thead d-flex">
                    <div class="title_th">訂單號碼</div>
                    <div class="title_th">訂單日期</div>
                    <div class="title_th">價錢合計</div>
                    <div class="title_th">訂單狀態</div>
                </div>

                <div class="tb">
                <?php foreach ($rows as $r) : ?>
                    <div class=" d-flex" data-id="<?= $r['id'] ?>">
                        <div class="detail_td"><?= htmlentities($m['id']) ?></div>
                        <div class="detail_td"><?= htmlentities($m['account']) ?></div>
                        <div class="detail_td"><?= htmlentities($m['email']) ?></div>
                        <div class="detail_td"><?= htmlentities($m['nickname']) ?></div>
                    
                    </div>
                <?php endforeach; ?>
                
                </div>
            </div>
           

        </div>
    </div>


</div>



<?php include __DIR__ . '/partials/scripts.php'; ?>
<script>
    const myTable = document.querySelector('table');
    const modal = $('#exampleModal');

    myTable.addEventListener('click', function(event) {

        // 判斷有沒有點到橙色的垃圾筒
        if (event.target.classList.contains('ajaxDelete')) {
            // console.log(event.target.closest('tr'));
            const tr = event.target.closest('tr');
            const id = tr.getAttribute('data-id');

            console.log(`tr.dataset.id:`, tr.dataset.id); // 也可以這樣拿

            if (confirm(`是否要刪除編號為 ${id} 的資料？`)) {
                fetch('002-tommy_account_delete-api.php?id=' + id)
                    .then(r => r.json())
                    .then(obj => {
                        if (obj.success) {
                            tr.remove(); // 從 DOM 裡移除元素
                            // TODO: 1. 刷頁面, 2. 取得該頁的資料再呈現

                        } else {
                            alert(obj.error);
                        }
                    });
            }

        }
    });

    let willDeleteId = 0;
    $('.del1btn').on('click', function(event) {
        willDeleteId = event.target.closest('tr').dataset.id;
        console.log(willDeleteId);
        modal.find('.modal-body').html(`確定要刪除編號為 ${willDeleteId} 的資料嗎？`);
    });

    // 按了確定刪除的按鈕
    modal.find('.modal-del-btn').on('click', function(event) {
        console.log(`002-tommy_account_delete.php?id=${willDeleteId}`);
        location.href = `002-tommy_account_delete.php?id=${willDeleteId}`;
    });

    // modal 一開始顯示時觸發
    modal.on('show.bs.modal', function(event) {
        // console.log(event.target);
    });
    </script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>