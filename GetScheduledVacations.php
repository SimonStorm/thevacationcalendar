<?php ActivityLog('Info', curPageURL(), 'Get Scheduled Vacations Include',  NULL, NULL); ?>

<?php
//This section displays the selected dates in a row

$self = $_SERVER['PHP_SELF'];

$OnPage = strstr($self, "/");

$OnPage = substr($OnPage, 1);

$VacationResult = NULL;
$GetType= NULL;
$StartRange= NULL;
$StartDate= NULL;
$EndRange= NULL;
$EndDate= NULL;
$VacationName= NULL;
$AllowGuests= NULL;
$AllowOwners= NULL;
$FirstName= NULL;
$LastName= NULL;
$OwnerIdVal= NULL;
$BkgrndColor= NULL;
$FontColor= NULL;

// This function gets a list of the vacation dates
$VacationResult = GetVacationDates($VacationResult, 0, $StartRange, $StartDate, $EndRange, $EndDate, $VacationName, $AllowGuests, $AllowOwners,  $FirstName, $LastName, $OwnerIdVal, $BkgrndColor, $FontColor);

$VacationName = stripslashes($VacationName);

$counter = 1;
$df_src = 'Y-m-d';
$df_des = 'n/j/Y';

echo "<tr align=\"center\"><td class=\"TableHeader\">Vacation Name</td><td class=\"TableHeader\">Scheduled Dates</td><td class=\"TableHeader\">Actions</td></tr>";

while ($VacationRow = mysqli_fetch_array($VacationResult, MYSQL_ASSOC)) 
{

	if (fmod($counter, 2) == 1)
	{
		echo "<tr class=\"RowOddColor\">";
	}
	else
	{
		echo "<tr class=\"RowEvenColor\">";
	}

	if ($VacationRow['OwnerId'] == $_SESSION["OwnerId"])
	{
		echo "<td class=\"TextItem\">".stripslashes($VacationRow['VacationName'])."</td>";
		echo "<td class=\"TextItem\">Scheduled from ".dates_interconv( $df_src, $df_des, $VacationRow['StartDate'])." ".$VacationRow['StartTime']." to ".dates_interconv( $df_src, $df_des, $VacationRow['EndDate'])." ".$VacationRow['EndTime']."</td>";

		echo "<td><a href=\"ScheduleVacations.php?VacationId=".$VacationRow['VacationId']."&Change=Update\">Edit Vacation</a></td>";
		//echo "<td><a href=\"ScheduleVacations.php?VacationId=".$VacationRow['VacationId']."&Change=Delete\">Delete Vacation</a></td>";

		$counter++;
	}

	echo "</tr>";
}


?>

