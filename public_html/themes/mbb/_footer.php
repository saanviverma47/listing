	<!--FOOTER SECTION-->
	<style>
		.help-block{font-size: 11px !important;}
	</style>
	<footer id="colophon" class="site-footer clearfix">
		<div id="quaternary" class="sidebar-container " role="complementary">
			<div class="sidebar-inner">
				<div class="widget-area clearfix">
					<div id="azh_widget-2" class="widget widget_azh_widget">
					<input type="hidden" name="site_url" id="site_url"	value="<?php echo base_url();?>" />
						<div data-section="section">
							<div class="container">
							<!-- end col-sm-2 navigation -->
								<div class="row">
									<?php if(settings_item('site.footer_text') != ""):?>
									<div class="col-sm-2 col-md-2 foot-logo"> <img src="<?php echo Template::theme_url("images/foot-logo.png")?>" alt="logo">
										<?php if(settings_item('site.footer_text') != ""):?>
										<?php endif;?>
									</div>
									<?php endif;?>
									<?php if($menu_links):?>
									<div class="col-sm-3 col-md-3">
										<h4><?php echo lang('footer_navigation');?></h4>
										<ul class="one-columns">
											<li><a href="/aboutus.php">About Us</a> </li>
											<li><a href="/members/add_business" >Add Listing</a> </li>
											<li><a href="/login">Sign In</a> </li>
											<li><a href="/contact" >Contact Us</a> </li>
										</ul>
										</ul>
									</div>
									<?php endif;?>
									<div class="col-sm-4">
										<h4>Address</h4>
										<p>28800 Orchard Lake Road, U.S.A. Landmark : Next To Airport</p>
										<p> <span class="strong">Phone: </span> <span class="highlighted">+01 1245 2541</span> </p>
									</div>
									<div class="col-sm-3 foot-social">
										<h4><?php echo lang('footer_social');?></h4>
										<p>Join the thousands of other There are many variations of passages of Lorem Ipsum available</p>
										<ul>
											<?php if(settings_item('site.facebook_url')):?>
							                	<li class="facebook"><a
													href="<?php echo settings_item('site.facebook_url');?>"
													data-toggle="tooltip" title="Facebook" rel="nofollow" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							                <?php endif;?>
							                <?php if(settings_item('site.twitter_url')):?>
							                     <li class="twitter"><a
													href="<?php echo settings_item('site.twitter_url');?>"
													data-toggle="tooltip" title="Twitter" rel="nofollow" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							                <?php endif;?>
							                <?php if(settings_item('site.googleplus_url')):?>
							                     <li class="gplus"><a
													href="<?php echo settings_item('site.googleplus_url');?>"
													data-toggle="tooltip" title="Google Plus" rel="nofollow" target="_blank"><i
														class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							                <?php endif;?>
							                <?php if(settings_item('site.youtube_url')):?>
							                     <li class="youtube"><a
													href="<?php echo settings_item('site.youtube_url');?>"
													data-toggle="tooltip" title="Youtube" rel="nofollow" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
							                <?php endif;?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<!-- .widget-area -->
			</div>
			<!-- .sidebar-inner -->
		</div>
		<!-- #quaternary -->
	</footer>
	<!--COPY RIGHTS-->
	<section class="copy">
		<div class="container">
			<p>Copyright &copy; 2018 MBB </p>
		</div>
	</section>
	<!--QUOTS POPUP-->
	<!--SCRIPT FILES-->

	<?php echo Assets::js(); ?>
	
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo Template::theme_url("js/jquery-latest.min.js")?>"><\/script>')</script>
	
	<script src="<?php echo Template::theme_url("js/bootstrap.js")?>" type="text/javascript"></script>
	<script src="<?php echo Template::theme_url("js/materialize.min.js")?>" type="text/javascript"></script>
	<script src="<?php echo Template::theme_url("js/jquery.cookie.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/selectize.min.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/bootstrap-typeahead.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/jquery.easyPaginate.js")?>"></script>
	<!--<script src="<?php //echo Template::theme_url("js/jquery.cookie.js")?>"></script>
	<script src="<?php //echo Template::theme_url("js/selectize.min.js")?>"></script>
	<script src="<?php //echo Template::theme_url("js/bootstrap-typeahead.js")?>"></script>-->
	<script src='<?php echo Template::theme_url("js/intlTelInput.min.js")?>' type='text/javascript'></script>
	<script src='<?php echo Template::theme_url("js/ontype_location_search.js")?>' type='text/javascript'></script>
	<script src="<?php echo Template::theme_url("js/custom.js")?>"></script>
	
	<script>
		$('#easyPaginate').easyPaginate({
			paginateElement: 'li',
			elementsPerPage: 12,
			effect: 'climb'
		});
	</script>
	
</body>

</html>