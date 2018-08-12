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

if (isset($banners))
{
	$banners = (array) $banners;
}
$id = isset($banners['id']) ? $banners['id'] : '';

?>
<div class="admin-box">
	<?php echo anchor(SITE_AREA . '/settings/banners/banner_types', '<span class="icon-home"></span>' .  ' Back to Banner Types'); ?>

	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

		<?php echo form_hidden('type', $banners['type']); //banner type value?>
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'image' => lang('label_image'),
					'html'	=> lang('label_html'),
					'text'	=> lang('label_text')
				);
				$js = 'class="span6"';
				if(isset($banners['type'])) {
					$js .= ' disabled';
				}							

				echo form_dropdown('type', $options, set_value('type', isset($banners['type']) ? $banners['type'] : ''), lang('label_banner_type'), $js);
			?>
			
			<div class="control-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title'). lang('bf_form_label_required'), 'title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='title' type='text' name='title' class="span6" maxlength="100" value="<?php echo set_value('title', isset($banners['title']) ? $banners['title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('title'); ?></span>
				</div>
			</div>
			<?php if($banners['type'] == 'image'):?>
			<div id="image-fields" class="control-group">
				<div class="control-group <?php echo form_error('filesize') ? 'error' : ''; ?>">
					<?php echo form_label(lang('label_filesize'). lang('bf_form_label_required'), 'filesize', array('class' => 'control-label') ); ?>
					<div class='controls'>
						<input id='filesize' type='text' name='filesize' class="span6" value="<?php echo set_value('filesize', isset($banners['filesize']) ? $banners['filesize'] : ''); ?>" />
						<span class='help-inline'><?php echo form_error('filesize'); ?></span>
					</div>
				</div>			
			</div>
			<?php endif;?>
			<div class="control-group <?php echo form_error('width') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_width'). lang('bf_form_label_required'), 'width', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='width' type='text' name='width' class="span6" maxlength="100" value="<?php echo set_value('width', isset($banners['width']) ? $banners['width'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('width'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('height') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_height'). lang('bf_form_label_required'), 'height', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='height' type='text' name='height' class="span6" maxlength="20" value="<?php echo set_value('height', isset($banners['height']) ? $banners['height'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('height'); ?></span>
				</div>
			</div>
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'top' => lang('label_top'),
					'left'	=> lang('label_left'),
					'right'	=> lang('label_right'),
					'middle' => lang('label_middle'),
					'bottom'	=> lang('label_bottom'),
					'slider'	=> lang('label_front_slider')
				);

				echo form_dropdown('location', $options, set_value('location', isset($banners['location']) ? $banners['location'] : ''), lang('label_location'), 'class="span6"');
			?>
			
			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'description', 'id' => 'description', 'rows' => '5', 'cols' => '80', 'class' => 'span6', 'value' => set_value('description', isset($banners['description']) ? $banners['description'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>
			
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/settings/banners/banner_types', lang('cancel'), 'class="btn btn-warning"'); ?>
			
			<?php if(isset($banners['id'])) {?>
			<?php if ($this->auth->has_permission('Banners.Settings.Delete')) : ?>
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