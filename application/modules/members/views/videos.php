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

if (isset($videos)) {
	$videos = (array) $videos;
}
$id = isset($videos['id']) ? $videos['id'] : '';

?>
	<?php echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING'], 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="form-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title').lang('label_optional'), 'videos_title', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='videos_title' type='text' name='videos_title' maxlength="100" class="form-control" placeholder="<?php echo lang('placeholder_title_optional');?>" value="<?php echo set_value('videos_title', isset($videos['title']) ? $videos['title'] : ''); ?>" />
					<span class='help-block'><?php echo form_error('title'); ?></span>
				</div>
			</div>

			<div class="form-group <?php echo form_error('url') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_video'). lang('bf_form_label_required'), 'videos_url', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='videos_url' type='text' name='videos_url' maxlength="255" class="form-control" placeholder="<?php echo lang('placeholder_video');?>" value="<?php echo set_value('videos_url', isset($videos['url']) ? 'https://www.youtube.com/watch?v=' .$videos['url'] : ''); ?>" />
					<span class='help-block'><?php echo form_error('url'); ?></span>
				</div>
			</div>
			
			<?php echo form_hidden('listing_id', $listing_id); ?>
			<div class="col-sm-6 col-sm-offset-6 controls">
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save'); ?>"  />
			</div>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
<?php

$num_columns	= 3;
$can_delete	= $this->auth->restrict();
$can_edit		= $this->auth->restrict();
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING']); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th><?php echo lang('label_title');?></th>
					<th><?php echo lang('label_video');?></th>
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
					<td><?php echo anchor(site_url('members/videos?id=' . $this->encrypt->encode($listing_id) .'&video_id=' .urlencode(base64_encode($record->id))), '<span class="icon-pencil"></span>' .  $record->title); ?></td>
				<?php else : ?>
					<td><?php e($record->title); ?></td>
				<?php endif; ?>
					<td>
						<a href="#"><img class="youtube thumbnail img-responsive" style="min-height:70px; height:70px;" rel="<?php e($record->url) ?>" src="http://img.youtube.com/vi/<?php echo $record->url;?>/0.jpg" /></a>
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
	<?php echo form_close(); ?>
</div>