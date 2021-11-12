<?php
session_start();
include('../include/config.php');

if (isset($_POST['update']))
{
    $type_id = $_POST['type_id'];
    $name = $_POST['name'];

    if (empty($name))
    {
        $error = "Please enter Pet types name.";
    } else
    {
        $type = $db->prepare('SELECT id FROM types WHERE id=?');
        $type->execute([
            $type_id,
        ]);
        if ($type->rowCount() == 0)
        {
            $error = "Pet types Not Found.";
        }
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("UPDATE types SET name=? WHERE id=?");
        $check = $stmt->execute([
            $name,
            $type_id
        ]);

        if ($check)
        {
            $success = "Pet types information are successfully Updated.";
        } else
        {
            $error = "Failed to Update Pet type informations, please try again.";
        }
    }
}
else
{
    $error = "Failed to Update Pet category informations, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
    header("Location: ../type_edit.php?type_id=$type_id");
} else
{
    $_SESSION['success'] = $success;
    header("Location: ../type_list.php");
}

exit();