<?php
session_start();
include('../include/config.php');

if (isset($_POST['create']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id FROM users WHERE email=?");
    $stmt->execute([
        $email,
    ]);

    if ($stmt->rowCount() > 0)
    {
        $_SESSION['error'] = $email . " email are already used.";
        header('Location: ../owner_list.php');
        exit();
    } else
    {
        $stmt = $db->prepare("INSERT INTO users(name, email, phone, password, user_type) VALUES(?,?,?,?,?)");
        $stmt->execute([
            $name,
            $email,
            $phone,
            $password,
            'owner'
        ]);
        $_SESSION['success'] = "Pet Owner store Success.";
        header('Location: ../owner_list.php');
        exit();
    }
}

if (isset($_POST['update']))
{
    $owner_id = $_POST['owner_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id FROM users WHERE id=?");
    $stmt->execute([
        $owner_id,
    ]);

    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("UPDATE users SET name=?, email=?, phone=?, password=? WHERE id=?");
        $stmt->execute([
            $name,
            $email,
            $phone,
            $password,
            $owner_id
        ]);
        $_SESSION['success'] = "Pet Owner Profile Successfully Updated.";
        header('Location: ../owner_list.php');
        exit();
    } else
    {
        $_SESSION['error'] = "Pet Owner Profile Not Found.";
        header('Location: ../owner_list.php');
        exit();
    }
}

if (isset($_GET['delete_id']))
{
    $stmt = $db->prepare("SELECT id FROM users WHERE id=? AND user_type=?");
    $stmt->execute([
        $_GET['delete_id'],
        'owner'
    ]);
    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("DELETE FROM users WHERE id=?");
        $stmt->execute([
            $_GET['delete_id'],
        ]);
        $_SESSION['success'] = "Pet Owner successfully deleted.";
        header('Location: ../owner_list.php');
        exit();
    } else
    {
        $_SESSION['error'] = "Pet Owner not found.";
        header('Location: ../owner_list.php');
        exit();
    }
}

if (isset($_GET['active_id']))
{
    $stmt = $db->prepare("SELECT id FROM users WHERE id=? AND user_type=?");
    $stmt->execute([
        $_GET['active_id'],
        'owner'
    ]);

    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("UPDATE users SET status=? WHERE id=?");
        $stmt->execute([
            1,
            $_GET['active_id'],
        ]);
        $_SESSION['success'] = "Pet Owner Account are Activated.";
        header('Location: ../owner_list.php');
        exit();
    } else
    {
        $_SESSION['error'] = "Failed to Activate Pet owner id.";
        header('Location: ../owner_list.php');
        exit();
    }
}

header('Location: ../owner_list.php');
exit();