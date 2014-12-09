<?php session_start(); ?>
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
<?php ActivityLog('Info', curPageURL(), 'User Confirmation Page',  NULL, NULL); ?>

<table border="0" align="center" width="65%">
	<tr align="center">
		<td colspan="4"><h1>Confirmation</h1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center">
				<tr>
					<td align="center">
<?php

/*****************************************************
 * New user confirmation page.  Should only get here *
 * from an email link.                               *
 *****************************************************/


require_once('register_funcs.inc');


//site_header('Account Confirmation');

if (isset($_GET['hash']) && isset($_GET['email']))
{
	if ($_GET['hash'] && $_GET['email']) {
	  $worked = user_confirm();
	} else {
	  $feedback_str = "<P class=\"errormess\">ERROR - Bad link</P>";
	}
}
else
{
  $feedback_str = "<P class=\"errormess\">ERROR - Bad link</P>";
}

if ($worked != 1) {
  $feedback_str = '<P class="errormess">Something went wrong.  Send email to support@TheVacationCalendar.com for help.  If you clicked through to this page directly, please go to login.php instead.</P>';
} else {
   $feedback_str = '<P class="big">You are now confirmed. <A HREF="index.php">Log in</A> to start browsing the site</P>';
}

$page = <<< EOPAGE
<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 ALIGN=CENTER>
	<tr>
		<TD COLSPAN=2 CLASS=AuthNotice>
			$feedback_str
		</td>
	</tr>
</TABLE>
EOPAGE;

echo $page;

?>

<?php include("Footer.php") ?>
</body>
</html>
