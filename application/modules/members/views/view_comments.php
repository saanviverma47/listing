<?php
$num_columns	= 7;
$can_delete	= $this->auth->restrict();
$can_edit		= $this->auth->restrict();
$has_records	= isset($records) && is_array($records) && count($records);

?>
	
	<?php echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING']); ?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th width="20%"><?php echo lang('label_title');?></th>
					<th width="20%"><?php echo lang('label_listing');?></th>
					<th width="50%"><?php echo lang('label_comments');?></th>
					<th width="20%"><?php echo lang('label_posted_on');?></th>
					<th width="10%"><?php echo lang('label_status');?></th>
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
					<td><?php e($record->title); ?></td>
					<td><?php e($record->listing_title) ?></td>
					<td><?php e($record->comment) ?></td>
					<td><?php e($record->created_on) ?></td>
					<td class='status'>
						<?php if ($record->status) : ?>
						<?php echo '<span class="label label-success">' . lang('us_active') . '</span>'; ?>
						<?php else : ?>
						<?php echo '<span class="label label-warning">' . lang('status') . '</span>'; ?>
						<?php endif; ?>
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
		</div>		
	<?php echo form_close(); ?>
	<div class="row">
			<div class="col-sm-12 centered-text">
				<?php echo $this->pagination->create_links(); ?>
			</div><!-- end of pagination column -->
		</div><!-- end of pagination row -->	