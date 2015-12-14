<?php
	

function GetBlog($GetType, $BlogType)
{
	// GetType = 0 will return all of the main blogs
	// GetType = Integer will return the blog with that ID

	// BlogType = B means display a blog
	// BlogType = C means display a comment

	if ($BlogType == 'B')
	{
		if ($GetType == 0)
		{
			$BlogQuery = "SELECT Subject, Content, Author, BlogDate, BlogId FROM Blog
							WHERE HouseId = ".$_SESSION['HouseId']."
							ORDER BY BlogDate";
		}
		else
		{
			$BlogQuery = "SELECT Subject, Content, Author, BlogDate, BlogId FROM Blog
						WHERE HouseId = ".$_SESSION['HouseId']."
						AND BlogId = ".$GetType."
						ORDER BY BlogDate";
		}
	}
	else
	{
		$BlogQuery = "SELECT Content, Author, BlogDate, BlogId FROM BlogComment
					WHERE BlogID = ".$GetType."
					AND HouseId = ".$_SESSION['HouseId']."
					ORDER BY BlogDate";
	}

	$BlogResult = mysqli_query( $GLOBALS['link'],  $BlogQuery );

	if (!$BlogResult)
	{
		ActivityLog('Error', curPageURL(), 'Select blog query',  $BlogQuery, mysqli_error($GLOBALS['link']));
		die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
	}
	
	return $BlogResult;
}



function DisplayBlog($BlogResult, $BlogType)
{
	
	// BlogType = B means display a blog
	// BlogType = C means display a comment

	$Counter = 1;
	while ( $BlogRow =  mysqli_fetch_assoc($BlogResult)) 
	{
		if ($BlogType == 'B')
		{
			if (fmod($Counter, 2) == 1)
			{
				echo "<tr><td colspan=\"3\"><table width=\"100%\" class=\"BlogOddColor\">";
			}
			else
			{
				echo "<tr><td colspan=\"3\"><table width=\"100%\" class=\"BlogEvenColor\">";
			}
			echo "<tr><td class=\"TextItem\" width=\"100\">Subject: </td><td class=\"BlogText\">".stripslashes($BlogRow['Subject'])."</td></tr>";
		}
		else
		{
			if (fmod($Counter, 2) == 1)
			{
				echo "<tr><td colspan=\"3\"><table width=\"100%\" class=\"RowOddColor\">";
			}
			else
			{
				echo "<tr><td colspan=\"3\"><table width=\"100%\" class=\"RowEvenColor\">";
			}
		}
		echo "<tr><td class=\"TextItem\" width=\"100\">Author: </td><td class=\"BlogText\">".stripslashes($BlogRow['Author'])."</td></tr>";
		echo "<tr><td class=\"TextItem\">Date: </td><td class=\"BlogText\">".$BlogRow['BlogDate']."</td></tr>";
		echo "<tr><td class=\"TextItem\">Blog: </td><td align=\"left\" class=\"BlogText\">".stripslashes($BlogRow['Content'])."</td></tr>";
		echo "<tr><td colspan=\"2\" class=\"TextItem\">&nbsp;</td></tr>";

		if ($BlogType == 'B')
		{
			echo "<tr><td colspan=\"2\"><table width=\"100%\"><tr align=\"center\">";
			echo "<td><a href=\"Blog.php?Request=Read&BlogId=".$BlogRow['BlogId']."\">Read Comments</a></td>";
			if ($_SESSION['Role'] == "Administrator")
			{
				echo "<td><a href=\"Blog.php?Request=Delete&BlogId=".$BlogRow['BlogId']."\">Delete Blog</a></td>";
			}
			else
			{
				echo "<td>&nbsp;</td>";
			}
			echo "<td><a href=\"Blog.php?Request=Comment&BlogId=".$BlogRow['BlogId']."\">Add Comment</a></td>";
			echo "</tr></table></td></tr>";
		}
		echo "</table></td></tr>";
		$Counter++;
	}

	if ($BlogType == 'C')
	{
		echo "<tr><td colspan=\"3\"><table width=\"100%\"><tr align=\"center\"><td><a href=\"Blog.php\">Return to Blogs</a></td>";
		echo "<td><a href=\"Blog.php?Request=Comment&BlogId=".$_GET['BlogId']."\">Add Comment</a></td></tr></table></td></tr>";
	}
}	
?>

