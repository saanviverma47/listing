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
   	if(isset($_REQUEST) && !empty($_REQUEST)){
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
	<!--PRE LOADING-->
	<div id="preloader">
		<div id="status">&nbsp;</div>
	</div>
	<!--BANNER AND SERACH BOX-->
	<section>
		<div class="v3-top-menu">
			<div class="container">
				<div class="row">
					<div class="v3-menu">
						<div class="v3-m-1">
							<a href="index.php"><img src="images/logo2.png" alt=""> </a>
						</div>
						<div class="v3-m-2">
							<ul>
								<li><a class='dropdown-button ed-sub-menu' href='#' data-activates='drop-menu-home'>Home</a>
								</li>
								<li><a class='dropdown-button ed-sub-menu' href='#' data-activates='drop-mega-menu'>Listing</a>
								</li>
								<li><a class='dropdown-button ed-sub-menu' href='#' data-activates='drop-mega-dash'>Dashboard</a>
								</li>
								<li><a class='dropdown-button ed-sub-menu' href='#' data-activates='drop-menu-page'>Pages</a>
								</li>
								<li><a class='dropdown-button ed-sub-menu' href='#' data-activates='drop-menu-admin'>Admin</a>
								</li>
							</ul>
						</div>
						<div class="v3-m-3">
							<div class="v3-top-ri">
								<ul>
									<li><a href="login.php" class="v3-menu-sign"><i class="fa fa-sign-in"></i> Sign In</a> </li>
									<li><a href="db-listing-add.php" class="v3-add-bus"><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
								</ul>
							</div>
						</div>
					</div>
					<div class="all-drop-down-menu">
						<!--DROP DOWN MENU: HOME-->
						<ul id='drop-menu-home' class='dropdown-content'>
							<li><a href="index.php">Home Page - 1</a>
							</li>
							<li class="divider"></li>
							<li><a href="index1.php">Home Page - 2</a>
							</li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: HOME-->
						<ul id='drop-mega-dash' class='dropdown-content'>
							<li><a href="dashboard.php"><i class="fa fa-tachometer"></i> Dashboard</a> </li>
							<li><a href="db-my-profile.php"><i class="fa fa-user"></i>  User Profile</a> </li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='dropdown3' data-hover="hover" data-alignm="left"><i class="fa fa-sign-in"></i> Login Details</a>
							</li>
							<li><a href="db-invoice.php"><i class="fa fa-file-pdf-o"></i> Invoice</a> </li>
							<li><a href="db-invoice-download.php"><i class="fa fa-download"></i> Download Invoice </a> </li>
							<li><a href="db-setting.php"><i class="fa fa-cogs"></i> User Setting</a> </li>
							<li><a href="db-post-ads.php"><i class="fa fa-buysellads	"></i> Post Ads </a> </li>
							<li><a href="db-all-listing.php"><i class="fa fa-list-ul"></i> All Listings</a> </li>
							<li><a href="db-listing-add.php"><i class="fa fa-plus-square-o"></i> Add New Listing</a> </li>
							<li><a href="db-review.php"><i class="fa fa-star-half-full"></i> Listing Reviews</a> </li>
							<li><a href="db-payment.php"><i class="fa fa-credit-card"></i> Listing Payments </a> </li>
							<li><a href="db-message.php"><i class="fa fa-commenting-o"></i> Messages</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<ul id='drop-mega-menu' class='dropdown-content'>
							<li><a href="list.php"><i class="fa fa-list-ul"></i> All Listing</a>
							</li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='dropdown2' data-hover="hover" data-alignm="left"><i class="fa fa-list-alt"></i>  Listing Details</a>
							</li>
							<li class="divider"></li>
							<li><a href="add-listing.php"><i class="fa fa-plus"></i> Add Listing</a>
							</li>
							<li class="divider"></li>
							<li><a href="nearby-listings.php"><i class="fa fa-map-marker"></i> Nearby Listing</a>
							</li>
							<li class="divider"></li>
							<li><a href="new-business.php"><i class="fa fa-bookmark-o"></i> Latest Listings</a>
							</li>
							<li class="divider"></li>
							<li><a href="trendings.php"><i class="fa fa-bullhorn"></i> Trending Listing</a>
							</li>
						</ul>
						<!--DROP DOWN MENU: WEB DESIGN-->
						<ul id='dropdown2' class='dropdown-content'>
							<li><a href="listing-details.php">Listing Details </a> </li>
							<li class="divider"></li>
							<li><a href="list-grid.php">Listing Grid View</a>
							</li>
							<li class="divider"></li>
							<li><a href="list-lead.php">Lead Listing</a>
							</li>
							<li class="divider"></li>
							<li><a href="property-listing-details.php">Property View</a>
							</li>
							<li class="divider"></li>
							<li><a href="shop-listing-details.php">Shoping View</a>
							</li>
							<li class="divider"></li>
							<li><a href="hotels-listing-details.php">Hotel View</a>
							</li>
							<li class="divider"></li>
							<li><a href="automobile-listing-details.php">Automobile View</a>
							</li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: WEB DESIGN-->
						<ul id='dropdown3' class='dropdown-content'>
							<li><a href="register.php"> User Register</a> </li>
							<li><a href="login.php"> User Login</a> </li>
							<li><a href="forgot-pass.php"> Forgot Password</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: HOME-->
						<ul id='drop-menu-page' class='dropdown-content'>
							<li><a href="about-us.php"><i class="fa fa-user"></i> About Us</a> </li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='email-temp' data-hover="hover" data-alignm="left"><i class="fa fa-envelop"></i> Email Template</a>
							</li>							
							<li><a href="how-it-work.php"><i class="fa fa-lightbulb-o"></i> How It Work</a> </li>
							<li><a href="advertise.php"><i class="fa fa-buysellads"></i> Advertise with us</a> </li>
							<li><a href="price.php"><i class="fa fa-dollar"></i> Price Details</a> </li>
							<li><a href="customer-reviews.php"><i class="fa fa-star-o"></i> Customer Reviews</a> </li>
							<li><a href="contact-us.php"><i class="fa fa-comments-o"></i> Contact Us</a> </li>
							<li><a href="blog.php"><i class="fa fa-book"></i> Blog Post</a> </li>
							<li><a href="blog-content.php"><i class="fa fa-book"></i> Blog Details</a> </li>
							<li><a href="elements.php"><i class="fa fa-code"></i> All Elements </a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: HOME-->
						<ul id='drop-menu-admin' class='dropdown-content'>
							<li><a href="admin.php"><i class="fa fa-tachometer"></i> Main Admin</a> </li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='adm-dr1' data-hover="hover" data-alignm="left"><i class="fa fa-list-ul"></i> Listing </a>
							</li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='adm-dr2' data-hover="hover" data-alignm="left"><i class="fa fa-user"></i> User</a>
							</li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='adm-dr6' data-hover="hover" data-alignm="left"><i class="fa fa-sign-in"></i> Login Detail</a>
							</li>							
							<li><a href="admin-analytics.php"><i class="fa fa-bar-chart"></i> Analytics</a> </li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='adm-dr3' data-hover="hover" data-alignm="left"><i class="fa fa-buysellads"></i> Ads</a>
							</li>
							<li><a href="admin-payment.php"><i class="fa fa-usd"></i> Payments</a> </li>
							<li><a href="admin-earnings.php"><i class="fa fa-money"></i> Earnings</a> </li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='adm-dr4' data-hover="hover" data-alignm="left"><i class="fa fa-buysellads"></i> Notifications</a>
							</li>
							<li><a class='dropdown-button2 ed-sub-drop-menu' href='#' data-activates='adm-dr5' data-hover="hover" data-alignm="left"><i class="fa fa-tags"></i> Price List</a>
							</li>
							<li><a href="admin-setting.php"><i class="fa fa-cogs" aria-hidden="true"></i> Setting</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: WEB DESIGN-->
						<ul id='adm-dr1' class='dropdown-content'>
							<li><a href="admin-all-listing.php">All listing</a> </li>
							<li><a href="admin-list-add.php">Add New listing</a> </li>
							<li><a href="admin-listing-category.php">All listing Category</a> </li>
							<li><a href="admin-list-category-add.php">Add listing Category</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: WEB DESIGN-->
						<ul id='adm-dr2' class='dropdown-content'>
							<li><a href="admin-all-users.php">All Users</a> </li>
							<li><a href="admin-list-users-add.php">Add New user</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: WEB DESIGN-->
						<ul id='adm-dr3' class='dropdown-content'>
							<li><a href="admin-ads.php">All Ads</a> </li>
							<li><a href="admin-ads-create.php">Create New Ads</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: WEB DESIGN-->
						<ul id='adm-dr4' class='dropdown-content'>
							<li><a href="admin-notifications.php">All Notifications</a> </li>
							<li><a href="admin-notifications-user-add.php">User Notifications</a> </li>
							<li><a href="admin-notifications-push-add.php">Push Notifications</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: WEB DESIGN-->
						<ul id='adm-dr5' class='dropdown-content'>
							<li><a href="admin-price.php">All List Price</a> </li>
							<li><a href="admin-price-list.php">Add New Price</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->
						<!--DROP DOWN MENU: WEB DESIGN-->
						<ul id='adm-dr6' class='dropdown-content'>
							<li><a href="admin-login.php">Admin Login</a> </li>
							<li><a href="admin-register.php">Admin Register</a> </li>
							<li><a href="admin-pass.php">Admin Forgot Pass</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->	
						<!--DROP DOWN MENU: EMAIL TEMPLATE-->
						<ul id='email-temp' class='dropdown-content'>
							<li><a href="email-template-register.php" target="_blank">Register</a> </li>
							<li><a href="email-template-invoice.php" target="_blank">Invoice</a> </li>
							<li><a href="email-listing-submited.php" target="_blank">Listing Submit</a> </li>
							<li><a href="email-subscribe.php" target="_blank">Subscripe</a> </li>
							<li><a href="email-template-email-verification.php" target="_blank">Email Verification</a> </li>
							<li><a href="email-template-forgot-pass.php" target="_blank">Forgot Password</a> </li>
						</ul>
						<!--END DROP DOWN MENU-->						
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="v3-mob-top-menu">
			<div class="container">
				<div class="row">
					<div class="v3-mob-menu">
						<div class="v3-mob-m-1">
							<a href="index.php"><img src="images/logo2.png" alt=""> </a>
						</div>
						<div class="v3-mob-m-2">
							<div class="v3-top-ri">
								<ul>
									<li><a href="login.php" class="v3-menu-sign"><i class="fa fa-sign-in"></i> Sign In</a> </li>
									<li><a href="price.php" class="v3-add-bus"><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
									<li><a href="#" class="ts-menu-5" id="v3-mob-menu-btn"><i class="fa fa-bars" aria-hidden="true"></i>Menu</a> </li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mob-right-nav" data-wow-duration="0.5s">
			<div class="mob-right-nav-close"><i class="fa fa-times" aria-hidden="true"></i> </div>
			<h5>Business</h5>
			<ul class="mob-menu-icon">
				<li><a href="price.php">Add Business</a> </li>
				<li><a href="#!" data-toggle="modal" data-target="#register">Register</a> </li>
				<li><a href="#!" data-toggle="modal" data-target="#sign-in">Sign In</a> </li>
			</ul>
			<h5>All Categories</h5>
			<ul>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Help Services</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Appliances Repair & Services</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Furniture Dealers</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Packers and Movers</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Pest Control </a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Solar Product Dealers</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Interior Designers</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Carpenters</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Plumbing Contractors</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Modular Kitchen</a> </li>
				<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Internet Service Providers</a> </li>
			</ul>
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
	<div id="preloader">
		<div id="status">&nbsp;</div>
	</div>
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
							<li><a href="register.php">Register</a> </li>
							<li><a href="login.php">Sign In</a> </li>
							<li><a href="db-listing-add.php"><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
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
					<div class="ts-menu-2"><a href="#" class="t-bb">All Pages <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<!--SECTION: BROWSE CATEGORY-->
						<div class="cat-menu cat-menu-1">
							<div class="dz-menu">
								<div class="dz-menu-inn">
									<h4>Frontend Pages</h4>
									<ul>
										<li><a href="index.php">Home</a></li>
										<li><a href="index-1.php">Home 1</a></li>
										<li><a href="list.php">All Listing</a></li>
										<li><a href="listing-details.php">Listing Details </a> </li>
										<li><a href="price.php">Add Listing</a> </li>
										<li><a href="list-lead.php">Lead Listing</a></li>
										<li><a href="list-grid.php">Listing Grid View</a></li>
									</ul>
								</div>
								<div class="dz-menu-inn">
									<h4>Frontend Pages</h4>
									<ul>
										<li><a href="new-business.php"> New Listings </a> </li>
										<li><a href="nearby-listings.php">Nearby Listings</a> </li>
										<li><a href="customer-reviews.php"> Customer Reviews</a> </li>
										<li><a href="trendings.php"> Top Trendings</a> </li>
										<li><a href="how-it-work.php"> How It Work</a> </li>
										<li><a href="advertise.php"> Advertise with us</a> </li>
										<li><a href="price.php"> Price Details</a> </li>
									</ul>
								</div>
								<div class="dz-menu-inn">
									<h4>Frontend Pages</h4>
									<ul>
										<li><a href="about-us.php"> About Us</a> </li>
										<li><a href="customer-reviews.php"> Customer Reviews</a> </li>
										<li><a href="contact-us.php"> Contact Us</a> </li>
										<li><a href="blog.php"> Blog Post</a> </li>
										<li><a href="blog-content.php"> Blog Details</a> </li>
										<li><a href="elements.php"> All Elements </a> </li>
										<li><a href="shop-listing-details.php"> Shop Details </a> </li>
										<li><a href="property-listing-details.php"> Property Details </a> </li>
									</ul>
								</div>
								<div class="dz-menu-inn">
									<h4>Dashboard Pages</h4>
									<ul>
										<li><a href="dashboard.php"> Dashboard</a> </li>
										<li><a href="db-invoice.php"> Invoice</a> </li>
										<li><a href="db-setting.php"> User Setting</a> </li>
										<li><a href="db-all-listing.php"> All Listings</a> </li>
										<li><a href="db-listing-add.php"> Add New Listing</a> </li>
										<li><a href="db-review.php"> Listing Reviews</a> </li>
										<li><a href="db-payment.php"> Listing Payments </a> </li>
									</ul>
								</div>
								<div class="dz-menu-inn">
									<h4>Dashboard Pages</h4>
									<ul>
										<li><a href="register.php"> User Register</a> </li>
										<li><a href="login.php"> User Login</a> </li>
										<li><a href="forgot-pass.php"> Forgot Password</a> </li>
										<li><a href="db-message.php"> Messages</a> </li>
										<li><a href="db-my-profile.php"> Dashboard Profile</a> </li>
										<li><a href="db-post-ads.php"> Post Ads </a> </li>
										<li><a href="db-invoice-download.php"> Download Invoice </a> </li>
									</ul>
								</div>
								<div class="dz-menu-inn lat-menu">
									<h4>Admin Panel Pages</h4>
									<ul>
										<li><a target="_blank" href="admin.php"> Admin</a> </li>
										<li><a target="_blank" href="admin-all-listing.php"> All Listing</a> </li>
										<li><a target="_blank" href="admin-all-users.php"> All Users</a> </li>
										<li><a target="_blank" href="admin-analytics.php"> Analytics</a> </li>
										<li><a target="_blank" href="admin-ads.php"> Advertisement</a> </li>
										<li><a target="_blank" href="admin-setting.php"> Admin Setting </a> </li>
										<li><a target="_blank" href="admin-payment.php"> Payments </a> </li>
									</ul>
								</div>
							</div>
							<div class="dir-home-nav-bot">
								<ul>
									<li>A few reasons you’ll love Online Business Directory <span>Call us on: +01 6214 6548</span> </li>
									<li><a href="advertise.php" class="waves-effect waves-light btn-large"><i class="fa fa-bullhorn"></i> Advertise with us</a>
									</li>
									<li><a href="db-listing-add.php" class="waves-effect waves-light btn-large"><i class="fa fa-bookmark"></i> Add your business</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
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
					<!--MOBILE MENU ICON:IT'S ONLY SHOW ON MOBILE & TABLET VIEW-->
					<div class="ts-menu-5"><span><i class="fa fa-bars" aria-hidden="true"></i></span> </div>
					<!--MOBILE MENU CONTAINER:IT'S ONLY SHOW ON MOBILE & TABLET VIEW-->
					<div class="mob-right-nav" data-wow-duration="0.5s">
						<div class="mob-right-nav-close"><i class="fa fa-times" aria-hidden="true"></i> </div>
						<h5>Business</h5>
						<ul class="mob-menu-icon">
							<li><a href="price.php">Add Business</a> </li>
							<li><a href="#!" data-toggle="modal" data-target="#register">Register</a> </li>
							<li><a href="#!" data-toggle="modal" data-target="#sign-in">Sign In</a> </li>
						</ul>
						<h5>All Categories</h5>
						<ul>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Help Services</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Appliances Repair & Services</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Furniture Dealers</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Packers and Movers</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Pest Control </a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Solar Product Dealers</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Interior Designers</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Carpenters</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Plumbing Contractors</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Modular Kitchen</a> </li>
							<li><a href="list.php"><i class="fa fa-angle-right" aria-hidden="true"></i> Internet Service Providers</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

