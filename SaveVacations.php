<?php ActivityLog('Info', curPageURL(), 'Save Vacations Include',  NULL, NULL); ?>
<?php
//This section displays the selected dates in a row
$self = $_SERVER['PHP_SELF'];

function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}


$self = $_SERVER['PHP_SELF'];

//This is delete logic
if ((isset($_POST["submittype"]) && $_POST["submittype"] == 'deletesubmit')||(isset($_GET["Change"]) && $_GET["Change"] == "Delete"))
{   
		if(isset($_POST["VacationId"])){
			$vacationIdVar = $_POST["VacationId"];
		}elseif(isset($_GET["VacationId"])){
			$vacationIdVar = $_GET["VacationId"];
		}
	
		SendNotification('deleted', $vacationIdVar);
		
		$DeleteOwnerQuery = "DELETE FROM Schedule 
			WHERE HouseId = ".$_SESSION['HouseId']." 
			AND DateId >= (SELECT StartDateId FROM Vacations WHERE VacationId = ".$vacationIdVar.")
			AND DateId <= (SELECT EndDateId FROM Vacations WHERE VacationId = ".$vacationIdVar.")";

		if (!mysqli_query( $GLOBALS['link'],  $DeleteOwnerQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Scheduled Vacation Days',  $DeleteOwnerQuery, mysqli_error($GLOBALS['link']));
			die ("Could not delete scheduled visitors from the database:". mysqli_error($GLOBALS['link']));
		}
		
		$DeleteOwnerVacation = "DELETE FROM Vacations 
			WHERE OwnerId = ".$_SESSION['OwnerId']." 
			AND HouseId = ".$_SESSION['HouseId']." 
			AND VacationId = ".$vacationIdVar;

		if (!mysqli_query( $GLOBALS['link'],  $DeleteOwnerVacation ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Scheduled Vacations',  $DeleteOwnerVacation, mysqli_error($GLOBALS['link']));
			die ("Could not delete owner vacation from the database:". mysqli_error($GLOBALS['link']));
		}

		echo "Congrats you have deleted your vacation";
}
//This is insert logic
elseif (isset($_POST["submittype"]) && $_POST["submittype"] == 'savesubmit')
{   
	if(!isset($_POST["VacationName"] ) || $_POST["VacationName"] == '' ){
		die ("Vacation Name is required");
	}else
	if(preg_match('/"/', $_POST["VacationName"])){
		die ("Vacation Name cannot include a double quote");	
	}
	
	if (!isset($_POST["vacStartDate"]) || $_POST["vacStartDate"] == ''
			|| !isset($_POST["vacEndDate"]) || $_POST["vacEndDate"] == '')
	{
			die ("Date is not valid");
	}
	
	if ($_POST["vacStartDate"] == $_POST["vacEndDate"])
	{
			die ("Start and End Dates cannot be the same");
	}	
	
	$startDateAsDate = new DateTime($_POST["vacStartDate"]);
	$endDateAsDate = new DateTime($_POST["vacEndDate"]);
	if($endDateAsDate < $startDateAsDate){
		die ("Start date must be before end date");
	}	
	
	$startdate = explode('/', $_POST["vacStartDate"]);
	$StartMonth = $startdate[0];
	$StartDay = $startdate[1];
	$tempparsestart = explode(' ', $startdate[2]);
	$StartYear = $tempparsestart[0];
	$StartTime = $tempparsestart[1];
	
	$enddate = explode('/', $_POST["vacEndDate"]);
	$EndMonth = $enddate[0];
	$EndDay = $enddate[1];
	$tempparseend = explode(' ', $enddate[2]);
	$EndYear = $tempparseend[0];
	$EndTime = $tempparseend[1];		

	if (!checkdate($StartMonth, $StartDay, $StartYear))
	{
		die ("Invalid start date");
	}
	elseif (!checkdate($EndMonth, $EndDay, $EndYear))
	{
		die ("Invalid end date");
	}
	elseif (date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear)) > date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear)))
	{
		die ("Start date must be before end date");
	}
	else
	{

		$StartQuery = "SELECT C.RealDate, C.DateId
 		  FROM Calendar C, Calendar CE, Vacations V, Time T, Time TE
 		  WHERE 
 		  C.DateId = V.StartDateId
 		  AND CE.DateId = V.EndDateId
 		  AND T.timeid = V.StartTimeId
		  AND TE.timeid = V.EndTimeId
 		  AND ((CONCAT_WS(' ', C.RealDate,T.time) < STR_TO_DATE('".$_POST["vacStartDate"]."', '%m/%d/%Y %H:%i')
				AND CONCAT_WS(' ', CE.RealDate,TE.time) > STR_TO_DATE('".$_POST["vacStartDate"]."', '%m/%d/%Y %H:%i'))
			OR
			   (CONCAT_WS(' ', C.RealDate,T.time) > STR_TO_DATE('".$_POST["vacStartDate"]."', '%m/%d/%Y %H:%i')
			    AND CONCAT_WS(' ', CE.RealDate,TE.time) < STR_TO_DATE('".$_POST["vacEndDate"]."', '%m/%d/%Y %H:%i'))
			OR
			   (CONCAT_WS(' ', C.RealDate,T.time) > STR_TO_DATE('".$_POST["vacStartDate"]."', '%m/%d/%Y %H:%i')
			    AND CONCAT_WS(' ', C.RealDate,T.time) < STR_TO_DATE('".$_POST["vacEndDate"]."', '%m/%d/%Y %H:%i'))
		  )
		  AND V.HouseId = ".$_SESSION['HouseId'];
		  

		$result = mysqli_query( $GLOBALS['link'], $StartQuery);
		ActivityLog('Error', curPageURL(), 'Select Start Date Range',  $StartQuery, mysqli_error($GLOBALS['link']));
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select Start Date Range',  $StartQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database:". mysqli_error($GLOBALS['link']));
		}
		elseif (mysqli_num_rows($result) > 0)
		{
			die ("Another vacation conflicts with your dates");
		}

		$StartQuery = "SELECT C.RealDate, C.DateId
 		  FROM Calendar C, Calendar CE, Vacations V, Time T, Time TE
 		  WHERE 
 		  C.DateId = V.StartDateId
 		  AND CE.DateId = V.EndDateId
 		  AND T.timeid = V.StartTimeId
		  AND TE.timeid = V.EndTimeId
 		  AND CONCAT_WS(' ', C.RealDate,T.time) < STR_TO_DATE('".$_POST["vacEndDate"]."', '%m/%d/%Y %H:%i')
 		  AND CONCAT_WS(' ', CE.RealDate,TE.time) > STR_TO_DATE('".$_POST["vacEndDate"]."', '%m/%d/%Y %H:%i')	 		  
		  AND V.HouseId = ".$_SESSION['HouseId'];

		$result = mysqli_query( $GLOBALS['link'], $StartQuery);
		ActivityLog('Error', curPageURL(), 'Select End Date Range',  $StartQuery, mysqli_error($GLOBALS['link']));		
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select End Date Range',  $StartQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database: ". mysqli_error($GLOBALS['link']));
		}
		elseif (mysqli_num_rows($result) > 0)
		{
			die ("A vacation conflicts with your dates");
		}

		$VacationName = "";
		
		$StartQuery = "SELECT C.RealDate, C.DateId
		  FROM Calendar C 
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear));
	
		$StartResult = mysqli_query( $GLOBALS['link'],  $StartQuery );
		if (!$StartResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Start Date Range - Again',  $StartQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database:". mysqli_error($GLOBALS['link']));
		}
	
		while ($StartRow = mysqli_fetch_array($StartResult, MYSQL_ASSOC)) 
		{
			$StartRange = $StartRow['DateId'];
			$StartDate = $StartRow['RealDate'];
		}
	
		$StartQuery = "SELECT T.timeid
		  FROM Time T 
		  WHERE T.time = '".$StartTime."'";
	
		$StartResult = mysqli_query( $GLOBALS['link'],  $StartQuery );
		if (!$StartResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Start Time Range - Again',  $StartQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database:". mysqli_error($GLOBALS['link']));
		}
	
		while ($StartRow = mysqli_fetch_array($StartResult, MYSQL_ASSOC)) 
		{
			$StartRangeTime = $StartRow['timeid'];
		}	
	
		$EndQuery = "SELECT C.RealDate, C.DateId
		  FROM Calendar C 
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear));
	
		$EndResult = mysqli_query( $GLOBALS['link'],  $EndQuery );
		if (!$EndResult)
		{
			ActivityLog('Error', curPageURL(), 'Select End Date Range - Again',  $EndQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database:". mysqli_error($GLOBALS['link']));
		}
		
		while ($EndRow = mysqli_fetch_array($EndResult, MYSQL_ASSOC)) 
		{
			$EndRange = $EndRow['DateId'];
			$EndDate = $EndRow['RealDate'];
		}
		
		$EndQuery = "SELECT T.timeid
		  FROM Time T 
		  WHERE T.time = '".$EndTime."'";
	
		$EndResult = mysqli_query( $GLOBALS['link'],  $EndQuery );
		if (!$EndResult)
		{
			ActivityLog('Error', curPageURL(), 'Select End Time Range - Again',  $EndQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database:". mysqli_error($GLOBALS['link']));
		}
	
		while ($EndRow = mysqli_fetch_array($EndResult, MYSQL_ASSOC)) 
		{
			$EndRangeTime = $EndRow['timeid'];
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

	$InsertOwnerVacation = "INSERT INTO Vacations (OwnerId, HouseId, StartDateId, EndDateId, StartTimeId, EndTimeId, AllowGuests, AllowOwners, VacationName, BackGrndColor, FontColor, Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
	VALUES (".$_SESSION['OwnerId'].", ".$_SESSION['HouseId'].", ".$StartRange.", ".$EndRange.", ".$StartRangeTime.", ".$EndRangeTime.", '".$AllowGuests."', '".$AllowOwners."', '".mysqli_real_escape_string($GLOBALS['link'], $_POST['VacationName'])."', '".$_POST['BackGrndColor']."',  '".$_POST['FontColor']."', 
	'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";

	if (!mysqli_query( $GLOBALS['link'],  $InsertOwnerVacation ))
	{
		ActivityLog('Error', curPageURL(), 'Insert Scheduled Vacations',  $InsertOwnerVacation, mysqli_error($GLOBALS['link']));
		die ("Could not insert into the database:". mysqli_error($GLOBALS['link']));
	}
	
	$VacationIdQuery = "SELECT VacationId
			FROM Vacations
			WHERE OwnerId = ".$_SESSION['OwnerId']."
			AND HouseId = ".$_SESSION['HouseId']."
			AND StartDateId = ".$StartRange."
			AND EndDateId = ".$EndRange."
			AND StartTimeId = ".$StartRangeTime."
			AND EndTimeId = ".$EndRangeTime;			
      
	$VacationIdResult = mysqli_query( $GLOBALS['link'], $VacationIdQuery);
      
	if (!$VacationIdResult || mysqli_num_rows($VacationIdResult) <> 1)
	{
		ActivityLog('Error', curPageURL(), 'Select Scheduled Vacation Id',  $VacationIdQuery, mysqli_error($GLOBALS['link']));
		die ("ERROR - Unable to get VacationId:". mysqli_error($GLOBALS['link']));
    } 
    else 
    {
      $VacationId = mysqli_result($VacationIdResult, 0, 'VacationId');
	}	

SendNotification('inserted', $VacationId);

echo "Congrats you have scheduled your vacation";
}   

//This is update logic
if (isset($_POST["submittype"]) && $_POST["submittype"] == 'updatesubmit')
{   
	if(!isset($_POST["VacationName"] ) || $_POST["VacationName"] == '' ){
		die ("Vacation Name is required");
	}else
	if(preg_match('/"/', $_POST["VacationName"])){
		die ("Vacation Name cannot include a double quote");	
	}
	
	if (!isset($_POST["vacStartDate"]) || $_POST["vacStartDate"] == ''
			|| !isset($_POST["vacEndDate"]) || $_POST["vacEndDate"] == '')
	{
			die ("Date is not valid");
	}
	
	if ($_POST["vacStartDate"] == $_POST["vacEndDate"])
	{
			die ("Start and End Dates cannot be the same");
	}	
	
	$startDateAsDate = new DateTime($_POST["vacStartDate"]);
	$endDateAsDate = new DateTime($_POST["vacEndDate"]);
	if($endDateAsDate < $startDateAsDate){
		die ("Start date must be before end date");
	}	
	
	$startdate = explode('/', $_POST["vacStartDate"]);
	$StartMonth = $startdate[0];
	$StartDay = $startdate[1];
	$tempparsestart = explode(' ', $startdate[2]);
	$StartYear = $tempparsestart[0];
	$StartTime = $tempparsestart[1];
	
	$enddate = explode('/', $_POST["vacEndDate"]);
	$EndMonth = $enddate[0];
	$EndDay = $enddate[1];
	$tempparseend = explode(' ', $enddate[2]);
	$EndYear = $tempparseend[0];
	$EndTime = $tempparseend[1];
	
	if (!checkdate($StartMonth, $StartDay, $StartYear))
	{
		die ( "Invalid Start Date" );
	}
	elseif (!checkdate($EndMonth, $EndDay, $EndYear))
	{
		die ( "Invalid End Date" );
	}
	else
	{

		$GetDateIdQuery = "SELECT C.DateId
		  FROM Calendar C
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear));

		$result = mysqli_query( $GLOBALS['link'], $GetDateIdQuery);
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select Start Date Date Id',  $GetDateIdQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database:". mysqli_error($GLOBALS['link']));
		}
		while ($DateIdRow = mysqli_fetch_array($result, MYSQL_ASSOC)) 
		{
			$DateId = $DateIdRow['DateId'];
		}

		$StartQuery = "SELECT C.RealDate, C.DateId
 		  FROM Calendar C, Calendar CE, Vacations V, Time T, Time TE
 		  WHERE 
 		  C.DateId = V.StartDateId
 		  AND CE.DateId = V.EndDateId
 		  AND T.timeid = V.StartTimeId
		  AND TE.timeid = V.EndTimeId
 		  AND ((CONCAT_WS(' ', C.RealDate,T.time) < STR_TO_DATE('".$_POST["vacStartDate"]."', '%m/%d/%Y %H:%i')
				AND CONCAT_WS(' ', CE.RealDate,TE.time) > STR_TO_DATE('".$_POST["vacStartDate"]."', '%m/%d/%Y %H:%i'))
		    OR
			   (CONCAT_WS(' ', C.RealDate,T.time) > STR_TO_DATE('".$_POST["vacStartDate"]."', '%m/%d/%Y %H:%i')
			    AND CONCAT_WS(' ', CE.RealDate,TE.time) < STR_TO_DATE('".$_POST["vacEndDate"]."', '%m/%d/%Y %H:%i'))
			OR
			   (CONCAT_WS(' ', C.RealDate,T.time) > STR_TO_DATE('".$_POST["vacStartDate"]."', '%m/%d/%Y %H:%i')
				AND CONCAT_WS(' ', C.RealDate,T.time) < STR_TO_DATE('".$_POST["vacEndDate"]."', '%m/%d/%Y %H:%i'))				
		  )
		  
		  AND V.VacationId <> ".$_POST['VacationId']."
		  AND V.HouseId = ".$_SESSION['HouseId'];

		$result = mysqli_query( $GLOBALS['link'], $StartQuery);
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select Update Start Date Range',  $StartQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database:". mysqli_error($GLOBALS['link']));
		}
		elseif (mysqli_num_rows($result) > 0)
		{
			echo "A vacation conflicts with your dates ";
		}
		else
		{

			$GetDateIdQuery = "SELECT C.DateId
			  FROM Calendar C
			  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear));

			$result = mysqli_query( $GLOBALS['link'], $GetDateIdQuery);
			if (!$result)
			{
				ActivityLog('Error', curPageURL(), 'Select End Date Date Id',  $GetDateIdQuery, mysqli_error($GLOBALS['link']));
				die ("Could not query the database:". mysqli_error($GLOBALS['link']));
			}
			while ($DateIdRow = mysqli_fetch_array($result, MYSQL_ASSOC)) 
			{
				$DateId = $DateIdRow['DateId'];
			}

			$EndQuery = "SELECT C.RealDate, C.DateId
			  FROM Calendar C, Calendar CE, Vacations V, Time T, Time TE
			  WHERE 
			  C.DateId = V.StartDateId
			  AND CE.DateId = V.EndDateId
			  AND T.timeid = V.StartTimeId
			  AND TE.timeid = V.EndTimeId
			  AND CONCAT_WS(' ', C.RealDate,T.time) < STR_TO_DATE('".$_POST["vacEndDate"]."', '%m/%d/%Y %H:%i')
			  AND CONCAT_WS(' ', C.RealDate,T.time) > STR_TO_DATE('".$_POST["vacEndDate"]."', '%m/%d/%Y %H:%i')		  
			  AND V.VacationId <> ".$_POST['VacationId']."
			  AND V.HouseId = ".$_SESSION['HouseId'];

			$result = mysqli_query( $GLOBALS['link'], $EndQuery);
			if (!$result)
			{
				ActivityLog('Error', curPageURL(), 'Select Update End Date Range',  $EndQuery, mysqli_error($GLOBALS['link']));
				die ("Could not query the database:". mysqli_error($GLOBALS['link']));
			}
			elseif (mysqli_num_rows($result) > 0)
			{
				echo "A vacation conflicts with your dates";
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
			
				$StartResult = mysqli_query( $GLOBALS['link'],  $StartQuery );
				if (!$StartResult)
				{
					ActivityLog('Error', curPageURL(), 'Select Update Start Date Range - Again',  $StartQuery, mysqli_error($GLOBALS['link']));
					die ("Could not query the database:". mysqli_error($GLOBALS['link']));
				}
			
				while ($StartRow = mysqli_fetch_array($StartResult, MYSQL_ASSOC)) 
				{
					$StartRange = $StartRow['DateId'];
					$StartDate = $StartRow['RealDate'];
				}
			
			$StartQuery = "SELECT T.timeid
			  FROM Time T 
			  WHERE T.time = '".$StartTime."'";
		
			$StartResult = mysqli_query( $GLOBALS['link'],  $StartQuery );
			if (!$StartResult)
			{
				ActivityLog('Error', curPageURL(), 'Select Start Time Range - Again',  $StartQuery, mysqli_error($GLOBALS['link']));
				die ("Could not query the database:". mysqli_error($GLOBALS['link']));
			}
		
			while ($StartRow = mysqli_fetch_array($StartResult, MYSQL_ASSOC)) 
			{
				$StartRangeTime = $StartRow['timeid'];
			}				
			
				$EndQuery = "SELECT C.RealDate, C.DateId
				  FROM Calendar C 
				  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear));
			
				$EndResult = mysqli_query( $GLOBALS['link'],  $EndQuery );
				if (!$EndResult)
				{
					ActivityLog('Error', curPageURL(), 'Select Update End Date Range - Again',  $EndQuery, mysqli_error($GLOBALS['link']));
					die ("Could not query the database:". mysqli_error($GLOBALS['link']));
				}
				
				while ($EndRow = mysqli_fetch_array($EndResult, MYSQL_ASSOC)) 
				{
					$EndRange = $EndRow['DateId'];
					$EndDate = $EndRow['RealDate'];
				}
						
		$EndQuery = "SELECT T.timeid
		  FROM Time T 
		  WHERE T.time = '".$EndTime."'";
	
		$EndResult = mysqli_query( $GLOBALS['link'],  $EndQuery );
		if (!$EndResult)
		{
			ActivityLog('Error', curPageURL(), 'Select End Time Range - Again',  $EndQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database:". mysqli_error($GLOBALS['link']));
		}
	
		while ($EndRow = mysqli_fetch_array($EndResult, MYSQL_ASSOC)) 
		{
			$EndRangeTime = $EndRow['timeid'];
		}							

				$UpdateOwnerVacation = "UPDATE Vacations 
										SET AllowGuests = '".$AllowGuests."',
										AllowOwners = '".$AllowOwners."',
										VacationName = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['VacationName'])."' ,
										StartDateId = ".$StartRange.",
										EndDateId = ".$EndRange.",
										StartTimeId = ".$StartRangeTime.",
										EndTimeId = ".$EndRangeTime.",
										Audit_user_name = '".$_SESSION['user_name']."',
										Audit_Role = '".$_SESSION['Role']."',
										Audit_FirstName = '".$_SESSION['FirstName']."',
										Audit_LastName = '".$_SESSION['LastName']."', 
										Audit_Email = '".$_SESSION['Email']."',
										BackGrndColor = '".$_POST['BackGrndColor']."',
										FontColor = '".$_POST['FontColor']."'
										WHERE VacationId = ".$_POST['VacationId']."
										AND HouseId = ".$_SESSION['HouseId']."
										AND OwnerId = ".$_SESSION['OwnerId'];
			
				if (!mysqli_query( $GLOBALS['link'],  $UpdateOwnerVacation ))
				{
					ActivityLog('Error', curPageURL(), 'Update Vacation',  $UpdateOwnerVacation, mysqli_error($GLOBALS['link']));
					die ("Could not insert into the database:". mysqli_error($GLOBALS['link']));
				}
		
				SendNotification('updated', $_POST['VacationId']);
				
				echo "Congrats you have scheduled your vacation";
			}
		}
	}
}   
?>
