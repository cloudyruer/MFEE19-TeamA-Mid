<?php
include __DIR__ . '/partials/init.php';
$title = '資料列表';
$activeLi = 'tommy';

// 固定每一頁最多幾筆
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
    table tbody i.fas.fa-trash-alt {
        color: darkred;
    }

    table tbody i.fas.fa-trash-alt.ajaxDelete {
        color: darkorange;
        cursor: pointer;
    }
</style>
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <form action="002-tommy_account_list.php" class="form-inline my-2 my-lg-0 d-flex justify-content-end">
                <a class="mx-3" href="002-tommy_account_insert.php">新增資料</a>
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
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col"><i class="fas fa-trash-alt"></i></th>
                        <th scope="col"><i class="fas fa-trash-alt"> ajax</i></th>
                        <th scope="col">id</th>
                        <th scope="col">account</th>
                        <th scope="col">email</th>
                        <th scope="col">mobile</th>
                        <th scope="col">address</th>
                        <th scope="col">birthday</th>
                        <th scope="col">nickname</th>
                        <th scope="col"><i class="fas fa-edit"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr data-id="<?= $r['id'] ?>">
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-warning del1btn" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                            <td>
                                <i class="fas fa-trash-alt ajaxDelete"></i>
                            </td>
                            <td><?= htmlentities($r['id']) ?></td>
                            <td><?= htmlentities($r['account']) ?></td>
                            <td><?= htmlentities($r['email']) ?></td>
                            <td><?= htmlentities($r['mobile']) ?></td>
                            <td><?= htmlentities($r['address']) ?></td>
                            <td><?= htmlentities($r['birthday']) ?></td>
                            <td><?= htmlentities($r['nickname']) ?></td>
                            <td>
                                <a href="002-tommy_account_edit.php?id=<?= $r['id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>


</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">刪除注意</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary modal-del-btn">Delete</button>
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