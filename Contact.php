<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>The Vacation Calendar - Contact Us to Learn How to Manage Your Shared Online Beach House Calendar, Ski House Calendar, Mountain Home Calendar, Lake House Calendar.</title>
	<meta name="keywords" content="Online Calendar, Online Vacation Calendar, Vacation Calendar, Calendar, Timeshare, Condo, The Vacation Calendar, Beach House Calendar, Ski House Calendar, Mountain House Calendar, Lake House Calendar, Condo Calendar" />
	<meta name="description" content="Online calendar to manage your vacation home occupancy and availability" />
    <link href="BeachStyle.css" rel="stylesheet" type="text/css" />
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
</head>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("NavigationLimited.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Contact Us',  NULL, NULL); ?>

<div class="container vacation">	
  <h2 class="featurette-heading">We'd Love to Hear From You</h2>
  <p class="lead">Thank you very much for visiting TheVacationCalendar.com. If you have any questions about the service, technical issues, or any other suggestions, please feel free to email.</p>				

	<form class="form-signin" role="form" id="inForm" action="Contact.php" method="post">
		<div class="form-group">
		  <h2 class="featurette-heading">Contact Form</h2>
		</div>
		<?php
		if (isset($_POST['email'])) 
		{
		echo "<div class=\"form-group\"><font size='2' face='Verdana, Arial, Helvetica, sans-serif' color='red'>Thank you for contacting TheVacationCalendar.com</font></div>";
		}
		else
		{
		echo "<div class=\"form-group\"></div>";
		}
		?>		
		<div class="form-group">
		  <input type="text" placeholder="First Name" class="form-control" name="fname">
		</div>
		<div class="form-group">
		  <input type="text" placeholder="Last Name" class="form-control" name="lname">
		</div>
		<div class="form-group">
		  <input type="text" placeholder="Email" class="form-control" name="email">
		</div>	
		<div class="form-group">
		  <input type="text" placeholder="Subject" class="form-control" name="subject">
		</div>	
		<div class="form-group">
			<textarea placeholder="Questions or Comments" class="form-control" name="message" cols="28" rows="4"></textarea>
		</div>	
		<div class="form-group">					
		  <button type="submit" name="Submit" class="btn btn-success">Send</button>
		  <button type="reset" name="Reset" class="btn btn-success">Reset</button>
		</div>						  
		<?php
		if (isset($_POST['email'])) 
		{
		// Send the email
		$to      = 'support@thevacationcalendar.com';
		$from    = $_POST['email'];
		$subject = 'Website Email: '.$_POST['subject'];
		$msg     = $_POST['message'].'   Sent from: '.$_POST['fname'].' '.$_POST['lname'];
		
		$mailsend = mail("$to","$subject","$msg","From: $from");
		}
		?>
	</form>
</div>	
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




