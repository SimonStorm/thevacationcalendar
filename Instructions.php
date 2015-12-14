<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">		
	<title>The Vacation Calendar - Learn more about how to manage your shared vacation home, personal vacation home, or timeshare occupancy and availability. Beach House Calendar, Ski House Calendar, Mountain Home Calendar, Lake House Calendar.</title>
	<meta name="keywords" content="Online Calendar, Shared Vacation Home, Shared Vacation Calendar, Online Vacation Calendar, Vacation Calendar, Calendar, Timeshare, Condo, The Vacation Calendar, Beach House Calendar, Ski House Calendar, Mountain House Calendar, Lake House Calendar, Condo Calendar" />
	<meta name="description" content="Online calendar to manage your vacation home occupancy and availability" />
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
</head>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Full Instructions',  NULL, NULL); ?>

<div class="container vacation">	
  <div>
	  <h2 class="featurette-heading">Instructions</h2>
 </div>
<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr>
					<td align="left" colspan="2">
						<a href="Instructions.php#QuickAdmins">Quick Start Guide for Administrators</a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<a href="Instructions.php#QuickOwners">Quick Start Guide for Owners</a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<a href="Instructions.php#Admins">Instructions for Administrators</a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<a href="Instructions.php#Owners">Instructions for Owners</a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<a href="Instructions.php#GuestsInst">Instructions for Guests</a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<a href="Instructions.php#Ways">Different Ways to Use TheVacationCalendar.com</a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<a href="Instructions.php#UsersRoles">Understanding the Different Users and Roles</a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<h2 id="QuickAdmins">Quick Start Guide for Administrators</h2>
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
						<h2 id="QuickOwners">Quick Start Guide for Owners</h2>
						
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<p>Here are the steps to quickly get your house up and running quickly. For a more thorough understanding of the website please scroll down to see the full Instructions for Owners or <a href="Instructions.php#Owners">click here</a>. Please note the <a href="Instructions.php">Need Help?</a> link at the top right which has a complete instruction guide to TheVacationCalendar.com.</p>
						<h3>1 - Schedule a vacation</h3>
						<p>Use the vacations screen to schedule a vacation.</p>
						<h3>2 - Have fun and tell your friends</h3>
						<p>Feel free to share the name of your vacation home and the guest password (ask your house administrator for it) to as many people as you like. This will give them basic access to see the activity in your vacation home.</p>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<h2 id="Admins">Instructions for Administrators</h2>
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
				<tr>
					<td align="left" colspan="2">
						<h2 id="Owners">Instructions for Owners</h2>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<p>As an Owner on TheVacationCalendar.com website, you main ability is to schedule vacations. You also have the ability to join other vacations (if permitted by other Owners), to view the bulletin board, to participate in the house blog and to manage your profile. Below are instructions for each of these functions, which are also always available to you using the <a href="Instructions.php">Need Help?</a> link at the top of the page.</p>
						<h3>calendar</h3>
		   				<p>Use the calendar to schedule, edit and delete vacations. Simply click on the first date that you are interested in and then specify the end date within the edit box that will appear. Additionally, you will be prompted to add the vacation name.</p><p>Lastly, you have the option to select various colors to easily identify your vacations.</p>
						<p>To edit your vacation, simply click on any of the calendar days of your vacation and the edit box will appear so you can make any necessary changes.</p>
						<p>The calendar screen also allows you to view the vacations that are already scheduled for your vacation home. You can navigate month by month by clicking on the month links at the top of the calendar, or you can jump quickly to a specific month by specifying the date you want to jump to and then clicking the jump button. In addition to viewing vacations scheduled, you have the ability to request to join a vacation. Simply click on a vacation name that is a link and then fill out the information at the bottom of the next page to have TheVacationCalendar.com email the Owner who scheduled the vacation that you would like to join him for all or part of the vacation.</p>
						<h3>blog</h3>
						<p>The house blog is the location where conversations between all the different users of TheVacationCalendar.com website for your individual vacation home can take place. When you first access the screen the initial blogs are shown. By clicking the "Read Comments" link you can see what comments have been added to that thread. Additionally, you can add a comment to any thread by clicking the "Add Comment Link". Finally, if you want to start a new topic, you can click the "Add a New Blog" at the top of the page.</p>
						<h3>bulletin board</h3>
						<p>This is a simple screen that allows you to view information about the vacation home. If you have any updates or suggestions for this page, please contact your house administrator who has the ability to make changes.</p>
						<h3>manage account</h3>
						<p>It is important to note that your email address is used whenever someone requests to join a vacation that you scheduled. You can keep you email address up to date on this page. Additionally, if you need to change you password you can do this here as well.</p>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<h2 id="GuestsInst">Instructions for Guests</h2>
						<p>As an Guest of TheVacationCalendar.com website, you are able to see the vacation schedule of the vacation home. You have the ability to request to join vacations (if permitted by the Owners), to view the bulletin board, and to participate in the house blog. Below are instructions for each of these functions, which are also always available to you using the <a href="Instructions.php">Need Help?</a> link at the top of the page.</p>
						<h3>calendar</h3>
						<p>The calendar screen allows you to view the vacations that are already scheduled for your vacation home. You can navigate month by month by clicking on the month links at the top of the calendar, or you can jump quickly to a specific month by specifying the date you want to jump to and then clicking the jump button. In addition to viewing vacations scheduled, you have the ability to request to join a vacation. Simply click on a vacation name that is a link and then fill out the information at the bottom of the next page to have TheVacationCalendar.com email the Owner who scheduled the vacation that you would like to join him for all or part of the vacation.</p>
						<h3>blog</h3>
						<p>The house blog is the location where conversations between all the different users of TheVacationCalendar.com website for your individual vacation home can take place. When you first access the screen the initial blogs are shown. By clicking the "Read Comments" link you can see what comments have been added to that thread. Additionally, you can add a comment to any thread by clicking the "Add Comment Link". Finally, if you want to start a new topic, you can click the "Add a New Blog" at the top of the page.</p>
						<h3>bulletin board</h3>
						<p>This is a simple screen that allows you to view information about the vacation home. If you have any updates or suggestions for this page, please contact your house administrator who has the ability to make changes.</p>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<h2 id="Ways">Different Ways to Use TheVacationCalendar.com</h2>
						<p>TheVacationCalendar.com website was designed to try to appease as many people as possible. Initially, it built for my family when they decided they did not want to have only one person manage the "official" calendar for the beach house. But even within our family, we had all different types of users. Some loved the complexity and rich functionality, but most politely asked if there was an easier way. The website has evolved to be able to support various types of people. This guide will help you set up the house so that it meets your needs, no matter which category you fall into.</p>
						<h3>Training Wheels</h3>
						<p>The Training Wheels approach can be used when only one person is going to manage the vacation home. The users of the house can use the Guest access to view the calendar, request to join a specific vacation, view the house bulletin board and partake in the house blog.</p>
		   				<p><strong>Administrator:</strong></p><p>The Administrator should check the "Allow Administrator to have Owner permissions" checkbox and clicking the Update button on the Administrator's manage account screen. Now the Administrator can maintain the vacations and manage the entire house. The Administrator can use as much of the functionality as he/she desires.</p>
						<p><strong>Owner:</strong></p><p>No owner accounts. All other users should use the Guest password to access the calendar. </p>
						<h3>Keep It Simple</h3>
		   				<p>The Keep It Simple approach can be used when you want to manage your vacation home so that people simply block off time when they are using the house. The owners simply need to schedule the dates when they are using the house.</p>
						<p><strong>Administrator:</strong></p><p>The functionality that will be available to users is to schedule vacations.</p>
						<p><strong>Owner:</strong></p><p> Your view is limited to scheduling and deleting vacations. You will still have access to the bulletin board and blog.</p>
						<h3>Dipping in your big toe</h3>
						<p>Dipping in your big toe approach can be used when you want to give the owners of the house the choice of how they manage their vacation time. Owners will be able to either block off time when they are using the house. </p>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<h2 id="UsersRoles">Understanding the Different Users and Roles</h2>
						<p>TheVacationCalendar.com has three different types of users that can access the website.</p>
						<h3>Administrator</h3>
						<p>The Administrator is set up during the initial setup of a new vacation home on the website. This user is responsible for configuring the site to match your vacation home. Additionally, the user has the ability to add users, remove scheduled vacations, delete inappropriate blog messages, and manage the subscription. Another important role of the Administrator is to fill the House Bulletin Board with useful information.</p>
						<h3>Administrator with Owner Privledges</h3>
						<p>By checking the "Allow Administrator to have Owner permissions" checkbox and clicking the Update button on the Administrator's manage account screen, an Administrator can have both administrative capabilities and owner capabilities.</p>
						<h3>Owner</h3>
		   				<p>An Owner is set up by the Administrator. As an Owner you can reserve time at the vacation house as long as the time does not overlap with any other scheduled vacations. You have the option to simply block off time when you are using the vacation home or you can go into more detail and specify who is going to use each room on any particular date. You also have the ability to allow or prevent other Owners from adding themselves to your vacation.</p>
						<h3>Guest</h3>
						<p>A single Guest account is set up during the initial setup of a new vacation home on the website however the password can be reset easily from the "manage account" screen. This is a generic password that allows users to view the activity on the website but cannot make any changes. You should feel free to send this password out to all of your friends and family who you want to be able to see who is using your vacation home. The Guest is able to click on a vacation and request to join. This will trigger an email to be sent to the Owner who scheduled the vacation.</p>
					</td>
				</tr>
			</table>	
		</td>
	</tr>	
</table>
<?php include("Footer.php") ?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7019638-1");
pageTracker._trackPageview();
} catch(err) {}</script> 

</div>
</body>
</html>
