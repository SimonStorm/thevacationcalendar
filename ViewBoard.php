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
	<link href="css/lightbox.css" rel="stylesheet" />
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

<div class="container vacation">	
  <h2 class="featurette-heading">House bulletin board</h2>
  <div style="text-align:left">

<?php
$self = $_SERVER['PHP_SELF'];

// This is the add and update logic. The code always updates
if (isset($_POST["Board"]))
{   
	
	$DeleteBoardQuery = "DELETE FROM Board
		WHERE HouseId = ".$_SESSION['HouseId'];
		
	if (!mysqli_query( $GLOBALS['link'],  $DeleteBoardQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Board Info',  $DeleteBoardQuery, mysqli_error($GLOBALS['link']));
		die ("Could not delete boards from the database: <br />". mysqli_error($GLOBALS['link']));
	}

	$InsertBoardQuery = "INSERT INTO Board
		(HouseId, Board,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) VALUES
		(".$_SESSION['HouseId'].", '".mysqli_real_escape_string($GLOBALS['link'], $_POST["Board"])."', '".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
	if (!mysqli_query( $GLOBALS['link'],  $InsertBoardQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Insert Board Info',  $InsertBoardQuery, mysqli_error($GLOBALS['link']));
		die ("Could not insert boards into the database: <br />". mysqli_error($GLOBALS['link']));
	}

	echo "Congrats you have updated your house board<br/><br/>";
	echo "<meta http-equiv=\"Refresh\" content=\"1; url=ViewBoard.php\"/>";

}

$BoardQuery = "SELECT Board
				FROM Board 
				WHERE HouseId = ".$_SESSION["HouseId"];
		  
$BoardResult = mysqli_query( $GLOBALS['link'],  $BoardQuery );
if (!$BoardResult)
{
	ActivityLog('Error', curPageURL(), 'Select Board Info',  $BoardQuery, mysqli_error($GLOBALS['link']));
	die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
}
while ($BoardRow = mysqli_fetch_array($BoardResult, MYSQL_ASSOC)) 
{
	echo stripslashes($BoardRow['Board']);
}
?>

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
	</div>
</div>
</body>
</html>
