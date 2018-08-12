<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/claim_reports') ?>" id="list"><?php echo lang('all_claims'); ?></a>
	</li>
</ul>