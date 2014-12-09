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
<?php ActivityLog('Info', curPageURL(), 'Save Scheduled Guests Main',  NULL, NULL); ?>

<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Owner" || ($_SESSION['Role'] == "Administrator" && IsAdminOwner()))
	{
?>

<?php include("Navigation.php") ?>

<table border="0" align="center" width="85%">
	<tr align="center">
		<td colspan="4"><h1>Schedule</h1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="100%" cellpadding="5">
				
<?php
$self = $_SERVER['PHP_SELF'];
$df_src = 'Y-m-d';
$df_des = 'n/j/Y';


// This is the add and update logic. The code always deletes all rooms
// and then reinserts
if (isset($_POST["SaveScheduledGuests"]))
{   

	$StartRange = $_POST["StartRange"];
	$EndRange = $_POST["EndRange"];
			
	GetRooms(&$RoomResult);

	while ($RoomRow = mysql_fetch_array($RoomResult, MYSQL_ASSOC)) 
	{		
		
		for ($Counter = $StartRange ; $Counter <= $EndRange; $Counter++) 
		{
		

			$DeleteGuestQuery = "DELETE FROM Schedule 
				WHERE RoomID = ".$RoomRow['RoomId']."
				AND DateId = ".$Counter."
				AND HouseId = ".$_SESSION['HouseId']."
				AND OwnerId = ".$_SESSION['OwnerId'];

			if (!mysql_query( $DeleteGuestQuery ))
			{
				ActivityLog('Error', curPageURL(), 'Delete Schedule info for Guests',  $DeleteGuestQuery, mysql_error());
				die ("Could not delete visitors from the database: <br />". mysql_error());
			}						

			if (isset($_POST["c".$Counter."_".$RoomRow['RoomId']]))
			{   

				$BookedGuests = $_POST["c".$Counter."_".$RoomRow['RoomId']];
				foreach( $BookedGuests as $GuestValue )
				{	
					$InsertGuestQuery = "INSERT INTO Schedule (OwnerId, DateId, HouseId, RoomID, GuestId, VacationId, Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
											VALUES (".$_SESSION['OwnerId'].", ".$Counter.", ".$_SESSION['HouseId'].", ".$RoomRow['RoomId'].", ".$GuestValue.", ".$_POST["VacationId"].",
											'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
					if (!mysql_query( $InsertGuestQuery ))
					{
						ActivityLog('Error', curPageURL(), 'Insert Schedule info for Guests',  $InsertGuestQuery, mysql_error());
						die ("Could not insert visitors into the database: <br />". mysql_error());
					}						
				}

			}
		}
	}
	

	echo "Congrats you have scheduled your visitors";
	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ScheduleGuests.php\"/>";

	echo "<tr><td colspan=\"4\"></td></tr>";

}
?>
				</tr>
			</table>
		</td>
	</tr>
</table>

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
