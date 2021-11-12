<?php
session_start();
include('../back/include/config.php');

if (isset($_GET['title']))
{
    $title = $_GET['title'];

    $products = $db->prepare("SELECT *, products.id FROM products INNER JOIN categories ON products.category_id=categories.id WHERE title LIKE '%$title%' OR name LIKE '%$title%'");
    $products->execute();

    $data = ` `;
    while ($product = $products->fetchObject())
    {
        $data .= "<p><a href='./product.php?product_id=" . $product->id . "'>" . $product->title . "</a></p>";
    }

    echo $data;
}