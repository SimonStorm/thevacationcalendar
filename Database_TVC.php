<?php
$db_host='localhost';
$db_database='storm_TheVacationCalendar';
$db_username='storm_vacal';
$db_password='vacation';
$connection = mysql_connect($db_host, $db_username, $db_password);

if (!$connection)
{
	die ("Could not connect to the database: <br />". mysql_error());
}

$db_select = mysql_select_db($db_database);
if (!$db_select)
{
	die ("Could not select the database: <br />". mysql_error());
}
?>


