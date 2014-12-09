<?php ActivityLog('Info', curPageURL(), 'Blog Delete Include',  NULL, NULL); ?>
<?php

// This is the delete blog logic
$DeleteBlogCommentsQuery = "DELETE FROM BlogComment 
					WHERE BlogId = ".$_GET['BlogId']."
					AND HouseId = ".$_SESSION['HouseId'];
	
	if (!mysql_query( $DeleteBlogCommentsQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Blog Comment',  $DeleteBlogCommentsQuery, mysql_error());
		die ("Could not delete the blog from the database: <br />". mysql_error());
	}

$DeleteBlogQuery = "DELETE FROM Blog 
					WHERE BlogId = ".$_GET['BlogId']."
					AND HouseId = ".$_SESSION['HouseId'];
	
	if (!mysql_query( $DeleteBlogQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Blog',  $DeleteBlogQuery, mysql_error());
		die ("Could not delete the blog from the database: <br />". mysql_error());
	}
	
	echo "Congrats you have deleted your blog";
	echo "<meta http-equiv=\"Refresh\" content=\"1; url=Blog.php\"/>";

?>