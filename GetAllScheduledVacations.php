<?php ActivityLog('Info', curPageURL(), 'Get All Scheduled Vacations Include',  NULL, NULL); ?>
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
$VacationOwnerId= NULL;

// This function gets a list of the vacation dates
$VacationResult = GetAllVacationDates($VacationResult, 0, $StartRange, $StartDate, $EndRange, $EndDate, $VacationName, $AllowGuests, $AllowOwners, $VacationOwnerId);

$counter = 1;
$df_src = 'Y-m-d';
$df_des = 'n/j/Y';

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
	$counter++;

	echo "<td class=\"TextItem\">".stripslashes($VacationRow['VacationName'])."</td>";
	echo "<td class=\"TextItem\">Scheduled from ".dates_interconv( $df_src, $df_des, $VacationRow['StartDate'])." to ".dates_interconv( $df_src, $df_des, $VacationRow['EndDate'])."</td>";

	echo "<td><a class=\"admindeletelink\" href=\"DeleteVacationsAdmin.php?VacationId=".$VacationRow['VacationId']."&Change=Delete\">Delete Vacation</a></td>";
}
?>
<?php
if (isset($_POST["StartMonth"]))
{ 
	echo "<input type=\"hidden\" name=\"SaveScheduledOwner\" value=\"Y\"><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"\" />";
}
?>