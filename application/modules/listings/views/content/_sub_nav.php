<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/listings') ?>" id="list"><?php echo lang('list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Listings.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/listings/create') ?>" id="create_new"><?php echo lang('listings_create'); ?></a>
	</li>
	<?php endif; ?>
</ul>