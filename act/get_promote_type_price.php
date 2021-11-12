<?php

//To Handle Session Variables on This Page
session_start();
//Including Database Connection From db.php file to avoid rewriting in all files

include('../include/config.php');


if (isset($_GET['promote_type']))
{
    $types = $db->query("SELECT price FROM promote_types WHERE id='$_GET[promote_type]'");
    $type = $types->fetch();
    echo $type['price'];
}