<?php
session_start();
include('../include/config.php');

if (isset($_POST['update']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (!isset($error))
    {
        $stmt = $db->prepare("UPDATE users SET name=?, phone=?, password=? WHERE id=?");
        $check = $stmt->execute([
            $name,
            $phone,
            $password,
            $_SESSION['user_id']
        ]);

        if ($check)
        {
            $success = "Profile successfully updated.";
        } else
        {
            $error = "Failed to update profile.";
        }
    }
} else
{
    $error = "Request error.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../profile.php");
exit();