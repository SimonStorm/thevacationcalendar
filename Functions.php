
<?php
/**
echo $_SERVER['HTTP_HOST'];
echo "<br/>";
echo "GET";
echo "<br/>";
echo "-------";
echo "<pre>";
print_r ($_GET);
echo "</pre>";
echo "POST";
echo "<br/>";
echo "-------";
echo "<pre>";
print_r ($_POST);
echo "</pre>";
echo "FILES";
echo "<br/>";
echo "-------";
echo "<pre>";
print_r ($_FILES);
echo "</pre>";
echo "SESSION";
echo "<br/>";
echo "-------";
echo "<pre>";
print_r ($_SESSION);
echo "</pre>";
**/

// Calls a function to get the array of room usage for the month
// Used in CreateCalendar.php
/**
function GetAvailableBunks($Month, $Year, &$AvailableBunksArray)
{
	$UsedRoomsQuery = "SELECT COUNT(R.RoomId) 'UsedRooms', C.Day
    			FROM Calendar C
					LEFT OUTER JOIN Schedule S ON C.DateID = S.DateID AND S.GuestId <> 0 AND S.HouseId = ".$_SESSION['HouseId']."
					LEFT OUTER JOIN Room R ON S.RoomId = R.RoomId
				WHERE DATE_FORMAT(C.RealDate, '%m') =".$Month."  
				AND DATE_FORMAT(C.RealDate, '%Y') =".$Year." 
				GROUP BY C.Day
    			ORDER BY C.Day";

	$UsedRoomsResults = mysql_query( $UsedRoomsQuery );
	if (!$UsedRoomsResults)
	{
		die ("Could not query the database: <br />". mysql_error());
	}
}
*/

function curPageURL() {
 $pageURL = 'http';
// if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function ActivityLog($LogLevel, $WebPage, $Comment, $Query, $ErrorMsg)
{

	if (isset($_SESSION['HouseId']))
	{
	  $HouseId = $_SESSION['HouseId'];
	}
	else
	{
	  $HouseId = NULL;
	}
	if (isset($_SESSION['user_name']))
	{
	  $UserName = $_SESSION['user_name'];
	}
	else
	{
	  $UserName = NULL;
	}
	if (isset($_SESSION['Role']))
	{
	  $Role = $_SESSION['Role'];
	}
	else
	{
	  $Role = NULL;
	}
	
	
	$LogLevelPref = 'Debug';  // Options are Debug, Info, Warn, Error
	
	if ($LogLevelPref == 'Debug' || ($LogLevelPref == 'Info' && ($LogLevel == 'Info' || $LogLevel == 'Warn' || $LogLevel == 'Error')) || ($LogLevelPref == 'Warn' && ($LogLevel == 'Warn' || $LogLevel == 'Error')) || ($LogLevelPref == 'Error' && $LogLevel == 'Error'))
	{
		$InsertActivityLog = "INSERT INTO audit_Log (Audit_LogLevel,  Audit_WebPage, Audit_Comment, Audit_Timestamp, Audit_HouseId, Audit_user_name, Audit_Role, Audit_Query, Audit_MySQL_Error) 
		VALUES ('".$LogLevel."', '".$WebPage."', '".$Comment."', SYSDATE(), '".$HouseId."', '".$UserName."', '".$Role."', '".mysql_real_escape_string($Query)."', '".mysql_real_escape_string($ErrorMsg)."')";
//echo $InsertActivityLog;
		if (!mysql_query( $InsertActivityLog ))
		{
			die ("Could not insert logging into the database: <br />". mysql_error());
		}
	}

}


// Calls a function to get the array of room usage for the month
// Used in Navigation.php
// Used in ManageProfile.php
function ShowOldSave()
{
	$ShowOldSaveQuery = "SELECT ShowOldSave
    			FROM user
				WHERE user_id = ".$_SESSION['OwnerId'];

	$ShowOldSaveResults = mysql_query( $ShowOldSaveQuery );
	if (!$ShowOldSaveResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if User wants to use the old save vacation',  $ShowOldSaveQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
	
	if (mysql_num_rows($ShowOldSaveResults) > 0)
	{
		while ($ShowOldSaveRow = mysql_fetch_array($ShowOldSaveResults, MYSQL_ASSOC)) 
		{
			if ($ShowOldSaveRow['ShowOldSave'] == 'Y')
			{
				return "CHECKED";	
			}
			else
			{
				return "";
			}
		}
	}
	else
	{
		ActivityLog('Error', curPageURL(), 'Multiple users found for User wants to use the old save vacation',  $ShowOldSaveQuery, mysql_error());
		die ("Too many records returned: <br />". mysql_error());
		return "";
	}
	
}


// SaveVacations.php
function SendNotification($Change, $VacationId)
{

	if (strlen(CalEmailList()) > 0)
	{	
		GetVacationDates(&$VacationResult, $VacationId, &$StartRange, &$StartDate, &$EndRange, &$EndDate, &$VacationName, &$AllowGuests, &$AllowOwners, &$FirstName, &$LastName, &$OwnerIdVal, &$BkgrndColor, &$FontColor);	
		
		$EmailContent = "";
		while ($VacationInfoRow = mysql_fetch_array($VacationResult, MYSQL_ASSOC)) 
		{
			 $EmailContent .= $VacationInfoRow['VacationName']." has been ".$Change." from ".$StartDate." to ".$EndDate;
		}
			
		$mail_body = <<< EOMAILBODY
A vacation change has taken place on www.TheVacationCalendar.com.  

$EmailContent


Thank you for using the TheVacationCalendar.com


EOMAILBODY;
	
		$array = explode(',', CalEmailList());
		foreach ($array as $value) 
		{
			mail ($value, 'TheVacationCalendar.com Change Notification', $mail_body, 'From: noreply@TheVacationCalendar.com');
		}
		
	}
			
	return true;

}


// SaveVacations.php
function SendBlogNotification($Change, $BlogId)
{
	
	if (strlen(BlogEmailList()) > 0)
	{	
		GetBlog(&$BlogResult, $BlogId, 'B');
		
		$EmailContent = "";
		while ($BlogRow = mysql_fetch_array($BlogResult, MYSQL_ASSOC)) 
		{
			 $EmailContent .= $BlogRow['Subject']."-- Posted by ".$BlogRow['Author'].":  ".$BlogRow['Content'];
		}
	
		$mail_body = <<< EOMAILBODY
A new blog announcement has been mande on www.TheVacationCalendar.com.  

$EmailContent


Thank you for using the TheVacationCalendar.com


EOMAILBODY;

		
		$array = explode(',', BlogEmailList());
		foreach ($array as $value) 
		{
			mail ($value, 'TheVacationCalendar.com Blog Announcement', $mail_body, 'From: noreply@TheVacationCalendar.com');
		}

	}
		
	return true;
	
}


// Gets house list of people to email
function CalEmailList()
{
	$CalEmailListQuery = "SELECT CalEmailList
    			FROM House
				WHERE HouseId = ".$_SESSION['HouseId'];

	$CalEmailListResults = mysql_query( $CalEmailListQuery );
	if (!$CalEmailListResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find cal changes email list',  $CalEmailListQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
	
	if (mysql_num_rows($CalEmailListResults) > 0)
	{
		while ($CalEmailListRow = mysql_fetch_array($CalEmailListResults, MYSQL_ASSOC)) 
		{
			return $CalEmailListRow['CalEmailList'];	
		}
	}
	else
	{
		ActivityLog('Error', curPageURL(), 'Multiple email lists found for house',  $CalEmailListQuery, mysql_error());
		die ("Too many records returned: <br />". mysql_error());
		return "";
	}
	
}



// Gets house list of people to email
function BlogEmailList()
{
	$BlogEmailListQuery = "SELECT BlogEmailList
    			FROM House
				WHERE HouseId = ".$_SESSION['HouseId'];

	$BlogEmailListResults = mysql_query( $BlogEmailListQuery );
	if (!$BlogEmailListResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find blog email list',  $BlogEmailListQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
	
	if (mysql_num_rows($BlogEmailListResults) > 0)
	{
		while ($BlogEmailListRow = mysql_fetch_array($BlogEmailListResults, MYSQL_ASSOC)) 
		{
			return $BlogEmailListRow['BlogEmailList'];	
		}
	}
	else
	{
		ActivityLog('Error', curPageURL(), 'Multiple blog email lists found for house',  $BlogEmailListQuery, mysql_error());
		die ("Too many records returned: <br />". mysql_error());
		return "";
	}
	
}
// Calls a function to get the array of room usage for the month
// Used in Navigation.php
// Used in SaveVacations.php
function HasRooms()
{
	$HasRoomsQuery = "SELECT R.RoomId 
    			FROM Room R
				WHERE HouseId = ".$_SESSION['HouseId'];

	$HasRoomsResults = mysql_query( $HasRoomsQuery );
	if (!$HasRoomsResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if House has Rooms Defined',  $HasRoomsQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
	
	if (mysql_num_rows($HasRoomsResults) > 0)
	{
		return true;	
	}
	else
	{
		return false;
	}
}

// Calls a function to get the array of room usage for the month
// Used in Navigation.php
function IsAdminOwner()
{
	$IsAdminQuery = "SELECT AdminOwner
    			FROM user
				WHERE user_id = ".$_SESSION['OwnerId'];

	$IsAdminResults = mysql_query( $IsAdminQuery );
	if (!$IsAdminResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if Admin is Owner',  $IsAdminQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
	
	if (mysql_num_rows($IsAdminResults) > 0)
	{
		while ($IsAdminRow = mysql_fetch_array($IsAdminResults, MYSQL_ASSOC)) 
		{
			if ($IsAdminRow['AdminOwner'] == 'Y')
			{
				return true;	
			}
			else
			{
				return false;
			}
		}
	}
	else
	{
		return true;
	}
	
}

function IsHouseAdminOwner()
{
	$IsAdminQuery = "SELECT AdminOwner
    			FROM user
				WHERE HouseId = ".$_SESSION['HouseId']."
				AND role = 'Administrator'";

	$IsAdminResults = mysql_query( $IsAdminQuery );
	if (!$IsAdminResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if Admin of the House is Owner',  $IsAdminQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
	
	if (mysql_num_rows($IsAdminResults) > 0)
	{
		while ($IsAdminRow = mysql_fetch_array($IsAdminResults, MYSQL_ASSOC)) 
		{
			if ($IsAdminRow['AdminOwner'] == 'Y')
			{
				return true;	
			}
			else
			{
				return false;
			}
		}
	}
	else
	{
		return true;
	}
	
}

// Calls a function to get the array of room usage for the month
// Used in Navigation.php
function WantsIntro()
{
	$WantsIntroQuery = "SELECT Intro
    			FROM user
				WHERE user_id = ".$_SESSION['OwnerId'];

	$WantsIntroResults = mysql_query( $WantsIntroQuery );
	if (!$WantsIntroResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if User wants intro',  $WantsIntroQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
	
	if (mysql_num_rows($WantsIntroResults) > 0)
	{
		while ($WantsIntroRow = mysql_fetch_array($WantsIntroResults, MYSQL_ASSOC)) 
		{
			if ($WantsIntroRow['Intro'] == 'Y')
			{
				return true;	
			}
			else
			{
				return false;
			}
		}
	}
	else
	{
		return true;
	}
	
}


// Calls a function to get the array of room usage for the month
// Used in CreateCalendar.php
function GetUsedRooms($Month, $Year, &$UsedRoomsResults)
{
	$UsedRoomsQuery = "SELECT COUNT(DISTINCT(R.RoomId)) 'UsedRooms', C.Day
    			FROM Calendar C
					LEFT OUTER JOIN Schedule S ON C.DateID = S.DateID AND S.GuestId <> 0 AND S.HouseId = ".$_SESSION['HouseId']."
					LEFT OUTER JOIN Room R ON S.RoomId = R.RoomId
				WHERE DATE_FORMAT(C.RealDate, '%m') =".$Month."  
				AND DATE_FORMAT(C.RealDate, '%Y') =".$Year." 
				GROUP BY C.Day
    			ORDER BY C.Day";

	$UsedRoomsResults = mysql_query( $UsedRoomsQuery );
	if (!$UsedRoomsResults)
	{
		ActivityLog('Error', curPageURL(), 'Select array of room usage for the month',  $UsedRoomsQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
}

// Calls a function to get the available rooms in the house
// Used in CreateCalendar.php
function GetAvailableRooms($Month, $Year, &$Avail)
{
	$AvailRoomsQuery = "SELECT COUNT(R.RoomId) AvailRooms FROM Room R WHERE HouseId = ".$_SESSION['HouseId'];

	$AvailRoomsResults = mysql_query( $AvailRoomsQuery );
	if (!$AvailRoomsResults)
	{
		ActivityLog('Error', curPageURL(), 'Select the available rooms in the house',  $AvailRoomsQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

	while ($AvailRoomRow = mysql_fetch_array($AvailRoomsResults, MYSQL_ASSOC)) 
	{
		$Avail = $AvailRoomRow['AvailRooms'];
	}
}

// Calls a function to get the vacation for the current date
// Used in CreateCalendar.php
function GetVacation($Month, $Year, &$VacationResults)
{
   $VacationQuery = "SELECT DISTINCT V.VacationName, V.VacationId, V.AllowGuests, C.Day, V.BackGrndColor, V.FontColor, V.OwnerId
	FROM Calendar C
		LEFT OUTER JOIN Vacations V ON V.StartDateId <= C.DateId and V.EndDateId >= C.DateId and V.HouseId = ".$_SESSION['HouseId']."
	WHERE DATE_FORMAT(C.RealDate, '%m') =".$Month."  
	AND DATE_FORMAT(C.RealDate, '%Y') =".$Year." 
	GROUP BY C.Day
	ORDER BY C.Day";
   
	$VacationResults = mysql_query( $VacationQuery );
	if (!$VacationResults)
	{
		ActivityLog('Error', curPageURL(), 'Select vacation for the current date',  $VacationQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

}

// This function gets a list of all the rooms and their amenities
// Used by GetRoomInfo.php
function GetRoomData(&$RoomDataResult)
{
	$RoomDataQuery = "SELECT R.RoomId, R.RoomName, A.AmenityName, R.Beds
				  FROM Room R 
					LEFT JOIN RoomAmenity RA ON R.RoomId = RA.RoomId
					LEFT JOIN AmenityType A ON RA.AmenityID = A.AmenityID
				  WHERE HouseID = ".$_SESSION['HouseId']."
				  ORDER BY R.RoomName";

	$RoomDataResult = mysql_query( $RoomDataQuery );
	if (!$RoomDataResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the rooms and their amenities',  $RoomDataQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

}

// Used by GetVacationInfo.php
// Used by InputGuestSchedule.php
// Used by InputOwnerSchedule.php
// Used by SaveScheduledGuests.php
// Used by SaveScheduledOwner.php

function GetRooms(&$RoomResult)
{
	$RoomQuery = "SELECT R.RoomId, R.RoomName, R.Beds
	  FROM Room R 
	  WHERE HouseID = ".$_SESSION['HouseId']."
	  ORDER BY R.RoomName";
	  
	$RoomResult = mysql_query( $RoomQuery );
	if (!$RoomResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the rooms',  $RoomQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

}


// Used by GetVacationInfo.php
// Used by GetAllScheduledVacations
function GetAllVacationDates(&$VacationResult, $GetType, &$StartRange, &$StartDate, &$EndRange, &$EndDate, &$VacationName, &$VacationOwnerId)
{

// GetType: 0 = All, Integer = That specific record

	if ($GetType == 0)
	{
		$VacationQuery = "SELECT V.VacationName, V.VacationId, V.StartDateId, V.EndDateId, C1.RealDate StartDate, C2.RealDate EndDate, V.OwnerId
		  FROM Vacations V, Calendar C1, Calendar C2
		  WHERE V.StartDateId = C1.DateId
		  AND V.EndDateId = C2.DateId
		  AND V.HouseId = ".$_SESSION["HouseId"]."
		  ORDER BY V.StartDateId";
	}
	else
	{
		$VacationQuery = "SELECT V.VacationName, V.VacationId, V.StartDateId, V.EndDateId, C1.RealDate StartDate, C2.RealDate EndDate, V.OwnerId
		  FROM Vacations V, Calendar C1, Calendar C2
		  WHERE V.StartDateId = C1.DateId
		  AND V.EndDateId = C2.DateId
		  AND V.HouseId = ".$_SESSION["HouseId"]."
		  AND V.VacationId = ".$GetType."
		  ORDER BY V.StartDateId";
	
	}


	$VacationResult = mysql_query( $VacationQuery );
	if (!$VacationResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the vacations',  $VacationQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

	if (mysql_num_rows($VacationResult) > 0)
	{
		while ($VacationRow = mysql_fetch_array($VacationResult, MYSQL_ASSOC)) 
		{
			$StartRange = $VacationRow['StartDateId'];
			$StartDate = $VacationRow['StartDate'];
			$EndRange = $VacationRow['EndDateId'];
			$EndDate = $VacationRow['EndDate'];
			$VacationName = $VacationRow['VacationName'];
			$VacationOwnerId = $VacationRow['OwnerId'];
		}

		mysql_data_seek($VacationResult, 0);
	}

	$df_src = 'Y-m-d';
	$df_des = 'n/j/Y';

	$StartDate = dates_interconv( $df_src, $df_des, $StartDate);
	$EndDate = dates_interconv( $df_src, $df_des, $EndDate);
		
}

// This function gets a list of the vacation dates
// Used by GetScheduledVacations.php
// Used by InputGuestSchedule.php
// Used by InputOwnerSchedule.php
// Used by SaveVacations.php
function GetVacationDates(&$VacationResult, $GetType, &$StartRange, &$StartDate, &$EndRange, &$EndDate, &$VacationName, &$AllowGuests, &$AllowOwners, &$FirstName, &$LastName, &$OwnerIdVal, &$BkgrndColor, &$FontColor)
{

// GetType: 0 = All, Integer = That specific record

	if ($GetType == 0)
	{
		$VacationQuery = "SELECT V.VacationName, V.VacationId, V.StartDateId, V.EndDateId, C1.RealDate StartDate, C2.RealDate EndDate, V.AllowGuests, V.AllowOwners, U.first_name FirstName, U.last_name LastName, V.OwnerId, V.BackGrndColor, V.FontColor
		  FROM Vacations V, Calendar C1, Calendar C2, user U
		  WHERE V.StartDateId = C1.DateId
		  AND V.EndDateId = C2.DateId
		  AND V.OwnerId = U.user_id
		  AND V.HouseId = ".$_SESSION["HouseId"]."
		  AND (V.OwnerId = ".$_SESSION["OwnerId"]." OR V.AllowOwners = 'Y')
		  AND C2.RealDate >=  DATE_ADD(NOW(), INTERVAL -180 DAY)
		  ORDER BY V.StartDateId";

	}
	else
	{
		$VacationQuery = "SELECT V.VacationName, V.VacationId, V.StartDateId, V.EndDateId, C1.RealDate StartDate, C2.RealDate EndDate, V.AllowGuests, V.AllowOwners, U.first_name FirstName, U.last_name LastName, V.OwnerId, V.BackGrndColor, V.FontColor
		  FROM Vacations V, Calendar C1, Calendar C2, user U
		  WHERE V.StartDateId = C1.DateId
		  AND V.EndDateId = C2.DateId
		  AND V.OwnerId = U.user_id
		  AND V.HouseId = ".$_SESSION["HouseId"]." 
		  AND (V.OwnerId = ".$_SESSION["OwnerId"]." OR V.AllowOwners = 'Y')
		  AND V.VacationId = ".$GetType."
		  AND C2.RealDate >=  DATE_ADD(NOW(), INTERVAL -180 DAY)
		  ORDER BY V.StartDateId";

		  
	
	}
//echo $VacationQuery;
	$VacationResult = mysql_query( $VacationQuery );
	if (!$VacationResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the vacations within range',  $VacationQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

	if (mysql_num_rows($VacationResult) > 0)
	{
		while ($VacationRow = mysql_fetch_array($VacationResult, MYSQL_ASSOC)) 
		{
			$StartRange = $VacationRow['StartDateId'];
			$StartDate = $VacationRow['StartDate'];
			$EndRange = $VacationRow['EndDateId'];
			$EndDate = $VacationRow['EndDate'];
			$VacationName = $VacationRow['VacationName'];
			$AllowGuests = $VacationRow['AllowGuests'];
			$AllowOwners = $VacationRow['AllowOwners'];
			$FirstName = $VacationRow['FirstName'];
			$LastName = $VacationRow['LastName'];
			$OwnerIdVal = $VacationRow['OwnerId'];
			$BkgrndColor = $VacationRow['BackGrndColor'];
			$FontColor = $VacationRow['FontColor'];
		}

		mysql_data_seek($VacationResult, 0);
	}

	$df_src = 'Y-m-d';
	$df_des = 'n/j/Y';

	$StartDate = dates_interconv( $df_src, $df_des, $StartDate);
	$EndDate = dates_interconv( $df_src, $df_des, $EndDate);
	
}

// Function to get a list of available guests for the owner
// Used by InputGuestSchedules

function GetGuests(&$GuestResult, $ShowGuest)
{

	if ($ShowGuest == 'Y')
	{
		$AddCode = " OR HouseGuest = 'Y'";
	}
	else
	{
		$AddCode = "";	
	}

	$GuestQuery = "(SELECT CONCAT(FirstName, ' ', LastName) Name, GuestId 
				FROM Guest 
				WHERE (OwnerId = ".$_SESSION["OwnerId"].$AddCode.")
				AND HouseId = ".$_SESSION["HouseId"].")
				UNION
				(SELECT CONCAT(first_name, ' ', last_name) Name, user_id
				FROM user
				WHERE HouseId = ".$_SESSION["HouseId"]."
				AND Role IN ('Owner'))
				ORDER BY 1";
//echo $GuestQuery;			

	if (IsHouseAdminOwner())
	{
		$GuestQuery = str_replace('\'Owner\'', '\'Owner\', \'Administrator\'', $GuestQuery); 
	}

	$GuestResult = mysql_query( $GuestQuery );
	if (!$GuestResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of the guests for an owner',  $GuestQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

}

// Function to get a list of available guests for the owner
// Used by InputGuestSchedules

function GetAllGuests(&$GuestResult)
{

	$GuestQuery = "(SELECT CONCAT(FirstName, ' ', LastName) Name, GuestId 
				FROM Guest 
				WHERE HouseId = ".$_SESSION["HouseId"].")
				UNION
				(SELECT CONCAT(first_name, ' ', last_name) Name, user_id
				FROM user
				WHERE HouseId = ".$_SESSION["HouseId"]."
				AND Role IN ('Owner'))
				ORDER BY 1";
			  
	if (IsHouseAdminOwner())
	{
		$GuestQuery = str_replace('\'Owner\'', '\'Owner\', \'Administrator\'', $GuestQuery); 
	}

	$GuestResult = mysql_query( $GuestQuery );
	if (!$GuestResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the guests for an owner',  $GuestQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

}


// Used by SaveVacations.pho
function AddRemoveDays($VacationId, $InitialRange, $NewRange, $FrontOrEnd)
{
	if ($InitialRange == $NewRange)
	{
		return;
	}
	elseif ((($InitialRange < $NewRange) && ($FrontOrEnd == 'Front')) || (($InitialRange > $NewRange) && ($FrontOrEnd == 'End')))
	{
		// Delete Days
		IF ($FrontOrEnd == 'Front')
		{
//		echo "Front Logic - ".$InitialRange." - ".$NewRange."<br/>";
			$DeleteDaysQuery = "DELETE FROM Schedule 
				WHERE OwnerId = ".$_SESSION['OwnerId']."
				AND HouseId = ".$_SESSION['HouseId']."
				AND VacationId = ".$VacationId."
				AND DateId >= ".$InitialRange."
				AND DateId < ".$NewRange;
		}
		else
		{
//		echo "End Logic - ".$InitialRange." - ".$NewRange."<br/>";
		
			$DeleteDaysQuery = "DELETE FROM Schedule 
				WHERE OwnerId = ".$_SESSION['OwnerId']."
				AND HouseId = ".$_SESSION['HouseId']."
				AND VacationId = ".$VacationId."
				AND DateId <= ".$InitialRange."
				AND DateId > ".$NewRange;
		}
		
		if (!mysql_query( $DeleteDaysQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Deletes vacation days from range',  $DeleteDaysQuery, mysql_error());
			die ("Could not Delete into the database: <br />". mysql_error());
		}
		
	}
	else
	{
		// Insert Days
		IF ($FrontOrEnd == 'Front')
		{
			$Start = $NewRange;
			$End = $InitialRange - 1;
		}
		else
		{
			$Start = $InitialRange + 1;
			$End = $NewRange;
		}
			
		for ($Counter = $Start ; $Counter <= $End; $Counter++) 
		{
		
			if ($_POST['OwnerRoom'] != 0)
			{
				$InsertOwnerQuery = "INSERT INTO Schedule (OwnerId, DateId, HouseId, RoomID, GuestId, VacationId, Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
					VALUES (".$_SESSION['OwnerId'].", ".$Counter.", ".$_SESSION['HouseId'].", ".$_POST['OwnerRoom'].", ".$_SESSION['OwnerId'].", ".$VacationId.", '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
				if (!mysql_query( $InsertOwnerQuery ))
				{
					ActivityLog('Error', curPageURL(), 'Inserts Owner into Schedule',  $InsertOwnerQuery, mysql_error());
					die ("Could not insert into the database: <br />". mysql_error());
				}
			}
			
			GetRooms($RoomResult);
			
			while ($RoomRow = mysql_fetch_array($RoomResult, MYSQL_ASSOC)) 
			{
				if ($_POST['OwnerRoom'] != $RoomRow['RoomId'])
				{
					$InsertDefaultGuests = "INSERT INTO Schedule (OwnerId, DateId, HouseId, RoomID, GuestId, VacationId,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
					VALUES (".$_SESSION['OwnerId'].", ".$Counter.", ".$_SESSION['HouseId'].", ".$RoomRow['RoomId'].", 0, ".$VacationId.", '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
	
					if (!mysql_query( $InsertDefaultGuests ))
					{
						ActivityLog('Error', curPageURL(), 'Inserts Guests into Schedule',  $InsertDefaultGuests, mysql_error());
						die ("Could not insert into the database: <br />". mysql_error());
					}
				}
			}
		}
	}
}
?>


<?php
/**
 * Converts a date string from one format to another (e.g. d/m/Y => Y-m-d, d.m.Y => Y/d/m, ...)
 *
 * @param string $date_format1
 * @param string $date_format2
 * @param string $date_str
 * @return string
 */
function dates_interconv( $date_format1, $date_format2, $date_str )
{
   $base_struc    = split('[/.-]', $date_format1);
   $date_str_parts = split('[/.-]', $date_str );
  
//   print_r( $base_struc ); echo "<br/>";
//   print_r( $date_str_parts ); echo "<br/>";
  
   $date_elements = array();
  
   $p_keys = array_keys( $base_struc );
   foreach ( $p_keys as $p_key )
   {
	   if ( !empty( $date_str_parts[$p_key] ))
	   {
		   $date_elements[$base_struc[$p_key]] = $date_str_parts[$p_key];
	   }
	   else
		   return false;
   }
  
   $dummy_ts = mktime( 0,0,0, $date_elements['m'],$date_elements['d'],$date_elements['Y']);
  
   return date( $date_format2, $dummy_ts );
}


// Used by OwnerAdministration.php

function GetOwners(&$GetOwnersResult)
{
	$GetOwnersQuery = "SELECT U.first_name, U.last_name, U.email, U.user_id
	  FROM user U where role = 'Owner'";

	$GetOwnersResult = mysql_query( $GetOwnersQuery );
	if (!$GetOwnersResult)
	{
		ActivityLog('Error', curPageURL(), 'Select list of owners',  $GetOwnersQuery, mysql_error());
		die ("Could not query the database for users: <br />". mysql_error());
	}
}

?>