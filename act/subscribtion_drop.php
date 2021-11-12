<?php
session_start();
include('../include/config.php');

if (isset($_GET['subscribtion_id']) && !empty($_GET['subscribtion_id']))
{
    $subscribtion_id = $_GET['subscribtion_id'];

    $subscribtion = $db->prepare("SELECT id FROM subscribtions WHERE id=?");
    $subscribtion->execute([
        $subscribtion_id,
    ]);

    if ($subscribtion->rowCount() > 0)
    {
        $subscribtion = $db->prepare("DELETE FROM subscribtions WHERE id=?");
        $check = $subscribtion->execute([
            $subscribtion_id,
        ]);

        if ($check)
        {
            $success = "Subscribtion successfully deleted.";
        } else
        {
            $error = "Subscribtion does't sussfully deleted, please try again.";
        }
    } else
    {
        $error = "Subscribtion histry does't found.";
    }
} else
{
    $error = "Subscribtion histry does't found.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../subscribtion_list.php");
exit();