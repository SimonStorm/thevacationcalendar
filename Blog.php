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
	if (document.getElementById('Blog')) {
		document.getElementById('Blog').className="NavSelected";
		document.getElementById('BlogLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}

</SCRIPT>

<?php if (isset($_SESSION['Role']))
{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Blog Main Page',  NULL, NULL); ?>


<?php include("BlogFunctions.php") ?>
<?php include("BlogInput.php") ?>

<form action="Blog.php" method="post">

<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">House blog</td>
				<tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="65%" cellpadding="5">
				<tr align="center">
					<td align="left">
						&nbsp;&nbsp;&nbsp;<a href="Blog.php?Request=Add">Add A New Blog</a>
					</td>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>				

<?php
if (isset($_GET['Request']))
{
	if ($_GET['Request'] == 'Add')
	{
		include("BlogAdd.php");
	}
	elseif ($_GET['Request'] == 'Delete')
	{
		include("BlogDelete.php");
	}
	elseif ($_GET['Request'] == 'Comment')
	{
		include("BlogComment.php");
	}
	else 
	{
		include("BlogRead.php");
	}
}
else 
{
	include("BlogViewAll.php");
}
?>

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
echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";

}
?>

</form>


</body>
</html>
