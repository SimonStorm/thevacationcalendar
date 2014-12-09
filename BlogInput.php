<?php ActivityLog('Info', curPageURL(), 'Blog Input Include',  NULL, NULL); ?>
<?php

// This is the insert comment logic
if (isset($_POST['AddComment']))
{

	$InsertCommentQuery = "INSERT INTO BlogComment (BlogId, Author, Content, BlogDate, HouseId,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
			VALUES (".$_POST['AddComment'].", '".mysql_real_escape_string($_POST['Author'])."', '".mysql_real_escape_string($_POST['Comment'])."', now(), ".$_SESSION['HouseId'].", 
			'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
		if (!mysql_query( $InsertCommentQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Insert Blog Comment',  $InsertCommentQuery, mysql_error());
			die ("Could not insert blog comment into the database: <br />". mysql_error());
		}
		
		echo "Congrats you have added your comment";
		echo "<meta http-equiv=\"Refresh\" content=\"1; url=Blog.php?Request=Read&BlogId=".$_POST['AddComment']."\"/>";
}

// This is the insert comment logic
if (isset($_POST['AddBlog']))
{

	$InsertBlogQuery = "INSERT INTO Blog (HouseId, Author, Subject, Content, BlogDate,  Audit_user_name, Audit_Role, Audit_FirstName, Audit_LastName, Audit_Email) 
			VALUES (".$_SESSION['HouseId'].", '".mysql_real_escape_string($_POST['Author'])."', '".mysql_real_escape_string($_POST['Subject'])."', '".mysql_real_escape_string($_POST['Content'])."', now(), 
			'".$_SESSION['user_name']."', '".$_SESSION['Role']."', '".$_SESSION['FirstName']."', '".$_SESSION['LastName']."', '".$_SESSION['Email']."')";
		
		if (!mysql_query( $InsertBlogQuery ))
		{
			ActivityLog('Error', curPageURL(), 'Insert Blog',  $InsertBlogQuery, mysql_error());
			die ("Could not insert blog into the database: <br />". mysql_error());
		}
		
		$BlogId = mysql_insert_id();
		
		SendBlogNotification('inserted', $BlogId);

		echo "Congrats you have added your blog";
//		echo "<meta http-equiv=\"Refresh\" content=\"1; url=Blog.php\"/>";
}


?>