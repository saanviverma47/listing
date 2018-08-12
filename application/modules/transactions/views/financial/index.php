<?php
 
 
 
 
 
 
 
 
 
 
 
 

?>
<style>
th.id { width: 3em; }
th.last-login { width: 11em; }
th.status { width: 10em; }
</style>
<ul class="nav nav-tabs" >
	<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('tab_all')); ?></li>
	<li<?php echo $filter_type == 'pending' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'pending/', lang('pending')); ?></li>
	<li<?php echo $filter_type == 'paid' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'paid/', lang('paid')); ?></li>
	<li<?php echo $filter_type == 'cancelled' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'cancelled/', lang('cancelled')); ?></li>
</ul>
<?php 
$num_columns	= 9;
$can_delete	= $this->auth->has_permission('Transactions.Financial.Delete');
$can_edit		= $this->auth->has_permission('Transactions.Financial.Edit');
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
					<th><?php echo lang('label_transaction_id');?></th>
					<th><?php echo lang('label_business').' '.lang('label_listing');?></th>
					<th><?php echo lang('label_package');?></th>
					<th><?php echo lang('label_user');?></th>					
					<th><?php echo lang('label_amount');?></th>
					<th><?php echo lang('label_date');?></th>
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
				<td><?php e($record->id) ?></td>
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/financial/transactions/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->invoice); ?></td>
				<?php else : ?>
					<td><?php e($record->invoice); ?></td>
				<?php endif; ?>
					<td><?php e($record->listing) ?></td>
					<td><?php e($record->title) ?></td>
					<td><?php e($record->display_name) ?></td>	
					<td><?php e($record->amount) ?></td>
					<td><?php e($record->received_on) ?></td>
					<td>
						<?php switch ($record->status) { 
							case 0: 
								echo '<span class="label label-default">' . lang('pending') . '</span>'; 
								break;
							case 1:
								echo '<span class="label label-success">' . lang('paid') . '</span>';
								break;
							case 2:
								echo '<span class="label label-warning">' . lang('cancelled') . '</span>';
								break;
						} ?>
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
	<?php echo form_close();
	echo $this->pagination->create_links();
	?>
</div>