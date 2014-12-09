
 
<script type="text/javascript">
// <![CDATA[
function popitup2() {
	newwindow2=window.open('','name','height=200,width=150');
	var tmp = newwindow2.document;
	tmp.write('<html><head><title>popup</title>');
	tmp.write('<link rel="stylesheet" href="js.css">');
	tmp.write('</head><body><p>this is once again a popup.</p>');
	tmp.write('<p><a href="javascript:alert(self.location.href)">view location</a>.</p>');
	tmp.write('<p><a href="javascript:self.close()">close</a> the popup.</p>');
	tmp.write('</body></html>');
	tmp.close();
}

function changeLayerVisibility(whichLayer, toWhat, source) {
  var elem, vis;
  if( document.getElementById ) // this is the way the standards work
    elem = document.getElementById( whichLayer );
  else if( document.all ) // this is the way old msie versions work
      elem = document.all[whichLayer];
  else if( document.layers ) // this is the way nn4 works
    elem = document.layers[whichLayer];

  if(toWhat == 'toggle') { elem.style.display = (elem.style.display == 'none' || elem.style.display == '') ? 'block' : 'none'; }
  else { elem.style.display = toWhat; }

  if(source) {
  	y = (source.offsetTop-242 < 100) ? source.offsetTop : source.offsetTop - 240;
	// check for the top of the page
	y = (y < getScrollXY()[1]) ? getScrollXY()[1] + 10 : y;
	// check for the virtual bottom of page
	y = (y + 500) > (getScrollXY()[1] + getInnerDimensions()[1]) ? getScrollXY()[1] + getInnerDimensions()[1] - 515 : y;
	// check for the bottom of the page (static bottom)
	y = (y + 500) > document.body.clientHeight ? document.body.clientHeight - 515 : y;
	// lastly, make sure when we set the bottom we didn't push it right off the top of the page
	y = (y < 10 ) ? 10 : y;
	// set it
	elem.style.top = y + "px";
  }
}
// ]]>
</script>


<?php ActivityLog('Info', curPageURL(), 'Build Calendar',  NULL, NULL); ?>

<?php

//This section gets the month that is displayed at the top of the calendar

$self = $_SERVER['PHP_SELF'];

if (isset($_GET["MonthIn"]))
 {
 	if ($_GET["MonthIn"] == 0)
 	{
 		$Month = 12;
 		$Year = ($_GET["YearIn"] - 1);
 	}
 	elseif ($_GET["MonthIn"] == 13)
 	{
 		$Month = 1;
 		$Year = ($_GET["YearIn"] + 1);
 	}
 	else
 	{
 		$Month = $_GET["MonthIn"];
 		$Year = $_GET["YearIn"];
 	}

	$query = "SELECT DATE_FORMAT(DATE_ADD(C.RealDate, INTERVAL -1 MONTH), '%M') 'PrevMonth',
				DATE_FORMAT(C.RealDate, '%M') 'MonthText',
				DATE_FORMAT(DATE_ADD(C.RealDate, INTERVAL 1 MONTH), '%M') 'NextMonth',
				DATE_FORMAT(C.RealDate, '%Y') 'YearText',
				C.Month,
				C.Year
			  FROM Calendar C
			  WHERE DATE_FORMAT(C.RealDate, '%m') =".$Month." AND DATE_FORMAT(C.RealDate, '%Y') =".$Year;

 }
else
 {

 	$Month = '01';
 	$Year = '2007';

	$query = "SELECT DATE_FORMAT(DATE_ADD(C.RealDate, INTERVAL -1 MONTH), '%M') 'PrevMonth',
				DATE_FORMAT(C.RealDate, '%M') 'MonthText',
				DATE_FORMAT(DATE_ADD(C.RealDate, INTERVAL 1 MONTH), '%M') 'NextMonth',
				DATE_FORMAT(C.RealDate, '%Y') 'YearText',
				C.Month,
				C.Year
			  FROM Calendar C
			  WHERE DATE_FORMAT(C.RealDate, '%m-%Y') = DATE_FORMAT(now(), '%m-%Y')";
 }



$CalResult = mysql_query( $query );
if (!$CalResult)
{
	ActivityLog('Error', curPageURL(), 'Select Date from Calendar',  $query, mysql_error());
	die ("Could not query the database: <br />". mysql_error());
}
$row = mysql_fetch_row($CalResult);
while ($row = mysql_fetch_array($CalResult, MYSQL_ASSOC))
{
	$Month = $row['Month'];
	$Year = $row['Year'];
	$MonthText = $row['MonthText'];
	$YearText = $row['YearText'];
	$Prev = $row['PrevMonth'];
	$Next = $row['NextMonth'];
}
?>
<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
	<tr align="center">
		<td>
			<table border="0" width="90%">
				<tr>
<?php
		if (($Month - 1) == 0 && $Year == 2007)
		{
			echo "<td align=\"right\" width=\"40%\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		}
		else
		{
			echo "<td align=\"right\" width=\"40%\"><a href=\"".$self."?MonthIn=".($Month - 1)."&amp;YearIn=".$Year."\"> ".$Prev."</a></td>";
		}
?>
					<td align="center" width="20.25%" class="Title"><?php echo $MonthText.' '.$YearText; ?></td>
					<td align="left" width="10.25%"><?php echo "<a href=\"".$self."?MonthIn=".($Month + 1)."&amp;YearIn=".$Year."\"> ".$Next."</a>"; ?></td>
					<td align="right" width="29.5%">
						
						<select name="MonthIn">
						<?php
							$JumpMonth = 1;
							while ($JumpMonth < 13) 
							{   	
								if ($JumpMonth == $Month)
								{
									echo "<option selected=\"selected\" value=\"".$JumpMonth."\">".$JumpMonth."</option>";
								}
								else
								{
									echo "<option value=\"".$JumpMonth."\">".$JumpMonth."</option>";
								}
								$JumpMonth++;
							}
						?>
						</select>
						&nbsp;/&nbsp;
						<select name="YearIn">
						<?php
							$JumpYear = 2007;
							while ($JumpYear < 2018) 
							{   	
								if ($JumpYear == $Year)
								{
									echo "<option selected=\"selected\" value=\"".$JumpYear."\">".$JumpYear."</option>";
								}
								else
								{
									echo "<option value=\"".$JumpYear."\">".$JumpYear."</option>";
								}
								$JumpYear++;
							}
						?>
						</select>
						<input type="submit" value="Jump" />	
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td>
			<table class="Calendar" align="center" width="90%">
				<tr>
					<td height="25px" width="14%" class="CalendarHeader">Sunday</td>
					<td width="14%" class="CalendarHeader">Monday</td>
					<td width="14%" class="CalendarHeader">Tuesday</td>
					<td width="14%" class="CalendarHeader">Wednesday</td>
					<td width="14%" class="CalendarHeader">Thursday</td>
					<td width="14%" class="CalendarHeader">Friday</td>
					<td width="14%" class="CalendarHeader">Saturday</td>
				</tr>

<?php


//This section identifies the number of blank cells to show at the beginning of the calendar
$query = "SELECT DAYOFWEEK(C.RealDate) 'CalDay', C.Month, C.Day, C.Year, C.DateId FROM Calendar C
			WHERE DATE_FORMAT(C.RealDate, '%m') =".$Month." AND DATE_FORMAT(C.RealDate, '%Y') =".$Year;

$CalResult = mysql_query( $query );
if (!$CalResult)
{
	ActivityLog('Error', curPageURL(), 'Select Day of Week from Calendar',  $query, mysql_error());
	die ("Could not query the database: <br />". mysql_error());
}

$row = mysql_fetch_array($CalResult, MYSQL_ASSOC);

$start = 1;
echo '<tr>';

while ($start < $row['CalDay']) {
       echo '<td class=\"TableValue\>&nbsp;</td>';
    $start++;
}

// Calls a function to get the array of room usage for the month
GetUsedRooms($Month, $Year, &$UsedRoomsResults, &$Avail);

// Calls a function to get the available rooms in the house
GetAvailableRooms($Month, $Year, &$Avail);

// Calls a function to get the vacation for the current date
GetVacation($Month, $Year, &$VacationResults);

// Reset the results and write out the calendar
mysql_data_seek($CalResult, 0);

while ($row = mysql_fetch_array($CalResult, MYSQL_ASSOC))
{
    
//    echo "<td height=\"100\" valign=\"top\" class=\"CalendarDay\">".$row['Day']."  -  ";

	mysql_data_seek($VacationResults, ($row['Day'] - 1));

	$VacationRow = mysql_fetch_row($VacationResults);

	if (!IS_NULL($VacationRow[0]))
	{
		if ($_SESSION['Role'] == "Owner" && $VacationRow[6] == $_SESSION['OwnerId'])
		{
			echo "<td bgcolor='#".$VacationRow[4]."' onclick=\"Javascript: document.getElementById('editor').src='EditCalendar.php?VacationId=".$VacationRow[1]."&amp;Change=Update'; changeLayerVisibility('editor-container', 'block', this);\" height=\"100\" valign=\"top\" class=\"CalendarDayFilled\"><font color='#".$VacationRow[5]."'>".$row['Day']."  -  ";
		}
		elseif ($_SESSION['Role'] == "Administrator" && IsAdminOwner() && $VacationRow[6] == $_SESSION['OwnerId'])
		{
			echo "<td bgcolor='#".$VacationRow[4]."' onclick=\"Javascript: document.getElementById('editor').src='EditCalendar.php?VacationId=".$VacationRow[1]."&amp;Change=Update'; changeLayerVisibility('editor-container', 'block', this);\" height=\"100\" valign=\"top\" class=\"CalendarDayFilled\"><font color='#".$VacationRow[5]."'>".$row['Day']."  -  ";
		}
		else 
		{
			echo "<td bgcolor='#".$VacationRow[4]."' height=\"100\" align=\"left\" valign=\"top\" class=\"CalendarDayFilled\"><font color='#".$VacationRow[5]."'>".$row['Day']."  -  ";
		}
		 		

		// This finds the record that has the number of rooms used for this date within the array of room usage
		mysql_data_seek($UsedRoomsResults, ($row['Day'] - 1));

		$UsedRoomRow = mysql_fetch_row($UsedRoomsResults);

		$Used = $UsedRoomRow[0];

		$LeftOver = $Avail - $Used;

		// Don't show link if $AllowGuests is set to N
		if ($VacationRow[2] == "Y")
		{
			echo "<a href=\"ViewVacation.php?VacationId=".$VacationRow[1]."\">".stripslashes($VacationRow[0])."</a><br/><br/>Available Rooms: ".$LeftOver."</font>";
		}
		else
		{
		//	echo $VacationRow[0]."<br/><br/>Available Rooms: 0</font>";
			echo $VacationRow[0]."</font>";
		}
	}
	else
	{
		if ($_SESSION['Role'] == "Owner")
		{
			echo "<td onclick=\"Javascript: document.getElementById('editor').src='EditCalendar.php?StartDay=".$row['Day']."&amp;StartMonth=".$row['Month']."&amp;StartYear=".$row['Year']."&amp;Change=Insert'; changeLayerVisibility('editor-container', 'block', this);\" height=\"100\" valign=\"top\" class=\"CalendarDay\">".$row['Day']."  -  ";	
		}
		elseif ($_SESSION['Role'] == "Administrator" && IsAdminOwner())
		{
			echo "<td onclick=\"Javascript: document.getElementById('editor').src='EditCalendar.php?StartDay=".$row['Day']."&amp;StartMonth=".$row['Month']."&amp;StartYear=".$row['Year']."&amp;Change=Insert'; changeLayerVisibility('editor-container', 'block', this);\" height=\"100\" valign=\"top\" class=\"CalendarDay\">".$row['Day']."  -  ";	
		}
		else 
		{
			echo "<td height=\"100\" valign=\"top\" class=\"CalendarDay\">".$row['Day']."  -  ";	
		}
	}

	echo '</td>';

    if ($row['CalDay'] == 7)
    {
    	echo '</tr><tr>';
    }

}

?>
					<td>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
        <div id="editor-container" class="shade"><img src="images/shadow.png" width="0" height="0" alt="" class="shade" />
          <iframe id="editor" scrolling="no" style="" frameborder="0"></iframe>
        </div>

