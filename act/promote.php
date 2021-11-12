<?php

session_start();

/*if (!isset($_SESSION['admin_id']))
{
    header("Location: ../login.php");
    exit();
}*/

include('../include/config.php');

if (isset($_GET['activate_id']))
{
    $starting_date = date('Y-m-d');
    $ending_date = date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . $_GET['days'] . ' days'));
    $db->query("UPDATE promote_history SET status=1, starting_date='$starting_date', ending_date='$ending_date' WHERE id='$_GET[activate_id]'");

    $promote_history = $db->query("SELECT * FROM promote_history WHERE id='$_GET[activate_id]'")->fetch();
    $db->query("UPDATE products SET promote_type_id='$promote_history[promote_type_id]' WHERE id='$promote_history[product_id]'");

    $product = $db->query("SELECT * FROM products WHERE id='$promote_history[product_id]'")->fetch();

    $stmt = $db->prepare("SELECT users.id FROM users INNER JOIN cart ON users.id=cart.user_id INNER JOIN products ON products.id=cart.product_id WHERE products.type_id=? GROUP BY users.id");
    $stmt->execute([
        $product['type_id'],
    ]);

    while ($user = $stmt->fetchObject())
    {
        $notis = $db->prepare("INSERT INTO notifications(user_id, product_id, message) VALUES(?,?,?)");
        $notis->execute([
            $user->id,
            $product['id'],
            "You favorite product !"
        ]);
    }
}

if (isset($_GET['reject_id']))
{
    $db->query("UPDATE promote_history SET status=3 WHERE id='$_GET[reject_id]'");
}

header("Location: ../promote_list.php");
exit();