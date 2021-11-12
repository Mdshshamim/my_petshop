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
        header('Location: ../user_list.php');
        exit();
    } else
    {
        $stmt = $db->prepare("INSERT INTO users(name, email, phone, password, user_type) VALUES(?,?,?,?,?)");
        $stmt->execute([
            $name,
            $email,
            $phone,
            $password,
            'user'
        ]);
        $_SESSION['success'] = "User store Success.";
        header('Location: ../user_list.php');
        exit();
    }
}

if (isset($_POST['update']))
{
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id FROM users WHERE id=?");
    $stmt->execute([
        $user_id,
    ]);

    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("UPDATE users SET name=?, email=?, phone=?, password=? WHERE id=?");
        $stmt->execute([
            $name,
            $email,
            $phone,
            $password,
            $user_id
        ]);
        $_SESSION['success'] = "User Profile Successfully Updated.";
        header('Location: ../user_list.php');
        exit();
    } else
    {
        $_SESSION['error'] = "User Profile Not Found.";
        header('Location: ../user_list.php');
        exit();
    }
}

if (isset($_GET['delete_id']))
{
    $stmt = $db->prepare("SELECT id FROM users WHERE id=? AND user_type=?");
    $stmt->execute([
        $_GET['delete_id'],
        'user'
    ]);
    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("DELETE FROM users WHERE id=?");
        $stmt->execute([
            $_GET['delete_id'],
        ]);
        $_SESSION['success'] = "User successfully deleted.";
        header('Location: ../user_list.php');
        exit();
    } else
    {
        $_SESSION['error'] = "User not found.";
        header('Location: ../user_list.php');
        exit();
    }
}

if (isset($_GET['active_id']))
{
    $stmt = $db->prepare("SELECT id FROM users WHERE id=? AND user_type=?");
    $stmt->execute([
        $_GET['active_id'],
        'user'
    ]);

    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("UPDATE users SET status=? WHERE id=?");
        $stmt->execute([
            1,
            $_GET['active_id'],
        ]);
        $_SESSION['success'] = "User Account are Activated.";
        header('Location: ../user_list.php');
        exit();
    } else
    {
        $_SESSION['error'] = "Failed to Activate User id.";
        header('Location: ../user_list.php');
        exit();
    }
}

header('Location: ../user_list.php');
exit();