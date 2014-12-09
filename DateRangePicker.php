<?php ActivityLog('Info', curPageURL(), 'Date Range Picker Include',  NULL, NULL); ?>
<?php
//This section allows a user to enter dates

if(isset($_POST["StartDay"]))
{
		$StartDay = $_POST["StartDay"];
		$StartMonth = $_POST["StartMonth"];
		$StartYear = $_POST["StartYear"];
		$EndDay = $_POST["EndDay"];
		$EndMonth = $_POST["EndMonth"];
		$EndYear = $_POST["EndYear"];
	
		$OnPage = '';
}
elseif (isset($_GET["StartDay"]))
{
	$StartDay = $_GET["StartDay"];
	$StartMonth = $_GET["StartMonth"];
	$StartYear = $_GET["StartYear"];
	$EndDay = $_GET["StartDay"];
	$EndMonth = $_GET["StartMonth"];
	$EndYear = $_GET["StartYear"];

		$OnPage = '';
}
elseif (!isset($StartMonth))
{

	$query = "SELECT C.Day,
				C.Month,
				C.Year
			  FROM Calendar C
			  WHERE DATE_FORMAT(C.RealDate, '%d-%m-%Y') = DATE_FORMAT(now(), '%d-%m-%Y')";

	$CalResult = mysql_query( $query );
	if (!$CalResult)
	{
		ActivityLog('Error', curPageURL(), 'Select Day from Calendar',  $query, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

	while ($row = mysql_fetch_array($CalResult, MYSQL_ASSOC))
	{
		$StartDay = $row['Day'];
		$StartMonth = $row['Month'];
		$StartYear = $row['Year'];
	}

	$query = "SELECT C.Day,
				C.Month,
				C.Year
			  FROM Calendar C
			  WHERE DATE_FORMAT(C.RealDate, '%d-%m-%Y') = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 7 DAY), '%d-%m-%Y')";
 
	$CalResult = mysql_query( $query );
	if (!$CalResult)
	{
		ActivityLog('Error', curPageURL(), 'Select Day from Calendar',  $query, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}

	while ($row = mysql_fetch_array($CalResult, MYSQL_ASSOC))
	{
		$EndDay = $row['Day'];
		$EndMonth = $row['Month'];
		$EndYear = $row['Year'];
	}
	
	$OnPage = '';

}
else
{
	$OnPage ="ViewVacation.php";

}
?>


<td align="center" colspan="4" class="TextItem">  <br/><br/>

    Date Range: 
    <select name="StartMonth">
   <?php
		$Month = 1;
		while ($Month < 13) 
		{   	
       		if ($Month == $StartMonth)
       		{
       			echo "<option selected=\"selected\" value=\"".$Month."\">".$Month."</option>";
       		}
       		else
       		{
       			echo "<option value=\"".$Month."\">".$Month."</option>";
       		}
    		$Month++;
    	}
	?>
  </select>
  &nbsp;/&nbsp;
  <select name="StartDay">
   <?php
		$Day = 1;
		while ($Day <= 31) 
		{   	
       		if ($Day == $StartDay)
       		{
       			echo "<option selected=\"selected\" value=\"".$Day."\">".$Day."</option>";
       		}
       		else
       		{
       			echo "<option value=\"".$Day."\">".$Day."</option>";
       		}
    		$Day++;
    	}
	?>
  </select>
  &nbsp;/&nbsp;
  <select name="StartYear">
   <?php
		$Year = 2007;
		while ($Year < 2018) 
		{   	
       		if ($Year == $StartYear)
       		{
       			echo "<option selected=\"selected\" value=\"".$Year."\">".$Year."</option>";
       		}
       		else
       		{
       			echo "<option value=\"".$Year."\">".$Year."</option>";
       		}
    		$Year++;
    	}
	?>
  </select>

    &nbsp;&nbsp; To: &nbsp;&nbsp;
    <select name="EndMonth">
   <?php
		$Month = 1;
		while ($Month < 13) 
		{   	
       		if ($Month == $EndMonth)
       		{
       			echo "<option selected=\"selected\" value=\"".$Month."\">".$Month."</option>";
       		}
       		else
       		{
       			echo "<option value=\"".$Month."\">".$Month."</option>";
       		}
    		$Month++;
    	}
	?>
  </select>
  &nbsp;/&nbsp;
  <select name="EndDay">
   <?php
		$Day = 1;
		while ($Day <= 31) 
		{   	
       		if ($Day == $EndDay)
       		{
       			echo "<option selected=\"selected\" value=\"".$Day."\">".$Day."</option>";
       		}
       		else
       		{
       			echo "<option value=\"".$Day."\">".$Day."</option>";
       		}
    		$Day++;
    	}
	?>
  </select>
  &nbsp;/&nbsp;
  <select name="EndYear">
   <?php
		$Year = 2007;
		while ($Year < 2018) 
		{   	
       		if ($Year == $EndYear)
       		{
       			echo "<option selected=\"selected\" value=\"".$Year."\">".$Year."</option>";
       		}
       		else
       		{
       			echo "<option value=\"".$Year."\">".$Year."</option>";
       		}
    		$Year++;
    	}
	?>
  </select>
  <?php
	if ($OnPage == "ViewVacation.php")
	{
		echo "<br /><br /><input type=\"submit\" value=\"Request to Join\" /><br />";
	}
	else
	{
		if (!isset($_GET["Change"]))
		{
//			echo "<br /><br /><input type=\"submit\" value=\"Get Dates\" /><br />";
		}
		elseif ($_GET["Change"] == 'Update')
		{
		
		}
		
	}
  ?>
</td>