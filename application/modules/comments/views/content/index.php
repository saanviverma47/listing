<?php 
 
 
 
 
 
 
 
 
 
 
 
 

?>
<style>
th.id { width: 3em; }
th.last-login { width: 11em; }
th.status { width: 10em; }
</style>
<ul class="nav nav-tabs" >
	<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('comments_tab_all')); ?></li>
	<li<?php echo $filter_type == 'active' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'active/', lang('comments_tab_active')); ?></li>
	<li<?php echo $filter_type == 'inactive' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'inactive/', lang('comments_tab_inactive')); ?></li>
	<li<?php echo $filter_type == 'flagged' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'flagged/', lang('comments_tab_flagged')); ?></li>
	<li<?php echo $filter_type == 'spammed' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'spammed/', lang('comments_tab_spammed')); ?></li>
	<li<?php echo $filter_type == 'rejected' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'rejected/', lang('comments_tab_rejected')); ?></li>
	<li<?php echo $filter_type == 'deleted' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'deleted/', lang('comments_tab_deleted')); ?></li>
</ul>

<?php

$num_columns	= 9;
$can_delete	= $this->auth->has_permission('Comments.Content.Delete');
$can_edit		= $this->auth->has_permission('Comments.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string()); ?>
		<div class="input-append pull-right">
	    	<input class="span3" id="search" type="text" name="search" placeholder="<?php echo lang('placeholder_admin_comment_search');?>" value="<?php echo set_value('search', isset($_POST['search']) ? $_POST['search'] : ''); ?>" />
	    	<button class="btn" type="submit"><?php echo lang('label_admin_search');?></button>
	    </div>
	    <br />
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					<th style="width: 1%"><?php echo lang('label_id');?></th>
					<th style="width: 17%"><?php echo lang('label_listing');?></th>
					<th style="width: 15%"><?php echo lang('label_user');?></th>
					<th style="width: 40%"><?php echo lang('label_comment');?></th>
					<th style="width: 5%"><?php echo lang('label_status');?></th>
					<th style="width: 15%"><?php echo lang('label_posted_on');?></th>
					<th style="width: 5%"><?php echo lang('label_action');?></th>
				</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="<?php echo $num_columns; ?>">
					<?php
					echo lang('bf_with_selected');

					if ($filter_type == 'deleted') :
					?>
					<input type="submit" name="submit" class="btn" value="<?php echo lang('comments_action_restore'); ?>" />
					<input type="submit" name="submit" class="btn btn-danger" value="<?php echo lang('comments_action_purge'); ?>" onclick="return confirm('<?php e(js_escape(lang('comments_purge_del_confirm'))); ?>')" />
					<?php else : ?>
					<input type="submit" name="submit" class="btn" value="<?php echo lang('comments_action_activate'); ?>" />
					<input type="submit" name="submit" class="btn" value="<?php echo lang('comments_action_deactivate'); ?>" />
					<input type="submit" name="submit" class="btn" value="<?php echo lang('comments_action_flag'); ?>" />
					<input type="submit" name="submit" class="btn" value="<?php echo lang('comments_action_spam'); ?>" />
					<input type="submit" name="submit" class="btn" value="<?php echo lang('comments_action_reject'); ?>" />
					<input type="submit" name="submit" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('comments_delete_account_confirm'))); ?>')" />
					<?php endif;?>
				</td>
			</tr>
		</tfoot>
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
					<td><?php e($record->title) ?></td>				
					<td><?php e(ucwords(strtolower($record->username))) ?></td>
					<td><?php e($record->comment) ?></td>
					<td>
					<?php 
					switch($record->status) {
						case 0:
							echo '<span class="label btn-warning">'. lang('comments_inactive') .'</span>';
							break;
						case 1:
							echo '<span class="label btn-success">'. lang('comments_active') .'</span>';
							break;
						case 2:
							echo '<span class="label btn-info">'. lang('comments_flag') .'</span>';
							break;
						case 3:
							echo '<span class="label btn-active">'. lang('comments_spam') .'</span>';
							break;
						case 4:
							echo '<span class="label btn-danger">'. lang('comments_reject') .'</span>';
							break;
					}
					?></td>
					<td><?php e($record->created_on) ?></td>
					<td><?php echo anchor(SITE_AREA . '/content/comments/edit/' . $record->id, '<span class="label btn-info">'.lang('label_view').'</span>'); ?> </td>
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