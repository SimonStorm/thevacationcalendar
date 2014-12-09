<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">
</HEAD>
<body onload="init();">



<script type="text/javascript">

function init() 
{
try {
	if (document.getElementById('Users')) {
		document.getElementById('Users').className="NavSelected";
		document.getElementById('UsersLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}


</SCRIPT>


<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Administrator")
	{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php include('register_funcs.inc'); ?>
<?php ActivityLog('Info', curPageURL(), 'User Administration Main',  NULL, NULL); ?>


<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Owner Administration</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this screen to add and update Owners of the vacation home. Owners are individuals who should have the ability to schedule time at the vacation home. For more information about ways to manage the vacation home, please click <a href="Instructions.php#UsersRoles">here</a>.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr>
					<td align="center">

<?php

/**********************************************
* This file displays the change non-sensitive *
* user data form.  It submits to itself, and  *
* displays a message each time you submit.    *
***********************************************/

include_once('login_funcs.inc');

$status_message = "";
$userlist = "";
$JavaString = "";
$user_name = $_SESSION['user_name'];
if (isset($_POST['user_id'])) {

	if ($_POST['submit'] == 'Add new user')
	{
		if ($_POST['access'] == 'Guest' )
		{
			$status_message = user_register();
		}
		else
		{
			$status_message = owner_register();
		}
	}
	else
	{
		$PassReset = user_resend();
		
		if ($PassReset == 'User information has been updated.')
		{
			$query = "UPDATE user
					  SET user_name = '".$_POST['user_name']."',
						first_name = '".$_POST['first_name']."',
						last_name = '".$_POST['last_name']."',
						role = '".$_POST['access']."',
						is_confirmed = ".$_POST['confirmed'].",
						email = '".$_POST['email']."',
						Audit_user_name = '".$_SESSION['user_name']."',
						Audit_Role = '".$_SESSION['Role']."',
						Audit_FirstName = '".$_SESSION['FirstName']."',
						Audit_LastName = '".$_SESSION['LastName']."', 
						Audit_Email = '".$_SESSION['Email']."'
					  WHERE user_id = ".$_POST['user_id']."
					  AND HouseId = ".$_SESSION['HouseId'];
		
			$result = mysql_query($query);
			if (!$result) {
				ActivityLog('Error', curPageURL(), 'Update Owner Administration',  $query, mysql_error());
			  $status_message = 'Problem with user data entry';
			} else {
			  $status_message = 'Successfully edited user data';
			}
		}
		else
		{
			 $status_message = $PassReset;
		}
	}
}
  // Get previously-existing data
$UserQuery = "SELECT u.user_id, u.user_name, u.first_name, u.last_name, u.email, u.is_confirmed, u.role AccessLevel
            FROM user u
            WHERE u.role = 'Owner' AND HouseId = ".$_SESSION['HouseId']."
			ORDER BY u.last_name, u.first_name, u.user_id";

$UserResults = mysql_query( $UserQuery );
if (!$UserResults)
{
	ActivityLog('Error', curPageURL(), 'Select Owner Info for Administration',  $UserQuery, mysql_error());
	die ("Could not get Users from the database: <br />". mysql_error());
}
elseif (mysql_num_rows($UserResults) > 0)
{
	while ($UserResultsRow = mysql_fetch_array($UserResults, MYSQL_ASSOC)) 
	{
		$user_id = $UserResultsRow['user_id'];
		$user_name = $UserResultsRow['user_name'];
		$first_name = $UserResultsRow['first_name'];
		$last_name = $UserResultsRow['last_name'];
		$email = $UserResultsRow['email'];
		$confirmed = $UserResultsRow['is_confirmed'];
		$access = $UserResultsRow['AccessLevel'];
		
		$userlist .= "<option value=\"$user_id\">$first_name $last_name</option>";
		
		$JavaString .= "if(inValue == ".$user_id.") { 
							inForm.email.value = \"".$email."\";
							inForm.user_name.value = \"".$user_name."\";
							inForm.first_name.value = \"".$first_name."\";
							inForm.last_name.value = \"".$last_name."\";
							inForm.access.value = \"".$access."\";
							inForm.user_id.value = \"".$user_id."\"; 
							var radioLength = inForm.confirmed.length;
							for(var i = 0; i < radioLength; i++) {
								inForm.confirmed[i].checked = false;
								if(inForm.confirmed[i].value == ".$confirmed.") {
									inForm.confirmed[i].checked = true;
								}
							}
							}";
									
		$user_id = $UserResultsRow['user_id'];
		$user_name = "";
		$first_name = "";
		$last_name = "";
		$email = "";
		$confirmed = "";
		$access = "";

							
	}
	
//	$SecurityInput = "";

//	$SecurityInput = $SecurityInput."<option value=\"Owner\">Owner</option><option value=\"Guest\">Guest</option>";
}
else
{
//   	$SecurityInput = "";
}

?>

<script type="text/javascript">

function Validate(inForm) {
	
    var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\" :<>?";

    var iNameChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

	var radioLength = inForm.confirmed.length;
	for(var i = 0; i < radioLength; i++) {
		if(inForm.confirmed[i].checked == true) 
		{
			ConfirmVal = inForm.confirmed[i].value;
		}
	}

	if(ConfirmVal == 0 && (inForm.password1.value == '' || inForm.password1.value == null || inForm.password2 == '' || inForm.password2.value == null))
	{
		alert('Passwords must be populated if Confirmed is set to No');
		return false;
	}
	else if(inForm.user_name.value.length < 6)
	{
		alert('Username must be at least six characters');
		return false;
	}
	else if(inForm.password1.value.length > 0 && (inForm.password1.value.length < 8 || inForm.password2.value.length < 8 ))
	{
		alert('Password must be at least eight characters');
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

function ValidatePswd(inForm) {

	if(inForm.password1.value == '' || inForm.password1.value == null || inForm.password2 == '' || inForm.password2.value == null)
	{
		alert('Passwords must be populated for a new user');
		return false;
	}
	else
	{
		return true;
	}
}

function PopulateUser(inValue, inForm) {
	<?php echo $JavaString	?>
}

</SCRIPT>


<?php
  // --------------
  // Construct form
  // --------------

//  site_header('User data edit page');

  $userform_str = <<< EOUSERFORMSTR
<TABLE ALIGN=CENTER WIDTH=40%>
<tr>
  <TD ROWSPAN=10><IMG WIDTH=15 HEIGHT=1 SRC="../images/spacer.gif"></td>
  <TD WIDTH=606></td>
</tr>
<tr>
 <td>

<form NAME=UserForm ACTION="OwnerAdministration.php" METHOD="POST" ONSUBMIT="return Validate(this);">

<TABLE>
	<TR ALIGN=CENTER>
		<TD COLSPAN=2>
			<select SIZE=5 name=Users onclick="PopulateUser(this.value, this.form);">
				$userlist;
			</select>
		</td>
	</tr>
	<tr>
		<TD COLSPAN=2 HEIGHT=25>
			&nbsp;
		</td>
	</tr>
	<tr>
		<TD COLSPAN=2>
			<FONT COLOR="#ff0000">$status_message</FONT>
		</td>
	</tr>
	<tr>
		<td>
			Username:
		</td>
		<td>
			Email:
		</td>
	</tr>
	<tr>
		<td>
			<INPUT TYPE="TEXT" NAME="user_name" SIZE="40">
		</td>
		<td>
			<INPUT TYPE="TEXT" NAME="email" SIZE="40">
		</td>
	</tr>
	<tr>
		<td>
			First Name:
		</td>
		<td>
			Last Name:
		</td>
	</tr>
	<tr>
		<td>
			<INPUT TYPE="TEXT" NAME="first_name" SIZE="40">
		</td>
		<td>
			<INPUT TYPE="TEXT" NAME="last_name" SIZE="40">
		</td>
	</tr>
	<tr>
		<td>
			Password:
		</td>
		<td>
			Password Again:
		</td>
	</tr>
	<tr>
		<td>
			<INPUT TYPE="PASSWORD" NAME="password1" SIZE="40">
		</td>
		<td>
			<INPUT TYPE="PASSWORD" NAME="password2" SIZE="40">
		</td>
	</tr>
	<tr>
		<td>
			Confirmed:
		</td>
		<td>
			Send Email:
		</td>
	</tr>
	<tr>
		<td>
			<INPUT TYPE="RADIO" NAME="confirmed" VALUE="1" CHECKED>Yes <INPUT TYPE="RADIO" NAME="confirmed" VALUE="0">
		</td>
		<td>
			<INPUT TYPE="RADIO" NAME="sendemail" VALUE="1" CHECKED>Yes <INPUT TYPE="RADIO" NAME="sendemail" VALUE="0">No
		</td>
	</tr>
	<INPUT TYPE="HIDDEN" NAME="user_id" SIZE="40">
	<input type="hidden" name="access" value="Owner"></input>
	<tr>
		<TD COLSPAN=3 HEIGHT=25>
			&nbsp;
		</td>
	</tr>
</TABLE>

 </td>
</tr>
</TABLE>
EOUSERFORMSTR;

  echo $userform_str;

?>
<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Edit user data">
<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Add new user" onclick="return ValidatePswd(this.form);">
</FORM>

				</tr>
			</table>
		</td>
	</tr>
</table>



<?php include("Footer.php") ?>


<?php 
	}
	else
	{
		echo "You do not have access to this page. <a href=\"index.php\">Please click here to log in.</a>. <a href=\"index.php\">Please click here to log in.</a> <a href=\"index.php\">Please click here to log in</a> ";
	}
}
else
{
	echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";
}
?>
</body>
</html>
