<?php
session_start();
include('back/include/config.php');

$cart_products = $db->prepare("SELECT *, cart.id FROM cart INNER JOIN products ON cart.product_id=products.id WHERE cart.user_id='$_SESSION[user_id]' && cart.status=1");
$cart_products->execute();
$total_price = 0;
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
    if ($item->quantity > 1)
    {
        $price = $price * $item->quantity;
    }
    $cart = $db->prepare("UPDATE cart SET cart_price=? WHERE id=?");
    $cart->execute([$price, $item->id]);

    $total_price += $price;
    ?>
    <?php
}

$stmt = $db->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([
    $_SESSION['user_id'],
]);
if ($stmt->rowCount() > 0)
{
    $profile = $stmt->fetchObject();
}
else
{
    header("Location: ./index.php");
    exit();
}
?>
<?php
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

    <style>
        th {
            font-size: 14px;
        }
    </style>
    <!---//End-rate---->
</head>

<body>
<!--header-->
<?php include 'include/header.php'; ?>
<!--banner-->
<div class="banner-top">
    <div class="container">
        <h1>Contact</h1>
        <em></em>
        <h2><a href="index.php">Home</a><label>/</label><a href="contact.php">Contact</a></h2>
    </div>
</div>

<div class="contact">

    <div class="contact-form">
        <div class="container">
            <div class="col-md-6 contact-left">
                <table width="100%">
                    <caption>Payment Step</caption>
                    <tr>
                        <th>STEP 1</th>
                        <th>:</th>
                        <th>Dial *247#</th>
                    </tr>
                    <tr>
                        <th>STEP 2</th>
                        <th>:</th>
                        <th>Choose Option: "Payment"</th>
                    </tr>
                    <tr>
                        <th>STEP 3</th>
                        <th>:</th>
                        <th>Enter Merchant bKash Account No: +8801836614037</th>
                    </tr>
                    <tr>
                        <th>STEP 4</th>
                        <th>:</th>
                        <th>Enter Amount: 50% of total fare</th>
                    </tr>
                    <tr>
                        <th>STEP 5</th>
                        <th>:</th>
                        <th>Enter Reference:VRS</th>
                    </tr>
                    <tr>
                        <th>STEP 6</th>
                        <th>:</th>
                        <th>Enter Counter No: 1</th>
                    </tr>
                    <tr>
                        <th>STEP 7</th>
                        <th>:</th>
                        <th>Enter Your Pin to Confirm the Transaction: XXXX</th>
                    </tr>
                    <tr>
                        <th>STEP 8</th>
                        <th>:</th>
                        <th>Submit your TrxID to complete your transaction received from bKash</th>
                    </tr>
                    <tr>
                        <th>Your Payment Amount</th>
                        <th>:</th>
                        <th>BDT <?= $total_price ?></th>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 contact-top">
                <h3>Payment Details</h3>
                <form action="act/payment.php" method="post">
                    <input type="hidden" name="total_amount" value="<?= $total_price ?>">
                    <div>
                        <span>Your Name </span>
                        <input name="name" type="text" placeholder="Your Name" value="<?= $profile->name ?>">
                    </div>
                    <div>
                        <span>Your Email </span>
                        <input name="email" type="text" placeholder="Your Email" value="<?= $profile->email ?>">
                    </div>
                    <div>
                        <span>Phone</span>
                        <input name="phone" type="text" placeholder="Phone No" value="<?= $profile->phone ?>">
                    </div>
                    <div>
                        <span>Address</span>
                        <textarea name="address" placeholder="Your Address" required></textarea>
                    </div>
                    <div>
                        <span>TRX ID</span>
                        <input name="trx" type="text" placeholder="Transection Id" required>
                    </div>
                    <label class="hvr-skew-backward">
                        <input type="submit" value="Send" name="create">
                    </label>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3689.865316684592!2d91.80870901495572!3d22.358713785293336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30acd8ed39d31fd3%3A0x198470979dca25cb!2sS%20Khulshi%20Rd%2C%20Chittagong!5e0!3m2!1sen!2sbd!4v1573556040440!5m2!1sen!2sbd"></iframe>
    </div>
</div>

<!--//contact-->

<!--//content-->
<!--//footer-->
<?php include 'include/footer.php'; ?>
<!--//footer-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="js/simpleCart.min.js"></script>
<!-- slide -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>