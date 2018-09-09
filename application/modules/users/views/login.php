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


<section class="tz-register">
			<div class="log-in-pop" style='width:50% !important;'>
				
				<div id="loginbox" class="log-in-pop-right" style='width:100% !important;'>
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
						<h4>Login</h4>
					<p>Don't have an account? <a href="#" id="signup_box">Create your account.</a> It's take less then a minutes</p>
					<?php echo form_open(LOGIN_URL, array('id' => 'loginform', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
						<div >
							<div class="input-field s12" class="<?php echo iif( form_error('login') , 'error') ;?>">
								<input type="text" data-ng-model="name1" class="validate" id="login_value" name="login" name="login" value="<?php echo set_value('login'); ?>" tabindex="1"
							placeholder="<?php echo $this->settings_lib->item('auth.login_type') == 'both' ? lang('bf_username') .'/'. lang('bf_email') : ucwords($this->settings_lib->item('auth.login_type')) ?>">
								<label>User name</label>
							</div>
						</div>
						<div>
							<div class="input-field s12" <?php echo iif( form_error('password') , 'error') ;?>>
								<input type="password" class="validate" id="password" name="password" placeholder="<?php echo lang('bf_password'); ?>">
								<label>Password</label>
							</div>
						</div>
						<div>
							<div class="input-field s4">
							<input  type="submit" class="btn btn-sm btn-success" name="log-me-in" id="submit"	value="<?php e(lang('us_let_me_in')); ?>" tabindex="5" />
								<input type="reset" class="btn btn-sm btn-success"value="Reset"/>
							</div>
						</div>
						<div>
							<div class="input-field s12"><a href="#" id="reset_password_box"><?php echo lang('us_forgot_your_password'); ?></a>	 | <a href="register.php"><?php echo lang('label_sign_in');?></a> </div>
						</div>
					<?php echo form_close(); ?>
				</div>
				
		<div id="passwordresetbox" style="display: none; margin-top: 10px" class="mainbox col-md-8 col-md-offset-2 col-sm-12">
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

		<div class="log-in-pop-right" style='width:100% !important;'>
		<a href="#" class="pop-close" data-dismiss="modal"><img src="images/cancel.png" alt=""></a>
		<h4>Create an Account</h4>
		<p>Already have an account? <a href='#' id='signin_box'>Login.</a></p>
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
		<form class="s12 ng-pristine ng-valid">
			<?php Template::block('user_fields', 'user_fields', $fieldData); ?>
                <?php
                // Allow modules to render custom fields
                Events::trigger('render_user_form');
                ?>
			<div class="form-group">
					<!-- Button -->
					<div class="col-md-offset-4 col-md-9">
						<button id="signup" type="submit" class="btn btn-info" name="register">
							<i class="glyphicon glyphicon-hand-right"></i> <?php echo lang('us_register'); ?>
						</button>
					</div>
				</div>
			<?php echo form_hidden('mobile_country_iso', $mobile_country_iso, 'mobile_country_iso');?>
		</form>
	</div>
	

</div>
	</section>