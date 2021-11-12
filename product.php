<?php
session_start();
include('back/include/config.php');

if (isset($_GET['product_id']) && !empty($_GET['product_id']))
{
    $product_id = $_GET['product_id'];

    $products = $db->prepare("SELECT * FROM products WHERE id=?");
    $products->execute([
        $product_id,
    ]);

    if ($products->rowCount() > 0)
        $product = $products->fetchObject();
    else
    {
        header("location:index.php");
        exit();
    }
}
else
{
    header("location:index.php");
    exit();
}

$categories = $db->prepare("SELECT id, name FROM categories");
$categories->execute();

$types = $db->prepare("SELECT id, name FROM types");
$types->execute();

$brands = $db->prepare("SELECT id, name FROM brands");
$brands->execute();
$i = 0;

if (isset($_SESSION['user_id']))
{
    $ratting_val = $db->prepare("SELECT ratting FROM rattings WHERE user_id=? AND product_id=?");
    $ratting_val->execute([
        $_SESSION['user_id'],
        $product->id
    ]);
    if ($ratting_val->rowCount() > 0)
    {
        $ratting_val = $ratting_val->fetchObject();
        $ratting_val = $ratting_val->ratting;
    }
    else
    {
        $ratting_val = 0;
    }

    $cart = $db->prepare("SELECT id FROM cart WHERE user_id=? AND product_id=?");
    $cart->execute([
        $_SESSION['user_id'],
        $product->id
    ]);

    if ($cart->rowCount() == 0)
        $ratting_val = 'false';
}
else
    $ratting_val = 'false';

$ratting_avg = $db->prepare("SELECT AVG(ratting) as ratting FROM rattings WHERE product_id=?");
$ratting_avg->execute([
    $product_id,
]);

$ratting_avg = $ratting_avg->fetchObject();
$ratting_avg = sprintf('%.2f', $ratting_avg->ratting);
if ($ratting_avg == "0.00")
{
    $ratting_avg = "5.00";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Pet Shop</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Custom Theme files -->
    <!--theme-style-->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Pet Shop"/>
    <script type="application/x-javascript">
        addEventListener("load", function ()
        {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar()
        {
            window.scrollTo(0, 1);
        }
    </script>
    <!--theme-style-->
    <link href="css/style4.css" rel="stylesheet" type="text/css" media="all"/>
    <!--//theme-style-->
    <script src="js/jquery.min.js"></script>
    <!--- start-rate---->
    <script src="js/jstarbox.js"></script>
    <link rel="stylesheet" href="css/jstarbox.css" type="text/css" media="screen" charset="utf-8"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript">
        jQuery(function ()
        {
            jQuery('.starbox').each(function ()
            {
                var starbox = jQuery(this);
                starbox.starbox({
                    average: starbox.attr('data-start-value'),
                    changeable: starbox.hasClass('unchangeable') ? false : starbox.hasClass('clickonce') ? 'once' : true,
                    ghosting: starbox.hasClass('ghosting'),
                    autoUpdateAverage: starbox.hasClass('autoupdate'),
                    buttons: starbox.hasClass('smooth') ? false : starbox.attr('data-button-count') || 5,
                    stars: starbox.attr('data-star-count') || 5
                }).bind('starbox-value-changed', function (event, value)
                {
                    if (starbox.hasClass('random'))
                    {
                        var val = Math.random();
                        starbox.next().text(' ' + val);
                        return val;
                    }
                })
            });
        });
    </script>
    <!---//End-rate---->
    <link href="css/form.css" rel="stylesheet" type="text/css" media="all"/>
    <style>
        .d-none {
            display: none;
        }
    </style>
</head>

<body>
<!--header-->
<?php include 'include/header.php'; ?>
<!--banner-->
<div class="banner-top">
    <div class="container">
        <h1>Single</h1>
        <em></em>
        <!--<h2><a href="index.php">Home</a><label>/</label><a href="single.php">Single</a></h2>-->
    </div>
</div>
<div class="single">

    <div class="container">
        <div class="col-md-9">
            <div class="col-md-5 grid">
                <div class="flexslider">
                    <ul class="slides">
                        <li data-thumb="./uploads/<?= $product->img1 ?>">
                            <div class="thumb-image"><img src="./uploads/<?= $product->img1 ?>" data-imagezoom="true"
                                                          class="img-responsive"></div>
                        </li>
                        <li data-thumb="./uploads/<?= $product->img2 ?>">
                            <div class="thumb-image"><img src="./uploads/<?= $product->img2 ?>" data-imagezoom="true"
                                                          class="img-responsive"></div>
                        </li>
                        <li data-thumb="./uploads/<?= $product->img3 ?>">
                            <div class="thumb-image"><img src="./uploads/<?= $product->img3 ?>" data-imagezoom="true"
                                                          class="img-responsive"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-7 single-top-in">
                <div class="span_2_of_a1 simpleCart_shelfItem">
                    <h3><?= $product->title ?>&nbsp;&nbsp;<small>Ratting: <span
                                    id="ratting_avg"><?= $ratting_avg ?></span></small></h3>
                    <p class="in-para"> There are many variations of products.</p>
                    <div class="price_single">
                            <span class="reducedfrom item_price">BDT
                                <?php
                                if ($product->offer_price)
                                {
                                    $off_price = ($product->offer_price * $product->price) / 100;
                                    echo($product->price - $off_price);
                                }
                                else
                                    echo $product->price;
                                ?>
                            </span>
                        <div class="clearfix"></div>
                    </div>

                    <div class="rating-sec">
                        <div id="ratings_<?= $i ?>">
                            <label for="rate1_<?= $i ?>" id="rate1L_<?= $i ?>">
                                <input type="radio" id="rate1_<?= $i ?>" name="rate_<?= $i ?>" value="1" class="d-none">
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </label>
                            <label for="rate2_<?= $i ?>" id="rate2L_<?= $i ?>">
                                <input type="radio" id="rate2_<?= $i ?>" name="rate_<?= $i ?>" value="2" class="d-none">
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </label>
                            <label for="rate3_<?= $i ?>" id="rate3L_<?= $i ?>">
                                <input type="radio" id="rate3_<?= $i ?>" name="rate_<?= $i ?>" value="3" class="d-none">
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </label>
                            <label for="rate4_<?= $i ?>" id="rate4L_<?= $i ?>">
                                <input type="radio" id="rate4_<?= $i ?>" name="rate_<?= $i ?>" value="4" class="d-none">
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </label>
                            <label for="rate5_<?= $i ?>" id="rate5L_<?= $i ?>">
                                <input type="radio" id="rate5_<?= $i ?>" name="rate_<?= $i ?>" value="5" class="d-none">
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </label>
                        </div>
                    </div>
                    <script>
                        rating_val = <?= $ratting_val ?>;

                        if (rating_val != false)
                        {
                            if (rating_val > 0)
                            {
                                if (rating_val == 1)
                                {
                                    $('#rate1L_<?= $i ?> i').css('color', 'red');
                                }
                                else if (rating_val == 2)
                                {
                                    $('#rate1L_<?= $i ?> i, #rate2L_<?= $i ?> i').css('color', 'red');
                                }
                                else if (rating_val == 3)
                                {
                                    $('#rate1L_<?= $i ?> i, #rate2L_<?= $i ?> i, #rate3L_<?= $i ?> i').css('color', 'red');
                                }
                                else if (rating_val == 4)
                                {
                                    $('#rate1L_<?= $i ?> i, #rate2L_<?= $i ?> i, #rate3L_<?= $i ?> i, #rate3L_<?= $i ?> i, #rate4L_<?= $i ?> i').css('color', 'red');
                                }
                                else if (rating_val == 5)
                                {
                                    $('#rate1L_<?= $i ?> i, #rate2L_<?= $i ?> i, #rate3L_<?= $i ?> i, #rate3L_<?= $i ?> i, #rate4L_<?= $i ?> i, #rate4L_<?= $i ?> i, #rate5L_<?= $i ?> i').css('color', 'red');
                                }
                            }

                            $('#rate1_<?= $i ?>').click(function ()
                            {
                                $('#ratings_<?= $i ?> i').css('color', 'black');
                                $('#rate1L_<?= $i ?> i').css('color', 'red');

                                rating($(this).val(), <?= $product_id ?>);
                            });
                            $('#rate2_<?= $i ?>').click(function ()
                            {
                                $('#ratings_<?= $i ?> i').css('color', 'black');
                                $('#rate1L_<?= $i ?> i, #rate2L_<?= $i ?> i').css('color', 'red');

                                rating($(this).val(), <?= $product_id ?>);
                            });
                            $('#rate3_<?= $i ?>').click(function ()
                            {
                                $('#ratings_<?= $i ?> i').css('color', 'black');
                                $('#rate1L_<?= $i ?> i, #rate2L_<?= $i ?> i, #rate3L_<?= $i ?> i').css('color', 'red');

                                rating($(this).val(), <?= $product_id ?>);
                            });
                            $('#rate4_<?= $i ?>').click(function ()
                            {
                                $('#ratings_<?= $i ?> i').css('color', 'black');
                                $('#rate1L_<?= $i ?> i, #rate2L_<?= $i ?> i, #rate3L_<?= $i ?> i, #rate3L_<?= $i ?> i, #rate4L_<?= $i ?> i').css('color', 'red');

                                rating($(this).val(), <?= $product_id ?>);
                            });
                            $('#rate5_<?= $i ?>').click(function ()
                            {
                                $('#ratings_<?= $i ?> i').css('color', 'black');
                                $('#rate1L_<?= $i ?> i, #rate2L_<?= $i ?> i, #rate3L_<?= $i ?> i, #rate3L_<?= $i ?> i, #rate4L_<?= $i ?> i, #rate4L_<?= $i ?> i, #rate5L_<?= $i ?> i').css('color', 'red');

                                rating($(this).val(), <?= $product_id ?>);
                            });
                        }
                    </script>

                    <h4 class="quick">Quick Overview:</h4>
                    <p class="quick_desc"> <?= $product->overview ?></p>
                    <div class="quantity">
                        <div class="quantity-select">
                            <div class="entry value-minus">&nbsp;</div>
                            <div class="entry value"><span>1</span></div>
                            <div class="entry value-plus active">&nbsp;</div>
                        </div>
                    </div>
                    <!--quantity-->
                    <script>
                        $('.value-plus').on('click', function ()
                        {
                            var divUpd = $(this).parent().find('.value'),
                                newVal = parseInt(divUpd.text(), 10) + 1;
                            divUpd.text(newVal);
                        });

                        $('.value-minus').on('click', function ()
                        {
                            var divUpd = $(this).parent().find('.value'),
                                newVal = parseInt(divUpd.text(), 10) - 1;
                            if (newVal >= 1) divUpd.text(newVal);
                        });
                    </script>
                    <!--quantity-->

                    <?php
                    if ($product->quantity > 0)
                    ?>
                    <a href="act/cart.php?add=&product=<?= $product->id ?>" class="add-to item_add hvr-skew-backward">Add
                        to cart</a>
                    <?php
                    ?>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="clearfix"></div>
            <!---->
            <div class="tab-head">
                <nav class="nav-sidebar">
                    <ul class="nav tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">Product Description</a></li>
                        <li class=""><a href="#tab2" data-toggle="tab">Additional Information</a></li>
                    </ul>
                </nav>
                <div class="tab-content one">
                    <div class="tab-pane active text-style" id="tab1">
                        <div class="facts">
                            <p> <?= $product->description ?> </p>
                        </div>

                    </div>
                    <div class="tab-pane text-style" id="tab2">

                        <div class="facts">
                            <p> <?= $product->additional_info ?> </p>
                        </div>

                    </div>

                </div>
                <div class="clearfix"></div>
            </div>
            <!---->
        </div>
        <!----->

        <div class="col-md-3 product-bottom product-at">
            <!--categories-->
            <div class=" rsidebar span_1_of_left">
                <h4 class="cate">Categories</h4>
                <ul class="menu-drop">

                    <?php
                    $i = 0;
                    while ($category = $categories->fetchObject())
                    {
                        $i++;
                        ?>
                        <li class="item<?= $i ?>"><a href="#"><?= $category->name ?> </a>
                            <ul class="cute">
                                <?php
                                $s_categories = $db->prepare("SELECT id, name FROM s_categories WHERE category_id=?");
                                $s_categories->execute([
                                    $category->id,
                                ]);
                                if ($s_categories->rowCount() > 0)
                                {
                                    while ($s_cat = $s_categories->fetchObject())
                                    {
                                        ?>
                                        <li>
                                            <a href="products.php?cat=<?= $s_cat->id ?>"><?= $s_cat->name ?> </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
            </div>
            <!--initiate accordion-->
            <script type="text/javascript">
                $(function ()
                {
                    var menu_ul = $('.menu-drop > li > ul'),
                        menu_a = $('.menu-drop > li > a');
                    menu_ul.hide();
                    menu_a.click(function (e)
                    {
                        e.preventDefault();
                        if (!$(this).hasClass('active'))
                        {
                            menu_a.removeClass('active');
                            menu_ul.filter(':visible').slideUp('normal');
                            $(this).addClass('active').next().stop(true, true).slideDown('normal');
                        }
                        else
                        {
                            $(this).removeClass('active');
                            $(this).next().stop(true, true).slideUp('normal');
                        }
                    });

                });
            </script>
            <!--//menu-->


            <!---->
            <section class="sky-form">
                <h4 class="cate">Type</h4>
                <div class="row row1 scroll-pane">
                    <div class="col col-4">
                        <?php
                        while ($type = $types->fetchObject())
                        {
                            $count = $db->prepare("SELECT id FROM products WHERE type_id=?");
                            $count->execute([
                                $type->id,
                            ]);
                            ?>

                            <label class="checkbox">
                                <input type="checkbox" class="check-box" name="type" id="type" value="<?= $type->id ?>"><i></i>
                                <?= $type->name ?> (<?= $count->rowCount() ?>)
                            </label>

                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
            <section class="sky-form">
                <h4 class="cate">Brand</h4>
                <div class="row row1 scroll-pane">
                    <div class="col col-4">
                        <?php
                        while ($brand = $brands->fetchObject())
                        {
                            $count = $db->prepare("SELECT id FROM products WHERE brand_id=?");
                            $count->execute([
                                $brand->id,
                            ]);
                            ?>

                            <label class="checkbox">
                                <input type="checkbox" class="check-box" name="brand" id="brand"
                                       value="<?= $brand->id ?>"><i></i>
                                <?= $brand->name ?> (<?= $count->rowCount() ?>)
                            </label>

                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
        <div class="clearfix"></div>
    </div>
</div>


<!--//content-->
<!--//footer-->
<?php include 'include/footer.php'; ?>
<!--//footer-->
<script src="js/imagezoom.js"></script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script defer src="js/jquery.flexslider.js"></script>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen"/>

<script>
    // Can also be used with $(document).ready()
    $(window).load(function ()
    {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    });
</script>

<script>
    function rating(value, product)
    {
        xml = new XMLHttpRequest();
        xml.open('POST', 'act/update-rate.php', true);
        xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        params = "value=" + value + "&product=" + product;
        xml.onload = function ()
        {
            if (this.status == 200)
            {
                // console.log(this.responseText)
                $("#ratting_avg").html(this.responseText);
            }
        }
        xml.send(params);
    }
</script>

<script src="js/simpleCart.min.js"></script>
<!-- slide -->
<script src="js/bootstrap.min.js"></script>


</body>

</html>