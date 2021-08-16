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
                    <a class="nav-link" href="001-emma-blog-list.php">Emma</a>
                </li>

                <!-- 002 Tommy -->
                <li class="nav-item  <?=$activeLi == 'tommy' ? 'active' : ''?>">
                    <a class="nav-link" href="002-tommy.php">Tommy</a>
                </li>

                <!-- 009 li -->
                <li class="nav-item  <?=$activeLi == 'li' ? 'active' : ''?>">
                    <a class="nav-link" href="009-li.php">Li</a>
                </li>

                <!-- 019 Henry -->
                <li class="nav-item  <?=$activeLi == 'henry' ? 'active' : ''?>">
                    <a class="nav-link" href="019-henry.php">Henry</a>
                </li>

                <!-- 033 Leo -->
                <li class="nav-item  <?=$activeLi == 'leo' ? 'active' : ''?>">
                    <a class="nav-link" href="033-leo.php">Leo</a>
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
                    <li class="nav-item">
                        <a class="nav-link  <?=$activeLi == 'edit' ? 'active' : ''?>"
                        href="profile-edit.php">編輯個人資料</a>
                    </li>

                    <!-- WARN the need of avatar?  -->
                    <li class="nav-item">
                        <?php if (!empty($_SESSION['user']['avatar'])): ?>
                            <img src="imgs/<?=$_SESSION['user']['avatar']?>" alt="" width="50px">
                        <?php endif;?>
                    </li>

                    <!-- log out -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">登出</a>
                    </li>

                    <!-- NOTE temp if need, will show up after login -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">example</a>
                    </li>

                    <!-- 004 Joey -->
                    <li class="nav-item  <?=$activeLi == 'joey' ? 'active' : ''?>">
                        <a class="nav-link" href="004-joey.php">Joey</a>
                    </li>


                <?php else: ?>
                <!-- before log in -->
                    <!-- log in -->
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php">登入</a>
                    </li>

                    <!-- register -->
                    <!-- WARN no link -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">註冊</a>
                    </li>
                <?php endif;?>
            </ul>

        </div>
    </div>
</nav>