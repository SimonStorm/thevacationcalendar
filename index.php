<?php session_start(); ?>
<?php header("Cache-control: private"); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/favicon.ico">
	<title>The Vacation Calendar - Online Calendar to Manage Your Shared Vacation Home</title>
	<meta name="keywords" content="Vacation Calendar, Calendar, Shared Calendar, Shared Vacation Home, Shared Vacation, Shared Home, Online Calendar, Shared Vacation Home, Shared Vacation Calendar, Online Vacation Calendar, Vacation Calendar, Calendar, Timeshare, Condo, The Vacation Calendar, Beach House Calendar, Ski House Calendar, Mountain House Calendar, Lake House Calendar, Condo Calendar"/>
	<meta name="description" content="Online calendar to manage your vacation home occupancy and availability. Shared Online Vacation Calendar Perfect for Shared Vacation Home."/>
    <meta name="verify-v1" content="rv61Na+DJjgmm+bVOlNsyMdcDo7NHUJ9DcQF44WxpgU=" />

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">
  </head>
<!-- NAVBAR
================================================== -->
  <body class="bodyindex">	
<?php include("Database.php") ?>
<?php include("Functions.php") ?>
<?php include("NavigationLimited.php") ?>
<?php ActivityLog('Info', curPageURL(), 'Public Index Page',  NULL, NULL); ?>  

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active" >
          <img src="img/one.png" alt="First slide">
          <div class="container" >
            <div class="carousel-caption" >
              <p>The perfect way to organize all types of vacation homes</p>
              <p><a class="btn btn-lg btn-primary" href="NewHouseOne.php" role="button">Sign up today</a></p>
			  <p style="background-color:grey;margin-left:10%;margin-right:10%">Only $20 per year</p>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="img/two.png" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <p>Helps you manage any type of property arrangement</p>
              <p><a class="btn btn-lg btn-primary" href="#learnmore" role="button">Learn more</a></p>
			  <p style="background-color:grey;margin-left:10%;margin-right:10%">First month Free!</p>			  
            </div>
          </div>
        </div>
        <div class="item">
          <img src="img/three.png" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <p>Keep track of when your vacation home is in use</p>
              <p><a class="btn btn-lg btn-primary" href="NewHouseOne.php" role="button">Sign up today</a></p>
			  <p style="background-color:grey;margin-left:10%;margin-right:10%">We support mobile phones and tablets</p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

	  
    </div><!-- /.carousel -->

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
	
    <div class="container marketing vacationrow">
      <!-- Three columns of text below the carousel -->
      <div class="row vacationrow"><a name="learnmore"></a>
        <div class="col-lg-4">
          <img src="img/calendar.png" alt="Generic placeholder image" style="width: 140px; height: 140px;">
          <h2>Organize your vacation home schedule</h2>
          <p>Spend more time enjoying your getaway home</p>
          <!--<p><a class="btn btn-default" href="#" role="button">View details »</a></p>-->
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="img/photo.png" alt="Generic placeholder image" style="width: 140px; height: 140px;">
          <h2>Share information on the house bulletin board and house blog</h2>
          <p>Direct all of your guests to a single location that has all of the house details.</p>
          <!--<p><a class="btn btn-default" href="#" role="button">View details »</a></p>-->
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="img/note.png" alt="Generic placeholder image" style="width: 140px; height: 140px;">
          <h2>Let friends and family see when they can visit</h2>
          <p>Allows visitors to see when the house is going to be free.</p>
          <!--<p><a class="btn btn-default" href="#" role="button">View details »</a></p>-->
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider-top">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">What is The Vacation Calendar?</h2>
          <p class="lead">This is the main view of online calendar on TheVacationCalendar.com which allows everyone to see when the vacation home is in use. When a vacation is scheduled the user can set the online calendar to show that the house is occupied. Users can choose to use color to enhance the calendar or to signify special meaning, such as "would like to trade this vacation" for different time.</p>
        </div>
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/cal1.png" class="featurette-image img-responsive" alt="Calendar">
        </div>
      </div>
	  
      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/cal8.png" class="featurette-image img-responsive" alt="House Bulletin Board">
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">House Bulletin Board</h2>
          <p class="lead">The House Bulletin Board is the perfect solution to that all important piece paper that is always getting misplaced. This is a great place for contact information, house instructions, rules, cleaning services, favorite restaurants, directions, etc.</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Managing Vacations</h2>
          <p class="lead">So this is the money shot of TheVacationCalendar.com. Using this simple screen anyone who is authorized to schedule a vacation can do so. The site checks that there are no conflicts on the online calendar and prevents you from ever having multiple parties showing up at your vacation home at the same time.</p>
        </div>
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/cal3.png" class="featurette-image img-responsive" alt="Managing Vacations">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/iphone.png" class="featurette-image img-responsive" alt="Managing Vacations">
        </div>	  
        <div class="col-md-7">
          <h2 class="featurette-heading">TheVacationCalendar.com on ANY device</h2>
          <p class="lead">When TheVacationCalendar.com was first built, smart phones were barely beginning to gain steam. Now, the site is used on all sorts of devices from all the major vendors. TheVacationCalendar.com will adapt to whatever phone, tablet or computer you want to use!</p>
        </div>
      </div>		  
	  
      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">House Blog</h2>
          <p class="lead">How have you ever lived without a vacation home blog?!?! Since the House Bulletin Board is only updated by the administrator of the house, the House Blog gives everyone a place to share thoughts, provide updates, and generally make fun of each other.</p>
        </div>
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/cal7.png" class="featurette-image img-responsive" alt="House Blog">
        </div>		
      </div>
	  
      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/cal8.png" class="featurette-image img-responsive" alt="House Bulletin Board Administration">
        </div>	  
        <div class="col-md-7">
          <h2 class="featurette-heading">House Bulletin Board Administration</h2>
          <p class="lead">The House Bulletin Board is one of the most popular features of the online calendar and is easily maintained using the WYSIWYG (what you see is what you get) editor. This has all the same functions that you are accustomed to on your word processor so you can create a fun and appealing bulletin board without any coding.</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">House Photo Album</h2>
          <p class="lead">This is another favorite for many of the site's users. Since people were getting more and more use out of the vacation homes thanks to the online calendar system in TheVacationCalendar.com, we needed to provide a way to memorialize the great times you are having. So we added a new photo album. It is pretty simple for the first iteration, just add photos and allow anyone to comment. As always, the Administrator has the ability to remove any photos or comments that are inappropriate.</p>
        </div>	  
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/cal5.png" class="featurette-image img-responsive" alt="House Photo Album">
        </div>
      </div>	

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/cal6.png" class="featurette-image img-responsive" alt="Account Management">
        </div>	  
        <div class="col-md-7">
          <h2 class="featurette-heading">Account Management</h2>
          <p class="lead">This is your basic profile page that allows the administrator to update passwords, change the site picture, and {cough}{cough} cancel the subscription</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">User Management</h2>
          <p class="lead">This simple screen lets the Administrator of the house control the users. If you forget your password you can either use the automated password reset functionality or you can call the Administrator and he/she can update your account in a few clicks using this screen.</p>
        </div>	  
        <div class="col-md-5">
          <img data-holder-rendered="true" class="img-circle" src="images/cal9.png" class="featurette-image img-responsive" alt="User Management">
        </div>
      </div>	 		 	  

      <!-- /END THE FEATURETTES -->	  

      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>© 2015 The Vacation Calendar · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
      </footer>

    </div><!-- /.container -->
	<?php include("Footer.php") ?>

	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	try {
	var pageTracker = _gat._getTracker("UA-7019638-1");
	pageTracker._trackPageview();
	} catch(err) {}</script>
	
</body>
</html>





