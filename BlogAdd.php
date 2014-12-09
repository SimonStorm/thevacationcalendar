<?php ActivityLog('Info', curPageURL(), 'Blog Add Include',  NULL, NULL); ?>
<?php


//This section displays the input fields to create a new blog
	echo "<tr><td class=\"TextItem\">Author: </td><td><input maxlength=\"50\" type=\"text\" name=\"Author\"></td></tr>";
	echo "<tr><td class=\"TextItem\">Subject: </td><td><input maxlength=\"100\" type=\"text\" name=\"Subject\"></td></tr>";
	echo "<tr><td class=\"TextItem\">Blog: </td><td><textarea maxlength=\"65535\" cols=\"50\" rows=\"5\" name=\"Content\"></textarea></td></tr>";
	echo "<tr><td colspan=\"2\" class=\"TextItem\">&nbsp;</td></tr>";
	echo "<tr align=\"center\"><td><input type=\"button\" value=\"Cancel\" onclick=\"history.back();\"></td>";
	echo "<td><input type=\"submit\" value=\"Add Blog\"><input type=\"hidden\" name=\"AddBlog\" value=\"0\"></td></tr></table></td></tr>";

?>
