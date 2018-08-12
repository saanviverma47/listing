<?php
 
 
 
 
 
 
 
 
 
 
 
 

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading"><?php echo lang('validations_error');?></h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($paypal))
{
	$paypal = (array) $paypal;
}
$id = isset($paypal['id']) ? $paypal['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>			

			<div class="control-group <?php echo form_error('display_name') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_display_name'). lang('bf_form_label_required'), 'display_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='display_name' type='text' name='display_name' class='span6' maxlength="100" value="<?php echo set_value('display_name', isset($paypal['display_name']) ? $paypal['display_name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('display_name'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('order') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_order'), 'order', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='order' type='text' name='order' class='span6' maxlength="4" value="<?php echo set_value('order', isset($paypal['order']) ? $paypal['order'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('order'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('api_username') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_paypal') .' ' .lang('label_username'). lang('bf_form_label_required'), 'paypal_api_username', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='paypal_api_username' type='text' name='paypal_api_username' class='span6' maxlength="100" value="<?php echo set_value('paypal_api_username', isset($settings['api_username']) ? $settings['api_username'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('api_username'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('api_password') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_paypal') .' ' .lang('label_password'). lang('bf_form_label_required'), 'paypal_api_password', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='paypal_api_password' type='text' name='paypal_api_password' class='span6' maxlength="100" value="<?php echo set_value('paypal_api_password', isset($settings['api_password']) ? $settings['api_password'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('api_password'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('api_signature') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_paypal') .' ' .lang('label_signature'). lang('bf_form_label_required'), 'paypal_api_signature', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='paypal_api_signature' type='text' name='paypal_api_signature' class='span6' maxlength="255" value="<?php echo set_value('paypal_api_signature', isset($settings['api_signature']) ? $settings['api_signature'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('api_signature'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('currency') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_currency') . lang('bf_form_label_required'), 'paypal_currency', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='paypal_currency' type='text' name='paypal_currency' class='span6' maxlength="4" value="<?php echo set_value('paypal_currency', isset($settings['currency']) ? $settings['currency'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('currency'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('testmode') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_sandbox_mode'), 'paypal_testmode', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='paypal_testmode'>
						<input type='checkbox' id='paypal_testmode' name='paypal_testmode' value='1' <?php echo (isset($settings['testmode']) && $settings['testmode'] == 1) ? 'checked="checked"' : set_checkbox('paypal_testmode', 1); ?>>
						<span class='help-inline'><?php echo form_error('testmode'); ?></span>
					</label>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('active') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_status'), 'active', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='active'>
						<input type='checkbox' id='active' name='active' value='1' <?php echo (isset($paypal['active']) && $paypal['active'] == 1) ? 'checked="checked"' : set_checkbox('active', 1); ?>>
						<span class='help-inline'><?php echo form_error('active'); ?></span>
					</label>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/settings/payment_gateways/', lang('cancel'), 'class="btn btn-warning"'); ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>