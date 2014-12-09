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
	if (document.getElementById('Admin')) {
		document.getElementById('Admin').className="NavSelected";
		document.getElementById('AdminLink').className="NavSelectedLink";

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
<?php ActivityLog('Info', curPageURL(), 'Administrator Delete Vacations Main Page',  NULL, NULL); ?>


<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Delete Vacations</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use this screen to delete scheduled vacations. This can be used to resolve any conflicts or allow for changes in the case that someone is abusing the website.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center" width="70%" cellpadding="5" border="0">
				<tr>

<form action="EditOwner.php" method="post">

<?php include("GetAllScheduledVacations.php") ?>

</form>

<form action="SaveScheduledOwner.php" method="post">

<?php 

if ($_SESSION['Role'] != 'Administrator')
{
	include("InputOwnerSchedule.php");
}

?>

</form>
				
</table>
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
				</tr>
			</table>
		</td>
	</tr>
</table>


<?php include("Footer.php") ?>

</body>
</html>
