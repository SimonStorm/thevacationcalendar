<?php ActivityLog('Info', curPageURL(), 'Blog Read Include',  NULL, NULL); ?>
<?php
//This section displays the guests in the system
	$GetType = $_GET['BlogId'];

	$BlogResult = GetBlog($GetType, 'B');

	DisplayBlog($BlogResult, 'B');

	$BlogResult = GetBlog($GetType, 'C');

	DisplayBlog($BlogResult, 'C');

?>
