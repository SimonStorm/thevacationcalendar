<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>The Vacation Calendar</title>
	<link href="css/BeachStyle.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">
	<link rel='stylesheet' type='text/css' href='fullcalendar/fullcalendar.css' />
	<link rel='stylesheet' type='text/css' href='fullcalendar/fullcalendar.print.css' media='print' />
	<link href="css/lightbox.css" rel="stylesheet" />
	<link href="css/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="css/jquery-ui.min.css" rel="stylesheet" />

<style type='text/css'>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width:90%;
		margin: 0 auto;
	}

</style>

</head>
<body>
<?php if (isset($_SESSION['Role']))
{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'View Calendar',  NULL, NULL); ?>


<?php

	if(isset($_POST['NoIntro']))
	{
		$NoIntroQuery = "Update user SET Intro = 'N',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."'
							WHERE user_id = ".$_SESSION['OwnerId'];

		$NoIntroResults = mysqli_query( $GLOBALS['link'],  $NoIntroQuery );
		if (!$NoIntroResults)
		{
			ActivityLog('Error', curPageURL(), 'Update User',  $NoIntroQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
		}
	}
?>

<div class="container vacation">	
  <h2 class="featurette-heading">House Calendar</h2>
  <div style="text-align:left">
	<div id='calendar'>
	</div>
</div>
</div>
	
<?php include("CreateCalendar.php") ?>

<?php include("Footer.php") ?>

<?php 
}
else
{
echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";

}
?>
</body></html>