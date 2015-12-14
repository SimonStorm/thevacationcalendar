<?php session_start(); ?>
<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Build Calendar',  NULL, NULL); ?>

<?php

$self = $_SERVER['PHP_SELF'];
 
if (isset($_GET["start"]))
 {
 	$startdttemp=$_GET["start"];
	$startdt= date('Y-m-d', $startdttemp);
 
  	$enddttemp=$_GET["end"];
	$enddt= date('Y-m-d', $enddttemp);
}
?>

<?php
$VacationResultsTemp = GetVacation($startdt, $enddt);
$ResultString = "[";
while ($VacationRow = mysqli_fetch_assoc($VacationResultsTemp) )
{ 
	if (!IS_NULL($VacationRow['VacationName']))
	{
		if ($_SESSION['Role'] == "Owner" && $VacationRow['OwnerId'] == $_SESSION['OwnerId'])
		{
		
			$ResultString .= '{';
			$ResultString .=  '"title": "'.$VacationRow['VacationName'].'" ,';		
			$ResultString .=  '"id": "'.$VacationRow['VacationId'].'" ,';
			$ResultString .=  '"start": "'.$VacationRow['StartDate'].'",';
			$ResultString .=  '"end": "'.$VacationRow['EndDate'].'",';
			$ResultString .=  '"allDay": false,';
			$ResultString .=  '"color": "#'.$VacationRow['BackGrndColor'].'",';
			$ResultString .=  '"textColor": "#'.$VacationRow['FontColor'].'",';
			$ResultString .=  '"className": "way"';			
			$ResultString .=  '},';		
		}
		elseif ($_SESSION['Role'] == "Administrator" && IsAdminOwner() && $VacationRow['OwnerId'] == $_SESSION['OwnerId'])
		{
			$ResultString .= '{';
			$ResultString .=  '"title": "'.$VacationRow['VacationName'].'" ,';		
			$ResultString .=  '"id": "'.$VacationRow['VacationId'].'" ,';
			$ResultString .=  '"start": "'.$VacationRow['StartDate'].'",';
			$ResultString .=  '"end": "'.$VacationRow['EndDate'].'",';
			$ResultString .=  '"allDay": false,';
			$ResultString .=  '"color": "#'.$VacationRow['BackGrndColor'].'",';
			$ResultString .=  '"textColor": "#'.$VacationRow['FontColor'].'",';
			$ResultString .=  '"className": "way"';			
			$ResultString .=  '},';	
		}
		else 
		{
			$ResultString .= '{';
			$ResultString .=  '"title": "'.$VacationRow['VacationName'].'" ,';		
			$ResultString .=  '"id": "'.$VacationRow['VacationId'].'" ,';
			$ResultString .=  '"start": "'.$VacationRow['StartDate'].'",';
			$ResultString .=  '"end": "'.$VacationRow['EndDate'].'",';
			$ResultString .=  '"allDay": false,';
			$ResultString .=  '"color": "#'.$VacationRow['BackGrndColor'].'",';
			$ResultString .=  '"textColor": "#'.$VacationRow['FontColor'].'",';
			$ResultString .=  '"className": "noway"';			
			$ResultString .=  '},';		
		}

	}

}

$ResultString = substr($ResultString,0,-1);
$ResultString = $ResultString."]";
echo $ResultString;
?>			



