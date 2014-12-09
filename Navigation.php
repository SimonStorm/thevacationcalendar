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

<table border="0" align="center" width="<?php echo $PageWidth; ?>" cellpadding="0" cellspacing="0">
	<tr>
		<td>			
			<table border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" align="center">
							<tr>
								<td height="72px" align="left"><a href="/index.php"><img border="0" src="/images/branding.gif" alt="branding" /></a></td>
								<td align="right" valign="bottom" bgcolor="#FFFBF0" width="<?php echo $ColWidth; ?>">&nbsp;<a href="/Instructions.php">Need Help?</a></td>
								<td align="left" width="25px">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr bgcolor="white">
								<td height="1px"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" align="center">
							<tr align="center">
								<td height="120px" align="left"><a href="/index.php"><img border="0" src="/images/photobanner.jpg" alt="photo banner" /></a></td>
<?php
if (isset($_SESSION['HouseId']))
{
	if (file_exists('images/customimage_'.$_SESSION['HouseId'].'.jpg'))
	{
		echo "<td width=\"".$ColWidth."\" bgcolor=\"#FFFBF0\" align=\"center\"><img src=\"/images/customimage_".$_SESSION['HouseId'].".jpg\" alt=\"house picture\" /></td>";
	}
	else
	{
		echo "<td width=\"".$ColWidth."\" bgcolor=\"#FFFBF0\" align=\"center\"><img src=\"/images/housedefault.jpg\" alt=\"house picture\" /></td>";
	}
}
else
{
	echo "<td width=\"".$ColWidth."\" bgcolor=\"#FFFBF0\" align=\"center\"><img src=\"/images/housedefault.jpg\" alt=\"house picture\" /></td>";
}

?>							
								<td align="left"><img src="/images/photobannerpiece.jpg" alt="picture piece" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0">
							<tr bgcolor="white">
								<td height="1px"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="<?php echo $PageWidth; ?>" cellpadding="0" cellspacing="0" align="center">
							<tr align="center">
								
<?php
$Calendar = "<td height=\"33px\" id=\"Calendar\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/Calendar.php';\"><a id=\"CalendarLink\" class=\"NavLink\" href=\"/Calendar.php\">calendar</a></td>";
$ScheduleVacation = "<td height=\"33px\" id=\"Vacations\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/ScheduleVacations.php';\"><a class=\"NavLink\" id=\"VacationsLink\" href=\"/ScheduleVacations.php\">vacations</a></td>";
//$EditVacation = "<td height=\"33px\" id=\"EditVacations\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\"><a class=\"NavLink\" id=\"EditVacationsLink\" href=\"/EditOwner.php\">edit vacation</a></td>";
$AdministerVacation = "<td height=\"33px\" id=\"Admin\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/EditAdmin.php';\"><a class=\"NavLink\" id=\"AdminLink\" href=\"/EditAdmin.php\">delete<br/>vacations</a></td>";
$ScheduleGuests = "<td height=\"33px\" id=\"Schedule\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/ScheduleGuests.php';\"><a class=\"NavLink\" id=\"ScheduleLink\" href=\"/ScheduleGuests.php\">schedule<br/>visitors</a></td>";
$ManageGuests = "<td height=\"33px\" id=\"Guests\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/ManageGuests.php';\"><a class=\"NavLink\" id=\"GuestsLink\" href=\"/ManageGuests.php\">manage<br/>visitors</a></td>";
$ManageRooms = "<td height=\"33px\" id=\"Rooms\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/ManageRooms.php';\"><a class=\"NavLink\" id=\"RoomsLink\" href=\"/ManageRooms.php\">manage<br/>rooms</a></td>";
$HouseBlog = "<td height=\"33px\" id=\"Blog\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/Blog.php';\"><a class=\"NavLink\" id=\"BlogLink\" href=\"/Blog.php\">blog</a></td>";
$ManageProfile = "<td height=\"33px\" id=\"Profile\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/ManageProfile.php';\"><a class=\"NavLink\" id=\"ProfileLink\" href=\"/ManageProfile.php\">manage<br/>account</a></td>";
$AdministerUsers = "<td height=\"33px\" id=\"Users\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/OwnerAdministration.php';\"><a class=\"NavLink\" id=\"UsersLink\" href=\"/OwnerAdministration.php\">administer<br/>users</a></td>";
$Board = "<td height=\"33px\" id=\"EditBoard\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/Board.php';\"><a class=\"NavLink\" id=\"EditBoardLink\" href=\"/Board.php\">manage<br/>bulletin board</a></td>";
$Photos = "<td height=\"33px\" id=\"Photos\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/Photos.php';\"><a class=\"NavLink\" id=\"PhotosLink\" href=\"/Photos.php\">photo<br/>album</a></td>";
$ViewBoard = "<td height=\"33px\" id=\"Board\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/ViewBoard.php';\"><a class=\"NavLink\" id=\"BoardLink\" href=\"/ViewBoard.php\">bulletin<br/>board</a></td>";
$LogOut = "<td height=\"33px\" id=\"LogOut\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/logout.php';\"><a class=\"NavLink\" id=\"LogOutLink\" href=\"/logout.php\">log out</a></td>";

$Home = "<td height=\"33px\" id=\"Home\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/index.php';\"><a id=\"HomeLink\" class=\"NavLink\" href=\"/index.php\">home</a></td>";
$Purchase = "<td height=\"33px\" id=\"Purchase\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = 'http://www.thevacationcalendar.com/NewHouseOne.php';\"><a id=\"PurchaseLink\" class=\"NavLink\" href=\"http://www.thevacationcalendar.com/NewHouseOne.php\">sign up</a></td>";
$MoreInfo = "<td height=\"33px\" id=\"MoreInfo\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/MoreInfo.php';\"><a id=\"MoreInfoLink\" class=\"NavLink\" href=\"/MoreInfo.php\">site features</a></td>";
$Contact = "<td height=\"33px\" id=\"Contact\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/Contact.php';\"><a id=\"ContactLink\" class=\"NavLink\" href=\"/Contact.php\">contact us</a></td>";
$Blog = "<td height=\"33px\" id=\"Blog\" width=\"8%\" class=\"NavNormal\" colspan=\"1\" onmouseover=\"NavIn(this);\" onmouseout=\"NavOut(this);\" onclick=\"location.href = '/Blog/';\"><a id=\"BlogLink\" class=\"NavLink\" href=\"/Blog/\">more info</a></td>";
$Tagline = "<td height=\"33px\" class=\"IndexHeader\" align=\"right\">manage your vacation home occupancy and availability&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == 'Owner')
	{
		echo $Calendar;
		if (ShowOldSave() == 'CHECKED')
		{
			echo $ScheduleVacation;
		}
	//	echo $EditVacation;
		if (HasRooms())
		{
			echo $ScheduleGuests;
			echo $ManageGuests;
		}
		echo $HouseBlog;
		echo $ViewBoard;
		echo $Photos;
		echo $ManageProfile;
		echo $LogOut;
	}
	elseif ($_SESSION['Role'] == 'Guest')
	{
		echo $Calendar;
		echo $HouseBlog;
//		echo $ManageProfile;
		echo $ViewBoard;
		echo $Photos;
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
			if (HasRooms())
			{
				echo $ScheduleGuests;
				echo $ManageGuests;
			}
		}
		else
		{
			if (HasRooms())
			{
				echo $ManageGuests;
			}
		}
		echo $ManageRooms;
		echo $AdministerUsers;
		echo $AdministerVacation;
		echo $HouseBlog;
		echo $Board;
		echo $ViewBoard;
		echo $Photos;
		echo $ManageProfile;
		echo $LogOut;
	}
}
else
{
		echo $Home;
		echo $Purchase;
		echo $MoreInfo;
		echo $Blog;
		echo $Contact;
		echo $Tagline;

}
?>
							</tr>
						</table>
					</td>
				</tr>
				<tr align="center" valign="top">
					<td height="650">

