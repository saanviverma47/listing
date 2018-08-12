<?php 
	echo theme_view('_header');
	echo isset ( $content ) ? $content : Template::content ();
	echo theme_view('_footer'); 
?>