<?php echo theme_view('install/_header'); ?>
<?php echo theme_view('install/_sitenav'); ?>

<?php    
     echo isset($content) ? $content : Template::content();
?>
<?php echo theme_view('install/_footer'); ?>