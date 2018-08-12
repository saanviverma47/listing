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

if (isset($classifieds))
{
	$classifieds = (array) $classifieds;
}
$id = isset($classifieds['id']) ? $classifieds['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
		
			<div class="control-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title'). lang('bf_form_label_required'), 'classifieds_title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='classifieds_title' type='text' name='classifieds_title' class='span6' maxlength="100" value="<?php echo set_value('classifieds_title', isset($classifieds['title']) ? $classifieds['title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('title'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('image') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_image'), 'image', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='image' type='file' name='image' maxlength="100" />
					<span class='help-inline'><?php echo form_error('image'); ?></span>
					<p class="help-block"><?php echo sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height'));?></p>
					<?php if(!empty($_POST['uploaded_image']) || (isset($classifieds) && !empty($classifieds['image']))): ?>
							<input type="input" name="uploaded_image" id="uploaded_image"  class="readonly-field" readonly="readonly" value="<?php echo !empty($_POST['uploaded_image']) ? $_POST['uploaded_image'] : (!empty($classifieds['image']) ? $classifieds['image'] : '');?>" />
						<?php else: ?>
							<input type="hidden" name="uploaded_image" id="uploaded_image" />
						<?php endif;?>	
					<?php if(!empty($classifieds['image'])) {?>
						<div class="fileupload-preview fileupload-exists thumbnail module-img-thumb admin-thumb">
						<a rel="gallery" href="<?php echo base_url("assets/images/classifieds/" .$classifieds['image']);?>" class="iframe-img">
							<img src="<?php echo base_url("assets/images/classifieds/" .$classifieds['image']);?>" class="module-img">
						</a>
						</div>
					<?php } ?>
				</div>
			</div>

			<div class="control-group <?php echo form_error('from') ? 'error' : ''; ?>">
				<?php echo form_label(lang('classifieds_from'), 'classifieds_from', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='classifieds_from' type='text' name='classifieds_from'  class='span6' value="<?php echo set_value('classifieds_from', isset($classifieds['from']) ? $classifieds['from'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('from'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('to') ? 'error' : ''; ?>">
				<?php echo form_label(lang('classifieds_to'), 'classifieds_to', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='classifieds_to' type='text' name='classifieds_to'  class='span6' value="<?php echo set_value('classifieds_to', isset($classifieds['to']) ? $classifieds['to'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('to'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('price') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_price'), 'classifieds_price', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='classifieds_price' type='text' name='classifieds_price' class='span6' maxlength="100" value="<?php echo set_value('classifieds_price', isset($classifieds['price']) ? $classifieds['price'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('price'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('link') ? 'error' : ''; ?>">
				<?php echo form_label(lang('classifieds_buy'), 'classifieds_link', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='classifieds_link' type='text' name='classifieds_link' class='span6' maxlength="100" value="<?php echo set_value('classifieds_link', isset($classifieds['url']) ? $classifieds['url'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('link'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'classifieds_description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'classifieds_description', 'id' => 'classifieds_description', 'rows' => '5', 'cols' => '80', 'class'=>'span6', 'value' => set_value('classifieds_description', isset($classifieds['description']) ? $classifieds['description'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>

			<?php if(!empty($classifieds)) { echo form_hidden('classifieds_image_name', $classifieds['url']); } ?>
			<?php echo form_hidden('listing_id', $listing_id); ?>
			
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/listings/classifieds/' .$listing_id, lang('cancel'), 'class="btn btn-warning"'); ?>
			
			<?php if(isset($classifieds['id'])) {?>
			<?php if ($this->auth->has_permission('Listings.Content.Delete')) : ?>
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