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
	<?php echo form_open_multipart($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING'], 'class="form-horizontal"');?>
		<fieldset>

			<div class="form-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title'). lang('bf_form_label_required'), 'products_title', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='products_title' type='text' name='products_title' class='form-control' maxlength="100" value="<?php echo set_value('products_title', isset($products['title']) ? $products['title'] : ''); ?>" />
					<span class='help-block'><?php echo form_error('title'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<?php echo form_label(lang('label_type') .lang('bf_form_label_required'), 'products_type', array('class' => 'col-sm-3 control-label') ); ?>
				<select name="products_type" id="products_type" class="col-sm-9" placeholder="<?php echo lang('placeholder_select_product');?>">
					<option value =""><?php echo lang('label_select');?></option>
					<option value ="product" <?php echo (!empty($_POST['products_type']) && $_POST['products_type'] == 'product') || (isset($products['type']) && ($products['type']) == 'product') ? 'selected' : '';?>><?php echo lang('label_product'); ?></option>
					<option value ="service" <?php echo (!empty($_POST['products_type']) && $_POST['products_type'] == 'service') || (isset($products['type']) && ($products['type']) == 'service') ? 'selected' : '';?>><?php echo lang('label_service'); ?></option>
				</select>
			</div>
			
			<div class="form-group <?php echo form_error('price') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_price'), 'products_price', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='products_price' type='text' name='products_price' class='form-control' maxlength="100" value="<?php echo set_value('products_price', isset($products['price']) ? $products['price'] : ''); ?>" />
					<span class='help-block'><?php echo form_error('price'); ?></span>
				</div>
			</div>				
			
			<div class="editme">
			<div class="form-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'products_description', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<?php echo form_textarea( array( 'name' => 'products_description', 'id' => 'products_description', 'rows' => '5', 'cols' => '80', 'class'=>'form-control', 'value' => set_value('products_description', isset($products['description']) ? $products['description'] : '', false) ) ); ?>
					<span class='help-block'><?php echo form_error('description'); ?></span>
				</div>
			</div>
			</div>
			
			<div class="form-group <?php echo form_error('image') ? 'error' : ''; ?> mrg-view">
				<label class="col-sm-3 control-label required" for="image"><?php echo lang('label_image'); ?></label>
				<div class="col-sm-6">
					<div class="input-group">
						<input id='image' type='file' name='image' maxlength="100"
							class="form-control" /> <span class='help-block'><?php echo form_error('image'); ?></span>
					</div>
					<p class="help-block"><?php echo sprintf(lang('image_help'), settings_item('lst.image_file_size'), settings_item('lst.image_width'), settings_item('lst.image_height'));?></p>
					<input type="hidden" name="uploaded_image" id="uploaded_image" />			
			</div>
				<div class="col-sm-3">
			<?php if(!empty($products['image'])):?>
				<img src="<?php echo base_url(); ?>assets/images/products/<?php echo $products['image']; ?>"
						class="thumbnail img-responsive listing-logo"
						alt="<?php echo $products['title'];?>"
						title="<?php echo $products['title'];?>" />
			<?php else: ?>
				<img src="<?php echo base_url(); ?>assets/images/no-logo.png"
						class="thumbnail img-responsive listing-logo"
						alt="<?php echo !empty($products['title']) ? $products['title'] : '';?>" />
			<?php endif; ?>
			</div>
			</div>	
      
			<!--  Modal content -->
			  <div class="modal fade image-popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-1" aria-hidden="true">
			    <div class="modal-dialog modal-lg">
			      <div class="modal-content">
			
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			          <h4 class="modal-title" id="myLargeModalLabel-1"><?php echo isset($products) ? $products['title'] : '';?></h4>
			        </div>
			        <div class="modal-body">
			        <?php if(!empty($products['image'])):?>
			        <img src="<?= base_url(); ?>assets/images/products/<?= $products['image']; ?>" class="img-responsive img-rounded center-block" alt="">
			        <?php endif;?>
			        </div>
			      </div><!-- /.modal-content -->
			    </div><!-- /.modal-dialog -->
			  </div><!-- /.modal image -->
			
			<?php if(!empty($products)) { echo form_hidden('products_image_name', $products['image']); } ?>
			<?php echo form_hidden('products_listing_id', $listing_id); ?>
			<div class="col-sm-6 col-sm-offset-6 controls">
				<div class="form-actions">
					<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save'); ?>"  />
					<?php echo lang('bf_or'); ?>
					<?php echo anchor(site_url('members/products?id=' .$this->encrypt->encode($listing_id)), lang('cancel'), 'class="btn btn-warning"'); ?>
				
					<?php if(isset($products['id'])) {?>
					<?php if ($this->auth->restrict()) : ?>
						or
						<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
							<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('delete_record'); ?>
						</button>
					<?php endif; ?>
					<?php }?>
				</div>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>