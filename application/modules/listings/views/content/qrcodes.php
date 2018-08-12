<?php 
 
 
 
 
 
 
 
 
 
 
 
 

$validation_errors = validation_errors();
if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading"><?php echo lang('validations_error');?></h4>
	<?php echo $validation_errors; ?>
</div>
<?php endif; ?>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
<div class="control-group">
	<label class="control-label"><?php echo lang('label_listing_ids'); ?></label>
	<div class="controls"><?php echo lang('label_value_between')?>
		<input type="text" name="listing_id_from" style="width: 6em;" value="<?php echo isset($_POST['listing_id_from']) ? $_POST['listing_id_from']: 1; ?>"><?php echo lang('label_value_and')?>
		<input type="text" name="listing_id_to" style="width: 6em;" value="<?php echo isset($_POST['listing_id_to']) ? $_POST['listing_id_to']: 50000; ?>">
		<span class="help-inline"><?php echo lang('label_difference_warning');?></span>
	</div>
</div>
<div class="control-group">
	<label class="control-label" id="insert_or_update"><?php echo lang('label_db_transaction') ?></label>
	<div class="controls" aria-labelledby="insert_or_update" role="group">
		<label class="radio" for="insert_only"> <input type="radio"
			id="insert_only" name="insert_or_update" value="1"
			<?php echo set_radio('insert_or_update','1', TRUE); if(isset($_POST['insert_or_update']) && $_POST['insert_or_update'] == 1) {echo 'checked';} ?> />
			<span><?php echo lang('label_insert_only') ?></span>
		</label> <label class="radio" for="insert_and_update"> <input
			type="radio" id="insert_and_update" name="insert_or_update" value="0"
			<?php if(isset($_POST['insert_or_update']) && $_POST['insert_or_update'] == 0) {echo 'checked';} ?> />
			<span><?php echo lang('label_insert_update') ?></span>
		</label>

	</div>
</div>

<div class="form-actions">
	<input type="submit" name="save" class="btn btn-primary"
		value="<?php echo lang('action_save'); ?>" />
</div>
<?php echo form_close();?>