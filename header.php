<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page;?> | SAA</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!--include preload if the page is home or dashboard -->
    <?php
		if((isset($page) && $page == 'Home') || (isset($page) && $page == 'Dashboard'))
			echo '<link rel="stylesheet" href="css/preload.css">';
	  ?>
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">
    

   <style>
 .row .error 
    {
     color:red;
     visibility: hidden;
                  
    }
	  

	  
.disabled {
        cursor: default;
        opacity: 0.6;
    }
</style>
  </head>
  <body>
    <div class="page home-page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="index.php" class="navbar-brand">
                  <div class="brand-text brand-big"><span>ٍSentimental Analysis For Airlines</span></div>
                  <div class="brand-text brand-small"><strong>BD</strong></div></a>
<!--                 Toggle Button<a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>-->
              </div>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Navidation Menus-->
          <ul class="list-unstyled">
           <li <?php echo (isset($page) && $page == 'Home')? ' class="active" ':'';?> > <a href="index.php"><i class="fa fa-home"></i>Home</a></li>
            <li <?php echo (isset($page) && $page == 'Dashboard')? ' class="active" ':'';
							echo (isset($page) && $page == 'Home' && !isset($_COOKIE['USER']))? ' style="pointer-events: none;"':'';?> > <a href="dashboard.php"><i class="fa fa-tachometer"></i>Dashboard</a></li>
            <li <?php echo (isset($page) && $page == 'Analysis')? ' class="active" ':'';
							echo (isset($page) && $page == 'Home' && !isset($_COOKIE['USER']))? ' style="pointer-events: none;"':'';?> > <a href="analysis.php"> <i class="fa fa-book"></i>Analysis </a></li>
            <li <?php echo (isset($page) && $page == 'About Us')? ' class="active" ':'';
							echo (isset($page) && $page == 'Home' && !isset($_COOKIE['USER']))? ' style="pointer-events: none;"':'';?> > <a href="AboutUs.php"> <i class="fa fa-cart-plus"></i>AboutUs </a></li>
          </ul>
        </nav>
        <div class="content-inner">
          <!-- Page Header-->
<!--
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom"></h2>
            </div>
          </header>-->
