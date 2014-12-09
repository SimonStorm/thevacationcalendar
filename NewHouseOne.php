<?php session_start(); ?>
<?php header("Cache-control: private"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar - Signup for a vacation home calendar. The easy to use online calendar will help you manage when your vacation home is vacant and when it is occupied.</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">


<script type="text/javascript">

function Validate(inForm) {

    var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

	if(inForm.HousePass.value == '' || inForm.HousePass.value == null || inForm.HouseConfirm.value == '' || inForm.HouseConfirm.value == null)
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
	  for (var i = 0; i < inForm.HouseName.value.length; i++) {
		if (iChars.indexOf(inForm.HouseName.value.charAt(i)) != -1) {
		alert ("Your housename has special characters. \nPlease only use numbers and letters.\n Please remove them and try again.");
		return false;
		}
	  }
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

</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'New House Setup Page 1',  NULL, NULL); ?>


<form enctype="multipart/form-data" id="inForm" action="NewHouseTwo.php" method="post">
<table border="0" align="center" width="55%">
	<tr align="center">
		<td colspan="4"><h1>Create your Vacation House</h1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" cellpadding="5" width="100%">
				<tr>
					<td colspan="4"><h3>House Details</h3></td>
				</tr>
				<tr>
					<td class="TextItem">House Name*:</td><td colspan="1"><input maxlength="40" type="text" name="HouseName"></input>
				</tr>
				<tr>
					<td class="TextItem">Guest Password*:</td><td colspan="1"><input maxlength="40" type="password" name="HousePass"></input>
				</tr>
				<tr>
					<td class="TextItem">Guest Password (confirm)*:</td><td colspan="1"><input maxlength="40" type="password" name="HouseConfirm"></input>
				</tr>
				<tr>
					<td class="TextItem">Address Line 1:</td><td colspan="1"><input maxlength="40" type="text" name="Address1"></input>
				</tr>
				<tr>
					<td class="TextItem">Address Line 2:</td><td colspan="1"><input maxlength="40" type="text" name="Address2"></input>
				</tr>
				<tr>
					<td class="TextItem">City:</td><td colspan="1"><input maxlength="40" type="text" name="City"></input>
				</tr>
				<tr>
					<td class="TextItem">State:</td><td colspan="1"><input size="2" maxlength="2" type="text" name="State"></input>
				</tr>
				<tr>
					<td class="TextItem">Zip Code:</td><td colspan="1"><input size="5" maxlength="5" type="text" name="ZipCode"></input>
				</tr>
				<tr>
					<td class="TextItem">Home Phone:</td><td colspan="1"><input size="12" maxlength="12" type="text" name="HomePhone"></input>
				</tr>
				<tr>
					<td class="TextItem">Fax:</td><td colspan="1"><input size="12" maxlength="12" type="text" name="Fax"></input>
				</tr>
				<tr>
					<td class="TextItem">Emergency Phone:</td><td colspan="1"><input size="12" maxlength="12" type="text" name="EmergencyPhone"></input>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" cellpadding="5" width="100%">
				<tr>
					<td colspan="4"><h3>Referral Info</h3></td>
				</tr>
				<tr>
					<td colspan="4" class="Instructions">Please provide the PayPal account of the person that referred you to TheVacationCalendar.com. They will receive $5 via PayPal after this account remains open beyond the initial free trial period. Please note that the referral PayPal account cannot be the same as the account used to activate this house. Additionally, please note that standard PayPal service charges will be applied to the the $5.</td>
				</tr>
				<tr>
					<td class="TextItem">PayPal Account of Referrer:</td><td colspan="1"><input maxlength="40" type="text" name="ReferredBy"></input>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" cellpadding="5" width="100%">
				<tr>
					<td colspan="4"><h3>House Picture</h3></td>
				</tr>
				<tr>
					<td class="TextItem">Add a picture of your vacation home:</td><td colspan="1"><!-- MAX_FILE_SIZE must precede the file input field -->
				    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><input size="20" maxlength="2" type="file" name="HousePicture"></input>
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

<?php include("Footer.php") ?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7019638-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
