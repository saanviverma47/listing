<?php
	if($_SERVER['REQUEST_URI'] != "/"){
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
	<link rel='stylesheet' type='text/css' href='<?php echo Template::theme_url("css/intlTelInput.css")?>' media='screen' />
	<link href="<?php echo Template::theme_url("css/materialize.css")?>" rel="stylesheet">
	<link href="<?php echo Template::theme_url("css/style.css")?>" rel="stylesheet">
	<link href="<?php echo Template::theme_url("css/bootstrap.css")?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo Template::theme_url("css/responsive.css")?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo Template::theme_url("css/star-rating.min.css")?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo Template::theme_url("css/flags.css")?>" rel="stylesheet">
	
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
</head>

<style>
	.alert-error {
		background-color: #f2dede;
		border-color: #ebccd1;
		color: #a94442;
	}
	.alert-dismissable, .alert-dismissible {
		padding-right: 35px;
	}
	.alert {
		padding: 15px;
		margin-bottom: 20px;
		border: 1px solid transparent;
		border-radius: 4px;
	}
	.help-block>p {
		display: block;
		margin-top: 5px;
		margin-bottom: 10px;
		color: #FF523F;
	}
	.help-block>p {
		font-size: 11px !important;
	}
	#options>.select-wrapper{display:none;}
	#options>button>.caret{display:none;}
</style>

<body>
	<section>
		<div class="v3-top-menu">
			<div class="container">
				<div class="row">
					<div class="v12-menu">
						<div class="v12-m-1">
							<a href="/" style="passing-top:3px;"><img src="<?php echo Template::theme_url("images/logo2.png"); ?>" alt=""> </a>
							<div class="dir-ho-tr" style="float: right; ">
								<ul >
									<li><a href="/aboutus.php" style="color: #000;">About Us</a> </li>
									<li></li>
									<li><a href="/members/add_business" ><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
									<li><a href="/login" style="color: #000;">Sign In</a> </li>
									<li><a href="/contact" style="color: #000;">Contact Us</a> </li>
									<li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>
									<li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>
									<li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>
									<li><div id="options" data-input-name="country2" data-selected-country="US"></div></li>
									
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
	<link href="<?php echo Template::theme_url("css/responsive.css")?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo Template::theme_url("css/star-rating.min.css")?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo Template::theme_url("css/flags.css")?>" rel="stylesheet">
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS 
	<link href="css/responsive.css" rel="stylesheet"> -->
	
</head>

<body>
	<!--PRE LOADING-->
	<!--BANNER AND SERACH BOX-->
	<section id="background" class="dir1-home-head">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="dir-ho-tl">
						<ul>
							<li>
								<a href="/"><img src="<?= base_url(); ?>assets/images/<?= settings_item('site.logo');?>" alt=""> </a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-9 col-sm-9">
					<div class="dir-ho-tr">
						<ul>
							<li><a href="/aboutus.php">About Us</a> </li>
							<li><a href="/register.php">Register</a> </li>
							<li><a href="/members/add_business"><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
							<li><a href="/login">Sign In</a> </li>
							<li><a href="/contactus.php">Contact Us</a> </li>
							<li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>
									<li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>
									<li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>
									<li><div id="options" data-input-name="country2" data-selected-country="US"></div></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container dir-ho-t-sp">
			<div class="row">
				<div class="dir-hr1">
					<div class="dir-ho-t-tit">
						<h1 style='font-size:40px;'>Connect with the right Service Experts</h1> 
						<p>Find B2B & B2C businesses contact addresses, phone numbers,<br> user ratings and reviews.</p>
					</div>
					<?php if(settings_item('adv.search_blocks') == 1):?>
						<form class="tourz-search-form" role="search" method="post"	id="search-form" action="<?php echo base_url('listings/search');?>" name="search-form">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
						<input type="hidden" name="search-country" id="search-country" value="<?php echo $default_country;?>" />
			    		<input type="hidden" name="search-state" id="search-state" value="<?php echo $default_state; ?>" />
						<div class="input-field">
							<select name="select-city" id="select-city" class="demo-default span6"	placeholder="<?php echo lang('header_select_city');?>">
								<option value =""><?php echo lang('header_select_city');?></option>
								<?php if($cities):?>
								<?php foreach($cities as $city): ?>
									<option value ="<?php echo $city->id;?>" <?php echo (isset($default_city) && ($default_city==$city->id)) ? 'selected': ''; ?>><?php echo $city->name;?></option>
								<?php endforeach; ?>
								<?php endif;?>
							</select>
						</div>
						
						<div class="input-field">
							<select id="select-locality" name="select-locality" class="demo-default span6"	placeholder="<?php echo lang('header_select_locality');?>">
								<option value ="-1" <?php echo (isset($search_locality) && ($search_locality == -1)) ? 'selected': ''; ?>><?php echo lang('header_select_locality');?></option>
								<?php if($localities):?>
								<?php foreach($localities as $locality): ?>
									<option value ="<?php echo $locality->id;?>" <?php echo (isset($search_locality) && ($search_locality == $locality->id)) ? 'selected': ''; ?>><?php echo $locality->name;?></option>
								<?php endforeach; ?>
								<?php endif;?>
							</select>
						</div>
						<div class="input-field">
							<input type="submit" value="search" id="searchSubmit" name="searchSubmit" class="waves-effect waves-light tourz-sear-btn"> 
						</div>
					</form>
					<?php elseif(settings_item('adv.search_blocks') == 3): ?>
						<form class="tourz-search-form" role="search" method="post"	id="search-form" action="<?php echo base_url('listings/search');?>" name="search-form">
							<div class="input-field">
								<input type="text" id="select-city" class="autocomplete1" name="location" value="<?php echo isset($search_location) ? $search_location : '';?>">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
								<label for="select-city">Enter city</label>
							</div>
							<div class="input-field">
								<input type="text" id="select-search" name="search" value="<?php echo isset($searchterm) ? $searchterm : '';?>" class="autocomplete">
								<label for="select-search" class="search-hotel-type">Search your services like hotel, resorts, events and more</label>
							</div>
							<div class="input-field">
								<input type="submit" value="search" class="waves-effect waves-light tourz-sear-btn" id="searchSubmit" name="searchSubmit"> 
							</div>
						</form>
					<?php elseif(settings_item('adv.search_blocks') == 2):?>
							<form class="tourz-search-form" role="search" method="post"	id="search-form" action="<?php echo base_url('listings/search');?>" name="search-form">
								<div class="input-field">
									<input type="text" id="select-city" class="autocomplete1" name="location" value="<?php echo isset($search_location) ? $search_location : '';?>">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
									<label for="select-city">Enter city</label>
								</div>
								<div class="input-field">
									<input type="text" id="select-search" name="search" value="<?php echo isset($searchterm) ? $searchterm : '';?>" class="autocomplete">
									<label for="select-search" class="search-hotel-type">Search your services like hotel, resorts, events and more</label>
								</div>
								<div class="input-field">
									<input type="submit" value="search" class="waves-effect waves-light tourz-sear-btn" id="searchSubmit" name="searchSubmit"> 
								</div>
							</form>

					<?php endif;?>
				</div>
			</div>
		</div>
	</section>
	<!--TOP SEARCH SECTION-->
	<style>
		.waves-input-wrapper .waves-button-input {
			position: relative;
			top: 0;
			left: 0;
			z-index: 1;
			width: 100% !important;
		}
	</style>
	<section id="myID" class="bottomMenu hom-top-menu">
		<div class="container top-search-main">
			<div class="row">
				<div class="ts-menu">
					<!--SECTION: LOGO-->
					<div class="ts-menu-1">
						<a href="/"><img src="<?php echo Template::theme_url("images/aff-logo.png")?>" alt=""> </a>
					</div>
					<!--SECTION: BROWSE CATEGORY(NOTE:IT'S HIDE ON MOBILE & TABLET VIEW)-->
					<!--SECTION: SEARCH BOX-->
					<div class="ts-menu-3">
						<div class="">
						<?php if(settings_item('adv.search_blocks') == 1):?>
								<form class="tourz-search-form tourz-top-search-form" role="search" method="post"	id="search-form" action="<?php echo base_url('listings/search');?>" name="search-form">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
								<input type="hidden" name="search-country" id="search-country" value="<?php echo $default_country;?>" />
								<input type="hidden" name="search-state" id="search-state" value="<?php echo $default_state; ?>" />
								<div class="input-field">
									<select name="select-city" id="select-city" class="demo-default span6"	placeholder="<?php echo lang('header_select_city');?>">
										<option value =""><?php echo lang('header_select_city');?></option>
										<?php if($cities):?>
										<?php foreach($cities as $city): ?>
											<option value ="<?php echo $city->id;?>" <?php echo (isset($default_city) && ($default_city==$city->id)) ? 'selected': ''; ?>><?php echo $city->name;?></option>
										<?php endforeach; ?>
										<?php endif;?>
									</select>
								</div>
								
								<div class="input-field">
									<select id="select-locality" name="select-locality" class="demo-default span6"	placeholder="<?php echo lang('header_select_locality');?>">
										<option value ="-1" <?php echo (isset($search_locality) && ($search_locality == -1)) ? 'selected': ''; ?>><?php echo lang('header_select_locality');?></option>
										<?php if($localities):?>
										<?php foreach($localities as $locality): ?>
											<option value ="<?php echo $locality->id;?>" <?php echo (isset($search_locality) && ($search_locality == $locality->id)) ? 'selected': ''; ?>><?php echo $locality->name;?></option>
										<?php endforeach; ?>
										<?php endif;?>
									</select>
								</div>
								<div class="input-field">
									<input type="submit" value="search" id="searchSubmit" name="searchSubmit" class="waves-effect waves-light tourz-sear-btn"> 
								</div>
							</form>
							<?php elseif(settings_item('adv.search_blocks') == 3): ?>
								<form class="tourz-search-form tourz-top-search-form"" role="search" method="post"	id="search-form" action="<?php echo base_url('listings/search');?>" name="search-form">
									<div class="input-field">
										<input type="text" id="top-select-city" class="autocomplete1" name="location" value="<?php echo isset($search_location) ? $search_location : '';?>">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
										<label for="top-select-city">Enter city</label>
									</div>
									<div class="input-field">
										<input type="text" id="top-select-search" name="search" value="<?php echo isset($searchterm) ? $searchterm : '';?>" class="autocomplete1">
										<label for="top-select-search" class="search-hotel-type">Search your services like hotel, resorts, events and more</label>
									</div>
									<div class="input-field">
										<input type="submit" value="" id="searchSubmit" name="searchSubmit" class="waves-effect waves-light tourz-top-sear-btn"> 
									</div>
								</form>
							<?php elseif(settings_item('adv.search_blocks') == 2):?>
									<form class="tourz-search-form tourz-top-search-form" role="search" method="post"	id="search-form" action="<?php echo base_url('listings/search');?>" name="search-form">
										<div class="input-field">
											<input type="text" id="top-select-city" class="autocomplete1" name="location" value="<?php echo isset($search_location) ? $search_location : '';?>">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
											<label for="select-city">Enter city</label>
										</div>
										<div class="input-field">
											<input type="text" id="top-select-search" name="search" value="<?php echo isset($searchterm) ? $searchterm : '';?>" class="autocomplete">
											<label for="top-select-search" class="search-hotel-type">Search your services like hotel, resorts, events and more</label>
										</div>
										<div class="input-field">
											<input type="submit" value="" style='width: 100%;' class="waves-effect waves-light tourz-top-sear-btn" id="searchSubmit" name="searchSubmit"> 
										</div>
									</form>

							<?php endif;?>
						</div>
					</div>
					<!--SECTION: REGISTER,SIGNIN AND ADD YOUR BUSINESS-->
					<div class="ts-menu-4">
						<div class="v3-top-ri">
							<ul>
								<li><a href="login" class="v3-menu-sign"><i class="fa fa-sign-in"></i> Sign In</a> </li>
								<li><a href="/members/add_business" class="v3-add-bus"><i class="fa fa-plus" aria-hidden="true"></i> Add Listing</a> </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

