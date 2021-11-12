<?php
session_start();
include('../include/config.php');

// <!-- 1 for active, 2 for deactive, 3 for rejected -->

if (isset($_GET['confirm_id']))
{
    $payment_id = $_GET['confirm_id'];

    $stmt = $db->prepare("UPDATE orders SET status=1 WHERE id='$payment_id'");
    $stmt->execute();

    $order = $db->prepare("SELECT user_id FROM orders WHERE id='$payment_id'");
    $order->execute();

    $order = $order->fetchObject();

    $notis = $db->prepare("INSERT INTO notifications(user_id, message) VALUES(?,?)");
    $notis->execute([
        $order->user_id,
        "Your Order are approved."
    ]);
}

if (isset($_GET['reject_id']))
{
    $payment_id = $_GET['reject_id'];

    $stmt = $db->prepare("UPDATE orders SET status=3 WHERE id='$payment_id'");
    $stmt->execute();

    $order = $db->prepare("SELECT user_id FROM orders WHERE id='$payment_id'");
    $order->execute();

    $order = $order->fetchObject();

    $notis = $db->prepare("INSERT INTO notifications(user_id, message) VALUES(?,?)");
    $notis->execute([
        $order->user_id,
        "Your Order are rejected."
    ]);
}

header("Location: ../payments.php");
exit();