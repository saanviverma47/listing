<?php if($links):?>
<div class="row row-bottom-padding">
<?php $i = 1;?>
<?php foreach($links as $link):?>
<div class="span2 context-span">
	<a class="context-container btn btn-<?php echo $link['color'];?>" href="<?php echo site_url(SITE_AREA . $link['link'])?>">
		<span class="context-title">
			<i class="context-icons fa fa-2x <?php echo $link['icon'];?>"></i>
			<?php echo $link['name'];?>
		</span>
	</a>
</div>
<?php if($i%5 == 0):?>
</div>
<div class="row row-bottom-padding">
<?php endif;?>
<?php $i++;?>
<?php endforeach;?>
</div>
<?php endif;?>