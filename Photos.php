<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">

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
	
	if (!mysql_query( $DeletePhotoQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Photo from Album',  $DeletePhotoQuery, mysql_error());
		die ("Could not delete photo from the database: <br />". mysql_error());
	}
	
	$DeleteAllPhotoCommentQuery = "DELETE FROM PhotoComment 
		WHERE HouseId = ".$_SESSION['HouseId']." 
		AND PhotoId = ".$_GET['Delete'];
	
	if (!mysql_query( $DeleteAllPhotoCommentQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Photo Comment from Album',  $DeleteAllPhotoCommentQuery, mysql_error());
		die ("Could not delete photo comment from the database: <br />". mysql_error());
	}

	unlink("photos/photo_".$_SESSION['HouseId']."_".$_GET['Delete'].".jpg");

}

if (isset($_GET['DeleteComment']))
{
	$DeletePhotoCommentQuery = "DELETE FROM PhotoComment 
		WHERE HouseId = ".$_SESSION['HouseId']." 
		AND CommentId = ".$_GET['DeleteComment'];
	
	if (!mysql_query( $DeletePhotoCommentQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Photo Comment from Album',  $DeletePhotoCommentQuery, mysql_error());
		die ("Could not delete photo comment from the database: <br />". mysql_error());
	}
	
}

if (isset($_POST['AddComment']))
{
	$PhotoQuery = "SELECT PhotoId, HouseId
						FROM Photo
						WHERE HouseId = ".$_SESSION['HouseId']."
						ORDER BY 1";

	$PhotoResult = mysql_query( $PhotoQuery );
	if (!$PhotoResult)
	{
		ActivityLog('Error', curPageURL(), 'Select Photo for Comment',  $PhotoQuery, mysql_error());
		die ("Could not query the database: <br />". mysql_error());
	}
	
	$counter = 1;
	while ($PhotoRow = mysql_fetch_array($PhotoResult, MYSQL_ASSOC)) 
	{
		if (isset($_POST["PhotoComment_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId']]))
		{
			if (strlen(trim($_POST["PhotoComment_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId']])) > 0)
			{
				$InsertPhotoCommentQuery = "INSERT INTO PhotoComment (PhotoId, HouseId, Comment, UserId, CommentDate) 
					VALUES (".$PhotoRow['PhotoId'].", ".$_SESSION['HouseId'].", '".$_POST["PhotoComment_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId']]."', '".$_SESSION['user_name']."', SYSDATE())";
			
				if (!mysql_query( $InsertPhotoCommentQuery ))
				{
					ActivityLog('Error', curPageURL(), 'Inserts Photo Comment into Album',  $InsertPhotoCommentQuery, mysql_error());
					die ("Could not insert photo comment into the database: <br />". mysql_error());
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
	
		if (!mysql_query( $InsertPhotoQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Inserts Picture into Album',  $InsertPhotoQuery, mysql_error());
			die ("Could not insert picture into the database: <br />". mysql_error());
		}
		
		$PhotoId = mysql_insert_id();
		
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


<table border="0" align="center" width="85%">
	<tr align="center">
		<td colspan="4"><h1>House Photo Album</h1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Add, view and comment on vacation photos</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<form enctype="multipart/form-data" action="Photos.php" method="post" id="PhotoAddForm">
			<table class="FocusTable" align="center" width="100%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Add New Photo:
					</td>
					<td colspan="1"><!-- MAX_FILE_SIZE must precede the file input field -->
				    	<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><input size="20" maxlength="2" type="file" name="PhotoAlbumPicture"></input>
					</td>
					<TD CLASS=TextItem ALIGN=LEFT COLSPAN="2">
						<input type="submit" value="Add Photo" />
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<form action="Photos.php" method="post" id="PhotoCommentAddForm">
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center" width="100%" cellpadding="5" border=0>
<?php			
		$PhotoQuery = "SELECT PhotoId, HouseId
							FROM Photo
							WHERE HouseId = ".$_SESSION['HouseId']."
							ORDER BY 1";
	
		$PhotoResult = mysql_query( $PhotoQuery );
		if (!$PhotoResult)
		{
			ActivityLog('Error', curPageURL(), 'Select Photo',  $PhotoQuery, mysql_error());
			die ("Could not query the database: <br />". mysql_error());
		}
		
		$counter = 1;
		while ($PhotoRow = mysql_fetch_array($PhotoResult, MYSQL_ASSOC)) 
		{

			$PhotoId = $PhotoRow['PhotoId'];

			$PhotoDisplay = "<img src=\"photos/photo_".$PhotoRow['HouseId']."_".$PhotoRow['PhotoId'].".jpg\">";

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
		
			$PhotoCommentResult = mysql_query( $PhotoCommentQuery );
			if (!$PhotoCommentResult)
			{
				ActivityLog('Error', curPageURL(), 'Select Photo Comments for Display',  $PhotoCommentQuery, mysql_error());
				die ("Could not query the database: <br />". mysql_error());
			}
			
			$PhotoCommentEntry = "";
			while ($PhotoCommentRow = mysql_fetch_array($PhotoCommentResult, MYSQL_ASSOC)) 
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
					<TD CLASS=TextItem width=600>
						$PhotoDisplay
					</td>
					<TD CLASS=TextItem ALIGN=LEFT>
						$PhotoDelete
					</td>
				</tr>
				$PhotoCommentEntry
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						<textarea cols="70" rows="3" name="$PhotoComment"></textarea>
					</td>
					<TD CLASS=TextItem ALIGN=LEFT>
						<input type="submit" value="Add Comment" name="AddComment">
					</td>
				</tr>
EOPHOTOFORM;

echo $photo_form;
		}

?>
			</table>
		</td>
	</tr>
	</form>
</table>


<?php include("Footer.php") ?>

<?php 
}
else
{
echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";

}
?>

</body>
</html>
