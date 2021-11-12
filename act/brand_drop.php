<?php
session_start();
include('../include/config.php');

if (isset($_GET['brand_id']) && !empty($_GET['brand_id']))
{
    $brand_id = $_GET['brand_id'];

    $brand = $db->prepare("SELECT id FROM brands WHERE id=?");
    $brand->execute([
        $brand_id,
    ]);

    if ($brand->rowCount() > 0)
    {
        $brand = $db->prepare("DELETE FROM brands WHERE id=?");
        $check = $brand->execute([
            $brand_id,
        ]);

        if ($check)
        {
            $success = "Pet brand successfully deleted.";
        } else
        {
            $error = "Pet brand does't deleted, please try again.";
        }
    }
    else
    {
        $error = "Pet brand history does't found.";
    }
}
else
{
    $error = "Pet brand history does't found.";
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