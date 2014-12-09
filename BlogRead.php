<?php ActivityLog('Info', curPageURL(), 'Blog Read Include',  NULL, NULL); ?>
<?php
//This section displays the guests in the system
	$GetType = $_GET['BlogId'];

	GetBlog(&$BlogResult, $GetType, 'B');

	DisplayBlog(&$BlogResult, 'B');

	GetBlog(&$BlogResult, $GetType, 'C');

	DisplayBlog(&$BlogResult, 'C');

?>
