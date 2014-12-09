<?php ActivityLog('Info', curPageURL(), 'Get Guest List Include',  NULL, NULL); ?>
<?php

echo "<tr align=\"center\"><td class=\"TableHeader\">Visitor Name</td><td class=\"TableHeader\">Visitor Email</td><td class=\"TableHeader\">Available to<br/>All Owners</td><td colspan=\"2\" class=\"TableHeader\">Actions</td></tr>";

//This section displays the guests in the system
	if ($_SESSION["Role"] == 'Administrator')
	{
		$GuestQuery = "SELECT CONCAT(FirstName, ' ', LastName) Name, Email, GuestId, HouseGuest
						FROM Guest 
						WHERE  (HouseGuest = 'Y' OR OwnerId = ".$_SESSION["OwnerId"].")
						AND GuestId <> ".$_SESSION["OwnerId"]."
						AND HouseId = ".$_SESSION["HouseId"]."
						AND GuestId <> OwnerId
						ORDER BY LastName, FirstName";
	}
	else
	{
		$GuestQuery = "SELECT CONCAT(FirstName, ' ', LastName) Name, Email, GuestId, HouseGuest
						FROM Guest 
						WHERE OwnerId = ".$_SESSION["OwnerId"]."
						AND GuestId <> ".$_SESSION["OwnerId"]."
						AND HouseId = ".$_SESSION["HouseId"]."
						ORDER BY LastName, FirstName";
	}


	$GuestResult = mysql_query( $GuestQuery );
	if (!$GuestResult)
	{
		ActivityLog('Error', curPageURL(), 'Select Guest List',  $GuestQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

	$counter = 1;
	while ($GuestRow = mysql_fetch_array($GuestResult, MYSQL_ASSOC)) 
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
		echo "<td class=\"TextItem\">".stripslashes($GuestRow['Name'])."</td>";
		echo "<td class=\"TextItem\">".stripslashes($GuestRow['Email'])."</td>";
		echo "<td align =\"center\" class=\"TextItem\">".stripslashes($GuestRow['HouseGuest'])."</td>";
		echo "<td align =\"center\"><a href=\"ManageGuests.php?GuestId=".$GuestRow['GuestId']."&Change=Edit\">Edit Visitor</a></td>";
		echo "<td align =\"center\"><a href=\"ManageGuests.php?GuestId=".$GuestRow['GuestId']."&Change=Delete\">Delete Visitor</a></td></tr>";
	}
?>
