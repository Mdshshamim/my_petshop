<?php
session_start();
include('../include/config.php');

if (isset($_POST['update']))
{
    $brand_id = $_POST['brand_id'];
    $name = $_POST['name'];

    if (empty($name))
    {
        $error = "Please enter Pet brand name.";
    } else
    {
        $brand = $db->prepare('SELECT id FROM brands WHERE id=?');
        $brand->execute([
            $brand_id,
        ]);
        if ($brand->rowCount() == 0)
        {
            $error = "Pet Brand Not Found.";
        }
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("UPDATE brands SET name=? WHERE id=?");
        $check = $stmt->execute([
            $name,
            $brand_id
        ]);

        if ($check)
        {
            $success = "Pet brands information are successfully Updated.";
        } else
        {
            $error = "Failed to Update Pet brand informations, please try again.";
        }
    }
} else
{
    $error = "Failed to Update Pet category informations, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
    header("Location: ../brand_edit.php?brand_id=$brand_id");
} else
{
    $_SESSION['success'] = $success;
    header("Location: ../brand_list.php");
}

exit();