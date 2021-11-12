<?php
session_start();
include('../back/include/config.php');

if (isset($_POST['create']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $trx = $_POST['trx'];
    $total_amount = $_POST['total_amount'];

    $stmt = $db->prepare("INSERT INTO orders(user_id, name, email, phone, address, trx_id, total_amount) VALUES(?,?,?,?,?,?,?)");
    $res = $stmt->execute([
        $_SESSION['user_id'],
        $name,
        $email,
        $phone,
        $address,
        $trx,
        $total_amount
    ]);


    if ($res)
    {
        $order_id = $db->lastInsertId();

        $carts = $db->prepare("SELECT * FROM cart WHERE user_id=? AND status=?");
        $carts->execute([
            $_SESSION['user_id'],
            1
        ]);
        while ($cart = $carts->fetchObject())
        {
            $product = $db->prepare("SELECT id, quantity from products where id='$cart->product_id'");
            $product->execute();
            $product = $product->fetchObject();

            $stmt = $db->prepare("UPDATE products SET quantity=? WHERE id=?");
            $stmt->execute([
                $product->quantity - $cart->quantity,
                $product->id
            ]);
        }

        $stmt = $db->prepare("UPDATE cart SET status=?, order_id=? WHERE user_id=? AND status=?");
        $stmt->execute([
            3,
            $order_id,
            $_SESSION['user_id'],
            1
        ]);
    }
}

header("Location: ../index.php");
exit();