<?php ActivityLog('Info', curPageURL(), 'Input Guest Schedule Include',  NULL, NULL); ?>

<script language="JavaScript" type="text/javascript">
<!--

var NS4 = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) < 5);

function addOption(theSel, theText, theValue)
{

  var newOpt = new Option(theText, theValue);
  var selLength = theSel.length;
  theSel.options[selLength] = newOpt;
  theSel.options[selLength].selected = true;
}

function deleteOption(theSel)
{ 
  var selLength = theSel.length;
  var selectedCount = 0;
  
  var i;
  
  // Find the selected Options in reverse order
  // and delete them from the 'from' Select.
  for(i=selLength-1; i>=0; i--)
  {
    if(theSel.options[i].selected)
    {
      theSel.options[i] = null;
      selectedCount++;
    }
  }
}

function moveOptions(theSelFrom, theSelTo)
{
  var selLength = theSelFrom.length;
  var selectedText = new Array();
  var selectedValues = new Array();
  var selectedCount = 0;
  
  var i;
  
  // Find the selected Options in reverse order
  // and delete them from the 'from' Select.
  for(i=selLength-1; i>=0; i--)
  {
    if(theSelFrom.options[i].selected)
    {
      selectedText[selectedCount] = theSelFrom.options[i].text;
      selectedValues[selectedCount] = theSelFrom.options[i].value;
//      deleteOption(theSelFrom, i);
      selectedCount++;
    }
  }
  
  // Add the selected text/values in reverse order.
  // This will add the Options to the 'to' Select
  // in the same order as they were in the 'from' Select.
  for(i=selectedCount-1; i>=0; i--)
  {
    addOption(theSelTo, selectedText[i], selectedValues[i]);
  }
  
  if(NS4) history.go(0);
}
</script>

<?php


//This section displays the selected dates in a row
$self = $_SERVER['PHP_SELF'];
$df_src = 'Y-m-d';
$df_des = 'n/j/Y';

if (isset($_GET["ShowGuest"]))
{
	if ($_GET["ShowGuest"] == 'N')
	{
		$ShowGuest = "N";
	}
	else
	{
		$ShowGuest = "Y";
	}
}

if (isset($_GET["Change"]))
{

	GetVacationDates(&$VacationResult, $_GET["VacationId"], &$StartRange, &$StartDate, &$EndRange, &$EndDate, &$VacationName, &$AllowGuests, &$AllowOwners, &$FirstName, &$LastName, &$OwnerIdVal, &$BkgrndColor, &$FontColor);

	if ($AllowGuests == "Y")
	{
		// Function to get a list of available guests for the owner
		GetGuests(&$GuestResult, $ShowGuest);

			
		echo "<input type=\"hidden\" name=\"StartRange\" value=\"".$StartRange."\">";
		echo "<input type=\"hidden\" name=\"EndRange\" value=\"".$EndRange."\">";		

		echo "<tr><td colspan=\"4\">&nbsp;</td></tr>";

		echo "<tr><td align=\"center\" colspan=\"4\">";
		
		echo "<select multiple name=\"guestlist\" size=\"8\">";
				
		while ($GuestRow = mysql_fetch_array($GuestResult, MYSQL_ASSOC)) 
		{					
			echo "<option value=\"".$GuestRow['GuestId']."\">".stripslashes($GuestRow['Name'])."</option>";
		}			
	
		echo "</select>";

		echo "</td></tr>";

		echo "<tr><td colspan=\"4\" align=center>Select the individuals you want to book in the top box and then add them to the desired room by clicking the + button next to the room/day<br/><br/>To add more than one person at a time to a single day/room slot, simply use ctrl+click to select multiple individuals</td></tr>";
	
		echo "<tr><td colspan=\"4\">&nbsp;</td></tr><tr><td colspan=\"4\" align=\"CENTER\"><table border=\"0\">";
	
		// This is logic to show 7 days and then wrap
		
		$TotalDays = $EndRange - $StartRange;
		$DaysLeft = $TotalDays;
		$CurrentStart = $StartRange;
		$RealEnd = $EndRange;
	
		GetAllGuests(&$GuestResult);
		
		while ($DaysLeft >= 0)
		{
	
			echo "<tr><td>&nbsp;</td>";
		
			$StartRange = $CurrentStart;
			
			if ($DaysLeft >= 7)
			{
				$EndRange = $CurrentStart + 6;
			}
			elseif ($DaysLeft >= 0)
			{
				$EndRange = $CurrentStart + $DaysLeft;
			}
			else
			{
				break;
			}
	
			$query = "SELECT C.RealDate, C.DateId, DATE_FORMAT(C.RealDate, '%W') Day
			  FROM Calendar C 
			  WHERE DateId >= ".$StartRange."
			  AND DateId <= ".$EndRange;
		
			$CalResult = mysql_query( $query );
			if (!$CalResult)
			{
				ActivityLog('Error', curPageURL(), 'Select Date Info',  $query, mysql_error());
				die ("Could not query the database: <br />". mysql_error());
			}
			
			$FirstDate = 'Y';
			
			while ($row = mysql_fetch_array($CalResult, MYSQL_ASSOC)) 
			{
				if ($FirstDate == 'Y')
				{
					$StartRange = $row['DateId'];
					$FirstDate = 'N';
				}
				echo "<td height=\"20\" align=\"CENTER\" class=\"TableHeader\">".$row['Day']."<br/>".dates_interconv( $df_src, $df_des, $row['RealDate'])."</td>";
				$EndRange = $row['DateId'];
			}
			
			echo "</tr><tr>";
					
			GetRooms(&$RoomResult);
			
			while ($RoomRow = mysql_fetch_array($RoomResult, MYSQL_ASSOC)) 
			{
					echo "<td class=\"TableSideItem\">".stripslashes($RoomRow['RoomName'])."</td>";
					
					for ($Counter = $StartRange ; $Counter <= $EndRange; $Counter++) 
					{

						echo "<td class=\"TableValue\"><table border=1><tr><td class=\"TableValue\" rowspan=2><select MULTIPLE name=\"c".$Counter."_".$RoomRow['RoomId']."[]\" id=\"c".$Counter."_".$RoomRow['RoomId']."\" size=\"2\">";
		
						//Here we are going to get existing value
						$CurentOccupantQuery = "SELECT GuestId
						  FROM Schedule 
						  WHERE HouseID = ".$_SESSION['HouseId']."
						  AND DateId = ".$Counter."
						  AND RoomId = ".$RoomRow['RoomId'];

						$CurrentOccupantResult = mysql_query( $CurentOccupantQuery );
						if (!$CurrentOccupantResult)
						{
							ActivityLog('Error', curPageURL(), 'Select Current Occupant',  $CurentOccupantQuery, mysql_error());
							die ("Could not query the database: <br />". mysql_error());
						}
					
						while ($CurrentOccupantRow = mysql_fetch_array($CurrentOccupantResult, MYSQL_ASSOC)) 
						{
							$CurrentOccupant = $CurrentOccupantRow['GuestId'];

							mysql_data_seek($GuestResult, 0);
						
							
							while ($GuestRow = mysql_fetch_array($GuestResult, MYSQL_ASSOC)) 
							{					

								if ($CurrentOccupant == $GuestRow['GuestId'])
								{
									echo "<option SELECTED value=\"".$GuestRow['GuestId']."\">".stripslashes($GuestRow['Name'])."</option>";
								}
	
							}

						}
	
						
						echo "</select></td><td class=\"TableValue\"><input type=\"button\" value=\"+\" onclick=\"moveOptions( this.form.guestlist, this.form.c".$Counter."_".$RoomRow['RoomId'].");\"></td></tr><tr>
						<td class=\"TableValue\"><input type=\"button\" value=\"-\" onclick=\"deleteOption(this.form.c".$Counter."_".$RoomRow['RoomId'].");\"></td></tr></table></td>";
					}	
				echo "</tr><tr>";
			}   
			
			$DaysLeft = $DaysLeft - 7;
			
			$CurrentStart = $EndRange + 1;
			
	
		}
		echo "</tr></table></td></tr>";
		echo "<tr><td colspan=\"4\" align=\"center\"><input type=\"hidden\" name=\"VacationId\" value=\"".$_GET["VacationId"]."\"><input type=\"hidden\" name=\"SaveScheduledGuests\" value=\"Y\"><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"Schedule Visitors\" /></td></tr>";
	}
	else
	{
		echo "<tr><td colspan=\"4\">&nbsp;</td></tr><tr><td colspan=\"4\" align=\"CENTER\" class=\"TextItem\">";
		echo "<font class=\"Error\">This vacation is not set up to receive visitors.</font>";
		echo "</td></tr><tr><td colspan=\"4\">&nbsp;</td></tr>";
	}
}

?>
