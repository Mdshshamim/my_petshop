<?php
ob_start();
session_start();
include("../back/include/config.php");

$stmt = $db->prepare("SELECT users.id FROM users INNER JOIN cart ON users.id=cart.user_id INNER JOIN products ON products.id=cart.product_id WHERE products.type_id=? GROUP BY users.id");
$stmt->execute([
    11,
]);

echo $stmt->rowCount();