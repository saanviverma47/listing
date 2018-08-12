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

if (isset($pages))
{
	$pages = (array) $pages;
}
$id = isset($pages['id']) ? $pages['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<?php // Change the values in this array to populate your dropdown as required
				echo form_dropdown('pages_parent_id', $pages_no_parents, set_value('pages_parent_id', isset($pages['parent_id']) ? $pages['parent_id'] : ''), 'Parent ID', 'class = "span6"');
			?>

			<div class="control-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title'). lang('bf_form_label_required'), 'pages_title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pages_title' type='text' class="span6" name='pages_title' maxlength="100" value="<?php echo set_value('pages_title', isset($pages['title']) ? $pages['title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('title'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('slug') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_slug'), 'pages_slug', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pages_slug' type='text' class="span6" name='pages_slug' maxlength="100" value="<?php echo set_value('pages_slug', isset($pages['slug']) ? $pages['slug'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('slug'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('body') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_body'). lang('bf_form_label_required'), 'pages_body', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'pages_body', 'id' => 'pages_body', 'class' => 'span6', 'rows' => '5', 'cols' => '80', 'value' => set_value('pages_body', isset($pages['body']) ? $pages['body'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('body'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('meta_title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_meta_title'), 'pages_meta_title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='pages_meta_title' type='text' class="span6" name='pages_meta_title' maxlength="100" value="<?php echo set_value('pages_meta_title', isset($pages['meta_title']) ? $pages['meta_title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('meta_title'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('meta_keywords') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_meta_keywords'), 'pages_meta_keywords', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'pages_meta_keywords', 'id' => 'pages_meta_keywords', 'class' => 'span6', 'rows' => '5', 'cols' => '80', 'value' => set_value('pages_meta_keywords', isset($pages['meta_keywords']) ? $pages['meta_keywords'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('meta_keywords'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('meta_description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_meta_description'), 'pages_meta_description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'pages_meta_description', 'id' => 'pages_meta_description', 'class' => 'span6', 'rows' => '5', 'cols' => '80', 'value' => set_value('pages_meta_description', isset($pages['meta_description']) ? $pages['meta_description'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('meta_description'); ?></span>
				</div>
			</div>
			
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'footer' => lang('label_footer'),
					'header' => lang('label_header'),
					'both'	=> 	lang('label_both')
				);
				echo form_dropdown('pages_location', $options, set_value('pages_location', isset($pages['location']) ? $pages['location'] : ''), lang('label_location'), 'class = "span6"');
			?>

			<div class="control-group <?php echo form_error('active') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_status'), 'pages_active', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='pages_active'>
						<input type='checkbox' id='pages_active' name='pages_active' value='1' <?php echo (isset($pages['active']) && $pages['active'] == 1) ? 'checked="checked"' : set_checkbox('pages_active', 1); ?>>
						<span class='help-inline'><?php echo form_error('active'); ?></span>
					</label>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/pages', lang('cancel'), 'class="btn btn-warning"'); ?>
			<?php if(isset($pages['id'])) {?>
			<?php if ($this->auth->has_permission('Pages.Content.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('delete_record'); ?>
				</button>
			<?php endif; ?>
			<?php }?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>