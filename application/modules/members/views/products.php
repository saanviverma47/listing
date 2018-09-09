<?php
$num_columns	= 8;
$can_delete	= $this->auth->restrict();
$can_edit		= $this->auth->restrict();
$has_records	= isset($records) && is_array($records) && count($records);
?>
	<?php echo anchor(site_url('members/add_product?id=' .$this->input->get('id')), '<span class="glyphicon glyphicon-plus"></span>' .lang('new') .' '.lang('label_product') .'/' .lang('label_service'), 'class="btn btn-primary pull-right"'); ?>
	<br />
	<?php echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING']); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th><?php echo lang('label_title');?></th>
					<th><?php echo lang('label_type');?></th>
					<th><?php echo lang('label_status');?></th>
					<th><?php echo lang("column_created"); ?></th>
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
					<td><?php echo anchor(site_url('members/edit_product?id=' . $this->encrypt->encode($record->id)), '<span class="icon-pencil"></span>' .  $record->title); ?></td>
				<?php else : ?>
					<td><?php e($record->title); ?></td>
				<?php endif; ?>
					<td><?php e($record->type) ?></td>
					<td class='status'>
						<?php if ($record->active) : ?>
						<?php echo '<span class="label label-success">' . lang('us_active') . '</span>' ; ?>
						<?php else : ?>
						<?php echo '<span class="label label-warning">' . lang('status') . '</span>'; ?>
						<?php endif; ?>
					</td>
					<td><?php e($record->created_on) ?></td>
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
</div>