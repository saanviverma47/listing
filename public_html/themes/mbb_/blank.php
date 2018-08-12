<?php
Assets::add_css( array('bootstrap.min.css', 'layout.css', 'font-awesome.min.css', 'famfamfam-flags.css'));
echo Assets::css();
?>
<title><?php echo $meta_title;?></title>
<?php 
echo Template::content(); 
?>