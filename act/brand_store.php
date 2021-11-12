<?php
session_start();
include('../include/config.php');

if (isset($_POST['create']))
{
    $name = $_POST['name'];

    if (empty($name))
    {
        $error = "Please enter Pet Brands name.";
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("INSERT INTO brands(name) VALUES(?)");
        $check = $stmt->execute([
            $name,
        ]);

        if ($check)
        {
            $success = "Pet brands information are successfully stored.";
        } else
        {
            $error = "Failed to store Pet brand informations, please try again.";
        }
    }
}

else
{
    $error = "Failed to store Pet brand informations, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../brand_list.php");
exit();