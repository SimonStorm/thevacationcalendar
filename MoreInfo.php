<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar - Online Calendar to Manage Your Shared Vacation Home</title>
	<meta name="keywords" content="Online Calendar, Vacation Calendar, Calendar, Shared Calendar, Shared Vacation Home, Shared Vacation, Shared Home, Shared Vacation Home, Shared Vacation Calendar, Online Vacation Calendar, Vacation Calendar, Calendar, Timeshare, Condo, The Vacation Calendar, Beach House Calendar, Ski House Calendar, Mountain House Calendar, Lake House Calendar, Condo Calendar"/>
	<meta name="description" content="Online calendar to manage your vacation home occupancy and availability. Shared Online Calendar Perfect for Shared Vacation Homes."/>
    <link href="BeachStyle.css" rel="stylesheet" type="text/css"/>

</head>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'More Info',  NULL, NULL); ?>


<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center">
		<td colspan="2" height="45">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">What is The Vacation Calendar?</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>Calendar View</h2>					
						<p class="SalesText">This is the main view of online calendar on TheVacationCalendar.com which allows everyone to see when the vacation home is in use. When a vacation is scheduled the user has the option to allow others to see if there are rooms available or the user can set the online calendar to simply show that the house is occupied. Users can choose to use color to enhance the calendar or to signify special meaning, such as "would like to trade this vacation" for different time.</p>					
					</td>
					<td colspan="2">
						<img src="images/Calendar.jpg" alt="Calendar.jpg" width="450" height="369" border="1" align="middle" />
					</td>
				</tr>	
				<tr align="center">
					<td colspan="2">
						<img src="images/BoardView.jpg" alt="BoardView.jpg" width="450" height="256" border="1" align="middle" />
					</td>
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>House Bulletin Board</h2>					
						<p class="SalesText">The House Bulletin Board is the perfect solution to that all important piece paper that is always getting misplaced. This is a great place for contact information, house instructions, rules, cleaning services, favorite restaurants, directions, etc.</p>					
					</td>
				</tr>	
				<tr align="center">
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>Managing Vacations</h2>					
						<p class="SalesText">So this is the money shot of TheVacationCalendar.com. Using this simple screen anyone who is authorized to schedule a vacation can do so. The site checks that there are no conflicts on the online calendar and prevents you from ever having multiple parties showing up at your vacation home at the same time.</p>					
					</td>
					<td colspan="2">
						<img src="images/EditVacation.jpg" alt="EditVacation.jpg" width="450" height="363" border="1" align="middle" />
					</td>
				</tr>	
				<tr align="center">
					<td colspan="2">
						<img src="images/Blog.jpg" alt="Blog.jpg" width="450" height="385" border="1" align="middle" />
					</td>
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>House Blog</h2>					
						<p class="SalesText">How have you ever lived without a vacation home blog?!?! Since the House Bulletin Board is only updated by the administrator of the house, the House Blog gives everyone a place to share thoughts, provide updates, and generally make fun of each other.</p>					
					</td>
				</tr>	
				<tr align="center">
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>House Bulletin Board Administration</h2>					
						<p class="SalesText">The House Bulletin Board is one of the most popular features of the online calendar and is easily maintained using the WYSIWYG (what you see is what you get) editor. This has all the same functions that you are accustomed to on your word processor so you can create a fun and appealing bulletin board without any coding.</p>					
					</td>
					<td colspan="2">
						<img src="images/BoardAdmin.jpg" alt="BoardAdmin.jpg" width="450" height="310" border="1" align="middle" />
					</td>
				</tr>	
				<tr align="center">
					<td colspan="2">
						<img src="images/PhotoAlbum.jpg" alt="PhotoAlbum.jpg" width="450" height="438" border="1" align="middle" />
					</td>
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>House Photo Album</h2>					
						<p class="SalesText">This is another favorite for many of the site's users. Since people were getting more and more use out of the vacation homes thanks to the online calendar system in TheVacationCalendar.com, we needed to provide a way to memorialize the great times you are having. So we added a new photo album. It is pretty simple for the first iteration, just add photos and allow anyone to comment. As always, the Administrator has the ability to remove any photos or comments that are inappropriate.</p>					
					</td>
				</tr>	
				<tr align="center">
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>Account Management</h2>					
						<p class="SalesText">This is your basic profile page that allows the administrator to update passwords, change the site picture, and {cough}{cough} cancel the subscription</p>					
					</td>
					<td colspan="2">
						<img src="images/AdminProfile.jpg" alt="AdminProfile.jpg" width="450" height="425" border="1" align="middle" />
					</td>
				</tr>	
				<tr align="center">
					<td colspan="2">
						<img src="images/OwnerAdmin.jpg" alt="OwnerAdmin.jpg" width="450" height="324" border="1" align="middle" />
					</td>
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>User Management</h2>					
						<p class="SalesText">This simple screen lets the Administrator of the house control the users. If you forget your password you can either use the automated password reset functionality or you can call the Administrator and he/she can update your account in a few clicks using this screen.</p>					
					</td>
				</tr>	
				<tr align="center">
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>Room Management</h2>					
						<p class="SalesText">Probably one of the least exciting pages, this screen allows the Administrator to set up the house and identify the number of rooms that are available. You should only use this page once. But it is neat. </p>					
					</td>
					<td colspan="2">
						<img src="images/ManageRooms.jpg" alt="ManageRooms.jpg" width="450" height="362" border="1" align="middle" />
					</td>
				</tr>	
				<tr align="center">
					<td colspan="2">
						<img src="images/Visitors.jpg" alt="Visitors.jpg" width="450" height="524" border="1" align="middle" />
					</td>
					<td colspan="1" width="30%" align="left" valign="top">
						<h2>Scheduling Visitors</h2>					
						<p class="SalesText">Are you still reading? I'm impressed! This is where TheVacationCalendar.com steps it up a notch... but thankfully it is completely optional. If you are a type A personality and want to be able to specify who is staying in what room at any given time, this page gives you that control. Best of all it is visible to all users so that one family member that insists on arriving at 2am will no longer have to wake up the entire house when trying to find out which bedroom to sleep in.</p>					
					</td>
				</tr>	
				<tr align="center">
					<td colspan="1" width="35%">
						&nbsp;
					</td>
					<td colspan="1" width="30%" align="left" valign="top">
						&nbsp;
					</td>
					<td colspan="1" width="35%">
						&nbsp;
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
