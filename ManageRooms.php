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
	if (document.getElementById('Rooms')) {
		document.getElementById('Rooms').className="NavSelected";
		document.getElementById('RoomsLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}


</SCRIPT>

<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Administrator")
	{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Manage Rooms Main',  NULL, NULL); ?>

<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Manage your rooms</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this screen to add and update the bedrooms in your vacation home. Accurately defining the number of bedrooms will allow Owners to show others when there is availability for additional visitors during their vacation. You can also add the amenities each room offers, but this is for informational purposes only.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">

<form action="ManageRooms.php" method="post">

<?php include("GetRoomInfo.php") ?>

<?php include("InputRoomInfo.php") ?>

			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p><font color="red">It is important to note that if you delete a room from this page, you are not able undo this and any visitors (or owners) that are scheduled in this room will be deleted as well.</font></p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


<?php include("Footer.php") ?>

</form>
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
