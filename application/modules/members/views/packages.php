<?php 
 $has_records	= isset($records) && is_array($records) && count($records);
if ($has_records) : ?>
<div class="row">
<?php foreach ($records as $record) :?>
<?php $color = '';
	  $btn = ''; 
switch ($record->price) {
	case 0:
		$color = 'grey';
		$btn = 'btn-primary';
		break;
	case $record->price <= 10:
		$color = 'blue';
		$btn = 'btn-info';
		break;
	case in_array($record->price, range(11,20)):
		$color = 'green';
		$btn = 'btn-success';
		break;
	default:
		$color = 'red';	
		$btn = 'btn-danger';
}
?>
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
			<!-- PRICE ITEM -->
			<div class="panel price panel-<?php echo $color;?>">
				<div class="panel-heading  text-center">
					<h3><?php echo ucwords(strtoupper($record->title));?></h3>
				</div>
				<div class="panel-body text-center">
					<p class="lead" style="font-size: 30px">
						<strong><?php echo ($record->price == 0) ? lang('label_free') : settings_item('site.currency'). $record->price;?> <?php echo ($record->duration == 0) ? $record->subscription : '/ ' .$record->duration .' ' . lang('bf_days');?></strong>
					</p>
				</div>
				<ul class="list-group list-group-flush text-center">
					<?php echo $record->description; ?>
				</ul>
				<div class="panel-footer">
					<a class="btn btn-lg btn-block <?php echo $btn;?>" href="<?php echo site_url('members/add_business?id=' . $this->encrypt->encode($record->id));?>"><?php echo lang('btn_buy_now');?></a>
				</div>
			</div><!-- /PRICE ITEM -->


		</div>
<?php endforeach;?>
	</div><!-- end of row -->
<?php endif;?>