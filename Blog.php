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

<div class="container vacation">	
  <h2 class="featurette-heading">House blog</h2>
  <div style="text-align:left">

<?php include("BlogFunctions.php") ?>
<?php include("BlogInput.php") ?>



<form  action="Blog.php" method="post">

<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="95%" cellpadding="5">
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
</div>
</div>

</body>
</html>
