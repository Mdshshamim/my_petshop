<?php
session_start();
include('../include/config.php');

if (isset($_GET['s_categorie_id']) && !empty($_GET['s_categorie_id']))
{
    $s_categorie_id = $_GET['s_categorie_id'];

    $s_categorie = $db->prepare("SELECT id FROM s_categories WHERE id=?");
    $s_categorie->execute([
        $s_categorie_id,
    ]);

    if ($s_categorie->rowCount() > 0)
    {
        $s_categorie = $db->prepare("DELETE FROM s_categories WHERE id=?");
        $check = $s_categorie->execute([
            $s_categorie_id,
        ]);

        if ($check)
        {
            $success = "Pet Sub Categorie successfully deleted.";
        } else
        {
            $error = "Pet Sub Ccategorie does't sussfully deleted, please try again.";
        }
    } else
    {
        $error = "Pet Sub Ccategorie histry does't found.";
    }
} else
{
    $error = "Pet Sub Ccategorie histry does't found.";
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