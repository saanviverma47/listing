<?php
 
 
 
 
 
 
 
 
 
 
 
 

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Contact_Queries.Reports.Delete');
$can_edit		= $this->auth->has_permission('Contact_Queries.Reports.Edit');
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
					
					<th><?php echo lang('label_user');?></th>
					<th><?php echo lang('label_name');?></th>
					<th><?php echo lang('label_email');?></th>
					<th><?php echo lang('label_phone');?></th>
					<th><?php echo lang('label_message');?></th>
					<th><?php echo lang('label_ip_address');?></th>
					<th><?php echo lang('label_posted_on');?></th>
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
					
					<td><?php e($record->display_name); ?></td>
					<td><?php e($record->name) ?></td>
					<td><?php e($record->email) ?></td>
					<td><?php e($record->phone) ?></td>
					<td><?php e($record->message) ?></td>
					<td><?php e($record->ip) ?></td>
					<td><?php e($record->posted_on) ?></td>
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