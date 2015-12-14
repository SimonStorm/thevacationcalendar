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
</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Change Password',  NULL, NULL); ?>

<div class="container vacation">	

  <h2 class="featurette-heading">Change your password</h2>

<table border="0" align="center" width="65%">
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
			<INPUT class="form-control" TYPE="TEXT" NAME="old_password" VALUE="" SIZE="10" MAXLENGTH="15">
		</td>
	</tr>
	<TR ALIGN=CENTER>
		<TD CLASS=TextItem>
			New Password:
		</td>
		<TD CLASS=TextItem>
			<INPUT class="form-control" TYPE="password" NAME="new_password1" VALUE="" SIZE="10" MAXLENGTH="15">
		</td>
	</tr>
	<TR ALIGN=CENTER>
		<TD CLASS=TextItem>
			New Password Again:
		</td>
		<TD CLASS=TextItem>
			<INPUT class="form-control"  TYPE="password" NAME="new_password2" VALUE="" SIZE="10" MAXLENGTH="15">
		</td>
	</tr>
	<TR ALIGN=CENTER>
		<TD CLASS=TextItem>
			&nbsp;
		</td>	
		<TD CLASS=TextItem >
			<INPUT class="btn btn-success" TYPE="SUBMIT" NAME="submit" VALUE="Change my password">
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

</div>
</body>
</html>
