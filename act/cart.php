<?php
ob_start();
session_start();
include("../back/include/config.php");

if (!isset($_SESSION['user_type']) || !isset($_SESSION['user_id']))
{
    $_SESSION['error'] = 'You must Login First.';
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['add']) && isset($_GET['product']) && !empty($_GET['product']))
{
    $stmt = $db->prepare("SELECT id, quantity FROM cart WHERE user_id=? AND product_id=? AND status=?");
    $stmt->execute([
        $_SESSION['user_id'],
        $_GET['product'],
        1
    ]);
    if ($stmt->rowCount() > 0)
    {
        $v_cart = $stmt->fetchObject();
        $quantity = $v_cart->quantity;
        $quantity++;
        $stmt = $db->prepare("UPDATE cart SET quantity=? WHERE id=?");
        $stmt->execute([
            $quantity,
            $v_cart->id
        ]);
    } else
    {
        $stmt = $db->prepare("INSERT INTO cart(user_id, product_id, quantity) VALUES(?,?,?)");
        $res = $stmt->execute([
            $_SESSION['user_id'],
            $_GET['product'],
            1
        ]);
    }
}

if (isset($_GET['remove_cart']) && isset($_GET['cart']) && !empty($_GET['cart']))
{
    $cart_id = $_GET['cart'];

    $stmt = $db->prepare("SELECT id FROM cart WHERE id='$cart_id'");
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("UPDATE cart SET status=? WHERE id=?");
        $stmt->execute([
            2,
            $cart_id
        ]);
    }
    header("Location: ../checkout.php");
    exit();
}

if (isset($_GET['remove_product']) && isset($_GET['product']) && !empty($_GET['product']))
{
    $cart_id = $_GET['product'];

    $stmt = $db->prepare("SELECT id, quantity FROM cart WHERE id='$cart_id'");
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $cart = $stmt->fetchObject();
        $quantity = $cart->quantity;
        $quantity -= 1;
        if ($quantity == 0)
        {
            $stmt = $db->prepare("UPDATE cart SET status=? WHERE id=?");
            $stmt->execute([
                2,
                $cart_id
            ]);
        } else
        {
            $stmt = $db->prepare("UPDATE cart SET quantity=? WHERE id=?");
            $stmt->execute([
                $quantity,
                $cart_id
            ]);
        }
    }
    header("Location: ../checkout.php");
    exit();
}

if (isset($_GET['empty']))
{
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'user')
    {
        header("Location: ../login.php");
        exit();
    }
    $stmt = $db->prepare("SELECT id FROM cart WHERE user_id=? AND status=?");
    $stmt->execute([
        $_SESSION['user_id'],
        1
    ]);
    if ($stmt->rowCount() > 0)
    {
        $stmt = $db->prepare("UPDATE cart SET status=? WHERE user_id=? AND status=?");
        $stmt->execute([
            2,
            $_SESSION['user_id'],
            1
        ]);
    }
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['plus']))
{
    $id = $_GET['plus'];

    $cart = $db->prepare("SELECT quantity FROM cart WHERE id=?");
    $cart->execute([$id]);

    $cart = $cart->fetchObject();
    $quantity = $cart->quantity + 1;

    $stmt = $db->prepare("UPDATE cart SET quantity=? WHERE id=?");
    $stmt->execute([
        $quantity,
        $id
    ]);
}

if (isset($_GET['minus']))
{
    $id = $_GET['minus'];

    $cart = $db->prepare("SELECT quantity FROM cart WHERE id=?");
    $cart->execute([$id]);

    $cart = $cart->fetchObject();
    $quantity = $cart->quantity - 1;

    $stmt = $db->prepare("UPDATE cart SET quantity=? WHERE id=?");
    $stmt->execute([
        $quantity,
        $id
    ]);
}

header("Location: ../products.php");
exit();
