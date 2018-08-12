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

if (isset($localities))
{
	$localities = (array) $localities;
}
$id = isset($localities['id']) ? $localities['id'] : '';

?>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
			<div class='controls'>
					<input id='localities_name' type='text' name='localities_name' maxlength="40" class='span6' placeholder='<?php echo sprintf(lang('placeholder_location_name'), strtolower(lang('label_locality')));?>' value="<?php echo set_value('localities_name', isset($localities['name']) ? $localities['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
					<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				</div>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
<style>
th.id { width: 3em; }
th.last-login { width: 11em; }
th.status { width: 10em; }
</style>
<div class="well shallow-well">
	<span class="filter-link-list">
		<?php
		// If there's a current filter, we need to replace the caption with a clear button
		if ($filter_type == 'first_letter') :
			echo anchor($localities_url, lang('bf_clear'), array('class' => 'btn btn-small btn-primary'));
		else :
			e(lang('filter_first_letter'));
		endif;

		$letters = range('A', 'Z');
		foreach ($letters as $letter) :
			echo anchor($localities_url . 'first_letter-' . $letter, $letter) . PHP_EOL;
		endforeach;
		?>
	</span>
</div>
<?php

$num_columns	= 5;
$can_delete	= $this->auth->has_permission('Locations.Settings.Delete');
$can_edit		= $this->auth->has_permission('Locations.Settings.Edit');
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
					<th><?php echo lang('label_id');?></th>
					<th><?php echo lang('label_name');?></th>
					<th><?php echo lang('label_city') .' '.lang('label_code');?></th>
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
					<td><?php e($record->id); ?></td>
				<?php if ($can_edit) : ?> 
						<?php if($this->uri->segment(5) && ($this->uri->segment(6)) && ($this->uri->segment(7))) :?>
					<td><?php echo anchor(SITE_AREA .'/settings/locations/localities/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'. $this->uri->segment(7).'/'. $record->id, $record->name);?></td>
						<?php elseif($this->uri->segment(5) && ($this->uri->segment(6))) : ?>
					<td><?php echo anchor(SITE_AREA .'/settings/locations/localities/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/0/'. $record->id, $record->name);?></td>
						<?php else: ?>
					<td><?php echo anchor(SITE_AREA .'/settings/locations/localities/'.$this->uri->segment(5).'/all/0/'. $record->id, $record->name);?></td>
						<?php endif;?>
				<?php else : ?>
					<td><?php e($record->name); ?></td>					
				<?php endif; ?>
					<td><?php echo e($record->abbrev); ?></td>
					<td>
						<button type="submit" name="update_status" value="<?php echo $record->id?>" class="btn btn-mini <?php echo $record->active == 1 ? 'btn-success' : 'btn-warning';?>">
							<?php echo $record->active == 1 ? lang('us_active') : lang('us_inactive'); ?>
						</button>
					</td>
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
	<?php echo form_close(); ?>
	<?php echo $this->pagination->create_links(); ?>
</div>