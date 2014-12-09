<?php session_start(); ?>
<?php header("Cache-control: private"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar - Online Calendar to manage your vacation home or timeshare occupancy and availability. Beach House Calendar, Ski House Calendar, Mountain Home Calendar, Lake House Calendar.</title>
	<meta name="keywords" content="Online Calendar, Online Vacation Calendar, Vacation Calendar, Calendar, Timeshare, Condo, The Vacation Calendar, Beach House Calendar, Ski House Calendar, Mountain House Calendar, Lake House Calendar, Condo Calendar">
	<meta name="description" content="Online calendar to manage your vacation home occupancy and availability">
    <meta name="verify-v1" content="rv61Na+DJjgmm+bVOlNsyMdcDo7NHUJ9DcQF44WxpgU=" />
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">
</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Public Login Page',  NULL, NULL); ?>

<?php


if (isset($_POST['submit']))
{
	$SelectedHouse = $_POST['SelectedHouse'];
}
else
{
	$SelectedHouse = $_GET['HouseId'];
}

$FindHouseQuery = "SELECT HouseName, Status
					FROM House 
					WHERE HouseId = ".$SelectedHouse;


$FindHouseResult = mysql_query( $FindHouseQuery );
if (!$FindHouseResult)
{
	ActivityLog('Error', curPageURL(), 'Select Houses',  $FindHouseQuery, mysql_error());
	die ("Could not search the database for selected houses: <br />". mysql_error());
}
else
{
	while ($FindHouseRow = mysql_fetch_array($FindHouseResult, MYSQL_ASSOC)) 
	{
		$DisplayHouseString = stripslashes($FindHouseRow['HouseName']);
		$HouseStatus = $FindHouseRow['Status'];
	}
}


if (isset($_SESSION['Role']))
{
		$feedback_str = "<P class=\"errormess\">You are already logged in</P>";
		if ($_SESSION['Role'] == 'Administrator' && WantsIntro())
		{
			echo "<meta http-equiv=\"Refresh\" content=\"1; url=InstructionsAdmin.php\"/>";
		}
		elseif ($_SESSION['Role'] == 'Owner' && WantsIntro())
		{
			echo "<meta http-equiv=\"Refresh\" content=\"1; url=InstructionsOwner.php\"/>";
		}
		elseif ($_SESSION['Role'] == 'Guest' && WantsIntro())
		{
			echo "<meta http-equiv=\"Refresh\" content=\"1; url=InstructionsGuests.php\"/>";
		}
		else
		{
			echo "<meta http-equiv=\"Refresh\" content=\"1; url=Calendar.php\"/>";
		}
}

require_once('login_funcs.inc');

if (isset($_POST['submit']))
{
	if ($_POST['submit'] == 'Login')
	{
	  if ((strlen($_POST['user_name']) <= 25 && strlen($_POST['password'])) || strlen($_POST['guestpass']) <=25) {
		$feedback = user_login();
	  } else {
		$feedback = 'ERROR - Username and password are too long';
	  }
	  if ($feedback == 1) {
		// On successful login, redirect to homepage
		echo "Authentication complete. Allowing access.";
		if ($_SESSION['Role'] == 'Administrator' && WantsIntro())
		{
			echo "<meta http-equiv=\"Refresh\" content=\"1; url=InstructionsAdmin.php\"/>";
		}
		elseif ($_SESSION['Role'] == 'Owner' && WantsIntro())
		{
			echo "<meta http-equiv=\"Refresh\" content=\"1; url=InstructionsOwner.php\"/>";
		}
		elseif ($_SESSION['Role'] == 'Guest' && WantsIntro())
		{
			echo "<meta http-equiv=\"Refresh\" content=\"1; url=InstructionsGuests.php\"/>";
		}
		else
		{
			echo "<meta http-equiv=\"Refresh\" content=\"1; url=Calendar.php\"/>";
		}
		$feedback_str = '';
	  } else {
		$feedback_str = "<P class=\"errormess\">$feedback</P>";
	  }
	}
	else
	{
	  $feedback_str = '';
	}
}
else
{
	$feedback_str = '';
}
?>

<table border="0" align="center" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="bottom" align="center" height="45">
		<td height="45" colspan="4">
			<table cellpadding="0" cellspacing="0" width="95%" border="0">
				<tr>
					<td class="Heading">
						<h1>Welcome to your shared online calendar for your vacation home!!!</h1>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center" width="90%" cellpadding="5" border="0">
				<tr>
					<td align="left" width="65%" valign="top">
						<h2>Organize your vacation home schedule</h2>					
						<ul>
							<li>Spend more time enjoying your getaway home</li>
							<li>Let friends and family see the online calendar so they know when they can visit </li>
							<li>Keep track of when your vacation home is in use</li>
							<li>Share information on the house bulletin board and house blog</li>
						</ul>
					</td>
					<td align="center" valign="top">	
						<a href="http://www.thevacationcalendar.com/NewHouseOne.php"><img src="images/JoinNow.jpg" alt="JoinNow.jpg" width="150" height="100" border="0" align="middle" /></a><br/)<br/>
						<a href="TutorialSignUp.php" target="_new" onclick="window.open(this.href, '','height=960,width=960');return false;"><img src="images/GetStarted.jpg" alt="JoinNow.jpg" width="150" height="83" border="0" align="middle" /></a><br/)<br/>
					</td>
					<td align="center" valign="top" rowspan="4">	
						<table align="center" width="100%" cellpadding="2" class="LoginBox" cellspacing="5">
							<tr>
								<td align="center" colspan="2">
									<a href="http://www.thevacationcalendar.com/Blog/index.php?entry=entry090727-205943"><img src="images/EarnCash.jpg" alt="EarnCash.jpg" width="223" height="95" border="0" align="middle" /></a><br/)<br/>
								</td>
							</tr>
							<tr>
								<td align="left" colspan="2">	
									<h3>Welcome to <?php echo $DisplayHouseString; ?></h3>
								</td>
							</tr>
<?php
$login_form = <<< EOLOGINFORM
							<tr>
								<td align="center" colspan="2">	
									$feedback_str
								</td>
							</tr>
<form action="indexLogin.php" method="post">
<input type="hidden" name="SelectedHouse" value=$SelectedHouse></input>
							<tr>
								<td align="center" colspan="2">	
									If you are a guest of this home, <br/>please enter the password here:
								</td>
							</tr>
							<tr>
								<td class="InfoText" align="center">	
									Guest Password: 
								</td>
								<td align="center">	
									<input type="password" size="20" maxsize="20" name="guestpass">
								</td>
							</tr>
							<tr>
								<td align="center" colspan="2">	
									If you are a member of this home, <br/>please enter your username and password here:
								</td>
							</tr>
							<tr>
								<td class="InfoText" align="center">	
									Member Username: 
								</td>
								<td align="center">	
									<input type="text" size="20" maxsize="20" name="user_name">
								</td>
							</tr>
							<tr>
								<td class="InfoText" align="center">	
									Member Password:
								</td>
								<td align="center">	
									<input type="password" size="20" maxsize="20" name="password">
								</td>
							</tr>
							<tr>
								<td align="center" colspan="2">	
									<input type="submit" name="submit" value="Login">
								</td>
							</tr>						
							<tr>
								<td align="left" colspan="2">	
									<a href="forgot.php?HouseId=$SelectedHouse">Forgot Password</a>
								</td>
							</tr>						
EOLOGINFORM;

  if ($HouseStatus == 'P' || $HouseStatus == 'C')
  {
	echo '<tr><td align="center" colspan="2">	Subscription has not been set up through PayPal or is no longer active. <br/><br/>To sign up or sign up again, please click here:<br/><br/>
	<form id="form_id" action="paypal.php" method="post" ><input type="hidden" name="houseid" value='.$SelectedHouse.'></input>
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"></form></td></tr>';
  }
  else
  {
  	echo $login_form;
  } 
?>
							<tr>
								<td align="right" colspan="2">	
									<a href="index.php">Click here to search again</a>
								</td>
							</tr>						
						</table>			
						<table cellpadding="0" cellspacing="0" width="95%" border="0">
							<tr>
								<td align="center" colspan="2" height=325 valign="bottom">	
									<img src="images/CalendarView.jpg" alt="CalendarView.jpg" width="300" height="300" border="0" align="middle" />
								</td>
							</tr>						
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2" valign="middle">
						<h2>The perfect way to organize all types of vacation homes</h2>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2" valign="top">
						<table>
							<tr>
								<td align="left" valign="top">
									<ul>
										<li>Beach house calendar</li>
										<li>Ski house calendar</li>
										<li>Apartment calendar</li>
										<li>Lake house calendar</li>
										<li>Mountain house calendar</li>
										<li>Condo calendar</li>
									</ul>
								</td>
								<td align="center" valign="top">
									<a href="TutorialAbout.php" target="_new" onclick="window.open(this.href, '','height=960,width=960');return false;"><img src="images/LearnMore.jpg" alt="LearnMore.jpg" width="223" height="95" border="0" align="middle" /></a><br/)<br/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2" valign="top">
						<h2>Helps you manage any type of property arrangement</h2>
						<ul>
							<li>Family homes</li>
							<li>Shared rental properties</li>
							<li>Timeshares</li>
							<li>Personal vacation homes</li>
						</ul>
					</td>
				</tr>				<tr>
					<td align="left" colspan="3" valign="top">	
						<h2>Spend more time enjoying your getaway home</h2>					
						<p>The Vacation Calendar was originally built for my family who has a beach house in North Carolina. They had one individual who was responsible for the
						"official" calendar. Because people did not want to seem greedy, they often only spent a week or two down at the beach house. The result
						was that a beautiful house in the perfect location sometimes was often left unused, even on some of the most glorious summer weekends.<BR><BR>
						</p>					
						<h2>Let friends and family see when they can visit</h2>					
						<p>Now, thanks to The Vacation Calendar, the schedule of who is going to use the beach house is available via the online calendar to not only all of the family members, but friends as well.
						This allows everyone to see that the house is going to be free and people can now feel comfortable offering the house to extended family and friends. 
						Thanks to the ability to identify which rooms people are staying in, it is possible for friends and family to join others at the beach house which is a fantastic
						bonus because our family is definitely a "the more the merrier" family. But don't worry, if you want a nice quite weekend away, a simple click and the vacation
						calendar will show that there are no available rooms.</p>					
						<h2>Keep track of when your vacation home is in use</h2>					
						<p>Even if you do not share your vacation home, it is extremely helpful to have an online calendar to share with your friends and family so they know when you are going to
						be there. The Vacation Calendar lets you specify who is staying in each room of your house, so now those annoying late arrivers will know exactly which room they
						are sleeping in before they even leave the house.</p>					
						<h2>Share information on the house bulletin board and house blog</h2>					
						<p>Do you feel like every time you have a new guest you need to list out all of the instructions for them? How to get to the house, where the spare key can be found, what
						to do with the AC when you leave, etc, etc. Now, with the The Vacation Calendar Bulletin Board, you can direct all of your guests to a single location that has all of these
						details. No longer will you have to search for scraps of paper or old emails that have this valuable information. Also, with the house blog, you can keep your friends
						and family up to date as well as let them add comments and keep you informed about what is going on in your home.</p>					
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr valign="bottom" align="center">
		<td height="5" colspan="4">
			<table cellpadding="0" cellspacing="0" width="80%" border="0">
				<tr>
					<td width="40%" align="left">
					</td>
					<td width="20%" align="center" valign="middle">
						<!-- AddThis Button BEGIN -->
						<script type="text/javascript">addthis_pub  = 'mexstorm';</script>
						<a href="http://www.addthis.com/bookmark.php" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s9.addthis.com/button1-share.gif" width="125" height="16" border="0" alt="" /></a><script type="text/javascript" src="http://s7.addthis.com/js/152/addthis_widget.js"></script>
						<!-- AddThis Button END -->
					</td>
					<td width="40%" align="left" class="AdText">
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
  <p>
    <a href="http://validator.w3.org/check?uri=referer"><img
        src="http://www.w3.org/Icons/valid-xhtml10-blue"
        alt="Valid XHTML 1.0 Transitional" height="31" width="88" border="0" /></a>
  </p>

<?php include("Footer.php") ?>

</form>

 
</body>
</html>
