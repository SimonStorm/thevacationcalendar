<?php ActivityLog('Info', curPageURL(), 'Save Vacations Include',  NULL, NULL); ?>
<?php
//This section displays the selected dates in a row

$self = $_SERVER['PHP_SELF'];

//This is update vacation screen logic
if (isset($_GET["VacationId"]))
{
	GetVacationDates(&$VacationResult, $_GET["VacationId"], &$StartRange, &$StartDate, &$EndRange, &$EndDate, &$VacationName, &$AllowGuests, &$AllowOwners, &$FirstName, &$LastName, &$OwnerIdVal, &$BkgrndColor, &$FontColor);	
	
	$VacationName = stripslashes($VacationName);
	
	echo "<input type=\"hidden\" name=\"VacationId\" value=\"".$_GET["VacationId"]."\"></input>";		
	echo "<input type=\"hidden\" name=\"InitialStartRange\" value=\"".$StartRange."\"></input>";
	echo "<input type=\"hidden\" name=\"InitialEndRange\" value=\"".$EndRange."\"></input>";		

	echo "</td></tr>";
	
	echo "<tr>";
	$DateArray = explode('/',$StartDate);
	
	$StartYear = $DateArray[2];
	$StartMonth = $DateArray[0]; 
	$StartDay = $DateArray[1];

	$DateArray = explode('/',$EndDate);
	
	$EndYear = $DateArray[2];
	$EndMonth = $DateArray[0]; 
	$EndDay = $DateArray[1];

	include("DateRangePicker.php");
	echo "</tr>";
	
	GetRooms(&$RoomResult);
	$RoomInUse = -1;
	
	echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Vacation Name:</td><td colspan=\"2\"><input maxlength=\"40\" type=\"text\" name=\"VacationName\" value=\"".stripslashes($VacationName)."\" /></td></tr>";
	
	if (HasRooms())
	{
		
		$RoomInUseQuery = "select RoomId from Schedule where VacationId = ".$_GET["VacationId"]." and OwnerId = GuestId LIMIT 1";

		$RoomInUseResult = mysql_query( $RoomInUseQuery );
		if (!$RoomInUseResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Room Info',  $RoomInUseQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		
		while ($RoomInUseRow = mysql_fetch_array($RoomInUseResult, MYSQL_ASSOC)) 
		{
			$RoomInUse = $RoomInUseRow['RoomId'];
		}
		
		echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Choose your your room  preference</td><td colspan=\"2\" class=\"TextItem\" width=\"40%\"><select name=\"OwnerRoom\">";
	
		echo "<option value=\"0\">Booking for Others</option>";
		
		while ($RoomRow = mysql_fetch_array($RoomResult, MYSQL_ASSOC)) 
		{	
			echo "<option ";
			if ($RoomInUse == $RoomRow['RoomId'])
			{
				echo "SELECTED";
			}
			echo " value=\"".$RoomRow['RoomId']."\">".$RoomRow['RoomName']."</option>";
		}
	
		echo "</select></td></tr>";
	
	
		if ($AllowGuests == "Y")
		{
			$Checked = "checked=\"checked\"";	
		}
		else
		{
			$Checked = "";
		}	
	
		if ($AllowOwners == "Y")
		{
			$OwnerChecked = "checked=\"checked\"";	
		}
		else
		{
			$OwnerChecked = "";
		}	
	
		echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Allow visitors?</td><td colspan=\"2\"><input type=\"checkbox\" ".$Checked." name=\"AllowGuests\" value=\"Y\" /></td></tr>";
		echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Allow other Owners to book rooms?</td><td colspan=\"2\"><input type=\"checkbox\" ".$OwnerChecked." name=\"AllowOwners\" value=\"Y\" /></td></tr>";
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

$admin_form = str_replace("\"".$BkgrndColor, "\"".$BkgrndColor."\" selected "  , $admin_form);
$admin_form = str_replace("\"".$FontColor, "\"".$FontColor."\" selected "  , $admin_form);


echo $admin_form;


	echo "<tr><td align=\"center\" colspan=\"4\"><input type=\"hidden\" name=\"UpdateScheduledOwner\" value=\"".$_GET["VacationId"]."\"></input><input type=\"submit\" value=\"Update Vacation\" />&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Delete Vacation\" onclick=window.location='EditCalendar.php?VacationId=".$_GET["VacationId"]."&Change=Delete' target=\"_self\"/></td></tr>";
}

?>
				

<?php

$self = $_SERVER['PHP_SELF'];

//This is delete logic
if (isset($_GET["VacationId"]))
{   
	if ($_GET["Change"] == "Delete")
	{
	//Removed owner check in order to delete all guests as well
	//OwnerId = ".$_SESSION['OwnerId']." AND 
	
		SendNotification('deleted', $_GET["VacationId"]);
		
		$DeleteOwnerQuery = "DELETE FROM Schedule 
			WHERE HouseId = ".$_SESSION['HouseId']." 
			AND DateId >= (SELECT StartDateId FROM Vacations WHERE VacationId = ".$_GET["VacationId"].")
			AND DateId <= (SELECT EndDateId FROM Vacations WHERE VacationId = ".$_GET["VacationId"].")";

		if (!mysql_query( $DeleteOwnerQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Scheduled Vacation Days',  $DeleteOwnerQuery, mysql_error());
			die ("Could not delete scheduled visitors from the database: <br />". mysql_error());
		}
		
		$DeleteOwnerVacation = "DELETE FROM Vacations 
			WHERE OwnerId = ".$_SESSION['OwnerId']." 
			AND HouseId = ".$_SESSION['HouseId']." 
			AND VacationId = ".$_GET["VacationId"];

		if (!mysql_query( $DeleteOwnerVacation ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Scheduled Vacations',  $DeleteOwnerVacation, mysql_error());
			die ("Could not delete owner vacation from the database: <br />". mysql_error());
		}

		echo "Congrats you have deleted your vacation";
		echo "<script language='JavaScript'>parent.location=parent.location.href;</script>";

	}
}
//This is insert logic
elseif (isset($_POST["SaveScheduledOwner"])	)
{   
	if (isset($_POST["StartMonth"]))
	{
		$StartDay = $_POST["StartDay"];
		$StartMonth = $_POST["StartMonth"];
		$StartYear = $_POST["StartYear"];
		$EndDay = $_POST["EndDay"];
		$EndMonth = $_POST["EndMonth"];
		$EndYear = $_POST["EndYear"];
	}
	else
	{
		$StartDay = $_GET["StartDay"];
		$StartMonth = $_GET["StartMonth"];
		$StartYear = $_GET["StartYear"];
		$EndDay = $_GET["StartDay"];
		$EndMonth = $_GET["StartMonth"];
		$EndYear = $_GET["StartYear"];
	}

	if (!checkdate($StartMonth, $StartDay, $StartYear))
	{
		echo "Invalid start date";
	}
	elseif (!checkdate($EndMonth, $EndDay, $EndYear))
	{
		echo "Invalid end date";
	}
	elseif (date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear)) > date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear)))
	{
		echo "Start date must be before end date";
	}
	else
	{

		$StartQuery = "SELECT C.RealDate, C.DateId
		  FROM Calendar C, Vacations V
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear))."
		  AND C.DateId >= V.StartDateId
		  AND C.DateId <= V.EndDateId
		  AND V.HouseId = ".$_SESSION['HouseId'];

		$result = mysql_query($StartQuery);
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select Start Date Range',  $StartQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		elseif (mysql_num_rows($result) == 1)
		{
			die ("<br/><font color=red> Another vacation conflicts with your dates </font> <br/><br/>");
		}

		$StartQuery = "SELECT C.RealDate, C.DateId
		  FROM Calendar C, Vacations V
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear))."
		  AND C.DateId >= V.StartDateId
		  AND C.DateId <= V.EndDateId
		  AND V.HouseId = ".$_SESSION['HouseId'];

		$result = mysql_query($StartQuery);
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select End Date Range',  $StartQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		elseif (mysql_num_rows($result) == 1)
		{
			die ("A vacation conflicts with your dates <br />");
		}

		$VacationName = "";
		
		$StartQuery = "SELECT C.RealDate, C.DateId
		  FROM Calendar C 
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear));
	
		$StartResult = mysql_query( $StartQuery );
		if (!$StartResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Start Date Range - Again',  $StartQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
	
		while ($StartRow = mysql_fetch_array($StartResult, MYSQL_ASSOC)) 
		{
			$StartRange = $StartRow['DateId'];
			$StartDate = $StartRow['RealDate'];
		}
	
		$EndQuery = "SELECT C.RealDate, C.DateId
		  FROM Calendar C 
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear));
	
		$EndResult = mysql_query( $EndQuery );
		if (!$EndResult)
		{
			ActivityLog('Error', curPageURL(), 'Select End Date Range - Again',  $EndQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		
		while ($EndRow = mysql_fetch_array($EndResult, MYSQL_ASSOC)) 
		{
			$EndRange = $EndRow['DateId'];
			$EndDate = $EndRow['RealDate'];
		}
		
		$df_src = 'Y-m-d';
		$df_des = 'n/j/Y';
	
		$StartDate = dates_interconv( $df_src, $df_des, $StartDate);
		$EndDate = dates_interconv( $df_src, $df_des, $EndDate);
	}
	
	if (isset($_POST['AllowGuests']))
	{
		$AllowGuests = "Y";
	}
	else
	{
		$AllowGuests = "N";
	}

	if (isset($_POST['AllowOwners']))
	{
		$AllowOwners = "Y";
	}
	else
	{
		$AllowOwners = "N";
	}

	$InsertOwnerVacation = "INSERT INTO Vacations (OwnerId, HouseId, StartDateId, EndDateId, AllowGuests, AllowOwners, VacationName, BackGrndColor, FontColor, Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
	VALUES (".$_SESSION['OwnerId'].", ".$_SESSION['HouseId'].", ".$StartRange.", ".$EndRange.", '".$AllowGuests."', '".$AllowOwners."', '".mysql_real_escape_string($_POST['VacationName'])."', '".$_POST['BackGrndColor']."',  '".$_POST['FontColor']."', 
	'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";

	//echo $InsertOwnerVacation;

	if (!mysql_query( $InsertOwnerVacation ))
	{
		ActivityLog('Error', curPageURL(), 'Insert Scheduled Vacations',  $InsertOwnerVacation, mysql_error());
		die ("Could not insert into the database: <br />". mysql_error());
	}
	
	$VacationIdQuery = "SELECT VacationId
			FROM Vacations
			WHERE OwnerId = ".$_SESSION['OwnerId']."
			AND HouseId = ".$_SESSION['HouseId']."
			AND StartDateId = ".$StartRange."
			AND EndDateId = ".$EndRange;
      
	$VacationIdResult = mysql_query($VacationIdQuery);
      
	if (!$VacationIdResult || mysql_num_rows($VacationIdResult) <> 1)
	{
		ActivityLog('Error', curPageURL(), 'Select Scheduled Vacation Id',  $VacationIdQuery, mysql_error());
		die ("ERROR - Unable to get VacationId: <br />". mysql_error());
    } 
    else 
    {
      $VacationId = mysql_result($VacationIdResult, 0, 'VacationId');
	}	



	for ($Counter = $StartRange ; $Counter <= $EndRange; $Counter++) 
	{
		if ($_POST['OwnerRoom'] != 0)
		{

			$InsertOwnerQuery = "INSERT INTO Schedule (OwnerId, DateId, HouseId, RoomID, GuestId, VacationId, Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
				VALUES (".$_SESSION['OwnerId'].", ".$Counter.", ".$_SESSION['HouseId'].", ".$_POST['OwnerRoom'].", ".$_SESSION['OwnerId'].", ".$VacationId.",
						'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
	
			if (!mysql_query( $InsertOwnerQuery ))
			{
				ActivityLog('Error', curPageURL(), 'Insert Scheduled Vacation Days',  $InsertOwnerQuery, mysql_error());
				die ("Could not insert into the database: <br />". mysql_error());
			}
		}
		
		GetRooms($RoomResult);		
	}

SendNotification('inserted', $VacationId);

echo "Congrats you have scheduled your vacation";
echo "<script language='JavaScript'>parent.location=parent.location.href;</script>";
}   

//This is update logic
if (isset($_POST["UpdateScheduledOwner"]))
{   
//echo "<pre>";
//print_r ($_POST);
//echo "</pre>";

	$StartDay = $_POST["StartDay"];
	$StartMonth = $_POST["StartMonth"];
	$StartYear = $_POST["StartYear"];
	$EndDay = $_POST["EndDay"];
	$EndMonth = $_POST["EndMonth"];
	$EndYear = $_POST["EndYear"];

	if (!checkdate($StartMonth, $StartDay, $StartYear))
	{
		echo "Invalid Start Date";
//		echo "<script language='JavaScript'>parent.location='/Calendar.php';</script>";
	}
	elseif (!checkdate($EndMonth, $EndDay, $EndYear))
	{
		echo "Invalid End Date";
//		echo "<meta http-equiv=\"Refresh\" content=\"1; url=ScheduleVacations.php\"/>";
	}
	else
	{

		$GetDateIdQuery = "SELECT C.DateId
		  FROM Calendar C
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear));

		$result = mysql_query($GetDateIdQuery);
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select Start Date Date Id',  $GetDateIdQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		while ($DateIdRow = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
			$DateId = $DateIdRow['DateId'];
		}

		$StartQuery = "SELECT *
		  FROM Vacations V
		  WHERE ".$DateId." >= V.StartDateId
		  AND ".$DateId." <= V.EndDateId
		  AND V.VacationId <> ".$_POST['VacationId']."
		  AND V.HouseId = ".$_SESSION['HouseId'];

		$result = mysql_query($StartQuery);
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select Update Start Date Range',  $StartQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		elseif (mysql_num_rows($result) > 0)
		{
			echo "A vacation conflicts with your dates 1<br />";
//			echo "<meta http-equiv=\"Refresh\" content=\"1; url=ScheduleVacations.php\"/>";
		}
		else
		{

			$GetDateIdQuery = "SELECT C.DateId
			  FROM Calendar C
			  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear));

			$result = mysql_query($GetDateIdQuery);
			if (!$result)
			{
				ActivityLog('Error', curPageURL(), 'Select End Date Date Id',  $GetDateIdQuery, mysql_error());
				die ("Could not query the database: <br />". mysql_error());
			}
			while ($DateIdRow = mysql_fetch_array($result, MYSQL_ASSOC)) 
			{
				$DateId = $DateIdRow['DateId'];
			}
		
			$EndQuery = "SELECT *
			  FROM Vacations V
			  WHERE ".$DateId." >= V.StartDateId
			  AND ".$DateId." <= V.EndDateId
			  AND V.VacationId <> ".$_POST['VacationId']."
			  AND V.HouseId = ".$_SESSION['HouseId'];

			$result = mysql_query($EndQuery);
			if (!$result)
			{
				ActivityLog('Error', curPageURL(), 'Select Update End Date Range',  $EndQuery, mysql_error());
				die ("Could not query the database: <br />". mysql_error());
			}
			elseif (mysql_num_rows($result) == 1)
			{
				echo "<p align=\"center\" class=\"Error\">A vacation conflicts with your dates </p><br />";
//				echo "<meta http-equiv=\"Refresh\" content=\"1; url=ScheduleVacations.php\"/>";
			}
			else
			{
	
				if (isset($_POST['AllowGuests']))
				{
					$AllowGuests = "Y";
				}
				else
				{
					$AllowGuests = "N";
				}
			
				if (isset($_POST['AllowOwners']))
				{
					$AllowOwners = "Y";
				}
				else
				{
					$AllowOwners = "N";
				}
			
				
				$StartQuery = "SELECT C.RealDate, C.DateId
				  FROM Calendar C 
				  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear));
			
				$StartResult = mysql_query( $StartQuery );
				if (!$StartResult)
				{
					ActivityLog('Error', curPageURL(), 'Select Update Start Date Range - Again',  $StartQuery, mysql_error());
					die ("Could not query the database: <br />". mysql_error());
				}
			
				while ($StartRow = mysql_fetch_array($StartResult, MYSQL_ASSOC)) 
				{
					$StartRange = $StartRow['DateId'];
					$StartDate = $StartRow['RealDate'];
				}
			
				$EndQuery = "SELECT C.RealDate, C.DateId
				  FROM Calendar C 
				  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear));
			
				$EndResult = mysql_query( $EndQuery );
				if (!$EndResult)
				{
					ActivityLog('Error', curPageURL(), 'Select Update End Date Range - Again',  $EndQuery, mysql_error());
					die ("Could not query the database: <br />". mysql_error());
				}
				
				echo "<div>";
			
				while ($EndRow = mysql_fetch_array($EndResult, MYSQL_ASSOC)) 
				{
					$EndRange = $EndRow['DateId'];
					$EndDate = $EndRow['RealDate'];
				}
						
			//echo "<pre>";
			//print_r ($_POST);
			//echo "</pre>";
			
			
				AddRemoveDays($_POST['VacationId'], $_POST['InitialStartRange'], $StartRange, 'Front');	
				AddRemoveDays($_POST['VacationId'], $_POST['InitialEndRange'], $EndRange, 'End');
			
				for ($Counter = $StartRange ; $Counter <= $EndRange; $Counter++) 
				{
				
					$UpdateScheduleQuery = "DELETE FROM Schedule
						WHERE GuestId = ".$_SESSION['OwnerId']." 
						AND DateId = ".$Counter." 
						AND HouseId = ".$_SESSION['HouseId']."
						AND OwnerId = ".$_SESSION['OwnerId']."
						AND VacationId = ".$_POST['VacationId'];
		
					if (!mysql_query( $UpdateScheduleQuery ))
					{
						ActivityLog('Error', curPageURL(), 'Delete Scheduled Vacation for Update',  $UpdateScheduleQuery, mysql_error());
						die ("Could not update the database: <br />". mysql_error());
					}
			
					if ($_POST['OwnerRoom'] != 0)
					{

						$InsertOwnerQuery = "INSERT INTO Schedule (OwnerId, DateId, HouseId, RoomID, GuestId, VacationId, Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
							VALUES (".$_SESSION['OwnerId'].", ".$Counter.", ".$_SESSION['HouseId'].", ".$_POST['OwnerRoom'].", ".$_SESSION['OwnerId'].", ".$_POST['UpdateScheduledOwner'].",
									'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
				
						if (!mysql_query( $InsertOwnerQuery ))
						{
							ActivityLog('Error', curPageURL(), 'Insert Scheduled Vacation for Update',  $InsertOwnerQuery, mysql_error());
							die ("Could not insert into the database: <br />". mysql_error());
						}

					}
				}
			
				$UpdateOwnerVacation = "UPDATE Vacations 
										SET AllowGuests = '".$AllowGuests."',
										AllowOwners = '".$AllowOwners."',
										VacationName = '".mysql_real_escape_string($_POST['VacationName'])."' ,
										StartDateId = ".$StartRange.",
										EndDateId = ".$EndRange.",
										Audit_user_name = '".$_SESSION['user_name']."',
										Audit_Role = '".$_SESSION['Role']."',
										Audit_FirstName = '".$_SESSION['FirstName']."',
										Audit_LastName = '".$_SESSION['LastName']."', 
										Audit_Email = '".$_SESSION['Email']."',
										BackGrndColor = '".$_POST['BackGrndColor']."',
										FontColor = '".$_POST['FontColor']."'
										WHERE VacationId = ".$_POST['UpdateScheduledOwner']."
										AND HouseId = ".$_SESSION['HouseId']."
										AND OwnerId = ".$_SESSION['OwnerId'];
			
				if (!mysql_query( $UpdateOwnerVacation ))
				{
					ActivityLog('Error', curPageURL(), 'Update Vacation',  $UpdateOwnerVacation, mysql_error());
					die ("Could not insert into the database: <br />". mysql_error());
				}
		
				SendNotification('updated', $_POST['UpdateScheduledOwner']);
				
				echo "Congrats you have scheduled your vacation";
				echo "<script language='JavaScript'>parent.location=parent.location.href;</script>";
			}
		}
	}
}   
?>
