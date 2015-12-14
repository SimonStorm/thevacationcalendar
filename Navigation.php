
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

        <nav class="navbar navbarapp navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><img class="logoimg" src="img/calicon.png" /></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
							
<?php
$Calendar = "<li><a href=\"Calendar.php\">Calendar</a></li>";
$ScheduleVacation = "<li><a href=\"ScheduleVacations.php\">Vacations</a></li>"; 
$HouseBlog = "<li><a href=\"Blog.php\">Blog</a></li>"; 
$ManageProfile = "<li><a href=\"ManageProfile.php\">Manage Account</a></li>";
$AdministerUsers = "<li><a href=\"OwnerAdministration.php\">Administer Users</a></li>";
$AdministerVacation = "<li><a href=\"EditAdmin.php\">Delete Vacation</a></li>";
$Board = "<li><a href=\"Board.php\">Manage Bulletin Board</a></li>";
$Photos = "<li><a href=\"Photos.php\">Photo Album</a></li>";
$ViewBoard = "<li><a href=\"ViewBoard.php\">Bulletin Board</a></li>";
$LogOut = "<li><a href=\"logout.php\">Log Out</a></li>";

$Home = "<li><a href=\"index.php\">Home</a></li>";
$MoreInfo = "<li><a href=\"MoreInfo.php\">Site Features</a></li>";
$Purchase = "<li><a href=\"NewHouseOne.php\">Sign Up</a></li>";
$SignIn = "<li class=\"dropdown\">
                  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Sign In<span class=\"caret\"></span></a>
                  <ul class=\"dropdown-menu dropdown-menusignin\" role=\"menu\">
                    <li>
						<form class=\"navbar-form\" role=\"form\" id=\"houseSearchForm\" action=\"indexLogin.php\" method=\"get\">
							<div class=\"form-group\">
							  <select placeholder=\"Enter House Name or Address Here and Select\" class=\"demo-default\" name=\"HouseId\" id=\"HouseName\">
							  </select>							  
							<div class=\"divider\"></div>							
							  <button type=\"submit\" class=\"btn btn-success\" onclick=\"return Validate(this.form);\" >Go To House</button>
						  </form>
					</li>
                  </ul>
                </li>";

$Contact = "<li><a href=\"Contact.php\">Contact Us</a></li>";
$Blog = "<li><a href=\"Blog\">More Info</a></li>";
$Help = "<li><a href=\"Instructions.php\">Help</a></li>";
$HelpGuest = "<li><a href=\"Instructions.php#GuestsInst\">Help</a></li>";
$HelpOwner = "<li><a href=\"Instructions.php#Owners\">Help</a></li>";
$HelpAdmin = "<li><a href=\"Instructions.php#Admins\">Help</a></li>";


$Blank = "<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>";

if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == 'Owner')
	{
		echo $Calendar;
		if (ShowOldSave() == 'CHECKED')
		{
			echo $ScheduleVacation;
		}

		echo $HouseBlog;
		echo $ViewBoard;
		echo $Photos;
		echo $ManageProfile;
		echo $HelpOwner;		
		echo $LogOut;
		echo $Blank;
	}
	elseif ($_SESSION['Role'] == 'Guest')
	{
		echo $Calendar;
		echo $HouseBlog;
		echo $ViewBoard;
		echo $Photos;
		echo $HelpGuest;		
		echo $LogOut;
	}
	elseif  ($_SESSION['Role'] == 'Administrator')
	{
		echo $Calendar;
		if ($_SESSION['Role'] == "Administrator" && IsAdminOwner())
		{
			if (ShowOldSave() == 'CHECKED')
			{
				echo $ScheduleVacation;
			}
		}

		echo $HouseBlog;
		echo $ViewBoard;
		echo $Photos;
		echo $ManageProfile;
        echo "<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">Administrator<span class=\"caret\"></span></a><ul class=\"dropdown-menu\" role=\"menu\">";
		echo $AdministerUsers;	
		echo $Board;
		echo $AdministerVacation;
		echo $HelpAdmin;	
		echo "</ul></li>";
		echo $LogOut;	
		
	}
}
else
{
		echo $SignIn;
		echo $Home;
		echo $Purchase;
		echo $Blog;
		echo $Contact;
		echo $Help;

}
?>
              </ul>

            </div>
          </div>
        </nav>

      </div>
    </div>
	
<?php
if (isset($_SESSION['HouseId']))
{
	if (file_exists('images/customimage_'.$_SESSION['HouseId'].'.jpg'))
	{
		echo "<div class=\"img-circlediv2\" style=\"position:absolute\" ><a href=\"images/customimage_".$_SESSION['HouseId'].".jpg\" data-lightbox=\"image-1\" data-title=\"".$_SESSION['HouseName']."\"><img class=\"img-circle2\" src=\"images/customimage_".$_SESSION['HouseId'].".jpg\" alt=\"\"></a></div>";
	}
	else
	{
		echo "<div class=\"img-circlediv2\" style=\"position:absolute\" ><a href=\"images/housedefault.jpg\" data-lightbox=\"image-1\" data-title=\"Vacation House\"><img class=\"img-circle2\" src=\"images/housedefault.jpg\" alt=\"\"></a></div>";
	}
}

?>		
	
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="js/jquery.js"></script>	
	<script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery-ui-sliderAccess.js"></script>
    <script src="js/jquery-ui-timepicker-addon.js"></script>	
	<script src='js/jquery-ui.custom.min.js'></script>
	<script src='fullcalendar/fullcalendar.js'></script>	
    <script src="js/bootstrap.js"></script>
    <script src="js/docs.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<script src="js/lightbox.js"></script>
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
        option: function(item, escape) {//alert('tes'+item.HouseName+' '+item.HouseVal);
            return '<div id="houseoptions">' +
                '<span class="title">' +
                    '<span class="by">' + escape(item.HouseVal) + '</span>' +
                '</span>' +
            '</div>';
        }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
		//var params = JSON.parse(this.$input.attr('selectized'));
		//alert(query);
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