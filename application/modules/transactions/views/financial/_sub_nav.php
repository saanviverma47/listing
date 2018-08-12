<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/financial/transactions') ?>" id="list"><?php echo lang('label_back_to') . lang('label_transactions'); ?></a>
	</li>
</ul>