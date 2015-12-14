<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">		
	<title>The Vacation Calendar - Reset your password</title>
    <LINK href="css/BeachStyle.css" rel="stylesheet" type="text/css">
	
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

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
<?php include("NavigationLimited.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Forgot Password',  NULL, NULL); ?>


<div class="container vacation">	

  <h2 class="featurette-heading">Request new password</h2>

<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center" width="35%">
				<tr>
					<td align="center">

<?php
if (isset($_GET['HouseId']))
{
	$SelectedHouse = $_GET['HouseId'];
}
else
{
	$SelectedHouse = $_POST['HouseId'];
}

$FindHouseQuery = "SELECT HouseName
					FROM House 
					WHERE HouseId = ".$SelectedHouse;


$FindHouseResult = mysqli_query( $GLOBALS['link'],  $FindHouseQuery );
if (!$FindHouseResult)
{
    ActivityLog('Error', curPageURL(), 'Select House Name',  $query, mysqli_error($GLOBALS['link']));
	die ("Could not search the database for selected houses: <br />". mysqli_error($GLOBALS['link']));
}
else
{
	while ($FindHouseRow = mysqli_fetch_array($FindHouseResult, MYSQL_ASSOC)) 
	{
		$DisplayHouseString = $FindHouseRow['HouseName'];
	}
}



/******************************************
* This file displays the forgot-password  *
* form.  It submits to itself, mails a    *
* temporary password, and then redirects  *
* to login.                               *
******************************************/

if (isset($_POST['command']) && isset($_POST['email'])) 
{
	if ($_POST['command'] == 'forgot' && strlen($_POST['email'] <= 50)) {
	  // Handle submission.  This is a one-time only form
	  // so there will be no problems with handling errors.

	  $as_email = addslashes($_POST['email']);
	  $query = "select user_id from user where email = '$as_email' and HouseId = $SelectedHouse";

			  
//echo '<br/><br/>';			  
//echo $query;
//echo '<br/><br/>';			  

	  $result = mysqli_query( $GLOBALS['link'], $query);
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select User Name',  $query, mysqli_error($GLOBALS['link']));
			die ("Could not search the database for user name: <br />". mysqli_error($GLOBALS['link']));
		}	  
	  $is_user = mysqli_num_rows($result);
	
	  if ($is_user == 1) {
		// Generate a random password
		$alphanum = array('a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','q','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','2','3','4','5','6','7','8','9');
		$chars = sizeof($alphanum);
		$a = time();
		$password = "";
		mt_srand($a);
		for ($i=0; $i < 6; $i++) {
		  $randnum = intval(mt_rand(0,56));
		  $password = $password.$alphanum[$randnum];
		}
		// One-way encrypt it
		$crypt_pass = md5($password);
	
		// Put the temp password in the db
		$query = "update user set password = '$crypt_pass',
							Audit_user_name = 'FORGOT',
							Audit_Email = '".$_POST['email']."'
					where email = '$as_email' and HouseId = $SelectedHouse";

		$result = mysqli_query( $GLOBALS['link'], $query);
		if (!$result)
		{
			ActivityLog('Error', curPageURL(), 'Select User Name',  $query, mysqli_error($GLOBALS['link']));
			die ("Could not update user password: <br />". mysqli_error($GLOBALS['link']));
		}	  
		
		$server = $_SERVER['HTTP_HOST'];
	
		// Send the email
		$to      = $_POST['email'];
		$from    = "forgot@TheVacationCalendar.com";
		$subject = "New password";
		$msg     = <<< EOMSG
	You recently requested that we send you a new password for The Vacation Calendar.  Your new password is:
	
				 $password
	
	Please log in at this URL:
	
				 http://$server/index.php
	
	Then go to Manage Profile to change your password:
	
EOMSG;
		$mailsend = mail("$to","$subject","$msg","From: $from");
		// Redirect to login

		echo "A new password has been emailed to you.";
//		echo "<meta http-equiv=\"Refresh\" content=\"1; url=index.php\"/>";
	  } else {
		// The email address isn't good, they lose.
		echo "Email does not exist.";
	  }
	
	}
}

// -----------------------
// Display the form nicely
// -----------------------

// Superglobal arrays don't work in heredoc
$php_self = $_SERVER['PHP_SELF'];

$form_str = <<< EOFORMSTR
<form action="$php_self" method="post">
<TABLE BORDER=0 CELLPADDING=10 WIDTH=100%>
	<TR ALIGN=CENTER>
		<TD VALIGN=TOP COLSPAN=2 CLASS=TextItem>
			Please enter your email address and a new password will be emailed to you.<br/><br/> 
		</td>
	</tr>
	<tr>
		<td COLSPAN=2>
			Vacation Home:  &nbsp; $DisplayHouseString <br/><br/>
		</td>
	</tr>
	<tr>
		<td COLSPAN=2>
			<input class="form-control" placeholder="Email" type="text" name="email">
		</td>
	</tr>
	<TR ALIGN=CENTER>
		<TD COLSPAN=2>
			<input type="hidden" name="command" value="forgot">
			<input type="hidden" name="HouseId" value="$SelectedHouse">
			<br/>
			<input class="btn btn-success" type="submit" value="Send password">
		</td>
	</tr>
</TABLE>
</form>
EOFORMSTR;

echo $form_str;

?>
				</tr>
			</table>
		</td>
	</tr>
</table>



<?php include("Footer.php") ?>

</form>
</div>
</body>
</html>
