<div class="mypage_outsidebar d-flex flex-column">
    <div class="mypage_insidebar d-flex flex-column justify-content-center align-items-center">
        <h3>我的帳戶</h3>
        <h4 class="my-2"><a href="002-tommy_index.php">個人資訊</a></h4>
        <h4 class="my-2"><a href="002-tommy_orders_page.php">歷史訂單</a></h4>
        <h4 class="my-2"><a href="002-tommy-api.php">追蹤清單</a></h4>
        <h4 class="my-2"><a href="002-tommy-api.php">活動列表</a></h4>
        <h4 class="my-2"><a href="002-tommy-api.php">收件資訊</a></h4>
        <!-- <h2>Hi Tommy!! <a href="002-tommy-api.php">Click me!</a> ☜(ﾟヮﾟ☜)</h2>  -->
    </div>
    <div class="mypage_insidebar d-flex flex-column justify-content-center align-items-center my-5">
        <div class="form-group">
            <label for="avatar"></label>
            <!-- <input type="text" class="form-control" id="clean" name="clean"?>"> -->
            <!-- <a href=""></a> -->


            
            <?php if (($m['orders_amount'] >= 3000)) :?>
                <div class="">
                    <img class="ranking_img" src="./imgs/L4.jpeg" alt="">
                    <p class="ranking_text text-center mt-3">等級四</p>
                </div>
            <?php elseif (($m['orders_amount'] >= 2000)) :?>
                <img class="ranking_img" src="./imgs/L3.png" alt="">
                <p class="ranking_text text-center mt-3">等級三</p>
            <?php elseif (($m['orders_amount'] >= 1000)) :?>
                <div class="">
                    <img class="ranking_img" src="./imgs/L2.jpeg" alt="">
                    <p class="ranking_text text-center mt-3 ">等級二</p>
                </div>
            <?php else : ?>
                <img class="ranking_img" src="./imgs/L1.jpeg" alt="">
                <p class="ranking_text text-center mt-3">等級一</p>
            <?php endif; ?>
            
            <div>累計消費<span class="orders_amount"><?= htmlentities($m['orders_amount']) ?></span>元</div>


        </div>
    </div>
    <div class="mypage_insidebar d-flex flex-column justify-content-center align-items-center">
        <h3>我的帳戶</h3>
        <h4 class="my-2"><a href="002-tommy_account_list.php">個人資訊後台</a></h4>
        <h4 class="my-2"><a href="002-tommy_orders.php">歷史訂單</a></h4>
        <h4 class="my-2"><a href="002-tommy-api.php">追蹤清單</a></h4>
        <h4 class="my-2"><a href="002-tommy-api.php">活動列表</a></h4>
        <h4 class="my-2"><a href="002-tommy-api.php">收件資訊</a></h4>

    </div>

</div>