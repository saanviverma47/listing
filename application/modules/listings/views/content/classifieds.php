<?php
 
 
 
 
 
 
 
 
 
 
 
 

$num_columns	= 7;
$can_delete	= $this->auth->has_permission('Listings.Content.Delete');
$can_edit		= $this->auth->has_permission('Listings.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<?php echo anchor(SITE_AREA .'/content/listings/add_classified/' .$listing_id, '<span class="glyphicon glyphicon-plus"></span>' .lang('new') .' '.lang('label_classified'), 'class="btn btn-primary pull-right"'); ?>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th><?php echo lang('label_title');?></th>
					<th><?php echo lang('classifieds_from');?></th>
					<th><?php echo lang('classifieds_to');?></th>
					<th><?php echo lang('label_status');?></th>
					<th><?php echo lang("column_created"); ?></th>
					<th><?php echo lang("column_modified"); ?></th>
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
					<td><?php echo anchor(SITE_AREA . '/content/listings/edit_classified/' . $record->id, '<span class="icon-pencil"></span>' .  $record->title); ?></td>
				<?php else : ?>
					<td><?php e($record->title); ?></td>
				<?php endif; ?>
					<td><?php e($record->from) ?></td>
					<td><?php e($record->to) ?></td>
					<td><?php echo $record->active == 0 ? anchor(SITE_AREA . '/content/listings/change_status/classifieds/' . $record->listing_id .'/' . $record->id, '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/content/listings/change_status/classifieds/' . $record->listing_id .'/' . $record->id, '<span class="label label-success">' . lang('us_active') . '</span>' ); ?></td>
					<td><?php e($record->created_on) ?></td>
					<td><?php e($record->modified_on) ?></td>
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