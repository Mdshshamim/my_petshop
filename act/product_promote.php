<?php

//To Handle Session Variables on This Page
session_start();
//Including Database Connection From db.php file to avoid rewriting in all files
include('../include/config.php');

//If user Actually clicked login button 
if (isset($_POST['create']))
{
    $product_id = $_POST['product_id'];
    $promote_type = $_POST['promote_type'];
    $promote_price = $_POST['promote_price'];
    // $paid_amount = $_POST['measurement'];
    $days = $_POST['days'];
    $total_amount = $_POST['total_amount'];
    $payment_type = $_POST['payment_type'];

    $db->query("INSERT INTO promote_history(product_id, promote_type_id, days, total_amount, payment_type) VALUES('$product_id', '$promote_type', '$days', '$total_amount', '$payment_type')");
    $id = $db->lastInsertId();
    // echo $conn->error;
    // $_SESSION['success'] = "Your promote request are pending.";
    header("Location: ../promote_payment.php?pay_id=$id");
    exit();
}

if (isset($_POST['payment']))
{
    $pay_id = $_POST['pay_id'];
    $trx_id = $_POST['trx_id'];
    $db->query("UPDATE promote_history SET trx_id='$trx_id' WHERE id='$pay_id'");
    $_SESSION['success'] = "Your Payment request are pending.";
    header("Location: ../product_list.php");
    exit();
}

header("Location: ../product_list.php");
exit();