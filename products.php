<?php
session_start();
include('back/include/config.php');


$offer_exp_products = $db->prepare("SELECT id FROM products WHERE offer_price > 0 AND offer_exp_date < ?");
$offer_exp_products->execute([date('Y-m-d')]);

if ($offer_exp_products->rowCount() > 0)
{
    $stmt = $db->prepare("UPDATE products SET offer_price=? WHERE offer_price > ? AND offer_exp_date < ?");
    $stmt->execute([
        0, 0, date("Y-m-d")
    ]);
}

if (isset($_GET['cat']) && !empty($_GET['cat']))
{
    $products = $db->prepare("SELECT categories.name as category, products.id, products.title, products.price,products.offer_price, products.quantity, products.img1, users.name as owner_name FROM categories INNER JOIN products ON categories.id=products.category_id INNER JOIN users ON users.id=products.owner_id INNER JOIN promote_types ON promote_types.id=products.promote_type_id WHERE products.s_category_id=? ORDER BY promote_types.price DESC");
    $products->execute([
        $_GET['cat'],
    ]);
}
else
{
    $products = $db->prepare("SELECT categories.name as category, products.id, products.title, products.price,products.offer_price, products.quantity, products.img1, users.name as owner_name FROM categories INNER JOIN products ON categories.id=products.category_id INNER JOIN users ON users.id=products.owner_id INNER JOIN promote_types ON promote_types.id=products.promote_type_id ORDER BY promote_types.price DESC");
    $products->execute();
}

$categories = $db->prepare("SELECT id, name FROM categories");
$categories->execute();

$types = $db->prepare("SELECT id, name FROM types");
$types->execute();

$brands = $db->prepare("SELECT id, name FROM brands");
$brands->execute();


$minimum_range = 0;
$maximum_range = 100;
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


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
<!--header-->
<?php include 'include/header.php'; ?>
<!--banner-->
<div class="banner-top">
    <div class="container">
        <h1>Products</h1>
        <em></em>
        <h2><a href="index.php">Home</a><label>/</label><a href="product.php">Products</a></h2>
    </div>
</div>
<!--content-->
<div class="product" style="margin-bottom: 20px;">
    <div class="container">
        <div class="col-md-9">
            <div class="mid-popular" id="product_section">

                <?php
                while ($product = $products->fetchObject())
                {
                    ?>
                    <div class="col-md-4 item-grid1 simpleCart_shelfItem">
                        <div class=" mid-pop">
                            <div class="pro-img">
                                <img src="./uploads/<?= $product->img1 ?>" class="img-responsive" alt="">
                                <div class="zoom-icon ">
                                    <a class="picture" href="images/pc.jpg" rel="title"
                                       class="b-link-stripe b-animate-go  thickbox"><i
                                                class="glyphicon glyphicon-search icon "></i></a>
                                    <a href="product.php?product_id=<?= $product->id ?>"><i
                                                class="glyphicon glyphicon-menu-right icon"></i></a>
                                </div>
                            </div>
                            <div class="mid-1">
                                <div class="women">
                                    <div class="women-top">
                                        <span><?= $product->category ?></span>
                                        <h6>
                                            <a href="product.php?product_id=<?= $product->id ?>"><?= $product->title ?></a>
                                        </h6>
                                    </div>
                                    <?php
                                    if ($product->quantity > 0)
                                    ?>
                                    <div class="img item_add">
                                        <a href="act/cart.php?add=&product=<?= $product->id ?>"><img src="images/ca.png"
                                                                                                     alt=""></a>
                                    </div>
                                    <?php
                                    ?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="mid-2">
                                    <?php
                                    if ($product->offer_price)
                                    {
                                        ?>
                                        <p>
                                            <label>$<?= $product->price ?></label>
                                            <em class="item_price">$
                                                <?php
                                                $off_price = ($product->offer_price * $product->price) / 100;
                                                echo($product->price - $off_price);
                                                ?>
                                            </em>
                                        </p>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p>
                                            <em class="item_price">$<?= $product->price ?></em>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <div class="block">
                                        <div class="starbox small ghosting"></div>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                                <div>
                                    <p><?= $product->owner_name ?></p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-3 product-bottom">
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
            <section class="sky-form">
                <h4 class="cate">Discounts</h4>
                <div class="row row1 scroll-pane">
                    <div class="col col-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label id="minimum_range"><?= $minimum_range ?></label>%
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <label id="maximum_range"><?= $maximum_range ?></label>%
                            </div>
                            <div class="col-md-12" style="padding-top:12px">
                                <div id="price_range"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


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
<!--products-->

<!--//products-->

<!--//content-->
<!--//footer-->
<?php include 'include/footer.php'; ?>
<!--//footer-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="js/simpleCart.min.js"></script>
<!-- slide -->
<script src="js/bootstrap.min.js"></script>
<!--light-box-files -->
<script src="js/jquery.chocolat.js"></script>
<link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen" charset="utf-8">
<!--light-box-files -->
<script type="text/javascript" charset="utf-8">
    $(function ()
    {
        $('a.picture').Chocolat();

        $(".check_per").click(function ()
        {
            console.log($(this).attr('id'));
        });

        $(".check-box").click(function ()
        {
            // $brands = [];
            // $types = [];
            // console.log("<-----New Information----->")

            // $("#brand:checked").each(function(){
            // 	$brands.push($(this).val());
            // })
            // $("#type:checked").each(function(){
            // 	$types.push($(this).val());
            // })
            // $brands = $brands.join(',');
            // $types = $types.join(',');
            // console.log($brands);
            // console.log($types);
            filter_products();
        });

        $("#price_range").slider({
            range: true,
            min: 0,
            max: 100,
            values: [ <?php echo $minimum_range; ?>, <?php echo $maximum_range; ?> ],
            slide: function (event, ui)
            {
                $("#minimum_range").html(ui.values[0]);
                $("#maximum_range").html(ui.values[1]);
                // load_product(ui.values[0], ui.values[1]);
            }
        });
        $("#price_range").mouseup(function ()
        {
            filter_products();
        })
    });

    function filter_products()
    {
        $brands = [];
        $types = [];

        $("#brand:checked").each(function ()
        {
            $brands.push($(this).val());
        })
        $("#type:checked").each(function ()
        {
            $types.push($(this).val());
        })
        $brands = $brands.join(',');
        $types = $types.join(',');

        minimum_range = $("#minimum_range").text();
        maximum_range = $("#maximum_range").text();

        xml = new XMLHttpRequest();

        params = "brands=" + $brands + "&types=" + $types + "&minimum_range=" + minimum_range + "&maximum_range=" + maximum_range;

        console.log(params);

        xml.open('GET', 'act/filter_products.php?' + params, true);
        xml.onload = function ()
        {
            if (this.status == 200)
            {
                rcv = this.responseText;
                $("#product_section").html(rcv);
            }
        }
        xml.send();
    }
</script>
</body>

</html>