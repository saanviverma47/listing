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
	<?php echo form_open_multipart($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING'], 'class="form-horizontal"'); ?>
		<fieldset>
		
			<div class="form-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title'). lang('bf_form_label_required'), 'classifieds_title', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='classifieds_title' type='text' name='classifieds_title' class='form-control' maxlength="100" placeholder="<?php echo sprintf(lang('placeholder_title_common'), strtolower(lang('label_classified')));?>" value="<?php echo set_value('classifieds_title', isset($classifieds['title']) ? $classifieds['title'] : ''); ?>" />
					<span class='help-block'><?php echo form_error('title'); ?></span>
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
			<?php if(!empty($classifieds['image'])):?>
				<img src="<?php echo base_url(); ?>assets/images/classifieds/<?php echo $classifieds['image']; ?>"
						class="thumbnail img-responsive listing-logo"
						alt="<?php echo $classifieds['title'];?>"
						title="<?php echo $classifieds['title'];?>" />
			<?php else: ?>
				<img src="<?php echo base_url(); ?>assets/images/no-logo.png"
						class="thumbnail img-responsive listing-logo"
						alt="<?php echo !empty($classifieds['title']) ? $classifieds['title'] : '';?>" />
			<?php endif; ?>
			</div>
			</div>			
		
			<div class="form-group <?php echo form_error('from') ? 'error' : ''; ?>">
				<?php echo form_label(lang('classifieds_from'), 'classifieds_from', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='classifieds_from' type='text' name='classifieds_from'  class='form-control' placeholder="<?php echo lang('placeholder_from');?>" value="<?php echo set_value('classifieds_from', isset($classifieds['from']) ? $classifieds['from'] : ''); ?>" data-date-format="YYYY-MM-DD HH:mm:ss" />
					<span class='help-block'><?php echo form_error('from'); ?></span>
				</div>
			</div>

			<div class="form-group <?php echo form_error('to') ? 'error' : ''; ?>">
				<?php echo form_label(lang('classifieds_to'), 'classifieds_to', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='classifieds_to' type='text' name='classifieds_to'  class='form-control' placeholder="<?php echo lang('placeholder_to');?>" value="<?php echo set_value('classifieds_to', isset($classifieds['to']) ? $classifieds['to'] : ''); ?>" data-date-format="YYYY-MM-DD HH:mm:ss" />
					<span class='help-block'><?php echo form_error('to'); ?></span>
				</div>
			</div>
			
			<div class="form-group <?php echo form_error('price') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_price'), 'classifieds_price', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='classifieds_price' type='text' name='classifieds_price' class='form-control' maxlength="100" placeholder="<?php echo sprintf(lang('placeholder_price'), strtolower(lang('label_classified')));?>" value="<?php echo set_value('classifieds_price', isset($classifieds['price']) ? $classifieds['price'] : ''); ?>" />
					<span class='help-block'><?php echo form_error('price'); ?></span>
				</div>
			</div>
			
			<div class="form-group <?php echo form_error('link') ? 'error' : ''; ?>">
				<?php echo form_label(lang('classifieds_buy'), 'classifieds_link', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<input id='classifieds_link' type='text' name='classifieds_link' class='form-control' maxlength="100" placeholder="<?php echo lang('placeholder_buy');?>" value="<?php echo set_value('classifieds_link', isset($classifieds['url']) ? $classifieds['url'] : ''); ?>" />
					<span class='help-block'><?php echo form_error('link'); ?></span>
				</div>
			</div>
			
			<div class="form-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'classifieds_description', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
					<?php echo form_textarea( array( 'name' => 'classifieds_description', 'id' => 'classifieds_description', 'rows' => '5', 'cols' => '80', 'class'=>'form-control', 'placeholder'=> sprintf(lang('placeholder_desc'), strtolower(lang('label_classified'))), 'value' => set_value('classifieds_description', isset($classifieds['description']) ? $classifieds['description'] : '', false) ) ); ?>
					<span class='help-block'><?php echo form_error('description'); ?></span>
				</div>
			</div>

			<?php if(!empty($classifieds)) { echo form_hidden('classifieds_image_name', $classifieds['image']); } ?>
			<?php echo form_hidden('listing_id', $listing_id); ?>
			<div class="col-sm-6 col-sm-offset-6 controls">
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(site_url('members/classifieds?id=' .$this->encrypt->encode($listing_id)), lang('cancel'), 'class="btn btn-warning"'); ?>
			
			<?php if(isset($classifieds['id'])) {?>
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
<!--  Modal content -->
<div class="modal fade image-popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">			
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h4 class="modal-title" id="myLargeModalLabel-1"><?php echo !empty($classifieds) ? $classifieds['title'] : '';?></h4>
			</div>
			<div class="modal-body">
				<?php if(!empty($classifieds['image'])):?>
				<img src="<?= base_url(); ?>assets/images/classifieds/<?= $classifieds['image']; ?>" class="img-responsive img-rounded center-block" alt="">
	        	<?php endif;?>
	        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal image -->
  
</div>