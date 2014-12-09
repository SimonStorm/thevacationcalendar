<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar - Learn more about how to manage your shared vacation home, personal vacation home, or timeshare occupancy and availability. Beach House Calendar, Ski House Calendar, Mountain Home Calendar, Lake House Calendar.</title>
	<meta name="keywords" content="Online Calendar, Shared Vacation Home, Shared Vacation Calendar, Online Vacation Calendar, Vacation Calendar, Calendar, Timeshare, Condo, The Vacation Calendar, Beach House Calendar, Ski House Calendar, Mountain House Calendar, Lake House Calendar, Condo Calendar" />
	<meta name="description" content="Online calendar to manage your vacation home occupancy and availability" />
    <link href="BeachStyle.css" rel="stylesheet" type="text/css" />

</head>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Full Instructions',  NULL, NULL); ?>


<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center">
		<td colspan="2" height="45">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Instructions</td>
				</tr>
			</table>
		</td>
	</tr>
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
		   				<p>The Keep It Simple approach can be used when you want to manage your vacation home so that people simply block off time when they are using the house. The calendar will always show "Available Rooms: 0" for time that someone has booked at the house and the owners simply need to schedule the dates when they are using the house.</p>
						<p><strong>Administrator:</strong></p><p>Do not define individual rooms from the "manage rooms" screen. The only functionality that will be available to users is to schedule vacations. This will hide the menu items for "schedule visitors" and "manage visitors". </p>
						<p><strong>Owner:</strong></p><p> Your view is limited to scheduling and deleting vacations. You will still have access to the bulletin board and blog.</p>
						<h3>Dipping in your big toe</h3>
						<p>Dipping in your big toe approach can be used when you want to give the owners of the house the choice of how they manage their vacation time. Owners will be able to either block off time when they are using the house or they will be able to show that there is room for additional visitors. </p>
						<p><strong>Administrator:</strong></p><p>Define the individual rooms at your vacation home from the "manage rooms" menu. Remember, if you delete the rooms later, you are not able undo this and any visitors (or owners) that are scheduled in this room will be deleted as well.</p>
						<p><strong>Owner: </strong></p><p>You have choices when you are scheduling a vacation. </p>
						<p><i>Allow Visitors Checkbox -</i> When you select the dates you are looking for, simply uncheck the "Allow Visitors " checkbox and the calendar will show "Available Rooms: 0" to anyone who views the calendar.</p>
						<p><i>Allow Owners to Book Rooms Checkbox -</i> When you select the dates for your vacation, and you have left "Allow Visitors" checked, you can uncheck the "Allow Owners to Book Rooms" checkbox so that only you can schedule visitors during your vacation. If left checked, other Owners at the house can schedule themselves in available rooms during your vacation. </p>
						<p><i>Schedule Visitors Screen -</i> After you schedule your vacation, you will need to go to the "Schedule Visitors" screen and add people to the calendar as needed. Additional information about Visitors can be found <a href="Instructions.php#UsersRoles">here</a>. One shortcut that can be employed is to create one guest called "Occupied" and then add that to each of the rooms that is Occupied. Now you don’t have to bother with identifying who is staying in what room. </p>
						<h3>Jumping in with both feet</h3>
						<p>Jumping in with both feet approach can be used when you want to take full advantage of TheVacationCalendar.com website. </p>
						<p><strong>Administrator: </strong></p><p>Define the individual rooms at your vacation home from the "manage rooms" screen. You will also want to define visitors on the "manage visitors" screen. Visitors that are defined on this screen by an Administrator are available to all Owners.</p>
						<p><strong>Owner:</strong> </p><p>To fully use all of the functionality you should leave both the "Allow Visitors" and the "Allow Owners to Book Rooms" checkboxes checked. After you schedule your vacation, you will need to go to the "Schedule Visitors" screen and add people to the specific rooms during the dates they are joining you. If you are adding common visitors to the house that other Owners may use, you should ask the Administrator to add them for you so that other Owners will have access to those visitors as well. </p>
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
						<h3>Visitor</h3>
						<p>Visitors are a unique (and optional) type of entity on the website. The only purpose of visitors is to correctly identify who is staying in a particular room on any given date. Visitors do not have unique website credentials, but instead would use the Guest password.</p>
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
</body>
</html>
