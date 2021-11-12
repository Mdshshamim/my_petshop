<?php
session_start();
include('back/include/config.php');


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
                <h3>Contact Us</h3>
                <p>For order status inquiry,

                    To cancel and return ordered items, please log-in with your account

                    For other concerns, feel free to visit our Help Center Page </p>


                <div class="address">
                    <div class=" address-grid">
                        <i class="glyphicon glyphicon-map-marker"></i>
                        <div class="address1">
                            <h3>Address</h3>
                            <p>South khulsi,CTG
                                TL 01836614037</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class=" address-grid ">
                        <i class="glyphicon glyphicon-phone"></i>
                        <div class="address1">
                            <h3>Our Phone:</h3>
                            <p>+88001782559399</p>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class=" address-grid ">
                        <i class="glyphicon glyphicon-envelope"></i>
                        <div class="address1">
                            <h3>Email:</h3>
                            <p><a href="mailto:Mdshshamim.cse@gmail.com">Mdshshamim.cse@gmail.com</a></p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class=" address-grid ">
                        <i class="glyphicon glyphicon-bell"></i>
                        <div class="address1">
                            <h3>Open Hours:</h3>
                            <p>7/24</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 contact-top">
                <h3>Want to work with me?</h3>
                <form action="act/contact_store.php" method="post">
                    <div>
                        <span>Your Name </span>
                        <input name="name" type="text" value="" placeholder="Your Name">
                    </div>
                    <div>
                        <span>Your Email </span>
                        <input name="email" type="text" value="" placeholder="Your Email">
                    </div>
                    <div>
                        <span>Subject</span>
                        <input name="subject" type="text" value="" placeholder="Subject Name">
                    </div>
                    <div>
                        <span>Your Message</span>
                        <textarea name="message" placeholder="Your Message"></textarea>
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
