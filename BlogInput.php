<?php ActivityLog('Info', curPageURL(), 'Blog Input Include',  NULL, NULL); ?>
<?php

// This is the insert comment logic
if (isset($_POST['AddComment']))
{

	$InsertCommentQuery = "INSERT INTO BlogComment (BlogId, Author, Content, BlogDate, HouseId,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
			VALUES (".$_POST['AddComment'].", '".mysqli_real_escape_string($GLOBALS['link'], $_POST['Author'])."', '".mysqli_real_escape_string($GLOBALS['link'], $_POST['Comment'])."', now(), ".$_SESSION['HouseId'].", 
			'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
		if (!mysqli_query( $GLOBALS['link'],  $InsertCommentQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Insert Blog Comment',  $InsertCommentQuery, mysqli_error($GLOBALS['link']));
			die ("Could not insert blog comment into the database: <br />". mysqli_error($GLOBALS['link']));
		}
		
		echo "Congrats you have added your comment";
		echo "<meta http-equiv=\"Refresh\" content=\"1; url=Blog.php?Request=Read&BlogId=".$_POST['AddComment']."\"/>";
}

// This is the insert comment logic
if (isset($_POST['AddBlog']))
{

	$InsertBlogQuery = "INSERT INTO Blog (HouseId, Author, Subject, Content, BlogDate,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
			VALUES (".$_SESSION['HouseId'].", '".mysqli_real_escape_string($GLOBALS['link'], $_POST['Author'])."', '".mysqli_real_escape_string($GLOBALS['link'], $_POST['Subject'])."', '".mysqli_real_escape_string($GLOBALS['link'], $_POST['Content'])."', now(), 
			'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
		if (!mysqli_query( $GLOBALS['link'],  $InsertBlogQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Insert Blog',  $InsertBlogQuery, mysqli_error($GLOBALS['link']));
			die ("Could not insert blog into the database: <br />". mysqli_error($GLOBALS['link']));
		}
		
		$BlogId = mysqli_insert_id($GLOBALS['link']);
		
		SendBlogNotification('inserted', $BlogId);

		echo "Congrats you have added your blog";
//		echo "<meta http-equiv=\"Refresh\" content=\"1; url=Blog.php\"/>";
}


?>