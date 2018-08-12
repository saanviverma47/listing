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

if (isset($categories))
{
	$categories = (array) $categories;
}
$id = isset($categories['id']) ? $categories['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>
			<?php echo form_hidden('listings_categories_level', set_value('listings_categories_level', settings_item('lst.categories_level')))?>
			
			<?php // Change the values in this array to populate your dropdown as required
				echo form_dropdown('categories_parent_id', $categories_no_parents, set_value('categories_parent_id', isset($parent_category) ? $parent_category : ''), 'Parent', 'class = "span6"');
			?>
			
			<?php if(settings_item('lst.categories_level') == 3):?>
			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					'' => lang('placeholder_subcategory')
				);
				$js = 'class="span6"';
				if(isset($sub_categories)):											
				foreach($sub_categories as $subcategory) { $options[$subcategory->id] = $subcategory->name; }	
				endif;
				if (!isset($sub_category) && !isset($sub_categories)) {
					$js .= " disabled";					
				}
				echo form_dropdown('listings_subcategory_id', $options, set_value('listings_subcategory_id', isset($sub_category) ? $sub_category : ''), lang('label_select_subcategory'), $js);
			?>			
			<?php endif;?>
			
			<div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_name'). lang('bf_form_label_required'), 'categories_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='categories_name' type='text' class="span6" name='categories_name' maxlength="100" value="<?php echo set_value('categories_name', isset($categories['name']) ? $categories['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('slug') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_slug'), 'categories_slug', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='categories_slug' type='text' class="span6" name='categories_slug' maxlength="100" value="<?php echo set_value('categories_slug', isset($categories['slug']) ? $categories['slug'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('slug'); ?></span>
				</div>
			</div>
			
			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_description'), 'categories_description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'categories_description', 'id' => 'categories_description', 'class' => 'span6', 'rows' => '5', 'cols' => '80', 'value' => set_value('categories_description', (isset($categories['description']) ? $categories['description'] : ''), false)) ); ?>
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('meta_title') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_meta_title'), 'categories_meta_title', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='categories_meta_title' type='text' class="span6" name='categories_meta_title' maxlength="100" value="<?php echo set_value('categories_meta_title', isset($categories['meta_title']) ? $categories['meta_title'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('meta_title'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('meta_keywords') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_meta_keywords'), 'categories_meta_keywords', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'categories_meta_keywords', 'id' => 'categories_meta_keywords', 'class' => 'span6', 'rows' => '5', 'cols' => '80', 'value' => set_value('categories_meta_keywords', (isset($categories['meta_keywords']) ? $categories['meta_keywords'] : ''), false) ) ); ?>
					<span class='help-inline'><?php echo form_error('meta_keywords'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('meta_description') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_meta_description'), 'categories_meta_description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'categories_meta_description', 'id' => 'categories_meta_description', 'class' => 'span6', 'rows' => '5', 'cols' => '80', 'value' => set_value('categories_meta_description', (isset($categories['meta_description']) ? $categories['meta_description'] : ''), false) ) ); ?>
					<span class='help-inline'><?php echo form_error('meta_description'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('active') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_status'), 'categories_active', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='categories_active'>
						<input type='checkbox' id='categories_active' name='categories_active' value='1' <?php echo (isset($categories['active']) && $categories['active'] == 1) ? 'checked="checked"' : set_checkbox('categories_active', 1); ?>>
						<span class='help-inline'><?php echo form_error('active'); ?></span>
					</label>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('save'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/categories', lang('cancel'), 'class="btn btn-warning"'); ?>
			<?php if(isset($categories['id'])) {?>
			<?php if ($this->auth->has_permission('Categories.Content.Delete')) : ?>
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