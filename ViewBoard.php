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
	if (document.getElementById('Board')) {
		document.getElementById('Board').className="NavSelected";
		document.getElementById('BoardLink').className="NavSelectedLink";

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
<?php ActivityLog('Info', curPageURL(), 'View House Baord Main',  NULL, NULL); ?>

<table border="0" align="center" width="100%">
	<tr valign="bottom" align="center" height="45">
		<td colspan="2">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">House bulletin board</td>
				<tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="90%" cellpadding="5">
				<TR ALIGN=LEFT>
					<td>

<?php
$self = $_SERVER['PHP_SELF'];

// This is the add and update logic. The code always updates
if (isset($_POST["Board"]))
{   
	
	$DeleteBoardQuery = "DELETE FROM Board
		WHERE HouseId = ".$_SESSION['HouseId'];
		
	if (!mysql_query( $DeleteBoardQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Board Info',  $DeleteBoardQuery, mysql_error());
		die ("Could not delete boards from the database: <br />". mysql_error());
	}

	$InsertBoardQuery = "INSERT INTO Board
		(HouseId, Board,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) VALUES
		(".$_SESSION['HouseId'].", '".mysql_real_escape_string($_POST["Board"])."', '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
	if (!mysql_query( $InsertBoardQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Insert Board Info',  $InsertBoardQuery, mysql_error());
		die ("Could not insert boards into the database: <br />". mysql_error());
	}

	echo "Congrats you have updated your house board<br/><br/>";
	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ViewBoard.php\"/>";

}

$BoardQuery = "SELECT Board
				FROM Board 
				WHERE HouseId = ".$_SESSION["HouseId"];
		  
$BoardResult = mysql_query( $BoardQuery );
if (!$BoardResult)
{
	ActivityLog('Error', curPageURL(), 'Select Board Info',  $BoardQuery, mysql_error());
	die ("Could not query the database: <br />". mysql_error());
}
while ($BoardRow = mysql_fetch_array($BoardResult, MYSQL_ASSOC)) 
{
	echo stripslashes($BoardRow['Board']);
}
?>

</td>


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
</body>
</html>
