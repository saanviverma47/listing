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
if (isset($listings)) {
	$listings = (array) $listings;
}
$id = isset($listings['id']) ? $listings['id'] : '';
?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
			<div class="control-group <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_business'). lang('bf_form_label_required'), 'listings_title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_title' type='text' name='listings_title' class='span6' maxlength="100" value="<?php echo set_value('listings_title', isset($listings['title']) ? $listings['title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('title'); ?></span>
				</div>
			</div>
			
			<?php echo form_hidden('listings_user_id', $this->session->userdata('user_id')); ?>
			<?php echo form_hidden('listings_slug', isset($listings['slug']) ? $listings['slug'] : ''); ?>
	
			<?php
				foreach($packages as $package){
					$options[$package->id] = ucwords(strtolower($package->title));
				}
				echo form_dropdown('listings_package_id', $options, set_value('listings_package_id', isset($listings['package_id']) ? $listings['package_id'] : ''), lang('label_package'), 'class="span6"');
				echo form_dropdown('listings_category_id', $categories, set_value('listings_category_id', isset($parent_category) ? $parent_category : ''), lang('label_select_category'). lang('bf_form_label_required'), 'class="span6"');
			?>
			<?php if((settings_item('lst.categories_level') == 2) || (settings_item('lst.categories_level') == 3)):?>
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'' => lang('placeholder_subcategory')
				);
				$js = 'class="span6"';
				if(!empty($sub_categories)):											
					foreach($sub_categories as $subcategory) { 
						$options[$subcategory->id] = $subcategory->name; 
					}	
				endif;
				if (empty($sub_category) && empty($sub_categories)) {
					$js .= " disabled";					
				}
				echo form_dropdown('listings_subcategory_id', $options, set_value('listings_subcategory_id', isset($sub_category) ? $sub_category : ''), lang('label_select_subcategory'), $js);
			?>
			
			<?php endif;?>
			<?php if(settings_item('lst.categories_level') == 3):?>
				<?php // Change the values in this array to populate your dropdown as required
				$subsub_options = array(
					'' => lang('placeholder_subsubcategory')
				);
				$js = 'class="span6"';
				if(isset($subsub_categories) && !empty($subsub_categories)):											
					foreach($subsub_categories as $subsubcategory) { 
						$subsub_options[$subsubcategory->id] = $subsubcategory->name; 
					}	
				endif;
				if (empty($subsub_category) && empty($subsub_categories)) {
					$js .= " disabled";
				}				
				echo form_dropdown('listings_subsubcategory_id', $subsub_options, set_value('listings_subsubcategory_id', isset($subsub_category) ? $subsub_category : ''), lang('label_select_subsubcategory'), $js);
			?>
			<?php endif;?>
			
			<?php if(settings_item('lst.allow_country_selection') == 1):?>
						<?php // Change the values in this array to populate your dropdown as required
				$countries_options = array(
					'' => lang('placeholder_country')
				);
				if(!empty($countries)):
				foreach($countries as $country){
					$countries_options[$country->iso] = ucwords(strtolower($country->name));
				}
				endif;
				$js = 'class="span6", onChange="selectState(this.options[this.selectedIndex].value)"';
				echo form_dropdown('listings_country_id', $countries_options, set_value('listings_country_id', (isset($listings['country_iso']) || (isset($selected_country))) ? (isset($listings['country_iso']) ? $listings['country_iso'] : $selected_country) : ''), lang('label_select_country'). lang('bf_form_label_required'), $js);
			?>
			<?php endif;?>							
					
			<?php // Change the values in this array to populate your dropdown as required
				$states_options = array(
					'' => lang('placeholder_state')
				);
				$js = 'id = "state_dropdown", onChange="selectCity(this.options[this.selectedIndex].value)", class="span6"';
				if (!empty($listings['state_id']) || !empty($selected_state)) {
					$js .= '';
					if(!empty($states)):
					foreach($states as $state) { 
						$states_options[$state->id] = $state->name; 
					}
					endif;
				} else if(settings_item('lst.allow_country_selection') == 0) {
					if(!empty($states)):
						foreach($states as $state) { 
							$states_options[$state->id] = $state->name; 
						}
					endif;
				} else { $js .= ', disabled="disabled"'; }				
				echo form_dropdown('listings_state_id', $states_options, set_value('listings_state_id', (isset($listings['state_id']) || isset($selected_state)) ? (isset($listings['state_id']) ? $listings['state_id'] : $selected_state) : ''), lang('label_select_state'). lang('bf_form_label_required'), $js);
			?><span id="state_loader"></span>

			<?php // Change the values in this array to populate your dropdown as required
				$cities_options = array(
					'' => lang('placeholder_city')
				);
				$js ='class="span6", onChange="GetCityMap(this.options[this.selectedIndex].value); selectLocality(this.options[this.selectedIndex].value);"';
				if (isset($listings['city_id']) || isset($selected_city)) {
					$js .= '';
					if($cities):
					foreach($cities as $city) { $cities_options[$city->id] = $city->name; }
					endif;
				}
				else { $js .= ', disabled="disabled"'; }
				
				echo form_dropdown('listings_city_id', $cities_options, set_value('listings_city_id', (isset($listings['city_id']) || isset($selected_city)) ? (isset($listings['city_id']) ? $listings['city_id'] : $selected_city) : ''), lang('label_select_city'). lang('bf_form_label_required'), $js);
			?><span id="city_loader"></span>
						
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'' => lang('placeholder_locality')
				);
				if (isset($listings['locality_id']) || isset($selected_locality)) {
					$locality_js = 'class="span6"';
					if($localities):
					foreach($localities as $locality) { $options[$locality->id] = $locality->name; }
					endif;
				} else { $locality_js = 'class="span6", disabled="disabled"'; }
				
				echo form_dropdown('listings_locality_id', $options, set_value('listings_locality_id', isset($listings['locality_id']) ? $listings['locality_id'] : ''), lang('label_select_locality'), $locality_js);
			?><span id="locality_loader"></span>

			<div class="control-group <?php echo form_error('pincode') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_pincode'). lang('bf_form_label_required'), 'listings_pincode', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_pincode' type='text' name='listings_pincode' class='span6' maxlength="10" value="<?php echo set_value('listings_pincode', isset($listings['pincode']) ? $listings['pincode'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pincode'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('address') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_address'). lang('bf_form_label_required'), 'listings_address', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'listings_address', 'id' => 'listings_address', 'rows' => '5', 'cols' => '80', 'class' => 'span6', 'value' => set_value('listings_address', isset($listings['address']) ? $listings['address'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('address'); ?></span>
				</div>
			</div>
			<?php echo form_hidden('listings_categories_level', set_value('listings_categories_level', settings_item('lst.categories_level')))?>
			<?php echo form_hidden('listings_country_selection', set_value('listings_country_selection', settings_item('lst.allow_country_selection')))?>
			<?php echo form_hidden('listings_latitude', set_value('listings_latitude', isset($listings['latitude']) ? $listings['latitude'] : '')) ?>
			<?php echo form_hidden('listings_longitude', set_value('listings_longitude', isset($listings['longitude']) ? $listings['longitude'] : '')) ?>
			
			<div class="control-group">
				<?php echo form_label(lang('label_location'), 'listings_location', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<script type="text/javascript">
							var centreGot = false;
					</script>
					<?php echo $map['js']; ?>
					<?php echo $map['html']; ?>
				</div>
			</div>

			<div class="control-group <?php echo form_error('contact_person') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_contact_person'), 'listings_contact_person', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_contact_person' type='text' name='listings_contact_person' class='span6' maxlength="50" value="<?php echo set_value('listings_contact_person', isset($listings['contact_person']) ? $listings['contact_person'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('contact_person'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('phone_number') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_phone_number'), 'listings_phone_number', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_phone_number' type='text' name='listings_phone_number' class='span6' maxlength="20" value="<?php echo set_value('listings_phone_number', isset($listings['phone_number']) ? $listings['phone_number'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('phone_number'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('mobile_number') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_mobile_number'). lang('bf_form_label_required'), 'listings_mobile_number', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_mobile_number' type='text' name='listings_mobile_number' class='span6' maxlength="30" value="<?php echo set_value('listings_mobile_number', isset($listings['mobile_number']) ? $listings['mobile_number'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('mobile_number'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tollfree') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_tollfree'), 'listings_tollfree', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_tollfree' type='text' name='listings_tollfree' class='span6' maxlength="30" value="<?php echo set_value('listings_tollfree', isset($listings['tollfree']) ? $listings['tollfree'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tollfree'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('fax') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_fax'), 'listings_fax', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_fax' type='text' name='listings_fax' class='span6' maxlength="30" value="<?php echo set_value('listings_fax', isset($listings['fax']) ? $listings['fax'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('fax'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('email') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_email'). lang('bf_form_label_required'), 'listings_email', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_email' type='text' name='listings_email' class='span6' maxlength="100" value="<?php echo set_value('listings_email', isset($listings['email']) ? $listings['email'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('email'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('website') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_website'), 'listings_website', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_website' type='text' name='listings_website' class='span6' maxlength="100" value="<?php echo set_value('listings_website', isset($listings['website']) ? $listings['website'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('website'); ?></span>
				</div>
			</div>
			
			<?php if(settings_item('lst.allow_facebook_url')):?>
			<div class="control-group <?php echo form_error('facebook_url') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_facebook_url'), 'listings_facebook_url', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_facebook_url' type='text' name='listings_facebook_url' class='span6' maxlength="100" value="<?php echo set_value('listings_facebook_url', isset($listings['facebook_url']) ? $listings['facebook_url'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('facebook_url'); ?></span>
				</div>
			</div>
			<?php endif;?>
			<?php if(settings_item('lst.allow_twitter_url')):?>
			<div class="control-group <?php echo form_error('twitter_url') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_twitter_url'), 'listings_twitter_url', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_twitter_url' type='text' name='listings_twitter_url' class='span6' maxlength="100" value="<?php echo set_value('listings_twitter_url', isset($listings['twitter_url']) ? $listings['twitter_url'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('twitter_url'); ?></span>
				</div>
			</div>
			<?php endif;?>
			<?php if(settings_item('lst.allow_googleplus_url')):?>
			<div class="control-group <?php echo form_error('googleplus_url') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_googleplus_url'), 'listings_googleplus_url', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_googleplus_url' type='text' name='listings_googleplus_url' class='span6' maxlength="100" value="<?php echo set_value('listings_googleplus_url', isset($listings['googleplus_url']) ? $listings['googleplus_url'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('googleplus_url'); ?></span>
				</div>
			</div>
			<?php endif;?>
			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'listings_description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'listings_description', 'id' => 'listings_description', 'rows' => '5', 'cols' => '80', 'class' => 'span6', 'value' => set_value('listings_description', isset($listings['description']) ? $listings['description'] : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('keywords') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_keywords'), 'listings_keywords', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'listings_keywords', 'id' => 'listings_keywords', 'rows' => '5', 'cols' => '80', 'class' => 'span6', 'value' => set_value('listings_keywords', isset($tags) ? $tags : '', false) ) ); ?>
					<span class='help-inline'><?php echo form_error('keywords'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('expires_on') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_expires_on'), 'listings_expires_on', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_expires_on' type='text' name='listings_expires_on'  class='span6' value="<?php echo set_value('listings_expires_on', isset($listings['expires_on']) ? $listings['expires_on'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('expires_on'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('featured') ? 'error' : ''; ?>">
				<div class='controls'>
					<label class='checkbox' for='listings_featured'>
						<input type='checkbox' id='listings_featured' name='listings_featured' value='1' <?php echo (isset($listings['featured']) && $listings['featured'] == 1) ? 'checked="checked"' : set_checkbox('listings_featured', 1); ?>><?php echo lang('label_featured');?>
						<span class='help-inline'><?php echo form_error('featured'); ?></span>
					</label>
					<label class='checkbox' for='listings_active'>
						<input type='checkbox' id='listings_active' name='listings_active' value='1' <?php echo (isset($listings['active']) && $listings['active'] == 1) ? 'checked="checked"' : set_checkbox('listings_active', 1); ?>><?php echo lang('label_status');?>
						<span class='help-inline'><?php echo form_error('active'); ?></span>
					</label>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/listings', lang('cancel'), 'class="btn btn-warning"'); ?>				
			<?php if ($id && $this->auth->has_permission('Listings.Content.Delete')) : ?>
				<?php echo lang('bf_or'); ?>
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>