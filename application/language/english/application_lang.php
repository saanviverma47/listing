<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	/*
 * Copyright (c) 2011 Lonnie Ezell Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions: The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
	
// --------------------------------------------------------------------
	// ! GENERAL SETTINGS
	// --------------------------------------------------------------------

$lang['bf_site_name'] = 'Site Name';
$lang['bf_site_email'] = 'Site Email';
$lang['bf_site_email_help'] = 'The default email that system-generated emails are sent from.';
$lang['bf_site_status'] = 'Site Status';
$lang['bf_online'] = 'Online';
$lang['bf_offline'] = 'Offline';
$lang['bf_top_number'] = 'Items <em>per</em> page:';
$lang['bf_top_number_help'] = 'When viewing reports, how many items should be listed at a time?';
$lang['bf_home'] = 'Home';
$lang['bf_site_information'] = 'Site Information';
$lang['bf_timezone'] = 'Timezone';
$lang['bf_language'] = 'Language';
$lang['bf_language_help'] = 'Choose the languages available to the user.';

// --------------------------------------------------------------------
// ! AUTH SETTINGS
// --------------------------------------------------------------------

$lang['bf_security'] = 'Security';
$lang['bf_login_type'] = 'Login Type';
$lang['bf_login_type_email'] = 'Email Only';
$lang['bf_login_type_username'] = 'Username Only';
$lang['bf_allow_register'] = 'Allow User Registrations?';
$lang['bf_login_type_both'] = 'Email or Username';
$lang['bf_use_usernames'] = 'User display across bonfire:';
$lang['bf_use_own_name'] = 'Use Own Name';
$lang['bf_allow_remember'] = 'Allow \'Remember Me\'?';
$lang['bf_remember_time'] = 'Remember Users For';
$lang['bf_week'] = 'Week';
$lang['bf_weeks'] = 'Weeks';
$lang['bf_days'] = 'Days';
$lang['bf_username'] = 'Username';
$lang['bf_password'] = 'Password';
$lang['bf_password_confirm'] = 'Password (again)';
$lang['bf_display_name'] = 'Display Name';

// --------------------------------------------------------------------
// ! CRUD SETTINGS
// --------------------------------------------------------------------

$lang['bf_home_page'] = 'Home Page';
$lang['bf_pages'] = 'Pages';
$lang['bf_enable_rte'] = 'Enable RTE for pages?';
$lang['bf_rte_type'] = 'RTE Type';
$lang['bf_searchable_default'] = 'Searchable by default?';
$lang['bf_cacheable_default'] = 'Cacheable by default?';
$lang['bf_track_hits'] = 'Track Page Hits?';

$lang['bf_action_save'] = 'Save';
$lang['bf_action_delete'] = 'Delete';
$lang['bf_action_edit'] = 'Edit';
$lang['bf_action_undo'] = 'Undo';
$lang['bf_action_cancel'] = 'Cancel';
$lang['bf_action_download'] = 'Download';
$lang['bf_action_preview'] = 'Preview';
$lang['bf_action_search'] = 'Search';
$lang['bf_action_purge'] = 'Purge';
$lang['bf_action_restore'] = 'Restore';
$lang['bf_action_show'] = 'Show';
$lang['bf_action_login'] = 'Sign In';
$lang['bf_action_logout'] = 'Sign Out';
$lang['bf_actions'] = 'Actions';
$lang['bf_clear'] = 'Clear';
$lang['bf_action_list'] = 'List';
$lang['bf_action_create'] = 'Create';
$lang['bf_action_ban'] = 'Ban';
$lang['bf_action_spam'] = 'Mark as Spam';
$lang['bf_action_unspam'] = 'Remove from Spam';

// --------------------------------------------------------------------
// ! SETTINGS LIB
// --------------------------------------------------------------------

$lang['bf_do_check'] = 'Check for updates?';
$lang['bf_do_check_edge'] = 'Must be enabled to see bleeding edge updates as well.';

$lang['bf_update_show_edge'] = 'View bleeding edge updates?';
$lang['bf_update_info_edge'] = 'Leave unchecked to only check for new tagged updates. Check to see any new commits to the official repository.';

$lang['bf_ext_profile_show'] = 'Does User accounts have extended profile?';
$lang['bf_ext_profile_info'] = 'Check "Extended Profiles" to have extra profile meta-data available option(wip), omiting some default bonfire fields (eg: address).';

$lang['bf_yes'] = 'Yes';
$lang['bf_no'] = 'No';
$lang['bf_none'] = 'None';
$lang['bf_id'] = 'ID';

$lang['bf_or'] = 'or';
$lang['bf_size'] = 'Size';
$lang['bf_files'] = 'Files';
$lang['bf_file'] = 'File';

$lang['bf_with_selected'] = 'With selected';

$lang['bf_env_dev'] = 'Development';
$lang['bf_env_test'] = 'Testing';
$lang['bf_env_prod'] = 'Production';

$lang['bf_show_profiler'] = 'Show Admin Profiler?';
$lang['bf_show_front_profiler'] = 'Show Front End Profiler?';

$lang['bf_cache_not_writable'] = 'The application cache folder is not writable';
$lang['gc_form_decimal_extra'] = 'The %s field may only contain decimal values';
$lang['bf_password_strength'] = 'Password Strength Settings';
$lang['bf_password_length_help'] = 'Minimum password length e.g. 8';
$lang['bf_password_force_numbers'] = 'Should password force numbers?';
$lang['bf_password_force_symbols'] = 'Should password force symbols?';
$lang['bf_password_force_mixed_case'] = 'Should password force mixed case?';
$lang['bf_password_show_labels'] = 'Display password validation labels';
$lang['bf_password_iterations_note'] = 'Higher values increase the security and the time taken to hash the passwords.<br/>See the <a href="http://www.openwall.com/phpass/" target="blank">phpass page</a> for more information. If in doubt, leave at 8.';

// --------------------------------------------------------------------
// ! USER/PROFILE
// --------------------------------------------------------------------

$lang['bf_user'] = 'User';
$lang['bf_users'] = 'Users';
$lang['bf_description'] = 'Description';
$lang['bf_email'] = 'Email';
$lang['bf_user_settings'] = 'My Profile';

// --------------------------------------------------------------------
// !
// --------------------------------------------------------------------

$lang['bf_both'] = 'both';
$lang['bf_go_back'] = 'Go Back';
$lang['bf_new'] = 'New';
$lang['bf_required_note'] = 'Required fields are in <b>bold</b>.';
$lang['bf_form_label_required'] = '<span class="required">*</span>';

// --------------------------------------------------------------------
// MY_Model
// --------------------------------------------------------------------
$lang['bf_model_db_error'] = 'DB Error: %s';
$lang['bf_model_no_data'] = 'No data available.';
$lang['bf_model_invalid_id'] = 'Invalid ID passed to model.';
$lang['bf_model_no_table'] = 'Model has unspecified database table.';
$lang['bf_model_fetch_error'] = 'Not enough information to fetch field.';
$lang['bf_model_count_error'] = 'Not enough information to count results.';
$lang['bf_model_unique_error'] = 'Not enough information to check uniqueness.';
$lang['bf_model_find_error'] = 'Not enough information to find by.';

// --------------------------------------------------------------------
// Contexts
// --------------------------------------------------------------------
$lang['bf_no_contexts'] = 'The contexts array is not properly setup. Check your application config file.';
$lang['bf_context_dashboard'] = 'Dashboard';
$lang['bf_context_content'] = 'Content';
$lang['bf_context_reports'] = 'Reports';
$lang['bf_context_settings'] = 'Settings';
$lang['bf_context_developer'] = 'Developer';
$lang['bf_context_financial'] = 'Financial';
$lang['bf_context_help'] = 'Help';

// --------------------------------------------------------------------
// Activities
// --------------------------------------------------------------------
$lang['bf_act_settings_saved'] = 'App settings saved from';
$lang['bf_unauthorized_attempt'] = 'unsuccessfully attempted to access a page which required the following permission "%s" from ';

$lang['bf_keyboard_shortcuts'] = 'Available keyboard shortcuts:';
$lang['bf_keyboard_shortcuts_none'] = 'There are no keyboard shortcuts assigned.';
$lang['bf_keyboard_shortcuts_edit'] = 'Update the keyboard shortcuts';

// --------------------------------------------------------------------
// Common
// --------------------------------------------------------------------
$lang['bf_question_mark'] = '?';
$lang['bf_language_direction'] = 'ltr';
$lang['log_intro'] = 'These are your log messages';
$lang['bf_name'] = 'Name';
$lang['bf_status'] = 'Status';

// --------------------------------------------------------------------
// Login
// --------------------------------------------------------------------
$lang['bf_action_register'] = 'Sign Up';
$lang['bf_forgot_password'] = 'Forgot your password?';
$lang['bf_remember_me'] = 'Remember me';

// --------------------------------------------------------------------
// Password Help Fields to be used as a warning on register
// --------------------------------------------------------------------
$lang['bf_password_number_required_help'] = 'Password must contain at least 1 number.';
$lang['bf_password_caps_required_help'] = 'Password must contain at least 1 capital letter.';
$lang['bf_password_symbols_required_help'] = 'Password must contain at least 1 symbol.';

$lang['bf_password_min_length_help'] = 'Password must be at least %s characters long.';
$lang['bf_password_length'] = 'Password Length';

// --------------------------------------------------------------------
// User Meta examples
// --------------------------------------------------------------------

$lang['user_meta_title'] = 'Meta Title';
$lang['user_meta_street_name'] = 'Street Name';
$lang['user_meta_type'] = 'Type';
$lang['user_meta_country'] = 'Country';
$lang['user_meta_state'] = 'State';

// --------------------------------------------------------------------
// Activation
// --------------------------------------------------------------------
$lang['bf_activate_method'] = 'Activation Method';
$lang['bf_activate_none'] = 'None';
$lang['bf_activate_email'] = 'Email';
$lang['bf_activate_admin'] = 'Admin';
$lang['bf_activate'] = 'Activate';
$lang['bf_activate_resend'] = 'Resend Activation';

$lang['bf_reg_complete_error'] = 'An error occurred completing your registration. Please try again or contact the site administrator for help.';
$lang['bf_reg_activate_email'] = 'An email containing your activation code has been sent to [EMAIL].';
$lang['bf_reg_activate_admin'] = 'You will be notified when the site administrator has approved your membership.';
$lang['bf_reg_activate_none'] = 'Please login to begin using the site.';
$lang['bf_user_not_active'] = 'User account is not active.';
$lang['bf_login_activate_title'] = 'Need to activate your account?';
$lang['bf_login_activate_email'] = '<b>Have an activation code to enter to activate your membership?</b> Enter it on the [ACCOUNT_ACTIVATE_URL] page.<br /><br />    <b>Need your code again?</b> Request it again on the [ACTIVATE_RESEND_URL] page.';

// --------------------------------------------------------------------
// Migrations lib
// --------------------------------------------------------------------
$lang['no_migrations_found'] = 'No migration files were found';
$lang['multiple_migrations_version'] = 'Multiple migrations version: %d';
$lang['multiple_migrations_name'] = 'Multiple migrations name: %s';
$lang['migration_class_doesnt_exist'] = 'Migration class does not exist: %s';
$lang['wrong_migration_interface'] = 'Wrong migration interface: %s';
$lang['invalid_migration_filename'] = 'Wrong migration filename: %s - %s';

// --------------------------------------------------------------------
// Profiler Template
// --------------------------------------------------------------------
$lang['bf_profiler_menu_console'] = 'Console';
$lang['bf_profiler_menu_time'] = 'Load Time';
$lang['bf_profiler_menu_time_ms'] = 'ms';
$lang['bf_profiler_menu_time_s'] = 's';
$lang['bf_profiler_menu_memory'] = 'Memory Used';
$lang['bf_profiler_menu_memory_mb'] = 'MB';
$lang['bf_profiler_menu_queries'] = 'Queries';
$lang['bf_profiler_menu_queries_db'] = 'Database';
$lang['bf_profiler_menu_vars'] = '<span>vars</span> &amp; Config';
$lang['bf_profiler_menu_files'] = 'Files';
$lang['bf_profiler_box_console'] = 'Console';
$lang['bf_profiler_box_memory'] = 'Memory Usage';
$lang['bf_profiler_box_benchmarks'] = 'Benchmarks';
$lang['bf_profiler_box_queries'] = 'Queries';
$lang['bf_profiler_box_session'] = 'Session User Data';
$lang['bf_profiler_box_files'] = 'Files';

// --------------------------------------------------------------------
// Form Validation
// --------------------------------------------------------------------
$lang['bf_form_unique'] = 'The value in &quot;%s&quot; is already being used.';
$lang['bf_form_alpha_extra'] = 'The %s field may only contain alpha-numeric characters, spaces, periods, underscores, and dashes.';
$lang['bf_form_alpha_title'] = 'The %s field may only contain alpha-numeric characters and spaces. Periods, underscores, and dashes are not allowed.';
$lang['bf_form_matches_pattern'] = 'The %s field does not match the required pattern.';
$lang['bf_form_valid_password'] = 'The %s field must be at least {min_length} characters long.';
$lang['bf_form_valid_password_nums'] = '%s must contain at least 1 number.';
$lang['bf_form_valid_password_syms'] = '%s must contain at least 1 punctuation mark.';
$lang['bf_form_valid_password_mixed_1'] = '%s must contain at least 1 uppercase characters.';
$lang['bf_form_valid_password_mixed_2'] = '%s must contain at least 1 lowercase characters.';
$lang['bf_form_allowed_types'] = '%s must contain one of the allowed selections.';
$lang['bf_form_one_of'] = '%s must contain one of the available selections.';
$lang['bf_form_valid_date_time'] = '%s format is not correct.';
$lang['bf_form_not_valid'] = '%s is invalid!';
$lang['bf_form_max_keywords'] = 'The %s field may only contain maximum %s keywords';
$lang['description_limit'] = '(Maximum characters %s)';
$lang['keywords_limit'] = 'Only comma separated values are allowed and maximum keywords are %s';
$lang['no_limit'] = 'Unlimited';
$lang['bf_form_alpha_keyword'] = 'The %s field may only contain alpha-numeric characters and spaces. Periods, underscores, and dashes are not allowed.';
$lang['bf_min_value'] = '%s minimum value is less than %s';
$lang['bf_max_value'] = '%s maximum value is greater than %s';
$lang['bf_diff_between'] = '%s fields must not exceed the permissible value';
$lang['bf_compare_fields'] = '%s first field is greater than second field';
// --------------------------------------------------------------------
// Listing Validation
// --------------------------------------------------------------------
$lang['ls_err_no_id'] = 'No Listing ID was received';
$lang['ls_err_listing_is_active'] = 'The listing is already active.';
$lang['ls_err_listing_is_inactive'] = 'The listing is already inactive.';
$lang['ls_empty_id'] = 'No listing id provided. You must provide a listing id to perform this action.';
$lang['ls_action_product_service'] = 'Product or Service';
$lang['ls_action_logo'] = 'Logo';
$lang['ls_action_gallery'] = 'Image or Video';
$lang['ls_action_working_hours'] = 'Working Hours';
$lang['ls_action'] = 'Add';
$lang['ls_logo_upload_success'] = 'Logo Uploaded Successfully';
$lang['listings_action_logo'] = 'Upload Logo';
$lang['label_no_record_found'] = 'No records found that match your selection.';

// --------------------------------------------------------------------
// mbb Language
// --------------------------------------------------------------------
$lang['listings_manage'] = 'Manage Listings';
$lang['add'] = 'Add';
$lang['edit'] = 'Edit';
$lang['listings_true'] = 'True';
$lang['listings_false'] = 'False';
$lang['save'] = 'Save';
$lang['list'] = 'Back to Listings';
$lang['listings_create'] = 'Create Listing';
$lang['new'] = 'New';
$lang['listings_edit_text'] = 'Edit this to suit your needs';
$lang['listings_no_records'] = 'There aren\'t any listings in the system.';
$lang['listings_create_new'] = 'Create a new Listings.';
$lang['create_success'] = 'Record successfully added.';
$lang['create_failure'] = 'There was a problem creating the record: ';
$lang['listings_create_new_button'] = 'Create New Listings';
$lang['invalid_id'] = 'Invalid ID.';
$lang['edit_success'] = 'Record successfully saved.';
$lang['edit_failure'] = 'There was a problem saving the record: ';
$lang['delete_success'] = 'Record(s) successfully deleted.';
$lang['delete_failure'] = 'We could not delete the record: ';
$lang['update_success'] = 'Record(s) successfully updated.';
$lang['listings_delete_error'] = 'You have not selected any records to delete.';
$lang['listings_actions'] = 'Actions';
$lang['cancel'] = 'Go Back';
$lang['delete_record'] = 'Delete this record';
$lang['delete_confirm'] = 'Are you sure you want to delete this record?';
$lang['listings_edit_heading'] = 'Edit Listing';

// Create/Edit Buttons
$lang['action_save'] = 'Save';

// Activities
$lang['act_create_record'] = 'Created record with ID';
$lang['act_edit_record'] = 'Updated record with ID';
$lang['act_delete_record'] = 'Deleted record with ID';
$lang['delete_account_confirm'] = 'Are you sure you wish to delete the selected listing(s)?';
$lang['purge_del_confirm'] = 'Are you sure you want to completely remove the listing(s) - there is no going back?';
$lang['action_purged'] = 'Listing deleted permanently';
$lang['restored_success'] = 'Listing restored successfully';
$lang['restored_error'] = 'Unable to perform restore operation';

// Column Headings
$lang['column_created'] = 'Created';
$lang['column_deleted'] = 'Deleted';
$lang['column_modified'] = 'Modified';

// Home Links
$lang['top_advertisement'] = 'Want to always see your listing on top, %s';
$lang['listings_action_logo'] = 'Logo';
$lang['listings_action_logo_update'] = 'Update';
$lang['listings_action_product_service'] = 'Product or Service';
$lang['listings_action_photos'] = 'Photos';
$lang['listings_action_videos'] = 'Videos';
$lang['listings_action_classifieds'] = 'Classifieds';
$lang['listings_action_working_hours'] = 'Business Hours';

// Status
$lang['status'] = 'Waiting for approval';

// Share
$lang['sms_info_source'] = 'For complete info, visit ';
$lang['unauthorized_deleted'] = 'Either you are not authorized or this record has been deleted';

// Member Area
// Invoicing
$lang['pending'] = 'Pending';
$lang['paid'] = 'Paid';
$lang['cancelled'] = 'Cancelled';

$lang['user_limit'] = 'You have reached your limit. You can add maximum %s %s in this package';
// Images Upload
$lang['upload_button'] = 'Upload files here';
$lang['upload-drop-area'] = 'Drop files here to upload';
$lang['upload-cancel'] = 'Cancel';
$lang['upload-failed'] = 'Failed';

$lang['loading'] = 'Loading, please wait...';
$lang['deleting'] = 'Deleting, please wait...';
$lang['saving_title'] = 'Saving title...';
$lang['saving_status'] = 'Saving status...';

$lang['list_delete'] = 'Delete';
$lang['image_active'] = 'Active';
$lang['image_inactive'] = 'Inactive';
$lang['image_status'] = 'Status';
$lang['alert_delete'] = 'Are you sure that you want to delete this image?';
$lang['upload_limit'] = 'You have reached your image upload limit';
$lang['upload_failed'] = 'Either file size or pixels are exceeding the allowed filesize';
$lang['image_help'] = 'Image size should not exceed %sKB in size and %s X %s in pixels';

// FRONTEND
// Listing details
$lang['success_message'] = 'Your information has been sent successfully';
$lang['failure_message'] = 'Unable to post your information, please try again letter';
$lang['success_rating'] = 'Your rating has been posted';
$lang['error_rating'] = 'There was a problem rating this listing';
$lang['failure_rating'] = 'You have already rated for this listing';

// Category View
$lang['ads_click'] = 'Click Here';
$lang['show_limit'] = 'Show';
$lang['label_sort_by'] = 'Sort By';
$lang['label_sort_by_default'] = 'Default';
$lang['label_sort_by_rating_high'] = 'Rating (Highest)';
$lang['label_sort_by_rating_low'] = 'Rating (Lowest)';
$lang['heading_title'] = 'Title';
$lang['heading_area'] = 'Area';
$lang['heading_address'] = 'Address';
$lang['heading_phone'] = 'Phone No';
$lang['heading_logo'] = 'Logo';
$lang['business_query'] = 'Send Query';
$lang['more_info'] = 'more';
$lang['less_info'] = 'less';
$lang['featured_listings'] = 'Featured Listings';
$lang['popular_listings'] = 'Popular Listings';
$lang['recently_added_listings'] = 'Recently Added';
$lang['related_listings'] = 'Related Listings';
$lang['related_listings_text'] = ' Website and Review';
$lang['added_on'] = 'Added on: ';
$lang['contact_heading'] = 'Tell Us What You Think...';
$lang['contact_summary'] = 'We appreciate any feedback about your overall experience on our site or how to make it even better. Please fill in the below form with any comments and we will get back to you.';
$lang['send_business_query'] = 'Send Business Query';
$lang['query_heading'] = 'Ask Query To Business Owner...';
$lang['query_summary'] = 'Please fill in the below form with your query and we will get back to you.';
$lang['form_heading_title'] = 'Please fill below given details';
$lang['label_message'] = 'Message';
$lang['placeholder_message'] = 'Enter your message';
$lang['placeholder_description'] = 'Please enter description';
$lang['label_name'] = 'Name';
$lang['placeholder_name'] = 'Enter your name';
$lang['label_phone'] = 'Phone';
$lang['placeholder_phone'] = 'Enter your phone (Optional)';
$lang['placeholder_email'] = 'Enter your email';
$lang['placeholder_title'] = 'Enter review title';
$lang['label_review'] = 'Review';
$lang['placeholder_review'] = 'Enter your review';
$lang['label_captcha'] = 'Text within image';
$lang['placeholder_captcha'] = 'Please enter the code.';
$lang['error_invalid_captcha'] = 'Invalid security code';
$lang['error_message'] = '%s is missing';
$lang['error_message_email'] = 'Please enter a valid email';
$lang['error_captcha'] = 'Please enter the code displayed within the image.';
$lang['form_submit'] = 'Send';
$lang['form_close'] = 'Close';
$lang['captcha_refresh'] = 'Refresh';
// Detail Page
$lang['detail_home'] = 'Home';
$lang['detail_products'] = 'Product(s)';
$lang['detail_services'] = 'Service(s)';
$lang['detail_gallery'] = 'Gallery';
$lang['detail_classifieds'] = 'Classifieds';
$lang['detail_description'] = 'Description';
$lang['detail_provides'] = 'Provides';
$lang['label_video_gallery'] = 'Video Gallery';
$lang['classifieds_price'] = 'Price';
$lang['classifieds_overview'] = 'Overview';
$lang['classifieds_from'] = 'Valid From';
$lang['classifieds_to'] = 'Expires On';
$lang['classifieds_buy'] = 'Buy Link';
$lang['error_not_exist'] = 'Uh oh! We couldn\'t find anything.';
$lang['label_stars'] = 'Stars';
$lang['label_half_star'] = 'Half Star';
$lang['label_one_star'] = 'One Star';
$lang['label_one_half_star'] = 'One & Half Star';
$lang['label_two_stars'] = 'Two Stars';
$lang['label_two_half_stars'] = 'Two & Half Stars';
$lang['label_three_stars'] = 'Three Stars';
$lang['label_three_half_stars'] = 'Three & Half Stars';
$lang['label_four_stars'] = 'Four Stars';
$lang['label_four_half_stars'] = 'Four & Half Stars';
$lang['label_five_stars'] = 'Five Stars';
$lang['label_not_rated'] = 'Not Rated';
$lang['label_ratings'] = 'star(s) from';
$lang['label_users_rated'] = 'user(s)';
$lang['label_click_to_call'] = 'Click to Call';
// Claim Listing
$lang['label_owner'] = 'Owner';
$lang['claim_help'] = 'Are you owner of this information?';
$lang['claim_listing'] = 'Claim Listing';
$lang['label_claim_price'] = 'Claim Price:';
$lang['label_claim_login'] = 'Please create an account and login to claim listing.<br />After completion, you would receive the listing ownership in your account';
$lang['claim_description'] = 'This listing has been claimed.';
$lang['claim_request_success'] = 'Your request for listing claim has been received successfully';
$lang['claim_request_error'] = 'Your request not submitted, please try again later';
// Share Information
$lang['share_info'] = 'Send';
$lang['send_sms'] = 'Send SMS';
$lang['send_sms_heading'] = 'Send Business Info via SMS';
$lang['label_mobile'] = 'Mobile';
$lang['placeholder_mobile'] = 'Enter mobile number';
$lang['error_mobile'] = 'Please enter a valid mobile number.';
$lang['send_email'] = 'Send Email';
$lang['send_email_heading'] = 'Send Business Info via Email';
$lang['label_friends_email'] = 'Email To';
$lang['placeholder_friends_email'] = 'Enter friend\'s email';
$lang['label_your_email'] = 'Email From';
$lang['error_email'] = 'Please enter a valid email';
$lang['print_info'] = 'PDF';
// Review Section
$lang['all_review'] = 'Review';
$lang['reviews_of'] = 'Reviews of ';
$lang['error_no_review'] = 'Uh oh! We couldn\'t find any review for this listing.';
$lang['error_loggedin_review_only'] = 'Uh oh! You must log in to submit a review.';
$lang['post_review'] = 'Post Review';
$lang['claim_report'] = 'Claim/Report';
$lang['claim_report_type'] = 'Claim/Report Type';
$lang['claim_option_first'] = 'Claim (this info belongs to me)';
$lang['claim_option_second'] = 'Incorrect Business Name';
$lang['claim_option_third'] = 'Invalid Phone Number(s)';
$lang['claim_option_fourth'] = 'Invalid Email Address';
$lang['claim_option_fifth'] = 'Other';

// Header Links
$lang['header_call_us'] = 'Call Us';
$lang['header_email'] = 'Email';
$lang['header_my_account'] = 'My Account';
$lang['header_toggle_navigation'] = 'Toggle Navigation';
$lang['header_select_state'] = 'Select a state...';
$lang['header_select_city'] = 'Select a city...';
$lang['header_select_locality'] = 'All Localities';
$lang['header_form_submit'] = 'Submit';
$lang['header_location_term'] = 'Town, City or Postcode';
$lang['header_category_term'] = 'Categories';
$lang['header_select_category'] = 'All Categories';
$lang['header_search_term'] = 'Search by business, product or service...';
$lang['header_change_country'] = 'Change Country';
$lang['header_change_state'] = 'Change State';
$lang['header_change_country_state'] = 'Change Country/State';
$lang['header_add_business'] = 'Add Your Business';
// Home Page
$lang['home_category_browse'] = 'Browse by Category';
$lang['home_location_browse'] = 'Browse by Location';
// Footer Links
$lang['display_footer_popular'] = 'Display Footer Popular';
$lang['footer_copyright'] = 'Copyright &copy; 2016-17';
$lang['footer_about_us'] = 'About Us';
$lang['footer_navigation'] = 'Navigation';
$lang['footer_social'] = 'Follow Us';
$lang['label_contact_us'] = 'Contact us';
$lang['footer_quick_links'] = 'Quick Links';
$lang['footer_partners'] = 'Partners';
$lang['footer_popular_searches'] = 'Popular Searches:';
$lang['footer_popular_cities'] = 'Popular Cities:';

// --------------------------------------------------------------------
// Members Area
// --------------------------------------------------------------------
$lang['members_menu'] = 'Menu';
$lang['members_dashboard'] = 'Dashboard';
$lang['members_business_queries'] = 'Business Queries';
$lang['members_comments'] = 'Comments';
$lang['members_invoices'] = 'Invoices';
$lang['members_profile'] = 'View/Edit Account';
$lang['members_logout'] = 'Logout';
$lang['members_admin_messages'] = 'Messages from Admin';
$lang['members_message_more_info'] = 'For more info, please check your email';
$lang['members_login_information'] = 'Login Information';
$lang['members_display_name'] = 'Display Name';
$lang['members_last_login'] = 'Last Login';
$lang['members_last_ip'] = 'Last IP';
// Dashboard
$lang['label_id'] = 'ID';
$lang['label_business_title'] = 'Business Title';
$lang['label_type'] = 'Type';
$lang['label_number_of_hits'] = 'Hits';
$lang['label_status'] = 'Status';
$lang['error_no_record_found'] = 'No records found that match your selection.';
$lang['validations_error'] = 'Please fix the following errors:';
// Form
$lang['label_listing'] = 'Listing';
$lang['label_business'] = 'Business';
$lang['label_product'] = 'Product';
$lang['label_service'] = 'Service';
$lang['label_classified'] = 'Classified';
$lang['label_business_hours'] = 'Business Hours';
$lang['label_package'] = 'Package';
$lang['label_posted_on'] = 'Posted On';
$lang['label_reply'] = 'Reply';
$lang['label_title'] = 'Title';
$lang['label_slug'] = 'Slug';
$lang['label_amount'] = 'Amount';
$lang['label_comments'] = 'Comments';
$lang['label_received_on'] = 'Received On';
$lang['label_action'] = 'Action';
$lang['placeholder_select_product'] = 'Select product/service type...';
$lang['placeholder_title_optional'] = 'Please enter title for video or it will be taken automatically from youtube';
$lang['placeholder_title_common'] = 'Please enter a title for %s';
$lang['label_price'] = 'Price';
$lang['placeholder_price'] = 'Please enter a price for your %s';
$lang['label_image'] = 'Image';
$lang['label_optional'] = '(Optional)';
$lang['label_video'] = 'Video';
$lang['placeholder_video'] = 'Please enter full URL of youtube video';
$lang['label_from'] = 'From';
$lang['placeholder_from'] = 'Please enter a date when your classified starts';
$lang['label_to'] = 'To';
$lang['placeholder_to'] = 'Please enter a date when your classified ends';
$lang['placeholder_buy'] = 'Please enter buy link, if your classified is available via other website';
$lang['message_business_hours'] = 'Select days and time to set working hours';
$lang['label_day'] = 'Day';
$lang['label_monday'] = 'Monday';
$lang['label_tuesday'] = 'Tuesday';
$lang['label_wednesday'] = 'Wednesday';
$lang['label_thursday'] = 'Thursday';
$lang['label_friday'] = 'Friday';
$lang['label_saturday'] = 'Saturday';
$lang['label_sunday'] = 'Sunday';
$lang['label_select'] = 'Please Select';
$lang['label_select_category'] = 'Select Category';
$lang['placeholder_category'] = 'Select a category...';
$lang['label_select_subcategory'] = 'Select Subcategory';
$lang['placeholder_subcategory'] = 'Select a Subcategory...';
$lang['label_select_subsubcategory'] = 'Select Subsubcategory';
$lang['placeholder_subsubcategory'] = 'Select a Subsubcategory...';
$lang['label_select_country'] = 'Select Country';
$lang['placeholder_country'] = 'Select a country...';
$lang['label_select_state'] = 'Select State';
$lang['placeholder_state'] = 'Select a state...';
$lang['label_select_city'] = 'Select City';
$lang['placeholder_city'] = 'Select a city...';
$lang['label_select_locality'] = 'Select Locality';
$lang['placeholder_locality'] = 'Select a locality...';
$lang['label_pincode'] = 'Pincode';
$lang['label_location'] = 'Location';
$lang['label_latitude'] = 'Latitude';
$lang['label_longitude'] = 'Longitude';
$lang['placeholder_pincode'] = 'Please enter a valid pincode';
$lang['label_address'] = 'Address';
$lang['placeholder_address'] = 'Please enter your business address';
$lang['label_contact_person'] = 'Contact Person';
$lang['placeholder_contact_person'] = 'Please enter the name of contact person';
$lang['label_phone_number'] = 'Phone Number';
$lang['placeholder_phone_number'] = 'Please enter a valid phone number';
$lang['help_phone_number'] = '(e.g. 0180-4020101)';
$lang['label_mobile_number'] = 'Mobile Number';
$lang['placeholder_mobile_number'] = 'Please enter a valid mobile number';
$lang['help_mobile_number'] = '(e.g. 9999999999)';
$lang['message_mobile_valid'] = 'Valid Number';
$lang['message_mobile_invalid'] = 'Invalid Number';
$lang['label_tollfree'] = 'Tollfree';
$lang['placeholder_tollfree'] = 'Enter tollfree number if your business have any';
$lang['label_fax'] = 'Fax';
$lang['placeholder_fax'] = 'Enter fax number if your business have any';
$lang['label_email'] = 'Email';
$lang['label_website'] = 'Website';
$lang['label_facebook_url'] = 'Facebook URL';
$lang['placeholder_facebook_url'] = 'Please enter facebook URL';
$lang['label_twitter_url'] = 'Twitter URL';
$lang['placeholder_twitter_url'] = 'Please enter twitter URL';
$lang['label_googleplus_url'] = 'Google Plus URL';
$lang['placeholder_googleplus_url'] = 'Please enter google+ URL';
$lang['placeholder_website'] = 'Please enter your business website address if any';
$lang['label_description'] = 'Description';
$lang['placeholder_desc'] = 'Please enter a description for your %s';
$lang['label_keywords'] = 'Keywords';
$lang['placeholder_keywords'] = 'Please enter keywords for your business';
$lang['label_payment_gateway'] = 'Payment Gateways';
$lang['placeholder_payment_gateway'] = 'Select a payment gateway...';
$lang['error_video_not_found'] = 'YouTube video ID not found. Please double-check your URL.';
$lang['label_select_package'] = 'Select Package';
$lang['btn_buy_now'] = 'Buy Now!';
$lang['label_id_asc'] = 'ID - ASC';
$lang['label_id_desc'] = 'ID - DESC';
$lang['label_title_asc'] = 'TITLE - ASC';
$lang['label_title_desc'] = 'TITLE - DESC';
$lang['label_created_asc'] = 'CREATED_ON - ASC';
$lang['label_created_desc'] = 'CREATED_ON - DESC';
$lang['label_admin_search'] = 'Go!';
$lang['placeholder_admin_search'] = 'ID/Business Title/Email/Created Date';
// Business Query Form
$lang['label_subject'] = 'Subject';
$lang['placeholder_subject'] = 'Please enter subject for email';
// Invoice Template
$lang['transaction_successful'] = 'Payment has been received successfully, please visit invoice section for invoice';
$lang['transaction_cancelled'] = 'Your last transaction was unsuccessful, please try again';
$lang['invoice_title'] = 'Invoice';
$lang['invoice_order'] = 'Order # ';
$lang['invoice_billed_to'] = 'Billed To:';
$lang['invoice_shipped_to'] = 'Shipped To:';
$lang['invoice_payment_method'] = 'Payment Method:';
$lang['invoice_order_date'] = 'Order Date:';
$lang['invoice_order_summary'] = 'Order Summary:';
$lang['invoice_item'] = 'Item';
$lang['invoice_item_price'] = 'Price';
$lang['invoice_item_quantity'] = 'Quantity';
$lang['invoice_item_totals'] = 'Totals';
$lang['invoice_subtotal'] = 'Subtotal';
$lang['invoice_total'] = 'Total';
$lang['invoice_status'] = 'Status:';
$lang['invoice_message'] = 'For more information, please visit: ';

/**
 * *************************************************************************
 *
 * ADMIN AREA
 *
 * *************************************************************************
 */
// --------------------------------------------------------------------
// Module Name
// --------------------------------------------------------------------
$lang['label_transactions'] = 'Transaction(s)';
$lang['label_transaction'] = ' Transaction';
$lang['label_transaction_id'] = 'Transaction ID';
$lang['label_transaction_status'] = 'Transaction Status';
$lang['label_date'] = 'Date';
$lang['label_user'] = 'User';
$lang['tab_all'] = 'All';
$lang['label_ip_address'] = 'IP Address';
$lang['label_membership_package'] = 'Membership Package';
$lang['manage_transactions'] = 'Manage Transactions';
$lang['label_back_to'] = 'Back to ';
// Listing Module
$lang['label_featured'] = 'Featured';
$lang['label_verified'] = 'Verified';
$lang['us_tab_claimed'] = 'Claimed';
$lang['us_tab_unclaimed'] = 'Unclaimed';
$lang['label_expires_on'] = 'Expires On (Verified)';
// Tag Module
$lang['label_tags'] = 'Tags';
$lang['label_tag'] = 'Tag';
$lang['placeholder_tag_name'] = 'Please provide a keyword name';
$lang['us_tab_all_tags'] = 'All Tags';
$lang['us_tab_active'] = 'Active';
$lang['placeholder_admin_tag_search'] = 'ID/Name/Created';
// SMS Gateways Module
$lang['label_display_name'] = 'Display Name';
$lang['label_company_logo'] = 'Company Logo';
$lang['sms_gateways_list'] = 'All SMS Gateways';
$lang['manage_sms_gateways'] = 'Manage SMS Gateways';
$lang['label_api'] = 'API ';
$lang['label_secret'] = 'Secret';
$lang['label_username'] = 'Username';
$lang['label_password'] = 'Password';
$lang['label_key'] = 'Key';
$lang['label_nexmo'] = ' Nexmo';
$lang['label_sms_global'] = ' SMS Global';
// Payment Gateways Module
$lang['manage_payment_gateways'] = 'Manage Payment Gateways';
$lang['label_signature'] = 'Signature';
$lang['label_order'] = 'Order';
$lang['label_currency'] = 'Currency';
$lang['label_account_number'] = 'Account Number';
$lang['label_secret_word'] = 'Secret Word';
$lang['label_public_key'] = 'Public Key';
$lang['label_sandbox_mode'] = 'Use Sandbox Test Mode';
$lang['label_paypal'] = ' PayPal';
$lang['label_twocheckout'] = ' 2Checkout';
$lang['label_authorizenet'] = 'AuthorizeNet';
$lang['label_login_id'] = 'Login ID';
$lang['label_transaction_key'] = 'Transaction Key';
$lang['label_hash'] = 'MD5 Hash Secret';
$lang['hash_help'] = 'In case of SIM, <strong>MD5 Hash Secret</strong> is required';
$lang['payment_gateways_list'] = 'All Payment Gateways';
// Pages
$lang['manage_pages'] = 'Manage Pages';
$lang['order_pages'] = 'Order Pages';
$lang['order_pages_help'] = 'Drag to order pages and then click \'Save\'';
$lang['label_pages'] = 'Page(s)';
$lang['label_page'] = 'Page';
$lang['pages_list'] = 'All Pages';
$lang['label_body'] = 'Body';
$lang['label_meta_title'] = 'Meta Title';
$lang['label_meta_keywords'] = 'Meta Keywords';
$lang['label_meta_description'] = 'Meta Description';
$lang['label_header'] = 'Header';
$lang['label_footer'] = 'Footer';
$lang['label_both'] = 'Both';
$lang['label_parent_id'] = 'Parent ID';
$lang['label_parent_name'] = 'Parent';
// Packages
$lang['manage_packages'] = 'Manage Packages';
$lang['label_packages'] = 'Package(s)';
$lang['packages_list'] = 'All Packages';
$lang['label_plan_type'] = 'Plan Type';
$lang['label_subscription'] = 'Subscription';
$lang['label_duration'] = 'Duration';
$lang['label_default'] = 'Default';
$lang['label_validity'] = 'Validity';
$lang['label_lifetime'] = 'Lifetime';
$lang['label_days'] = 'Days';
$lang['label_free'] = 'Free';
$lang['label_upgrade'] = 'Upgrade';
$lang['label_onetime'] = 'One Time';
$lang['label_google_map'] = 'Google Map';
$lang['label_logo'] = 'Logo';
$lang['label_set_default'] = 'Set Default';
$lang['label_listings_limit'] = 'Listings Limit';
$lang['label_keywords_limit'] = 'Keywords Limit';
$lang['label_keywords_length'] = 'Keywords Length';
$lang['label_description_length'] = 'Description Length';
$lang['label_images_limit'] = 'Images Limit';
$lang['label_videos_limit'] = 'Videos Limit';
$lang['label_products_limit'] = 'Products or Services Limit';
$lang['label_classifieds_limit'] = 'Classifieds Limit';
$lang['label_info_limit'] = 'Info Limit';
$lang['label_basic_info'] = 'Basic Information';
$lang['label_display_options'] = 'Set Display Options';
$lang['label_limit_listings'] = 'Limit Listings';
$lang['label_packages_layout'] = 'Set Featured Layout';
$lang['label_color_scheme'] = 'Color Scheme';
$lang['label_border_color'] = 'Border Color';
$lang['tab_basic_settings'] = 'Basic Settings';
$lang['tab_limit'] = 'Set Limit';
$lang['tab_display_options'] = 'Display Options';
$lang['tab_auto_approve_options'] = 'Auto Approve';
$lang['auto_approve_options'] = 'Auto Approve Options';
$lang['tab_layout_options'] = 'Layout';
// Migrations (Import/Export)
$lang['label_importer'] = 'Importer';
$lang['label_exporter'] = 'Exporter';
$lang['label_import'] = 'Import';
$lang['label_export'] = 'Export';
$lang['label_data_imported'] = 'Data Imported';
$lang['label_data_exported'] = 'Data Exported';
$lang['label_import_list'] = 'All Imports';
$lang['label_import_new'] = 'Import Data';
$lang['label_export_list'] = 'All Exports';
$lang['label_export_new'] = 'Export Data';
$lang['option_import_type'] = '-- Select Import Type --';
$lang['option_export_type'] = '-- Select Export Type --';
$lang['option_file_type'] = '-- Select File Type --';
$lang['label_file_type'] = 'File Type';
$lang['label_performed_on'] = 'Performed On';
$lang['label_file'] = 'File';
$lang['label_csv'] = 'CSV';
$lang['label_excel_97_2003'] = 'Excel 97-2003';
$lang['label_excel_2007'] = 'Excel 2007';
$lang['migrate_success'] = 'Success';
$lang['migrate_failure'] = 'Failed';
$lang['error_wrong_file'] = 'Uploaded file extension is different from %s';
$lang['upload_failure'] = 'Upload failed because ';
$lang['label_fields_separator'] = 'Fields Separator';
$lang['placeholder_fields_separator'] = 'Comma(,) is the default value. If you are using other separator, please enter it here';
$lang['label_lines_separator'] = 'Lines Separator';
$lang['placeholder_lines_separator'] = '\\n is the default value for new line. If you are using other separator, please enter it here';
$lang['label_enclosed_by'] = 'Enclosed By';
$lang['placeholder_enclosed_by'] = 'In case of double quotes (") use \\". Leave blank for default.';
$lang['label_start_id'] = 'Start ID';
$lang['placeholder_start_id'] = 'Enter an integer value for the row where to start exporting';
$lang['label_end_id'] = 'End ID';
$lang['placeholder_end_id'] = 'Enter an integer value for the row where to end exporting';
$lang['label_compress_file'] = 'Compress File';
$lang['placeholder_archieve'] = 'Please check, if you want to create a zip archieve';
$lang['label_insert_only'] = 'Insert Only';
$lang['label_insert_update'] = 'Insert and Update';
$lang['label_db_transaction'] = 'Transaction Type';
$lang['use_id_for_update'] = 'Update information based on ID. (Work with Insert and Update Only)';
$lang['id_update_warning'] = 'Note: Please use checkbox only if CSV file has ID column with values or it will overwrite existing records';
$lang['label_offset_value'] = 'Start Row';
$lang['label_limit_rows'] = 'Total Rows';
$lang['placeholder_offset_value'] = 'Skip number of rows';
$lang['placeholder_limit_rows'] = 'Total number of rows to export (e.g. 2000 rows)';
$lang['placeholder_optional_fields'] = 'Optional Fields (For bulk export limit)';
$lang['label_or_file_name'] = '<strong>OR</strong> Specify File Name';
$lang['help_file_path'] = 'File must be placed inside of <strong>%s</strong> folder';
// Locations Module
$lang['label_countries'] = 'Countries';
$lang['label_country'] = 'Country';
$lang['label_states'] = 'States';
$lang['label_state'] = 'State';
$lang['label_cities'] = 'Cities';
$lang['label_city'] = 'City';
$lang['label_localities'] = 'Localities';
$lang['label_locality'] = 'Locality';
$lang['label_all_countries'] = 'All Countries';
$lang['label_all_states'] = 'All States';
$lang['label_all_cities'] = 'All Cities';
$lang['label_all_localities'] = 'All Localities';
$lang['manage_countries'] = 'Manage Countries';
$lang['label_manage_states'] = 'Manage States';
$lang['label_manage_cities'] = 'Manage Cities';
$lang['label_manage_localities'] = 'Manage Localities';
$lang['back_to_countries'] = 'Back to Countries';
$lang['back_to_states'] = 'Back to States';
$lang['back_to_cities'] = 'Back to Cities';
$lang['back_to_localities'] = 'Back to Localities';
$lang['label_country_new'] = 'Add New Country';
$lang['label_country_edit'] = 'Edit Country';
$lang['label_state_new'] = 'Add New State';
$lang['label_state_edit'] = 'Edit State';
$lang['label_city_new'] = 'Add New City';
$lang['label_city_edit'] = 'Edit City';
$lang['label_locality_new'] = 'Add New Locality';
$lang['label_locality_edit'] = 'Edit Locality';
$lang['filter_first_letter'] = 'Filter by letter: ';
$lang['selection_failure'] = 'Please Select Country First';
$lang['label_iso'] = 'ISO';
$lang['label_iso_3'] = 'ISO 3';
$lang['label_printable_name'] = 'Printable Name';
$lang['label_numcode'] = 'Numcode';
$lang['label_code'] = 'Code';
$lang['placeholder_code'] = 'Please enter %s code';
$lang['placeholder_location_name'] = 'Please enter %s name';
$lang['label_view'] = 'View';
// Email Templates
$lang['manage_email_templates'] = 'Manage Email Templates';
$lang['all_email_templates'] = 'All Email Templates';
$lang['label_email_template'] = 'Email Template';
// Currencies
$lang['manage_currencies'] = 'Manage Currencies';
$lang['label_currency'] = 'Currency';
$lang['label_symbol'] = 'Symbol';
$lang['placeholder_currency_code'] = 'Code';
$lang['placeholder_currency_name'] = 'Please enter currency name (optional)';
$lang['placeholder_symbol'] = 'Symbol';
$lang['all_currencies'] = 'All Currencies';
// Comments
$lang['placeholder_admin_comment_search'] = 'ID/Listing/User/Posted';
// Filter
$lang['label_comment'] = 'Comment';
$lang['comments_list'] = 'All Comments';
$lang['comments_tab_all'] = 'All Comments';
$lang['comments_tab_active'] = 'Approved';
$lang['comments_tab_inactive'] = 'Waiting for Approval';
$lang['comments_tab_flagged'] = 'Flagged';
$lang['comments_tab_spammed'] = 'Spammed';
$lang['comments_tab_rejected'] = 'Rejected';
$lang['comments_tab_deleted'] = 'Deleted';
$lang['comments_active'] = 'Approved';
$lang['comments_inactive'] = 'Pending';
$lang['comments_flag'] = 'Flagged';
$lang['comments_spam'] = 'Spammed';
$lang['comments_reject'] = 'Rejected';
$lang['comments_action_restore'] = 'Restore';
$lang['comments_action_purge'] = 'Purge';
$lang['comments_action_activate'] = 'Approve';
$lang['comments_purge_del_confirm'] = 'Are you sure you want to completely remove the comment(s) - there is no going back?';
$lang['comments_action_activate'] = 'Approve';
$lang['comments_action_deactivate'] = 'Disapprove';
$lang['comments_action_flag'] = 'Flag';
$lang['comments_action_spam'] = 'Mark as Spam';
$lang['comments_action_reject'] = 'Reject';
$lang['comments_delete_account_confirm'] = 'Are you sure you want to delete the comment(s)?';
$lang['comments_restored_success'] = 'Comment(s) restored successfully';
$lang['comments_restored_error'] = 'Unable to restore comment(s)';
$lang['comments_status_success'] = 'Comment(s) status changed successfully';
$lang['comments_status_error'] = 'Unable to change comment(s) status';
$lang['comments_action_purged'] = 'Comment(s) deleted permanently';
// Claim/Report Module
$lang['manage_claim_reports'] = 'Manage Claim Reports';
$lang['label_reported_on'] = 'Reported On';
$lang['all_claims'] = 'All Claims';
$lang['label_claim_incorrect'] = 'Claim/Incorrect';
// Categories Module
$lang['manage_categories'] = 'Manage Categories';
$lang['manage_subcategories'] = 'Manage Subcategories';
$lang['label_category'] = 'Category';
$lang['label_categories'] = 'Categories';
$lang['label_subcategories'] = 'Subcategories';
$lang['all_parent_categories'] = 'All Parent Categories';
$lang['order_categories'] = 'Order Categories';
$lang['order_categories_help'] = 'Drag to order categories and then click \'Save\'';
$lang['label_select_parent'] = '-- Select Parent Category --';
$lang['message_count_success'] = 'Counts have been updated successfully';
$lang['label_update_counts'] = 'Update Listings Count';
$lang['label_counts'] = 'Total Listings';
$lang['placeholder_admin_category_search'] = 'ID/Name';
// Banners Module
$lang['manage_banner_types'] = 'Manage Banner Types';
$lang['manage_banners'] = 'Manage Banners';
$lang['all_banner_types'] = 'All Banner Types';
$lang['label_banner_type'] = 'Banner Type';
$lang['label_banner_types'] = 'Banner Types';
$lang['all_banners'] = 'All Banners';
$lang['label_banners'] = 'Banners';
$lang['label_banner'] = 'Banner';
$lang['label_html'] = 'HTML';
$lang['label_text'] = 'Text';
$lang['label_filesize'] = 'Filesize';
$lang['label_width'] = 'Width';
$lang['label_height'] = 'Height';
$lang['label_top'] = 'Top';
$lang['label_left'] = 'Left';
$lang['label_right'] = 'Right';
$lang['label_middle'] = 'Middle';
$lang['label_bottom'] = 'Bottom';
$lang['label_front_slider'] = 'Front Slider';
$lang['label_url'] = 'URL';
$lang['label_target'] = 'Target';
$lang['label_start_date'] = 'Start Date';
$lang['label_end_date'] = 'End Date';
$lang['label_max_impressions'] = 'Maximum Impressions';
$lang['label_max_clicks'] = 'Maximum Clicks';
$lang['label_slider_heading'] = 'Slider Heading';
$lang['label_text_html'] = 'Text/HTML';
$lang['label_locations'] = 'Locations';
$lang['label_all_pages'] = 'Display on all pages';
$lang['label_select_all'] = 'Select All';
$lang['label_deselect_all'] = 'Deselect All';
$lang['label_toggle_select'] = 'Toggle Select';
$lang['option_new_window'] = 'New Window';
$lang['option_same_window'] = 'Same Window';
$lang['option_top_window'] = 'Top Window';
$lang['option_parent_window'] = 'Parent Window';
$lang['label_impressions'] = 'Impressions';
$lang['label_clicks'] = 'Clicks';
// Click To Call Module
$lang['manage_click_to_call'] = 'Manage Click to Call';
$lang['click_to_call_list'] = 'List';
$lang['label_device'] = 'Device';
$lang['click_to_call_tab_all'] = 'All Calls';
$lang['click_to_call_tab_desktop'] = 'Desktop';
$lang['click_to_call_tab_mobile_only'] = 'Mobile Devices Only';
$lang['click_to_call_tab_ipad'] = 'iPad';
$lang['click_to_call_tab_iphone'] = 'iPhone';
$lang['click_to_call_tab_android'] = 'Android';
$lang['click_to_call_tab_blackberry'] = 'BlackBerry';
$lang['click_to_call_tab_webos'] = 'WebOS';
// Users Module
$lang['label_manage'] = 'Manage';
// Contact Queries
$lang['label_contact_queries'] = 'Contact Queries';
$lang['contact_queries_list'] = 'All Contact Queries';
// TOOLS
// Random Ratings
$lang['manage_random_ratings'] = 'Manage Random Ratings';
$lang['label_average_rating'] = 'Average Rating';
$lang['label_total_users'] = 'Total User(s)';
$lang['label_listing_ids'] = 'Listing ID(s)';
$lang['label_value_between'] = 'Between';
$lang['label_value_and'] = 'and';
$lang['label_difference_warning'] = 'The difference should not exceed 50000';
$lang['msg_insert_success'] = 'Operation completed successfully, all listings have already been rated';
$lang['msg_success'] = 'Operation completed successfully';
// --------------------------------------------------------------------
// Summary Page
// --------------------------------------------------------------------
$lang['summary_manage'] = 'Manage Summary';

// Listings
$lang['us_filter_listings_letter'] = 'Listings starts with: ';
$lang['us_tab_all_listings'] = 'All Listings';
$lang['us_tab_spammed'] = 'Spammed';
$lang['us_tab_having'] = 'Having';
$lang['listings'] = 'Listings';
$lang['total_listings'] = 'Total Listings';
$lang['inactive_listings'] = 'Inactive Listings';
$lang['listings_deleted'] = 'Deleted Listings';
$lang['listings_spammed'] = 'Spammed Listings';
$lang['listings_with_products'] = 'Listings with Products or Services';
$lang['listings_with_photos'] = 'Listings with Photos';
$lang['listings_with_videos'] = 'Listings with Videos';
$lang['listings_with_classifieds'] = 'Listings with Classifieds';
$lang['listings_with_business_hours'] = 'Listings with Business Hours';

// Others
$lang['others'] = 'Others';
$lang['categories'] = 'Categories';
$lang['locations'] = 'Locations';
$lang['emails_in_queue'] = 'Emails in Queue';

// Products or services
$lang['products_services'] = 'Products or Services';
$lang['total_products_services'] = 'Total Products or Services';
$lang['inactive_products_services'] = 'Inactive Products or Services';

// Images
$lang['images'] = 'Images';
$lang['total_images'] = 'Total Images';
$lang['inactive_images'] = 'Inactive Images';

// Videos
$lang['videos'] = 'Videos';
$lang['total_videos'] = 'Total Videos';
$lang['inactive_videos'] = 'Inactive Videos';

// Classifieds
$lang['classifieds'] = 'Classifieds';
$lang['total_classifieds'] = 'Total Classifieds';
$lang['inactive_classifieds'] = 'Inactive Classifieds';

// Users
$lang['users'] = 'Users Information';
$lang['total_users'] = 'Total Users';
$lang['inactive_users'] = 'Inactive Users';
$lang['banned_users'] = 'Banned Users';

// Comments
$lang['comments'] = 'Comments';
$lang['all_comments'] = 'Total Comments';
$lang['pending_comments'] = 'Pending';

// Financial
$lang['financial'] = 'Financial';
$lang['all_transactions'] = 'Total Transactions';
$lang['paid_transactions'] = 'Paid';
$lang['cancelled_transactions'] = 'Cancelled';

// Keywords
$lang['keywords'] = 'Keywords';
$lang['total_keywords'] = 'Total Keywords';
$lang['inactive_keywords'] = 'Inactive Keywords';
$lang['msg_payment_processing_error'] = 'Sorry, there was an error processing your payment. Please try again later.';

// mbb Update
$lang['version_help'] = '%s! %s is available:';
$lang['msg_update_help'] = 'Please read instructions carefully at %s before upgrade';
$lang['how_to_upgrade'] = 'How to Upgrade';
$lang['btn_update_now'] = 'Update Now';

// Menus
$lang['gc_menu_banners'] = 'Banners';
$lang['gc_desc_banners'] = 'Manage Banners';
$lang['gc_menu_categories'] = 'Categories';
$lang['gc_desc_categories'] = 'Manage Categories';
$lang['gc_menu_claim_reports'] = 'Claim Reports';
$lang['gc_desc_claim_reports'] = 'Display Claim Reports';
$lang['gc_menu_comments'] = 'Comments';
$lang['gc_desc_comments'] = 'Manage Comments';
$lang['gc_menu_contact_queries'] = 'Contact Queries';
$lang['gc_desc_contact_queries'] = 'Display all user queries';
$lang['gc_menu_cron_jobs'] = 'Cron Jobs';
$lang['gc_desc_cron_jobs'] = 'Manage Cron Jobs';
$lang['gc_menu_currencies'] = 'Currencies';
$lang['gc_desc_currencies'] = 'Manage Currencies';
$lang['gc_menu_email_templates'] = 'Email Templates';
$lang['gc_desc_email_templates'] = 'Manage Email Templates';
$lang['gc_menu_email_queue'] = 'Email Queue';
$lang['gc_desc_email_queue'] = 'Queues emails to be sent in bursts throughout the day.';
$lang['gc_menu_email_settings'] = 'Email Settings';
$lang['gc_menu_email_template'] = 'Template';
$lang['gc_menu_listings'] = 'Listings';
$lang['gc_desc_listings'] = 'Manage Business Listings';
$lang['gc_menu_locations'] = 'Locations';
$lang['gc_desc_locations'] = 'Manage Countries, States, Cities and Localities';
$lang['gc_menu_logs'] = 'Logs';
$lang['gc_desc_logs'] = 'Allows viewing of log files and adjusting log level.';
$lang['gc_menu_members'] = 'Members';
$lang['gc_desc_members'] = 'Members Area';
$lang['gc_menu_packages'] = 'Packages';
$lang['gc_desc_packages'] = 'Manage Packages';
$lang['gc_menu_pages'] = 'Pages';
$lang['gc_desc_pages'] = 'Manage Pages';
$lang['gc_menu_payment_gateways'] = 'Payment Gateways';
$lang['gc_desc_payment_gateways'] = 'Manage Payment Gateways';
$lang['gc_menu_roles'] = 'Roles';
$lang['gc_desc_roles'] = 'Provides Role-Based Access Control for users.';
$lang['gc_menu_summary'] = 'Summary';
$lang['gc_desc_summary'] = 'Brief Information';
$lang['gc_menu_tags'] = 'Tags';
$lang['gc_desc_tags'] = 'Manage Tags';
$lang['gc_menu_transactions'] = 'Transactions';
$lang['gc_desc_transactions'] = 'Manage Transactions';
$lang['gc_menu_users'] = 'Users';
$lang['gc_desc_users'] = 'Allows users to exist in.';
$lang['gc_menu_translate'] = 'Translate';
$lang['gc_desc_translate'] = 'Allows users to create translations for any language.';
$lang['gc_menu_sysinfo'] = 'System Information';
$lang['gc_desc_sysinfo'] = 'Allows users to create translations for any language.';
$lang['gc_menu_ui'] = 'Keyboard Shortcuts';
$lang['gc_desc_ui'] = 'Provides helpers for consistent admin UI features.';
$lang['gc_menu_permissions'] = 'Permissions';
$lang['gc_desc_permissions'] = 'Manages the Permissions available to the Roles.';
$lang['gc_menu_activities'] = 'Activities';
$lang['gc_desc_activities'] = 'Allows other modules to store user activity information.';
$lang['gc_menu_settings'] = 'Settings';
$lang['gc_desc_settings'] = 'Allows Admin to change settings.';
$lang['gc_menu_user_manual'] = 'User Manual';
$lang['gc_desc_manual'] = 'Allows Admin to access mbb online user manual.';
