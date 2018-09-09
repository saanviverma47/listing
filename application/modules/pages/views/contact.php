<script type="text/javascript" src="<?php echo Template::theme_url("js/respond.min.js")?>" ></script>	

	<section>
		<div class="con-page">
			<div class="con-page-ri">
			<div class="row bottom2">
				<div class="con-com" style='display:none;'>
					<h4 class="con-tit-top-o">Address & Contact Info</h4>
					<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A. Landmark : Next To Airport</p> <span><img src="images/icon/phone.png" alt="" /> Phone: +01 3214 6581</span> <span><img src="images/icon/mail.png" alt="" /> Email: support@listing.com</span>
					<h4>Follow us on</h4>
					<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here</p>
					<div class="share-btn">
						<ul>
							<li><a href="#"><i class="fa fa-facebook fb1"></i> Share On Facebook</a> </li>
							<li><a href="#"><i class="fa fa-twitter tw1"></i> Share On Twitter</a> </li>
							<li><a href="#"><i class="fa fa-google-plus gp1"></i> Share On Google Plus</a> </li>
						</ul>
					</div>
				</div>
			</div>
			<div id="contact_form" class="row bottom2">
				<div class="con-com">
					<div class="cpn-pag-form">
					<div id="contactUsMessage"></div>
						<form role="form" id="contactUsForm">
							<div class="form-group has-feedback">
								<label class="control-label" for="message"><?php echo lang('label_message');?>*</label>
								<textarea rows="5" cols="30" class="form-control input-sm"
									id="message" name="message"
									placeholder="<?php echo lang('placeholder_message');?>"></textarea>
								<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_message'));?></span>
							</div>
							<div class="row">
								<div class="col-6 col-sm-6 col-lg-6">
									<div class="form-group has-feedback">
										<label class="control-label" for="name"><?php echo lang('label_name');?>*</label>
										<input type="text" class="form-control input-sm" id="name"
											name="name" placeholder="<?php echo lang('placeholder_name');?>" />
										<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_name'));?></span>
									</div>
								</div>
								<div class="col-6 col-sm-6 col-lg-6">
									<div class="form-group has-feedback">
										<label class="control-label" for="phone"><?php echo lang('label_phone');?></label>
										<input type="tel" class="form-control input-sm optional"
											id="phone" name="phone"
											placeholder="<?php echo lang('placeholder_phone');?>" /> <span
											class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_phone'));?></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6 col-sm-6 col-lg-6">
									<div class="form-group has-feedback">
										<label class="control-label" for="email"><?php echo lang('label_email');?></label>
										<input type="email" class="form-control input-sm" id="email"
											name="email"
											placeholder="<?php echo lang('placeholder_email');?>" /> <span
											class="help-block" style="display: none;"><?php echo lang('error_message_email');?></span>
									</div>
								</div>
								<div class="col-6 col-sm-6 col-lg-6">
									<div class="row">
										<div class="col-7 col-md-7 col-lg-7">
											<div class="form-group has-feedback">
												<label class="control-label" for="captcha_code"><?php echo lang('label_captcha');?></label>
												<input type="text" class="form-control input-sm"
													name="captcha_code" id="captcha_code"
													placeholder="<?php echo lang('placeholder_captcha');?>" /> <span
													class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
											</div>
											<span class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
										</div>
										<div class="col-5 col-md-5 col-lg-5">
											<img class="img-thumbnail" id="captcha"
												src="<?php echo site_url("securimage"); ?>"
												alt="CAPTCHA Image" /><span class="text-info small text-center pull-right"><?php echo lang('captcha_refresh');?> <a id="update" href="#"
												onclick="document.getElementById('captcha').src = '<?php echo site_url("securimage?"); ?>' + Math.random(); return false"><i
												class="glyphicon glyphicon-refresh"></i></a></span>
										</div>
									</div>
								</div>
							</div>
							<button type="submit" id="contactSubmit"
								class="btn btn-primary btn-sm" data-loading-text="Sending..."
								style="display: block; margin-top: 10px;"><?php echo lang('business_query');?></button>
						</form>
								
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>