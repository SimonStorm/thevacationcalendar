<?php ActivityLog('Info', curPageURL(), 'Get Scheduled Vacations Include',  NULL, NULL); ?>

<script type="text/javascript">
<!--
//build the url
function sendWithInfo(item)
{
	if (item.checked == true)
	{
		if (document.location.href.indexOf('ShowGuest') > 0)
		{
			document.location.href = document.location.href.substring(0, document.location.href.lastIndexOf('=')) + '=N'
		}
		else
		{
			document.location.href = document.location.href.substring(0, document.location.href.indexOf('?')) + '?ShowGuest=N';
		}
	}
	else
	{
		if (document.location.href.indexOf('ShowGuest') > 0)
		{
			document.location.href = document.location.href.substring(0, document.location.href.lastIndexOf('=')) + '=Y'
		}
		else
		{
			
			//Do nothing
		}
	}
}
//-->
</SCRIPT>

<?php
//This section displays the selected dates in a row

$self = $_SERVER['PHP_SELF'];

$OnPage = strstr($self, "/");

$OnPage = substr($OnPage, 1);


// This function gets a list of the vacation dates
GetVacationDates(&$VacationResult, 0, &$StartRange, &$StartDate, &$EndRange, &$EndDate, &$VacationName, &$AllowGuests, &$AllowOwners,  &$FirstName, &$LastName, &$OwnerIdVal, &$BkgrndColor, &$FontColor);

$VacationName = stripslashes($VacationName);

$counter = 1;
$df_src = 'Y-m-d';
$df_des = 'n/j/Y';

echo "<tr align=\"center\"><td class=\"TableHeader\">Vacation Name</td><td class=\"TableHeader\">Owner</td><td class=\"TableHeader\">Scheduled Dates</td><td colspan=\"2\" class=\"TableHeader\">Actions</td></tr>";

while ($VacationRow = mysql_fetch_array($VacationResult, MYSQL_ASSOC)) 
{

	if (fmod($counter, 2) == 1)
	{
		echo "<tr class=\"RowOddColor\">";
	}
	else
	{
		echo "<tr class=\"RowEvenColor\">";
	}

	if ($OnPage == 'ScheduleGuests.php')
	{
		echo "<td class=\"TextItem\">".stripslashes($VacationRow['VacationName'])."</td>";
		echo "<td class=\"TextItem\">".stripslashes($VacationRow['FirstName'])." ".stripslashes($VacationRow['LastName'])."</td>";
		echo "<td class=\"TextItem\">Scheduled from ".dates_interconv( $df_src, $df_des, $VacationRow['StartDate'])." to ".dates_interconv( $df_src, $df_des, $VacationRow['EndDate'])."</td>";
	
		if (isset($_GET["ShowGuest"]))
		{
			if ($_GET["ShowGuest"] == 'N')
			{
				$ShowValue = "N";
			}
			else
			{
				$ShowValue = "Y";
			}
		}
		else
		{
			$ShowValue = "Y";
		}
	
		echo "<td><a href=\"ScheduleGuests.php?VacationId=".$VacationRow['VacationId']."&Change=Update&ShowGuest=".$ShowValue."\">Schedule Guests</a></td>";
		echo "<td><a href=\"SaveScheduledGuests.php?VacationId=".$VacationRow['VacationId']."&Change=Delete\">Delete Guests</a></td>";
	
		$counter++;
	}
	else
	{
		if ($VacationRow['OwnerId'] == $_SESSION["OwnerId"])
		{
			echo "<td class=\"TextItem\">".stripslashes($VacationRow['VacationName'])."</td>";
			echo "<td class=\"TextItem\">Scheduled from ".dates_interconv( $df_src, $df_des, $VacationRow['StartDate'])." to ".dates_interconv( $df_src, $df_des, $VacationRow['EndDate'])."</td>";

			echo "<td><a href=\"ScheduleVacations.php?VacationId=".$VacationRow['VacationId']."&Change=Update\">Edit Vacation</a></td>";
			echo "<td><a href=\"ScheduleVacations.php?VacationId=".$VacationRow['VacationId']."&Change=Delete\">Delete Vacation</a></td>";
	
			$counter++;
		}
	}
	
	echo "</tr>";
}

if ($OnPage == 'ScheduleGuests.php')
{
	if (isset($_GET["ShowGuest"]))
	{
		if ($_GET["ShowGuest"] == 'N')
		{
			$ShowGuestValue = "CHECKED";
		}
		else
		{
			$ShowGuestValue = "";
		}
	}
	else
	{
		$ShowGuestValue = "";
	}

	echo "<tr><td>&nbsp;</td><td class=\"TextItem\">Don't show house visitors?</td><td colspan=\"2\"><input type=\"checkbox\" name=\"ShowGuests\" Value=\"Y\" $ShowGuestValue onClick=\"sendWithInfo(this);\"></td></tr>";
}

?>
<?php
if (isset($_POST["StartMonth"]))
{ 
//	echo "<input type=\"hidden\" name=\"SaveScheduledOwner\" value=\"Y\"><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"\" />";
}
?>