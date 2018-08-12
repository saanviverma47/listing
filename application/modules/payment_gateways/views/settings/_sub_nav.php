<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/payment_gateways') ?>" id="list"><?php echo lang('payment_gateways_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Payment_Gateways.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/payment_gateways/create') ?>" id="create_new"><?php echo lang('payment_gateways_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>