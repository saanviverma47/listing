<?php 
 
 
 
 
 
 
 
 
 
 
 
 

?>
<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading"><?php echo lang('validations_error')?></h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($tags))
{
	$tags = (array) $tags;
}
$id = isset($tags['id']) ? $tags['id'] : '';

?>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_name'). lang('bf_form_label_required'), 'tags_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='tags_name' type='text' name='tags_name' maxlength="255" placeholder='<?php echo lang('placeholder_tag_name')?>' class='span6' value="<?php echo set_value('tags_name', isset($tags['name']) ? $tags['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
					<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				</div>				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
<style>
th.id { width: 3em; }
th.last-login { width: 11em; }
th.status { width: 10em; }
</style>
<ul class="nav nav-tabs" >
	<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('us_tab_all_tags')); ?></li>
	<li<?php echo $filter_type == 'active' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'active/', lang('us_tab_active')); ?></li>
	<li<?php echo $filter_type == 'inactive' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'inactive/', lang('us_tab_inactive')); ?></li>
</ul>
<?php

$num_columns	= 5;
$can_delete	= $this->auth->has_permission('Tags.Content.Delete');
$can_edit		= $this->auth->has_permission('Tags.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string()); ?>
		<div class="input-append pull-right">
	    	<input class="span3" id="search" type="text" name="search" placeholder="<?php echo lang('placeholder_admin_tag_search');?>" value="<?php echo set_value('search', isset($_POST['search']) ? $_POST['search'] : ''); ?>" />
	    	<button class="btn" type="submit"><?php echo lang('label_admin_search');?></button>
	    </div>
		<table class="table table-striped" id="flex_table_">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					<th><?php echo lang('label_id');?></th>
					<th><?php echo lang('label_name');?></th>
					<th><?php echo lang("column_created"); ?></th>
					<th><?php echo lang("column_modified"); ?></th>
					<th><?php echo lang('label_status');?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<tr>
					<td colspan="<?php echo $num_columns + 1; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="activate" class="btn" value="<?php echo lang('bf_action_activate'); ?>" />
						<input type="submit" name="deactivate" class="btn" value="<?php echo lang('bf_action_deactivate'); ?>" />
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>')" />
					</td>
				</tr>
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
					<td><?php e($record->id); ?></td>
				<?php if ($can_edit) : ?>
					<?php if($this->uri->segment(5) && ($this->uri->segment(6))): ?>
					<td><?php echo anchor(SITE_AREA . '/content/tags/index/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/' . $record->id, '<span class="icon-pencil"></span>' .  $record->name); ?></td>
					<?php elseif($this->uri->segment(5)):?>
					<td><?php echo anchor(SITE_AREA . '/content/tags/index/'.$this->uri->segment(5).'/0/' . $record->id, '<span class="icon-pencil"></span>' .  $record->name); ?></td>
					<?php else:?>
					<td><?php echo anchor(SITE_AREA . '/content/tags/index/all/0/' . $record->id, '<span class="icon-pencil"></span>' .  $record->name); ?></td>
					<?php endif;?>
				<?php else : ?>
					<td><?php e($record->name); ?></td>
				<?php endif; ?>
					<td><?php e($record->created_on) ?></td>
					<td><?php e($record->modified_on) ?></td>
					<td>
						<?php if ($record->active) : ?>
						<?php echo anchor(SITE_AREA . '/content/tags/change_status/' . $record->id, '<span class="label label-success">' . lang('us_active') . '</span>' ); ?>
						<?php else : ?>
						<?php echo anchor(SITE_AREA . '/content/tags/change_status/' . $record->id, '<span class="label label-warning">' . lang('us_inactive') . '</span>' ); ?>
						<?php endif; ?>
					</td>					
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr><td colspan="<?php echo $num_columns; ?>"><?php echo lang('label_no_record_found');?></td></tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); 
	echo $this->pagination->create_links();
	?>
</div>