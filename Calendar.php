<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <link href="BeachStyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	font-family:Arial, Helvetica, sans-serif;
	font-size: 0.75em;
}
img.shade {
	height: 305px;
	width: 510px;
	/* specify the dimension of the image */
	display: block;
	position: absolute;
	z-index: -1;
	/* force the image to show below the content */
	left: 0px;
}
div.shade {
	display: none;
	position:absolute;
	left: 650px;
	top: 225px;
	background-color:#FFFFFF;
	z-index: 10000;
	margin: 10px;
	border: 1px solid #999999;
}
iframe#editor {
	border: 0px;
	height: 295px;
	width: 490px;
}
span.note {
	font-size: 0.75em;
	color: #999999;
}
p, dl {
	margin: 0px;
	padding: 0px;
}
dd {
	margin: 2px;
	padding: 1px;
	border: 1px solid #CCCCCC;
	font-family:Arial, Helvetica, sans-serif;
	background-color: #FFFFFF;
}
dd:hover {
	border: 1px solid #004579;
	background-color: #EAEAEA;
	color: #004579;
	cursor: pointer;
}
.clearer {
	clear:both;
	white-space:nowrap;
	margin: 0px;
	padding: 0px;
}
div#search-container {
	display: none;
}
</style>
</head>
<body onload="init();">



<script type="text/javascript">
// <![CDATA[

function init() 
{
try {
	if (document.getElementById('Calendar')) {
		document.getElementById('Calendar').className="NavSelected";
		document.getElementById('CalendarLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}
// ]]>
</script>



<?php if (isset($_SESSION['Role']))
{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'View Calendar',  NULL, NULL); ?>

<?php

	if(isset($_POST['NoIntro']))
	{
		$NoIntroQuery = "Update user SET Intro = 'N',
							Audit_user_name = '".$_SESSION['user_name']."',
							Audit_Role = '".$_SESSION['Role']."',
							Audit_FirstName = '".$_SESSION['FirstName']."',
							Audit_LastName = '".$_SESSION['LastName']."', 
							Audit_Email = '".$_SESSION['Email']."'
							WHERE user_id = ".$_SESSION['OwnerId'];

		$NoIntroResults = mysql_query( $NoIntroQuery );
		if (!$NoIntroResults)
		{
			ActivityLog('Error', curPageURL(), 'Update User',  $NoIntroQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
	}
?>
<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="bottom" align="center">
		<td height="45">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">Calendar</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<form action="Calendar.php" method="get">

<?php include("CreateCalendar.php") ?>

</form>


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
