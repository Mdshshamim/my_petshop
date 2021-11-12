<?php
session_start();
include('back/include/config.php');

if (isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id, user_type, name, status FROM users WHERE email=? AND password=?");
    $stmt->execute([
        $email,
        $password
    ]);

    if ($stmt->rowCount() > 0)
    {

        $user = $stmt->fetchObject();

        if ($user->status == 1)
        {
            $_SESSION["user_id"] = $user->id;
            $_SESSION['user_type'] = $user->user_type;
            $_SESSION['username'] = $user->name;

            if ($user->user_type == 'user')
            {
                header('Location:index.php');
            }
            else
            {
                header('Location:back/index.php');
            }
            exit();
        }
        else
        {
            $_SESSION['error'] = "Your Profile are Deactive.";
        }

    }
    else
    {
        $_SESSION['error'] = "Email or Password Not Valid.";
    }
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
        <h1>Login</h1>
        <em></em>
        <h2><a href="index.php">Home</a><label>/</label><a href="login.php">Login</a></h2>
    </div>
</div>
<!--login-->
<div class="container">
    <div class="login" style="margin-bottom:20px;">
        <form method="post" action="">
            <div class="col-md-6 login-do">
                <div class="login-mail">
                    <input type="text" placeholder="Email" name="email" required="" value="">
                    <i class="glyphicon glyphicon-envelope"></i>
                </div>
                <div class="login-mail">
                    <input type="password" placeholder="Password" name="password" required="" value="">
                    <i class="glyphicon glyphicon-lock"></i>
                </div>
                <a class="news-letter " href="./pass_reset.php">
                    <label class="checkbox1">Forget Password</label>
                </a>
                <label class="hvr-skew-backward">
                    <input type="submit" value="login" name="login">
                </label>
            </div>
            <div class="col-md-6 login-right">
                <h3>Completely Free Account</h3>

                <p>Welcome to our shop. <br> If you don't have any account, fill free to open a account for ordering our
                    products.</p>
                <a href="register.php" class=" hvr-skew-backward">Register</a>

            </div>

            <div class="clearfix"></div>
        </form>
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

</body>

</html>