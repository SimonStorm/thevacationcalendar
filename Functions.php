
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
function GetAvailableBunks($Month, $Year, $AvailableBunksArray)
{
	$UsedRoomsQuery = "SELECT COUNT(R.RoomId) 'UsedRooms', C.Day
    			FROM Calendar C
					LEFT OUTER JOIN Schedule S ON C.DateID = S.DateID AND S.GuestId <> 0 AND S.HouseId = ".$_SESSION['HouseId']."
					LEFT OUTER JOIN Room R ON S.RoomId = R.RoomId
				WHERE DATE_FORMAT(C.RealDate, '%m') =".$Month."  
				AND DATE_FORMAT(C.RealDate, '%Y') =".$Year." 
				GROUP BY C.Day
    			ORDER BY C.Day";

	$UsedRoomsResults = mysqli_query( $GLOBALS['link'],  $UsedRoomsQuery );
	if (!$UsedRoomsResults)
	{
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
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
		VALUES ('".$LogLevel."', '".$WebPage."', '".$Comment."', SYSDATE(), '".$HouseId."', '".$UserName."', '".$Role."', '".mysqli_real_escape_string($GLOBALS['link'], $Query)."', '".mysqli_real_escape_string($GLOBALS['link'], $ErrorMsg)."')";

		if (!mysqli_query( $GLOBALS['link'], $InsertActivityLog ))
		{
			die ("Could not insert logging into the database: <br />". mysqli_error($GLOBALS['link']));
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

	$ShowOldSaveResults = mysqli_query( $GLOBALS['link'],  $ShowOldSaveQuery );
	if (!$ShowOldSaveResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if User wants to use the old save vacation',  $ShowOldSaveQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	if (mysqli_num_rows($ShowOldSaveResults) > 0)
	{
		while ($ShowOldSaveRow = mysqli_fetch_array($ShowOldSaveResults, MYSQL_ASSOC)) 
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
		ActivityLog('Error', curPageURL(), 'Multiple users found for User wants to use the old save vacation',  $ShowOldSaveQuery, mysqli_error($GLOBALS['link']));
		die ("Too many records returned: <br />". mysqli_error($GLOBALS['link']));
		return "";
	}
	
}


// SaveVacations.php
function SendNotification($Change, $VacationId)
{

	if (strlen(CalEmailList()) > 0)
	{	
		$VacationResult = GetVacationDates($VacationResult, $VacationId, $StartRange, $StartDate, $EndRange, $EndDate, $VacationName, $AllowGuests, $AllowOwners, $FirstName, $LastName, $OwnerIdVal, $BkgrndColor, $FontColor);	
		
		$EmailContent = "";
		while ($VacationInfoRow = mysqli_fetch_array($VacationResult, MYSQL_ASSOC)) 
		{
			 $EmailContent .= $VacationInfoRow['VacationName']." has been ".$Change." from ".$VacationInfoRow['StartDate']." to ".$VacationInfoRow['EndDate'];
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
		$BlogResult = GetBlog($BlogId, 'B');
		
		$EmailContent = "";
		while ($BlogRow = mysqli_fetch_array($BlogResult, MYSQL_ASSOC)) 
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

	$CalEmailListResults = mysqli_query( $GLOBALS['link'],  $CalEmailListQuery );
	if (!$CalEmailListResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find cal changes email list',  $CalEmailListQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	if (mysqli_num_rows($CalEmailListResults) > 0)
	{
		while ($CalEmailListRow = mysqli_fetch_array($CalEmailListResults, MYSQL_ASSOC)) 
		{
			return $CalEmailListRow['CalEmailList'];	
		}
	}
	else
	{
		ActivityLog('Error', curPageURL(), 'Multiple email lists found for house',  $CalEmailListQuery, mysqli_error($GLOBALS['link']));
		die ("Too many records returned: <br />". mysqli_error($GLOBALS['link']));
		return "";
	}
	
}



// Gets house list of people to email
function BlogEmailList()
{
	$BlogEmailListQuery = "SELECT BlogEmailList
    			FROM House
				WHERE HouseId = ".$_SESSION['HouseId'];

	$BlogEmailListResults = mysqli_query( $GLOBALS['link'],  $BlogEmailListQuery );
	if (!$BlogEmailListResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find blog email list',  $BlogEmailListQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	if (mysqli_num_rows($BlogEmailListResults) > 0)
	{
		while ($BlogEmailListRow = mysqli_fetch_array($BlogEmailListResults, MYSQL_ASSOC)) 
		{
			return $BlogEmailListRow['BlogEmailList'];	
		}
	}
	else
	{
		ActivityLog('Error', curPageURL(), 'Multiple blog email lists found for house',  $BlogEmailListQuery, mysqli_error($GLOBALS['link']));
		die ("Too many records returned: <br />". mysqli_error($GLOBALS['link']));
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

	$HasRoomsResults = mysqli_query( $GLOBALS['link'],  $HasRoomsQuery );
	if (!$HasRoomsResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if House has Rooms Defined',  $HasRoomsQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	if (mysqli_num_rows($HasRoomsResults) > 0)
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

	$IsAdminResults = mysqli_query( $GLOBALS['link'], $IsAdminQuery );
	if (!$IsAdminResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if Admin is Owner',  $IsAdminQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	if (mysqli_num_rows($IsAdminResults) > 0)
	{
		while ($IsAdminRow = mysqli_fetch_array($IsAdminResults, MYSQL_ASSOC)) 
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

	$IsAdminResults = mysqli_query( $GLOBALS['link'],  $IsAdminQuery );
	if (!$IsAdminResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if Admin of the House is Owner',  $IsAdminQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	if (mysqli_num_rows($IsAdminResults) > 0)
	{
		while ($IsAdminRow = mysqli_fetch_array($IsAdminResults, MYSQL_ASSOC)) 
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

	$WantsIntroResults = mysqli_query( $GLOBALS['link'],  $WantsIntroQuery );
	if (!$WantsIntroResults)
	{
		ActivityLog('Error', curPageURL(), 'Select to find if User wants intro',  $WantsIntroQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	if (mysqli_num_rows($WantsIntroResults) > 0)
	{
		while ($WantsIntroRow = mysqli_fetch_array($WantsIntroResults, MYSQL_ASSOC)) 
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
function GetUsedRooms($Month, $Year, $UsedRoomsResults)
{
	$UsedRoomsQuery = "SELECT COUNT(DISTINCT(R.RoomId)) 'UsedRooms', C.Day
    			FROM Calendar C
					LEFT OUTER JOIN Schedule S ON C.DateID = S.DateID AND S.GuestId <> 0 AND S.HouseId = ".$_SESSION['HouseId']."
					LEFT OUTER JOIN Room R ON S.RoomId = R.RoomId
				WHERE DATE_FORMAT(C.RealDate, '%m') =".$Month."  
				AND DATE_FORMAT(C.RealDate, '%Y') =".$Year." 
				GROUP BY C.Day
    			ORDER BY C.Day";

	$UsedRoomsResults = mysqli_query( $GLOBALS['link'],  $UsedRoomsQuery );
	if (!$UsedRoomsResults)
	{
		ActivityLog('Error', curPageURL(), 'Select array of room usage for the month',  $UsedRoomsQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
}

// Calls a function to get the available rooms in the house
// Used in CreateCalendar.php
function GetAvailableRooms($Month, $Year, $Avail)
{
	$AvailRoomsQuery = "SELECT COUNT(R.RoomId) AvailRooms FROM Room R WHERE HouseId = ".$_SESSION['HouseId'];

	$AvailRoomsResults = mysqli_query( $GLOBALS['link'],  $AvailRoomsQuery );
	if (!$AvailRoomsResults)
	{
		ActivityLog('Error', curPageURL(), 'Select the available rooms in the house',  $AvailRoomsQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}

	while ($AvailRoomRow = mysqli_fetch_array($AvailRoomsResults, MYSQL_ASSOC)) 
	{
		$Avail = $AvailRoomRow['AvailRooms'];
	}
}

// Calls a function to get the vacation for the current date
// Used in CreateCalendar.php
function GetVacation($startDt, $EndDt)
{
   $VacationQuery = "SELECT DISTINCT V.VacationName, V.VacationId, V.AllowGuests, C.Day, CE.Day, V.BackGrndColor, 
	V.FontColor, V.OwnerId, CONCAT_WS(' ', C.RealDate,T.time) as StartDate, CONCAT_WS(' ', CE.RealDate,TE.time) as EndDate
	FROM Vacations V 
    JOIN Calendar C ON C.DateId = V.StartDateId and V.HouseId = ".$_SESSION['HouseId']."
    JOIN Calendar CE ON CE.DateId = V.EndDateId and V.HouseId = ".$_SESSION['HouseId']."
    JOIN Time T ON T.timeid = V.StartTimeId and V.HouseId = ".$_SESSION['HouseId']."
    JOIN Time TE ON TE.timeid = V.EndtimeId and V.HouseId = ".$_SESSION['HouseId']."  	
    Where V.HouseId = ".$_SESSION['HouseId']."
    AND (C.RealDate > STR_TO_DATE('".$startDt."','%Y-%m-%d')
    AND C.RealDate < STR_TO_DATE('".$EndDt."','%Y-%m-%d'))
    OR
    (CE.RealDate > STR_TO_DATE('".$startDt."','%Y-%m-%d')
    AND CE.RealDate < STR_TO_DATE('".$EndDt."','%Y-%m-%d'))
	order by V.StartDateId asc";

	$VacationResults = mysqli_query( $GLOBALS['link'],  $VacationQuery );

	if (!$VacationResults)
	{
		ActivityLog('Error', curPageURL(), 'Select vacation for the current date',  $VacationQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}

	return $VacationResults;
	
}

// This function gets a list of all the rooms and their amenities
// Used by GetRoomInfo.php
function GetRoomData($RoomDataResult)
{
	$RoomDataQuery = "SELECT R.RoomId, R.RoomName, A.AmenityName, R.Beds
				  FROM Room R 
					LEFT JOIN RoomAmenity RA ON R.RoomId = RA.RoomId
					LEFT JOIN AmenityType A ON RA.AmenityID = A.AmenityID
				  WHERE HouseID = ".$_SESSION['HouseId']."
				  ORDER BY R.RoomName";

	$RoomDataResult = mysqli_query( $GLOBALS['link'],  $RoomDataQuery );
	if (!$RoomDataResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the rooms and their amenities',  $RoomDataQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}

}

// Used by GetVacationInfo.php
// Used by InputGuestSchedule.php
// Used by InputOwnerSchedule.php
// Used by SaveScheduledGuests.php
// Used by SaveScheduledOwner.php

function GetRooms($RoomResult)
{
	$RoomQuery = "SELECT R.RoomId, R.RoomName, R.Beds
	  FROM Room R 
	  WHERE HouseID = ".$_SESSION['HouseId']."
	  ORDER BY R.RoomName";
	  
	$RoomResult = mysqli_query( $GLOBALS['link'],  $RoomQuery );
	if (!$RoomResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the rooms',  $RoomQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}

}


// Used by GetVacationInfo.php
// Used by GetAllScheduledVacations
function GetAllVacationDates($VacationResult, $GetType, $StartRange, $StartDate, $EndRange, $EndDate, $VacationName, $VacationOwnerId)
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


	$VacationResult = mysqli_query( $GLOBALS['link'],  $VacationQuery );
	if (!$VacationResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the vacations',  $VacationQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}

	if (mysqli_num_rows($VacationResult) > 0)
	{
		while ($VacationRow = mysqli_fetch_array($VacationResult, MYSQL_ASSOC)) 
		{
			$StartRange = $VacationRow['StartDateId'];
			$StartDate = $VacationRow['StartDate'];
			$EndRange = $VacationRow['EndDateId'];
			$EndDate = $VacationRow['EndDate'];
			$VacationName = $VacationRow['VacationName'];
			$VacationOwnerId = $VacationRow['OwnerId'];
		}

		mysqli_data_seek($VacationResult, 0);
	}

	$df_src = 'Y-m-d';
	$df_des = 'n/j/Y';

	$StartDate = dates_interconv( $df_src, $df_des, $StartDate);
	$EndDate = dates_interconv( $df_src, $df_des, $EndDate);
		
	return $VacationResult;	
}

// This function gets a list of the vacation dates
// Used by GetScheduledVacations.php
// Used by InputGuestSchedule.php
// Used by InputOwnerSchedule.php
// Used by SaveVacations.php
function GetVacationDates($VacationResult, $GetType, $StartRange, $StartDate, $EndRange, $EndDate, $VacationName, $AllowGuests, $AllowOwners, $FirstName, $LastName, $OwnerIdVal, $BkgrndColor, $FontColor)
{

// GetType: 0 = All, Integer = That specific record
	if ($GetType == 0)
	{
		$VacationQuery = "SELECT V.VacationName, V.VacationId, V.StartDateId, V.EndDateId, T.time StartTime, TE.time EndTime, C1.RealDate StartDate, C2.RealDate EndDate, V.AllowGuests, V.AllowOwners, U.first_name FirstName, U.last_name LastName, V.OwnerId, V.BackGrndColor, V.FontColor
		  FROM Vacations V, Calendar C1, Calendar C2, user U, Time T, Time TE 
		  WHERE V.StartDateId = C1.DateId
		  AND V.EndDateId = C2.DateId
		  AND V.EndTimeId = TE.timeid
		  AND V.StartTimeId = T.timeid
		  AND V.OwnerId = U.user_id
		  AND V.HouseId = ".$_SESSION["HouseId"]."
		  AND (V.OwnerId = ".$_SESSION["OwnerId"]." OR V.AllowOwners = 'Y')
		  AND C2.RealDate >=  DATE_ADD(NOW(), INTERVAL -180 DAY)
		  ORDER BY V.StartDateId";

	}
	else
	{
		$VacationQuery = "SELECT V.VacationName, V.VacationId, V.StartDateId, V.EndDateId, T.time StartTime, TE.time EndTime, C1.RealDate StartDate, C2.RealDate EndDate, V.AllowGuests, V.AllowOwners, U.first_name FirstName, U.last_name LastName, V.OwnerId, V.BackGrndColor, V.FontColor
		  FROM Vacations V, Calendar C1, Calendar C2, user U, Time T, Time TE 
		  WHERE V.StartDateId = C1.DateId
		  AND V.EndDateId = C2.DateId
		  AND V.EndTimeId = TE.timeid
		  AND V.StartTimeId = T.timeid		  
		  AND V.OwnerId = U.user_id
		  AND V.HouseId = ".$_SESSION["HouseId"]." 
		  AND (V.OwnerId = ".$_SESSION["OwnerId"]." OR V.AllowOwners = 'Y')
		  AND V.VacationId = ".$GetType."
		  AND C2.RealDate >=  DATE_ADD(NOW(), INTERVAL -180 DAY)
		  ORDER BY V.StartDateId";

		  
	
	}
//echo $VacationQuery;
	$VacationResult = mysqli_query( $GLOBALS['link'],  $VacationQuery );
	if (!$VacationResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the vacations within range',  $VacationQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}

	if (mysqli_num_rows($VacationResult) > 0)
	{
		while ($VacationRow = mysqli_fetch_array($VacationResult, MYSQL_ASSOC)) 
		{
			$StartRange = $VacationRow['StartDateId'];
			$StartDate = $VacationRow['StartDate'];
			$StartTime = $VacationRow['StartTime'];			
			$EndRange = $VacationRow['EndDateId'];
			$EndDate = $VacationRow['EndDate'];
			$EndTime = $VacationRow['EndTime'];
			$VacationName = $VacationRow['VacationName'];
			$AllowGuests = $VacationRow['AllowGuests'];
			$AllowOwners = $VacationRow['AllowOwners'];
			$FirstName = $VacationRow['FirstName'];
			$LastName = $VacationRow['LastName'];
			$OwnerIdVal = $VacationRow['OwnerId'];
			$BkgrndColor = $VacationRow['BackGrndColor'];
			$FontColor = $VacationRow['FontColor'];
		}

		mysqli_data_seek($VacationResult, 0);
	}

	$df_src = 'Y-m-d';
	$df_des = 'n/j/Y';

	$StartDate = dates_interconv( $df_src, $df_des, $StartDate);
	$EndDate = dates_interconv( $df_src, $df_des, $EndDate);
	
	return $VacationResult;
}

// Function to get a list of available guests for the owner
// Used by InputGuestSchedules

function GetGuests($GuestResult, $ShowGuest)
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

	$GuestResult = mysqli_query( $GLOBALS['link'],  $GuestQuery );
	if (!$GuestResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of the guests for an owner',  $GuestQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}

}

// Function to get a list of available guests for the owner
// Used by InputGuestSchedules

function GetAllGuests($GuestResult)
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

	$GuestResult = mysqli_query( $GLOBALS['link'],  $GuestQuery );
	if (!$GuestResult)
	{
		ActivityLog('Error', curPageURL(), 'Select a list of all the guests for an owner',  $GuestQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
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
		
		if (!mysqli_query( $GLOBALS['link'],  $DeleteDaysQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Deletes vacation days from range',  $DeleteDaysQuery, mysqli_error($GLOBALS['link']));
			die ("Could not Delete into the database: <br />". mysqli_error($GLOBALS['link']));
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
			
		/*	
		for ($Counter = $Start ; $Counter <= $End; $Counter++) 
		{
		
			if ($_POST['OwnerRoom'] != 0)
			{
				$InsertOwnerQuery = "INSERT INTO Schedule (OwnerId, DateId, HouseId, RoomID, GuestId, VacationId, Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
					VALUES (".$_SESSION['OwnerId'].", ".$Counter.", ".$_SESSION['HouseId'].", , ".$_SESSION['OwnerId'].", ".$VacationId.", '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
				if (!mysqli_query( $GLOBALS['link'],  $InsertOwnerQuery ))
				{
					ActivityLog('Error', curPageURL(), 'Inserts Owner into Schedule',  $InsertOwnerQuery, mysqli_error($GLOBALS['link']));
					die ("Could not insert into the database: <br />". mysqli_error($GLOBALS['link']));
				}
			}
			

			GetRooms($RoomResult);
			
			while ($RoomRow = mysqli_fetch_array($RoomResult, MYSQL_ASSOC)) 
			{
				if ($_POST['OwnerRoom'] != $RoomRow['RoomId'])
				{
					$InsertDefaultGuests = "INSERT INTO Schedule (OwnerId, DateId, HouseId, RoomID, GuestId, VacationId,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
					VALUES (".$_SESSION['OwnerId'].", ".$Counter.", ".$_SESSION['HouseId'].", ".$RoomRow['RoomId'].", 0, ".$VacationId.", '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
	
					if (!mysqli_query( $GLOBALS['link'],  $InsertDefaultGuests ))
					{
						ActivityLog('Error', curPageURL(), 'Inserts Guests into Schedule',  $InsertDefaultGuests, mysqli_error($GLOBALS['link']));
						die ("Could not insert into the database: <br />". mysqli_error($GLOBALS['link']));
					}
				}
			}
			
		}
		*/
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

function GetOwners($GetOwnersResult)
{
	$GetOwnersQuery = "SELECT U.first_name, U.last_name, U.email, U.user_id
	  FROM user U where role = 'Owner'";

	$GetOwnersResult = mysqli_query( $GLOBALS['link'],  $GetOwnersQuery );
	if (!$GetOwnersResult)
	{
		ActivityLog('Error', curPageURL(), 'Select list of owners',  $GetOwnersQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database for users: <br />". mysqli_error($GLOBALS['link']));
	}
}

?>