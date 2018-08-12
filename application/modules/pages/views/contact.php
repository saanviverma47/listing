<!-- main row -->
<div class="row">
	<div class="col-sm-2">
		<div class="row">
			<div class="col-sm-12">
			<!-- Leftside Banner -->		
				 <?php if($banners): $i = 0;?>
				 <?php foreach ($banners as $banner):?>
				 <?php if((($banner['width'] == 190) && ($banner['height'] == 90)) && $banner['location'] == 'left'):?>
				  <?php if(++$i > 2) break; //display only two banners?>
					<div class="row">
					<div class="col-sm-12"><!-- leaderboard col-sm-12 -->
								<?php switch ($banner ['type']) {
									case 'image' : ?>
					 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
					 					id="<?php echo $banner['id'];?>" class="banner thumbnail img-responsive"
										src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
										title="<?php echo $banner['title'];?>"
										alt="<?php echo $banner['title'];?>" /></a>
							<?php break; ?>
							<?php case 'text' :
										echo htmlspecialchars($banner ['html_text']);
										break;
								} ?>
						</div><!-- end of leaderboard col-sm-12 -->
					</div><!-- end of row -->
				<?php endif;?>
				<?php endforeach; ?>
				<?php endif; ?>
				<!-- End of Leftside Banner -->
			</div>
		</div>
	</div><!-- end of left -->
	<div class="col-sm-7">
	<h1><?php echo lang('label_contact_us');?></h1>
	<div id="contact_form" class="row bottom2">
	<div class="col-12 col-sm-12 col-lg-12">
		<p><?php echo lang('query_summary');?></p>
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
	</div><!--/span-->
</div><!--/row-->
	</div><!-- end of middle -->
	<div class="col-sm-3">
		<div class="row">
			<div class="col-sm-12">
				<!-- Leftside Banner -->		
					 <?php if($banners): $i = 0;?>
					 <?php foreach ($banners as $banner):?>
					 <?php if((($banner['width'] == 300) && ($banner['height'] == 250)) && $banner['location'] == 'right'):?>
					  <?php if(++$i > 2) break; //display only two banners?>
						<div class="row">
						<div class="col-sm-12"><!-- leaderboard col-sm-12 -->
									<?php switch ($banner ['type']) {
										case 'image' : ?>
						 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
						 					id="<?php echo $banner['id'];?>" class="banner thumbnail img-responsive"
											src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
											title="<?php echo $banner['title'];?>"
											alt="<?php echo $banner['title'];?>" /></a>
								<?php break; ?>
								<?php case 'text' :
											echo htmlspecialchars($banner ['html_text']);
											break;
									} ?>
							</div><!-- end of leaderboard col-sm-12 -->
						</div><!-- end of row -->
					<?php endif;?>
					<?php endforeach; ?>
					<?php endif; ?>
					<!-- End of Leftside Banner -->
				</div>
			</div>
		</div><!-- end of right -->
	</div><!-- end of row -->