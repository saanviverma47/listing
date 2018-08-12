<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/categories') ?>" id="list"><?php echo lang('all_parent_categories'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Categories.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/categories/create') ?>" id="create_new"><?php echo lang('new') .' '. lang('label_category'); ?></a>
	</li>
	<?php endif; ?>
	<li>
		<a href="<?php echo site_url(SITE_AREA .'/content/categories/counts') ?>" id="update_counts"><?php echo lang('label_update_counts'); ?></a>
	</li>
</ul>