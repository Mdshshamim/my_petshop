<?php

session_start();


/*
if (!isset($_SESSION['admin_id']))
{
    header("Location: ../login.php");
    exit();
}*/

include('../include/config.php');

if (isset($_POST['create']))
{
    $name = $_POST['name'];
    $price = $_POST['price'];
    $days = $_POST['days'];

    $res = $db->query("INSERT INTO promote_types(name, price) VALUES('$name', '$price')");

    if ($res)
    {
        $_SESSION['success'] = "Successfully Create Promote Type";
        header('Location: ../promote_type_list.php');
    }

    else
    {
        $_SESSION['error'] = "Promote type not create successfully, please try again.";
        header("Location: ../promote_type_create.php");
    }

    exit();
}

if (isset($_POST['update']))
{
    $promote_type_id = $_POST['promote_type_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $days = $_POST['days'];

    $res = $db->query("UPDATE promote_types SET name='$name', price='$price' WHERE id='$promote_type_id'");

    if ($res)
    {
        $_SESSION['success'] = "Successfully Update Promote Type";
        header('Location: ../promote_type_list.php');
    } else
    {
        $_SESSION['error'] = "Promote type not Update successfully, please try again.";
        header("Location: ../promote_type_edit.php?promote_type_id=$promote_type_id");
    }

    exit();
}

if (isset($_GET['delete_id']))
{
    $res = $db->query("DELETE FROM promote_types WHERE id='$_GET[delete_id]'");

    if ($res)
    {
        $_SESSION['success'] = "Successfully Delete Promote Type";
        header('Location: ../promote_type_list.php');
    } else
    {
        $_SESSION['error'] = "Promote type not Delete successfully, please try again.";
        header("Location: ../promote_type_list.php");
    }

    exit();
}

header("Location: ../property_list.php");
exit();