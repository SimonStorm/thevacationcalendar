<?php ActivityLog('Info', curPageURL(), 'Input Room Info Include',  NULL, NULL); ?>
			
<?php
// This is the save logic for a new room

//echo "<pre>";
//print_r ($_POST);
//echo "</pre>";

$RoomName = '';

if (isset($_POST['AddRoom']))
{
	$AddGuestQuery = "INSERT INTO Room (HouseId, RoomTypeId, RoomName, Beds,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
					VALUES (".$_SESSION['HouseId'].", 'F', '".mysql_real_escape_string($_POST['RoomName'])."', 1,
					'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";

	if (!mysql_query( $AddGuestQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Insert Room Info',  $AddGuestQuery, mysql_error());
		die ("Could not insert Room into the database: <br />". mysql_error());
	}
	else
	{
		$InsertedRoomId = mysql_insert_id();
	}
	
	if (isset($_POST['AmenityPick']))
	{
		$AmenityList = $_POST['AmenityPick'];
		if ($AmenityList){
	
			foreach ($AmenityList as $AmenityItem)
			{
				$AddAmenitiesQuery = "INSERT INTO RoomAmenity (RoomId, AmenityId,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email)
									VALUES (".$InsertedRoomId.", ".mysql_real_escape_string($AmenityItem).", '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
									
				if (!mysql_query($AddAmenitiesQuery))
				{
					ActivityLog('Error', curPageURL(), 'Insert Room Amenity',  $AddAmenitiesQuery, mysql_error());
					die ("Could not insert amenities into the database: <br />". mysql_error());
				}
			}
		
		}	
	}

	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageRooms.php\"/>";
	echo "Congrats you have added a bedroom to your vacation home";
}

// This is the room update logic 

if (isset($_POST['UpdateRoom']))
{
	$DeleteAmenitiesQuery = "DELETE FROM RoomAmenity 
						WHERE RoomId = ".$_POST['UpdateRoom'];

	if (!mysql_query( $DeleteAmenitiesQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Room Amenity',  $DeleteAmenitiesQuery, mysql_error());
		die ("Could not delete - part of update - from the database: <br />". mysql_error());
	}

	if (isset($_POST['AmenityPick']))
	{
		$AmenityList = $_POST['AmenityPick'];
		if ($AmenityList){
	
			foreach ($AmenityList as $AmenityItem)
			{
				$AddAmenitiesQuery = "INSERT INTO RoomAmenity (RoomId, AmenityId,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email)
									VALUES (".$_POST['UpdateRoom'].", ".mysql_real_escape_string($AmenityItem).", '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
									
				if (!mysql_query($AddAmenitiesQuery))
				{
					ActivityLog('Error', curPageURL(), 'Add Room Amenity - Update',  $AddAmenitiesQuery, mysql_error());
					die ("Could not insert - part of update - into the database: <br />". mysql_error());
				}
			}
		
		}	
	}

	$UpdateRoomQuery = "UPDATE Room
			SET RoomName = '".mysql_real_escape_string($_POST['RoomName'])."',
				Beds = ".$_POST['Beds'].",
				Audit_user_name = '".$_SESSION['user_name']."',
				Audit_Role = '".$_SESSION['Role']."',
				Audit_FirstName = '".$_SESSION['FirstName']."',
				Audit_LastName = '".$_SESSION['LastName']."', 
				Audit_Email = '".$_SESSION['Email']."'
			WHERE RoomId = ".$_POST['UpdateRoom']."
			AND HouseId = ".$_SESSION['HouseId'];

	if (!mysql_query($UpdateRoomQuery))
	{
		ActivityLog('Error', curPageURL(), 'Update Room',  $UpdateRoomQuery, mysql_error());
		die ("Could not update the database: <br />". mysql_error());
	}

	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageRooms.php\"/>";

	echo "Congrats you have updated your room";

}
// This is the room delete logic 

if (isset($_GET['RoomId']))
{
	if ($_GET['Change'] == 'Delete')
	{
		$DeleteRoomQuery = "DELETE FROM Room WHERE RoomId = ".$_GET['RoomId'];
	
		if (!mysql_query( $DeleteRoomQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Room',  $DeleteRoomQuery, mysql_error());
			die ("Could not delete from the database: <br />". mysql_error());
		}

		$DeleteRoomAmenityQuery = "DELETE FROM RoomAmenity WHERE RoomId = ".$_GET['RoomId'];
	
		if (!mysql_query( $DeleteRoomAmenityQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Room Amenity',  $DeleteRoomAmenityQuery, mysql_error());
			die ("Could not insert into the database: <br />". mysql_error());
		}
		echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageRooms.php\"/>";


		echo "Congrats you have deleted your room";
	}


// This is the room edit logic
// Create a picklist where the user can select multiple items

	if ($_GET['Change'] == 'Update')
	{
		$AmenityQuery = "SELECT A.AmenityName, A.AmenityID 
		FROM RoomAmenity R, AmenityType A
		WHERE R.AmenityID = A.AmenityID
		AND R.RoomId = ".$_GET['RoomId'];
				
		$AmenityResult = mysql_query( $AmenityQuery );
		if (!$AmenityResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Room Amenity',  $AmenityQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
	
		$AmenityCounter = 0;
		while ($AmenityRow = mysql_fetch_array($AmenityResult, MYSQL_ASSOC)) 
		{
			$AmenityArray[$AmenityCounter] = $AmenityRow['AmenityID'];
			$AmenityCounter++;
		}

		echo "<tr><td colspan=\"4\">&nbsp;</td></tr><tr>";	

		$RoomNameQuery = "SELECT RoomName, Beds
		FROM Room
		WHERE RoomId = ".$_GET['RoomId']."
		AND HouseId = ".$_SESSION['HouseId'];
				
		$RoomNameResult = mysql_query( $RoomNameQuery );
		if (!$RoomNameResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Room Info',  $RoomNameQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
	
		while ($RoomNameRow = mysql_fetch_array($RoomNameResult, MYSQL_ASSOC)) 
		{
			$RoomName = $RoomNameRow['RoomName'];
			$Beds = $RoomNameRow['Beds'];
		}

		echo "<tr align=\"center\"><td class=\"TextItem\">Room Name:</td><td colspan=\"3\"><input maxlength=\"40\" type=\"text\" name=\"RoomName\" Value=\"".stripslashes($RoomName)."\"></td></tr>";
//		echo "<tr align=\"center\"><td class=\"TextItem\">Beds:</td><td colspan=\"3\"><input type=\"text\" name=\"Beds\" Value=\"".$Beds."\"></td></tr>";
		echo "<input type=\"hidden\" name=\"Beds\" value=\"1\">";

		echo "<tr align=\"center\"><td class=\"TextItem\">Amenities:</td><td colspan=\"3\"><select multiple=\"multiple\" size=\"5\" name=\"AmenityPick[]\">";
	
		$AmenityListQuery = "SELECT A.AmenityName, A.AmenityId
			FROM AmenityType A Order By A.AmenityName";
				
		$AmenityListResult = mysql_query( $AmenityListQuery );
		if (!$AmenityListResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Amenity Info',  $AmenityListQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		
		while ($AmenityListRow = mysql_fetch_array($AmenityListResult, MYSQL_ASSOC)) 
		{
			echo "<option value=\"".$AmenityListRow['AmenityId']."\"";
	
			for ($Counter = 0 ; $Counter <= $AmenityCounter - 1; $Counter++) 
			{
				if ($AmenityListRow['AmenityId'] == $AmenityArray[$Counter])
				{
					echo " SELECTED";
				}
			}

			echo ">".$AmenityListRow['AmenityName']."</option>";
		}
		echo "</select>";
		echo "</td></tr>";
		echo "<tr><td colspan=\"4\"><input type=\"hidden\" name=\"UpdateRoom\" value=\"".$_GET['RoomId']."\"></td></tr>";
		echo "<tr><td colspan=\"4\"><input type=\"submit\" value=\"Update Room\" /></td></tr>";

	}
}
else
{
//This is the form logic to create a new room
	echo "<tr><td colspan=\"4\">&nbsp;</td></tr><tr>";	
	echo "<tr align=\"center\"><td align=\"center\" class=\"TextItem\" width=\"50%\">Room Name:</td><td align=\"left\" colspan=\"3\"><input maxlength=\"40\" type=\"text\" name=\"RoomName\"></td></tr>";
//	echo "<tr align=\"center\"><td align=\"center\" class=\"TextItem\">Beds:</td><td align=\"left\" colspan=\"3\"><input type=\"text\" name=\"Beds\"></td></tr>";
	echo "<input type=\"hidden\" name=\"Beds\" value=\"1\">";
	echo "<tr align=\"center\"><td align=\"center\" class=\"TextItem\">Amenities:</td><td align=\"left\" colspan=\"3\"><select multiple=\"multiple\" size=\"5\" name=\"AmenityPick[]\">";
		$AmenityListQuery = "SELECT A.AmenityName, A.AmenityId
			FROM AmenityType A";
				
		$AmenityListResult = mysql_query( $AmenityListQuery );
		if (!$AmenityListResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Amenity Info - New',  $AmenityListQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		
		while ($AmenityListRow = mysql_fetch_array($AmenityListResult, MYSQL_ASSOC)) 
		{
			echo "<option value=\"".$AmenityListRow['AmenityId']."\">".$AmenityListRow['AmenityName']."</option>";
		}
		echo "</select>";
		echo "</td></tr>";

	echo "<tr><td colspan=\"4\"><input type=\"hidden\" name=\"AddRoom\" value=\"Y\">";
	echo "<tr><td colspan=\"4\"><input type=\"submit\" value=\"Add Room\" /></td></tr>";
}
?>
