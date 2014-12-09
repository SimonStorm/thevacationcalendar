<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">

</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Owner Instructions',  NULL, NULL); ?>

<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="3" width="75%">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Welcome New Owner!</td>
				</tr>
			</table>
		</td>
		<td colspan="1">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td><form enctype="multipart/form-data" method="post" action="Calendar.php"><input type="submit" name="NoIntro" value="Don't show welcome again"/></form></td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr>
					<td align="left">
						<h2 id="QuickOwners">Quick Start Guide for Owners</h2>
					</td>
					<td align="right">
						<a href="TutorialQuickStartOwner.php" target="_new" onclick="window.open(this.href, '','height=960,width=960');return false;"><img src="images/WatchVideo.jpg" alt="WatchVideo.jpg" width="150" height="45" border="0" align="middle" /></a>
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
					<td align="left">
						<h2 id="Owners">Instructions for Owners</h2>
					</td>
					<td align="right">
						<a href="TutorialInstrForOwners.php" target="_new" onclick="window.open(this.href, '','height=960,width=960');return false;"><img src="images/WatchVideo.jpg" alt="WatchVideo.jpg" width="150" height="45" border="0" align="middle" /></a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<p>As an Owner on TheVacationCalendar.com website, you main ability is to schedule vacations. You also have the ability to join other vacations (if permitted by other Owners), to view the bulletin board, to participate in the house blog and to manage your profile. Below are instructions for each of these functions, which are also always available to you using the <a href="Instructions.php">Need Help?</a> link at the top of the page.</p>
						<h3>calendar</h3>
		   				<p>Use the calendar to schedule, edit and delete vacations. Simply click on the first date that you are interested in and then specify the end date within the edit box that will appear. Additionally, you will be prompted to add more information such as the vacation name, the room that you want to stay in, and two other scheduling options.</p><p>These two options control how others view your vacation. If you uncheck the "Allow Visitors?" checkbox, your vacation will be displayed on the calendar without giving others the option of requesting to join. Additionally, the vacation will show zero rooms available so it will appear that the entire house is spoken for. This is the simplest way to schedule a vacation at your vacation home. The second checkbox, "Allow other Owners to book rooms?", will allow or prevent other Owners of the house from simply scheduling themselves in one of the available rooms of your vacation. This is useful when a house is shared and no single person has the ability to claim the full use of the house for any period of time. Lastly, you have the option to select various colors to easily identify your vacations.</p>
						<p>To edit your vacation, simply click on any of the calendar days of your vacation and the edit box will appear so you can make any necessary changes.</p>
						<p>The calendar screen also allows you to view the vacations that are already scheduled for your vacation home. You can navigate month by month by clicking on the month links at the top of the calendar, or you can jump quickly to a specific month by specifying the date you want to jump to and then clicking the jump button. In addition to viewing vacations scheduled, you have the ability to request to join a vacation. Simply click on a vacation name that is a link and then fill out the information at the bottom of the next page to have TheVacationCalendar.com email the Owner who scheduled the vacation that you would like to join him for all or part of the vacation.</p>
						<h3>schedule visitors</h3>
						<p>The schedule visitors screen is the location where you can specify which rooms in your vacation home are occupied for any particular day. A simple way to manage this screen is to create a visitor called "Occupied" and then add that name to any room that is occupied. Alternatively, you can use real people's names which is helpful if you want to schedule ahead of time who is going to stay in which room. This information is available to all Owners and Guests when they click on the vacation name from the calendar.</p>
						<h3>managing visitors</h3>
						<p>The managing visitors screen is where you go to create new visitors that will show up in select box on the schedule visitors page. By default, all other Owners are automatically put into this list. Additionally, the house administrator has the ability to add visitors that will be available to all of the Owners. Any visitors that you add yourself, will only be available to you when you are scheduling visitors.</p>
						<h3>blog</h3>
						<p>The house blog is the location where conversations between all the different users of TheVacationCalendar.com website for your individual vacation home can take place. When you first access the screen the initial blogs are shown. By clicking the "Read Comments" link you can see what comments have been added to that thread. Additionally, you can add a comment to any thread by clicking the "Add Comment Link". Finally, if you want to start a new topic, you can click the "Add a New Blog" at the top of the page.</p>
						<h3>bulletin board</h3>
						<p>This is a simple screen that allows you to view information about the vacation home. If you have any updates or suggestions for this page, please contact your house administrator who has the ability to make changes.</p>
						<h3>manage account</h3>
						<p>It is important to note that your email address is used whenever someone requests to join a vacation that you scheduled. You can keep you email address up to date on this page. Additionally, if you need to change you password you can do this here as well.</p>
					</td>
				</tr>
			</table>	
		</td>
	</tr>	
</table>
<?php include("Footer.php") ?>


</body>
</html>
