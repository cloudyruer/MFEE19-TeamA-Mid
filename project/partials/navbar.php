<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- NOTE -->
        <a class="navbar-brand" href="index_.php">Team &#923;</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- left side -->
            <ul class="navbar-nav mr-auto">
                <!-- NOTE temp 需要的話複製就好 不要動這個 li-->
                <li class="nav-item active">
                    <a class="nav-link" href="#">Member : </a>
                </li>

                <!-- 001 Emma -->
                <li class="nav-item  <?=$activeLi == 'emma' ? 'active' : ''?>">
                    <a class="nav-link" href="001-emma-blog-list.php">Blog</a>
                </li>

                <!-- 009 li -->
                <li class="nav-item  <?=$activeLi == 'li' ? 'active' : ''?>">
                    <a class="nav-link" href="009-li.php">Product List</a>
                </li>

                <!-- 019 Henry -->
                <!-- TODO: FIX -->
                <li class="nav-item  <?=$activeLi == 'henry' ? 'active' : ''?>">
                    <a class="nav-link" href="019-henry-product-list.php">Henry</a>
                </li>

                <!-- 033 Leo -->
                <li class="nav-item  <?=$activeLi == 'leo' ? 'active' : ''?>">
                    <a class="nav-link" href="033-leo-stadium-list.php">Stadium</a>
                </li>

            </ul>

            <!-- right side -->
            <ul class="navbar-nav">
                <!-- after log in,  will show up after login -->
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item active">
                        <a class="nav-link" ><?=$_SESSION['user']['nickname']?></a>
                    </li>

                    <!-- NOTE  add $activeLi ternary-->
                    <!----------- Tommy改的部分 -------------->
                    <li class="nav-item">
                        <a class="nav-link  <?=$activeLi == 'edit' ? 'active' : ''?>"
                        href="002-tommy_index.php">會員中心</a>
                    </li>

                    <!-- WARN the need of avatar?  -->
                    <li class="nav-item">
                        <!-- FIX 刪掉? --by Joey-->

                        <?php /* FIX NOTE 這是原本的 <?php if (empty($r['avatar'])): ?> --by Joey */?>
                        <?php if (empty($_SESSION['user']['avatar'])): ?>
                            <img class="Tommy_navbar_avatar" src="./imgs/default_avatar.jpeg" alt="">
                        <?php else: ?>
                            <img class="Tommy_navbar_avatar" src="imgs/<?=$_SESSION['user']['avatar']?>" alt="">
                        <?php endif;?>
                        <!----------- Tommy改的部分 -------------->

                    </li>

                    <!-- 004 Joey -->
                    <li class="nav-item  <?=$activeLi == 'joey' ? 'active' : ''?>">
                        <a class="nav-link" href="004-joey.php">舉辦活動</a>
                    </li>

                    <!-- log out -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">登出</a>
                    </li>

                    <!-- NOTE TODO:temp if need, will show up after login -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">example</a>
                    </li> -->




                <?php else: ?>
                <!-- before log in -->
                    <!-- log in -->
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php">登入</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="002-tommy_signup.php">註冊</a>
                    </li>
                    <!----------- Tommy改的部分 -------------->

                <?php endif;?>
            </ul>

        </div>
    </div>
</nav>