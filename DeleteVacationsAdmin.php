<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">
</HEAD>
<body>
<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Administrator")
	{
?>
<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Administrator Delete Vacations',  NULL, NULL); ?>

<form action="Schedule.php" method="post">

<?php

$self = $_SERVER['PHP_SELF'];

//This is delete logic
if (isset($_GET["VacationId"]))
{   
	if ($_GET["Change"] == "Delete")
	{
	//Removed owner check in order to delete all guests as well
	//OwnerId = ".$_SESSION['OwnerId']." AND 
	
		$DeleteOwnerQuery = "DELETE FROM Schedule 
			WHERE HouseId = ".$_SESSION['HouseId']." 
			AND DateId >= (SELECT StartDateId FROM Vacations WHERE VacationId = ".$_GET["VacationId"].")
			AND DateId <= (SELECT EndDateId FROM Vacations WHERE VacationId = ".$_GET["VacationId"].")";

		if (!mysql_query( $DeleteOwnerQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Visitors from Vacation',  $DeleteOwnerQuery, mysql_error());
			die ("Could not delete scheduled visitors from the database: <br />". mysql_error());
		}
		
		$DeleteOwnerVacation = "DELETE FROM Vacations 
			WHERE HouseId = ".$_SESSION['HouseId']." 
			AND VacationId = ".$_GET["VacationId"];

		if (!mysql_query( $DeleteOwnerVacation ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Owner from Vacation',  $DeleteOwnerVacation, mysql_error());
			die ("Could not delete owner vacation from the database: <br />". mysql_error());
		}

		echo "Congrats you have deleted your vacation";
		echo "<meta http-equiv=\"Refresh\" content=\"1; url=EditAdmin.php\"/>";

	}
}   
?>
<?php 
	}
	else
	{
		echo "You do not have access to this page. <a href=\"index.php\">Please click here to log in.</a>";
	}
}
else
{
	echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";
}
?>
</body>
</html>
