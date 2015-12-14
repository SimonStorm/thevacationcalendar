<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">		
	<title>The Vacation Calendar</title>
	<link href="css/BeachStyle.css" rel="stylesheet" type="text/css" />	
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">	
	<link href="css/lightbox.css" rel="stylesheet" />
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
		theme_advanced_resizing : false,

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

<div class="container vacation">	

  <h2 class="featurette-heading">House bulletin board</h2>
<p class="Instructions">Use the editor on this screen to add content to your house message board. This is a great place to include house rules, driving instructions, favorite restaurants, and emergency contact information. Remember to save often. </p>
<form action="ViewBoard.php" method="post">
		<div class="form-group">
		  <textarea  name="Board" class="form-control" rows="30" >
						<?php
						$BoardQuery = "SELECT Board
										FROM Board 
										WHERE HouseId = ".$_SESSION["HouseId"];
								  
						$BoardResult = mysqli_query( $GLOBALS['link'],  $BoardQuery );
						if (!$BoardResult)
						{
							ActivityLog('Error', curPageURL(), 'Select Board',  $BoardQuery, mysqli_error($GLOBALS['link']));
							die ("Could not query the database: <br />". mysqli_error($GLOBALS['link']));
						}
						while ($BoardRow = mysqli_fetch_array($BoardResult, MYSQL_ASSOC)) 
						{
							echo stripslashes($BoardRow['Board']);
						}
						?>
						
		   </textarea>		  
		</div>
		<div class="form-group">
		  <input class="btn btn-success" type="submit" value="Update Board" />
		</div>
	</form>

</div>

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
