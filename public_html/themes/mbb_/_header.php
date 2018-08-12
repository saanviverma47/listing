<?php
	// get last selected theme from user
    Assets::add_js( array('bootstrap.min.js', 'selectize.min.js', 'theme-switcher.js', 'metisMenu.js', 'jquery.cookie.js', 'bootstrap-typeahead.min.js', 'jquery.redirect.js', 'custom.js') );
    if((settings_item('adv.search_blocks') == 2) || (settings_item('adv.search_blocks') == 3 )) {
    	Assets::add_js('ontype_location_search.js');
    } else {
    	Assets::add_js('default_search.js');
    }
    Assets::add_css( array('bootstrap.min.css', 'font-awesome.min.css', 'selectize.bootstrap3.css', 'famfamfam-flags.css', 'layout.css', 'yellow_theme.css'));
    $inline = '$(".nav-tabs a:first").tab("show")';

    Assets::add_js( $inline, 'inline' );
?>
<!doctype html>
<head>
    <meta charset="utf-8">

    <title><?php echo !empty($page_title) ? $page_title .' : ' : settings_item('site.meta_title'); ?> <?php if (class_exists('Settings_lib')) e(settings_item('site.title')); else echo 'mbb'; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : settings_item('site.meta_description'); ?>">
    <meta name="keywords" content="<?php echo isset($page_keywords) ? $page_keywords : settings_item('site.meta_keywords'); ?>">
    <meta name="author" content="<?php echo settings_item('site.meta_title'); ?>">

    <?php echo Assets::css(); ?>
    
    <script type="text/javascript" src="<?php echo Template::theme_url("js/respond.min.js")?>" ></script>
     <script type="text/javascript">
    /*----------------------------------------------------*/
	/*	Google Analytics Code
	/*----------------------------------------------------*/
	
	</script>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
</head>
<body>