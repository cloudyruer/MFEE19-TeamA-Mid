<?php
    include __DIR__. '/partials/init.php';
    $title = '資料列表';

    // 固定每一頁最多幾筆
    $perPage = 5;

    // query string parameters
    $qs = [];

    // 關鍵字查詢
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    // 用戶決定查看第幾頁，預設值為 1
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $where = ' WHERE 1 ';
    if(! empty($keyword)){
        // $where .= " AND `name` LIKE '%{$keyword}%' "; // sql injection 漏洞
        $where .= sprintf(" AND ( `title` LIKE %s ", $pdo->quote('%'. $keyword. '%'));
        $where .= sprintf(" OR `author` LIKE %s )", $pdo->quote('%'. $keyword. '%'));

        $qs['keyword'] = $keyword;
    }


    // 總共有幾筆
    $totalRows = $pdo->query("SELECT count(1) FROM Blog $where ")
        ->fetch(PDO::FETCH_NUM)[0];
    // 總共有幾頁, 才能生出分頁按鈕
    $totalPages = ceil($totalRows / $perPage); // 正數是無條件進位

    $rows = [];
    // 要有資料才能讀取該頁的資料
    if($totalRows!=0) {


        // 讓 $page 的值在安全的範圍
        if ($page < 1) {
            header('Location: ?page=1');
            exit;
        }
        if ($page > $totalPages) {
            header('Location: ?page=' . $totalPages);
            exit;
        }

        $sql = sprintf("SELECT * FROM Blog %s ORDER BY id DESC LIMIT %s, %s",
            $where,
            ($page - 1) * $perPage,
                $perPage);

        $rows = $pdo->query($sql)->fetchAll();

    }
?>
<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
    <style>

        table tbody i.fas.fa-trash-alt.ajaxDelete {
            color: darkorange;
            cursor: pointer;
        }
    </style>
<div class="container">
    <div class="row" >
        <div class="col d-flex justify-content-between my-3">
            <div class="buttons">
                <button type="button" class="btn btn-secondary insert" onclick="location.href='001-emma-blog-home.php'">文章首頁</button>
                <button type="button" class="btn btn-secondary insert" onclick="location.href='001-emma-blog-insert.php'">新增文章</button>
            </div>
           
            <form action="001-emma-blog-list.php" class="form-inline">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search"
                       value="<?= htmlentities($keyword) ?>"
                       aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
   
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">author</th>
                    <th scope="col">nick_name</th>
                    <th scope="col">文章預覽圖片</th>
                    <th scope="col">title</th>
                    <th scope="col">content</th>
                    <th scope="col">category</th>
                    <th scope="col">created_at</th>
                    <th scope="col">last_modified</th>
                    <th scope="col"><i class="fas fa-edit"></i></th>
                    <th scope="col"><i class="fas fa-trash-alt"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($rows as $r): ?>
                <tr data-id="<?= $r['id'] ?>">
                    
                    <td><?= htmlentities($r['id']) ?></td>
                    <td><?= htmlentities($r['author']) ?></td>
                    <td><?= htmlentities($r['nick_name']) ?></td>
                    <td><img  src="imgs/<?= $r['prvw_img_name'] == "" ? "abc.jpg" : $r['prvw_img_name']?>" style="max-width: 100px;"> </td>
                    <td><?= htmlentities($r['title']) ?></td>
                    <td><?= htmlentities($r['content']) ?></td>
                    <td><?= htmlentities($r['category']) ?></td>
                    <td><?= $r['created_at'] ?></td>
                    <td><?= $r['last_modified'] ?></td>

                    <td>
                        <a href="001-emma-blog-edit.php?id=<?= $r['id'] ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>

                    <td>
                        <i class="fas fa-trash-alt ajaxDelete"></i>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
    <div class="row">
        <div class="col">
            
            <nav aria-label="Page navigation example">
                <ul class="pagination d-flex justify-content-center">

                    <li class="page-item <?= $page<=1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                        $qs['page']=$page-1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </li>

                    <?php for($i=$page-5; $i<=$page+5; $i++):
                        if($i>=1 and $i<=$totalPages):
                            $qs['page'] = $i;
                            ?>
                    <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                    </li>
                    <?php endif;
                        endfor; ?>

                    <li class="page-item <?= $page>=$totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php
                        $qs['page']=$page+1;
                        echo http_build_query($qs);
                        ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>


</div>

    


<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    const myTable = document.querySelector('table');
    const myButton = document.querySelector('button');

    myTable.addEventListener('click', function(event){

        // 判斷有沒有點到橙色的垃圾筒
        if(event.target.classList.contains('ajaxDelete')){
            // console.log(event.target.closest('tr'));
            const tr = event.target.closest('tr');
            const id = tr.getAttribute('data-id');

            console.log(`tr.dataset.id:`, tr.dataset.id); // 也可以這樣拿

            if(confirm(`是否要刪除編號為 ${id} 的資料？`)){
                fetch('001-emma-blog-delete-api.php?id=' + id)
                    .then(r=>r.json())
                    .then(obj=>{
                        if(obj.success){
                            tr.remove();  // 從 DOM 裡移除元素
                            // TODO: 1. 刷頁面, 2. 取得該頁的資料再呈現
                            location.href = '001-emma-blog-list.php';
                        } else {
                            alert(obj.error);
                        }
                    });
            }

        }
    });

    
  
</script>
<?php include __DIR__. '/partials/html-foot.php'; ?>