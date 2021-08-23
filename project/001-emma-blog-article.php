<?php
    include __DIR__. '/partials/init.php';
    $title = '文章';

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $sql = sprintf("SELECT * FROM Blog WHERE id = %s", $id);


    $row = $pdo->query($sql)->fetch();
    if(is_array($row)){
        $row['view_count'] += 1;
        $sql = "UPDATE `Blog` SET 
                          `view_count`= ?
                          WHERE `id`=?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $row['view_count'],
            $row['id']
        ]);
    }

    $top_rank_sql = "SELECT * FROM Blog WHERE 1 ORDER BY view_count DESC LIMIT 0, 6";
    $top_rank_row = $pdo->query($top_rank_sql)->fetchAll();

?>
<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
    <style>
        .hot-rank{
            text-align: center;
        }
        .rank-img img{
            max-width:90px;

        }

        .article-img img{
            max-width:600px;
        }
        .rank p{
            font-size: 14px;
        }

        .rank .title p{
            font-size: 14px;
            margin-bottom: 0px;
            min-height: 50px;
            
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
                       value=""
                       aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-5">
        
        <div class="left col-8 justify-content-center">
        <?php
        if(is_array($row)){
        ?>
            <div class="article-title">
                <h1><?=htmlentities($row['title'])?></h1>
            </div>
            <div class="article-detail d-flex justify-content-between">
                <a href="001-emma-blog-author.php?nick_name=<?=$row['nick_name']?>"><?=$row['nick_name']?></a>
                <div class="article-detail-date-count d-flex inline-block">
                    <p><?=$row['created_at']?></p>

                    <p>&nbsp  點擊數：<?=$row['view_count']?></p>
                </div>
                
            </div>
            <div class="article-img d-flex my-5 justify-content-center">
                <img src="./imgs/<?=htmlentities($row['prvw_img_name'])?>" alt="">
            </div>
            
            <div class="article-detail my-4">
                <p><?=$row['content']?></p>
            </div>
                
        <?php
        } else {
        ?>
            <p>無此文章</p>

        <?php
        }
        ?>
            
        </div>
        
        <div class="right mt-5 col-4 d-flex d-inline">
           <div class="container">
               <div class="row justify-content-center">
                   <div class="hot-rank col-12 mb-3">
                       <h3>熱門排行</h3>
                   </div>
                   <?php foreach($top_rank_row as $r): ?>
                   <a href="001-emma-blog-article.php?id=<?=$r['id']?>" class="row justify-content-center">
                        <div class="rank col-8">
                                <div class="title">
                                    <p><?=htmlentities($r['title'])?></p>
                                </div>
                                <div class="author">
                                    <p><?=htmlentities($r['nick_name'])?></p>
                                </div>

                        </div>
                        <div class="rank-img col-4">
                            
                                <img src="./imgs/<?=$r['prvw_img_name']?>" alt="">
                            
                        </div>
                   </a>
                   <?php endforeach; ?>
                   
               </div>
           </div>
            
            
                    
                   
                
            
                
            

        </div>
    </div>
</div>
<!-- <div class="container">
    <div class="row blog-card my-5">
        <?php foreach($rows as $r): ?>
        <div class="card col-12 col-lg-3 my-lg-1 border-0" id= "card" data-id="<?= $r['id'] ?>">
            <img class="card-img-top" src="imgs/<?= $r['prvw_img_name'] == "" ? "abc.jpg" : $r['prvw_img_name']?>"  alt="Card image cap">
            <div class="card-title mt-4 mb-2">
                <h5 class="card-title"><?= htmlentities($r['title']) ?></h5>
            </div>
            <div class="card-link d-flex justify-content-between">
                <a href="#" class="card-link"><?= htmlentities($r['nick_name']) ?></a>
                <a href="#" class="card-link"><?= $r['created_at'] ?></a>
            </div>
        </div>
       
        <?php endforeach; ?>
        
    </div> 
</div> -->



    


<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    const myLoadBtn = document.querySelector('.load-btn');
    const myBlogCards = document.querySelector('.blog-card');
    const myCard = document.querySelector('.card');
    let addDiv = document.createElement('div');
    let next_id = 5;

    myLoadBtn.addEventListener('click', function(event){
    
        fetch('001-emma-blog-load-api.php?next_id=' + next_id)
            .then(r=>r.json())
            .then(obj=>{
                console.log(obj);
                let rows = obj;
                if(rows.length<4){
                    myLoadBtn.classList.add('d-none');
                    
                }
                for(let i=0; i<rows.length; i++){
                    $( ".blog-card" ).append(
                    ` <div class="card col-12 col-lg-3 my-lg-1 border-0" id= "card" data-id="0">
                        <img class="card-img-top w-100 h-auto" src="imgs/${rows[i].prvw_img_name}" alt="Card image cap">
                        <div class="card-title mt-4 mb-2">
                            <h5 class="card-title">${rows[i]['title']}</h5>
                        </div>
                        <div class="card-link d-flex justify-content-between">
                            <a href="#" class="card-link">${rows[i]['nick_name']}</a>
                            <a href="#" class="card-link">${rows[i]['created_at']}</a>
                        </div>
                    </div>`
                    );

                }
                next_id += 4;
            });
    });

    
  
</script>
<?php include __DIR__. '/partials/html-foot.php'; ?>