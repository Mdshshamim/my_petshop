<?php
session_start();
include('back/include/config.php');

if (!isset($_SESSION['user_type']))
{
    header("Location: ./login.php");
    exit();
}

$profile_cart = true;
if (isset($_GET['order_id']) && !empty($_GET['order_id']))
{
    $profile_cart = false;
    $cart_products = $db->prepare("SELECT *, cart.id, cart.quantity FROM cart INNER JOIN products ON cart.product_id=products.id WHERE cart.user_id='$_SESSION[user_id]' && cart.order_id='$_GET[order_id]'");
}
else
{
    $cart_products = $db->prepare("SELECT *, cart.id, cart.quantity FROM cart INNER JOIN products ON cart.product_id=products.id WHERE cart.user_id='$_SESSION[user_id]' && cart.status=1");
}
$cart_products->execute();

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

        function hideURLbar() {
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
        jQuery(function () {
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
                }).bind('starbox-value-changed', function (event, value) {
                    if (starbox.hasClass('random')) {
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
<div class="banner-top">
    <div class="container">
        <h1>Checkout</h1>
        <em></em>
        <h2><a href="index.php">Home</a><label>/</label><a href="checkout.php">Checkout</a></h2>
    </div>
</div>
<!--login-->
<div class="container">
    <div class="check-out" style="margin-bottom: 20px;">
        <div class="bs-example4" data-example-id="simple-responsive-table">
            <div class="table-responsive">
                <table class="table-heading simpleCart_shelfItem">
                    <tr>
                        <th class="table-grid">Item</th>

                        <th>Prices</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php
                    while ($item = $cart_products->fetchObject())
                    {
                        if ($item->offer_price > 0)
                        {
                            $off_price = ($item->offer_price * $item->price) / 100;
                            $price = $item->price - $off_price;
                        }
                        else
                        {
                            $price = $item->price;
                        }
                        ?>
                        <tr class="cart-header">

                            <!--<td class="ring-in"><a href="single.php" class="at-in"><img src="./uploads/<?/*= $item->img1 */?>" class="img-responsive" alt=""></a>-->
                                <div class="sed">
                                    <h5>
                                        <a href="http://localhost/petShop/product.php?product_id=<?= $item->product_id ?>"><?= $item->title ?></a>
                                    </h5>
                                    <p>(<?= $item->overview ?>) </p>

                                </div>
                                <div class="clearfix"></div>
                                <?php
                                if ($profile_cart)
                                {
                                    ?>
                                    <a href="act/cart.php?remove_product=&product=<?= $item->id ?>">
                                        <div class="close1"></div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>BDT <?= $price ?>
                                <input type="hidden" id="pro<?= $item->id ?>" value="<?= $price ?>">
                            </td>
                            <td>
                                <div class="quantity">
                                    <div class="quantity-select">
                                        <div onclick="valueMinus(<?= $item->id ?>)" class="entry value-minus">&nbsp;
                                        </div>
                                        <div id="<?= $item->id ?>" class="entry value"><?= $item->quantity ?></div>
                                        <div onclick="valuePlus(<?= $item->id ?>)" class="entry value-plus active">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="item_price">BDT
                                <span id="cart-price<?= $item->id ?>">
                                        <?php
                                        $total_amount = $price * $item->quantity;
                                        echo $total_amount;
                                        ?>
                                    </span>
                            </td>
                            <td>
                                <?php
                                if ($profile_cart)
                                {
                                    ?>
                                    <a href="act/cart.php?remove_cart=&cart=<?= $item->id ?>" class="btn btn-danger">Remove
                                        From Cart</a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class="produced">
            <?php
            if ($profile_cart)
            {
                ?>
                <a href="./order.php" class="hvr-skew-backward">Produced To Buy</a>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<!--//login-->

<!--//content-->
<!--//footer-->
<?php include 'include/footer.php'; ?>
<!--//footer-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="js/simpleCart.min.js"></script>
<!-- slide -->
<script src="js/bootstrap.min.js"></script>

<script>
    function valuePlus(id) {
        console.log()
        ele = $("#" + id);
        newVal = parseInt(ele.text(), 10) + 1;
        ele.text(newVal);
        price = $("#pro" + id).val();
        $("#cart-price" + id).text(newVal * price);

        $.get('./act/cart.php?plus=' + id);
    }

    function valueMinus(id) {
        console.log()
        ele = $("#" + id);
        newVal = parseInt(ele.text(), 10) - 1;
        if (newVal > 0) {
            ele.text(newVal);
            price = $("#pro" + id).val();
            $("#cart-price" + id).text(newVal * price);
            $.get('./act/cart.php?minus=' + id);
        }
    }
</script>

</body>

</html>
