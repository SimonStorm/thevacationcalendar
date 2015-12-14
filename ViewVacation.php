<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>The Vacation Calendar</title>
    <LINK href="css/BeachStyle.css" rel="stylesheet" type="text/css">
</HEAD>
<body>
<?php if (isset($_SESSION['Role']))
{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'View Vacation Main',  NULL, NULL); ?>

<table border="0" align="center" width="85%">
	<tr align="center">
		<td colspan="4"><h1>View your Vacation</h1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center" width="100%" border="0" cellpadding="5">
				<tr>
<form action="RequestJoin.php" method="post">

<?php include("GetVacationInfo.php") ?>

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
echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";

}
?>


</body>
</html>
