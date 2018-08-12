<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/financial/packages') ?>" id="list"><?php echo lang('packages_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Packages.Financial.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/financial/packages/create') ?>" id="create_new"><?php echo lang('new') .' '. lang('label_packages'); ?></a>
	</li>
	<?php endif; ?>
</ul>