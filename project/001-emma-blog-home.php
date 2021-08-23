<?php
    include __DIR__. '/partials/init.php';
    $title = '文章列表';
    // 關鍵字查詢
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';


    $where = ' WHERE 1 ';
    if(! empty($keyword)){
        // $where .= " AND `name` LIKE '%{$keyword}%' "; // sql injection 漏洞
        $where .= sprintf(" AND ( `title` LIKE %s ", $pdo->quote('%'. $keyword. '%'));
        $where .= sprintf(" OR `author` LIKE %s )", $pdo->quote('%'. $keyword. '%'));

        $qs['keyword'] = $keyword;
    }

    
?>
<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>

<div class="container">
    <div class="row" >
        <div class="col d-flex justify-content-between my-3">
            <div class="buttons">
                
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
    <div class="row blog-card my-5">
        
        
    </div> 
</div>
<div class="container">
    <div class="row justify-content-center">
        <button type="button" class="btn btn-dark load-btn">看更多</button>
    </div>
</div>


    


<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    const myLoadBtn = document.querySelector('.load-btn');
    const myBlogCards = document.querySelector('.blog-card');
    const myCard = document.querySelector('.card');
    let addDiv = document.createElement('div');
    let next_id = 4;

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
                        <a href="001-emma-blog-article.php?id=${rows[i]['id']}">
                            <img class="card-img-top w-100 h-auto" src="imgs/${rows[i].prvw_img_name}" alt="Card image cap">
                            <div class="card-title mt-4 mb-2">
                                <h5 class="card-title">${rows[i]['title']}</h5>
                            </div>
                        </a>
                        <div class="card-link d-flex justify-content-between">
                            <a href="#" class="card-link">${rows[i]['nick_name']}</a>
                            <p>${rows[i]['created_at']}</p>
                        </div>
                    </div>`
                    );

                }
                next_id += 4;
            });
    });

    myLoadBtn.click();

    
  
</script>
<?php include __DIR__. '/partials/html-foot.php'; ?>