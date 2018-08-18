<?php

$num_columns	= 7;
$can_delete	= $this->auth->restrict();
$can_edit		= $this->auth->restrict();
$has_records	= isset($records) && is_array($records) && count($records);

?>
	
	<?php echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING']); ?>
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th width="5%"><?php echo lang('invoice_title');?></th>
				<th width="10%"><?php echo lang('label_package');?></th>
				<th width="10%"><?php echo lang('label_listing');?></th>
				<th width="4%"><?php echo lang('label_amount');?></th>
				<th width="26%"><?php echo lang('label_comments');?></th>
				<th width="20%"><?php echo lang('label_received_on');?></th>
				<th width="8%"><?php echo lang('label_status')?></th>
				<th width="15%"></th>
			</tr>
		</thead>
			<?php if ($has_records) : ?>
			<tfoot>
		</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
				<td><?php e($record->invoice); ?></td>
				<td><?php e($record->package_title) ?></td>
				<td><?php e($record->listing_title) ?></td>
				<td><?php e($record->amount) ?></td>
				<td><?php e($record->comments) ?></td>
				<td><?php e($record->received_on) ?></td>
				<td class='status' style="text-align: center">
						<?php switch ($record->status) { 
							case 0: 
								echo '<span class="label label-default">' . lang('pending') . '</span>'; 
								break;
							case 1:
								echo '<span class="label label-success">' . lang('paid') . '</span>';
								break;
							case 2:
								echo '<span class="label label-warning">' . lang('cancelled') . '</span>';
								break;
						} ?>
					</td>
				<td style="text-align: center">
				<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button"
							id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
							<?php echo lang('label_action');?><span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu" style="min-width: 90px"
							aria-labelledby="dropdownMenu1">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('members/view_invoice/' . $record->id);?>">View</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('members/download_invoice/' . $record->id);?>">Download</a></li>
						</ul>
					</div>
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
</div>
<?php echo form_close(); ?>
<div class="row">
	<div class="col-sm-12 centered-text">
				<?php echo $this->pagination->create_links(); ?>
			</div>
	<!-- end of pagination column -->
</div>
<!-- end of pagination row -->
