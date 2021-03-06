<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">		
	<title>The Vacation Calendar</title>
	<link href="css/BeachStyle.css" rel="stylesheet" type="text/css" />	
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">
	<link href="css/lightbox.css" rel="stylesheet" />	
</HEAD>
<body onload="init();">



<script type="text/javascript">

function init() 
{
try {
	if (document.getElementById('Profile')) {
		document.getElementById('Profile').className="NavSelected";
		document.getElementById('ProfileLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}


function Validate(inForm) {

    var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\" :<>?";

	if(inForm.HousePass.value == '' || inForm.HousePass.value == null || inForm.HouseConfirm == '' || inForm.HouseConfirm.value == null)
	{
		alert('Passwords must be populated');
		return false;
	}
	else if(inForm.HouseName.value.length < 3)
	{
		alert('House Name must be at least three characters');
		return false;
	}
	else if(inForm.HousePass.value.length > 0 && (inForm.HousePass.value.length < 8 || inForm.HouseConfirm.value.length < 8 ))
	{
		alert('Password must be at least eight characters');
		return false;
	}
	else if(inForm.HousePass.value != inForm.HouseConfirm.value )
	{
		alert('Passwords must must match');
		return false;
	}
	else
	{
      for (var i = 0; i < inForm.HousePass.value.length; i++) {
		if (iChars.indexOf(inForm.HousePass.value.charAt(i)) != -1) {
		alert ("Your password has special characters. \nPlease only use numbers and letters.\n Please remove them and try again.");
		return false;
		}
	  }
	  return true;
	}
}

</SCRIPT>



<?php if (isset($_SESSION['Role']))
{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php include("register_funcs.inc") ?>
<?php ActivityLog('Info', curPageURL(), 'Manage Profile Main',  NULL, NULL); ?>

<?php 
$GetHouseAdrQuery = "SELECT Address1, Address2, City, State, ZipCode, HomePhone, Fax, EmergencyPhone
					FROM House 
					WHERE HouseId = ".$_SESSION['HouseId'];


$GetHouseAdrResult = mysqli_query( $GLOBALS['link'],  $GetHouseAdrQuery );
if (!$GetHouseAdrResult)
{
	ActivityLog('Error', curPageURL(), 'Select House Info for Admin Profile',  $GetHouseAdrQuery, mysqli_error($GLOBALS['link']));
	die ("Could not search the database for houses: <br />". mysqli_error($GLOBALS['link']));
}
else
{
	while ($GetHouseAdrRow = mysqli_fetch_array($GetHouseAdrResult, MYSQL_ASSOC)) 
	{
		$Address1 = $GetHouseAdrRow['Address1'];
		$Address2 = $GetHouseAdrRow['Address2'];
		$City = $GetHouseAdrRow['City'];
		$State = $GetHouseAdrRow['State'];
		$ZipCode = $GetHouseAdrRow['ZipCode'];
		$HomePhone = $GetHouseAdrRow['HomePhone'];
		$Fax = $GetHouseAdrRow['Fax'];
		$EmergencyPhone = $GetHouseAdrRow['EmergencyPhone'];
	}
}

if (isset($_POST['CalEmailList']))
{
	$UpdateCalEmailList = "UPDATE House SET CalEmailList = '".$_POST['CalEmailList']."',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."' 
						WHERE HouseId = ".$_SESSION['HouseId'];

	if (!mysqli_query( $GLOBALS['link'],  $UpdateCalEmailList ))
	{
		ActivityLog('Error', curPageURL(), 'Update Email List',  $UpdateCalEmailList, mysqli_error($GLOBALS['link']));
		die ("Could not update email list in the database: <br />". mysqli_error($GLOBALS['link']));
	}
}

if (isset($_POST['BlogEmailList']))
{
	$UpdateBlogEmailList = "UPDATE House SET BlogEmailList = '".$_POST['BlogEmailList']."',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."' 
						WHERE HouseId = ".$_SESSION['HouseId'];

	if (!mysqli_query( $GLOBALS['link'],  $UpdateBlogEmailList ))
	{
		ActivityLog('Error', curPageURL(), 'Update Email List',  $UpdateBlogEmailList, mysqli_error($GLOBALS['link']));
		die ("Could not update email list in the database: <br />". mysqli_error($GLOBALS['link']));
	}
}

if (isset($_POST['AdminOwner']) && isset($_POST['ShowOldSave']))
{
		$UpdateOwnerAdmin = "UPDATE user SET AdminOwner = 'Y', ShowOldSave = 'Y',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."' 
						WHERE user_id = ".$_SESSION['OwnerId']."
						AND HouseId = ".$_SESSION['HouseId'];

	if (!mysqli_query( $GLOBALS['link'],  $UpdateOwnerAdmin ))
	{
		ActivityLog('Error', curPageURL(), 'Update Admin Info Y for Admin Profile',  $UpdateOwnerAdmin, mysqli_error($GLOBALS['link']));
		die ("Could not update OwnerAdmin in the database: <br />". mysqli_error($GLOBALS['link']));
	}

	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageProfile.php\"/>";
	echo "Congrats you have updated the Administrator";

}
elseif (isset($_POST['SubmitAdminOwner']) && isset($_POST['ShowOldSave']))
{
		$UpdateOwnerAdmin = "UPDATE user SET AdminOwner = 'N', ShowOldSave = 'Y',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."' 
						WHERE user_id = ".$_SESSION['OwnerId']."
						AND HouseId = ".$_SESSION['HouseId'];

	if (!mysqli_query( $GLOBALS['link'],  $UpdateOwnerAdmin ))
	{
		ActivityLog('Error', curPageURL(), 'Update Admin Info Y for Admin Profile',  $UpdateOwnerAdmin, mysqli_error($GLOBALS['link']));
		die ("Could not update OwnerAdmin in the database: <br />". mysqli_error($GLOBALS['link']));
	}

	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageProfile.php\"/>";
	echo "Congrats you have updated the Administrator";

}
elseif (isset($_POST['AdminOwner']) && isset($_POST['SubmitAdminOwner']))
{
		$UpdateOwnerAdmin = "UPDATE user SET AdminOwner = 'Y', ShowOldSave = 'N',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."' 
						WHERE user_id = ".$_SESSION['OwnerId']."
						AND HouseId = ".$_SESSION['HouseId'];

	if (!mysqli_query( $GLOBALS['link'],  $UpdateOwnerAdmin ))
	{
		ActivityLog('Error', curPageURL(), 'Update Admin Info Y for Admin Profile',  $UpdateOwnerAdmin, mysqli_error($GLOBALS['link']));
		die ("Could not update OwnerAdmin in the database: <br />". mysqli_error($GLOBALS['link']));
	}

	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageProfile.php\"/>";
	echo "Congrats you have updated the Administrator";

}
elseif (isset($_POST['SubmitAdminOwner']))
{
		$UpdateOwnerAdmin = "UPDATE user SET AdminOwner = 'N', ShowOldSave = 'N',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."' 
						WHERE user_id = ".$_SESSION['OwnerId']."
						AND HouseId = ".$_SESSION['HouseId'];

	if (!mysqli_query( $GLOBALS['link'],  $UpdateOwnerAdmin ))
	{
		ActivityLog('Error', curPageURL(), 'Update Admin Info N for Admin Profile',  $UpdateOwnerAdmin, mysqli_error($GLOBALS['link']));
		die ("Could not update OwnerAdmin in the database: <br />". mysqli_error($GLOBALS['link']));
	}

	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageProfile.php\"/>";
	echo "Congrats you have updated the Administrator";

}

if (isset($_POST['Address1']) || isset($_POST['Address2']) || isset($_POST['City']) || isset($_POST['ZipCode']) || isset($_POST['State']) || isset($_POST['HomePhone']) || isset($_POST['Fax']) || isset($_POST['EmergencyPhone'])) 
{
		$UpdateHouseQuery = "UPDATE House 
							Set Address1 = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['Address1'])."',
								Address2 = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['Address2'])."', 
								City = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['City'])."',
								State = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['State'])."',
								ZipCode = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['ZipCode'])."',
								HomePhone = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['HomePhone'])."',
								Fax = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['Fax'])."',
								EmergencyPhone = '".mysqli_real_escape_string($GLOBALS['link'], $_POST['EmergencyPhone'])."',
								Audit_user_name = '".$_SESSION['user_name']."',
								Audit_Role = '".$_SESSION['Role']."',
								Audit_FirstName = '".$_SESSION['FirstName']."',
								Audit_LastName = '".$_SESSION['LastName']."', 
								Audit_Email = '".$_SESSION['Email']."' 
							WHERE HouseId = ".$_SESSION['HouseId'];

		if (!mysqli_query( $GLOBALS['link'],  $UpdateHouseQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Update House Info for Admin Profile',  $UpdateHouseQuery, mysqli_error($GLOBALS['link']));
			die ("Could not update new house info 1 into the database: <br />". mysqli_error($GLOBALS['link']));
		}
		echo "<meta http-equiv=\"Refresh\" content=\"1; url=ManageProfile.php\"/>";
		echo "Congrats you have updated the house address";

}


if (isset($_POST['HousePass']))
{
	$feedback = guest_register($_SESSION['HouseId']);
}
else
{
	$feedback = "";
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
		$NewHeight = 300;
		$NewWidth = $NewHeight/$Ratio;
		
		$IconPicture = imagecreatetruecolor($NewWidth, $NewHeight);
		
		// Resizing our image to fit the canvas
		imagecopyresized($IconPicture, $WorkingPicture, 0, 0, 0, 0, $NewWidth, $NewHeight, $width, $height);
		
		$IconSaveName = "images/customimage_".$_SESSION['HouseId'].".jpg";
	
		imagejpeg($IconPicture, $IconSaveName, $IconCompress);

//		echo "<img src=\"images/customimage.jpg\">";
		echo "<meta http-equiv=\"Refresh\" content=\"0; url=ManageProfile.php\"/>";
	}
	else 
	{
//		echo "No picture uploaded";
	}
}
?>

<div class="container vacation">	
  <h2 class="featurette-heading">Manage <?php echo $_SESSION['Role']; ?> Account</h2>
  <div style="text-align:left">
<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this section to change your password or email address.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem COLSPAN=2>

					</td>
				</tr>
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Change Your Password:
					</td>
					<TD CLASS=TextItem>
						<a href="changepass.php">Change Password</a>
					</td>
				</tr>
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Change Your Email:
					</td>
					<TD CLASS=TextItem>
						<a href="changeemail.php">Change Email</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<form enctype="multipart/form-data" id="AdminOwnerForm" action="ManageProfile.php" method="post">	
<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center">
		<td colspan="2" height="45">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Manage Website</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this option to control whether you prefer to update the calendar by clicking on the day or by scheduling on the separate vacations screen. Using just the calendar is a lot easier, however, if you are using an older browser this functionality may not work to your liking.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<form enctype="multipart/form-data" id="AdminOwnerForm" action="ManageProfile.php" method="post">	
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Show additional schedule vacations screen :
					</td>
					<TD CLASS=TextItem>
						<input name="ShowOldSave" type="checkbox" <?php echo ShowOldSave() ?>> 
					</td>
				</tr>
<?php

if ($_SESSION['Role'] == 'Administrator')
{

if (IsAdminOwner()) 
{
	$CheckedVal  = 'CHECKED';
}
else
{
	$CheckedVal = '';
}

$CalEmailList = CalEmailList();

$BlogEmailList = BlogEmailList();

$reg_str = <<< EOREGSTR
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this option to control whether the admin will also have the ability to schedule vacations. The only reason not do this is in the case that a vacation home has a person who is purely the administrator and does not schedule time using the vacation home.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Allow Administrator to have Owner permissions:
					</td>
					<TD CLASS=TextItem>
						<input name="AdminOwner" type="checkbox" $CheckedVal> 
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this option to send out a notification email any time that a vacation is inserted, updated or deleted from the calendar.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Send email when calendar changes (separate multiple by comma,<br />leave blank for no notification):
					</td>
					<TD CLASS=TextItem>
						<textarea class="form-control" cols="30" rows="2" name="CalEmailList">$CalEmailList</textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this option to send out a notification email that contains the contents of a newly created blog (only the initial blog, not the comments).</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Send email when new blog items are added (separate multiple by comma,<br />leave blank for no notification):
					</td>
					<TD CLASS=TextItem>
						<textarea class="form-control" cols="30" rows="2" name="BlogEmailList">$BlogEmailList</textarea>
					</td>
				</tr>


EOREGSTR;

	echo $reg_str;
}
?>
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						
					</td>
					<TD CLASS=TextItem><br/>
						<input class="btn btn-success" type="submit" value="Update" name="SubmitAdminOwner">
					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>
</form>		
<?php

if ($_SESSION['Role'] == 'Administrator')
{


$reg_str = <<< EOREGSTR

<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Manage Subscription</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this section to unsubscribe from TheVacationCalendar.com website. Please note that as soon as you unsubscribe in PayPal all of your usernames are immediately disabled.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem COLSPAN=2>

					</td>
				</tr>
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Unsubscribe:
					</td>
					<TD CLASS=TextItem>
						<A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=payment%thevacationcalendar%2ecom">
							<IMG SRC="https://www.paypal.com/en_US/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
						</A>
					</td>
				</tr>
			</table>
		</td>
	
	</tr>
<form enctype="multipart/form-data" id="inForm" action="ManageProfile.php" method="post">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Manage Guest Password</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this section to change the password of your Guest user.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD VALIGN=TOP CLASS=AuthNotice>
						$feedback
					</td>
				</tr>
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						<table border="0" class="FocusTable" align="center" width="100%" cellpadding="0">
							<TR ALIGN=CENTER>
								<TD CLASS=TextItem>
										Guest Password*:
								</td>
								<TD CLASS=TextItem>
										Guest Password (confirm)*:
								</td>
								<TD CLASS=TextItem>

								</td>
							</tr>
							<TR ALIGN=CENTER>
								<TD CLASS=TextItem>
										<input class="form-control" maxlength="40" type="text" name="HousePass"></input>
								</td>
								<TD CLASS=TextItem>
										<input class="form-control" maxlength="40" type="text" name="HouseConfirm"></input>
								</td>
								<TD CLASS=TextItem>
									<input class="btn btn-success" type="submit" value="Set Password" onclick="return Validate(this.form);">
								</td>
							</tr>
						</TABLE>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<form enctype="multipart/form-data" id="inForm" action="ManageProfile.php" method="post"  class="form-signin" role="form">
<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Manage Account Picture</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this section to change the account picture which shows up in the upper right hand corner of each page on the website. </p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div>
<div class="input-group">
	<span class="input-group-btn">
		<span class="btn btn-primary btn-file">
			Browse&hellip; <input type="file" class="form-control" name="HousePicture">
		</span>
	</span>
	<input type="text" class="form-control" readonly placeholder="Add a picture of your vacation home">
	<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />

</div>	
<div class="input-group">
	<br/>		
	<input class="btn btn-success" type="submit" value="Update Picture">	
</div>		
</div>
</form>
<form enctype="multipart/form-data" id="inForm" action="ManageProfile.php" method="post">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Manage House Address</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">This information is used to help your guests and owners find the house in the house search page.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="50%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem COLSPAN=2>

					</td>
				</tr>
				<tr>
					<td class="TextItem">Address Line 1:</td><td colspan="1"><input class="form-control" maxlength="40" type="text" name="Address1" value="$Address1"></input></td>
				</tr>
				<tr>
					<td class="TextItem">Address Line 2:</td><td colspan="1"><input class="form-control" maxlength="40" type="text" name="Address2" value="$Address2"></input></td>
				</tr>
				<tr>
					<td class="TextItem">City:</td><td colspan="1"><input class="form-control" maxlength="40" type="text" name="City" value="$City"></input></td>
				</tr>
				<tr>
					<td class="TextItem">State:</td><td colspan="1"><input class="form-control" size="2" maxlength="2" type="text" name="State" value="$State"></input></td>
				</tr>
				<tr>
					<td class="TextItem">Zip Code:</td><td colspan="1"><input class="form-control" size="5" maxlength="5" type="text" name="ZipCode" value="$ZipCode"></input></td>
				</tr>
				<tr>
					<td class="TextItem">Home Phone:</td><td colspan="1"><input class="form-control" size="12" maxlength="12" type="text" name="HomePhone" value="$HomePhone"></input></td>
				</tr>
				<tr>
					<td class="TextItem">Fax:</td><td colspan="1"><input class="form-control" size="12" maxlength="12" type="text" name="Fax" value="$Fax"></input></td>
				</tr>
				<tr>
					<td class="TextItem">Emergency Phone:</td><td colspan="1"><input class="form-control" size="12" maxlength="12" type="text" name="EmergencyPhone" value="$EmergencyPhone"></td>					</input>&nbsp;&nbsp;&nbsp;
				</tr>
				<tr>
					<td class="TextItem">&nbsp;</td><td colspan="1"><br/><input class="btn btn-success"type="submit" value="Update Address"></td>
				</tr>				
			</table>
		</td>
	
	</tr>


EOREGSTR;

	echo $reg_str;
}
?>



<?php include("Footer.php") ?>

<?php 
}
else
{
echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";

}
?>

</div>
</div>

<script type="text/javascript">

$(document).on('change', '.btn-file :file', function () {
    var input = $(this), numFiles = input.get(0).files ? input.get(0).files.length : 1, label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [
        numFiles,
        label
    ]);
});
$(document).ready(function () {
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'), log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log)
                alert(log);
        }
    });
});
</script>


</body>
</html>
