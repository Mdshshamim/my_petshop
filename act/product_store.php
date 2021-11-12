<?php
session_start();
include('imgUploader.php');
include('../include/config.php');

if (isset($_POST['create']))
{
    $category_id = $_POST['category'];
    $s_category_id = $_POST['sub_category'];
    $type_id = $_POST['type'];
    $brand_id = $_POST['brand'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $offer_price = $_POST['offer_price'];
    $offer_exp_date = $_POST['offer_exp_date'];
    $quantity = $_POST['quantity'];
    $overview = $_POST['overview'];
    $description = $_POST['description'];
    $additional_info = $_POST['additional_info'];

    if (empty($title))
    {
        $error = "Please enter Product Title.";
    } else if (empty($price))
    {
        $error = "Please enter Product Price.";
    } else
    {
        $stmt = $db->prepare("SELECT categories.id FROM categories INNER JOIN s_categories ON categories.id=s_categories.category_id WHERE categories.id=? AND s_categories.id=?");
        $stmt->execute([
            $category_id,
            $s_category_id
        ]);

        if ($stmt->rowCount() == 0)
        {
            $error = "Requested Category or Sub-Category not found, please try again.";
        }


        $stmt = $db->prepare("SELECT id FROM types WHERE id=?");
        $stmt->execute([
            $type_id,
        ]);

        if ($stmt->rowCount() == 0)
        {
            $error = "Requested Product Type not found, please try again.";
        }


        $stmt = $db->prepare("SELECT id FROM brands WHERE id=?");
        $stmt->execute([
            $brand_id,
        ]);

        if ($stmt->rowCount() == 0)
        {
            $error = "Requested Product Brand not found, please try again.";
        }
    }

    if (!isset($error))
    {
        $img1 = imgUploader('img1');
        $img2 = imgUploader('img2');
        $img3 = imgUploader('img3');
        $stmt = $db->prepare("INSERT INTO products(owner_id, category_id, s_category_id, title, price, offer_price, offer_exp_date, quantity, overview, description, additional_info, type_id, brand_id, img1, img2, img3) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,'$img1','$img2','$img3')");
        $check = $stmt->execute([
            $_SESSION['user_id'],
            $category_id,
            $s_category_id,
            $title,
            $price,
            $offer_price,
            $offer_exp_date,
            $quantity,
            $overview,
            $description,
            $additional_info,
            $type_id,
            $brand_id
        ]);

        if ($check)
        {
            $success = "Product information are successfully stored.";
        } else
        {
            $error = "Failed to Product informations, please try again.";
        }
    }
} else
{
    $error = "Failed to store Product informations, please try again.";
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