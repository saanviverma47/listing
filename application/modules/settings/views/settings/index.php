<?php

$validation_errors = validation_errors();
$show_extended_settings = ! empty($extended_settings);
$show_general_settings = ! empty ( $general_settings );

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;
?>
<div class="admin-box">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#main-settings" data-toggle="tab"><?php echo lang('set_tab_settings') ?></a>
				</li>
				<?php if ($show_general_settings) : ?>
				<li>
					<a href="#general" data-toggle="tab"><?php echo lang('set_tab_general') ?></a>
				</li>
				<?php endif;?>
				<li>
					<a href="#advanced" data-toggle="tab"><?php echo lang('set_tab_advanced') ?></a>
				</li>
				<li>
					<a href="#listing" data-toggle="tab"><?php echo lang('set_tab_listing') ?></a>
				</li>
				<li>
					<a href="#financial" data-toggle="tab"><?php echo lang('set_tab_financial') ?></a>
				</li>
				<li>
					<a href="#security" data-toggle="tab"><?php echo lang('set_tab_security') ?></a>
				</li>				
			<?php if (has_permission('Site.Developer.View')) : ?>
				<li>
					<a href="#developer" data-toggle="tab"><?php echo lang('set_tab_developer') ?></a>
				</li>
			<?php endif;
				if ($show_extended_settings) :
			?>
				<li>
					<a href="#extended" data-toggle="tab"><?php echo lang('set_tab_extended') ?></a>
				</li>
			<?php endif; ?>			
			</ul>
			<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
				<!-- Start of Main Settings Tab Pane -->
				<div class="tab-pane active" id="main-settings">
					<fieldset>
						<legend><?php echo lang('bf_site_information') ?></legend>

						<div class="control-group">
							<label class="control-label" for="title"><?php echo lang('bf_site_name') ?></label>
							<div class="controls">
								<input type="text" name="title" id="title" class="span6" value="<?php echo set_value('site.title', isset($settings['site.title']) ? $settings['site.title'] : '') ?>" />
							</div>
						</div>
						
						<div class="control-group ">
						<label class="control-label" for="site_logo"><?php echo lang('site_logo') ?></label>
						<div class="controls">
							<input id="site_logo" class="span3" type="file" maxlength="100" value="<?php echo set_value('site.logo', isset($settings['site.logo']) ? $settings['site.logo'] : '') ?>" name="site_logo">
							<p class="help-inline"><?php echo sprintf(lang('site_logo_help'), $file_upload_settings['file_size'], $file_upload_settings['resize_width'], $file_upload_settings['resize_height']) ?></p>
						    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px; margin-top:5px;">
							<img src="<?php echo base_url("assets/images/" .$settings['site.logo']);?>"></div></div>
						</div>

						<div class="control-group">
							<label class="control-label" for="system_email"><?php echo lang('bf_site_email') ?></label>
							<div class="controls">
								<input type="text" name="system_email" id="system_email" class="span4" value="<?php echo set_value('site.system_email', isset($settings['site.system_email']) ? $settings['site.system_email'] : '') ?>" />
								<p class="help-inline"><?php echo lang('bf_site_email_help') ?></p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="status"><?php echo lang('bf_site_status') ?></label>
							<div class="controls">
								<select name="status" id="status">
									<option value="1" <?php echo isset($settings) && $settings['site.status'] == 1 ? 'selected="selected"' : set_select('site.status', '1') ?>><?php echo lang('bf_online') ?></option>
									<option value="0" <?php echo isset($settings) && $settings['site.status'] == 0 ? 'selected="selected"' : set_select('site.status', '1') ?>><?php echo lang('bf_offline') ?></option>
								</select>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="list_limit"><?php echo lang('bf_top_number') ?></label>
							<div class="controls">
								<input type="text" name="list_limit" id="list_limit" value="<?php echo set_value('list_limit', isset($settings['site.list_limit']) ? $settings['site.list_limit'] : '')  ?>" class="span1" />
								<p class="help-inline"><?php echo lang('bf_top_number_help') ?></p>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="deafult_language"><?php echo lang('site_default_language') ?></label>
							<div class="controls">
								<select name="default_language" id="default_language">
									<?php if ($languages) :
											foreach ($languages as $language) :?>
									<option value="<?php e($language); ?>" <?php echo ($language == $settings['site.default_language']) ? 'selected' : ''; ?>><?php e(ucfirst($language)); ?></option>
									<?php endforeach; endif;?>
								</select>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="languages"><?php echo lang('bf_language') ?></label>
							<div class="controls">
								<select name="languages[]" id="languages" multiple="multiple">
						<?php
							if (is_array($languages) && count($languages)) :
								foreach ($languages as $language) :
									$selected = in_array($language, $selected_languages) ? TRUE : FALSE;
						?>
									<option value="<?php e($language); ?>" <?php echo set_select('languages', $language, $selected); ?>><?php e(ucfirst($language)); ?></option>
						<?php
								endforeach;
							endif;
						?>
								</select>
								<p class="help-inline"><?php echo lang('bf_language_help') ?></p>
							</div>
						</div>
						<?php // Change the values in this array to populate your dropdown as required
							if(!empty($currencies)):
							foreach($currencies as $currency){
								$options[$currency->symbol .'|'.ucwords($currency->code)] = ucwords($currency->code);
							}
							echo form_dropdown('currency', $options, set_value('currency', isset($settings['site.currency']) ? $settings['site.currency'].'|'.$settings['site.currency_code'] : ''), lang('default_currency'));
							endif;
						?>
						<div class="control-group">
							<label class="control-label" for="google_api_key"><?php echo lang('google_api_key'). lang('bf_form_label_required') ?></label>
							<div class="controls">
								<input type="text" name="google_api_key" id="google_api_key" class="span6" value="<?php echo set_value('site.google_api_key', isset($settings['site.google_api_key']) ? $settings['site.google_api_key'] : '') ?>" />
								<p class="help-inline"><small><?php echo lang('help_google_api_key');?></small>
							</div>
						</div>	
					</fieldset>
				</div>
				
				<!-- Start of Security Settings Tab Pane -->
				<div class="tab-pane" id="security">
					<fieldset>
						<legend><?php echo lang('bf_security') ?></legend>

						<div class="control-group">
							<div class="controls">
								<label for="allow_register">
									<input type="checkbox" name="allow_register" id="allow_register" value="1" <?php echo $settings['auth.allow_register'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_register', 1); ?> />
									<span><?php echo lang('bf_allow_register') ?></span>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="user_activation_method"><?php echo lang('bf_activate_method') ?></label>
							<div class="controls">
								<select name="user_activation_method" id="user_activation_method">
									<option value="0" <?php echo $settings['auth.user_activation_method'] == 0 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_none') ?></option>
									<option value="1" <?php echo $settings['auth.user_activation_method'] == 1 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_email') ?></option>
									<option value="2" <?php echo $settings['auth.user_activation_method'] == 2 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_admin') ?></option>
								</select>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="login_type"><?php echo lang('bf_login_type') ?></label>
							<div class="controls">
								<select name="login_type" id="login_type">
									<option value="email" <?php echo $settings['auth.login_type'] == 'email' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_email') ?></option>
									<option value="username" <?php echo $settings['auth.login_type'] == 'username' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_username') ?></option>
									<option value="both" <?php echo $settings['auth.login_type'] == 'both' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_both') ?></option>
								</select>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" id="use_usernames_label"><?php echo lang('bf_use_usernames') ?></label>
							<div class="controls" aria-labelledby="use_usernames_label" role="group">
								<label class="radio" for="use_username">
									<input type="radio" id="use_username" name="use_usernames" value="1" <?php echo $settings['auth.use_usernames'] == 1 ? 'checked="checked"' : set_radio('auth.use_usernames', 1); ?> />
									<span><?php echo lang('bf_username') ?></span>
								</label>
								<label class="radio" for="use_email">
									<input type="radio" id="use_email" name="use_usernames" value="0" <?php echo $settings['auth.use_usernames'] == 0 ? 'checked="checked"' : set_radio('auth.use_usernames', 0); ?> />
									<span><?php echo lang('bf_email') ?></span>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('bf_display_name'); ?></label>
							<div class="controls">
								<label class="checkbox" for="allow_name_change">
									<input type="checkbox" name="allow_name_change" id="allow_name_change" <?php echo isset($settings['auth.allow_name_change']) && $settings['auth.allow_name_change'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_remember', 1); ?> >
									<?php echo lang('set_allow_name_change_note'); ?>
								</label>

								<div id="name-change-settings" style="<?php if (!$settings['auth.allow_name_change']) echo 'display: none'; ?>">
									<input type="text" name="name_change_frequency" style="width: 2em;" value="<?php echo $settings['auth.name_change_frequency'] ?>">
									<?php echo lang('set_name_change_frequency') ?>

									<input type="text" name="name_change_limit" style="width: 2em;" value="<?php echo $settings['auth.name_change_limit'] ?>">
									<?php echo lang('set_days') ?>
								</div>
							</div>
						</div>

						<div class="control-group">
							<div class="controls">
								<label class="checkbox" for="allow_remember">
									<input type="checkbox" name="allow_remember" id="allow_remember" value="1" <?php echo $settings['auth.allow_remember'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_remember', 1); ?> />
									<span><?php echo lang('bf_allow_remember') ?></span>
								</label>
							</div>
						</div>

						<div class="control-group" id="remember-length" style="<?php if (!$settings['auth.allow_remember']) echo 'display: none'; ?>">
							<label class="control-label" for="remember_length"><?php echo lang('bf_remember_time') ?></label>
							<div class="controls">
								<select name="remember_length" id="remember_length">
									<option value="604800"  <?php echo $settings['auth.remember_length'] == '604800' ?  'selected="selected"' : '' ?>>1 <?php echo lang('bf_week') ?></option>
									<option value="1209600" <?php echo $settings['auth.remember_length'] == '1209600' ? 'selected="selected"' : '' ?>>2 <?php echo lang('bf_weeks') ?></option>
									<option value="1814400" <?php echo $settings['auth.remember_length']== '1814400' ? 'selected="selected"' : '' ?>>3 <?php echo lang('bf_weeks') ?></option>
									<option value="2592000" <?php echo $settings['auth.remember_length'] == '2592000' ? 'selected="selected"' : '' ?>>30 <?php echo lang('bf_days') ?></option>
								</select>
							</div>
						</div>

						<div class="control-group" id="password-strength">
							<label class="control-label" for="password_min_length"><?php echo lang('bf_password_strength') ?></label>
							<div class="controls">
								<input type="text" name="password_min_length" id="password_min_length" value="<?php echo set_value('password_min_length', isset($settings['auth.password_min_length']) ? $settings['auth.password_min_length'] : '') ?>" class="span1" />
								<p class="help-inline"><?php echo lang('bf_password_length_help') ?></p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('set_option_password'); ?></label>
							<div class="controls">
								<label class="checkbox" for="password_force_numbers">
									<input type="checkbox" name="password_force_numbers" id="password_force_numbers" value="1" <?php echo set_checkbox('password_force_numbers', 1, isset($settings['auth.password_force_numbers']) && $settings['auth.password_force_numbers'] == 1 ? TRUE : FALSE); ?> />
									<?php echo lang('bf_password_force_numbers') ?>
								</label>
								<label class="checkbox" for="password_force_symbols">
									<input type="checkbox" name="password_force_symbols" id="password_force_symbols" value="1" <?php echo set_checkbox('password_force_symbols', 1, isset($settings['auth.password_force_symbols']) && $settings['auth.password_force_symbols'] == 1 ? TRUE : FALSE); ?> />
									<?php echo lang('bf_password_force_symbols') ?>
								</label>
								<label class="checkbox" for="password_force_mixed_case">
									<input type="checkbox" name="password_force_mixed_case" id="password_force_mixed_case" value="1" <?php echo set_checkbox('password_force_mixed_case', 1, isset($settings['auth.password_force_mixed_case']) && $settings['auth.password_force_mixed_case'] == 1 ? TRUE : FALSE); ?> />
									<?php echo lang('bf_password_force_mixed_case') ?>
								</label>
								<label class="checkbox" for="password_show_labels">
									<input type="checkbox" name="password_show_labels" id="password_show_labels" value="1" <?php echo set_checkbox('password_show_labels', 1, isset($settings['auth.password_show_labels']) && $settings['auth.password_show_labels'] == 1 ? TRUE : FALSE); ?> />
									<?php echo lang('bf_password_show_labels') ?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label for="password_iterations" class="control-label"><?php echo lang('set_password_iterations') ?></label>
							<div class="controls">
								<select name="password_iterations" style="width: auto">
									<option <?php echo set_select('password_iterations', 2, $settings['password_iterations'] == 2) ?>>2</option>
									<option <?php echo set_select('password_iterations', 4, $settings['password_iterations'] == 4) ?>>4</option>
									<option <?php echo set_select('password_iterations', 8, $settings['password_iterations'] == 8) ?>>8</option>
									<option <?php echo set_select('password_iterations', 16, $settings['password_iterations'] == 16) ?>>16</option>
									<option <?php echo set_select('password_iterations', 31, $settings['password_iterations'] == 31) ?>>31</option>
								</select>
								<span class="help-inline"><?php echo lang('bf_password_iterations_note'); ?></span>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="force_pass_reset"><?php echo lang('set_force_reset') ?></label>
							<div class="controls">
								<a href="<?php echo site_url(SITE_AREA .'/settings/users/force_password_reset_all'); ?>" class="btn btn-danger" onclick="return confirm('<?php echo lang('set_password_reset_confirm') ?>');">
									<?php echo lang('set_reset'); ?>
								</a>
								<span class="help-inline"><?php echo lang('set_reset_note'); ?></span>
							</div>
						</div>
					</fieldset>
				</div>
			<?php if (has_permission('Site.Developer.View')) : ?>
				<!-- Start of Developer Settings Tab Pane -->
				<div class="tab-pane" id="developer">
					<fieldset>
						<legend><?php echo lang('set_option_developer'); ?></legend>

						<div class="control-group">
							<div class="controls">
								<label class="checkbox" for="show_profiler">
									<input type="checkbox" name="show_profiler" id="show_profiler" value="1" <?php echo  $settings['site.show_profiler'] == 1 ? 'checked="checked"' : set_checkbox('auth.use_extended_profile', 1); ?> />
									<span><?php echo lang('bf_show_profiler') ?></span>
								</label>
								<label class="checkbox" for="show_front_profiler">
									<input type="checkbox" name="show_front_profiler" id="show_front_profiler" value="1" <?php echo  $settings['site.show_front_profiler'] == 1 ? 'checked="checked"' : set_checkbox('site.show_front_profiler', 1); ?> />
									<span><?php echo lang('bf_show_front_profiler') ?></span>
								</label>
								<label class="checkbox" for="enable_cache">
									<input type="checkbox" name="enable_cache" id="enable_cache" value="1" <?php echo  $settings['site.enable_cache'] == 1 ? 'checked="checked"' : set_checkbox('site.enable_cache', 1); ?> />
									<span><?php echo lang('bf_enable_cache') ?></span>
								</label>
								<label class="checkbox" for="do_check">
									<input type="checkbox" name="do_check" id="do_check" value="1" <?php echo $settings['updates.do_check'] == 1 ? 'checked="checked"' : set_checkbox('updates.do_check', 1); ?> />
									<span><?php echo lang('bf_do_check') ?></span>
									<p class="help-block"><?php echo lang('bf_do_check_edge') ?></p>
								</label>
								<label class="checkbox" for="bleeding_edge">
									<input type="checkbox" name="bleeding_edge" id="bleeding_edge" value="1" <?php echo $settings['updates.bleeding_edge'] == 1 ? 'checked="checked"' : set_checkbox('updates.bleeding_edge', 1); ?> />
									<span><?php echo lang('bf_update_show_edge') ?></span>
									<p class="help-block"><?php echo lang('bf_update_info_edge') ?></p>
								</label>
							</div>
						</div>

					</fieldset>
				</div>
				<!-- End of Developer Tab Options Pane -->
			<?php endif;
				if ($show_extended_settings) :
			?>
				<!-- Start of Extended Settings Tab Pane -->
				<div class='tab-pane' id='extended'>
					<fieldset>
						<legend><?php echo lang('set_option_extended'); ?></legend>
				<?php
					foreach ($extended_settings as $field)
					{
						if ( empty($field['permission'])
							|| $field['permission'] === FALSE
							|| ( ! empty($field['permission']) && has_permission($field['permission']))
							)
						{
							$form_error_class = form_error($field['name']) ? ' error' : '';
							$field_control = '';

							if ($field['form_detail']['type'] == 'dropdown')
							{
								echo form_dropdown($field['form_detail']['settings'], $field['form_detail']['options'], set_value($field['name'], isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : ''), $field['label']);
							}
							elseif ($field['form_detail']['type'] == 'checkbox') {
								$field_control = form_checkbox($field['form_detail']['settings'], '1' , $settings['ext.' .$field['name']] == 1 ? 'checked="checked"' : set_checkbox('ext.' .$field['name'], 1));
							} elseif ($field ['form_detail'] ['type'] == 'country_select') {
								// Change the values in this array to populate your dropdown as required
								$options = array( '' => '-- Select Country --' );
								foreach($countries as $country){ $options[$country->iso] = ucwords(strtolower($country->name)); }
								$js = 'onChange="selectState(this.options[this.selectedIndex].value)"';
								echo form_dropdown($field['form_detail']['settings'], $options, set_value($field['name'], isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : ''), $field['label'], $js);
							} elseif ($field ['form_detail'] ['type'] == 'state_select') {
								$options = array( '' => '-- Select State --' );
								$js = 'onChange="selectCity(this.options[this.selectedIndex].value)"';
								foreach($states as $state) { $options[$state->id] = $state->name; }
								echo form_dropdown($field['form_detail']['settings'], $options, set_value($field['name'], isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : ''), $field['label'], $js);
							} elseif ($field ['form_detail'] ['type'] == 'currency_select') {
								$options = array( '' => '-- Select Currency --' );
								foreach($currencies as $currency) { $options[$currency->symbol] = $currency->code; }
								echo form_dropdown($field['form_detail']['settings'], $options, set_value($field['name'], isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : ''), $field['label']);
							}
							else
							{
								$form_method = 'form_' . $field['form_detail']['type'];
								if (is_callable($form_method))
								{
									echo $form_method($field['form_detail']['settings'], set_value($field['name'], isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : ''), $field['label']);
								}
							}

							if ( ! empty($field_control)) :
						?>
								<div class="control-group<?php echo $form_error_class; ?>">
									<label class="control-label" for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
									<div class="controls">
										<?php echo $field_control; ?>
									</div>
								</div>
						<?php
							endif;
						}
					}
				?>
					</fieldset>
				</div>
			<?php endif;
			if ($show_general_settings) :
				?>
				<!-- Start of Extended Settings Tab Pane -->
			<div class='tab-pane' id='general'>
				<fieldset>
					<legend><?php echo lang('set_option_general'); ?></legend>
				<?php
				foreach ( $general_settings as $field ) {
					if (empty ( $field ['permission'] ) || $field ['permission'] === FALSE || (! empty ( $field ['permission'] ) && has_permission ( $field ['permission'] ))) {
						$form_error_class = form_error ( $field ['name'] ) ? ' error' : '';
						$field_control = '';
						
						if ($field ['form_detail'] ['type'] == 'dropdown') {
							echo form_dropdown ( $field ['form_detail'] ['settings'], $field ['form_detail'] ['options'], set_value ( $field ['name'], isset ( $settings ['site.' . $field ['name']] ) ? $settings ['site.' . $field ['name']] : '' ), $field ['label'] );
						} elseif ($field ['form_detail'] ['type'] == 'textarea') {
							$field_control = form_textarea(array( 'name' => $field ['name'], 'id' => $field ['name'], 'class' => 'span6', 'rows' => '5', 'value' => set_value ( $field ['name'], isset ( $settings ['site.' . $field ['name']] ) ? $settings ['site.' . $field ['name']] : '', false )));
							//$field_control = form_textarea( $field ['form_detail'] ['settings'], set_value ( $field ['name'], isset ( $settings ['site.' . $field ['name']] ) ? $settings ['site.' . $field ['name']] : '' ));
						} elseif ($field ['form_detail'] ['type'] == 'checkbox') {
							$field_control = form_checkbox($field['name'], 1, $settings ['site.' . $field ['name']] == 1 ? TRUE : FALSE);	
						} else {
							$form_method = 'form_' . $field ['form_detail'] ['type'];
							if (is_callable ( $form_method )) {
								echo $form_method ( $field ['form_detail'] ['settings'], set_value ( $field ['name'], isset ( $settings ['site.' . $field ['name']] ) ? $settings ['site.' . $field ['name']] : '' ), $field ['label'] );
							}
						}
						
						if (! empty ( $field_control )) :
							?>
								<div class="control-group<?php echo $form_error_class; ?>">
						<label class="control-label" for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
						<div class="controls">
										<?php echo $field_control; ?>
									</div>
					</div>
						
						<?php
							endif;
					}
				}
				?>
					</fieldset>
			</div>
			<?php endif; ?>
			<!-- Start of Advanced Settings Tab Pane -->
				<div class="tab-pane" id="advanced">
					<fieldset>
						<legend><?php echo lang('header_settings') ?></legend>
						<div class="control-group">
							<div class="controls">
								<label for="display_top_menu">
									<input type="checkbox" name="display_top_menu" id="display_top_menu" value="1" <?php echo $settings['site.display_top_menu'] == 1 ? 'checked="checked"' : set_checkbox('site.display_top_menu', 1); ?> />
									<span><?php echo lang('display_top_menu') ?></span>
								</label>
								<label for="display_email">
									<input type="checkbox" name="display_email" id="display_email" value="1" <?php echo $settings['site.display_email'] == 1 ? 'checked="checked"' : set_checkbox('site.display_email', 1); ?> />
									<span><?php echo lang('display_email') ?></span>
								</label>
							</div>
							<div class="control-group">
								<label class="control-label" for="call_us"><?php echo lang('site_call_us') ?></label>
								<div class="controls">
									<input type="text" name="call_us" id="call_us" class="span6" value="<?php echo set_value('site.call_us', isset($settings['site.call_us']) ? $settings['site.call_us'] : '') ?>" />
								</div>
						</div>							
						</div>
						<legend><?php echo lang('search_settings') ?></legend>
						<div class="control-group">
							<label class="control-label" for="search_blocks"><?php echo lang('search_blocks') ?></label>
							<div class="controls">
								<select name="search_blocks" id="search_blocks" class="span6">
									<option value="1" <?php echo $settings['adv.search_blocks'] == '1' ? 'selected="selected"' : ''; ?>><?php echo lang('search_blocks_default') ?></option>
									<option value="2" <?php echo $settings['adv.search_blocks'] == '2' ? 'selected="selected"' : ''; ?>><?php echo lang('search_blocks_category') ?></option>
									<option value="3" <?php echo $settings['adv.search_blocks'] == '3' ? 'selected="selected"' : ''; ?>><?php echo lang('search_blocks_what_where') ?></option>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="search_location"><?php echo lang('search_location') ?></label>
							<div class="controls">
								<select name="search_location" id="search_location" class="span6">
									<option value="1" <?php echo $settings['adv.search_location'] == '1' ? 'selected="selected"' : ''; ?>><?php echo lang('search_location_all') ?></option>
									<option value="2" <?php echo $settings['adv.search_location'] == '2' ? 'selected="selected"' : ''; ?>><?php echo lang('search_location_city_locality') ?></option>
									<option value="3" <?php echo $settings['adv.search_location'] == '3' ? 'selected="selected"' : ''; ?>><?php echo lang('search_location_state_city_locality') ?></option>
								</select>
							</div>
						</div>
						<?php // Change the values in this array to populate your dropdown as required
							$country_options = array(
								'' => '-- Select Country --'
							);
							if(!empty($countries)):
							foreach($countries as $country){
								$country_options[$country->iso] = ucwords(strtolower($country->name));
							}
							endif;
							$js = 'class = "span6", onChange="selectState(this.options[this.selectedIndex].value)"';
							echo form_dropdown('default_country', $country_options, set_value('default_country', isset($settings['adv.default_country']) ? $settings['adv.default_country'] : ''), lang('default_country'). lang('bf_form_label_required'), $js);
						?>				
								
						<?php // Change the values in this array to populate your dropdown as required
							$options = array(
								'' => '-- Select State --'
							);
							$js = 'class = "span6", onChange="selectCity(this.options[this.selectedIndex].value)"';
							if (isset($settings['adv.default_state'])) {
								$js .= '';
								if(!empty($states)):
								foreach($states as $state) { $options[$state->id] = $state->name; }
								endif;
							}
							else { $js .= ''; }				
							echo form_dropdown('default_state', $options, set_value('default_state', isset($settings['adv.default_state']) ? $settings['adv.default_state'] : ''), lang('default_state'). lang('bf_form_label_required'), $js);
						?><span id="state_loader"></span>
						
						<?php // Change the values in this array to populate your dropdown as required
							$options = array(
								'' => '-- Select City --'
							);
							$js ='class = "span6""';
							if (!empty($settings['adv.default_city'])) {
								$js .= '';
								if(!empty($cities)):
								foreach($cities as $city) { $options[$city->id] = $city->name; }
								endif;
							}
							else { $js .= ''; }
							
							echo form_dropdown('default_city', $options, set_value('default_city', isset($settings['adv.default_city']) ? $settings['adv.default_city'] : ''), lang('default_city'). lang('bf_form_label_required'), $js);
						?><span id="city_loader"></span>
						</fieldset>						
				</div>
				<!-- Start of Advanced Settings Tab Pane -->
				<div class="tab-pane" id="listing">
				<fieldset>
							<legend><?php echo lang('listing_general_settings') ?></legend>
							<div class="control-group">
							<div class="controls">
								<label for="top_advertisement">
									<input type="checkbox" name="top_advertisement" id="top_advertisement" value="1" <?php echo $settings['lst.top_advertisement'] == 1 ? 'checked="checked"' : set_checkbox('lst.top_advertisement', 1); ?> />
									<span><?php echo lang('top_advertisement') ?></span>
								</label>
								<label for="allow_email">
									<input type="checkbox" name="allow_email" id="allow_email" value="1" <?php echo $settings['lst.allow_email'] == 1 ? 'checked="checked"' : set_checkbox('lst.allow_email', 1); ?> />
									<span><?php echo lang('allow_email') ?></span>
								</label>
								<label for="allow_print">
									<input type="checkbox" name="allow_print" id="allow_print" value="1" <?php echo $settings['lst.allow_print'] == 1 ? 'checked="checked"' : set_checkbox('lst.allow_print', 1); ?> />
									<span><?php echo lang('allow_print') ?></span>
								</label>
								<label for="allow_review">
									<input type="checkbox" name="allow_review" id="allow_review" value="1" <?php echo $settings['lst.allow_review'] == 1 ? 'checked="checked"' : set_checkbox('lst.allow_review', 1); ?> />
									<span><?php echo lang('allow_review') ?></span>
								</label>
								<label for="loggedin_review_only">
									<input type="checkbox" name="loggedin_review_only" id="loggedin_review_only" value="1" <?php echo $settings['lst.loggedin_review_only'] == 1 ? 'checked="checked"' : set_checkbox('lst.loggedin_review_only', 1); ?> />
									<span><?php echo lang('loggedin_review_only') ?></span>
								</label>
								<label for="query_email_notification">
									<input type="checkbox" name="query_email_notification" id="query_email_notification" value="1" <?php echo $settings['lst.query_email_notification'] == 1 ? 'checked="checked"' : set_checkbox('lst.query_email_notification', 1); ?> />
									<span><?php echo lang('query_email_notification') ?></span>
								</label>
							</div>
							</div>
							<div class="control-group">
							<label class="control-label" for="advertisement_page"><?php echo lang('advertisement_page') ?></label>
								<div class="controls">
									<select name="advertisement_page" id="advertisement_page" class="span6">
										<?php foreach($pages as $page) { ?>
										<option value="<?php echo $page->slug; ?>" <?php echo $settings['lst.advertisement_page'] == $page->slug ? 'selected="selected"' : ''; ?>><?php echo $page->title; ?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="featured_location"><?php echo lang('featured_location') ?></label>
								<div class="controls">
									<select name="featured_location" id="featured_location" class="span6">
										<option value="1" <?php echo $settings['lst.featured_location'] == '1' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_all') ?></option>
										<option value="2" <?php echo $settings['lst.featured_location'] == '2' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home') ?></option>										
										<option value="3" <?php echo $settings['lst.featured_location'] == '3' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_category') ?></option>
										<option value="4" <?php echo $settings['lst.featured_location'] == '4' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_product') ?></option>
										<option value="5" <?php echo $settings['lst.featured_location'] == '5' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home_category') ?></option>
										<option value="6" <?php echo $settings['lst.featured_location'] == '6' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home_product') ?></option>
										<option value="7" <?php echo $settings['lst.featured_location'] == '7' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_category_product') ?></option>
										<option value="8" <?php echo $settings['lst.featured_location'] == '8' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_none') ?></option>
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="recently_added_location"><?php echo lang('recently_added_location') ?></label>
								<div class="controls">
									<select name="recently_added_location" id="recently_added_location" class="span6">
										<option value="1" <?php echo $settings['lst.recently_added_location'] == '1' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_all') ?></option>
										<option value="2" <?php echo $settings['lst.recently_added_location'] == '2' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home') ?></option>										
										<option value="3" <?php echo $settings['lst.recently_added_location'] == '3' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_category') ?></option>
										<option value="4" <?php echo $settings['lst.recently_added_location'] == '4' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_product') ?></option>
										<option value="5" <?php echo $settings['lst.recently_added_location'] == '5' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home_category') ?></option>
										<option value="6" <?php echo $settings['lst.recently_added_location'] == '6' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home_product') ?></option>
										<option value="7" <?php echo $settings['lst.recently_added_location'] == '7' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_category_product') ?></option>
										<option value="8" <?php echo $settings['lst.recently_added_location'] == '8' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_none') ?></option>
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="popular_location"><?php echo lang('popular_location') ?></label>
								<div class="controls">
									<select name="popular_location" id="popular_location" class="span6">
										<option value="1" <?php echo $settings['lst.popular_location'] == '1' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_all') ?></option>
										<option value="2" <?php echo $settings['lst.popular_location'] == '2' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home') ?></option>										
										<option value="3" <?php echo $settings['lst.popular_location'] == '3' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_category') ?></option>
										<option value="4" <?php echo $settings['lst.popular_location'] == '4' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_product') ?></option>
										<option value="5" <?php echo $settings['lst.popular_location'] == '5' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home_category') ?></option>
										<option value="6" <?php echo $settings['lst.popular_location'] == '6' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_home_product') ?></option>
										<option value="7" <?php echo $settings['lst.popular_location'] == '7' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_category_product') ?></option>
										<option value="8" <?php echo $settings['lst.popular_location'] == '8' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_none') ?></option>
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="related_links_location"><?php echo lang('related_links_location') ?></label>
								<div class="controls">
									<select name="related_links_location" id="related_links_location" class="span6">
										<option value="1" <?php echo $settings['lst.related_links_location'] == '1' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_product') ?></option>
										<option value="0" <?php echo $settings['lst.related_links_location'] == '0' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_location_none') ?></option>
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="top_featured_count"><?php echo lang('top_featured_count') ?></label>
								<div class="controls">
									<select name="top_featured_count" id="top_featured_count" class="span6">
										<?php for($i = 1; $i <= 10; $i++ ) { ?>
										<option value="<?php echo $i; ?>" <?php echo $settings['lst.top_featured_count'] == $i ? 'selected="selected"' : ''; ?>><?php echo $i; ?></option>
									<?php }?>
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="right_featured_count"><?php echo lang('right_featured_count') ?></label>
								<div class="controls">
									<select name="right_featured_count" id="right_featured_count" class="span6">
										<?php for($i = 1; $i <= 10; $i++ ) { ?>
										<option value="<?php echo $i; ?>" <?php echo $settings['lst.right_featured_count'] == $i ? 'selected="selected"' : ''; ?>><?php echo $i; ?></option>
									<?php }?>
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="recently_added_count"><?php echo lang('recently_added_count') ?></label>
								<div class="controls">
									<select name="recently_added_count" id="recently_added_count" class="span6">
										<?php for($i = 1; $i <= 10; $i++ ) { ?>
										<option value="<?php echo $i; ?>" <?php echo $settings['lst.recently_added_count'] == $i ? 'selected="selected"' : ''; ?>><?php echo $i; ?></option>
									<?php }?>
									</select>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="popular_count"><?php echo lang('popular_count') ?></label>
								<div class="controls">
									<select name="popular_count" id="popular_count" class="span6">
									<?php for($i = 1; $i <= 10; $i++ ) { ?>
										<option value="<?php echo $i; ?>" <?php echo $settings['lst.popular_count'] == $i ? 'selected="selected"' : ''; ?>><?php echo $i; ?></option>
									<?php }?>
									</select>
								</div>
							</div>		
							
							<div class="control-group">
								<label class="control-label" for="related_links_count"><?php echo lang('related_links_count') ?></label>
								<div class="controls">
									<select name="related_links_count" id="related_links_count" class="span6">
									<?php for($i = 1; $i <= 10; $i++ ) { ?>
										<option value="<?php echo $i; ?>" <?php echo $settings['lst.related_links_count'] == $i ? 'selected="selected"' : ''; ?>><?php echo $i; ?></option>
									<?php }?>
									</select>
								</div>
							</div>							
							
						</fieldset>
						<fieldset>
						<legend><?php echo lang('listing_registration_fields') ?></legend>
						<div class="control-group">
							<div class="controls">
								<label for="allow_country_selection">
									<input type="checkbox" name="allow_country_selection" id="allow_country_selection" value="1" <?php echo $settings['lst.allow_country_selection'] == 1 ? 'checked="checked"' : set_checkbox('lst.allow_country_selection', 1); ?> />
									<span><?php echo lang('allow_country_selection') ?></span>
								</label>
								<label for="allow_facebook_url">
									<input type="checkbox" name="allow_facebook_url" id="allow_facebook_url" value="1" <?php echo $settings['lst.allow_facebook_url'] == 1 ? 'checked="checked"' : set_checkbox('lst.allow_facebook_url', 1); ?> />
									<span><?php echo lang('allow_facebook_url') ?></span>
								</label>
								<label for="allow_twitter_url">
									<input type="checkbox" name="allow_twitter_url" id="allow_twitter_url" value="1" <?php echo $settings['lst.allow_twitter_url'] == 1 ? 'checked="checked"' : set_checkbox('lst.allow_twitter_url', 1); ?> />
									<span><?php echo lang('allow_twitter_url') ?></span>
								</label>
								<label for="allow_googleplus_url">
									<input type="checkbox" name="allow_googleplus_url" id="allow_googleplus_url" value="1" <?php echo $settings['lst.allow_googleplus_url'] == 1 ? 'checked="checked"' : set_checkbox('lst.allow_googleplus_url', 1); ?> />
									<span><?php echo lang('allow_googleplus_url') ?></span>
								</label>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="categories_level"><?php echo lang('categories_level') ?></label>
								<div class="controls">
									<select name="categories_level" id="categories_level" class="span6">
										<option value="1" <?php echo $settings['lst.categories_level'] == '1' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_categories_level_1') ?></option>
										<option value="2" <?php echo $settings['lst.categories_level'] == '2' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_categories_level_2') ?></option>										
										<option value="3" <?php echo $settings['lst.categories_level'] == '3' ? 'selected="selected"' : ''; ?>><?php echo lang('listing_categories_level_3') ?></option>
									</select>
								</div>
						</div>
						</fieldset>						
						<fieldset>
							<legend><?php echo lang('listing_member_settings') ?></legend>
							<div class="control-group">
								<label class="control-label" for="logo_file_size"><?php echo lang('listing_logo_file_size') ?></label>
								<div class="controls">
									<input type="text" name="logo_file_size" id="logo_file_size" class="span6" value="<?php echo set_value('lst.logo_file_size', isset($settings['lst.logo_file_size']) ? $settings['lst.logo_file_size'] : '') ?>" />
								</div>
							</div>
							<div class="control-group">
							<label class="control-label"><?php echo lang('listing_logo_pixels'); ?></label>
							<div class="controls">
								<div id="logo_pixels">
									<input type="text" name="logo_width" style="width: 5em;" value="<?php echo $settings['lst.logo_width'] ?>"> X 
									<input type="text" name="logo_height" style="width: 5em;" value="<?php echo $settings['lst.logo_height'] ?>">
								</div>
							</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="image_file_size"><?php echo lang('listing_image_file_size') ?></label>
								<div class="controls">
									<input type="text" name="image_file_size" id="image_file_size" class="span6" value="<?php echo set_value('lst.image_file_size', isset($settings['lst.image_file_size']) ? $settings['lst.image_file_size'] : '') ?>" />
								</div>
							</div>
							<div class="control-group">
							<label class="control-label"><?php echo lang('listing_image_pixels'); ?></label>
							<div class="controls">
								<div id="image_pixels">
									<input type="text" name="image_width" style="width: 5em;" value="<?php echo $settings['lst.image_width'] ?>"> X 
									<input type="text" name="image_height" style="width: 5em;" value="<?php echo $settings['lst.image_height'] ?>">
									<p class="help-inline"><?php echo lang('listing_image_help') ?></p>
								</div>								
							</div>
							</div>
							<div class="control-group">
							<label class="control-label"><?php echo lang('listing_thumbnail_pixels'); ?></label>
							<div class="controls">
								<div id="thumbnail_pixels">
									<input type="text" name="thumbnail_width" style="width: 5em;" value="<?php echo $settings['lst.thumbnail_width'] ?>"> X 
									<input type="text" name="thumbnail_height" style="width: 5em;" value="<?php echo $settings['lst.thumbnail_height'] ?>">
								</div>								
							</div>
							</div>
						</fieldset>
				</div>	
				<div class="tab-pane" id="financial">
				<fieldset>
					<legend><?php echo lang('listing_general_settings') ?></legend>
					<div class="control-group">
						<label class="control-label" for="days_before_email"><?php echo lang('financial_days_before_email') ?></label>
						<div class="controls">
							<input type="text" name="days_before_email" id="days_before_email" class="span6" value="<?php echo set_value('fin.days_before_email', isset($settings['fin.days_before_email']) ? $settings['fin.days_before_email'] : '') ?>" />
							<p class="help-inline"><?php echo lang('days_before_email_help') ?></p>
						</div>
					</div>
				</fieldset>
				</div>		
			</div>
		</div>

		<div class="form-actions">
			<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_context_settings'); ?>" />
		</div>

	<?php echo form_close(); ?>
</div><!-- /admin-box -->