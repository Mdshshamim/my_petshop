<?php
session_start();
include('../back/include/config.php');

if (isset($_POST['subscribtion']))
{
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error = "Email address not valied.";
    } else
    {
        $stmt = $db->prepare("SELECT id FROM subscribtions WHERE email=?");
        $stmt->execute([
            $email,
        ]);
        if ($stmt->rowCount() > 0)
        {
            $error = "Email already used for subcribtions.";
        }
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("INSERT INTO subscribtions(email) VALUES(?)");
        $check = $stmt->execute([
            $email,
        ]);

        if ($check)
        {
            $success = "Your Subscibtion are successfully stored.";
        } else
        {
            $error = "Your Subscibtion are failed, please try again.";
        }
    }
}
else
{
    $error = "Your process wrong, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../index.php");
exit();