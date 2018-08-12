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

if (isset($products))
{
	$products = (array) $products;
}
$id = isset($products['id']) ? $products['id'] : '';

?>
<div class="admin-box">
	<h5><?php echo sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height'));?></h5>
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"');?>
		<fieldset>

			<div class="control-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title'). lang('bf_form_label_required'), 'products_title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='products_title' type='text' name='products_title' class='span6' maxlength="100" value="<?php echo set_value('products_title', isset($products['title']) ? $products['title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('title'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					''		=> lang('label_select'),
					'product' => lang('label_product'),
					'service' => lang('label_service')
				);

				echo form_dropdown('products_type', $options, set_value('products_type', isset($products['type']) ? $products['type'] : ''), lang('label_type'). lang('bf_form_label_required'), 'class="span6"');
			?>
			
			<div class="control-group <?php echo form_error('price') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_price'), 'products_price', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='products_price' type='text' name='products_price' class='span6' maxlength="100" value="<?php echo set_value('products_price', isset($products['price']) ? $products['price'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('price'); ?></span>
				</div>
			</div>				
			
			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'products_description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'products_description', 'id' => 'products_description', 'rows' => '5', 'cols' => '80', 'class'=>'span6', 'value' => set_value('products_description', isset($products['description']) ? $products['description'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('image') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_image'), 'image', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='image' type='file' name='image' maxlength="100" />
					<span class='help-inline'><?php echo form_error('image'); ?></span>
					<p class="help-block"><?php echo sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height'));?></p>
					<?php if(!empty($_POST['uploaded_image']) || (isset($products) && !empty($products['image']))): ?>
							<input type="input" name="uploaded_image" id="uploaded_image"  class="readonly-field" readonly="readonly" value="<?php echo !empty($_POST['uploaded_image']) ? $_POST['uploaded_image'] : (!empty($products['image']) ? $products['image'] : '');?>" />
						<?php else: ?>
							<input type="hidden" name="uploaded_image" id="uploaded_image" />
						<?php endif;?>	
					<?php if(!empty($products['image'])) {?>
						<div class="fileupload-preview fileupload-exists thumbnail module-img-thumb admin-thumb">
						<a rel="gallery" href="<?php echo base_url("assets/images/products/" .$products['image']);?>" class="iframe-img">
							<img src="<?php echo base_url("assets/images/products/" .$products['image']);?>" class="module-img">
						</a>
						</div>
					<?php } ?>
				</div>
			</div>
			
			<?php if(!empty($products)) { echo form_hidden('products_image_name', $products['image']); } ?>
			<?php echo form_hidden('products_listing_id', $listing_id); ?>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/listings/products/' .$listing_id, lang('cancel'), 'class="btn btn-warning"'); ?>
			
			<?php if(isset($products['id'])) {?>
			<?php if ($this->auth->has_permission('Products.Content.Delete')) : ?>
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