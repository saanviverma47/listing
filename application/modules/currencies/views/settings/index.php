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

if (isset($currencies)) {
	$currencies = (array) $currencies;
}
$id = isset($currencies['id']) ? $currencies['id'] : '';

?>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('code') ? 'error' : ''; ?>">
				<div class='controls'>
					<input id='currencies_code' type='text' name='currencies_code' placeholder='<?php echo lang('placeholder_currency_code');?>' class='span1' maxlength="3" value="<?php echo set_value('currencies_code', isset($currencies['code']) ? $currencies['code'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('code'); ?></span>
					<input id='currencies_symbol' type='text' name='currencies_symbol' placeholder='<?php echo lang('placeholder_symbol');?>' class='span1' maxlength="10" value="<?php echo set_value('currencies_symbol', isset($currencies['symbol']) ? $currencies['symbol'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('symbol'); ?></span>
					<input id='currencies_name' type='text' name='currencies_name' placeholder='<?php echo lang('placeholder_currency_name');?>' class='span4' maxlength="80" value="<?php echo set_value('currencies_name', isset($currencies['name']) ? $currencies['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
					<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				</div>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
<?php
$num_columns	= 5;
$can_delete	= $this->auth->has_permission('Currencies.Settings.Delete');
$can_edit		= $this->auth->has_permission('Currencies.Settings.Edit');
$has_records	= isset($records) && is_array($records) && count($records);
?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th><?php echo lang('label_code');?></th>
					<th><?php echo lang('label_symbol');?></th>
					<th><?php echo lang('label_name');?></th>
					<th><?php echo lang('label_status');?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<?php if($this->uri->segment(5)):?>
					<td><?php echo anchor(SITE_AREA . '/settings/currencies/index/' .$this->uri->segment(5) .'/'. $record->id, '<span class="icon-pencil"></span>' .  $record->code); ?></td>
					<?php else:?>
					<td><?php echo anchor(SITE_AREA . '/settings/currencies/index/0/'. $record->id, '<span class="icon-pencil"></span>' .  $record->code); ?></td>
					<?php endif;?>
				<?php else : ?>
					<td><?php e($record->code); ?></td>
				<?php endif; ?>
					<td><?php e($record->symbol) ?></td>
					<td><?php e($record->name) ?></td>
					<?php if($this->uri->segment(5)):?>
					<td><?php echo $record->active == 0 ? anchor(SITE_AREA . '/settings/currencies/update_status/' . $record->id .'/' .$this->uri->segment(5), '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/settings/currencies/update_status/' . $record->id .'/' .$this->uri->segment(5), '<span class="label label-success">' . lang('us_active') . '</span>' ); ?></td>
					<?php else:?>
					<td><?php echo $record->active == 0 ? anchor(SITE_AREA . '/settings/currencies/update_status/' . $record->id, '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/settings/currencies/update_status/' . $record->id, '<span class="label label-success">' . lang('us_active') . '</span>' ); ?></td>
					<?php endif;?>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>"><?php echo lang('error_no_record_found');?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php 
	echo form_close(); 
	echo $this->pagination->create_links();?>
</div>