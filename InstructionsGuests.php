<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">		
	<title>The Vacation Calendar</title>
	<link href="css/BeachStyle.css" rel="stylesheet" type="text/css" />		
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
	<link href="css/lightbox.css" rel="stylesheet" />
</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Guest Instructions',  NULL, NULL); ?>

<div class="container vacation">	
  <div>
	  <h2 class="featurette-heading">Welcome New Guest!</h2>
 </div>

<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr>
					<td align="left">
						<h2 id="Guests">Instructions for Guests</h2>
						<p>As an Guest of TheVacationCalendar.com website, you are able to see the vacation schedule of the vacation home. You have the ability to request to join vacations (if permitted by the Owners), to view the bulletin board, and to participate in the house blog. Below are instructions for each of these functions, which are also always available to you using the <a href="Instructions.php">Need Help?</a> link at the top of the page.</p>
						<h3>calendar</h3>
						<p>The calendar screen allows you to view the vacations that are already scheduled for your vacation home. You can navigate month by month by clicking on the month links at the top of the calendar, or you can jump quickly to a specific month by specifying the date you want to jump to and then clicking the jump button. In addition to viewing vacations scheduled, you have the ability to request to join a vacation. Simply click on a vacation name that is a link and then fill out the information at the bottom of the next page to have TheVacationCalendar.com email the Owner who scheduled the vacation that you would like to join him for all or part of the vacation.</p>
						<h3>blog</h3>
						<p>The house blog is the location where conversations between all the different users of TheVacationCalendar.com website for your individual vacation home can take place. When you first access the screen the initial blogs are shown. By clicking the "Read Comments" link you can see what comments have been added to that thread. Additionally, you can add a comment to any thread by clicking the "Add Comment Link". Finally, if you want to start a new topic, you can click the "Add a New Blog" at the top of the page.</p>
						<h3>bulletin board</h3>
						<p>This is a simple screen that allows you to view information about the vacation home. If you have any updates or suggestions for this page, please contact your house administrator who has the ability to make changes.</p>
					</td>
				</tr>
			</table>	
		</td>
	</tr>	
</table>
<?php include("Footer.php") ?>
</div>

</body>
</html>
