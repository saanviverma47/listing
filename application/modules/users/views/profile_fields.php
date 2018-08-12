<?php /* /bonfire/modules/users/views/user_fields.php */

$currentMethod = $this->router->fetch_method();

$errorClass     = empty($errorClass) ? ' error' : $errorClass;
$controlClass   = empty($controlClass) ? 'form-control' : $controlClass;
$registerClass  = $currentMethod == 'register' ? ' required' : '';
$editSettings   = $currentMethod == 'edit';

$defaultLanguage = isset($user->language) ? $user->language : strtolower(settings_item('language'));
$defaultTimezone = isset($current_user) ? $current_user->timezone : strtoupper(settings_item('site.default_user_timezone'));

?>
<div class="form-group<?php echo iif(form_error('email'), $errorClass); ?>">
    <label class="col-md-3 control-label required" for="email"><?php echo lang('bf_email'); ?></label>
    <div class="col-md-9">
        <input class="<?php echo $controlClass; ?>" type="text" id="email" name="email" placeholder="Email" value="<?php echo set_value('email', isset($user) ? $user->email : ''); ?>" />
        <span class="help-block"><?php echo form_error('email'); ?></span>
    </div>
</div>
<div class="form-group<?php echo iif(form_error('display_name'), $errorClass); ?>">
    <label class="col-md-3 control-label" for="display_name"><?php echo lang('bf_display_name'); ?></label>
    <div class="col-md-9">
        <input class="<?php echo $controlClass; ?>" type="text" id="display_name" name="display_name" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : ''); ?>" placeholder="Display Name" />
        <span class="help-block"><?php echo form_error('display_name'); ?></span>
    </div>
</div>
<?php if (settings_item('auth.login_type') !== 'email' OR settings_item('auth.use_usernames')) : ?>
<div class="form-group<?php echo iif(form_error('username'), $errorClass); ?>">
    <label class="col-md-3 control-label required" for="username"><?php echo lang('bf_username'); ?></label>
    <div class="col-md-9">
        <input class="<?php echo $controlClass; ?>" type="text" id="username" name="username" value="<?php echo set_value('username', isset($user) ? $user->username : ''); ?>" />
        <span class="help-block"><?php echo form_error('username'); ?></span>
    </div>
</div>
<?php endif; ?>
<div class="form-group has-feedback">
	<label class="col-md-3 control-label" for="mobile_number"><?php echo lang('label_mobile_number'); ?></label>
	<div class="col-md-9">
	<input type="tel" class="form-control" id="mobile_number"
		name="mobile_number" placeholder="<?php echo lang('placeholder_phone');?>" value="<?php echo set_value('mobile_number', isset($user) ? $user->mobile_number : ''); ?>" /> 
		<span class="help-block"><?php echo form_error('mobile_number'); ?></span>
	</div>
</div>
<div class="form-group<?php echo iif(form_error('password'), $errorClass); ?>">
    <label class="col-md-3 control-label<?php echo $registerClass; ?>" for="password"><?php echo lang('bf_password'); ?></label>
    <div class="col-md-9">
        <input class="<?php echo $controlClass; ?>" type="password" id="password" name="password" value="" />
        <span class="help-block"><?php echo form_error('password'); ?></span>
        <p class="help-block"><?php if (isset($password_hints) ) { echo $password_hints; } ?></p>
    </div>
</div>
<div class="form-group<?php echo iif(form_error('pass_confirm'), $errorClass); ?>">
    <label class="col-md-3 control-label<?php echo $registerClass; ?>" for="pass_confirm"><?php echo lang('bf_password_confirm'); ?></label>
    <div class="col-md-9">
        <input class="<?php echo $controlClass; ?>" type="password" id="pass_confirm" name="pass_confirm" value="" />
        <span class="help-block"><?php echo form_error('pass_confirm'); ?></span>
    </div>
</div>
<?php if ($editSettings) : ?>
<div class="form-group<?php echo iif(form_error('force_password_reset'), $errorClass); ?>">
    <div class="col-md-9">
        <label class="checkbox" for="force_password_reset">
            <input type="checkbox" id="force_password_reset" name="force_password_reset" value="1" <?php echo set_checkbox('force_password_reset', empty($user->force_password_reset)); ?> />
            <?php echo lang('us_force_password_reset'); ?>
        </label>
    </div>
</div>
<?php endif;

if (isset($languages) && is_array($languages) && count($languages)) :
    if(count($languages) == 1):
?>
<input type="hidden" id="language" name="language" value="<?php echo $languages[0]; ?>" />
<?php
    else :
?>
    <div class="form-group<?php echo iif(form_error('language'), $errorClass); ?>">
    <label class="col-md-3 control-label required" for="language"><?php echo lang('bf_language'); ?></label>
    <div class="col-md-9">
        <select name="language" id="language" class="chzn-select <?php echo $controlClass; ?>">
            <?php foreach ($languages as $language) : ?>
            <option value="<?php e($language); ?>" <?php echo set_select('language', $language, $defaultLanguage == $language ? true : false); ?>>
                <?php e(ucfirst($language)); ?>
            </option>
            <?php endforeach; ?>
        </select>
        <span class="help-block"><?php echo form_error('language'); ?></span>
    </div>
</div>
<?php
    endif;
endif;
?>
<div class="form-group<?php echo iif(form_error('timezone'), $errorClass); ?>">
    <label class="col-md-3 control-label required" for="timezones"><?php echo lang('bf_timezone'); ?></label>
    <div class="col-md-9">
        <?php echo timezone_menu(set_value('timezones', isset($user) ? $user->timezone : $defaultTimezone), $controlClass); ?>
        <span class="help-block"><?php echo form_error('timezones'); ?></span>
    </div>
</div>