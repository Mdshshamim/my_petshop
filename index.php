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

$products = $db->prepare("SELECT categories.name as category, products.id, products.title, products.price,products.offer_price, products.quantity, products.img1, users.name as owner_name FROM categories INNER JOIN products ON categories.id=products.category_id INNER JOIN users ON users.id=products.owner_id INNER JOIN promote_types ON promote_types.id=products.promote_type_id ORDER BY promote_types.price DESC");
$products->execute();
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

</head>

<body>
<!--header-->

<?php include 'include/header.php'; ?>
<!--banner-->
<div class="banner">
    <div class="container">
        <section class="rw-wrapper">
            <h1 class="rw-sentence">
                <span class="text-center" style="font-weight: 900;">Pet Shop</span>
                <div class="rw-words rw-words-1">
                    <!--
                                            <span>Beautiful Designs</span>
                                            <span>Sed ut perspiciatis</span>
                                            <span> Totam rem aperiam</span>
                                            <span>Nemo enim ipsam</span>
                                            <span>Temporibus autem</span>
                                            <span>intelligent systems</span>
                    -->
                </div>
                <div class="rw-words rw-words-2">
                    <span class="text-center">Welcome to our shop</span>
                    <span class="text-center">We provide the best services</span>
                    <span class="text-center">We provide the best products</span>
                    <span class="text-center">There are many variation</span>
                    <span class="text-center">We believe in our service</span>
                    <span class="text-center">We ensure that you will impress</span>
                </div>
            </h1>
        </section>
    </div>
</div>
<!--content-->
<div class="content" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="container">
        <!--products-->
        <div class="content-mid">
            <h3>Trending Items</h3>
            <label class="line"></label>
            <div class="mid-popular">

                <?php

                $i = 0;
                while ($product = $products->fetchObject())
                {
                    $i++;
                    $promote_h = $db->query("SELECT ending_date FROM promote_history WHERE product_id='$product->id' AND status=1 ORDER BY id DESC LIMIT 1");
                    if ($promote_h->rowCount() > 0)
                    {
                        $ending_date = $promote_h->fetch()['ending_date'];
                        if (date('Y-m-d') > $ending_date)
                        {
                            $db->query("UPDATE products SET promote_type_id=1 WHERE id='$product->id'");
                        }
                    }
                    ?>

                    <div class="col-md-3 item-grid simpleCart_shelfItem">
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
                                    <div class="clearfix"></div>
                                </div>
                                <div>
                                    <p><?= $product->owner_name ?></p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php
                    if ($i == 4)
                    {
                        $i = 0;
                        echo '<div class="clearfix"></div>';
                    }
                }

                ?>

            </div>
        </div>
        <!--//products-->

    </div>

</div>
<!--//content-->


<!--//footer-->
<?php include 'include/footer.php'; ?>
<!--//footer-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/simpleCart.min.js">


</script>
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
    });

</script>


</body>

</html>
