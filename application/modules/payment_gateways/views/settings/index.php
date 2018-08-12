<?php
 
 
 
 
 
 
 
 
 
 
 
 

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Payment_Gateways.Settings.Delete');
$can_edit		= $this->auth->has_permission('Payment_Gateways.Settings.Edit');
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
					
					<th><?php echo lang('label_name');?></th>
					<th><?php echo lang('label_company_logo');?></th>
					<th><?php echo lang('label_order');?></th>
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
					<td><?php
						switch($record->name) {
							case 'PayPal':
								echo anchor(SITE_AREA . '/settings/payment_gateways/paypal/' . $record->id, $record->display_name);
								break;
						}
					?></td>
				<?php else : ?>
					<td><?php e($record->name); ?></td>
				<?php endif; ?>
					<td>
					<?php if($record->logo !== NULL) {?>
						<img src="<?= base_url(); ?>assets/images/payment-gateways/<?= $record->logo; ?>" alt="Payment Gateway Logo" title="Payment Gateway Logo" />
					<?php } else {?>
						<img src="<?= base_url(); ?>assets/images/payment-gateways/no-logo.png" alt="Payment Gateway Logo Not Set" title="Payment Gateway Logo Not Set" />
					<?php }?>
					</td>
					<td><?php e($record->order) ?></td>
					<td>
						<?php if ($record->active) : ?>
						<?php echo anchor(SITE_AREA . '/settings/payment_gateways/change_status/' . $record->id, '<span class="label label-success">' . lang('us_active') . '</span>' ); ?>
						<?php else : ?>
						<?php echo anchor(SITE_AREA . '/settings/payment_gateways/change_status/' . $record->id, '<span class="label label-warning">' . lang('us_inactive') . '</span>' ); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>"><?php echo lang('label_no_record_found');?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); 
	echo $this->pagination->create_links();
	?>
</div>