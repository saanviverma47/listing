<?php

Assets::add_js(array(Template::theme_url('js/bootstrap.min.js'), 'jwerty.js', 'jquery.cookie.js'), 'external', true);

echo theme_view('header');

?>
<div class="body">
	<div class="container-fluid">
	    <?php
            echo Template::message();
            echo isset($content) ? $content : Template::content();
        ?>
	</div>
</div>
<?php echo theme_view('footer'); ?>