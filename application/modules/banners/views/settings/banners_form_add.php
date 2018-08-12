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

if (isset($banners)) {
	$banners = (array) $banners;
}
$id = isset($banners['id']) ? $banners['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<?php echo form_hidden('banners_type'); //banner type value?>
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
						'' => lang('label_select'),
				);
				if($banner_types != false) {	
					foreach ($banner_types as $type) {
						$options[$type->id] = $type->title;
					}
				}

				echo form_dropdown('banners_type_id', $options, set_value('banners_type_id', isset($banners['type_id']) ? $banners['type_id'] : ''), lang('label_banner_type'). lang('bf_form_label_required'), 'class="span6"');
			?>
			
			<div class="control-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title'). lang('bf_form_label_required'), 'banners_title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='banners_title' type='text' name='banners_title' class="span6" maxlength="100" value="<?php echo set_value('banners_title', isset($banners['title']) ? $banners['title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('title'); ?></span>
				</div>
			</div>

			<div id="image-fields" class="control-group">
			<div class="control-group <?php echo form_error('image') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_banner') .' '. lang('label_image'), 'banners_image', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='banners_image' type='file' name='banners_image' class="span6" maxlength="100" />
					<span class='help-inline'><?php echo form_error('image'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('url') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_url'), 'banners_url', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='banners_url' type='text' name='banners_url' class="span6" maxlength="100" value="<?php echo set_value('banners_url', isset($banners['url']) ? $banners['url'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('url'); ?></span>
				</div>
			</div>
			
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
						'_blank' 	=> lang('option_new_window'),
						'_self'		=> lang('option_same_window'),
						'_top' 		=> lang('option_top_window'),
						'_parent'	=> lang('option_parent_window')
					);

				echo form_dropdown('banners_target', $options, set_value('banners_target', isset($banners['target']) ? $banners['target'] : ''), lang('label_target'), 'class="span6"');
			?>

			<div class="control-group <?php echo form_error('start_date') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_start_date'), 'banners_start_date', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='banners_start_date' type='text' name='banners_start_date' class="span6" value="<?php echo set_value('banners_start_date', isset($banners['start_date']) ? $banners['start_date'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('start_date'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('end_date') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_end_date'), 'banners_end_date', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='banners_end_date' type='text' name='banners_end_date' class="span6" value="<?php echo set_value('banners_end_date', isset($banners['end_date']) ? $banners['end_date'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('end_date'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('max_impressions') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_max_impressions'), 'banners_max_impressions', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='banners_max_impressions' type='text' name='banners_max_impressions' class="span6" value="<?php echo set_value('banners_max_impressions', isset($banners['max_impressions']) ? $banners['max_impressions'] : 0); ?>" />
					<span class='help-inline'><?php echo form_error('max_impressions'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('max_clicks') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_max_clicks'), 'banners_max_clicks', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='banners_max_clicks' type='text' name='banners_max_clicks' class="span6" value="<?php echo set_value('banners_max_clicks', isset($banners['max_clicks']) ? $banners['max_clicks'] : 0); ?>" />
					<span class='help-inline'><?php echo form_error('max_clicks'); ?></span>
				</div>
			</div>
			
			</div><!-- end of image-fields -->
			
			<!-- slider fields -->
			<div id="slider-fields" class="control-group">
			<div class="control-group <?php echo form_error('slider_heading') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_slider_heading'), 'banners_slider_heading', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='banners_slider_heading' type='text' name='banners_slider_heading' class="span6" maxlength="100" value="<?php echo set_value('banners_slider_heading', isset($banners['slider_heading']) ? $banners['slider_heading'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('slider_heading'); ?></span>
				</div>
			</div>
			</div><!-- end of slider fields -->
			
			<!-- html-text fields -->
			<div id="html-text-fields" class="control-group">
			<div class="control-group <?php echo form_error('html_text') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_text_html'), 'banners_html_text', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'banners_html_text', 'id' => 'banners_html_text', 'rows' => '5', 'cols' => '80', 'class' => 'span6', 'value' => set_value('banners_html_text', isset($banners['html_text']) ? $banners['html_text'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('html_text'); ?></span>
				</div>
			</div>
			</div><!-- end of html-text fields -->
			
			<?php echo form_hidden('selected_locations', '', 'selected_locations'); ?>
			<div class="control-group <?php echo form_error('locations') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_locations'), 'banners_locations', array('class' => 'control-label') ); ?>
				<div class='controls'>
				<p>
				    <a href="#" id="btnLocationsSelectAll"><?php echo lang('label_select_all');?></a> -
				    <a href="#" id="btnLocationsDeselectAll"><?php echo lang('label_deselect_all');?></a> -
				    <a href="#" id="btnLocationsToggleSelect"><?php echo lang('label_toggle_select');?></a>
				 </p>
					<div id="locations_tree" style="max-height: 250px; overflow-y: scroll; margin-left: 0px;"></div>
				</div>
			</div>
			
			<!-- common fields for images and html or text -->
			<div id="common-fields" class="control-group">
			<?php echo form_hidden('selected_categories', '', 'selected_categories'); ?>
			<div class="control-group <?php echo form_error('categories') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_categories'), 'banners_categories', array('class' => 'control-label') ); ?>
				<div class='controls'>
				<p>
				    <a href="#" id="btnSelectAll"><?php echo lang('label_select_all');?></a> -
				    <a href="#" id="btnDeselectAll"><?php echo lang('label_deselect_all');?></a> -
				    <a href="#" id="btnToggleSelect"><?php echo lang('label_toggle_select');?></a>
				 </p>
					<div id="categories_tree" style="max-height: 250px; overflow-y: scroll; margin-left: 0px;"></div>
				</div>
			</div>			

			<div class="control-group <?php echo form_error('all_pages') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_all_pages'), 'banners_all_pages', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='banners_all_pages'>
						<input type='checkbox' id='banners_all_pages' name='banners_all_pages' value='1' <?php echo (isset($banners['all_pages']) && $banners['all_pages'] == 1) ? 'checked="checked"' : set_checkbox('banners_all_pages', 1); ?>>
						<span class='help-inline'><?php echo form_error('all_pages'); ?></span>
					</label>
				</div>
			</div>
			</div><!-- end of common fields -->

			<div class="control-group <?php echo form_error('active') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_status'), 'banners_active', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='banners_active'>
						<input type='checkbox' id='banners_active' name='banners_active' value='1' <?php echo (isset($banners['active']) && $banners['active'] == 1) ? 'checked="checked"' : set_checkbox('banners_active', 1); ?>>
						<span class='help-inline'><?php echo form_error('active'); ?></span>
					</label>
				</div>
			</div>
			
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/settings/banners', lang('cancel'), 'class="btn btn-warning"'); ?>
			</div>
			
		</fieldset>
    <?php echo form_close(); ?>
</div>