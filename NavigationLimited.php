<script type="text/javascript">

function NavIn(cell) 
{
	if (cell.className != "NavSelected")
	{
		cell.className="NavOver";
		
	}

}

function NavOut(cell) 
{
	if (cell.className != "NavSelected")
	{
		cell.className="NavNormal";
	}
}

function Validate(inForm) {

	if(inForm.SelectedHouse.value == '' )
	{
		alert('The autocomplete did not find a house, please try again.');
		return false;
	}
	else
	{
		return true;
	}
}


</script>

<?php
if (isset($_SESSION['HouseId']))
{
	if (file_exists('images/customimage_'.$_SESSION['HouseId'].'.jpg'))
	{
		$HeadingPicture = imagecreatefromjpeg('images/customimage_'.$_SESSION['HouseId'].'.jpg');
		$PicWidth = ImageSx($HeadingPicture);
		
		$PageWidth = 960 - 180 + $PicWidth;
		$ColWidth = $PicWidth;
		
	}
	else
	{
		$PageWidth = 960;
		$ColWidth = 180;
	}
}
else
{
	$PageWidth = 960;
	$ColWidth = 180;
}


?>

    <div class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><img class="logoimg" src="img/calicon.png" /></a>
			  <!--<a class="navbar-brand" href=\"index.php\"><button type="submit" name="submit" class="btn btn-success">Sign In</button></a>-->

            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sign In<span class="caret"></span></a>
                  <ul class="dropdown-menu dropdown-menusignin" role="menu">
                    <li>
						<form class="navbar-form" role="form" id="houseSearchForm" action="indexLogin.php" method="get">
							<div class="form-group">
							  <select placeholder="Enter House Name or Address Here and Select" class="demo-default" name="HouseId" id="HouseName">
							  </select>							  
							<div class="divider"></div>							
							  <button type="submit" class="btn btn-success" onclick="return Validate(this.form);" >Go To House</button>
						  </form>
					</li>
                  </ul>
                </li>
<?php

$Home = "<li><a href=\"index.php\">Home</a></li>";
$Purchase = "<li><a href=\"NewHouseOne.php\">Sign Up</a></li>";
$Contact = "<li><a href=\"Contact.php\">Contact Us</a></li>";
$Blog = "<li><a href=\"Blog\">More Info</a></li>";
$Help = "<li><a href=\"Instructions.php\">Help</a></li>";

echo $Home;
echo $Purchase;
echo $Blog;
echo $Contact;
echo $Help;

?>

              </ul>

            </div>
          </div>
        </nav>

      </div>
    </div>

	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/docs.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<script type="text/javascript" src="js/selectize.js"></script>
	<link rel="stylesheet" type="text/css" href="css/selectize.css" />
<script >

$('#HouseName').selectize({
    valueField: 'HouseId',
    labelField: 'HouseVal',
    searchField: 'HouseVal',
    create: false,
	options: [],
    render: {
        option: function(item, escape) {
            return '<div id="houseoptions">' +
                '<span class="title">' +
                    '<span class="by">' + escape(item.HouseVal) + '</span>' +
                '</span>' +
            '</div>';
        }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
        $.ajax({
            url: 'indexSearchResultsJSON.php' +  '/?HouseName=' + encodeURIComponent(query),
            type: 'GET',
			dataType: 'json',
            error: function() {
                callback();
            },
            success: function(res) {
                return callback(res.houses);
            }
        });
    }	
});
</script>
