<?php
session_start();
include('../include/config.php');

if (isset($_POST['update']))
{
    $s_categorie_id = $_POST['s_category_id'];
    $categorie_id = $_POST['category_id'];
    $name = $_POST['name'];

    if (empty($name))
    {
        $error = "Please enter Pet Sub Categories name.";
    }

    else
    {
        $categorie = $db->prepare('SELECT id FROM categories WHERE id=?');
        $categorie->execute([
            $categorie_id,
        ]);
        if ($categorie->rowCount() == 0)
        {
            $error = "Pet Categories Not Found.";
        }

        $s_categorie = $db->prepare('SELECT id FROM s_categories WHERE id=?');
        $s_categorie->execute([
            $s_categorie_id,
        ]);
        if ($s_categorie->rowCount() == 0)
        {
            $error = "Pet Sub Categories Not Found.";
        }
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("UPDATE s_categories SET category_id=?, name=? WHERE id=?");
        $check = $stmt->execute([
            $categorie_id,
            $name,
            $s_categorie_id
        ]);

        if ($check)
        {
            $success = "Pet Sub Categories information are successfully Updated.";
        } else
        {
            $error = "Failed to Update Pet category informations, please try again.";
        }
    }
}
else
{
    $error = "Failed to Update Pet sub category informations, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
    header("Location: ../s_categorie_edit.php?categorie_id=$categorie_id");
}
else
{
    $_SESSION['success'] = $success;
    header("Location: ../s_categorie_list.php");
}

exit();