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
	if (document.getElementById('Vacations')) {
		document.getElementById('Vacations').className="NavSelected";
		document.getElementById('VacationsLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}

</SCRIPT>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Schedule Vacations Main',  NULL, NULL); ?>

<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Owner" || ($_SESSION['Role'] == "Administrator" && IsAdminOwner()))
	{
?>

<?php include("Navigation.php") ?>

<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Manage your vacations</td>
				<tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
		<?php
		if (HasRooms())
		{
						echo "<p class=\"Instructions\">Use this section to add, edit or delete a vacation scheduled at your vacation home. If you are planning on attending the vacation, you can select the room you wish to stay in. Otherwise, you can select Booking for Others in the room preference dropdown if you are scheduling the vacation home for someone else to use the house. <br/><br/>As the Owner, you are able to prevent others from seeing any availability at the vacation home by unchecking the Allow Visitors checkbox. Additionally, you can prevent other Owners from joining your vacation by unchecking the Allow other Owners to book rooms checkbox.</p>";
		}
		else
		{
						echo "<p class=\"Instructions\">Use this section to add, edit or delete a vacation scheduled at your vacation home. Simply select the date range you are interested in using the vacation home for and click Get Dates. Then enter the name of your vacation and click Schedule Vacation</p>";
		}
		?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="90%" cellpadding="5">
				<tr>

<form action="ScheduleVacations.php" method="post">

<?php include("GetScheduledVacations.php") ?>

				</tr>
				<tr>

<?php 
if (!isset($_GET["VacationId"]))
{
	include("DateRangePicker.php") ;


	GetRooms(&$RoomResult);

	echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Vacation Name:</td><td colspan=\"2\"><input maxlength=\"40\" type=\"text\" name=\"VacationName\" value=\"\" /></td></tr>";

	if (HasRooms())
	{
		echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Choose your your room  preference</td><td colspan=\"2\" class=\"TextItem\" width=\"40%\"><select name=\"OwnerRoom\">";
		
		echo "<option value=\"0\">Booking for Others</option>";
		
		while ($RoomRow = mysql_fetch_array($RoomResult, MYSQL_ASSOC)) 
		{	
			echo "<option value=\"".$RoomRow['RoomId']."\">".$RoomRow['RoomName']."</option>";
		}
	
		echo "</select></td></tr>";
	

		echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Allow visitors?</td><td colspan=\"2\"><input type=\"checkbox\" checked=\"checked\" name=\"AllowGuests\" value=\"Y\" /></td></tr>";
		echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Allow other Owners to book rooms?</td><td colspan=\"2\"><input type=\"checkbox\" checked=\"checked\" name=\"AllowOwners\" value=\"Y\" /></td></tr>";

	}

$admin_form = <<< EOADMINFORM
<tr><td>&nbsp;</td><td class="TextItem">Select background color</td><td colspan="2">
<select name="BackGrndColor">
<option value="FFFBF0" style="background-color: #FFFBF0;">Default</option>
<option value="F48058" style="background-color: #F48058;">Red</option>
<option value="F4AC58" style="background-color: #F4AC58;">Orange</option>
<option value="F3F298" style="background-color: #F3F298;">Yellow</option>
<option value="B0EFA8" style="background-color: #B0EFA8;">Green</option>
<option value="B9EAE3" style="background-color: #B9EAE3;">Light Blue</option>
<option value="9ECCF8" style="background-color: #9ECCF8;">Dark Blue</option>
<option value="9EB1F8" style="background-color: #9EB1F8;">Purple</option>
<option value="DEB2F1" style="background-color: #DEB2F1;">Pink</option>
</select>
</td></tr>
<tr><td>&nbsp;</td><td class="TextItem">Select font color</td><td colspan="2">
<select name="FontColor">
<option value="FFFBF0" style="background-color: #FFFBF0;">Default</option>
<option value="FEFCF6" style="background-color: #FEFCF6;">White</option>
<option value="32302B" style="background-color: #32302B;">Black</option>
</select>
</td></tr>
EOADMINFORM;

echo $admin_form;

echo "<tr><td align=\"center\" colspan=\"4\"><input type=\"hidden\" name=\"SaveScheduledOwner\" value=\"N\"></input><input type=\"submit\" value=\"Schedule Vacation\" /></td>";
	

}	
?>

</form>

<form action="ScheduleVacations.php" method="post">

				</tr>
				<tr>



<?php include("SaveVacations.php") ?>
</form>





<?php include("Footer.php") ?>

				
</table>
<?php 
	}
	else
	{
		echo "You do not have access to this page. <a href=\"index.php\">Please click here to log in.</a>";
		echo "<script language='JavaScript'>this.location='/index.php';</script>";
	}
}
else
{
	echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";
	echo "<script language='JavaScript'>this.location='/index.php';</script>";

}
?>

</body>
</html>
