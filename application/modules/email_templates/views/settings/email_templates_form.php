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

if (isset($email_templates)) {
	$email_templates = (array) $email_templates;
}
$id = isset($email_templates['id']) ? $email_templates['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('subject') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_subject'). lang('bf_form_label_required'), 'email_templates_subject', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='email_templates_subject' type='text' name='email_templates_subject' maxlength="100" value="<?php echo set_value('email_templates_subject', isset($email_templates['subject']) ? $email_templates['subject'] : ''); ?>" class='span6' />
					<span class='help-inline'><?php echo form_error('subject'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('message') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_message'). lang('bf_form_label_required'), 'email_templates_message', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'email_templates_message', 'id' => 'email_templates_message', 'rows' => '5', 'cols' => '80', 'class' => 'span6', 'value' => set_value('email_templates_message', isset($email_templates['message']) ? $email_templates['message'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('message'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/settings/email_templates', lang('cancel'), 'class="btn btn-warning"'); ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>