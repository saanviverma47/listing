<?php
	// get last selected theme from user
    //Assets::add_js( array('bootstrap.min.js', 'selectize.min.js', 'theme-switcher.js', 'metisMenu.js', 'jquery.cookie.js', 'bootstrap-typeahead.min.js', 'jquery.redirect.js', 'custom.js') );
    if((settings_item('adv.search_blocks') == 2) || (settings_item('adv.search_blocks') == 3 )) {
    	Assets::add_js('ontype_location_search.js');
    } else {
    	Assets::add_js('default_search.js');
    }
   // Assets::add_css( array('bootstrap.min.css', 'font-awesome.min.css', 'selectize.bootstrap3.css', 'famfamfam-flags.css', 'layout.css', 'yellow_theme.css'));
    $inline = '$(".nav-tabs a:first").tab("show")';

	//  Assets::add_js( $inline, 'inline' );
    // this condition is used to load the different page for home and other
	if($_SERVER['REQUEST_URI'] != "/" && $_SERVER['REQUEST_URI'] != "/index.php"){
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo !empty($page_title) ? $page_title .' : ' : settings_item('site.meta_title'); ?> <?php if (class_exists('Settings_lib')) e(settings_item('site.title')); else echo 'mbb'; ?></title>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : settings_item('site.meta_description'); ?>">
    <meta name="keywords" content="<?php echo isset($page_keywords) ? $page_keywords : settings_item('site.meta_keywords'); ?>">
    <meta name="author" content="<?php echo settings_item('site.meta_title'); ?>">
	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href="<?php echo Template::theme_url("images/fav.ico")?>" type="image/x-icon">
	<!-- GOOGLE FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
	<!-- FONTAWESOME ICONS -->
	<link rel="stylesheet" href="<?php echo Template::theme_url("css/font-awesome.min.css")?>">
	<!-- ALL CSS FILES -->
	<link href="<?php echo Template::theme_url("css/materialize.css")?>" rel="stylesheet">
	<link href="<?php echo Template::theme_url("css/style.css")?>" rel="stylesheet">
	<link href="<?php echo Template::theme_url("css/bootstrap.css")?>" rel="stylesheet" type="text/css" />
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
	<link href="<?php echo site_url("css/responsive.css")?>" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="<?php echo Template::theme_url("js/html5shiv.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/respond.min.js")?>"></script>
	<![endif]-->
</head>

<body>
	<section>
		<div class="v3-top-menu">
			<div class="container">
				<div class="row">
					<div class="v12-menu">
						<div class="v12-m-1">
							<a href="index.php" style="passing-top:3px;"><img src="<?php echo Template::theme_url("images/logo2.png"); ?>" alt=""> </a>
							<div class="dir-ho-tr" style="float: right; ">
								<ul >
									<li><a href="aboutus.php" style="color: #000;">About Us</a> </li>
									<li><a href="register.php" style="color: #000;">Register</a> </li>
									<li><a href="/members/add_business" ><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
									<li><a href="login" style="color: #000;">Sign In</a> </li>
									<li><a href="contactus.php" style="color: #000;">Contact Us</a> </li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
<?php } else { ?>
<!-- For home page -->
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo !empty($page_title) ? $page_title .' : ' : settings_item('site.meta_title'); ?> <?php if (class_exists('Settings_lib')) e(settings_item('site.title')); else echo 'mbb'; ?></title>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : settings_item('site.meta_description'); ?>">
    <meta name="keywords" content="<?php echo isset($page_keywords) ? $page_keywords : settings_item('site.meta_keywords'); ?>">
    <meta name="author" content="<?php echo settings_item('site.meta_title'); ?>">

	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href=<?php echo Template::theme_url("images/fav.ico")?>" type="image/x-icon">
	<!-- GOOGLE FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
	<!-- FONTAWESOME ICONS -->
	<link rel="stylesheet" href="<?php echo Template::theme_url("css/font-awesome.min.css")?>">
	<!-- ALL CSS FILES -->
	<link href="<?php echo Template::theme_url("css/materialize.css")?>" rel="stylesheet">
	<link href="<?php echo Template::theme_url("css/style.css")?>" rel="stylesheet">
	<link href="<?php echo Template::theme_url("css/bootstrap.css")?>" rel="stylesheet" type="text/css" />
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
	<link href="css/responsive.css" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="<?php echo Template::theme_url("js/html5shiv.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/respond.min.js")?>"></script>
	<![endif]-->
</head>

<body>
	<!--PRE LOADING-->
	<!--BANNER AND SERACH BOX-->
	<section id="background" class="dir1-home-head">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="dir-ho-tl">
						<ul>
							<li>
								<a href="index.php"><img src="<?php echo Template::theme_url("images/logo.png")?>" alt=""> </a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="dir-ho-tr">
						<ul>
							<li><a href="aboutus.php">About Us</a> </li>
							<li><a href="register.php">Register</a> </li>
							<li><a href="/members/add_business"><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
							<li><a href="login">Sign In</a> </li>
							<li><a href="contactus.php">Contact Us</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container dir-ho-t-sp">
			<div class="row">
				<div class="dir-hr1">
					<div class="dir-ho-t-tit">
						<h1>Connect with the right Service Experts</h1> 
						<p>Find B2B & B2C businesses contact addresses, phone numbers,<br> user ratings and reviews.</p>
					</div>
					<form class="tourz-search-form">
						<div class="input-field">
							<input type="text" id="select-city" class="autocomplete">
							<label for="select-city">Enter city</label>
						</div>
						<div class="input-field">
							<input type="text" id="select-search" class="autocomplete">
							<label for="select-search" class="search-hotel-type">Search your services like hotel, resorts, events and more</label>
						</div>
						<div class="input-field">
							<input type="submit" value="search" class="waves-effect waves-light tourz-sear-btn"> </div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!--TOP SEARCH SECTION-->
	<section id="myID" class="bottomMenu hom-top-menu">
		<div class="container top-search-main">
			<div class="row">
				<div class="ts-menu">
					<!--SECTION: LOGO-->
					<div class="ts-menu-1">
						<a href="index.php"><img src="<?php echo Template::theme_url("images/aff-logo.png")?>" alt=""> </a>
					</div>
					<!--SECTION: BROWSE CATEGORY(NOTE:IT'S HIDE ON MOBILE & TABLET VIEW)-->
					<!--SECTION: SEARCH BOX-->
					<div class="ts-menu-3">
						<div class="">
							<form class="tourz-search-form tourz-top-search-form">
								<div class="input-field">
									<input type="text" id="top-select-city" class="autocomplete">
									<label for="top-select-city">Enter city</label>
								</div>
								<div class="input-field">
									<input type="text" id="top-select-search" class="autocomplete">
									<label for="top-select-search" class="search-hotel-type">Search your services like hotel, resorts, events and more</label>
								</div>
								<div class="input-field">
									<input type="submit" value="" class="waves-effect waves-light tourz-top-sear-btn"> </div>
							</form>
						</div>
					</div>
					<!--SECTION: REGISTER,SIGNIN AND ADD YOUR BUSINESS-->
					<div class="ts-menu-4">
						<div class="v3-top-ri">
							<ul>
								<li><a href="login.php" class="v3-menu-sign"><i class="fa fa-sign-in"></i> Sign In</a> </li>
								<li><a href="db-listing-add.php" class="v3-add-bus"><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

