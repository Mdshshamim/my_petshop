<?php
session_start();
include('../back/include/config.php');

if (isset($_POST['create']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error = "Email address not valied.";
    } else if (empty($name))
    {
        $error = "Please enter your name.";
    } else if (empty($subject))
    {
        $error = "Please enter subject of your contact.";
    } else if (empty($message))
    {
        $error = "Please enter message of your contact.";
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("INSERT INTO contacts(name, email, subject, message) VALUES(?,?,?,?)");
        $check = $stmt->execute([
            $name,
            $email,
            $subject,
            $message
        ]);

        if ($check)
        {
            $success = "Your Contact information are successfully stored.";
        } else
        {
            $error = "Your Contact are failed, please try again.";
        }
    }
} else
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

header("Location: ../contact.php");
exit();