<?php
 
 
 
 
 
 
 
 
 
 
 
 

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading"><?php echo lang('validations_failure');?></h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($countries))
{
	$countries = (array) $countries;
}
$id = isset($countries['iso']) ? $countries['iso'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('iso') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_iso'). lang('bf_form_label_required'), 'countries_iso', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='countries_iso' type='text' name='countries_iso' class='span6' value="<?php echo set_value('countries_iso', isset($countries['iso']) ? $countries['iso'] : ''); ?>" <?php echo isset($countries['iso']) ? 'readonly' : ''; ?>/>
					<span class='help-inline'><?php echo form_error('iso'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_name'). lang('bf_form_label_required'), 'countries_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='countries_name' type='text' name='countries_name' class='span6' value="<?php echo set_value('countries_name', isset($countries['name']) ? $countries['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('printable_name') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_printable_name'), 'countries_printable_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='countries_printable_name' type='text' name='countries_printable_name' class='span6' value="<?php echo set_value('countries_printable_name', isset($countries['printable_name']) ? $countries['printable_name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('printable_name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('iso3') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_iso_3'), 'countries_iso3', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='countries_iso3' type='text' name='countries_iso3' class='span6' value="<?php echo set_value('countries_iso3', isset($countries['iso3']) ? $countries['iso3'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('iso3'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('numcode') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_numcode'), 'countries_numcode', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='countries_numcode' type='text' name='countries_numcode' class='span6' value="<?php echo set_value('countries_numcode', isset($countries['numcode']) ? $countries['numcode'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('numcode'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/settings/locations', lang('cancel'), 'class="btn btn-warning"'); ?>
			<?php if(isset($countries['iso'])) {?>
			<?php if ($this->auth->has_permission('Locations.Settings.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('delete_record'); ?>
				</button>
			<?php endif; ?>
			<?php }?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>