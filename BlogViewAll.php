<?php ActivityLog('Info', curPageURL(), 'Blog View All Include',  NULL, NULL); ?>
<?php
//This section displays the guests in the system

	$GetType = 0;
	
	GetBlog(&$BlogResult, $GetType, 'B');

	DisplayBlog(&$BlogResult, 'B');


?>
