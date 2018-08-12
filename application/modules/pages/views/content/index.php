<?php
 
 
 
 
 
 
 
 
 
 
 
 

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Pages.Content.Delete');
$can_edit		= $this->auth->has_permission('Pages.Content.Edit');
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
					<th><?php echo lang('label_slug');?></th>
					<th><?php echo lang('label_parent_id');?></th>
					<th><?php echo lang('label_status')?></th>
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
					<td><?php echo anchor(SITE_AREA . '/content/pages/edit/' . $record->id, $record->title); ?></td>
				<?php else : ?>
					<td><?php e($record->title); ?></td>
				<?php endif; ?>
					<td><?php e($record->slug) ?></td>
					<td><?php echo $record->parent_id == 0 ? '' : $record->parent_id ?></td>
					<td><?php echo $record->active == 0 ? anchor(SITE_AREA . '/content/pages/change_status/' . $record->id, '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/content/pages/change_status/' . $record->id, '<span class="label label-success">' . lang('us_active') . '</span>' ); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr><td colspan="<?php echo $num_columns; ?>"><?php echo lang('label_no_record_found');?></td></tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); 
	echo $this->pagination->create_links();?>
</div>