<?php
$num_columns	= 24;
$can_delete	= $this->auth->restrict();;
$can_edit		= $this->auth->restrict();;
$has_records	= isset($records) && is_array($records) && count($records);

?>
<?php echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING']); ?>

<table class="responsive-table bordered">
	<thead>
		<tr>
		<?php if ($can_delete && $has_records) : ?>
			<th class="column-check"><input class="check-all" type="checkbox" />
			</th>
			<?php endif;?>
			<th width="5%"><?php echo lang('label_id');?></th>
			<th width="63%"><?php echo lang('label_business_title');?></th>
			<th width="10%"><?php echo lang('label_email');?></th>
			<th width="10%"><?php echo lang('column_created');?></th>
			<th width="4%"><?php echo lang('label_number_of_hits');?></th>
			<th width="8%"><?php echo lang('label_status');?></th>
		</tr>
	</thead>
	<?php if ($has_records) : ?>
		<tfoot>
		<?php if ($can_delete) : ?>
			<tr>
				<td colspan="<?php echo $num_columns; ?>"><?php echo lang('bf_with_selected'); ?>
					<input type="submit" name="delete" id="delete-me"
					class="btn btn-danger"
					value="<?php echo lang('bf_action_delete'); ?>"
					onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>')" />
				</td>
			</tr>
			<?php endif; ?>
		</tfoot>
		<?php endif; ?>
	<tbody>
		<?php
		if ($has_records) :
		foreach ($records as $record) :
		?>
			<tr>
			<?php if ($can_delete) : ?>
				<td class="column-check"><input type="checkbox" name="checked[]"
					value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
				<td><?php e($record->id); ?></td>
				<?php if ($can_edit) : //urlencode(base64_encode($record->id))?>
				<td><?php echo anchor('members/edit_business?id=' . $this->encrypt->encode($record->id), '<span class="icon-pencil"></span>' .  $record->title); ?>
					<div class="hover-item small">
					<?php echo lang('ls_action'); ?>
						:: <a
							href="<?php echo site_url('members/logo?id=' . $this->encrypt->encode($record->id)); ?>"
							title="Logo"><?php echo lang('listings_action_logo'); ?> </a> | <a
							href="<?php echo site_url('members/products?id=' . $this->encrypt->encode($record->id)); ?>"
							title="Product or Service"><?php echo lang('listings_action_product_service'); ?>
						</a> | <a
							href="<?php echo site_url('members/photos/'.$record->id.'/?id=' . $this->encrypt->encode($record->id)); ?>"
							title="Photos"><?php echo lang('listings_action_photos'); ?> </a>
						| <a
							href="<?php echo site_url('members/videos?id=' . $this->encrypt->encode($record->id)); ?>"
							title="Videos"><?php echo lang('listings_action_videos'); ?> </a>
						| <a
							href="<?php echo site_url('members/classifieds?id=' . $this->encrypt->encode($record->id)); ?>"
							title="Classifieds"><?php echo lang('listings_action_classifieds'); ?>
						</a> | <a
							href="<?php echo site_url('members/business_hours?id=' . $this->encrypt->encode($record->id)); ?>"
							title="Business Hours"><?php echo lang('listings_action_working_hours'); ?>
						</a>
					</div></td>
					<?php else : ?>
				<td><?php e($record->title); ?></td>
				<?php endif; ?>
				<td><?php echo $record->email ? mailto($record->email) : ''; ?></td>
				<td><?php e($record->created_on) ?></td>
				<td><?php e($record->hits) ?></td>
				<td class='status'><?php if ($record->active) : ?> <span
					class="label label-success"><?php echo lang('us_active'); ?> </span>
					<?php else : ?> <span class="label label-warning"><?php echo lang('us_inactive'); ?>
				</span> <?php endif; ?>
				</td>
			</tr>
			<?php
			endforeach;
			else:
			?>
			<tr>
				<td colspan="<?php echo $num_columns; ?>"><?php echo lang('error_no_record_found');?>
				</td>
			</tr>
			<?php endif; ?>
	</tbody>
</table>
<?php echo form_close(); ?>
<div class="row">
	<div class="col-sm-12 centered-text">
	<?php echo $this->pagination->create_links(); ?>
	</div>
	<!-- end of pagination column -->
</div>
<!-- end of pagination row -->
