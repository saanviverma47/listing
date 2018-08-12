<?php

$num_columns	= 11;
$can_delete	= $this->auth->has_permission('Categories.Content.Delete');
$can_edit		= $this->auth->has_permission('Categories.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string()); ?>
		<div class="input-append pull-right">
	    	<input class="span3" id="search" type="text" name="search" placeholder="<?php echo lang('placeholder_admin_category_search');?>" value="<?php echo set_value('search', isset($_POST['search']) ? $_POST['search'] : ''); ?>" />
	    	<button class="btn" type="submit"><?php echo lang('label_admin_search');?></button>
	    </div>
	    <br />
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					<th><?php echo lang('label_id');?></th>
					<th><?php echo lang('label_parent_id');?></th>
					<th><?php echo lang('label_name');?></th>
					<th><?php echo lang('label_slug');?></th>
					<?php if($this->uri->segment(5)):?>
						<th><?php echo lang('label_parent_name');?></th>
					<?php endif; ?>
					<th><?php echo lang('label_counts');?></th>
					<th><?php echo lang('label_number_of_hits');?></th>
					<th style="text-align: center"><?php echo lang('label_action');?></th>										
					
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
					<td><?php echo $record->id; ?></td>
					<td><?php e($record->parent_id) ?></td>
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/content/categories/edit/' . $record->id, $record->name); $this->session->set_userdata('parent_category_navigation', $this->uri->segment(5));?></td>
				<?php else : ?>
					<td><?php e($record->name); ?></td>
				<?php endif; ?>
					<td><?php e($record->slug) ?></td>
					<?php if($this->uri->segment(5)):?>
					<td><?php e($parent_name) ?></td>
					<?php endif; ?>
					<td><?php e($record->counts) ?></td>
					<td><?php e($record->hits) ?></td>
					<td style="text-align: center">
					<?php if(settings_item('lst.categories_level') == 1):?>
					<?php if($this->uri->segment(6)):?>
					<?php echo $record->active == 0 ? anchor(SITE_AREA . '/content/categories/update_status/' .$record->id.'/' . $this->uri->segment(5).'/' . $this->uri->segment(6), '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' .$this->uri->segment(5).'/' . $this->uri->segment(6), '<span class="label label-success">' . lang('us_active') . '</span>' ); ?>
					<?php else:?>
					<?php echo $record->active == 0 ? anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' . $this->uri->segment(5), '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' . $this->uri->segment(5), '<span class="label label-success">' . lang('us_active') . '</span>' ); ?>
					<?php endif;?>
					<?php elseif(settings_item('lst.categories_level') == 2):?>
					<?php if($this->uri->segment(6)):?>
					<?php echo $record->parent_id == 0 ? anchor(SITE_AREA . '/content/categories/index/' .$record->id, '<span class="label label-info">'.lang('label_view') .' '.lang('label_subcategories').'</span>') : ''?>
					<?php echo $record->active == 0 ? anchor(SITE_AREA . '/content/categories/update_status/' .$record->id.'/' . $this->uri->segment(5).'/' . $this->uri->segment(6), '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' .$this->uri->segment(5).'/' . $this->uri->segment(6), '<span class="label label-success">' . lang('us_active') . '</span>' ); ?>
					<?php else:?>
					<?php echo $record->parent_id == 0 ? anchor(SITE_AREA . '/content/categories/index/' . $record->id, '<span class="label label-info">'.lang('label_view') .' '.lang('label_subcategories').'</span>') : ''?>
					<?php echo $record->active == 0 ? anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' . $this->uri->segment(5), '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' . $this->uri->segment(5), '<span class="label label-success">' . lang('us_active') . '</span>' ); ?>
					<?php endif;?>
					<?php elseif(settings_item('lst.categories_level') == 3):?>
					<?php if($this->uri->segment(6)):?>
					<?php echo anchor(SITE_AREA . '/content/categories/index/' .$record->id, '<span class="label label-info">'.lang('label_view') .' '.lang('label_subcategories').'</span>')?>
					<?php echo $record->active == 0 ? anchor(SITE_AREA . '/content/categories/update_status/' .$record->id.'/' . $this->uri->segment(5).'/' . $this->uri->segment(6), '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' .$this->uri->segment(5).'/' . $this->uri->segment(6), '<span class="label label-success">' . lang('us_active') . '</span>' ); ?>
					<?php else:?>
					<?php echo anchor(SITE_AREA . '/content/categories/index/' . $record->id, '<span class="label label-info">'.lang('label_view') .' '.lang('label_subcategories').'</span>')?>
					<?php echo $record->active == 0 ? anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' . $this->uri->segment(5), '<span class="label label-warning">' . lang('us_inactive') . '</span>' ) : anchor(SITE_AREA . '/content/categories/update_status/' . $record->id.'/' . $this->uri->segment(5), '<span class="label label-success">' . lang('us_active') . '</span>' ); ?>
					<?php endif;?>
					<?php endif;?>
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