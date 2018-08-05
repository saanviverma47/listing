<!DOCTYPE html>
<html lang="en">

<head>
	<title>World Best Local Directory Website template</title>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href="images/fav.ico" type="image/x-icon">
	<!-- GOOGLE FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
	<!-- FONTAWESOME ICONS -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- ALL CSS FILES -->
	<link href="css/materialize.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
	<link href="css/responsive.css" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
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