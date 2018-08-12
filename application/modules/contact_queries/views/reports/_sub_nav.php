<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/contact_queries') ?>" id="list"><?php echo lang('contact_queries_list'); ?></a>
	</li>
</ul>