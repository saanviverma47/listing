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

<div class="col-md-4">
	<div class="v4-pril-inn">
		<div class="v4-pril-inn-top">
			<h2><?php echo ucwords(strtoupper($record->title));?></h2>
			<p class="v4-pril-price">
				<span class="v4-pril-curr">$</span> <b><?php echo ($record->price == 0) ? lang('label_free') : settings_item('site.currency'). $record->price;?></b> 
				<span class="v4-pril-mon"><?php echo ($record->duration == 0) ? $record->subscription : '/ ' .$record->duration .' ' . lang('bf_days');?></span>
			</p>
		</div>
		<div class="v4-pril-inn-bot">
			<ul>
				<?php echo $record->description; ?>
			</ul>
			<a class="waves-effect waves-light btn-large full-btn" href="<?php echo site_url('members/add_business?id=' . $this->encrypt->encode($record->id));?>"><?php echo lang('btn_buy_now');?></a>
		</div>
	</div>
</div>
<?php endforeach;?>
</div><!-- end of row -->
<?php endif;?>