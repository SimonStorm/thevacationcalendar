<?php ActivityLog('Info', curPageURL(), 'Blog Delete Include',  NULL, NULL); ?>
<?php

// This is the delete blog logic
$DeleteBlogCommentsQuery = "DELETE FROM BlogComment 
					WHERE BlogId = ".$_GET['BlogId']."
					AND HouseId = ".$_SESSION['HouseId'];
	
	if (!mysqli_query( $GLOBALS['link'],  $DeleteBlogCommentsQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Blog Comment',  $DeleteBlogCommentsQuery, mysqli_error($GLOBALS['link']));
		die ("Could not delete the blog from the database: <br />". mysqli_error($GLOBALS['link']));
	}

$DeleteBlogQuery = "DELETE FROM Blog 
					WHERE BlogId = ".$_GET['BlogId']."
					AND HouseId = ".$_SESSION['HouseId'];
	
	if (!mysqli_query( $GLOBALS['link'],  $DeleteBlogQuery ))
	{
		ActivityLog('Error', curPageURL(), 'Delete Blog',  $DeleteBlogQuery, mysqli_error($GLOBALS['link']));
		die ("Could not delete the blog from the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	echo "Congrats you have deleted your blog";
	echo "<meta http-equiv=\"Refresh\" content=\"1; url=Blog.php\"/>";

?>