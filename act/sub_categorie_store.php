<?php
session_start();
include('../include/config.php');

if (isset($_POST['create']))
{
    $categorie_id = $_POST['category_id'];
    $name = $_POST['name'];

    if (empty($name))
    {
        $error = "Please enter Pet Sub Categories name.";
    } else
    {
        $categorie = $db->prepare("SELECT id FROM categories WHERE id=?");
        $categorie->execute([
            $categorie_id,
        ]);

        if ($categorie->rowCount() == 0)
        {
            $error = "Request Pet category not exist.";
        }
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("INSERT INTO s_categories(category_id, name) VALUES(?,?)");
        $check = $stmt->execute([
            $categorie_id,
            $name,
        ]);

        if ($check)
        {
            $success = "Pet Sub Categories information are successfully stored.";
        } else
        {
            $error = "Failed to store Pet sub category informations, please try again.";
        }
    }
} else
{
    $error = "Failed to store Pet sub category informations, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../s_categorie_list.php");
exit();