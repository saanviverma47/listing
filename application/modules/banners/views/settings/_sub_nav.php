<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == 'banner_types' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/banners/banner_types') ?>" id="banner_types"><?php echo lang('all_banner_types'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Banners.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'add_banner_type' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/banners/add_banner_type') ?>" id="create_new_type"><?php echo lang('new') . ' ' .lang('label_banner_type'); ?></a>
	</li>
	<?php endif; ?>
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/banners') ?>" id="list"><?php echo lang('all_banners'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Banners.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/banners/create') ?>" id="create_new"><?php echo lang('new') .' ' .lang('label_banner'); ?></a>
	</li>
	<?php endif; ?>
</ul>