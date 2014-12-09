<?php session_start(); ?>
<?php header("Cache-control: private"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

function Validate(inForm) {

    var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\" :<>?";

    var iNameChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";


	if(inForm.password1.value == '' || inForm.password1.value == null || inForm.password2 == '' || inForm.password2.value == null)
	{
		alert('Passwords must be populated');
		return false;
	}
	else if(inForm.user_name.value.length < 3)
	{
		alert('House Name must be at least three characters');
		return false;
	}
	else if(inForm.password1.value.length > 0 && (inForm.password1.value.length < 8 || inForm.password2.value.length < 8 ))
	{
		alert('Password must be at least eight characters');
		return false;
	}
	else if(inForm.password1.value != inForm.password2.value )
	{
		alert('Passwords must must match');
		return false;
	}
	else if(inForm.email.value.length < 5 || inForm.email.value.indexOf("@") == -1 || inForm.email.value.indexOf(".") == -1)
	{
		alert('Email must be a valid email address');
		return false;
	}

	else
	{
	  for (var i = 0; i < inForm.user_name.value.length; i++) {
		if (iChars.indexOf(inForm.user_name.value.charAt(i)) != -1) {
		alert ("Your username has special characters. \nPlease only use numbers and letters.\n Please remove them and try again.");
		return false;
		}
      }
	  for (var i = 0; i < inForm.password1.value.length; i++) {
		if (iChars.indexOf(inForm.password1.value.charAt(i)) != -1) {
		alert ("Your password has special characters. \nPlease only use numbers and letters.\n Please remove them and try again.");
		return false;
		}
      }
	  for (var i = 0; i < inForm.first_name.value.length; i++) {
		if (iNameChars.indexOf(inForm.first_name.value.charAt(i)) != -1) {
		alert ("Your first name has special characters. \nPlease only use numbers and letters.\n Please remove them and try again.");
		return false;
		}
      }
	  for (var i = 0; i < inForm.last_name.value.length; i++) {
		if (iNameChars.indexOf(inForm.last_name.value.charAt(i)) != -1) {
		alert ("Your last name has special characters. \nPlease only use numbers and letters.\n Please remove them and try again.");
		return false;
		}
      }
	  return true;
	}
}

</SCRIPT>

</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'New House Setup Page 2',  NULL, NULL); ?>
<?php include("register_funcs.inc") ?>
<?php

//echo "<pre>";
//print_r ($_POST);
//echo "</pre>";

// This is the logic to set the logo of the house 




// This is the logic to create a new house record. It is important so we are going to first check that it has not been done already 

if (isset($_POST['HouseName']))
{
	
	$IsNewHouseQuery = "SELECT * FROM House WHERE HouseName = '".mysql_real_escape_string($_POST['HouseName'])."'";

	if (!mysql_query( $IsNewHouseQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Select House Info for House Setup',  $IsNewHouseQuery, mysql_error());
		die ("Could not execute house search: <br />". mysql_error());
	}
    $result = mysql_query($IsNewHouseQuery);

// If the house name exists, then prompt for a new name and pass the other values as hidden variables


    if (!$result || mysql_num_rows($result) > 0)
    {
		$feedback = 'A house with this name already exists in the system, please select another name';
		
		echo $feedback."<br/><br/>";

		$Address1 = mysql_real_escape_string($_POST['Address1']);
		$Address2 = mysql_real_escape_string($_POST['Address2']);
		$City = mysql_real_escape_string($_POST['City']);
		$State = mysql_real_escape_string($_POST['State']);
		$ZipCode = mysql_real_escape_string($_POST['ZipCode']);
		$HomePhone = mysql_real_escape_string($_POST['HomePhone']);
		$Fax = mysql_real_escape_string($_POST['Fax']);
		$EmergencyPhone = mysql_real_escape_string($_POST['EmergencyPhone']);
		$ReferredBy = mysql_real_escape_string($_POST['ReferredBy']);
		

$house_form = <<< EOHOUSEFORM

<form id="inForm" action="NewHouseTwo.php" method="post" >
<table border="0" align="center" width="55%">
	<tr align="center">
		<td colspan="4"><h1>Create your Vacation House</h1>&nbsp;<h2>Page 2</h2></td>
	</tr>

	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" cellpadding="5" width="100%">
				<tr>
					<td colspan="4"><h3>Enter A Different House Name</h3></td>
				</tr>
				<tr>
					<td class="TextItem">House Name*:</td><td colspan="1"><input maxlength="20" type="text" name="HouseName"></input>
					<input type="hidden" name="Address1" value=$Address1></input>
					<input type="hidden" name="Address2" value=$Address2></input>
					<input type="hidden" name="City" value=$City></input>
					<input type="hidden" name="State" value=$State></input>
					<input type="hidden" name="ZipCode" value=$ZipCode></input>
					<input type="hidden" name="HomePhone" value=$HomePhone></input>
					<input type="hidden" name="Fax" value=$Fax></input>
					<input type="hidden" name="EmergencyPhone" value=$EmergencyPhone></input>
					<input type="hidden" name="ReferredBy" value=$ReferredBy></input>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table border="0" align="center" width="55%">
	<tr>
		<td align="left" colspan="3">* Required Field</td>
		<td align="right"><input type="submit" value="Next" onclick="return Validate(this.form);"></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
</table>
</form>
EOHOUSEFORM;

echo $house_form;

	}

	// If the house name is new, save the record and get a house id

	else      
	{
		$AddHouseQuery = "INSERT INTO House (HouseName, Address1, Address2, City, State, ZipCode, HomePhone, Fax, EmergencyPhone, ReferredBy, Status,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
					VALUES ('".mysql_real_escape_string($_POST['HouseName'])."', '".mysql_real_escape_string($_POST['Address1'])."', '".mysql_real_escape_string($_POST['Address2'])."', 
					'".mysql_real_escape_string($_POST['City'])."', '".mysql_real_escape_string($_POST['State'])."', '".mysql_real_escape_string($_POST['ZipCode'])."', 
					'".mysql_real_escape_string($_POST['HomePhone'])."', '".mysql_real_escape_string($_POST['Fax'])."', '".mysql_real_escape_string($_POST['EmergencyPhone'])."', '".mysql_real_escape_string($_POST['ReferredBy'])."', 'P',
					'New House', NULL, NULL, NULL, NULL)";

		if (!mysql_query( $AddHouseQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Insert House Info for House Setup',  $AddHouseQuery, mysql_error());
			die ("Could not insert new house info 1 into the database: <br />". mysql_error());
		}
		
//		echo "<br/><br/>Last inserted record has id ".mysql_insert_id();
		
		$NewHouseId = mysql_insert_id();

$admin_form = <<< EOADMINFORM

<form id="inForm" action="NewHouseThree.php" method="post" >
<table border="0" align="center" width="55%">
	<tr align="center">
		<td colspan="4"><h1>Create your Vacation House</h1>&nbsp;<h2>Page 2</h2></td>
	</tr>

	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" cellpadding="5" width="100%">
				<tr>
					<td colspan="4"><h3>Administrator Information</h3></td>
				</tr>
				<tr>
					<td class="TextItem">Admin Username*:</td><td colspan="1"><input maxlength="20" type="text" name="user_name"></input>
				</tr>
				<tr>
					<td class="TextItem">Admin Password*:</td><td colspan="1"><input maxlength="20" type="password" name="password1"></input>
				</tr>
				<tr>
					<td class="TextItem">Admin Password (confirm)*:</td><td colspan="1"><input maxlength="20" type="password" name="password2"></input>
				</tr>
				<tr>
					<td class="TextItem">Admin Email*:</td><td colspan="1"><input maxlength="40" type="text" name="email"></input>
					<input type="hidden" name="houseid" value=$NewHouseId></input>
				</tr>
				<tr>
					<TD CLASS=TextItem>Allow Administrator to have Owner permissions:</td><td colspan="1"><input name="AdminOwner" type="checkbox"></td>
				</tr>				
				<tr>
					<td class="TextItem">First Name:</td><td colspan="1"><input maxlength="40" type="text" name="first_name"></input>
				</tr>
				<tr>
					<td class="TextItem">Last Name:</td><td colspan="1"><input maxlength="40" type="text" name="last_name"></input>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table border="0" align="center" width="55%">
	<tr>
		<td align="left" colspan="3">* Required Field</td>
		<td align="right"><input type="submit" value="Next" onclick="return Validate(this.form);"></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
</table>
</form>
EOADMINFORM;

echo $admin_form;

	}
}


if (isset($_FILES['HousePicture']))
{
	if (strlen(trim($_FILES['HousePicture']['tmp_name'])) > 0) 
	{	
		
		// Where the file is going to be placed 
		$target_path = "images/";
		
		/* Add the original filename to our target path.  
		Result is "uploads/filename.extension" */
		$target_path = $target_path.basename( $_FILES['HousePicture']['name']); 
		
		if(move_uploaded_file($_FILES['HousePicture']['tmp_name'], $target_path)) {
			echo "The file ".  basename( $_FILES['HousePicture']['name']). 
			" has been uploaded";
		} else{
			echo "There was an error uploading the file, please try again!";
		}
		
		
		// Setting the resize parameters
		$WorkingPicture = imagecreatefromjpeg($target_path);
		$width = ImageSx($WorkingPicture);
		$height = ImageSy($WorkingPicture);
		$Ratio = $height/$width;

		$IconCompress = 100;
		
		//
		// Creating the Icons 
		//
		
		// Creating the Icon Canvas
		$NewHeight = 120;
		$NewWidth = $NewHeight/$Ratio;
		
		$IconPicture = imagecreatetruecolor($NewWidth, $NewHeight);
		
		// Resizing our image to fit the canvas
		imagecopyresized($IconPicture, $WorkingPicture, 0, 0, 0, 0, $NewWidth, $NewHeight, $width, $height);
		
		$IconSaveName = "images/customimage_".$NewHouseId.".jpg";
	
		imagejpeg($IconPicture, $IconSaveName, $IconCompress);

//		echo "<img src=\"images/customimage.jpg\">";
	}
	else 
	{
//		echo "No picture uploaded";
	}
}

if (isset($NewHouseId))
{
	$feedback = guest_register($NewHouseId);
}
else
{
	$feedback = "";
}

?>



<?php include("Footer.php") ?>


</body>
</html>
