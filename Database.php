<?php
$db_host='localhost';
$db_database='vacation_vacal';
$db_username='vacation_vacal';
$db_password='vacation';

global $link;
$link = mysqli_connect('localhost', 'vacation_vacal', 'vacation');
mysqli_select_db($link, 'vacation_vacal');
mysqli_set_charset($link, 'UTF-8');


?>

