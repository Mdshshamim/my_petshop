<?php
session_start();
include('back/include/config.php');

if (isset($_POST['registration']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $account_type = $_POST['account_type'];
    $question = $_POST['question'];
    $ans = $_POST['ans'];

    $stmt = $db->prepare("SELECT id FROM users WHERE email=?");
    $stmt->execute([
        $email,
    ]);

    if ($stmt->rowCount() > 0)
    {
        $_SESSION['error'] = $email . " email are already used.";
    }
    else if ($account_type == 'user')
    {
        $stmt = $db->prepare("INSERT INTO users(name, email, phone, password, question_id, ans) VALUES(?,?,?,?,?,?)");
        $stmt->execute([
            $name,
            $email,
            $phone,
            $password,
            $question,
            $ans
        ]);
        $_SESSION['success'] = "Registration Process Success.";
        header('Location: login.php');
        exit();
    }
    else if ($account_type == 'owner')
    {

        $tln = $_POST['tln'];

        $stmt = $db->prepare("INSERT INTO users(name, email, phone, password, user_type, status, question_id, ans, tln) VALUES(?,?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $name,
            $email,
            $phone,
            $password,
            $account_type,
            2,
            $question,
            $ans,
            $tln
        ]);
        $_SESSION['success'] = "Registration Process Success.";
        header('Location: login.php');
        exit();
    }
}

$questions = $db->prepare("SELECT * FROM recover_questions");
$questions->execute();

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
    <script
            type="application/x-javascript"> addEventListener("load", function ()
        {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar()
        {
            window.scrollTo(0, 1);
        } </script>
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
        <h1>Register</h1>
        <em></em>
        <h2><a href="index.php">Home</a><label>/</label><a href="register.php">Register</a></h2>
    </div>
</div>
<!--login-->
<div class="container">
    <div class="login" style="margin-bottom: 20px;">
        <form action="" method="POST">
            <div class="col-md-6 login-do">
                <div class="login-mail">
                    <input type="text" placeholder="Name" name="name" required="">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <div class="login-mail">
                    <input type="text" placeholder="Phone Number" name="phone" required="">
                    <i class="glyphicon glyphicon-phone"></i>
                </div>
                <div class="login-mail">
                    <input type="text" placeholder="Email" name="email" required="">
                    <i class="glyphicon glyphicon-envelope"></i>
                </div>
                <div class="login-mail">
                    <input type="password" placeholder="Password" name="password" required="">
                    <i class="glyphicon glyphicon-lock"></i>
                </div>
                <div class="login-mail">
                    <select name="account_type" class="form-control" id="account_type" onchange="tln_controller(this)">
                        <option value="user" selected>User</option>
                        <option value="owner">Shop Owner</option>
                    </select>
                    <!-- <i class="glyphicon glyphicon-lock"></i> -->
                </div>
                <div class="login-mail" id="tln" style="display: none;">
                    <input type="text" placeholder="Trade License No" name="tln">
                    <i class="glyphicon glyphicon-tag"></i>
                </div>
                <div class="login-mail">
                    <select name="question" class="form-control">
                        <option value="">SELECT RECOVERY QUESTION</option>
                        <?php
                        while ($question = $questions->fetchObject())
                        {
                            ?>
                            <option value="<?= $question->id ?>"><?= $question->question ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="login-mail">
                    <input type="text" placeholder="Question ANS" name="ans" required="">
                </div>
                <label class="hvr-skew-backward">
                    <input type="submit" value="Submit" name="registration">
                </label>

            </div>
            <div class="col-md-6 login-right">
                <h3>Completely Free Account</h3>

                <p>Welcome in our Pet Shop. <br>If you have an account, please go to the login page for login in
                    our system. </p>
                <a href="login.php" class="hvr-skew-backward">Login</a>

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

<script>
    function tln_controller(ele)
    {
        val = $(ele).val();
        if (val == 'owner')
        {
            $("#tln").css('display', 'block');
        }
        else
        {
            $("#tln").css('display', 'none');
        }
    }
</script>

</body>

</html>