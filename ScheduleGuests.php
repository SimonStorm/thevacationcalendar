<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">

</HEAD>
<body onload="init();">



<script type="text/javascript">

function init() 
{
try {
	if (document.getElementById('Schedule')) {
		document.getElementById('Schedule').className="NavSelected";
		document.getElementById('ScheduleLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}

</SCRIPT>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>

<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Owner" || ($_SESSION['Role'] == "Administrator" && IsAdminOwner()))
	{
?>
<?php ActivityLog('Info', curPageURL(), 'Schedule Guests Main',  NULL, NULL); ?>
<?php include("Navigation.php") ?>

<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Schedule your visitors</td>
				<tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this screen to specify visitors that are staying during your vacation. To start this process you can click the Schedule Guests link on one of your vacations. Select the name of the visitor that you want to schedule. Then in the bottom grid, click the + button that corresponds to the day and the room that you want the visitor to stay in. </p>
						<p class="Instructions">If you find that you do not have any guests in the select box, or you want to add a different guest, go to the manage visitors screen and add more guests. When you return to this screen they will be available to you.</p>
						<p class="Instructions">If you get the message "This vacation is not set up to receive visitors." this means that you have unchecked the Allow Visitors checkbox when you set up your vacation. To undo this, return to the vacations screen, edit your vacation, check the box, and click the Update Vacation button.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="90%" cellpadding="5">
				<tr>
	
<form action="ScheduleGuests.php" method="post">

<?php include("GetScheduledVacations.php") ?>

</form>

<form id="form_id" action="SaveScheduledGuests.php" method="post" >

<?php include("InputGuestSchedule.php") ?>

				</tr>
			</table>
		</td>
	</tr>
</table>
</form>

<?php include("Footer.php") ?>

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
