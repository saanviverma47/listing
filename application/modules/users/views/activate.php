<div class="page-header">
	<h1><?php echo lang('us_activate'); ?></h1>
</div>

<?php if (validation_errors()) { ?>
<div class="row-fluid">
	<div class="span8 offset2">
		<div class="alert alert-error fade in">
		  <a data-dismiss="alert" class="close">&times;</a>
			<?php echo validation_errors(); ?>
		</div>
	</div>
</div>
<?php } elseif(!empty($success_msg)) { ?>
<?php echo Template::message(); ?>
<?php } else { ?>
<div class="row-fluid">
	<div class="span8 offset2">
		<div class="well shallow-well">
			<?php echo lang('us_user_activate_note'); ?>
		</div>
	</div>
</div>
<?php } ?>
<?php echo form_open($this->uri->uri_string(), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
<fieldset>
	<div class="form-group <?php echo iif( form_error('code') , 'error') ;?>">
		<label for="code" class="control-label col-xs-2"><?php echo lang('us_activate_code'); ?></label>
		<div class="col-xs-6">
			<div class="input-group">
				<input id="code" type="text" name="code" class="form-control" value="<?php echo set_value('code') ?>" />
					<span class='help-block'><?php echo form_error('error'); ?></span> 
					<span class="input-group-btn">
					<input class="btn btn-primary" type="submit" name="activate" value="<?php echo lang('us_confirm_activate_code') ?>"  />
				</span>
			</div>
		</div>
	</div>
</fieldset>
<?php echo form_close(); ?>
<br />