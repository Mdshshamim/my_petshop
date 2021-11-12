<?php
/*My Pet's Database*/
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shop";

$dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name;
try
{
    $db = new PDO($dsn, $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOEXCEPTION $e)
{
    $e->getMessage();
}

?>
