<?php
session_start();
include('back/include/config.php');

if (isset($_POST['reset']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $question = $_POST['question'];
    $ans = $_POST['ans'];

    $stmt = $db->prepare("SELECT id FROM users WHERE email=? AND question_id=? AND ans=?");
    $stmt->execute([
        $email,
        $question,
        $ans
    ]);

    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("UPDATE users SET password=? WHERE email=? AND question_id=? AND ans=?");
        $stmt->execute([
            $password,
            $email,
            $question,
            $ans
        ]);
    }
    header("Location: ./login.php");
    exit();
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
        <h1>Reset Password</h1>
        <em></em>
        <h2><a href="index.php">Home</a><label>/</label><a href="#">Pass Reset</a></h2>
    </div>
</div>
<!--login-->
<div class="container">
    <div class="login" style="margin-bottom: 20px;">
        <form action="" method="POST">
            <div class="col-md-6 login-do">
                <div class="login-mail">
                    <input type="text" placeholder="Email" name="email" required="">
                </div>
                <div class="login-mail">
                    <input type="password" placeholder="New Password" name="password" required="">
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
                    <input type="submit" value="Submit" name="reset">
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

</body>

</html>