<?php
session_start();
include('../include/config.php');

if (isset($_POST['update']))
{
    $categorie_id = $_POST['categorie_id'];
    $name = $_POST['name'];

    if (empty($name))
    {
        $error = "Please enter Pet Categories name.";
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
    }

    if (!isset($error))
    {
        $stmt = $db->prepare("UPDATE categories SET name=? WHERE id=?");
        $check = $stmt->execute([
            $name,
            $categorie_id
        ]);

        if ($check)
        {
            $success = "Pet Categories information are successfully Updated.";
        }
        else
        {
            $error = "Failed to Update Pet category informations, please try again.";
        }
    }
} else
{
    $error = "Failed to Update Pet category informations, please try again.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
    header("Location: ../categorie_edit.php?categorie_id=$categorie_id");
} else
{
    $_SESSION['success'] = $success;
    header("Location: ../categorie_list.php");
}

exit();