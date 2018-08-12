<?php
 
 
 
 
 
 
 
 
 
 
 
 

$num_columns	= 19;
$can_delete	= $this->auth->has_permission('Banners.Settings.Delete');
$can_edit		= $this->auth->has_permission('Banners.Settings.Edit');
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
					<th><?php echo lang('label_title');?></th>
					<th><?php echo lang('label_description');?></th>
					<th><?php echo lang('label_location');?></th>
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
					<td><?php e($record->id) ?></td>
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/settings/banners/edit_banner_types/' . $record->id, '<span class="icon-pencil"></span>' .  $record->title); ?></td>
				<?php else : ?>
					<td><?php e($record->title); ?></td>
				<?php endif; ?>
					<td><?php e($record->description) ?></td>
					<td><?php e($record->location) ?></td>					
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
	<?php echo form_close(); 
	echo $this->pagination->create_links();
	?>
</div>