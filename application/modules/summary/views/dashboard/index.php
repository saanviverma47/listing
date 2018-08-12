<?php
 
 
 
 
 
 
 
 
 
 
 
 

$num_columns = 2;
$can_delete = $this->auth->has_permission ( 'Summary.Dashboard.Delete' );
$can_edit = $this->auth->has_permission ( 'Summary.Dashboard.Edit' );
$has_records = isset ( $records ) && is_array ( $records ) && count ( $records );

?>
<?php if(isset($update)):?>
<div class="alert alert-error text-center">
	<a class="close" data-dismiss="alert">&times;</a>
	<?php echo sprintf(lang('version_help'), $update['software'], '<span class="label label-important">' . $update['version'] .'</span>')?>
	<a class="btn btn-primary" href="<?php echo $update['link']; ?>" target="_blank"><?php echo lang('btn_update_now');?></a><br />
	<?php if(!empty($update['helpurl'])):?>
		<span class="small"><?php echo sprintf(lang('msg_update_help'), '<a href=" '. $update['helpurl'] .'" target="_blank">'. lang('how_to_upgrade') .'</a>');?>.</span>
	<?php endif;?>	
</div>
<?php endif;?>
<?php if(isset($notifications)):?>
<?php foreach($notifications as $notification):?>
<div class="alert alert-success text-center">
	<a class="close" data-dismiss="alert">&times;</a>
	<?php echo $notification['message']; ?>
	<?php if(!empty($notification['url'])):?>		
	<span class="small">
		<a href="<?php echo $notification['url']; ?>" target="_blank" title="<?php echo $notification['title']; ?>"><?php echo $notification['title']; ?></a>
	</span>
	<?php endif;?>
</div>
<?php endforeach;?>
<?php endif;?>
<div class="span4">
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-list-alt"></i><?php echo ' '. lang('listings'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('total_listings'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-success"><?php e($summary->TotalListings); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('inactive_listings'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->InactiveListings); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('listings_deleted'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge btn-danger"><?php e($summary->DeletedListings); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('listings_spammed'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-active"><?php e($summary->SpammedListings); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('listings_with_business_hours'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-success"><?php e($summary->ListingsWithBusinessHours); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-shopping-cart"></i><?php echo ' '. lang('products_services'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('total_products_services'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalProductsServices); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('listings_with_products'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-success"><?php e($summary->ListingsWithProductsServices); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('inactive_products_services'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->InactiveProductsServices); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-picture"></i><?php echo ' '. lang('images'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('total_images'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalImages); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('listings_with_photos'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-success"><?php e($summary->ListingsWithImages); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('inactive_images'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->InactiveImages); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="span4">
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-usd"></i><?php echo ' '. lang('financial'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('all_transactions'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalTransactions); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('paid_transactions'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-success"><?php e($summary->PaidTransactions); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('cancelled_transactions'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->CancelledTransactions); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-user"></i><?php echo ' '. lang('users'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('total_users'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalUsers); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('inactive_users'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->InactiveUsers); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-comment"></i><?php echo ' '. lang('comments'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('all_comments'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalComments); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('pending_comments'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->InactiveComments); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-film"></i><?php echo ' '. lang('videos'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('total_videos'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalVideos); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('listings_with_videos'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-success"><?php e($summary->ListingsWithVideos); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('inactive_videos'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->InactiveVideos); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="span4">
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-tag"></i><?php echo ' '. lang('keywords'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('total_keywords'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalTags); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('inactive_keywords'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->InactiveTags); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-hand-right"></i><?php echo ' '. lang('others'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('categories'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalCategories); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('locations'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalLocations); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('emails_in_queue'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-active"><?php e($summary->EmailsInQueue); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="table-responsive">
		<h4>
			<i class="glyphicon glyphicon-link"></i><?php echo ' '. lang('classifieds'); ?></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td><strong><?php echo lang('total_classifieds'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-info"><?php e($summary->TotalClassifieds); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('listings_with_classifieds'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-success"><?php e($summary->ListingsWithClassifieds); ?></span></td>
				</tr>
				<tr>
					<td><strong><?php echo lang('inactive_classifieds'); ?></strong></td>
					<td style="text-align: right; width: 30%"><span class="badge badge-warning"><?php e($summary->InactiveClassifieds); ?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>