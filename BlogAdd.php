<?php ActivityLog('Info', curPageURL(), 'Blog Add Include',  NULL, NULL); ?>
<?php


//This section displays the input fields to create a new blog
	echo "<div class=\"form-signin\" role=\"form\" ><tr><td colspan=\"2\"><input maxlength=\"50\" type=\"text\" name=\"Author\" placeholder=\"Author\" class=\"form-control\"></td></tr>";
	echo "<tr><td colspan=\"2\"><input maxlength=\"100\" type=\"text\" name=\"Subject\" placeholder=\"Subject\" class=\"form-control\"></td></tr>";
	echo "<tr><td colspan=\"2\"><textarea maxlength=\"65535\" cols=\"50\" rows=\"5\" name=\"Content\"  placeholder=\"Blog\" class=\"form-control\"></textarea></td></tr>";
	echo "<tr><td colspan=\"2\" class=\"TextItem\">&nbsp;</td></tr>";
	echo "<tr align=\"center\"><td><input class=\"btn btn-success\" type=\"button\" value=\"Cancel\" onclick=\"history.back();\"></td>";
	echo "<td><input class=\"btn btn-success\" type=\"submit\" value=\"Add Blog\"><input type=\"hidden\" name=\"AddBlog\" value=\"0\"></td></tr></div>";

?>
