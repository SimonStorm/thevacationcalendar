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
<?php ActivityLog('Info', curPageURL(), 'Administrator Instructions',  NULL, NULL); ?>

<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="3" width="75%">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Welcome New Administrator!</td>
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
						<h2 id="QuickAdmins">Quick Start Guide for Administrators</h2>
					</td>
					<td align="right">
						<a href="TutorialQuickStartAdmin.php" target="_new" onclick="window.open(this.href, '','height=960,width=960');return false;"><img src="images/WatchVideo.jpg" alt="WatchVideo.jpg" width="150" height="45" border="0" align="middle" /></a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<p>Here are the steps to quickly get your house up and running quickly. For a more thorough understanding of the website please scroll down to see the full Instructions for Administrators or <a href="Instructions.php#Admins">click here</a>. Please note the <a href="Instructions.php">Need Help?</a> link at the top right which has a complete instruction guide to TheVacationCalendar.com.</p>
						<h3>1 - Set up administrator capabilities</h3>
						<p>Use the manage account screen to decide whether you, as an administrator, also want to be able to schedule vacations as an owner. If you do, simply check the "Allow Administrator to have Owner permissions" checkbox and click the update button.</p>
						<h3>2 - Create owners</h3>
						<p>Use the administer users screen to create usernames and passwords for the people that need to be able to schedule vacations.</p>
						<h3>3 - Define the rooms</h3>
						<p>Use the manage rooms to specify how many bedrooms your vacation home has. Don't forget, you can skip this step if you want to really simplify TheVacationCalendar.com for your friends and family. Without rooms defined your Owners will simply schedule when they are using the vacation home.</p>
						<h3>4 - Have fun and tell your friends</h3>
						<p>Feel free to share the name of your vacation home and the guest password to as many people as you like. This will give them basic access to see the activity in your vacation home.</p>
					</td>
				</tr>
				<tr>
					<td align="left">
						<h2 id="Admins">Instructions for Administrators</h2>
					</td>
					<td align="right">
						<a href="TutorialInstrForAdmins.php" target="_new" onclick="window.open(this.href, '','height=960,width=960');return false;"><img src="images/WatchVideo.jpg" alt="WatchVideo.jpg" width="150" height="45" border="0" align="middle" /></a>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						<p>As an Administrator on TheVacationCalendar.com website, your responsibility is to set up the house, set up users, and monitor the content.</p>
						<h3>calendar</h3>
		   				<p>Use the calendar to schedule, edit and delete vacations. Simply click on the first date that you are interested in and then specify the end date within the edit box that will appear. Additionally, you will be prompted to add more information such as the vacation name, the room that you want to stay in, and two other scheduling options.</p><p>These two options control how others view your vacation. If you uncheck the "Allow Visitors?" checkbox, your vacation will be displayed on the calendar without giving others the option of requesting to join. Additionally, the vacation will show zero rooms available so it will appear that the entire house is spoken for. This is the simplest way to schedule a vacation at your vacation home. The second checkbox, "Allow other Owners to book rooms?", will allow or prevent other Owners of the house from simply scheduling themselves in one of the available rooms of your vacation. This is useful when a house is shared and no single person has the ability to claim the full use of the house for any period of time. Lastly, you have the option to select various colors to easily identify your vacations.</p>
						<p>To edit your vacation, simply click on any of the calendar days of your vacation and the edit box will appear so you can make any necessary changes.</p>
						<p>The calendar screen also allows you to view the vacations that are already scheduled for your vacation home. You can navigate month by month by clicking on the month links at the top of the calendar, or you can jump quickly to a specific month by specifying the date you want to jump to and then clicking the jump button. In addition to viewing vacations scheduled, you have the ability to request to join a vacation. Simply click on a vacation name that is a link and then fill out the information at the bottom of the next page to have TheVacationCalendar.com email the Owner who scheduled the vacation that you would like to join him for all or part of the vacation.</p>
						<h3>blog</h3>
						<p>The house blog is the location where conversations between all the different users of TheVacationCalendar.com website for your individual vacation home can take place. When you first access the screen the initial blogs are shown. By clicking the "Read Comments" link you can see what comments have been added to that thread. Additionally, you can add a comment to any thread by clicking the "Add Comment Link". Finally, if you want to start a new topic, you can click the "Add a New Blog" at the top of the page. One function that is available to the Administrator that is not available to any other user is the ability to delete blogs. You can use this to keep the blog screen tidy or to remove any inappropriate content.</p>
						<h3>manage rooms</h3>
		   				<p>The manage rooms screen is where you create and label rooms in your vacation home. You should really only add rooms once and you should be very careful about deleting rooms. During the first time setup it is important to define the rooms in the house. You can come back and update room names and amenities at any time, however if you delete a room it will delete all occurrences of that room in your Owner's scheduled vacations. Even if you delete and add the room back with the same name, any visitors scheduled in the original room will be lost.</p><p>One important feature of this page is that if you do not schedule any rooms, Owners will not have the schedule visitors or manage visitors screens available to them. This is a good way to reduce the complexity of the site if you find that your Owners find the house too complicated.</p>
						<h3>managing visitors</h3>
						<p>The managing visitors screen is where you go to create new visitors that will show up in select box on the schedule visitors page. As the house administrator any visitors  that you add will be available to all of the Owners.</p>
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
<?php include("Footer.php") ?>


</body>
</html>
