<?php ActivityLog('Info', curPageURL(), 'Input Guest Information Include',  NULL, NULL); ?>

<?php
// This is the save logic for a new guest

$GuestFirstName = '';
$GuestLastName = '';
$GuestEmail = '';

if ($_SESSION['Role'] == 'Administrator' && !IsAdminOwner())
{
	$HouseGuest = 'Y';
}
elseif ($_SESSION['Role'] == 'Administrator' && IsAdminOwner())
{
	if (isset($_POST['AvailAllOwners']))
	{
		$HouseGuest = 'Y';		
	}
	else
	{
		$HouseGuest = 'N';	
	}
}
else
{
	$HouseGuest = 'N';	
}


if (isset($_POST['AddGuest']))
{
	$AddGuestQuery = "INSERT INTO Guest (FirstName, LastName, Email, OwnerId, HouseId, HouseGuest,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email)
					VALUES ('".mysql_real_escape_string(trim($_POST['FirstName']))."', '".mysql_real_escape_string(trim($_POST['LastName']))."', '".mysql_real_escape_string(trim($_POST['Email']))."', ".$_SESSION['OwnerId'].", ".$_SESSION['HouseId'].", '".$HouseGuest."',
					'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";

	if (!mysql_query( $AddGuestQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Insert Guest Info',  $AddGuestQuery, mysql_error());
		die ("Could not insert Guest into the database: <br />". mysql_error());
	}

	if (isset($_POST['SendEmail']) && strlen(trim($_POST['Email'])) > 1)
	{
	
		$GuestPswdQuery = "SELECT h.Guest, h.HouseName from House h WHERE h.HouseId = ".$_SESSION['HouseId'];

		$GuestPswdResult = mysql_query( $GuestPswdQuery );
		if (!$GuestPswdResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Guest Password',  $GuestPswdQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}


		while ($GuestPswdRow = mysql_fetch_array($GuestPswdResult, MYSQL_ASSOC))
		{
			$EmailPassword = $GuestPswdRow['Guest'];
			$EmailHouseName = $GuestPswdRow['HouseName'];
		}

		$GuestFirstName = trim($_POST['FirstName']);
		$GuestLastName = trim($_POST['LastName']);
		$OwnerFirstName = $_SESSION['FirstName'];
		$OwnerLastName = $_SESSION['LastName'];
		$GuestEmail = trim($_POST['Email']);
		$server = $_SERVER['HTTP_HOST'];

		$mail_body = <<< EOMAILBODY
$GuestFirstName $GuestLastName,

$OwnerFirstName $OwnerLastName is inviting you to visit the vacation home, $EmailHouseName, on $server

As a guest to $EmailHouseName on $server you can see when the vacation home is in use, request to visit, participate in the blog, and view the house bulletin board. 

Please visit http://$server. Select "$EmailHouseName" from the the vacation home drop down menu and enter "$EmailPassword" as the Guest Password

Thank you!
		
		
EOMAILBODY;

		mail ($GuestEmail, 'The Vacation Calendar Guest Request', $mail_body, 'From: noreply@TheVacationCalendar.com');

		echo "Congrats, an email has been sent to ".$GuestFirstName." ".$GuestLastName.".<br/><br/>";
	}
//
	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageGuests.php\"/>";
	echo "Congrats you have added your guest.";
}

// This is the guest update logic

if (isset($_POST['EditGuest']))
{
	$UpdateGuestQuery = "UPDATE Guest SET
						FirstName = '".mysql_real_escape_string(trim($_POST['FirstName']))."',
						LastName = '".mysql_real_escape_string(trim($_POST['LastName']))."',
						Email = '".mysql_real_escape_string(trim($_POST['Email']))."',
						HouseGuest = '".$HouseGuest."',
						Audit_user_name = '".$_SESSION['user_name']."',
						Audit_Role = '".$_SESSION['Role']."',
						Audit_FirstName = '".$_SESSION['FirstName']."',
						Audit_LastName = '".$_SESSION['LastName']."', 
						Audit_Email = '".$_SESSION['Email']."'
						WHERE GuestId = ".$_POST['EditGuest']."
						AND OwnerId = ".$_SESSION['OwnerId']."
						AND HouseId = ".$_SESSION['HouseId'];

	if (!mysql_query( $UpdateGuestQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Update Guest Info',  $UpdateGuestQuery, mysql_error());
		die ("Could not update Guest in the database: <br />". mysql_error());
	}

	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageGuests.php\"/>";
	echo "Congrats you have updated your visitor";

}
// This is the guest delete logic

if (isset($_GET['GuestId']))
{
	if ($_GET['Change'] == 'Delete')
	{
		$DeleteScheduledGuestQuery = "DELETE FROM Schedule WHERE GuestId = ".$_GET['GuestId']." AND HouseId = ".$_SESSION['HouseId'];

		if (!mysql_query( $DeleteScheduledGuestQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Guest from Schedule',  $DeleteScheduledGuestQuery, mysql_error());
			die ("Could not delete guest scheduled from the database: <br />". mysql_error());
		}

		if ($_SESSION["Role"] == 'Administrator')
		{
			$DeleteGuestQuery = "DELETE FROM Guest WHERE GuestId = ".$_GET['GuestId']." AND (HouseGuest = 'Y' OR OwnerId = ".$_SESSION["OwnerId"].") AND HouseId = ".$_SESSION['HouseId'];
		}
		else
		{
			$DeleteGuestQuery = "DELETE FROM Guest WHERE GuestId = ".$_GET['GuestId']." AND OwnerId = ".$_SESSION['OwnerId']." AND HouseId = ".$_SESSION['HouseId'];
		}

		if (!mysql_query( $DeleteGuestQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Delete Guest',  $DeleteGuestQuery, mysql_error());
			die ("Could not delete from the database: <br />". mysql_error());
		}
		echo "Congrats you have deleted your visitor";
		echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageGuests.php\"/>";
	}


	if ($_GET['Change'] == 'Edit')
	{
		if ($_SESSION["Role"] == 'Administrator')
		{
			$EditGuestQuery = "SELECT FirstName, LastName, Email, HouseGuest
							FROM Guest 
							WHERE (HouseGuest = 'Y' OR OwnerId = ".$_SESSION["OwnerId"].")
							AND GuestId = ".$_GET['GuestId']."
							AND HouseId = ".$_SESSION["HouseId"];
		}
		else
		{
			$EditGuestQuery = "SELECT FirstName, LastName, Email, HouseGuest
							FROM Guest 
							WHERE OwnerId = ".$_SESSION["OwnerId"]."
							AND GuestId = ".$_GET['GuestId']."
							AND HouseId = ".$_SESSION["HouseId"];
		}

		$EditGuestResult = mysql_query( $EditGuestQuery );
		if (!$EditGuestResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Guest Info',  $EditGuestQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}


		while ($EditGuestRow = mysql_fetch_array($EditGuestResult, MYSQL_ASSOC))
		{
			$GuestFirstName = $EditGuestRow['FirstName'];
			$GuestLastName = $EditGuestRow['LastName'];
			$GuestEmail = $EditGuestRow['Email'];
			if ($EditGuestRow['HouseGuest'] == 'Y') 
			{
				$HouseGuestVal = "CHECKED"; 
			}
			ELSE
			{
				$HouseGuestVal = "";
			}
		}
		
		
		echo "<tr><td colspan=\"4\">&nbsp;</td></tr><tr>";
		echo "<tr><td class=\"TextItem\">Visitor First Name:</td><td colspan=\"3\"><input maxlength=\"20\" type=\"text\" name=\"FirstName\" Value=\"".stripslashes($GuestFirstName)."\"></td></tr>";
		echo "<tr><td class=\"TextItem\">Visitor Last Name:</td><td colspan=\"3\"><input maxlength=\"20\" type=\"text\" name=\"LastName\" Value=\"".stripslashes($GuestLastName)."\"></td></tr>";
		echo "<tr><td class=\"TextItem\">Visitor Email:</td><td colspan=\"3\"><input maxlength=\"40\" type=\"text\" name=\"Email\" Value=\"".stripslashes($GuestEmail)."\"></td></tr>";
		if (IsAdminOwner())
		{
			echo "<tr><td class=\"TextItem\">Make Visitor Available to All Owners:</td><td colspan=\"3\"><input type=\"checkbox\" unchecked name=\"AvailAllOwners\" Value=\"N\" ".$HouseGuestVal."></td></tr>";
		}
		echo "<tr><td colspan=\"4\"><input type=\"hidden\" name=\"EditGuest\" value=\"".$_GET['GuestId']."\">";
		echo "<tr><td colspan=\"2\"><input type=\"button\" OnClick=\"location.href='ManageGuests.php';\" value=\"Reset\"/></td><td colspan=\"2\"><input type=\"submit\" value=\"Update Guest\" /></td></tr>";

	}
}
else
{
//This is the form logic to submit a new guest
echo "<tr><td colspan=\"4\">&nbsp;</td></tr><tr>";
echo "<tr><td class=\"TextItem\">Visitor First Name:</td><td colspan=\"3\"><input maxlength=\"20\" type=\"text\" name=\"FirstName\" Value=\"".stripslashes($GuestFirstName)."\"></td></tr>";
echo "<tr><td class=\"TextItem\">Visitor Last Name:</td><td colspan=\"3\"><input maxlength=\"20\" type=\"text\" name=\"LastName\" Value=\"".stripslashes($GuestLastName)."\"></td></tr>";
echo "<tr><td class=\"TextItem\">Visitor Email:</td><td colspan=\"3\"><input maxlength=\"40\" type=\"text\" name=\"Email\" Value=\"".stripslashes($GuestEmail)."\"></td></tr>";
echo "<tr><td class=\"TextItem\">Send Email to Visitor:</td><td colspan=\"3\"><input type=\"checkbox\" unchecked name=\"SendEmail\" Value=\"Y\"></td></tr>";
if (IsAdminOwner())
{
	echo "<tr><td class=\"TextItem\">Make Visitor Available to All Owners:</td><td colspan=\"3\"><input type=\"checkbox\" unchecked name=\"AvailAllOwners\" Value=\"N\"></td></tr>";
}
echo "<tr><td colspan=\"4\"><input type=\"hidden\" name=\"AddGuest\" value=\"Y\">";
echo "<tr><td colspan=\"2\"><input type=\"reset\" value=\"Reset\"/></td><td colspan=\"2\"><input type=\"submit\" value=\"Add Guest\" /></td></tr>";
}
?>
