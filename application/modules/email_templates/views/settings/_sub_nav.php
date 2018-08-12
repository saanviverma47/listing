<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/email_templates') ?>" id="list"><?php echo lang('all_email_templates'); ?></a>
	</li>
</ul>