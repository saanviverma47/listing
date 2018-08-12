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

if (isset($claim_reports))
{
	$claim_reports = (array) $claim_reports;
}
$id = isset($claim_reports['id']) ? $claim_reports['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('listing') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_listing'), 'claim_reports_listing', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_listing' type='text' name='claim_reports_listing' class='span6' disabled maxlength="11" value="<?php echo set_value('claim_reports_listing', isset($claim_reports['listing_title']) ? $claim_reports['listing_title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('listing'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('user') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_user'), 'claim_reports_user', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_user' type='text' name='claim_reports_user' class='span6' disabled maxlength="11" value="<?php echo set_value('claim_reports_user', isset($claim_reports['display_name']) ? $claim_reports['display_name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('user'); ?></span>
				</div>
			</div>

			<?php
				$options = array (
					'1' => lang('claim_option_first'),
					'2' => lang('claim_option_second'),
					'3'	=> lang('claim_option_third'),
					'4'	=> lang('claim_option_fourth'),
					'5' => lang('claim_option_fifth')
				);
				echo form_dropdown('claim_reports_type', $options, set_value('claim_reports_type', isset($claim_reports['type']) ? $claim_reports['type'] : ''), lang('label_type'), 'class="span6"');
			?>

			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'claim_reports_description', array('class' => 'control-label') ); ?>
				<div class='controls'>				
					<?php echo form_textarea( array( 'name' => 'claim_reports_description', 'id' => 'claim_reports_description', 'class' => 'span6', 'rows' => '5', 'cols' => '80', 'value' => set_value('claim_reports_description', isset($claim_reports['description']) ? $claim_reports['description'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_name'), 'claim_reports_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_name' type='text' name='claim_reports_name' class='span6' disabled maxlength="100" value="<?php echo set_value('claim_reports_name', isset($claim_reports['name']) ? $claim_reports['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('email') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_email'), 'claim_reports_email', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_email' type='text' name='claim_reports_email' class='span6' disabled maxlength="100" value="<?php echo set_value('claim_reports_email', isset($claim_reports['email']) ? $claim_reports['email'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('email'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('phone') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_phone'), 'claim_reports_phone', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_phone' type='text' name='claim_reports_phone' class='span6' disabled maxlength="20" value="<?php echo set_value('claim_reports_phone', isset($claim_reports['phone']) ? $claim_reports['phone'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('phone'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('ip') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_ip_address'), 'claim_reports_ip', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_ip' type='text' name='claim_reports_ip' class='span6' disabled maxlength="50" value="<?php echo set_value('claim_reports_ip', isset($claim_reports['ip']) ? $claim_reports['ip'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('ip'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('reported_on') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_reported_on'), 'claim_reports_reported_on', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_reported_on' type='text' name='claim_reports_reported_on' class='span6' disabled maxlength="1" value="<?php echo set_value('claim_reports_reported_on', isset($claim_reports['reported_on']) ? $claim_reports['reported_on'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('reported_on'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/reports/claim_reports', lang('cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Claim_Reports.Reports.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>