<?php ActivityLog('Info', curPageURL(), 'Blog Comments Include',  NULL, NULL); ?>
<?php

//This section displays the existing blogs and comments.
	$GetType = $_GET['BlogId'];


	GetBlog(&$BlogResult, $GetType, 'B');

	DisplayBlog(&$BlogResult, 'B');

	GetBlog(&$BlogResult, $GetType, 'C');

	DisplayBlog(&$BlogResult, 'C');

//This section displays the input fields to enter a new comment
	
	echo "<tr><td class=\"TextItem\">Author: </td><td><input maxlength=\"50\" type=\"text\" name=\"Author\"></td></tr>";
	echo "<tr><td class=\"TextItem\">Comment: </td><td><textarea maxlength=\"65535\" cols=\"50\" rows=\"5\" name=\"Comment\"></textarea></td></tr>";
	echo "<tr><td colspan=\"2\" class=\"TextItem\">&nbsp;</td></tr>";
	echo "<tr align=\"center\"><td><input type=\"button\" value=\"Cancel\" onclick=\"history.back();\"></td>";
	echo "<td><input type=\"submit\" value=\"Add Comment\"><input type=\"hidden\" name=\"AddComment\" value=\"".$_GET["BlogId"]."\"></td></tr></table></td></tr>";

?>
			