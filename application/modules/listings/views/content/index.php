<?php 
 
 
 
 
 
 
 
 
 
 
 
 

?>
<style>
th.id { width: 3em; }
th.last-login { width: 11em; }
th.status { width: 10em; }
</style>
<div class="well shallow-well">
	<span class="filter-link-list">
		<?php
		// If there's a current filter, we need to replace the caption with a clear button
		if ($filter_type == 'first_letter') :
			echo anchor($index_url, lang('bf_clear'), array('class' => 'btn btn-small btn-primary'));
		else :
			e(lang('us_filter_listings_letter'));
		endif;

		$letters = range('A', 'Z');
		foreach ($letters as $letter) :
			echo anchor($index_url . 'first_letter-' . $letter, $letter) . PHP_EOL;
		endforeach;
		?>
	</span>
</div>
<ul class="nav nav-tabs" >
	<li<?php echo $filter_type == 'all' ? ' class="active"' : ''; ?>><?php echo anchor($index_url, lang('us_tab_all_listings')); ?></li>
	<li<?php echo $filter_type == 'claimed' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'claimed/', lang('us_tab_claimed')); ?></li>
	<li<?php echo $filter_type == 'unclaimed' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'unclaimed/', lang('us_tab_unclaimed')); ?></li>
	<li<?php echo $filter_type == 'inactive' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'inactive/', lang('us_tab_inactive')); ?></li>
	<li<?php echo $filter_type == 'spammed' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'spammed/', lang('us_tab_spammed')); ?></li>
	<li<?php echo $filter_type == 'deleted' ? ' class="active"' : ''; ?>><?php echo anchor($index_url . 'deleted/', lang('us_tab_deleted')); ?></li>
	<li class="<?php //DEALING WITH ACTIVE LINKS IN HAVING
					switch ($filter_type) {
						case 'logo':
							echo $filter_type == 'logo' ? 'active ' : ''; 
						break;
						case 'product':
							echo $filter_type == 'product' ? 'active ' : '';
						break;
						case 'photos':
							echo $filter_type == 'photos' ? 'active ' : '';
						break;
						case 'videos':
							echo $filter_type == 'videos' ? 'active ' : '';
						break;
						case 'classifieds':
							echo $filter_type == 'classifieds' ? 'active ' : '';
						break;
						case 'business_hours':
							echo $filter_type == 'business_hours' ? 'active ' : '';
						break;
						default:
							echo $filter_type == NULL ? 'active ' : '';
		}		
		?>dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php
			echo lang('us_tab_having');
			echo isset($filter_having) ? ": $filter_having" : '';
			?>
			<span class="caret light-caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li><?php echo anchor($index_url . 'logo/', 'Logo'); ?></li>
			<li><?php echo anchor($index_url . 'product/', 'Product or Service'); ?></li>
			<li><?php echo anchor($index_url . 'photos/', 'Photos'); ?></li>
			<li><?php echo anchor($index_url . 'videos/', 'Videos'); ?></li>
			<li><?php echo anchor($index_url . 'classifieds/', 'Classifieds'); ?></li>
			<li><?php echo anchor($index_url . 'business_hours/', 'Business Hours'); ?></li>
		</ul>
	</li>
	<li class="<?php echo $filter_type == 'role_id' ? 'active ' : ''; ?>dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php
			echo lang('us_tab_roles');
			echo isset($filter_role) ? ": $filter_role" : '';
			?>
			<span class="caret light-caret"></span>
		</a>
		<ul class="dropdown-menu">
			<?php foreach ($roles as $role) : ?>
			<li><?php echo anchor($index_url . 'role_id-' . $role->role_id, $role->role_name); ?></li>
			<?php endforeach; ?>
		</ul>
	</li>
</ul>
<?php

$num_columns	= 24;
$can_delete	= $this->auth->has_permission('Listings.Content.Delete');
$can_edit		= $this->auth->has_permission('Listings.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'id="listing_form"'); ?><br />
		<div class="input-append pull-left">
		<input type="hidden" name="order_by" id="order_by" />
		    <div class="btn-group">
			    <button class="btn btn-small"><?php echo strtoupper(str_replace(' ', ' - ', $this->session->userdata('listings_order_by'))); ?></button>
			    	<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
			    		<span class="caret"></span>
			    	</button>
			    	<ul class="dropdown-menu">
				    	<li <?php echo strcmp($this->session->userdata('listings_order_by'), "id asc") == 0 ? 'class="active"' :'';?> data-id="id_asc"><a role="button" tabindex="0"><?php echo lang('label_id_asc');?></a></li>
				    	<li <?php echo strcmp($this->session->userdata('listings_order_by'), "id desc") == 0 ? 'class="active"' :'';?> data-id="id_desc"><a role="button" tabindex="0"><?php echo lang('label_id_desc');?></a></li>
				    	<li <?php echo strcmp($this->session->userdata('listings_order_by'), "title asc") == 0 ? 'class="active"' :'';?> data-id="title_asc"><a role="button" tabindex="0"><?php echo lang('label_title_asc');?></a></li>
				    	<li <?php echo strcmp($this->session->userdata('listings_order_by'), "title desc") == 0 ? 'class="active"' :'';?> data-id="title_desc"><a role="button" tabindex="0"><?php echo lang('label_title_desc');?></a></li>
						<li <?php echo strcmp($this->session->userdata('listings_order_by'), "created_on asc") == 0 ? 'class="active"' :'';?> data-id="created_asc"><a role="button" tabindex="0"><?php echo lang('label_created_asc');?></a></li>
						<li <?php echo strcmp($this->session->userdata('listings_order_by'), "created_on desc") == 0 ? 'class="active"' :'';?> data-id="created_desc"><a role="button" tabindex="0"><?php echo lang('label_created_desc');?></a></li>
			    	</ul>
		    </div>
		</div>		
	 	<div class="input-append pull-right">
	    	<input class="span3" id="search" type="text" name="search" placeholder="<?php echo lang('placeholder_admin_search');?>" value="<?php echo set_value('search', isset($_POST['search']) ? $_POST['search'] : ''); ?>" />
	    	<button class="btn" type="submit"><?php echo lang('label_admin_search');?></button>
	    </div>
		<table class="table table-striped table-bordered" id="flex_table_">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>					
					<th><?php echo lang('label_id');?></th>
					<th><?php echo lang('label_business_title');?></th>
					<th><?php echo lang('label_email');?></th>
					<th><?php echo lang('label_number_of_hits');?></th>
					<th><?php echo lang("column_created"); ?></th>
					<th><?php echo lang('label_status');?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php
						echo lang('bf_with_selected');
	
						if ($filter_type == 'deleted') :
						?>
						<input type="submit" name="restore" class="btn" value="<?php echo lang('bf_action_restore'); ?>" />
						<input type="submit" name="purge" class="btn btn-danger" value="<?php echo lang('bf_action_purge'); ?>" onclick="return confirm('<?php e(js_escape(lang('purge_del_confirm'))); ?>')" />
						<?php else : ?>
						<input type="submit" name="activate" class="btn" value="<?php echo lang('bf_action_activate'); ?>" />
						<input type="submit" name="deactivate" class="btn" value="<?php echo lang('bf_action_deactivate'); ?>" />						
						<?php if ($filter_type == 'spammed'): ?>
						<input type="submit" name="unspam" class="btn" value="<?php echo lang('bf_action_unspam'); ?>" />
						<?php else:?>
						<input type="submit" name="spam" class="btn" value="<?php echo lang('bf_action_spam'); ?>" />
						<?php endif;?>
						<input type="submit" name="delete" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('delete_account_confirm'))); ?>')" />
						<?php endif;?>
					</td>
				</tr>
			</tfoot>
			<?php endif; ?>			
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record['id']; ?>" /></td>
					<?php endif;?>
				<td><?php e($record['id']); ?></td> 
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/content/listings/edit/' . $record['id'], '<span class="icon-pencil"></span>' .  $record['title']); ?>
					<div class="hover-item small">
							<?php echo lang('ls_action'); ?> ::
							<a href="<?php echo site_url(SITE_AREA . '/content/listings/logo/' .  $record['id']); ?>" title="Logo"><?php echo lang('listings_action_logo'); ?></a> |
							<a href="<?php echo site_url(SITE_AREA . '/content/listings/products/' . $record['id']); ?>" title="Product or Service"><?php echo lang('listings_action_product_service'); ?><?php if ($record['inactive_products'] != 0) { echo '<sup><span class="badge badge-danger">'.$record['inactive_products'].'</span></sup>'; }?></a> |
							<a href="<?php echo site_url(SITE_AREA . '/content/listings/photos/' . $record['id']); ?>" title="Photos"><?php echo lang('listings_action_photos'); ?><?php if ($record['inactive_images'] != 0) { echo '<sup><span class="badge badge-danger">'.$record['inactive_images'].'</span></sup>'; }?></a> |
							<a href="<?php echo site_url(SITE_AREA . '/content/listings/videos/' . $record['id']); ?>" title="Videos"><?php echo lang('listings_action_videos'); ?><?php if ($record['inactive_videos'] != 0) { echo '<sup><span class="badge badge-danger">'.$record['inactive_videos'].'</span></sup>'; }?></a> |
							<a href="<?php echo site_url(SITE_AREA . '/content/listings/classifieds/' . $record['id']); ?>" title="Classifieds"><?php echo lang('listings_action_classifieds'); ?><?php if ($record['inactive_classifieds'] != 0) { echo '<sup><span class="badge badge-danger">'.$record['inactive_classifieds'].'</span></sup>'; }?></a> |
							<a href="<?php echo site_url(SITE_AREA . '/content/listings/business_hours/' . $record['id']); ?>" title="Business Hours"><?php echo lang('listings_action_working_hours'); ?></a>
					</div></td>
				<?php else : ?>
					<td><?php e($record['title']); ?></td>
				<?php endif; ?>
					<td><?php echo $record['email'] ? mailto($record['email']) : ''; ?></td>
					<td><?php e($record['hits']) ?></td>
					<td><?php e($record['created_on']) ?></td>
					<td class='status'>
					<?php if ($record['active']) : ?>
					<span class="label label-success"><?php echo lang('us_active'); ?></span>
					<?php else : ?>
					<span class="label label-warning"><?php echo lang('us_inactive'); ?></span>
					<?php endif; ?>
				</td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>"><?php echo lang('error_no_record_found');?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); 
	echo $this->pagination->create_links();
	?>
</div>