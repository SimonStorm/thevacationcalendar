<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>The Vacation Calendar</title>
    <LINK href="css/BeachStyle.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">	
	<link href="css/jquery-ui.min.css" rel="stylesheet" />	
	<link href="css/lightbox.css" rel="stylesheet" />	
    <script src="js/jquery.js"></script>	
	<script src="js/jquery-ui.min.js"></script>	
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

<div class="container vacation">	

<form action="Schedule.php" method="post">

<?php

$self = $_SERVER['PHP_SELF'];

//This is delete logic
if (isset($_GET["VacationId"]))
{   
	if ($_GET["Change"] == "Delete")
	{
		$DeleteOwnerVacation = "DELETE FROM Vacations 
			WHERE HouseId = ".$_SESSION['HouseId']." 
			AND VacationId = ".$_GET["VacationId"];
			
			if (!mysqli_query( $GLOBALS['link'],  $DeleteOwnerVacation ))
			{
				ActivityLog('Error', curPageURL(), 'Delete Scheduled Vacations',  $DeleteOwnerVacation, mysqli_error($GLOBALS['link']));
				die ("Could not delete owner vacation from the database:". mysqli_error($GLOBALS['link']));
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
</div>
</body>
</html>
