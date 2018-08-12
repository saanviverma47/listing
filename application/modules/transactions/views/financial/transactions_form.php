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

if (isset($transactions))
{
	$transactions = (array) $transactions;
}
$id = isset($transactions['id']) ? $transactions['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('invoice') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_transaction_id'). lang('bf_form_label_required'), 'transactions_invoice', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='transactions_invoice' type='text' name='transactions_invoice' class='span6' value="<?php echo set_value('transactions_invoice', isset($transactions['invoice']) ? $transactions['invoice'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('invoice'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('received_on') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_date'), 'transactions_received_on', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='transactions_received_on' type='text' name='transactions_received_on' class='span6' value="<?php echo set_value('transactions_received_on', isset($transactions['received_on']) ? $transactions['received_on'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('received_on'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('ip_address') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_ip_address'), 'transactions_ip_address', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='transactions_ip_address' type='text' name='transactions_ip_address' class='span6' value="<?php echo set_value('transactions_ip_address', isset($transactions['ip_address']) ? $transactions['ip_address'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('ip_address'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('package_id') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_membership_package'). lang('bf_form_label_required'), 'transactions_package_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='transactions_package_id' type='text' name='transactions_package_id' class='span6' value="<?php echo set_value('transactions_package_id', isset($transactions['package_id']) ? $transactions['package_title'] .' - ' .$transactions['package_id'] : ''); ?>"readonly />
					<span class='help-inline'><?php echo form_error('ip_address'); ?></span>
				</div>
			</div>	
			
			<div class="control-group <?php echo form_error('user_id') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_user'). lang('bf_form_label_required'), 'transactions_user_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='transactions_user_id' type='text' name='transactions_user_id' class='span6' value="<?php echo set_value('transactions_user_id', isset($transactions['user_id']) ? $transactions['display_name'] .' - ' .$transactions['user_id'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('ip_address'); ?></span>
				</div>
			</div>	
			
			<div class="control-group <?php echo form_error('listing_id') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_listing'). lang('bf_form_label_required'), 'transactions_listing_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='transactions_listing_id' type='text' name='transactions_listing_id' class='span6' value="<?php echo set_value('transactions_listing_id', isset($transactions['listing_id']) ? $transactions['listing_title'] .' - ' .$transactions['listing_id'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('ip_address'); ?></span>
				</div>
			</div>	
				
			<div class="control-group <?php echo form_error('amount') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_amount'), 'transactions_amount', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='transactions_amount' type='text' name='transactions_amount' class='span6' value="<?php echo set_value('transactions_amount', isset($transactions['amount']) ? $transactions['amount'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('amount'); ?></span>
				</div>
			</div>			

			<div class="control-group <?php echo form_error('comments') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_comments'), 'transactions_comments', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'transactions_comments', 'id' => 'transactions_comments', 'rows' => '5', 'cols' => '80', 'class' => 'span6', 'value' => set_value('transactions_comments', isset($transactions['comments']) ? $transactions['comments'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('comments'); ?></span>
				</div>
			</div>
			
			
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'0'		=> lang('pending'),
					'1'		=> lang('paid'),
					'2'		=> lang('cancelled')
					
				);

				echo form_dropdown('transactions_status', $options, set_value('transactions_status', isset($transactions['status']) ? $transactions['status'] : ''), lang('label_status'). lang('bf_form_label_required'), 'class="span6"');
			?>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/financial/transactions', lang('cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Transactions.Financial.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>