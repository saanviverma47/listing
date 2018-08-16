	<!--FOOTER SECTION-->
	<footer id="colophon" class="site-footer clearfix">
		<div id="quaternary" class="sidebar-container " role="complementary">
			<div class="sidebar-inner">
				<div class="widget-area clearfix">
					<div id="azh_widget-2" class="widget widget_azh_widget">
						<div data-section="section">
							<div class="container">
							<!-- end col-sm-2 navigation -->
								<div class="row">
									<?php if(settings_item('site.footer_text') != ""):?>
									<div class="col-sm-4 col-md-3 foot-logo"> <img src="<?php echo Template::theme_url("images/foot-logo.png")?>" alt="logo">
										<?php if(settings_item('site.footer_text') != ""):?>
										<?php endif;?>
									</div>
									<?php endif;?>
									<?php if($menu_links):?>
									<div class="col-sm-4 col-md-6">
										<h4><?php echo lang('footer_navigation');?></h4>
										<ul class="two-columns">
											<li><a href="aboutus.php">About Us</a> </li>
											<li><a href="register.php">Register</a> </li>
											<li><a href="/members/add_business" >Add Listing</a> </li>
											<li><a href="login">Sign In</a> </li>
											<li><a href="contactus.php" >Contact Us</a> </li>
										</ul>
										</ul>
									</div>
									<?php endif;?>
								</div>
							</div>
						</div>
						<div data-section="section" class="foot-sec2">
							<div class="container">
								<div class="row">
									<div class="col-sm-3">
										<h4>Payment Options</h4>
										<p class="hasimg"> <img src="images/payment.png" alt="payment"> </p>
									</div>
									<div class="col-sm-4">
										<h4>Address</h4>
										<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A. Landmark : Next To Airport</p>
										<p> <span class="strong">Phone: </span> <span class="highlighted">+01 1245 2541</span> </p>
									</div>
									<div class="col-sm-5 foot-social">
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
	<section>
		<!-- GET QUOTES POPUP -->
		<div class="modal fade dir-pop-com" id="list-quo" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header dir-pop-head">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h4 class="modal-title">Get a Quotes</h4>
						<!--<i class="fa fa-pencil dir-pop-head-icon" aria-hidden="true"></i>-->
					</div>
					<div class="modal-body dir-pop-body">
						<form method="post" class="form-horizontal">
							<!--LISTING INFORMATION-->
							<div class="form-group has-feedback ak-field">
								<label class="col-md-4 control-label">Full Name *</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="fname" placeholder="" required> </div>
							</div>
							<!--LISTING INFORMATION-->
							<div class="form-group has-feedback ak-field">
								<label class="col-md-4 control-label">Mobile</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="mobile" placeholder=""> </div>
							</div>
							<!--LISTING INFORMATION-->
							<div class="form-group has-feedback ak-field">
								<label class="col-md-4 control-label">Email</label>
								<div class="col-md-8">
									<input type="text" class="form-control" name="email" placeholder=""> </div>
							</div>
							<!--LISTING INFORMATION-->
							<div class="form-group has-feedback ak-field">
								<label class="col-md-4 control-label">Message</label>
								<div class="col-md-8 get-quo">
									<textarea class="form-control"></textarea>
								</div>
							</div>
							<!--LISTING INFORMATION-->
							<div class="form-group has-feedback ak-field">
								<div class="col-md-6 col-md-offset-4">
									<input type="submit" value="SUBMIT" class="pop-btn"> </div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- GET QUOTES Popup END -->
	</section>
	<!--SCRIPT FILES-->
	<script src="<?php echo Template::theme_url("js/jquery.min.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/bootstrap.js")?>" type="text/javascript"></script>
	<script src="<?php echo Template::theme_url("js/materialize.min.js")?>" type="text/javascript"></script>
	<script src="<?php echo Template::theme_url("js/custom.js")?>"></script>
</body>

</html>