<?php
session_start();
include('../include/config.php');

if (isset($_POST['create']))
{
    $name = $_POST['name'];

    if (empty($name))
    {
        $error = "Please enter Pet Types name.";
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("INSERT INTO types(name) VALUES(?)");
        $check = $stmt->execute([
            $name,
        ]);

        if ($check)
        {
            $success = "Pet Types information are successfully stored.";
        } else
        {
            $error = "Failed to store Pet type informations, please try again.";
        }
    }
}
else
{
    $error = "Failed to store Pet type informations, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../type_list.php");
exit();