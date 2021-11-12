<?php
session_start();
include('../include/config.php');

if (isset($_GET['type_id']) && !empty($_GET['type_id']))
{
    $type_id = $_GET['type_id'];

    $type = $db->prepare("SELECT id FROM types WHERE id=?");
    $type->execute([
        $type_id,
    ]);

    if ($type->rowCount() > 0)
    {
        $type = $db->prepare("DELETE FROM types WHERE id=?");
        $check = $type->execute([
            $type_id,
        ]);

        if ($check)
        {
            $success = "Pet type successfully deleted.";
        } else
        {
            $error = "Pet type does't sussfully deleted, please try again.";
        }
    } else
    {
        $error = "Pet type histry does't found.";
    }
} else
{
    $error = "Pet type histry does't found.";
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