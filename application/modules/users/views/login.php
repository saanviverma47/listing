<?php
 
 
 
 
 
 
 
 
 
 
 
 

$site_open = $this->settings_lib->item ( 'auth.allow_register' );
$validation_errors = validation_errors();
$errorClass = ' error';
$controlClass = 'form-control';
$fieldData = array(
		'errorClass'    => $errorClass,
		'controlClass'  => $controlClass,
);
?>
<div class="row"><!-- start of main row -->
<div class="col-md-8 col-sm-8">
<div class="row">
<div class="container-fluid">
	<div id="loginbox" style="margin-top: 10px;"
		class="mainbox col-md-8 col-md-offset-2 col-sm-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title"><?php echo lang('label_sign_in');?></div>
				<div style="float: right; font-size: 80%; position: relative; top: -10px">
					<a href="#" id="reset_password_box"><?php echo lang('us_forgot_your_password'); ?></a>					
				</div>
			</div>
			<div style="padding-top: 30px" class="panel-body">
			<?php echo Template::message(); ?>
			<?php if(isset($_POST['log-me-in'])):?>
			<?php if (validation_errors ()) : ?>
				<div style="display: none" id="login-alert"
					class="alert alert-danger col-sm-12">
					<a data-dismiss="alert" class="close">&times;</a>
					<?php echo validation_errors(); ?>
				</div>
			<?php endif; ?>
			<?php endif;?>
			<?php echo form_open(LOGIN_URL, array('id' => 'loginform', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
					<div style="margin-bottom: 25px" class="input-group <?php echo iif( form_error('login') , 'error') ;?>">
						<span class="input-group-addon"><i
							class="glyphicon glyphicon-user"></i></span> <input
							id="login_value" type="text" class="form-control"
							name="login" value="<?php echo set_value('login'); ?>" tabindex="1"
							placeholder="<?php echo $this->settings_lib->item('auth.login_type') == 'both' ? lang('bf_username') .'/'. lang('bf_email') : ucwords($this->settings_lib->item('auth.login_type')) ?>">
					</div>
					<div style="margin-bottom: 25px" class="input-group <?php echo iif( form_error('password') , 'error') ;?>">
						<span class="input-group-addon"><i
							class="glyphicon glyphicon-lock"></i></span> <input
							id="password" type="password" class="form-control" tabindex="2"
							name="password" placeholder="<?php echo lang('bf_password'); ?>">
					</div>
					<?php if ($this->settings_lib->item('auth.allow_remember')) : ?>
					<div class="input-group">
						<div class="checkbox">
							<label> <input id="remember_me" type="checkbox"
								name="remember_me" value="1" tabindex="3"> 
								<span class="inline-help"><?php echo lang('us_remember_note'); ?></span>
							</label>
						</div>
					</div>
					<?php endif; ?>
										
					<div style="margin-top: 10px" class="form-group">
						<!-- Button -->

						<div class="col-sm-12 controls">
						<input class="btn btn-sm btn-success" type="submit" name="log-me-in" id="submit"
								value="<?php e(lang('us_let_me_in')); ?>" tabindex="5" />
								<input type="reset" class="btn btn-sm btn-primary" value="Reset"/>
						</div>
					</div>
					<?php echo form_close(); ?>
					<div class="form-group">
						<div class="col-md-12 control">
							<div
								style="border-top: 1px solid #888; padding-top: 15px; font-size: 85%">
								<?php echo lang('label_no_account');?>
								<a href="#" id="signup_box"> <?php echo lang('us_sign_up');?></a>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
	<div id="passwordresetbox" style="display: none; margin-top: 10px"
		class="mainbox col-md-8 col-md-offset-2 col-sm-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title"><?php echo lang('us_reset_password'); ?></div>
				<div
					style="float: right; font-size: 85%; position: relative; top: -10px">
					<a id="signin_box" href="#"><?php echo lang('label_sign_in');?></a>
				</div>
			</div>
			<div class="panel-body">
			<?php if(isset($_POST['send'])):?>
			<?php echo Template::message(); ?>
			<?php if (validation_errors()) : ?>
					<div id="passwordresetalert"
						class="alert alert-danger">
						<p><?php echo validation_errors(); ?></p>
						<span></span>
					</div>
				<?php endif; ?>
				<?php endif; ?>
				<?php echo form_open(site_url('forgot_password'), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>				
				<div class="alert alert-info fade in">
					<?php echo lang('us_reset_note'); ?>
				</div>
				
					<div class="form-group <?php echo iif( form_error('email') , 'error'); ?>">
						<label for="email" class="col-md-3 control-label required"><?php echo lang('bf_email'); ?></label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email') ?>"
								placeholder="<?php echo lang('placeholder_email');?>">
						</div>
					</div>
					<div class="form-group">
						<!-- Button -->
						<div class="col-md-offset-3 col-md-9">
							<input class="btn btn-primary" type="submit" name="send" value="<?php e(lang('us_send_password')); ?>" />
						</div>
					</div>
					
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
<div id="signupbox" style="display: none; margin-top: 10px"
	class="mainbox col-md-8 col-md-offset-2 col-sm-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title"><?php echo lang('us_sign_up'); ?></div>			
			<div
				style="float: right; font-size: 85%; position: relative; top: -10px">
				<a id="signin_box" href="#"><?php echo lang('label_sign_in');?></a>
			</div>
		</div>
		<div class="panel-body">
			<?php echo Template::message(); ?>
			<?php if(isset($_POST['register'])):?>			
			<?php if ($validation_errors) : ?>
				<div id="signupalert"
					class="alert alert-danger">
					<p><?php echo $validation_errors; ?></p>
					<span></span>
				</div>
			<?php endif; ?>
			<?php endif; ?>
			<div class="alert alert-info fade in">
        		<span class="alert-heading"><?php echo lang('bf_required_note'); ?></span>
        		<?php if (isset($password_hints)) { echo $password_hints; } ?>
    		</div>
    		<?php echo form_open( site_url(REGISTER_URL), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
				<?php Template::block('user_fields', 'user_fields', $fieldData); ?>
                <?php
                // Allow modules to render custom fields
                Events::trigger('render_user_form');
                ?>
                <!-- Start of User Meta -->
                <?php //$this->load->view('users/user_meta', array('frontend_only' => true)); ?>
                <!-- End of User Meta -->

				<div class="form-group">
					<!-- Button -->
					<div class="col-md-offset-4 col-md-9">
						<button id="signup" type="submit" class="btn btn-info" name="register">
							<i class="glyphicon glyphicon-hand-right"></i> <?php echo lang('us_register'); ?>
						</button>
					</div>
				</div>
			<?php echo form_hidden('mobile_country_iso', $mobile_country_iso, 'mobile_country_iso');?>
			<?php echo form_close(); ?>
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
			 					id="<?php echo $banner['id'];?>" class="banner center-block img-responsive"
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