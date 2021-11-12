<div class="header">
    <div class="container">
        <div class="head">
            <div class=" logo">
                <a href="index.php"><img src="" alt=""></a>
            </div>
        </div>
    </div>
    <div class="header-top">
        <div class="container">
            <div class="col-md-7 col-md-offset-2  header-login">

            </div>

            <div class="col-md-3 col-sm-12 header-login">
                <ul>
                    <?php
                    if (isset($_SESSION['user_type']))
                    {
                        ?>
                        <li><a href="./back/">Dashboart</a></li>
                        <li><a href="./back/include/logout.php">Logout</a></li>
                        <?php
                    } else
                    {
                        ?>
                        <li><a href="login.php">Login</a></li>
                        <?php
                    }
                    ?>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <?php
    if (isset($_SESSION['success']))
    {
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <p class="text-center"><?= $_SESSION['success'] ?></p>
        </div>
        <?php
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error']))
    {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <p class="text-center"><?= $_SESSION['error'] ?></p>
        </div>
        <?php
        unset($_SESSION['error']);
    }
    ?>

    <div class="container">

        <div class="head-top">

            <div class="col-sm-8 col-md-offset-2 h_menu4">
                <nav class="navbar nav_bottom" role="navigation">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header nav_2">
                        <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse"
                                data-target="#bs-megadropdown-tabs">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
                        <ul class="nav navbar-nav nav_1">
                            <li><a class="color" href="index.php">Home</a></li>

                            <li class="dropdown mega-dropdown active">
                                <a class="color1" href="#" class="dropdown-toggle" data-toggle="dropdown">Category<span
                                            class="caret"></span></a>
                                <div class="dropdown-menu ">
                                    <div class="menu-top">

                                        <?php

                                        $categoriess = $db->prepare("SELECT id, name FROM categories");
                                        $categoriess->execute();

                                        while ($category = $categoriess->fetchObject())
                                        {
                                            ?>

                                            <div class="col1">
                                                <div class="h_nav">
                                                    <h4><?= $category->name ?></h4>
                                                    <ul>

                                                        <?php

                                                        $s_cats = $db->prepare("SELECT id, name FROM s_categories WHERE category_id=?");
                                                        $s_cats->execute([
                                                            $category->id,
                                                        ]);
                                                        if ($s_cats->rowCount() > 0)
                                                        {
                                                            while ($s_cat = $s_cats->fetchObject())
                                                            {

                                                                ?>

                                                                <li>
                                                                    <a href="products.php?cat=<?= $s_cat->id ?>"><?= $s_cat->name ?></a>
                                                                </li>

                                                                <?php
                                                            }
                                                        }

                                                        ?>

                                                    </ul>
                                                </div>
                                            </div>

                                            <?php
                                        }

                                        ?>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </li>
                            <li><a class="color6" href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->

                </nav>
            </div>
            <div class="col-sm-2 search-right">
                <ul class="heart">
                    <!-- <li>
                        <a href="wishlist.php">
                            <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                        </a></li> -->
                    <li><a class="play-icon popup-with-zoom-anim" href="#small-dialog">Search &nbsp;<i
                                    class="glyphicon glyphicon-search"> </i></a></li>
                </ul>
                <div class="cart box_1">
                    <a href="checkout.php">
                        <h3>
                            <div class="total">
                                <?php
                                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "user")
                                {
                                    $crt = $db->prepare("SELECT id FROM cart WHERE user_id='$_SESSION[user_id]' && status=1");
                                    $crt->execute();
                                    echo $crt->rowCount();
                                } else
                                {
                                    echo "0";
                                }
                                ?>
                            </div>
                            <img src="images/cart.png" alt=""/>
                        </h3>
                    </a>
                    <p><a href="./act/cart.php?empty=" class="simpleCart_empty">Empty Cart</a></p>

                </div>
                <div class="clearfix"></div>

                <!----->

                <!---pop-up-box---->
                <link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all"/>
                <script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
                <!---//pop-up-box---->
                <div id="small-dialog" class="mfp-hide">
                    <div class="search-top">
                        <div class="login-search">
                            <input type="submit" value="">
                            <input type="text" value="Search.." onfocus="this.value = '';"
                                   onblur="if (this.value == '') {this.value = 'Search..';}" onkeyup="search(this)">
                        </div>
                        <div id="serch-product-result">
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $('.popup-with-zoom-anim').magnificPopup({
                            type: 'inline',
                            fixedContentPos: false,
                            fixedBgPos: true,
                            overflowY: 'auto',
                            closeBtnInside: true,
                            preloader: false,
                            midClick: true,
                            removalDelay: 300,
                            mainClass: 'my-mfp-zoom-in'
                        });

                    });

                    function search(ele)
                    {
                        $.get('./act/product.php?title=' + ele.value, function (data)
                        {
                            document.getElementById('serch-product-result').innerHTML = data;
                        });
                    }
                </script>
                <!----->
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>