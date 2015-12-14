<?php ActivityLog('Info', curPageURL(), 'Blog Comments Include',  NULL, NULL); ?>
<?php

//This section displays the existing blogs and comments.
	$GetType = $_GET['BlogId'];


	$BlogResult = GetBlog($GetType, 'B');

	DisplayBlog($BlogResult, 'B');

	$BlogResult = GetBlog($GetType, 'C');

	DisplayBlog($BlogResult, 'C');

//This section displays the input fields to enter a new comment
	
	echo "<tr><td colspan=\"2\" ><input placeholder=\"Author\" class=\"form-control\" maxlength=\"50\" type=\"text\" name=\"Author\"></td></tr>";
	echo "<tr><td colspan=\"2\" ><textarea placeholder=\"Comment\" class=\"form-control\" maxlength=\"65535\" cols=\"50\" rows=\"5\" name=\"Comment\"></textarea></td></tr>";
	echo "<tr><td colspan=\"2\" class=\"TextItem\">&nbsp;</td></tr>";
	echo "<tr align=\"center\"><td><input class=\"btn btn-success\" type=\"button\" value=\"Cancel\" onclick=\"history.back();\"></td>";
	echo "<td><input class=\"btn btn-success\" type=\"submit\" value=\"Add Comment\"><input type=\"hidden\" name=\"AddComment\" value=\"".$_GET["BlogId"]."\"></td></tr></table></td></tr>";

?>
			