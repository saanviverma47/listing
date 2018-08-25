	<!--FOOTER SECTION-->
	<style>
		.help-block{font-size: 11px !important;}
	</style>
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
						<h4 class="modal-title">Ask Query</h4>
						<div id="businessFormMessage"></div>
						<!--<i class="fa fa-pencil dir-pop-head-icon" aria-hidden="true"></i>-->
					</div>
					<div class="modal-body dir-pop-body">
						<form method="post" id="businessQueryForm">
							<div class="form-group has-feedback">
								<label class="control-label" for="message"><?php echo lang('label_message');?>*</label>
								<textarea rows="5" cols="30" class="form-control input-sm"
									id="message" name="message" placeholder="<?php echo lang('placeholder_message');?>"></textarea>
								<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_message'));?></span>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-lg-12">
									<div class="form-group has-feedback">
										<label class="control-label" for="name"><?php echo lang('label_name');?>*</label> <input
											type="text" class="form-control input-sm" id="name"
											name="name" placeholder="<?php echo lang('placeholder_name');?>" /> <span
											class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_name'));?></span>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-lg-12">
									<div class="form-group has-feedback">
										<label class="control-label" for="phone"><?php echo lang('label_phone');?></label> <input
											type="tel" class="form-control input-sm optional" id="phone"
											name="phone" placeholder="<?php echo lang('placeholder_phone');?>" /> <span
											class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_phone'));?></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-lg-12">
									<div class="form-group has-feedback">
										<label class="control-label" for="email"><?php echo lang('label_email');?></label>
										<input type="email" class="form-control input-sm" id="email"
											name="email" placeholder="<?php echo lang('placeholder_email');?>" /> <span
											class="help-block" style="display: none;"><?php echo lang('error_message_email');?></span>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-lg-12">
									<div class="row">
										<div class="col-7 col-md-7 col-lg-7">
											<div class="form-group has-feedback">
												<label class="control-label" for="captcha_code"><?php echo lang('label_captcha');?></label> <input type="text"
													class="form-control input-sm" name="captcha_code"
													id="captcha_code" placeholder="<?php echo lang('placeholder_captcha');?>" /> <span
													class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
											</div>
											<span class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
										</div>
										<div class="col-5 col-md-5 col-lg-5">
											<img class="img-thumbnail" id="captcha"
												src="<?php echo site_url("securimage"); ?>"
												alt="CAPTCHA Image" /> <a id="update" href="#"
												onclick="document.getElementById('captcha').src = '<?php echo site_url("securimage?"); ?>' + Math.random(); return false"><i
												class="glyphicon glyphicon-refresh"></i></a>
										</div>
									</div>
								</div>
							</div>
							<button type="submit" id="feedbackSubmit"
								class="btn btn-primary btn-sm" data-loading-text="Sending..."
								style="display: block; margin-top: 10px;"><?php echo lang('business_query');?></button>
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
	<script src="<?php echo Template::theme_url("js/jquery.cookie.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/selectize.min.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/bootstrap-typeahead.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/custom.js")?>"></script>
	<!--<script src="<?php echo Template::theme_url("js/jquery.cookie.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/selectize.min.js")?>"></script>
	<script src="<?php echo Template::theme_url("js/bootstrap-typeahead.js")?>"></script>-->
	
	<?php echo Assets::js(); ?>
	
</body>

</html>