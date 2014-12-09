<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">
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

<?php
$self = $_SERVER['PHP_SELF'];

//echo "<pre>";
//print_r ($_POST);
//echo "</pre>";


// This is the add and update logic. The code always updates
if (isset($_POST["StartMonth"]))
{
	if (!checkdate($_POST["StartMonth"], $_POST["StartDay"], $_POST["StartYear"]))
	{
		echo "Invalid start date";
	}
	elseif (!checkdate($_POST["EndMonth"], $_POST["EndDay"], $_POST["EndYear"]))
	{
		echo "Invalid end date";
	}
	elseif (date("Ymd", mktime(0, 0, 0, $_POST["StartMonth"], $_POST["StartDay"], $_POST["StartYear"])) > date("Ymd", mktime(0, 0, 0, $_POST["EndMonth"], $_POST["EndDay"], $_POST["EndYear"])))
	{
		echo "Start date must be before end date";
	}
	else
	{

		$StartQuery = "SELECT C.RealDate, C.DateId
		  FROM Calendar C
		  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $_POST["StartMonth"], $_POST["StartDay"], $_POST["StartYear"]));

		$StartResult = mysql_query( $StartQuery );
		if (!$StartResult)
		{
			ActivityLog('Error', curPageURL(), 'Select start date range',  $StartQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}

		while ($StartRow = mysql_fetch_array($StartResult, MYSQL_ASSOC))
		{
			$StartRange = $StartRow['DateId'];
			$StartDate = $StartRow['RealDate'];
		}

		if ($StartRange < $_POST["StartRange"])
		{
			echo "Start date is outside this vacation";
		}
		else
		{
			$EndQuery = "SELECT C.RealDate, C.DateId
			  FROM Calendar C
			  WHERE DATE_FORMAT(C.RealDate, '%Y%m%d') = ".date("Ymd", mktime(0, 0, 0, $_POST["EndMonth"], $_POST["EndDay"], $_POST["EndYear"]));

			$EndResult = mysql_query( $EndQuery );
			if (!$EndResult)
			{
				ActivityLog('Error', curPageURL(), 'Select end date range',  $EndQuery, mysql_error());
				die ("Could not query the database: <br />". mysql_error());
			}

			while ($EndRow = mysql_fetch_array($EndResult, MYSQL_ASSOC))
			{
				$EndRange = $EndRow['DateId'];
				$EndDate = $EndRow['RealDate'];
			}

			if ($EndRange > $_POST["EndRange"])
			{
				echo "End date is outside this vacation";
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
					and V.VacationId = ".$_POST['VacationId'];

				$OwnerResult = mysql_query( $OwnerQuery );
				if (!$OwnerResult)
				{
					ActivityLog('Error', curPageURL(), 'Select owner info',  $OwnerQuery, mysql_error());
					die ("Could not query the database: <br />". mysql_error());
				}

				while ($OwnerRow = mysql_fetch_array($OwnerResult, MYSQL_ASSOC))
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

</body>
</html>
