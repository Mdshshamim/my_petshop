<?php
ob_start();
session_start();
include("../back/include/config.php");

$stmt = $db->prepare("SELECT * FROM rattings WHERE user_id=? AND product_id=?");
$stmt->execute([
    $_SESSION['user_id'],
    $_POST['product']
]);

if ($stmt->rowCount() > 0)
{
    $stmt = $db->prepare("UPDATE rattings SET ratting=? WHERE user_id=? AND product_id=?");
    $stmt->execute([
        $_POST['value'],
        $_SESSION['user_id'],
        $_POST['product']
    ]);
} else
{
    $stmt = $db->prepare("INSERT INTO rattings(user_id, product_id, ratting) VALUES(?,?,?)");
    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['product'],
        $_POST['value']
    ]);
}

$stmt = $db->prepare("SELECT AVG(ratting) as ratting FROM rattings WHERE user_id=? AND product_id=?");
$stmt->execute([
    $_SESSION['user_id'],
    $_POST['product']
]);

if ($stmt->rowCount() > 0)
{
    $ratting = $stmt->fetchObject();
    echo sprintf("%.2f", $ratting->ratting);
} else
{
    echo "5.00";
}

?>