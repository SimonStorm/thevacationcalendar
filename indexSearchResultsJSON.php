<?php session_start(); ?>
<?php header("Cache-control: private"); ?>
<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Public Index Search Rsults Page',  NULL, NULL); ?>

<?php

		if ($_GET['HouseName'] != "")
		{
			$HouseString = 	"WHERE ( HouseName like '%".mysqli_real_escape_string($GLOBALS['link'], $_GET['HouseName'] )."%'".
							" OR Address1 like '%".mysqli_real_escape_string($GLOBALS['link'], $_GET['HouseName'] )."%'".
							" OR Address2 like '%".mysqli_real_escape_string($GLOBALS['link'], $_GET['HouseName'] )."%'".
							" OR City like '%".mysqli_real_escape_string($GLOBALS['link'], $_GET['HouseName'] )."%'".
							" OR State like '%".mysqli_real_escape_string($GLOBALS['link'], $_GET['HouseName'] )."%'".
							" OR ZipCode like '%".mysqli_real_escape_string($GLOBALS['link'], $_GET['HouseName'] )."%' ) ";
		}
		
		$ResultString = "";

		$FindHouseQuery = "SELECT HouseName, Address1, Address2, City, State, ZipCode, HouseId
							FROM House ".$HouseString.
							" AND Status IN ('A', 'P', 'C')";
	
		$FindHouseResult = mysqli_query( $GLOBALS['link'],  $FindHouseQuery );
		if (!$FindHouseResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Houses Main',  $FindHouseQuery, mysqli_error($GLOBALS['link']));
			die ("Could not search the database for houses: <br />". mysqli_error($GLOBALS['link']));
		}
		else
		{
			while ($FindHouseRow = mysqli_fetch_array($FindHouseResult, MYSQL_ASSOC)) 
			{
				$ResultString .= "{\"HouseId\":\"".$FindHouseRow['HouseId']."\",\"HouseName\":\"".$FindHouseRow['HouseName']."\",\"City\":\"".$FindHouseRow['City']."\",\"State\":\"".$FindHouseRow['State']."\",\"HouseVal\":\"".$FindHouseRow['HouseName']." ".$FindHouseRow['Address1']." ".$FindHouseRow['Address2']." ".$FindHouseRow['City']." ".$FindHouseRow['State']." ".$FindHouseRow['ZipCode']."\"},";
			}
			$ResultString = substr($ResultString,0,-1);
		}
?>
{"houses":[
<?php echo $ResultString; ?>
]}
	
<?php include("Footer.php") ?>	
	
	  