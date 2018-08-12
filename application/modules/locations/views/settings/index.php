<?php
 
 
 
 
 
 
 
 
 
 
 
 

?>
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
			echo anchor($index_url, lang('bf_clear'), array('class' => 'btn btn-small btn-primary'));
		else :
			e(lang('filter_first_letter'));
		endif;

		$letters = range('A', 'Z');
		foreach ($letters as $letter) :
			echo anchor($index_url . 'first_letter-' . $letter, $letter) . PHP_EOL;
		endforeach;
		?>
	</span>
</div>
<?php

$num_columns	= 8;
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
					<th><?php echo lang('label_iso');?></th>
					<th><?php echo lang('label_name');?></th>
					<th><?php echo lang('label_printable_name');?></th>
					<th><?php echo lang('label_iso_3');?></th>
					<th><?php echo lang('label_numcode');?></th>
					<th><?php echo lang('label_status');?></th>
					<th><?php echo lang('label_action');?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns + 2; ?>">
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
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->iso; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/settings/locations/edit_country/' . $record->iso, $record->iso); ?></td>
				<?php else : ?>
					<td><?php e($record->iso); ?></td>
				<?php endif; ?>
					<td><?php e($record->name); ?></td>
					<td><?php e($record->printable_name) ?></td>
					<td><?php e($record->iso3) ?></td>
					<td><?php e($record->numcode) ?></td>
					<td>
					<button type="submit" name="update_status" value="<?php echo $record->iso?>" class="btn btn-mini <?php echo $record->active == 1 ? 'btn-success' : 'btn-warning';?>">
						<?php echo $record->active == 1 ? lang('us_active') : lang('us_inactive'); ?>
					</button>
					</td>
					<td><?php echo anchor(SITE_AREA . '/settings/locations/states/' . $record->iso, '<span class="label label-info">'.lang('label_view'). ' ' .lang('label_states').'</span>')?></td>
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