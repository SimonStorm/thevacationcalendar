<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
	<link href="css/lightbox.css" rel="stylesheet" />	
</HEAD>
<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>

<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Guest" || $_SESSION['Role'] == "Owner" || ($_SESSION['Role'] == "Administrator" && IsAdminOwner()))
	{
?>

<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Request to Join Main',  NULL, NULL); ?>

<div class="container vacation">	
  <div>
	  <h2 class="featurette-heading">Request to Join Vacation</h2>
 </div>

<?php
$self = $_SERVER['PHP_SELF'];

//echo "<pre>";
//print_r ($_POST);
//echo "</pre>";

if (isset($_POST["vacStartDateJoin"]))
{
	$startdate = explode('/', $_POST["vacStartDateJoin"]);
	$StartMonth = $startdate[0];
	$StartDay = $startdate[1];
	$tempparsestart = explode(' ', $startdate[2]);
	$StartYear = $tempparsestart[0];
	$StartTime = $tempparsestart[1];	
	
	$enddate = explode('/', $_POST["vacEndDateJoin"]);
	$EndMonth = $enddate[0];
	$EndDay = $enddate[1];
	$tempparseend = explode(' ', $enddate[2]);
	$EndYear = $tempparseend[0];
	$EndTime = $tempparseend[1];	
}


// This is the add and update logic. The code always updates
if (isset($StartMonth))
{
	if (!checkdate($StartMonth, $StartDay, $StartYear))
	{
		echo "Invalid start date";
	}
	elseif (!checkdate($EndMonth, $EndDay, $EndYear))
	{
		echo "Invalid end date";
	}
	elseif (date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear)) > date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear)))
	{
		echo "Start date must be before end date";
	}
	else
	{

		$StartQuery = "SELECT C.RealDate, C.DateId
		  FROM Calendar C
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $StartMonth, $StartDay, $StartYear));

		$StartResult = mysqli_query( $GLOBALS['link'],  $StartQuery );
		if (!$StartResult)
		{
			ActivityLog('Error', curPageURL(), 'Select start date range',  $StartQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
		}

		while ($StartRow = mysqli_fetch_array($StartResult, MYSQL_ASSOC))
		{
			$StartRange = $StartRow['DateId'];
			$StartDate = $StartRow['RealDate'];
		}

		if (strtotime($StartDate.' '.$StartTime) < strtotime($_POST["InitialStartRangeJoin"]))
		{
			echo "Start date is outside this vacation".$StartDate.$_POST["InitialStartRangeJoin"];
		}
		else
		{
			$EndQuery = "SELECT C.RealDate, C.DateId
			  FROM Calendar C
			  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $EndMonth, $EndDay, $EndYear));

			$EndResult = mysqli_query( $GLOBALS['link'],  $EndQuery );
			if (!$EndResult)
			{
				ActivityLog('Error', curPageURL(), 'Select end date range',  $EndQuery, mysqli_error($GLOBALS['link']));
				die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
			}

			while ($EndRow = mysqli_fetch_array($EndResult, MYSQL_ASSOC))
			{
				$EndRange = $EndRow['DateId'];
				$EndDate = $EndRow['RealDate'];
			}

			if (false/* need to fix this todo strtotime($EndDate.' '.$EndTime.'') <> strtotime($_POST["InitialEndRangeJoin"])*/)
			{
				echo "End date is outside this vacation".$EndDate.' '.$EndTime.'-'.$_POST["InitialEndRangeJoin"];
			}
			else
			{
				$df_src = 'Y-m-d';
				$df_des = 'n/j/Y';

				$StartDate = dates_interconv( $df_src, $df_des, $StartDate);
				$EndDate = dates_interconv( $df_src, $df_des, $EndDate);

				$OwnerQuery = "SELECT first_name, last_name, email
					FROM user U, Vacations V
					where V.OwnerId = U.user_id
					and V.VacationId = ".$_POST['VacationIdJoin'];

				$OwnerResult = mysqli_query( $GLOBALS['link'],  $OwnerQuery );
				if (!$OwnerResult)
				{
					ActivityLog('Error', curPageURL(), 'Select owner info',  $OwnerQuery, mysqli_error($GLOBALS['link']));
					die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
				}

				while ($OwnerRow = mysqli_fetch_array($OwnerResult, MYSQL_ASSOC))
				{
					$OwnerFirstName = $OwnerRow['first_name'];
					$OwnerLastName = $OwnerRow['last_name'];
					$OwnerEmail = $OwnerRow['email'];
				}

				if (isset($_POST['RequestEmail']))
				{
					$GuestEmail = $_POST['RequestEmail'];
				}
				else
				{
					$GuestEmail = "Unknown Email";
				}
				
				if (isset($_POST['RequestName']))
				{
					$GuestName = $_POST['RequestName'];
				}
				else
				{
					$GuestName = "Unknown Name";
				}
				

				$mail_body = <<< EOMAILBODY
				$OwnerFirstName $OwnerLastName,

				$GuestName has requested to join your vacation from $StartDate to $EndDate
				
				They can be reached at the following email address:
				
				$GuestEmail
EOMAILBODY;
				mail ($OwnerEmail, 'The Vacation Calendar Vacation Request', $mail_body, 'From: noreply@TheVacationCalendar.com');

				$mail_body_confirm = <<< EOMAILBODY
				$GuestName

				You have requested to join $OwnerFirstName $OwnerLastName's vacation from $StartDate to $EndDate
				
EOMAILBODY;

				mail ($GuestEmail, 'The Vacation Calendar Vacation Request Confirmation', $mail_body_confirm, 'From: noreply@TheVacationCalendar.com');

				echo "Congrats, an email has been sent to ".$OwnerFirstName." ".$OwnerLastName.". A confirmation email has been sent to you as well.";
				echo "<meta http-equiv=\"Refresh\" content=\"2; url=Calendar.php\"/>";
			}
		}
	}
}
?>

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
</div>
</body>
</html>
