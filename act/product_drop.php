<?php
session_start();
include('../include/config.php');

if (isset($_GET['product_id']) && !empty($_GET['product_id']))
{
    $product_id = $_GET['product_id'];

    $product = $db->prepare("SELECT id FROM products WHERE id=?");
    $product->execute([
        $product_id,
    ]);

    if ($product->rowCount() > 0)
    {
        $product = $db->prepare("DELETE FROM products WHERE id=?");
        $check = $product->execute([
            $product_id,
        ]);

        if ($check)
        {
            $success = "Product successfully deleted.";
        } else
        {
            $error = "Product does't sussfully deleted, please try again.";
        }
    } else
    {
        $error = "Product histry does't found.";
    }
} else
{
    $error = "Product histry does't found.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../product_list.php");
exit();