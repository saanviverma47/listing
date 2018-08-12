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

if (isset($packages))
{
	$packages = (array) $packages;
}
$id = isset($packages['id']) ? $packages['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
	<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#main-settings" data-toggle="tab"><?php echo lang('tab_basic_settings') ?></a>
				</li>
				<li>
					<a href="#limit" data-toggle="tab"><?php echo lang('tab_limit') ?></a>
				</li>
				<li>
					<a href="#display_options" data-toggle="tab"><?php echo lang('tab_display_options') ?></a>
				</li>
				<li>
					<a href="#auto_approve_options" data-toggle="tab"><?php echo lang('tab_auto_approve_options') ?></a>
				</li>
				<li>
					<a href="#layout" data-toggle="tab"><?php echo lang('tab_layout_options') ?></a>
				</li>
			</ul>
		<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
		<!-- Start of Main Settings Tab Pane -->
		<div class="tab-pane active" id="main-settings">		
		<fieldset>
			<legend><?php echo lang('label_basic_info'); ?></legend>
			<div class="control-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_title'). lang('bf_form_label_required'), 'packages_title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_title' type='text' name='packages_title' class='span6' maxlength="100" value="<?php echo set_value('packages_title', isset($packages['title']) ? $packages['title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('title'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'packages_description', array('class' => 'control-label') ); ?>
				<div class='controls'>				
					<?php echo form_textarea( array( 'name' => 'packages_description', 'id' => 'packages_description', 'rows' => '5', 'cols' => '80', 'class' => 'span6', 'value' => set_value('packages_description', (isset($packages['description']) ? $packages['description'] : ''), false) ) ); ?>
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>			
	
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'' => lang('label_select'),
					'new'	=> lang('new').' '.lang('label_listing'),
					'upgrade'	=> lang('label_upgrade').' '.lang('label_listing')
				);

				echo form_dropdown('packages_plan_type', $options, set_value('packages_plan_type', isset($packages['plan_type']) ? $packages['plan_type'] : ''), lang('label_plan_type'), 'class="span6"');
			?>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'' => lang('label_select'),
					'free'	=> lang('label_free'),
					'onetime'	=> lang('label_onetime'),
					'subscription'	=> lang('label_subscription'),
					'lifetime' => lang('label_lifetime')
				);

				echo form_dropdown('packages_subscription', $options, set_value('packages_subscription', isset($packages['subscription']) ? $packages['subscription'] : ''), lang('label_subscription'), 'class="span6"');
			?>

			<div class="control-group <?php echo form_error('duration') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_duration'), 'packages_duration', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_duration' type='text' name='packages_duration' class='span6' maxlength="5" value="<?php echo set_value('packages_duration', isset($packages['duration']) ? $packages['duration'] : 0); ?>" />
					<span class='help-inline'><?php echo form_error('duration'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('price') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_price'), 'packages_price', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_price' type='text' name='packages_price' class='span6' maxlength="5" value="<?php echo set_value('packages_price', isset($packages['price']) ? $packages['price'] : 0); ?>" />
					<span class='help-inline'><?php echo form_error('price'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('claim_price') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_claim_price'), 'packages_claim_price', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_claim_price' type='text' name='packages_claim_price' class='span6' maxlength="5" value="<?php echo set_value('packages_claim_price', isset($packages['claim_price']) ? $packages['claim_price'] : 0); ?>" />
					<span class='help-inline'><?php echo form_error('claim_price'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('default') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_set_default'), 'packages_default', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_default'>
						<input type='checkbox' id='packages_default' name='packages_default' value='1' <?php echo (isset($packages['default']) && $packages['default'] == 1) ? 'checked="checked"' : set_checkbox('packages_default', 1); ?>>
						<span class='help-inline'><?php echo form_error('default'); ?></span>
					</label>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('active') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_status'), 'packages_active', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_active'>
						<input type='checkbox' id='packages_active' name='packages_active' value='1' <?php echo (isset($packages['active']) && $packages['active'] == 1) ? 'checked="checked"' : set_checkbox('packages_active', 1); ?>>
						<span class='help-inline'><?php echo form_error('active'); ?></span>
					</label>
			</div>	
			</div>		
			</fieldset>
			</div>
			<!-- Start of Limit Listing Tab Pane -->
			<div class="tab-pane" id="limit">
			<fieldset>
			<legend><?php echo lang('label_limit_listings'); ?></legend>			
			<div class="control-group <?php echo form_error('keywords_limit') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_keywords_limit'), 'packages_keywords_limit', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_keywords_limit' type='text' name='packages_keywords_limit' class='span6' maxlength="2" value="<?php echo set_value('packages_keywords_limit', isset($packages['keywords_limit']) ? $packages['keywords_limit'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('keywords_limit'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('keywords_length') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_keywords_length'), 'packages_keywords_length', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_keywords_length' type='text' name='packages_keywords_length' class='span6' maxlength="5" value="<?php echo set_value('packages_keywords_length', isset($packages['keywords_length']) ? $packages['keywords_length'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('keywords_length'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('description_limit') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description_length'), 'packages_description_limit', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_description_limit' type='text' name='packages_description_limit' class='span6' maxlength="8" value="<?php echo set_value('packages_description_limit', isset($packages['description_limit']) ? $packages['description_limit'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('description_limit'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('images_limit') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_images_limit'), 'packages_images_limit', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_images_limit' type='text' name='packages_images_limit' class='span6' maxlength="4" value="<?php echo set_value('packages_images_limit', isset($packages['images_limit']) ? $packages['images_limit'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('images_limit'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('videos_limit') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_videos_limit'), 'packages_videos_limit', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_videos_limit' type='text' name='packages_videos_limit' class='span6' maxlength="4" value="<?php echo set_value('packages_videos_limit', isset($packages['videos_limit']) ? $packages['videos_limit'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('videos_limit'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('products_limit') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_products_limit'), 'packages_products_limit', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_products_limit' type='text' name='packages_products_limit' class='span6' maxlength="2" value="<?php echo set_value('packages_products_limit', isset($packages['products_limit']) ? $packages['products_limit'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('products_limit'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('classifieds_limit') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_classifieds_limit'), 'packages_classifieds_limit', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_classifieds_limit' type='text' name='packages_classifieds_limit' class='span6' maxlength="2" value="<?php echo set_value('packages_classifieds_limit', isset($packages['classifieds_limit']) ? $packages['classifieds_limit'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('classifieds_limit'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('info_limit') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_info_limit'), 'packages_info_limit', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='packages_info_limit' type='text' name='packages_info_limit' class='span6' maxlength="2" value="<?php echo set_value('packages_info_limit', isset($packages['info_limit']) ? $packages['info_limit'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('info_limit'); ?></span>
				</div>
			</div>

			</fieldset>
			</div>
			<!-- Start of Display Options Tab Pane -->
			<div class="tab-pane" id="display_options">
			<fieldset>
			<legend><?php echo lang('tab_display_options'); ?></legend>
			<div class="control-group <?php echo form_error('address') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_address'), 'packages_address', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_address'>
						<input type='checkbox' id='packages_address' name='packages_address' value='1' <?php echo (isset($packages['address']) && $packages['address'] == 1) ? 'checked="checked"' : set_checkbox('packages_address', 1); ?>>
						<span class='help-inline'><?php echo form_error('address'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('email') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_email'), 'packages_email', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_email'>
						<input type='checkbox' id='packages_email' name='packages_email' value='1' <?php echo (isset($packages['email']) && $packages['email'] == 1) ? 'checked="checked"' : set_checkbox('packages_email', 1); ?>>
						<span class='help-inline'><?php echo form_error('email'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('website') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_website'), 'packages_website', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_website'>
						<input type='checkbox' id='packages_website' name='packages_website' value='1' <?php echo (isset($packages['website']) && $packages['website'] == 1) ? 'checked="checked"' : set_checkbox('packages_website', 1); ?>>
						<span class='help-inline'><?php echo form_error('website'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('map') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_google_map'), 'packages_map', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_map'>
						<input type='checkbox' id='packages_map' name='packages_map' value='1' <?php echo (isset($packages['map']) && $packages['map'] == 1) ? 'checked="checked"' : set_checkbox('packages_map', 1); ?>>
						<span class='help-inline'><?php echo form_error('map'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('logo') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_logo'), 'packages_logo', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_logo'>
						<input type='checkbox' id='packages_logo' name='packages_logo' value='1' <?php echo (isset($packages['logo']) && $packages['logo'] == 1) ? 'checked="checked"' : set_checkbox('packages_logo', 1); ?>>
						<span class='help-inline'><?php echo form_error('logo'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('phone') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_phone'), 'packages_phone', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_phone'>
						<input type='checkbox' id='packages_phone' name='packages_phone' value='1' <?php echo (isset($packages['phone']) && $packages['phone'] == 1) ? 'checked="checked"' : set_checkbox('packages_phone', 1); ?>>
						<span class='help-inline'><?php echo form_error('phone'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('person') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_contact_person'), 'packages_person', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_person'>
						<input type='checkbox' id='packages_person' name='packages_person' value='1' <?php echo (isset($packages['person']) && $packages['person'] == 1) ? 'checked="checked"' : set_checkbox('packages_person', 1); ?>>
						<span class='help-inline'><?php echo form_error('person'); ?></span>
					</label>
				</div>
			</div>
			</fieldset>
			</div>
			<!-- Start of Display Options Tab Pane -->
			<div class="tab-pane" id="auto_approve_options">
			<fieldset>
			<legend><?php echo lang('auto_approve_options'); ?></legend>
			<div class="control-group <?php echo form_error('listing') ? 'error' : ''; ?>">
				<?php echo form_label(lang('listings'), 'packages_listing', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_listing'>
						<input type='checkbox' id='packages_listing' name='packages_listing' value='1' <?php echo (isset($packages['listings_active']) && $packages['listings_active'] == 1) ? 'checked="checked"' : set_checkbox('packages_listing', 1); ?>>
						<span class='help-inline'><?php echo form_error('listing'); ?></span>
					</label>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('product') ? 'error' : ''; ?>">
				<?php echo form_label(lang('products_services'), 'packages_product', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_product'>
						<input type='checkbox' id='packages_product' name='packages_product' value='1' <?php echo (isset($packages['products_active']) && $packages['products_active'] == 1) ? 'checked="checked"' : set_checkbox('packages_product', 1); ?>>
						<span class='help-inline'><?php echo form_error('product'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('photo') ? 'error' : ''; ?>">
				<?php echo form_label(lang('images'), 'packages_photo', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_photo'>
						<input type='checkbox' id='packages_photo' name='packages_photo' value='1' <?php echo (isset($packages['photos_active']) && $packages['photos_active'] == 1) ? 'checked="checked"' : set_checkbox('packages_photo', 1); ?>>
						<span class='help-inline'><?php echo form_error('photo'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('video') ? 'error' : ''; ?>">
				<?php echo form_label(lang('videos'), 'packages_video', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_video'>
						<input type='checkbox' id='packages_video' name='packages_video' value='1' <?php echo (isset($packages['videos_active']) && $packages['videos_active'] == 1) ? 'checked="checked"' : set_checkbox('packages_video', 1); ?>>
						<span class='help-inline'><?php echo form_error('video'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('classified') ? 'error' : ''; ?>">
				<?php echo form_label(lang('classifieds'), 'packages_classified', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='packages_classified'>
						<input type='checkbox' id='packages_classified' name='packages_classified' value='1' <?php echo (isset($packages['classifieds_active']) && $packages['classifieds_active'] == 1) ? 'checked="checked"' : set_checkbox('packages_classified', 1); ?>>
						<span class='help-inline'><?php echo form_error('classified'); ?></span>
					</label>
				</div>
			</div>
						
			</fieldset>
			</div>
			<!-- Start of Limit Listing Tab Pane -->
			<div class="tab-pane" id="layout">
			<fieldset>
			<legend><?php echo lang('label_packages_layout'); ?></legend>
			<div class="control-group <?php echo form_error('color_scheme') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_color_scheme'), 'color_scheme', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input type="text" value="<?php echo set_value('color_scheme', isset($packages['color_scheme']) ? $packages['color_scheme'] : ''); ?>" name="color_scheme" class="pick-a-color form-control">
					<span class='help-inline'><?php echo form_error('color_scheme'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('border_color') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_border_color'), 'border_color', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input type="text" value="<?php echo set_value('border_color', isset($packages['border_color']) ? $packages['border_color'] : ''); ?>" name="border_color" class="pick-a-color form-control">
					<span class='help-inline'><?php echo form_error('border_color'); ?></span>
				</div>
			</div>
			
			</fieldset>
			</div>
		</div>
			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/financial/packages', lang('cancel'), 'class="btn btn-warning"'); ?>
			<?php if(isset($packages['id'])) {?>
			<?php if ($this->auth->has_permission('Packages.Financial.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('delete_record'); ?>
				</button>
			<?php endif; ?>
			<?php }?>
			</div>
		</div>
    <?php echo form_close(); ?>
</div>