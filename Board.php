<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>The Vacation Calendar</title>
    <LINK href="BeachStyle.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "BeachStyle.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js"

});
</script></HEAD>

<body onload="init();">



<script type="text/javascript">

function init() 
{
try {
	if (document.getElementById('EditBoard')) {
		document.getElementById('EditBoard').className="NavSelected";
		document.getElementById('EditBoardLink').className="NavSelectedLink";

	}
} catch(e) {
} finally {
} 

return 0;
}

</SCRIPT>

<?php if (isset($_SESSION['Role']))
{
?>

<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("Navigation.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Create House Board',  NULL, NULL); ?>

<form action="ViewBoard.php" method="post">

<table border="0" align="center" width="85%">
	<tr align="center">
		<td colspan="4"><h1>House Board</h1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table border="0" class="FocusTable" align="center" width="70%" cellpadding="5">
				<tr align="center">
					<td>
						<p class="Instructions">Use the editor on this screen to add content to your house message board. This is a great place to include house rules, driving instructions, favorite restaurants, and emergency contact information. Remember to save often. </p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table class="FocusTable" align="center" width="100%" cellpadding="5">
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem COLSPAN=2>

					</td>
				</tr>
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem>
						Enter your board text:
					</td>
					<TD CLASS=TextItem>
						<textarea cols="70" rows="20" name="Board">
<?php
$BoardQuery = "SELECT Board
				FROM Board 
				WHERE HouseId = ".$_SESSION["HouseId"];
		  
$BoardResult = mysql_query( $BoardQuery );
if (!$BoardResult)
{
	ActivityLog('Error', curPageURL(), 'Select Board',  $BoardQuery, mysql_error());
	die ("Could not query the database: <br />". mysql_error());
}
while ($BoardRow = mysql_fetch_array($BoardResult, MYSQL_ASSOC)) 
{
	echo stripslashes($BoardRow['Board']);
}
?>
						
						</textarea>
					</td>
				</tr>
				<TR ALIGN=CENTER>
					<TD CLASS=TextItem ALIGN=LEFT COLSPAN="2">
						<input type="submit" value="Update Board" />
					</td>


</form>
				</tr>
			</table>
		</td>
	</tr>
</table>


<?php include("Footer.php") ?>

<?php 
}
else
{
echo "You are not logged in or do not have access to this site. <a href=\"index.php\">Please click here to log in.</a>";

}
?>

</body>
</html>
