<?php ActivityLog('Info', curPageURL(), 'Get Room Info Include',  NULL, NULL); ?>
<?php

//This section displays the selected rooms in a table

// Create the table within a table for the rooms
echo "<tr align=\"center\"><td colspan=\"4\"><table border=\"0\"><tr><td width=\"150\" class=\"TableHeader\">Room Name</td><td width=\"150\" class=\"TableHeader\">Amenities</td><td width=\"100\" colspan=\"2\" class=\"TableHeader\">Actions</td>";

// This function gets a list of all the rooms and their amenities
GetRoomData(&$RoomDataResult);

$RecordCounter = 0;

while ($RoomDataRow = mysql_fetch_array($RoomDataResult, MYSQL_ASSOC)) 
{
	
	$CurrentRoom = $RoomDataRow['RoomId'];

	echo "</tr><tr><td class=\"TableSideItem\">".stripslashes($RoomDataRow['RoomName'])."</td>";	
//	echo "<td class=\"TableSideItem\" ALIGN=CENTER>".stripslashes($RoomDataRow['Beds'])."</td>";
	echo "<td class=\"TableValue\">";

	mysql_data_seek($RoomDataResult, $RecordCounter);
	
	while ($RoomDataRow = mysql_fetch_array($RoomDataResult, MYSQL_ASSOC)) 
	{
		
		if ($RoomDataRow['RoomId'] == $CurrentRoom)
		{
			$RecordCounter++;
			echo stripslashes($RoomDataRow['AmenityName'])."<BR/>";
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
	
	echo "</td><td class=\"TableValue\"><a href=\"ManageRooms.php?RoomId=".$CurrentRoom."&Change=Update\">Edit</td>";
	echo "<td class=\"TableValue\"><a href=\"ManageRooms.php?RoomId=".$CurrentRoom."&Change=Delete\">Delete</td></tr>";
}	

  	echo "</table></td></tr>";
?>
