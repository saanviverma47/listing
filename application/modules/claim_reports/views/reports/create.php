<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Please fix the following errors:</h4>
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
	<h3>Claim Reports</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('listing_id') ? 'error' : ''; ?>">
				<?php echo form_label('Listing Id', 'claim_reports_listing_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_listing_id' type='text' name='claim_reports_listing_id' maxlength="11" value="<?php echo set_value('claim_reports_listing_id', isset($claim_reports['listing_id']) ? $claim_reports['listing_id'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('listing_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('user_id') ? 'error' : ''; ?>">
				<?php echo form_label('User Id', 'claim_reports_user_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_user_id' type='text' name='claim_reports_user_id' maxlength="11" value="<?php echo set_value('claim_reports_user_id', isset($claim_reports['user_id']) ? $claim_reports['user_id'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('user_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('type') ? 'error' : ''; ?>">
				<?php echo form_label('Type', 'claim_reports_type', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_type' type='text' name='claim_reports_type' maxlength="2" value="<?php echo set_value('claim_reports_type', isset($claim_reports['type']) ? $claim_reports['type'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('type'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label('Description', 'claim_reports_description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_description' type='text' name='claim_reports_description' maxlength="450" value="<?php echo set_value('claim_reports_description', isset($claim_reports['description']) ? $claim_reports['description'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
				<?php echo form_label('Name', 'claim_reports_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_name' type='text' name='claim_reports_name' maxlength="100" value="<?php echo set_value('claim_reports_name', isset($claim_reports['name']) ? $claim_reports['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('email') ? 'error' : ''; ?>">
				<?php echo form_label('Email', 'claim_reports_email', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_email' type='text' name='claim_reports_email' maxlength="100" value="<?php echo set_value('claim_reports_email', isset($claim_reports['email']) ? $claim_reports['email'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('email'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('phone') ? 'error' : ''; ?>">
				<?php echo form_label('Phone', 'claim_reports_phone', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_phone' type='text' name='claim_reports_phone' maxlength="20" value="<?php echo set_value('claim_reports_phone', isset($claim_reports['phone']) ? $claim_reports['phone'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('phone'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('ip') ? 'error' : ''; ?>">
				<?php echo form_label('Ip', 'claim_reports_ip', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_ip' type='text' name='claim_reports_ip' maxlength="50" value="<?php echo set_value('claim_reports_ip', isset($claim_reports['ip']) ? $claim_reports['ip'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('ip'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('reported_on') ? 'error' : ''; ?>">
				<?php echo form_label('Reported On', 'claim_reports_reported_on', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='claim_reports_reported_on' type='text' name='claim_reports_reported_on' maxlength="1" value="<?php echo set_value('claim_reports_reported_on', isset($claim_reports['reported_on']) ? $claim_reports['reported_on'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('reported_on'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('claim_reports_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/reports/claim_reports', lang('claim_reports_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>