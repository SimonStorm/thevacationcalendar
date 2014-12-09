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
<?php ActivityLog('Info', curPageURL(), 'Change Password',  NULL, NULL); ?>

<table border="0" align="center" width="65%">
	<tr align="center">
		<td colspan="4"><h1>Change your password</h1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center">
				<tr>
					<td align="center">
<?php

/******************************
 * Change password form page. *
 ******************************/

require_once('emailpass_funcs.inc');
require_once('login_funcs.inc');

if (isset($_POST['submit']))
{
	if ($_POST['submit'] == "Change my password") {
	  $feedback = user_change_password();
	  if ($feedback == 1) {
		$feedback_str = "<P class=\"errormess\">Password changed</P>";
	  } else {
		$feedback_str = "<P class=\"errormess\">$feedback</P>";
	  }
	}
}
else 
{
	$feedback_str = "";
}


// ------------
// DISPLAY FORM
// ------------


// Superglobals don't work with heredoc
$php_self = $_SERVER['PHP_SELF'];

$form_str = <<< EOFORMSTR
<form ACTION="$php_self" METHOD="POST">
<TABLE CELLPADDING=5 CELLSPACING=0 BORDER=0 ALIGN=CENTER>
	<tr>
		<TD COLSPAN=2 CLASS=AuthNotice>
			$feedback_str
		</td>
	</tr>
	<TR ALIGN=CENTER>
		<TD CLASS=TextItem>
			Old password:
		</td>
		<TD CLASS=TextItem>
			<INPUT TYPE="TEXT" NAME="old_password" VALUE="" SIZE="10" MAXLENGTH="15">
		</td>
	</tr>
	<TR ALIGN=CENTER>
		<TD CLASS=TextItem>
			New Password:
		</td>
		<TD CLASS=TextItem>
			<INPUT TYPE="password" NAME="new_password1" VALUE="" SIZE="10" MAXLENGTH="15">
		</td>
	</tr>
	<TR ALIGN=CENTER>
		<TD CLASS=TextItem>
			New Password Again:
		</td>
		<TD CLASS=TextItem>
			<INPUT TYPE="password" NAME="new_password2" VALUE="" SIZE="10" MAXLENGTH="15">
		</td>
	</tr>
	<TR ALIGN=CENTER>
		<TD CLASS=TextItem COLSPAN=2>
			<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Change my password">
		</td>
	</tr>
</TABLE>
</FORM>
EOFORMSTR;

echo $form_str;

?>
				</tr>
			</table>
		</td>
	</tr>
</table>


<?php include("Footer.php") ?>

</body>
</html>
