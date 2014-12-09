<?php session_start(); ?>
<?php header("Cache-control: private"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">

</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'New House Setup Page 3',  NULL, NULL); ?>
<?php include("register_funcs.inc") ?>

<?php

$HouseID = $_POST['houseid'];

if (isset($_POST['houseid']))
{
	$feedback = user_register();	
	echo $feedback;
}


$sub_str = 'ERROR';
if (strpos($feedback, $sub_str) === false) 
{
// not found...
$house_form = <<< EOHOUSEFORM

<form id="form_id" action="paypal.php" method="post" >
<table border="0" align="center" width="55%">
	<tr align="center">
		<td colspan="4"><h1>Create your Vacation House</h1>&nbsp;<h2>Page 3</h2></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" cellpadding="5" width="100%">
				<tr>
					<td colspan="4"><h3>Whew! We are almost there. Please complete your registration by signing up for a subscription to TheVacationCalendar.com using our PayPal subscription service.</h3></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" cellpadding="5" width="100%">
				<tr>
					<td colspan="4"><h3>For a short time only, we are offering a free month of service for you to experience the vacation calendar and to tell us what you think. After that we manage your vacation home calendar for $20 a year. You can cancel anytime through the 
					"manage account" screen or directly from your PayPal account.</h3></td>
				</tr>
				<tr>
					<input type="hidden" name="houseid" value=$HouseID></input>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table border="0" align="center" width="55%">
	<tr align="right">
		<td>
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="">
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</td>
	</tr>
</table>
</form>
EOHOUSEFORM;

echo $house_form;

}
else
{
echo "<BR><BR><BR><BR>Please hit the back button and try again ";
}

?>

<?php include("Footer.php") ?>


</body>
</html>
