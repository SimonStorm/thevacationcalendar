<?php ActivityLog('Info', curPageURL(), 'Build Calendar',  NULL, NULL); ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	
	<form id="vacationform" action="EditCalendar.php" method="post" >
	  <input type="hidden" name="VacationId" id="VacationId" value="" />
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
                <input name="vacStartDate" id="vacStartDate" type="text" class="date-picker form-control" />
            </div>
        </div>
    </div>
    <div class="control-group">
        <label for="vacEndDate" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <label for="vacEndDate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                </label>
                <input name="vacEndDate" id="vacEndDate" type="text" class="date-picker form-control" />
            </div>
        </div>
    </div>
    <div class="control-group">
	    <label for="VacationName" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <input id="VacationName" name="VacationName" type="text" class="form-control" placeholder="Vacation Name" />
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
	
<div class="modal fade" id="myModalView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	
	<form id="vacationformjoin" action="RequestJoin.php" method="post" >
	  <input type="hidden" name="VacationIdJoin" id="VacationIdJoin" value="" />
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Request to Join Vacation</h4>
      </div>
      <div class="modal-body">
	  To request to join this vacation, provide your name, email, the dates you want to come and click "Request to Join"
	  <div id="myModalMessage" style="color:red" ></div>
<div class="date-form">

<div class="form-horizontal">
    <div class="control-group">
	    <label for="VacationName" class="control-label"></label>
        <div class="controls">
            <div class="input-group" id="viewVacationNameText" >
            </div>
        </div>
    </div>	
    <div class="control-group">
	    <label for="RequestName" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <input id="RequestName" name="RequestName" type="text" class="form-control" placeholder="Name" />
            </div>
        </div>
    </div>	
	    <div class="control-group">
	    <label for="RequestEmail" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <input id="RequestEmail" name="RequestEmail" type="text" class="form-control" placeholder="Email" />
            </div>
        </div>
    </div>	
    <div class="control-group">
        <label for="vacStartDateJoin" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <label for="vacStartDateJoin" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                </label>
                <input name="vacStartDateJoin" id="vacStartDateJoin" type="text" class="date-picker form-control" />
            </div>
        </div>
    </div>
    <div class="control-group">
        <label for="vacEndDateJoin" class="control-label"></label>
        <div class="controls">
            <div class="input-group">
                <label for="vacEndDateJoin" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                </label>
                <input name="vacEndDateJoin" id="vacEndDateJoin" type="text" class="date-picker form-control" />
            </div>
        </div>
    </div>

</div>
</div>
      </div>
      <div class="modal-footer" id="existingvacationfooter">
		<input type="hidden" name="InitialStartRangeJoin" id="InitialStartRangeJoin" value="" />
		<input type="hidden" name="InitialEndRangeJoin" id="InitialEndRangeJoin" value="" />	  
		<button type="submit" name="updatesubmitjoin" value="updatesubmitjoin" id="updatesubmitjoin" class="btn btn-primary">Request to Join</button>
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
			
			
			$( "#savesubmit" ).click(function( event ){$( "#submittype" ).val('savesubmit');} );
			$( "#updatesubmit" ).click(function( event ){$( "#submittype" ).val('updatesubmit');} );
			$( "#deletesubmit" ).click(function( event ){
				event.preventDefault();
				$( "#confirmModal" ).modal('show'); 

			} );
			$( "#deleteVacationButton" ).click(function( event ){
				$( "#submittype" ).val('deletesubmit');
				$( "#vacationform" ).submit();
			} );
			
			
			// Attach a submit handler to the form
			$( "#vacationform" ).submit(function( event ) {
			  // Stop form from submitting normally
			  event.preventDefault();
			  // Get some values from elements on the page:
			  var $form = $( this ),
				url = $form.attr( "action" );
			  // Send the data using post
			  var posting = $.post( url, $( "#vacationform" ).serialize()  );
			  // Put the results in a div
			  posting.done(function( data ) {	
			    if(data.indexOf("Congrats") != -1){
				    var initDate = new Date($( "#vacStartDate" ).val());
					window.location = 'Calendar.php?year='+initDate.getFullYear()+'&month='+initDate.getMonth()+'&date='+initDate.getDate()+'&view='+$('#calendar').fullCalendar('getView').name;
				}else{
					$('#myModalMessage').html(data); 
				}
			  });
			});
    });
</script>

</script>	
	
<script type='text/javascript'>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth()+1;
		var y = date.getFullYear();
		$('#calendar').fullCalendar({
			header: {
				left: 'title',
				center: 'prev,next today',
				right: 'year,month,agendaWeek,agendaDay'
			},
			editable: false,

<?php
	    if(isset($_GET["year"]) && isset($_GET["month"]) && isset($_GET["date"]) && isset($_GET["view"])){
			echo 'year: '.$_GET["year"].',';
			echo 'month: '.$_GET["month"].',';
			echo 'date: '.$_GET["date"].',';
			echo 'defaultView: \''.$_GET["view"].'\',';
		}

		if ($_SESSION['Role'] == "Owner" || ( $_SESSION['Role'] == "Administrator" && IsAdminOwner()))
		{
			echo 'dayClick: function(date, jsEvent, view) { ';
			echo 'date.setHours(12);';
			echo '$(\'#newvacationfooter\').show();';
			echo '$(\'#existingvacationfooter\').hide();';
			echo '$(\'#myModalMessage\').empty();';			
			echo '$(\'#myModal\').modal(\'show\');';
			echo '$(\'#vacStartDate\').datepicker(\'setDate\', date);';
			echo '$(\'#vacEndDate\').datepicker(\'setDate\', date);';
			echo '$(\'#BackGrndColor\').val(\'3a87ad\').css( \'background-color\', \'#\'+$(\'#BackGrndColor\').val());';
			echo '$(\'#FontColor\').val(\'ffffff\').css( \'background-color\', \'#\'+$(\'#FontColor\').val());';			
			echo '$(\'#VacationName\').val(\'\');';	
			echo '$(\'#VacationId\').val(\'\');';	
			echo '},';
		}
?>
			eventClick: function(calEvent, jsEvent, view) {
				if(calEvent.className != 'noway'){
					$('#newvacationfooter').hide();
					$('#existingvacationfooter').show();
					$('#myModalMessage').empty();
					$('#myModal').modal('show'); 
					$('#vacStartDate').datepicker('setDate', calEvent.start);
					$('#vacEndDate').datepicker('setDate', calEvent.end);
					if($('#vacEndDate').val().length == 0){
						$('#vacEndDate').datepicker('setDate', calEvent.start);
					}
					$('#InitialStartRange').val($('#vacStartDate').val().slice(0,10));	
					$('#InitialEndRange').val($('#vacStartDate').val().slice(0,10));					
					$('#VacationName').val(calEvent.title);	
					$('#VacationId').val(calEvent.id);
					$('#BackGrndColor').val(calEvent.color.slice(1)).css( "background-color", calEvent.color ).change(function() {
							$('#BackGrndColor').css( "background-color", '#'+$('#BackGrndColor').val() ); });
					$('#FontColor').val(calEvent.textColor.slice(1)).css( "background-color", calEvent.textColor ).change(function() {
							$('#FontColor').css( "background-color", '#'+$('#FontColor').val() ); });
				}else{
					$('#vacStartDateJoin').datepicker('setDate', calEvent.start);
					$('#vacEndDateJoin').datepicker('setDate', calEvent.end);
					$('#InitialStartRangeJoin').val(calEvent.start);	
					$('#InitialEndRangeJoin').val(calEvent.end);
					if($('#InitialEndRangeJoin').val().length == 0){
						$('#InitialEndRangeJoin').val(calEvent.start);	
					}					
					$('#viewVacationNameText').html('Vacation Name : ' + calEvent.title);
					$('#VacationIdJoin').val(calEvent.id);
					$('#myModalView').modal('show'); 
				}
			},			
			events: 'CreateCalendarJSON.php'
		});
		
		$('#BackGrndColor').css( "background-color", '#'+$('#BackGrndColor').val()).change(function() {
							$('#BackGrndColor').css( "background-color", '#'+$('#BackGrndColor').val() ); });
		$('#FontColor').css( "background-color", '#'+$('#FontColor').val()).change(function() {
							$('#FontColor').css( "background-color", '#'+$('#FontColor').val() ); });

	});
</script>


