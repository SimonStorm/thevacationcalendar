<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">		
	<title>The Vacation Calendar</title>
	<link href="css/BeachStyle.css" rel="stylesheet" type="text/css" />	
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
<body onload="init();">

		  


<script type="text/javascript">

function init() 
{
try {
	if (document.getElementById('Photos')) {
		document.getElementById('Photos').className="NavSelected";
		document.getElementById('PhotosLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}


function validatePhoto(){
	var isValid = (new RegExp('(.jpg|.gif|.png'.replace(/\./g, '\\.') + ')$')).test($('#PhotoAlbumPictureText').val());
	if(!isValid){
		alert('Photo type is not valid.  It needs to be jpg, gif or png.');
	}
	return isValid;
}

</SCRIPT>

<?php if (isset($_SESSION['Role']))
{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'House Photos',  NULL, NULL); 

if (isset($_GET['Delete']))
{
	$DeletePhotoQuery = "DELETE FROM Photo 
		WHERE HouseId = ".$_SESSION['HouseId']." 
		AND PhotoId = ".$_GET['Delete'];
	
	if (!mysqli_query( $GLOBALS['link'],  $DeletePhotoQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Photo from Album',  $DeletePhotoQuery, mysqli_error($GLOBALS['link']));
		die ("Could not delete photo from the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	$DeleteAllPhotoCommentQuery = "DELETE FROM PhotoComment 
		WHERE HouseId = ".$_SESSION['HouseId']." 
		AND PhotoId = ".$_GET['Delete'];
	
	if (!mysqli_query( $GLOBALS['link'],  $DeleteAllPhotoCommentQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Photo Comment from Album',  $DeleteAllPhotoCommentQuery, mysqli_error($GLOBALS['link']));
		die ("Could not delete photo comment from the database: <br />". mysqli_error($GLOBALS['link']));
	}

	unlink("photos/photo_".$_SESSION['HouseId']."_".$_GET['Delete'].".jpg");

}

if (isset($_GET['DeleteComment']))
{
	$DeletePhotoCommentQuery = "DELETE FROM PhotoComment 
		WHERE HouseId = ".$_SESSION['HouseId']." 
		AND CommentId = ".$_GET['DeleteComment'];
	
	if (!mysqli_query( $GLOBALS['link'],  $DeletePhotoCommentQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Photo Comment from Album',  $DeletePhotoCommentQuery, mysqli_error($GLOBALS['link']));
		die ("Could not delete photo comment from the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
}

if (isset($_POST['AddComment']))
{
	$PhotoQuery = "SELECT PhotoId, HouseId
						FROM Photo
						WHERE HouseId = ".$_SESSION['HouseId']."
						ORDER BY 1";

	$PhotoResult = mysqli_query( $GLOBALS['link'],  $PhotoQuery );
	if (!$PhotoResult)
	{
		ActivityLog('Error', curPageURL(), 'Select Photo for Comment',  $PhotoQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	$counter = 1;
	while ($PhotoRow = mysqli_fetch_array($PhotoResult, MYSQL_ASSOC)) 
	{
		if (isset($_POST["PhotoComment_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId']]))
		{
			if (strlen(trim($_POST["PhotoComment_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId']])) > 0)
			{
				$commentVar = mysqli_real_escape_string($GLOBALS['link'], $_POST["PhotoComment_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId']]);
			
				$InsertPhotoCommentQuery = "INSERT INTO PhotoComment (PhotoId, HouseId, Comment, UserId, CommentDate) 
					VALUES (".$PhotoRow['PhotoId'].", ".$_SESSION['HouseId'].", '".$commentVar."', '".$_SESSION['user_name']."', SYSDATE())";
			
				if (!mysqli_query( $GLOBALS['link'],  $InsertPhotoCommentQuery ))
				{
					ActivityLog('Error', curPageURL(), 'Inserts Photo Comment into Album',  $InsertPhotoCommentQuery, mysqli_error($GLOBALS['link']));
					die ("Could not insert photo comment into the database: <br />". mysqli_error($GLOBALS['link']));
				}
			}
		}
	}
}

if (isset($_FILES['PhotoAlbumPicture']))
{
	if (strlen(trim($_FILES['PhotoAlbumPicture']['tmp_name'])) > 0) 
	{	

		// Where the file is going to be placed 
		$target_path = "photos/";
		
		/* Add the original filename to our target path.  
		Result is "uploads/filename.extension" */
		$target_path = $target_path.basename( $_FILES['PhotoAlbumPicture']['name']); 
		
		if(move_uploaded_file($_FILES['PhotoAlbumPicture']['tmp_name'], $target_path)) {
			echo "The file ".  basename( $_FILES['PhotoAlbumPicture']['name']). 
			" has been uploaded";
		} else{
			echo "There was an error uploading the file, please try again!";
		}
		
		
		// Setting the resize parameters
		$WorkingPicture = imagecreatefromjpeg($target_path);
		$width = ImageSx($WorkingPicture);
		$height = ImageSy($WorkingPicture);
		$Ratio = $width/$height;

		$IconCompress = 100;
		// Creating the Web Canvas
		if ($width > $height)
		{
			$NewWidth = 600;
			$NewHeight = $NewWidth/$Ratio;
		}
		else
		{
			$NewHeight = 600;
			$NewWidth = $NewHeight*$Ratio;
		}
	
		$IconPicture = imagecreatetruecolor($NewWidth, $NewHeight);
		
		// Resizing our image to fit the canvas
		imagecopyresized($IconPicture, $WorkingPicture, 0, 0, 0, 0, $NewWidth, $NewHeight, $width, $height);
		
		$InsertPhotoQuery = "INSERT INTO Photo (HouseId) 
			VALUES (".$_SESSION['HouseId'].")";
	
		if (!mysqli_query( $GLOBALS['link'],  $InsertPhotoQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Inserts Picture into Album',  $InsertPhotoQuery, mysqli_error($GLOBALS['link']));
			die ("Could not insert picture into the database: <br />". mysqli_error($GLOBALS['link']));
		}
		
		$PhotoId = mysqli_insert_id($GLOBALS['link']);
		
		$IconSaveName = "photos/photo_".$_SESSION['HouseId']."_".$PhotoId.".jpg";
	
		imagejpeg($IconPicture, $IconSaveName, $IconCompress);

		unlink($target_path);

		
		
	}
	else 
	{
//		echo "No picture uploaded";
	}
}

?>
<div class="container vacation">	
  <h2 class="featurette-heading">House Photo Album</h2>
  <div style="text-align:left">
	<div>
			<form onsubmit="return validatePhoto();" enctype="multipart/form-data" action="Photos.php" method="post" id="PhotoAddForm" class="form-signin" role="form" >
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-primary btn-file">
							Browse&hellip; <input type="file" class="form-control" name="PhotoAlbumPicture" id="PhotoAlbumPicture">
						</span>
					</span>
					<input id="PhotoAlbumPictureText" type="text" class="form-control" readonly placeholder="Add a photo">
					<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
				</div>	
				<div class="input-group">
					<br/>
					<input class="btn btn-success" type="submit" value="Add Photo" />	
				</div>				
			</form>
	</div>
<table border="0" align="center" width="85%">
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Add, view and comment on vacation photos.  Supported formats are jpg, png and gif.</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	


	<TR align="LEFT">
	  <TD colspan="2" class="TextItem"><hr style="border-top: 1px solid #000000;"></TD>
	</TR>	
	<form action="Photos.php" method="post" id="PhotoCommentAddForm">
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center" width="100%" cellpadding="5" border=0>
<?php			
		$PhotoQuery = "SELECT PhotoId, HouseId
							FROM Photo
							WHERE HouseId = ".$_SESSION['HouseId']."
							ORDER BY 1";
	
		$PhotoResult = mysqli_query( $GLOBALS['link'],  $PhotoQuery );
		if (!$PhotoResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Photo',  $PhotoQuery, mysqli_error($GLOBALS['link']));
			die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
		}
		
		$counter = 1;
		while ($PhotoRow = mysqli_fetch_array($PhotoResult, MYSQL_ASSOC)) 
		{

			$PhotoId = $PhotoRow['PhotoId'];

			$PhotoDisplay = "<img  class=\"img-responsive\" src=\"photos/photo_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId'].".jpg\">";

			$PhotoComment = "PhotoComment_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId'];
			if ($_SESSION['Role'] == 'Administrator')
			{
				$PhotoDelete = "<a href=\"Photos.php?Delete=$PhotoId\">Delete Photo</a>";
			}
			else
			{
				$PhotoDelete = "";
			}
		
			$PhotoCommentQuery = "SELECT CommentId, Comment, UserId, CommentDate
								FROM PhotoComment
								WHERE HouseId = ".$_SESSION['HouseId']."
								AND PhotoId = ".$PhotoId."
								ORDER BY CommentId";
		
			$PhotoCommentResult = mysqli_query( $GLOBALS['link'],  $PhotoCommentQuery );
			if (!$PhotoCommentResult)
			{
				ActivityLog('Error', curPageURL(), 'Select Photo Comments for Display',  $PhotoCommentQuery, mysqli_error($GLOBALS['link']));
				die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
			}
			
			$PhotoCommentEntry = "";
			while ($PhotoCommentRow = mysqli_fetch_array($PhotoCommentResult, MYSQL_ASSOC)) 
			{
				$PhotoCommentEntry .= "<TR ALIGN=LEFT><TD CLASS=TextItem>[".$PhotoCommentRow['UserId']." wrote on ".$PhotoCommentRow['CommentDate']."]<br /><br /><font class=\"CommentColor\">".$PhotoCommentRow['Comment']."</font></td>";
				if ($_SESSION['Role'] == 'Administrator')
				{
					$PhotoCommentEntry .= "<TD CLASS=TextItem ALIGN=LEFT><a href=\"Photos.php?DeleteComment=".$PhotoCommentRow['CommentId']."\">Delete</a></td></tr>";
				}
				else
				{
					$PhotoCommentEntry .= "<TD CLASS=TextItem ALIGN=LEFT></td></tr>";
				}
			}




$photo_form = <<< EOPHOTOFORM

<TR ALIGN=CENTER>
					<TD CLASS=TextItem >
						$PhotoDisplay
					</td>
					<TD CLASS=TextItem ALIGN=LEFT>
						$PhotoDelete
					</td>
				</tr>
				<TR align="LEFT">
				  <TD colspan="2" class="TextItem">&nbsp;</TD>
				</TR>					
				$PhotoCommentEntry
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem >
						<textarea class="form-control" cols="70" rows="3" name="$PhotoComment"></textarea>
					</td>
					<TD CLASS=TextItem >
						<input class="btn btn-success" type="submit" value="Add Comment" name="AddComment">
					</td>
				</tr>
				<TR align="LEFT">
					<TD  class="TextItem"><hr style="border-top: 1px solid #000000;"></TD>
				</TR>	
EOPHOTOFORM;

echo $photo_form;
		}

?>
			</table>
		</td>
	</tr>
	</form>
</table>

	</div>
</div>

<?php include("Footer.php") ?>

<?php 
}
else
{
echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";

}
?>

<script type="text/javascript">

$(document).on('change', '.btn-file :file', function () {
    var input = $(this), numFiles = input.get(0).files ? input.get(0).files.length : 1, label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [
        numFiles,
        label
    ]);
});
$(document).ready(function () {
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'), log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log)
                alert(log);
        }
    });
});
</script>

</body>
</html>
