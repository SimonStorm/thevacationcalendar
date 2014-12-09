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
	if (document.getElementById('Guests')) {
		document.getElementById('Guests').className="NavSelected";
		document.getElementById('GuestsLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}

</SCRIPT>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>

<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Owner" || $_SESSION['Role'] == "Administrator")
	{
?>
<?php ActivityLog('Info', curPageURL(), 'Manage Guests Main',  NULL, NULL); ?>

<?php include("Navigation.php") ?>


<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Manage your visitors</td>
				<tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">
						<?php 
							if ($_SESSION['Role'] == "Administrator")
							{
								echo "Use this screen to add and update visitors of the vacation home. As the administrator, when visitors are added to this page, they will be made available to all Owners. It is a good idea to add visitors who will regularly visit the vacation home but are not Owners. For example, family members or spouses of Owners.<br/><br/>If you enter an email and check the Email Visitor checkbox, an email with the house information and Guest password will be sent to the visitor.";
							}
							else
							{
								echo "Use this screen to add and update visitors of the vacation home. As the owner, when visitors are added to this page, they will only be made available to you. If you are going to add visitors who are regularly going to use the vacation home, you may want to ask the Administrator to add the visitors so all Owners will have them available.<br/><br/>If you enter an email and check the Email Visitor checkbox, an email with the house information and Guest password will be sent to the visitor.";
							}
						?>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="65%" cellpadding="5">
				<tr>

<form action="ManageGuests.php" method="post">

<?php include("GetGuestList.php") ?>

<?php include("InputGuestInfo.php") ?>

				</tr>
			</table>
		</td>
	</tr>
</table>

<?php include("Footer.php") ?>

</form>
<?php
	}
	else
	{
		echo "You do not have access to this page. <a href=\"index.php\">Please click here to log in.</a>";
	}
}
else
{
	echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";
}
?>

</body>
</html>
