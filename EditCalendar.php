<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <link href="BeachStyle.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
// <!--


function notification(visibility) {
	document.getElementById('shade').style.visibility = visibility;
}

function setNotification(msg) {
	document.getElementById('notification').innerHTML = msg;
}

// -->
</script>
</head>


<?php include("Database.php") ?>
<?php include("Functions.php") ?>


<body onload="atLoad();">
<div id="shade" style="position:absolute; top: 0px; left: 0px; width: 350px; height: 485px; background-image:url(_images/shade.png); background-repeat:repeat; visibility:hidden; z-index:10001;">
	<div id="notification" style="position: relative; top: 230px; height: 25px; background: #99CC66; text-align: center; font-family:Georgia, 'Times New Roman', Times, serif; font-weight: bold; padding-top: 5px;" align="center">No Message</div>
</div>
<div id="content">
	<div id="options" style="position: absolute; right: 5px; top: 5px;"><img src="_images/close.gif" alt="close" onclick="Javascript: parent.location='Calendar.php';" style="cursor: pointer;" /></div>
	<form action="EditCalendar.php" method="post" enctype="multipart/form-data">

<table border="0" align="center" width="100%" height="295">
	<tr align="center">


<form action="EditCalendar.php" method="post">

<?php 
if (isset($_GET["StartDay"]))
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
<tr><td>&nbsp;</td><td class="TextItem">Select background color:</td><td colspan="2">
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
<tr><td>&nbsp;</td><td class="TextItem">Select text color:</td><td colspan="2">
<select name="FontColor">
<option value="94918B" style="background-color: #94918B;">Default</option>
<option value="FEFCF6" style="background-color: #FEFCF6;">White</option>
<option value="32302B" style="background-color: #32302B;">Black</option>
</select>
</td></tr>
EOADMINFORM;

echo $admin_form;
	echo "<tr><td align=\"center\" colspan=\"4\"><input type=\"hidden\" name=\"SaveScheduledOwner\" value=\"N\"></input><input type=\"submit\" value=\"Schedule Vacation\" /></td>";

}
	
include("SaveVacations.php");
?>

</form>



	</table>
	</form>
</div>
</body>
</html>
