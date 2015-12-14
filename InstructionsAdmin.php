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
<?php ActivityLog('Info', curPageURL(), 'Administrator Instructions',  NULL, NULL); ?>

<div class="container vacation">	
  <div>
	  <h2 class="featurette-heading">Welcome New Administrator!</h2>
	  <form class="form-signin" role="form" enctype="multipart/form-data" method="post" action="Calendar.php">
		<button type="submit" name="NoIntro" value="Don't show welcome again" class="btn btn-success">Don't show welcome again</button>
	  </form>
 </div>

<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr>
					<td align="left" colspan="2">
						<h2 style="float:left" id="QuickAdmins">Quick Start Guide for Administrators</h2>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<p>Here are the steps to quickly get your house up and running quickly. For a more thorough understanding of the website please scroll down to see the full Instructions for Administrators or <a href="Instructions.php#Admins">click here</a>. Please note the <a href="Instructions.php">Need Help?</a> link at the top right which has a complete instruction guide to TheVacationCalendar.com.</p>
						<h3>1 - Set up administrator capabilities</h3>
						<p>Use the manage account screen to decide whether you, as an administrator, also want to be able to schedule vacations as an owner. If you do, simply check the "Allow Administrator to have Owner permissions" checkbox and click the update button.</p>
						<h3>2 - Create owners</h3>
						<p>Use the administer users screen to create usernames and passwords for the people that need to be able to schedule vacations.</p>
						<h3>3 - Have fun and tell your friends</h3>
						<p>Feel free to share the name of your vacation home and the guest password to as many people as you like. This will give them basic access to see the activity in your vacation home.</p>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<h2 style="float:left" id="Admins">Instructions for Administrators</h2>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<p>As an Administrator on TheVacationCalendar.com website, your responsibility is to set up the house, set up users, and monitor the content.</p>
						<h3>calendar</h3>
		   				<p>Use the calendar to schedule, edit and delete vacations. Simply click on the first date that you are interested in and then specify the end date within the edit box that will appear. Additionally, you will be prompted to add the vacation name.</p><p>Lastly, you have the option to select various colors to easily identify your vacations.</p>
						<p>To edit your vacation, simply click on any of the calendar days of your vacation and the edit box will appear so you can make any necessary changes.</p>
						<p>The calendar screen also allows you to view the vacations that are already scheduled for your vacation home. You can navigate month by month by clicking on the month links at the top of the calendar, or you can jump quickly to a specific month by specifying the date you want to jump to and then clicking the jump button. In addition to viewing vacations scheduled, you have the ability to request to join a vacation. Simply click on a vacation name that is a link and then fill out the information at the bottom of the next page to have TheVacationCalendar.com email the Owner who scheduled the vacation that you would like to join him for all or part of the vacation.</p>
						<h3>blog</h3>
						<p>The house blog is the location where conversations between all the different users of TheVacationCalendar.com website for your individual vacation home can take place. When you first access the screen the initial blogs are shown. By clicking the "Read Comments" link you can see what comments have been added to that thread. Additionally, you can add a comment to any thread by clicking the "Add Comment Link". Finally, if you want to start a new topic, you can click the "Add a New Blog" at the top of the page. One function that is available to the Administrator that is not available to any other user is the ability to delete blogs. You can use this to keep the blog screen tidy or to remove any inappropriate content.</p>
		   				<h3>administer users</h3>
						<p>The administer users screen is the most important screen for the house administrator. This is where you create Owners of the house and give them access to the website. You are responsible for setting their initial password which the Owners can change themselves once they have accessed the website. You have the choice of setting up a new Owner with a confirmed account, or you can require that the Owner confirms the account before it can be used. In the latter case, an email is generated and is sent to the Owner's email account. The Owner then needs to open the email and click on the confirmation link which will activate the account. <strong>Please note that these confirmation emails almost always end up in junk mail. </strong></p>
						<h3>delete vacations</h3>
						<p>The delete vacations screen is used to delete scheduled vacations. This can be used to resolve any conflicts or allow for changes in the case that someone is abusing the website.</p>
						<h3>manage bulletin board</h3>
						<p>The manage bulletin board screen is another important screen for the administrator. Only the administrator has the ability to add content here which is available to all of the Owners and Guests. This is a great place to include house rules, driving instructions, favorite restaurants, and emergency contact information. Remember to save often.</p>
						<h3>bulletin board</h3>
						<p>This is a simple screen that allows you to view information about the vacation home. If you have any updates or suggestions for this page, please contact your house administrator who has the ability to make changes.</p>
						<h3>manage account</h3>
						<p>The manage account screen for the Administrator has several options that are not available to other users. The most important option is whether you would like to have a single account to perform administrative and owner tasks. If you are the house administrator and want to be able to schedule vacations using the same login, select the "Allow Administrator to have Owner permissions" checkbox. </p><p>Like other users you can keep you email address and password up to date. In addition you have the ability to unsubscribe from TheVacationCalendar.com website, change the Guest password for your vacation home, and update the picture that shows up in the top right corner of the website.</p>
					</td>
				</tr>
			</table>	
		</td>
	</tr>	
</table>

</div>
</div>

<?php include("Footer.php") ?>


</body>
</html>
