<?php
session_start();
include('../include/config.php');

if (isset($_GET['categorie_id']) && !empty($_GET['categorie_id']))
{
    $categorie_id = $_GET['categorie_id'];

    $categorie = $db->prepare("SELECT id FROM categories WHERE id=?");
    $categorie->execute([
        $categorie_id,
    ]);

    if ($categorie->rowCount() > 0)
    {
        $categorie = $db->prepare("DELETE FROM categories WHERE id=?");
        $check = $categorie->execute([
            $categorie_id,
        ]);

        if ($check)
        {
            $success = "Pet categories successfully deleted.";
        } else
        {
            $error = "Pet Categories does't sussfully deleted, please try again.";
        }
    } else
    {
        $error = "Sorry! Pet Categories history does't found.";
    }
}

else
{
    $error = "Pet Categories history does't found.";
}

if (isset($error))
{
    $_SESSION['error'] = $error;
} else
{
    $_SESSION['success'] = $success;
}

header("Location: ../categorie_list.php");
exit();