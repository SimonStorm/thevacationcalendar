<?php session_start(); ?>
<?php header("Cache-control: private"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>The Vacation Calendar - Signup for a vacation home calendar. The easy to use online calendar will help you manage when your vacation home is vacant and when it is occupied.</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">
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


<script type="text/javascript">

function Validate(inForm) {

    var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

	if(inForm.HousePass.value == '' || inForm.HousePass.value == null || inForm.HouseConfirm.value == '' || inForm.HouseConfirm.value == null)
	{
		alert('Passwords must be populated');
		return false;
	}
	else if(inForm.HouseName.value.length < 3)
	{
		alert('House Name must be at least three characters');
		return false;
	}
	else if(inForm.HousePass.value.length > 0 && (inForm.HousePass.value.length < 8 || inForm.HouseConfirm.value.length < 8 ))
	{
		alert('Password must be at least eight characters');
		return false;
	}
	else if(inForm.HousePass.value != inForm.HouseConfirm.value )
	{
		alert('Passwords must must match');
		return false;
	}
	else
	{
	  for (var i = 0; i < inForm.HouseName.value.length; i++) {
		if (iChars.indexOf(inForm.HouseName.value.charAt(i)) != -1) {
		alert ("Your housename has special characters. \nPlease only use numbers and letters.\n Please remove them and try again.");
		return false;
		}
	  }
	  for (var i = 0; i < inForm.HousePass.value.length; i++) {
		if (iChars.indexOf(inForm.HousePass.value.charAt(i)) != -1) {
		alert ("Your password has special characters. \nPlease only use numbers and letters.\n Please remove them and try again.");
		return false;
		}
	  }
      return true;
	}
}

</SCRIPT>

</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("NavigationLimited.php") ?>
<?php ActivityLog('Info', curPageURL(), 'New House Setup Page 1',  NULL, NULL); ?>

<div class="container vacation">	

<form class="form-signin" role="form" enctype="multipart/form-data" id="inForm" action="NewHouseTwo.php" method="post">
		<h3>Create your Vacation House</h3>
		<div class="form-group">
		  <h4>House Details</h4>
		</div>
		<div class="form-group">
		  <input type="text" placeholder="House Name*" class="form-control" name="HouseName">
		</div>		
		<div class="form-group">
		  <input type="password" placeholder="Guest Password*" class="form-control" name="HousePass">
		</div>	
		<div class="form-group">
		  <input type="password" placeholder="Guest Password (confirm)*" class="form-control" name="HouseConfirm">
		</div>	
		<div class="form-group">
		  <input type="text" placeholder="Address Line 1" class="form-control" name="Address1">
		</div>	
		<div class="form-group">
		  <input type="text" placeholder="Address Line 2" class="form-control" name="Address2">
		</div>	
		<div class="form-group">
		  <input type="text" placeholder="City" class="form-control" name="City">
		</div>		
		<div class="form-group">
		  <input type="text" placeholder="State" class="form-control" name="State">
		</div>	
		<div class="form-group">
		  <input type="text" placeholder="Zip Code" class="form-control" name="ZipCode">
		</div>	
		<div class="form-group">
		  <input type="text" placeholder="Home Phone" class="form-control" name="HomePhone">
		</div>	
		<div class="form-group">
		  <input type="text" placeholder="Fax" class="form-control" name="Fax">
		</div>		
		<div class="form-group">
		  <input type="text" placeholder="Emergency Phone" class="form-control" name="EmergencyPhone">
		</div>	
		<div class="form-group">
		  Referral Info
		</div>	
		<div class="form-group">
		  Please provide the PayPal account of the person that referred you to TheVacationCalendar.com. They will receive $5 via PayPal after this account remains open beyond the initial free trial period. Please note that the referral PayPal account cannot be the same as the account used to activate this house. Additionally, please note that standard PayPal service charges will be applied to the the $5.
		</div>	
		<div class="form-group">
		  <input maxlength="40" type="text" placeholder="PayPal Account of Referrer" class="form-control" name="ReferredBy">
		</div>	
		<div class="form-group">
		  <h4>House Picture</h4>
		</div>	
		<div class="input-group">
			<span class="input-group-btn">
				<span class="btn btn-primary btn-file">
					Browse&hellip; <input type="file" class="form-control" name="HousePicture">
				</span>
			</span>
			<input type="text" class="form-control" readonly placeholder="Add a picture of your vacation home">
			<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
		</div>
		<div class="form-group">					
		  <h4>* Required Field</h4>
	    </div>				
		<div class="form-group">					
		  <button type="submit" name="Submit" class="btn btn-success" onclick="return Validate(this.form);">Next</button>
	    </div>
</form>

</div>

<script type="text/javascript">

$(document).on('change', '.btn-file :file', function () {
    var input = $(this), numFiles = input.get(0).files ? input.get(0).files.length : 1, label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [
        numFiles,
        label
    ]);
});
$(document).ready(function () {
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'), log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log)
                alert(log);
        }
    });
});
</script>

<?php include("Footer.php") ?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7019638-1");
pageTracker._trackPageview();
} catch(err) {}</script>

</body>
</html>
