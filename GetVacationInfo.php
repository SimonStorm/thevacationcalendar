<?php ActivityLog('Info', curPageURL(), 'Get Vacation Information Include',  NULL, NULL); ?>

<?php
//This section displays the selected dates in a row
$self = $_SERVER['PHP_SELF'];

$OnPage = strstr($self, "/");

$OnPage = substr($OnPage, 1);

if (isset($_GET["VacationId"]))
{
	// Create the table within a table for the rooms
	echo "<td colspan=\"4\"><table border=\"0\"  cellpadding=\"0\" cellspacing=\"0\"><tr><td>&nbsp;</td>";

	GetAllVacationDates(&$VacationResult, $_GET["VacationId"], &$StartRange, &$StartDate, &$EndRange, &$EndDate, &$VacationName, &$VacationOwnerId);

	$VacationName = stripslashes($VacationName);

	GetRooms(&$RoomResult);

	$RoomCounter = 0;
	while ($RoomRow = mysql_fetch_array($RoomResult, MYSQL_ASSOC))
	{

		echo "<td align=\"CENTER\" width=\"100\"  height=\"35\" class=\"TableHeader\">".stripslashes($RoomRow['RoomName'])."</td>";
		$RoomArray[$RoomCounter] = $RoomRow['RoomId'];
		$RoomCounter++;

	}

	echo "</tr><tr><td class=\"TableSideItem\">Amenities</td>";

	mysql_data_seek($RoomResult, 0);

	// This function gets a list of all the rooms and their amenities
	GetRoomData(&$RoomDataResult);

	$RecordCounter = 0;

	while ($RoomDataRow = mysql_fetch_array($RoomDataResult, MYSQL_ASSOC))
	{
		echo "<td align=\"center\" valign=\"center\" class=\"TableValue\" height=\"30\">";

		$CurrentRoom = $RoomDataRow['RoomId'];

		mysql_data_seek($RoomDataResult, $RecordCounter);

		while ($RoomDataRow = mysql_fetch_array($RoomDataResult, MYSQL_ASSOC))
		{

			if ($RoomDataRow['RoomId'] == $CurrentRoom)
			{
				$RecordCounter++;
				echo $RoomDataRow['AmenityName']."<BR/>";
			}
			else
			{
				break;
			}
		}

		if (mysql_num_rows($RoomDataResult) > $RecordCounter)
		{
			mysql_data_seek($RoomDataResult, $RecordCounter);
		}

		echo "</td>";
	}

	echo "</tr>";

	$query = "SELECT C.RealDate, C.DateId
	  FROM Calendar C
	  WHERE DateId >= ".$StartRange."
	  AND DateId <= ".$EndRange;

	$CalResult = mysql_query( $query );
	if (!$CalResult)
	{
		die ("Could not query the database: <br />". mysql_error());
	}

	$df_src = 'Y-m-d';
	$df_des = 'n/j/Y';

	while ($Row = mysql_fetch_array($CalResult, MYSQL_ASSOC))
	{

	echo "<tr><td  height=\"25\" class=\"TableSideItem\">".dates_interconv( $df_src, $df_des, $Row['RealDate'])."</td>";

		for ($Counter = 0 ; $Counter <= $RoomCounter-1; $Counter++)
		{

			echo "<td class=\"TableValue\">";

			$CurentOccupantQuery = "SELECT S.GuestId, G.FirstName, G.LastName, G.OwnerId
			  FROM Schedule S, Guest G 
			  WHERE S.GuestId = G.GuestId
			  AND S.HouseID = ".$_SESSION['HouseId']."
			  AND S.DateId = ".$Row['DateId']."
			  AND S.RoomId = ".$RoomArray[$Counter]."
			  AND G.HouseID = ".$_SESSION['HouseId']."
			UNION
			  SELECT S.GuestId, u.first_name, u.last_name, u.user_id
			  FROM Schedule S, user u
			  WHERE S.GuestId = u.user_id
			  AND S.HouseID = ".$_SESSION['HouseId']."
			  AND S.DateId = ".$Row['DateId']."
			  AND S.RoomId = ".$RoomArray[$Counter]."
			  AND u.HouseID = ".$_SESSION['HouseId'];

			$AnyRows = 'N';


			$CurrentOccupantResult = mysql_query( $CurentOccupantQuery );
			if (!$CurrentOccupantResult)
			{
				ActivityLog('Error', curPageURL(), 'Select Occupant List',  $CurentOccupantQuery, mysql_error());
				die ("Could not query the database: <br />". mysql_error());
			}

			while ($CurrentOccupantRow = mysql_fetch_array($CurrentOccupantResult, MYSQL_ASSOC))
			{
				echo stripslashes($CurrentOccupantRow['FirstName'])." ".stripslashes($CurrentOccupantRow['LastName'])."<br/>";
			
				$AnyRows = 'Y';
			}

			if ($AnyRows == 'N')
			{
				echo "&nbsp;";
			}
			
			echo "</td>";

		}

	echo "</tr><tr>";

	}
	if ($_SESSION['Role'] == "Guest" || $_SESSION['Role'] == "Owner" || ($_SESSION['Role'] == "Administrator" && IsAdminOwner()))
	{

		$DateArray = explode('/',$StartDate);

		$StartYear = $DateArray[2];
		$StartMonth = $DateArray[0];
		$StartDay = $DateArray[1];

		$DateArray = explode('/',$EndDate);

		$EndYear = $DateArray[2];
		$EndMonth = $DateArray[0];
		$EndDay = $DateArray[1];

		echo "</tr></table></td></tr><tr align=\"center\"><td class=\"TextItem\">To request to join this vacation, provide your name, email, the dates you want to come and click \"Request to Join\"</td></tr>";
		echo "<tr align=\"center\"><td class=\"TextItem\">Name: <input type=\"text\" name=\"RequestName\"></td></tr>";
		echo "<tr align=\"center\"><td class=\"TextItem\">Email: <input type=\"text\" name=\"RequestEmail\"></td></tr>";
		echo "<input type=\"hidden\" name=\"VacationId\" value=\"".$_GET["VacationId"]."\">";
		echo "<input type=\"hidden\" name=\"StartRange\" value=\"".$StartRange."\">";
		echo "<input type=\"hidden\" name=\"EndRange\" value=\"".$EndRange."\">";
		echo "<input type=\"hidden\" name=\"StartDate\" value=\"".$StartDate."\">";
		echo "<input type=\"hidden\" name=\"EndDate\" value=\"".$EndDate."\">";

		include("DateRangePicker.php");
		echo "</table>";
	}


}
?>
