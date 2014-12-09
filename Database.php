<?php
$db_host='localhost';
$db_database='BeachHouse';
$db_username='root';
$db_password='root';


try {
    $connection = new PDO('mysql:host=localhost;dbname=BeachHouse;charset=utf8', 'root', 'root');
} catch(PDOException $ex) {
    echo "Could not connect to the database: <br />"; 
    echo $ex->getMessage();
}


?>


