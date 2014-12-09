<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar - Contact Us to Learn How to Manage Your Shared Online Beach House Calendar, Ski House Calendar, Mountain Home Calendar, Lake House Calendar.</title>
	<meta name="keywords" content="Online Calendar, Online Vacation Calendar, Vacation Calendar, Calendar, Timeshare, Condo, The Vacation Calendar, Beach House Calendar, Ski House Calendar, Mountain House Calendar, Lake House Calendar, Condo Calendar" />
	<meta name="description" content="Online calendar to manage your vacation home occupancy and availability" />
    <link href="BeachStyle.css" rel="stylesheet" type="text/css" />

</head>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Contact Us',  NULL, NULL); ?>

<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="bottom" align="center">
		<td height="45">
			<table cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td class="Heading">We'd Love to Hear From You</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="90%" cellpadding="5">
				<tr>
					<td align="left" width="65%" valign="top">
						<h2>Thank you very much for visiting TheVacationCalendar.com. If you have any questions about the service, technical issues, or any other suggestions, please feel free to email.</h2>					
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
		<form action="Contact.php" method="post">
			<table align="center">
				<tr>
					<td colspan='2' align='center'>
						<strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Contact Form</font></strong>
					</td>
				</tr>
					<?php
					if (isset($_POST['email'])) 
					{
					echo "<tr><td colspan='2' align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif' color='red'>Thank you for contacting TheVacationCalendar.com</font></td></tr>";
					}
					else
					{
					echo "<tr><td colspan='2' align='center'>&nbsp;</td></tr>";
					}
					?>
				<tr>
					<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">First Name:</font></td>
					<td><input name="fname" type="text" size="30" /></td>
				</tr>
				<tr>
					<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Last Name:</font></td>
					<td><input name="lname" type="text" size="30" /></td>
				</tr>
				<tr>
					<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:</font></td>
					<td><input name="email" type="text" size="30" /></td>
				</tr>
				<tr>
					<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></td>
					<td><input name="subject" type="text" size="30" /></td>
				</tr>
				<tr>
					<td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Questions or Comments:</font></td>
					<td><textarea name="message" cols="28" rows="4"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Send" />&nbsp;&nbsp;&nbsp;<input type="reset" value="Reset" />
					</td>
				</tr>
			</table>
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

		</td>
	</tr>	
</table>
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




