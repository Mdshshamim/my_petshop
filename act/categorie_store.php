<?php
session_start();
include('../include/config.php');

if (isset($_POST['create']))
{
    $name = $_POST['name'];

    if (empty($name))
    {
        $error = "Please enter Pet Categories name.";
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("INSERT INTO categories(name) VALUES(?)");
        $check = $stmt->execute([
            $name,
        ]);

        if ($check)
        {
            $success = "Pet Categories information are successfully stored.";
        } else
        {
            $error = "Failed to store Pet category informations, please try again.";
        }
    }
} else
{
    $error = "Failed to store Pet category informations, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../categorie_list.php");
exit();