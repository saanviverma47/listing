<?php
if (isset ( $listings )) {
	$listings = ( array ) $listings;
}
$id = isset ( $listings ['id'] ) ? $listings ['id'] : '';
echo form_hidden ( 'listing_id', $id ); // for javascript function, disable fields only if request is from create page
$validation_errors = validation_errors ();
if ($validation_errors) :
?>
<div class="alert alert-danger alert-error fade in col-sm-12">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading"><?php echo lang('validations_error');?></h4>
	<?php echo $validation_errors; ?>
</div>
<?php 
endif;
?>
<div class="hom-cre-acc-left hom-cre-acc-right">
<?php
echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING'], 'class="form-horizontal" rol="form"');
?>
<?php echo form_hidden('package_id', set_value('package_id', isset($package_id) ? $package_id : ''))?>
<div
	class="row <?php echo form_error('title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_business') . lang('label_title'). lang('bf_form_label_required'), 'listings_title', array('class' => 'col-sm-3 control-label') ); ?>
		<div class="col s9">
			<input id='listings_title' class='form-control input-field' type='text'
				name='listings_title'
				placeholder="<?php echo lang('label_business') . lang('label_title');?>"
				value="<?php echo set_value('listings_title', isset($listings['title']) ? $listings['title'] : ''); ?>" />
			<span class='help-block'><?php echo form_error('title'); ?></span>
		</div>
</div>

<div class="row form-group">
	<?php echo form_label(lang('label_select_category'). lang('bf_form_label_required'), 'listings_category_id', array('class' => 'col-sm-3 control-label') ); ?>
		<div class="input-field col s9">
			<select name="listings_category_id" id="listings_category_id"
				placeholder="<?php echo lang('placeholder_category');?>">
				<option value=""><?php echo lang('placeholder_category');?>	</option>
				<?php foreach($categories as $category): ?>
				<option value="<?php echo $category->id;?>"
					<?php echo (isset($parent_category) && ($category->id == $parent_category)) ? 'selected': ''; ?>>
				<?php echo $category->name;?>
				</option>
				<?php endforeach; ?>
			</select>
		</div>
</div>

<?php if((settings_item('lst.categories_level') == 2) || (settings_item('lst.categories_level') == 3)):?>
<div class="row form-group">
<?php echo form_label(lang('label_select_subcategory'), 'listings_subcategory_id', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="input-field col s9">
		<select name="listings_subcategory_id" id="listings_subcategory_id"	placeholder="<?php echo lang('placeholder_subcategory');?>">
			<option value="">
			<?php echo lang('placeholder_subcategory');?>
			</option>
			<?php if(!empty($sub_categories)):?>
			<?php foreach($sub_categories as $subcategory): ?>
			<option value="<?php echo $subcategory->id;?>"
			<?php echo isset($sub_category) && ($subcategory->id == $sub_category) ? 'selected': ''; ?>>
				<?php echo $subcategory->name;?>
			</option>
			<?php endforeach; ?>
			<?php endif;?>
		</select>
	</div>
</div>
	<?php endif;?>
<?php if(settings_item('lst.categories_level') == 3):?>
<div class="form-group row">
<?php echo form_label(lang('label_select_subsubcategory'), 'listings_subsubcategory_id', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="input-field col s9">
		<select name="listings_subsubcategory_id"
			id="listings_subsubcategory_id"
			placeholder="<?php echo lang('placeholder_subsubcategory');?>">
			<option value="">
			<?php echo lang('placeholder_subsubcategory');?>
			</option>
			<?php if(!empty($subsub_categories)):?>
			<?php foreach($subsub_categories as $subsubcategory): ?>
			<option value="<?php echo $subsubcategory->id;?>"
			<?php echo isset($subsub_category) && ($subsubcategory->id == $subsub_category) ? 'selected': ''; ?>>
				<?php echo $subsubcategory->name;?>
			</option>
			<?php endforeach; ?>
			<?php endif;?>
		</select>
	</div>
</div>
<?php endif;?>
<?php if(settings_item('lst.allow_country_selection') == 1):?>
<div class="form-group row">
<?php echo form_label(lang('label_select_country'). lang('bf_form_label_required'), 'listings_country_id', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="input-field col s9">
		<select name="listings_country_id" id="listings_country_id"
			placeholder="<?php echo lang('placeholder_country');?>">
			<option value="">
			<?php echo lang('placeholder_country');?>
			</option>
			<?php if(!empty($all_countries)):?>
			<?php foreach($all_countries as $country): ?>
			<option value="<?php echo $country->iso;?>"
			<?php echo ((isset($listings['country_iso']) && ($country->iso == $listings['country_iso'])) || ((isset($selected_country)) && ($country->iso == $selected_country))) ? 'selected': ''; ?>>
				<?php echo ucwords(strtolower($country->name));?>
			</option>
			<?php endforeach; ?>
			<?php endif;?>
		</select>
	</div>
</div>
<?php endif;?>

<div class="form-group row">
<?php echo form_label(lang('label_select_state'). lang('bf_form_label_required'), 'listings_state_id', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="input-field col s9">
		<select name="listings_state_id" id="listings_state_id"	placeholder="<?php echo lang('placeholder_state');?>">
			<option value="">
			<?php echo lang('placeholder_state');?>
			</option>
			<?php if(!empty($listing_states)):?>
			<?php foreach($listing_states as $state): ?>
			<option value="<?php echo $state->id;?>"
			<?php echo ((isset($listings['state_id']) && ($state->id == $listings['state_id'])) || ((isset($selected_state)) && ($state->id == $selected_state))) ? 'selected': ''; ?>>
				<?php echo $state->name;?>
			</option>
			<?php endforeach; ?>
			<?php endif;?>
		</select>
	</div>
</div>

<div class="form-group row">
<?php echo form_label(lang('label_select_city'). lang('bf_form_label_required'), 'listings_city_id', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="input-field col s9">
		<select name="listings_city_id" id="listings_city_id" placeholder="<?php echo lang('placeholder_city');?>">
			<option value="">
			<?php echo lang('placeholder_city');?>
			</option>
			<?php if(!empty($listing_cities)):?>
			<?php foreach($listing_cities as $city): ?>
			<option value="<?php echo $city->id;?>"
			<?php echo ((isset($listings['city_id']) && ($city->id == $listings['city_id'])) || ((isset($selected_city)) && ($city->id == $selected_city))) ? 'selected': ''; ?>>
				<?php echo $city->name;?>
			</option>
			<?php endforeach; ?>
			<?php endif;?>
		</select>
	</div>
</div>

<div
	class="form-group <?php echo form_error('pincode') ? 'error' : ''; ?>">
	<?php echo form_label(lang('label_pincode'). lang('bf_form_label_required'), 'listings_pincode', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="col-sm-9">
		<input id='listings_pincode' class='form-control' type='text'
			name='listings_pincode' maxlength="10"
			placeholder="<?php echo lang('placeholder_pincode');?>"
			value="<?php echo set_value('listings_pincode', isset($listings['pincode']) ? $listings['pincode'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('pincode'); ?> </span>
	</div>
</div>

<div
	class="form-group <?php echo form_error('address') ? 'error' : ''; ?>">
	<?php echo form_label(lang('label_address'). lang('bf_form_label_required'), 'listings_address', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="col-sm-9">
	<?php echo form_textarea( array( 'name' => 'listings_address', 'id' => 'listings_address', 'rows' => '5', 'cols' => '80', 'class' => 'form-control', 'placeholder' => "".lang('placeholder_address')."", 'value' => set_value('listings_address', isset($listings['address']) ? $listings['address'] : '', false) ) ); ?>
		<span class='help-block'><?php echo form_error('address'); ?> </span>
	</div>
</div>
<?php echo form_hidden('listings_categories_level', set_value('listings_categories_level', settings_item('lst.categories_level')))?>
<?php echo form_hidden('listings_country_selection', set_value('listings_country_selection', settings_item('lst.allow_country_selection')))?>
<?php echo form_hidden('listings_latitude', set_value('listings_latitude', isset($listings['latitude']) ? $listings['latitude'] : ''))?>
<?php echo form_hidden('listings_longitude', set_value('listings_longitude', isset($listings['longitude']) ? $listings['longitude'] : ''))?>

<div class="form-group">
<?php echo form_label(lang('label_location'), 'listings_location', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="col-sm-9">
		<script type="text/javascript">	var centreGot = false;	</script>
		<?php echo $map['js']; ?>
		<?php echo $map['html']; ?>
	</div>
</div>

<div
	class="form-group <?php echo form_error('contact_person') ? 'error' : ''; ?>">
	<?php echo form_label(lang('label_contact_person'), 'listings_contact_person', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="col-sm-9">
		<input id='listings_contact_person' class='form-control' type='text'
			name='listings_contact_person' maxlength="50"
			placeholder="<?php echo lang('placeholder_contact_person');?>"
			value="<?php echo set_value('listings_contact_person', isset($listings['contact_person']) ? $listings['contact_person'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('contact_person'); ?>
		</span>
	</div>
</div>

<div
	class="form-group <?php echo form_error('phone_number') ? 'error' : ''; ?>">
	<?php echo form_label(lang('label_phone_number')  .' <p class="help-bloc"><small>' .lang('help_phone_number').'</small></p>', 'listings_phone_number', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="col-sm-9">
		<input id='listings_phone_number' class='form-control' type='text'
			name='listings_phone_number' maxlength="20"
			placeholder="<?php echo lang('placeholder_phone_number');?>"
			value="<?php echo set_value('listings_phone_number', isset($listings['phone_number']) ? $listings['phone_number'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('phone_number'); ?> </span>
	</div>
</div>

<div
	class="form-group <?php echo form_error('mobile_number') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_mobile_number'). lang('bf_form_label_required') .' <p class="help-bloc"><small>' .lang('help_mobile_number').'</small></p>', 'listings_mobile_number', array('class' => 'col-sm-3 control-label') ); ?>
				<div class="col-sm-9">
		<input id='listings_mobile_number' class='form-control' type='text'
			name='listings_mobile_number' maxlength="30"
			placeholder="<?php echo lang('placeholder_mobile_number');?>"
			value="<?php echo set_value('listings_mobile_number', isset($listings['mobile_number']) ? $listings['mobile_number'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('mobile_number'); ?></span>
	</div>
</div>

<div
	class="form-group <?php echo form_error('tollfree') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_tollfree'), 'listings_tollfree', array('class' => 'col-sm-3 control-label') ); ?>
				<div class="col-sm-9">
		<input id='listings_tollfree' class='form-control' type='text'
			name='listings_tollfree' maxlength="30"
			placeholder="<?php echo lang('placeholder_tollfree');?>"
			value="<?php echo set_value('listings_tollfree', isset($listings['tollfree']) ? $listings['tollfree'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('tollfree'); ?></span>
	</div>
</div>

<div class="form-group <?php echo form_error('fax') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_fax'), 'listings_fax', array('class' => 'col-sm-3 control-label') ); ?>
				<div class="col-sm-9">
		<input id='listings_fax' class='form-control' type='text'
			name='listings_fax' maxlength="30"
			placeholder="<?php echo lang('placeholder_fax');?>"
			value="<?php echo set_value('listings_fax', isset($listings['fax']) ? $listings['fax'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('fax'); ?></span>
	</div>
</div>

<div
	class="form-group <?php echo form_error('email') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_email'). lang('bf_form_label_required'), 'listings_email', array('class' => 'col-sm-3 control-label') ); ?>
				<div class="col-sm-9">
		<input id='listings_email' class='form-control' type='text'
			name='listings_email' maxlength="100"
			placeholder="<?php echo lang('placeholder_email');?>"
			value="<?php echo set_value('listings_email', isset($listings['email']) ? $listings['email'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('email'); ?></span>
	</div>
</div>

<div
	class="form-group <?php echo form_error('website') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_website'), 'listings_website', array('class' => 'col-sm-3 control-label') ); ?>
				<div class="col-sm-9">
		<input id='listings_website' class='form-control' type='text'
			name='listings_website' maxlength="100"
			placeholder="<?php echo lang('placeholder_website');?>"
			value="<?php echo set_value('listings_website', isset($listings['website']) ? $listings['website'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('website'); ?></span>
	</div>
</div>
<?php if(settings_item('lst.allow_facebook_url')):?>
<div
	class="form-group <?php echo form_error('facebook_url') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_facebook_url'), 'listings_facebook_url', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
		<input id='listings_facebook_url' type='text'
			name='listings_facebook_url' class='form-control'
			placeholder="<?php echo lang('placeholder_facebook_url');?>"
			value="<?php echo set_value('listings_facebook_url', isset($listings['facebook_url']) ? $listings['facebook_url'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('facebook_url'); ?></span>
	</div>
</div>
<?php endif;?>
			<?php if(settings_item('lst.allow_twitter_url')):?>
<div
	class="form-group <?php echo form_error('twitter_url') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_twitter_url'), 'listings_twitter_url', array('class' => 'col-sm-3 control-label') ); ?>
				<div class='col-sm-9'>
		<input id='listings_twitter_url' type='text'
			name='listings_twitter_url' class='form-control' 
			placeholder="<?php echo lang('placeholder_twitter_url');?>"
			value="<?php echo set_value('listings_twitter_url', isset($listings['twitter_url']) ? $listings['twitter_url'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('twitter_url'); ?></span>
	</div>
</div>
<?php endif;?>
			<?php if(settings_item('lst.allow_googleplus_url')):?>
<div
	class="form-group <?php echo form_error('googleplus_url') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_googleplus_url'), 'listings_googleplus_url', array('class' => 'col-sm-3 control-label') ); ?>
		<div class='col-sm-9'>
		<input id='listings_googleplus_url' type='text'
			name='listings_googleplus_url' class='form-control'
			placeholder="<?php echo lang('placeholder_googleplus_url');?>"
			value="<?php echo set_value('listings_googleplus_url', isset($listings['googleplus_url']) ? $listings['googleplus_url'] : ''); ?>" />
		<span class='help-block'><?php echo form_error('googleplus_url'); ?></span>
	</div>
</div>
<?php endif;?>
<div
	class="form-group <?php echo form_error('description') ? 'error' : ''; ?>">
	<div class="col-sm-3 control-label">
		<label for="listings_description"><?php echo lang('label_description')?></label>
		<span class="help-block"><?php echo sprintf(lang('description_limit'), ($description_limit == 0) ? lang('no_limit') : $description_limit);?></span>
	</div>

	<div class="col-sm-9">
					<?php echo form_textarea( array( 'name' => 'listings_description', 'id' => 'listings_description', 'rows' => '5', 'cols' => '80', 'maxlength' => ($description_limit == 0) ? 50000 : $description_limit, 'value' => set_value('listings_description', isset($listings['description']) ? $listings['description'] : '', false) ) ); ?>
					<span class='help-block'><?php echo form_error('description'); ?></span>
		<div id="max_char_string"></div>
	</div>
</div>

<div
	class="form-group <?php echo form_error('keywords') ? 'error' : ''; ?>">
	<div class="col-sm-3 control-label">
		<label for="listings_description"><?php echo lang('label_keywords')?></label>
		<span class="help-block"><?php echo sprintf(lang('keywords_limit'), ($keywords_limit == 0) ? lang('no_limit') : $keywords_limit);?></span>
	</div>
	<div class="col-sm-9">
					<?php echo form_textarea( array( 'name' => 'listings_keywords', 'id' => 'listings_keywords', 'rows' => '5', 'cols' => '80', 'class' => 'form-control', 'placeholder' => "".lang('placeholder_keywords')."", 'value' => set_value('listings_keywords', isset($tags) ? $tags : '', false) ) ); ?>
					<span class='help-block'><?php echo form_error('keywords'); ?></span>
	</div>
</div>
<?php if(isset($price)):?>
<div class="form-group row">
<?php echo form_label(lang('label_payment_gateway'), 'payment_gateways', array('class' => 'col-sm-3 control-label') ); ?>
	<div class="input-field col s9">
		<select name="payment_gateways" id="payment_gateways" placeholder="<?php echo lang('placeholder_payment_gateway');?>">
			<?php foreach($payment_gateways as $payment_gateway): ?>
			<option value="<?php echo strtolower($payment_gateway->name);?>">
			<?php echo ucwords(strtolower($payment_gateway->display_name));?>
			</option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<?php endif;?>
<div style="margin-top: 10px" class="form-group row">
	<!-- Button -->
	<input type="submit" name="save" class="btn btn-primary col s3"
		value="<?php echo lang('action_save'); ?>" />
		<?php echo lang('bf_or'); ?>
		<?php echo anchor('/members', lang('cancel'), 'class="btn btn-warning"'); ?>
		<?php if ($this->auth->restrict() && $id) : ?>
	&mnsp;or &mnsp;
	<button type="submit" name="delete" class="btn btn-danger s3"
		id="delete-me"
		onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>'); ">
		<span class="icon-trash icon-white"></span>&nbsp;
		<?php echo lang('delete_record'); ?>
	</button>
	<?php endif; ?>
</div>
	<?php echo form_close();?>
</div>