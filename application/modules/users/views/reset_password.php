<div class="row"><!-- start of main row -->
<div class="col-md-8 col-sm-8">
<div class="row">
<div class="container">
		<br>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-2 ">
				<div class="alert alert-info fade in">
					<h4 class="alert-heading"><?php echo lang('us_reset_password_note'); ?></h4>
					<?php echo Template::message(); ?>
				</div>
				<?php if (validation_errors()) : ?>
					<div class="alert alert-error fade in">
						<?php echo validation_errors(); ?>
					</div>
				<?php endif; ?>
				<div class="panel panel-info">
				<div class="panel-heading">
						<div class="panel-title"><h3 class="text-center"><?php echo lang('us_reset_password');?></h3></div>
					</div>
					<div class="panel-body">
						<div class="text-center">
							<div class="panel-body">

								<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
								<input type="hidden" name="user_id" value="<?php echo $user->id ?>" />
									<fieldset>
										<div class="form-group">
											<div class="input-group <?php echo iif( form_error('pass_confirm') , 'error') ;?>" style="padding-top:10px;">
												<span class="input-group-addon"><i
													class="glyphicon glyphicon-lock "></i></span> <input type="password"
													id="password" name="password" placeholder=" <?php echo lang('bf_password'); ?>"
													class="form-control">													
											</div>
											<small><p class="help-block"><?php echo lang('us_password_mins'); ?></p></small>
											<div class="input-group <?php echo iif( form_error('pass_confirm') , 'error') ;?>" style="padding-top:10px;">
												<span class="input-group-addon"><i
													class="glyphicon glyphicon-lock"></i></span> <input type="password"
													id="pass_confirm" name="pass_confirm" placeholder="<?php echo lang('bf_password_confirm'); ?>"
													class="form-control">
											</div>
										</div><br />
										<div class="form-group">
											<input class="btn btn-lg btn-primary btn-block"
												value="<?php e(lang('us_set_password')); ?>" type="submit" name="set_password" id="submit">
										</div>
									</fieldset>
								<?php echo form_close(); ?>
								<!--/end form-->

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- end of right hand column row -->
</div><!-- end of right hand column col-md-6 -->
<div class="col-md-4 col-sm-4">
<?php if($banners): $i = 0;?>
		 <?php foreach ($banners as $banner):?>
		 <?php if(((($banner['width'] <= 300) && ($banner['height'] <= 250)) || (($banner['width'] <= 336) && ($banner['height'] <= 280))) && ($banner['location'] == 'right')):?>
		 <?php if(++$i > 2) break; //display only two banners?>		 
				<div class="row">
				<div class="col-sm-12 centered-text">
					<div class="panel panel-default">
						<div class="panel-body">
			 		<?php switch ($banner ['type']) {
							case 'image' : ?>
			 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
			 					id="<?php echo $banner['id'];?>" class="img-responsive center-block banner"
								src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
								title="<?php echo $banner['title'];?>"
								alt="<?php echo $banner['title'];?>" /></a>
					<?php break; ?>
					<?php case 'html' :
								echo $banner ['html_text'];
								break;
							case 'text' :
								echo htmlspecialchars($banner ['html_text']);
								break;
						} ?>
						</div> <!-- end of panel-body -->
					</div> <!-- end of panel -->
				</div><!-- end of col-sm-12 -->
				</div> <!-- end of row -->
		<?php endif;?>
		<?php endforeach; ?>
		<?php endif; ?>
</div><!-- end of left hand column col-md-6 -->

</div><!-- end of main row -->