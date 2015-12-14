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

<body>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Schedule Vacations Main',  NULL, NULL); ?>

<?php if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "Owner" || ($_SESSION['Role'] == "Administrator" && IsAdminOwner()))
	{
?>

<?php include("Navigation.php") ?>
<div class="container vacation">	
  <div>
	  <h2 class="featurette-heading">Manage your vacations</h2>
 </div>
<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
					<p class="Instructions">Use this section to add, edit or delete a vacation scheduled at your vacation home.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="90%" cellpadding="5">
			<?php include("SaveVacations.php") ?>
			<?php include("GetScheduledVacations.php") ?>
		</table>
</td></tr>
</table>
<div><br/><button type="submit" name="newsubmit" value="newsubmit" id="newsubmit" class="btn btn-primary">Schedule Vacation</button></div>

<?php

	}
	else
	{
		echo "You do not have access to this page. <a href=\"index.php\">Please click here to log in.</a>";
		echo "<script language='JavaScript'>this.location='/index.php';</script>";
	}
}
else
{
	echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";
	echo "<script language='JavaScript'>this.location='/index.php';</script>";

}
?>
</div>

<?php 

	$VacationResultOne = NULL;
	$GetTypeOne= NULL;
	$StartRangeOne= NULL;
	$StartDateOne= NULL;
	$EndRangeOne= NULL;
	$EndDateOne= NULL;
	$VacationNameOne= NULL;
	$AllowGuestsOne= NULL;
	$AllowOwnersOne= NULL;
	$FirstNameOne= NULL;
	$LastNameOne= NULL;
	$OwnerIdValOne= NULL;
	$BkgrndColorOne= NULL;
	$FontColorOne= NULL;

//This is update vacation screen logic
if (isset($_GET["VacationId"]))
{
	$VacationResultOne = NULL;
	$GetTypeOne= NULL;
	$StartRangeOne= NULL;
	$StartDateOne= NULL;
	$EndRangeOne= NULL;
	$EndDateOne= NULL;
	$VacationNameOne= NULL;
	$AllowGuestsOne= NULL;
	$AllowOwnersOne= NULL;
	$FirstNameOne= NULL;
	$LastNameOne= NULL;
	$OwnerIdValOne= NULL;
	$BkgrndColorOne= NULL;
	$FontColorOne= NULL;

	// This function gets a list of the vacation dates
	$VacationResultOne = GetVacationDates($VacationResultOne, $_GET["VacationId"] , $StartRangeOne, $StartDateOne, $EndRangeOne, $EndDateOne, $VacationNameOne, $AllowGuestsOne, $AllowOwnersOne,  $FirstNameOne, $LastNameOne, $OwnerIdValOne, $BkgrndColorOne, $FontColorOne);

	while ($VacationRowOne = mysqli_fetch_array($VacationResultOne, MYSQL_ASSOC)) 
	{
	
	$df_src = 'Y-m-d';
	$df_des = 'n/j/Y';

	$VacationNameOne = stripslashes($VacationRowOne['VacationName']);
	$StartDateOne = stripslashes(dates_interconv( $df_src, $df_des, $VacationRowOne['StartDate'])).' '.stripslashes($VacationRowOne['StartTime']);
	$EndDateOne = stripslashes(dates_interconv( $df_src, $df_des, $VacationRowOne['EndDate'])).' '.stripslashes($VacationRowOne['EndTime']);
	$BkgrndColorOne = stripslashes($VacationRowOne['BackGrndColor']);
	$FontColorOne = stripslashes($VacationRowOne['FontColor']);

	}
	?>

<?php 
	}
	?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

	<form id="vacationformlist" action="EditCalendar.php" method="post" >
	<input type="hidden" name="VacationId" id="VacationId" value="<?php echo $_GET["VacationId"]; ?>" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Schedule Vacation</h4>
      </div>
      <div class="modal-body">
	  <div id="myModalMessage" style="color:red" ></div>
<div class="date-form">

<div class="form-horizontal">
    <div class="control-group">
        <label for="vacStartDate" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <label for="vacStartDate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                </label>
                <input value="<?php echo $StartDateOne; ?>" name="vacStartDate" id="vacStartDate" type="text" class="date-picker form-control" />
            </div>
        </div>
    </div>
    <div class="control-group">
        <label for="vacEndDate" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <label for="vacEndDate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                </label>
                <input value="<?php echo $EndDateOne; ?>" name="vacEndDate" id="vacEndDate" type="text" class="date-picker form-control" />
            </div>
        </div>
    </div>
    <div class="control-group">
	    <label for="VacationName" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <input value="<?php echo $VacationNameOne; ?>"  id="VacationName" name="VacationName" type="text" class="form-control" placeholder="Vacation Name" />
            </div>
        </div>
    </div>	
    <div class="control-group">
	    <label for="BackGrndColor" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
				<select name="BackGrndColor" id="BackGrndColor" class="form-control" >
					<option value="3a87ad" style="background-color: #3a87ad;">Default</option>
					<option value="F48058" style="background-color: #F48058;">Red</option>
					<option value="F4AC58" style="background-color: #F4AC58;">Orange</option>
					<option value="F3F298" style="background-color: #F3F298;">Yellow</option>
					<option value="B0EFA8" style="background-color: #B0EFA8;">Green</option>
					<option value="B9EAE3" style="background-color: #B9EAE3;">Light Blue</option>
					<option value="9ECCF8" style="background-color: #9ECCF8;">Dark Blue</option>
					<option value="9EB1F8" style="background-color: #9EB1F8;">Purple</option>
					<option value="DEB2F1" style="background-color: #DEB2F1;">Pink</option>
					<option value="FFFBF0" style="background-color: #FFFBF0;">White</option>
				</select>
				<input type="hidden" name="BackGrndColorHidden" id="BackGrndColorHidden" value="<?php echo $BkgrndColorOne; ?>"/>
            </div>
        </div>
    </div>	
    <div class="control-group">
	    <label for="FontColor" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
			<select name="FontColor" id="FontColor" class="form-control">
				<option value="ffffff" style="background-color: #ffffff;">Default</option>
				<option value="FEFCF6" style="background-color: #FEFCF6;">White</option>
				<option value="32302B" style="background-color: #32302B;">Black</option>
				<option value="94918B" style="background-color: #94918B;">Gray</option>
			</select>
			<input type="hidden" name="FontColorHidden" id="FontColorHidden" value="<?php echo $FontColorOne; ?>" />
            </div>
        </div>
    </div>	
</div>
</div>

      </div>
      <div class="modal-footer" id="newvacationfooter">
	    <input type="hidden" name="SaveScheduledOwner" value="N" />
		<input type="hidden" id="submittype" name="submittype" value="savesubmit" />
		<button type="submit" name="savesubmit" value="savesubmit" id="savesubmit" class="btn btn-primary">Schedule Vacation</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      <div class="modal-footer" id="existingvacationfooter">
		<input type="hidden" name="InitialStartRange" id="InitialStartRange" value="" />
		<input type="hidden" name="InitialEndRange" id="InitialEndRange" value="" />	  
		<button type="submit" name="updatesubmit" value="updatesubmit" id="updatesubmit" class="btn btn-primary">Update Vacation</button>
		<button type="submit" name="deletesubmit" value="deletesubmit" id="deletesubmit" class="btn btn-primary">Delete Vacation</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>	 
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->	

<div id="confirmModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
		  <div class="modal-body">
			Are you sure you want to delete this vacation?
		  </div>
		  <div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-primary" id="deleteVacationButton">Delete</button>
			<button type="button" data-dismiss="modal" class="btn">Cancel</button>
		  </div>
	</div>
  </div>
</div>	

<script type="text/javascript">
    $(document).ready(function () {
        $("[id*='date-picker']").each(function () {
            $(this).addClass("date-picker");
        });
        $('.date-picker').removeAttr('type');
		
        $('.date-picker').datetimepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-10:+10",
            beforeShow: function () {
                var $datePicker = $(".date-picker");
                var zIndexModal = $datePicker.closest(".modal").css("z-index");
                $datePicker.css("z-index", zIndexModal + 1);
            },
			showMinute:false,
			stepMinute: 60,
			hour: 12,
			minute: 0,
			addSliderAccess: true, 
			sliderAccessArgs: { touchonly: false }
        }).attr('readonly', 'true').
            keypress(function (event) {
                if (event.keyCode == 8) {
                    event.preventDefault();
                }
            });
			
<?php
			if (isset($_GET["VacationId"]) && isset($_GET["Change"]) && $_GET["Change"] == 'Update'){
				echo "$('#existingvacationfooter').show();";
				echo "$('#newvacationfooter').hide();";
				echo "$(\"#myModal\").modal('show');";
			}
?>			
			$( "#savesubmit" ).click(function( event ){$( "#submittype" ).val('savesubmit');} );
			$( "#updatesubmit" ).click(function( event ){$( "#submittype" ).val('updatesubmit');} );
			$( "#deletesubmit" ).click(function( event ){
				event.preventDefault();
				$( "#confirmModal" ).modal('show'); 
			} );
			$( "#deleteVacationButton" ).click(function( event ){
				$( "#submittype" ).val('deletesubmit');
				$( "#vacationformlist" ).submit();
			} );
			$( "#newsubmit" ).click(function( event ){
				var theDate = new Date();
				theDate.setHours(12);
				$('#myModalMessage').empty();
				$('#VacationId').val('');
				$('#VacationName').val('');
				$('#vacStartDate').datepicker('setDate', theDate);
				$('#vacEndDate').datepicker('setDate', theDate);				
				$('#newvacationfooter').show();
				$('#existingvacationfooter').hide();
				$("#myModal").modal('show');
				$('#BackGrndColor').val('3a87ad').css( "background-color", '#'+$('#BackGrndColor').val());
				$('#FontColor').val('ffffff').css( "background-color", '#'+$('#FontColor').val());
			} );
			
			// Attach a submit handler to the form
			$( "#vacationformlist" ).submit(function( event ) {
			  // Stop form from submitting normally
			  event.preventDefault();
			  // Get some values from elements on the page:
			  var $form = $( this ),
			  url = $form.attr( "action" );
			  // Send the data using post
			  var posting = $.post( url, $( "#vacationformlist" ).serialize()  );
			  // Put the results in a div
			  posting.done(function( data ) {	
			    if(data.indexOf("Congrats") != -1){
					window.location.href = [location.protocol, '//', location.host, location.pathname].join('');
				}else{
					$('#myModalMessage').html(data); 
				}
			  });
			});	

		$('#BackGrndColor').val($('#BackGrndColorHidden').val()).css( "background-color", '#'+$('#BackGrndColorHidden').val()).change(function() {
							$('#BackGrndColor').css( "background-color", '#'+$('#BackGrndColor').val() ); });
		$('#FontColor').val($('#FontColorHidden').val()).css( "background-color", '#'+$('#FontColorHidden').val()).change(function() {
							$('#FontColor').css( "background-color", '#'+$('#FontColor').val() ); });			

    });
</script>	
</body>
</html>
