<?php
    include __DIR__. '/partials/init.php';
    $title = '作者列表';
    // 關鍵字查詢
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $nick_name = isset($_GET['nick_name']) ? $_GET['nick_name'] : '';



    // $where = ' WHERE 1 ';
    // if(! empty($keyword)){
    //     // $where .= " AND `name` LIKE '%{$keyword}%' "; // sql injection 漏洞
    //     $where .= sprintf(" AND ( `title` LIKE %s ", $pdo->quote('%'. $keyword. '%'));
    //     $where .= sprintf(" OR `author` LIKE %s )", $pdo->quote('%'. $keyword. '%'));

    //     $qs['keyword'] = $keyword;
    // }

    $where = 'WHERE 1 AND';
    if(! empty($nick_name)){
        
        $where .= sprintf(" `nick_name` LIKE %s ", $pdo->quote('%'. $nick_name. '%'));
       
    }
    
    $sql = sprintf("SELECT * FROM `Blog` %s",$where);
   
    $rows = $pdo->query($sql)->fetchAll();

    $where = 'WHERE';
    if(! empty($nick_name)){
        
        $where .= sprintf(" `nick_name` LIKE %s ", $pdo->quote('%'. $nick_name. '%'));
       
    }

    $sql = sprintf("SELECT * FROM blog_author %s",$where);
    $blog_author_rows = $pdo->query($sql)->fetch();
    
    
?>


<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
    <style>
        .author-img img{
            max-width: 255px;
        }
        .author-icon{
            max-width: 200px;
            height: 40px;
            margin-top: 30px;
        }
        .author-icon i{
            font-size: 30px;
        }
        .card-title{
        min-height: 100px;
        }

        .card{
            margin-top: 100px;
        }
    </style>
<div class="container">
    <div class="row" >
        <div class="col d-flex justify-content-between my-3">
            <div class="buttons">
                <button type="button" class="btn btn-secondary insert" onclick="location.href='001-emma-blog-home.php'">文章首頁</button>
                <button type="button" class="btn btn-secondary insert" onclick="location.href='001-emma-blog-list.php'">後台編輯</button>
            </div>
           
            <form action="001-emma-blog-home.php" class="form-inline">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search"
                       value="<?= htmlentities($keyword) ?>"
                       aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="author-img col-12 col-lg-3">
            <img src="./imgs/<?= $blog_author_rows['author_img']?>" alt="">
        </div>
        <div class="author-name mt-3 col-12 col-lg-9">
            <div class="author-name-nick-name">
                <h2><?= $_GET['nick_name'] ?></h2>
            </div>
            <div class="author-counts mt-3">
                <p>發表文章數：<?=count($rows)?></p>

            </div>
            <div class="author-icon d-flex justify-content-between">
                <i class="fab fa-facebook"></i>
                <i class="fas fa-globe"></i>
                <i class="fab fa-instagram"></i>

            </div>
           
        </div>
    </div>
</div>

<div class="container">
    <div class="row blog-card my-5">
    <?php foreach($rows as $r): ?>

        <div class="card col-12 col-lg-3 my-lg-1 border-0" id= "card" data-id="0">
            <a href="001-emma-blog-article.php?id=<?= $r['id']?>">
                <img class="card-img-top w-100 h-auto" src="imgs/<?= $r['prvw_img_name']?>" alt="Card image cap">
                <div class="card-title mt-4 mb-2">
                    <h5 class="card-title"><?= $r['title']?></h5>
                </div>
            </a>
            <div class="card-link d-flex justify-content-between">
                <a href="001-emma-blog-author.php?nick_name=<?= $r['nick_name']?>" class="card-link"><?= $r['nick_name']?></a>
                <p><?= $r['created_at']?></p>
            </div>
        </div>
        
        <?php endforeach; ?>   
    </div> 
</div>



    


<?php include __DIR__. '/partials/scripts.php'; ?>
<?php include __DIR__. '/partials/html-foot.php'; ?>