<?php
$driver = 'mysql';
$host = 'localhost';
$db_name = 'phonenum';
$db_user = 'root';
$db_pass = 'root';
$charset = 'utf8';
$options = [    PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION]; // =>? ::?
try {
$pdo=new PDO("mysql:host=$host;dbname-$db_name;charset=$charset",$db_user,$db_pass,$options); 
} catch (PDOException $err ) {
    die('ошибка подключения к БД');
}
//echo 'DB Connected'
?>