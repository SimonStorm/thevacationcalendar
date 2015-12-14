<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>The Vacation Calendar</title>
    <LINK href="css/BeachStyle.css" rel="stylesheet" type="text/css">
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
	<link href="css/jquery-ui.min.css" rel="stylesheet" />	
	<link href="css/lightbox.css" rel="stylesheet" />	
    <script src="js/jquery.js"></script>	
	<script src="js/jquery-ui.min.js"></script>		
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

    $(document).ready(function () {
			$( ".admindeletelink" ).click(function( event ){
				event.preventDefault();
				$( "#confirmModal" ).modal('show');
				$( "#vacationtodelete" ).val($(this).attr('href'));				
			} );	
	
			$( "#deleteVacationButton" ).click(function( event ){
			    //alert($( "#vacationtodelete" ).val());
				window.location=$( "#vacationtodelete" ).val();
				//$( "#submittype" ).val('deletesubmit');
				//$( "#vacationform" ).submit();
			} );
	} );

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

<div class="container vacation">	
  <div>
	  <h2 class="featurette-heading">Delete Vacations</h2>
 </div>
<table border="0" align="center" width="100%">
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
</div>
<div id="confirmModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
		  <div class="modal-body">
			Are you sure you want to delete this vacation?
			<input type="hidden" id="vacationtodelete" name="vacationtodelete" value="" />
		  </div>
		  <div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-primary" id="deleteVacationButton">Delete</button>
			<button type="button" data-dismiss="modal" class="btn">Cancel</button>
		  </div>
	</div>
  </div>
</div>	

</body>
</html>
