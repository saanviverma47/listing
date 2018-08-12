<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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

if (isset($comments))
{
	$comments = (array) $comments;
}
$id = isset($comments['id']) ? $comments['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('listing_id') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_listing'), 'comments_listing_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='comments_listing_id' type='text' class="span6" name='comments_listing_id' maxlength="11" value="<?php echo set_value('comments_listing_id', isset($comments['title']) ? $comments['title'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('listing_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('user_id') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_user'), 'comments_user_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='comments_user_id' type='text' class="span6" name='comments_user_id' maxlength="11" value="<?php echo set_value('comments_user_id', isset($comments['display_name']) ? $comments['display_name'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('user_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('comment') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_comment'). lang('bf_form_label_required'), 'comments_comment', array('class' => 'control-label') ); ?>
				<div class='controls'>					
					<?php echo form_textarea( array( 'name' => 'comments_comment', 'id' => 'comments_comment', 'class' => 'span6', 'rows' => '5', 'cols' => '80', 'value' => set_value('comments_comment', isset($comments['comment']) ? $comments['comment'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('comment'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('ip') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_ip_address'), 'comments_ip', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='comments_ip' type='text' class="span6" name='comments_ip' maxlength="50" value="<?php echo set_value('comments_ip', isset($comments['ip']) ? $comments['ip'] : ''); ?>" readonly/>
					<span class='help-inline'><?php echo form_error('ip'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					0 => lang('comments_inactive'),
					1 => lang('comments_active'),
					2 => lang('comments_flag'),
					3 => lang('comments_spam'),
					4 => lang('comments_reject')
				);

				echo form_dropdown('comments_status', $options, set_value('comments_status', isset($comments['status']) ? $comments['status'] : ''), 'Status', 'class="span6"');
			?>			
			
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/comments', lang('cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Comments.Content.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>