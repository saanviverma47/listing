<?php
 
 
 
 
 
 
 
 
 
 
 
 

$num_columns	= 10;
$can_delete	= $this->auth->has_permission('Claim_Reports.Reports.Delete');
$can_edit		= $this->auth->has_permission('Claim_Reports.Reports.Edit');
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
					
					<th><?php echo lang('label_listing');?></th>
					<th><?php echo lang('label_user');?></th>
					<th><?php echo lang('label_type');?></th>
					<th><?php echo lang('label_email');?></th>
					<th><?php echo lang('label_ip_address');?></th>
					<th><?php echo lang('label_reported_on');?></th>
					<th><?php echo lang('label_action');?></th>
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
					
					<td><?php e($record->listing_title); ?></td>
					<td><?php e($record->display_name) ?></td>
					<?php switch($record->type) {
						case 1:?>
							<td><?php echo lang('claim_option_first');?></td>
							<?php break;
						case 2:?>
							<td><?php echo lang('claim_option_second');?></td>
							<?php break;
						case 3:?>
							<td><?php echo lang('claim_option_third');?></td>
							<?php break;
						case 4: ?>
							<td><?php echo lang('claim_option_fourth');?></td>
							<?php break;
						case 5: ?>
							<td><?php echo lang('claim_option_fifth');?></td>
							<?php break; }?>
					<td><?php e($record->email) ?></td>
					<td><?php e($record->ip) ?></td>
					<td><?php e($record->reported_on) ?></td>
					<td><?php echo anchor(SITE_AREA . '/reports/claim_reports/view/' . $record->id, '<span class="label btn-info">'.lang('label_view').'</span>'); ?></td>
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