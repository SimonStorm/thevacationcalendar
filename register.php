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

<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4"><H1>Register</H1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center" width="40%">
				<TR>
					<td align="center">

<?php

/*****************************************************
 * New user registration page.  There are links to   *
 * this page from the header on every other page for *
 * logged-out and logged-in users.  This may be a    *
 * design flaw however; it's entirely possible that  *
 * we may want to show this page only to logged-out  *
 * visitors.                                         *
 *****************************************************/

require_once('register_funcs.inc');

if (isset($_POST['submit']))
{
	if ($_POST['submit'] == 'Mail confirmation') 
	{
		$feedback = user_register();
		// In every case, successful or not, there will be feedback
		$feedback_str = "<P class=\"errormess\">$feedback</P>";
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$user_name = $_POST['user_name'];
		$email = $_POST['email'];
		echo "<meta http-equiv=\"Refresh\" content=\"1; url=index.php\"/>";
	}
} 
else 
{
  // Show form for the first time
	$feedback_str = '';
	$first_name = '';
	$last_name = '';
	$user_name = '';
	$email = '';
}


// ----------------
// DISPLAY THE FORM
// ----------------

// Superglobals don't work with heredoc
$php_self = $_SERVER['PHP_SELF'];

$reg_str = <<< EOREGSTR
<FORM ACTION="$php_self" METHOD="POST">
<TABLE BORDER=0 CELLPADDING=5 WIDTH=100%>
	<TR ALIGN=CENTER>
		<TD VALIGN=TOP COLSPAN=2 CLASS=TextItem>
			Fill out this form and a confirmation email will be sent to you.<BR><BR>Once you click on the link in the email your account will be confirmed and you can begin to see the vacation schedule.
		</TD>
	</TR>
	<TR ALIGN=CENTER>
		<TD VALIGN=TOP COLSPAN=2 CLASS=AuthNotice>
			$feedback_str
		</TD>
	</TR>
	<TR>
		<TD CLASS=TextItem>
			First Name:
		</TD>
		<TD>
			<INPUT TYPE="TEXT" NAME="first_name" VALUE="$first_name" SIZE="20" MAXLENGTH="25">
		</TD>
	</TR>
	<TR>
		<TD CLASS=TextItem>
			Last Name:
		</TD>
		<TD>
			<INPUT TYPE="TEXT" NAME="last_name" VALUE="$last_name" SIZE="20" MAXLENGTH="25">
		</TD>
	</TR>
	<TR>
		<TD CLASS=TextItem>
			User Name:
		</TD>
		<TD>
			<INPUT TYPE="TEXT" NAME="user_name" VALUE="$user_name" SIZE="20" MAXLENGTH="10">
		</TD>
	</TR>
	<TR>
		<TD CLASS=TextItem>
			Password:
		</TD>
		<TD CLASS=TextItem>
			<INPUT TYPE="password" NAME="password2" VALUE="" SIZE="20" MAXLENGTH="25">
		</TD>
	</TR>
	<TR>
		<TD CLASS=TextItem>
			Password Again:
		</TD>
		<TD CLASS=TextItem>
			<INPUT TYPE="password" NAME="password1" VALUE="" SIZE="20" MAXLENGTH="25">
		</TD>
	</TR>
	<TR>
		<TD CLASS=TextItem>
			Email:
		</TD>
		<TD CLASS=TextItem>
			<INPUT TYPE="TEXT" NAME="email" VALUE="$email" SIZE="20" MAXLENGTH="50">
		</TD>
	</TR>
	<TR ALIGN=CENTER>
		<TD COLSPAN=2>
			<input type="submit" name="submit" value="Mail confirmation">
		</TD>
	</TR>
</TABLE>
</FORM>
EOREGSTR;
echo $reg_str;

?>
				</tr>
			</table>
		</td>
	</tr>
</table>



<?php include("Footer.php") ?>

</form>

</body>
</html>
