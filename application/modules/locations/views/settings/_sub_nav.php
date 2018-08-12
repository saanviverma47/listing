<?php 
 
 
 
 
 
 
 
 
 
 
 
 

?>
<ul class="nav nav-pills">
<?php 
	$url = $this->uri->segment(4);
	if($url == '') {
		$url = 'index';
	}
	switch($url) {
		case 'index':?>	
			<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations') ?>" id="list"><?php echo lang('label_all_countries'); ?></a>
			</li>
			<?php if ($this->auth->has_permission('Locations.Settings.Create')) : ?>
			<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations/add_country') ?>" id="create_new"><?php echo lang('label_country_new'); ?></a>
			</li>
			<?php endif;
		break;
		case 'states': ?>
			<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations') ?>" id="list"><?php echo lang('back_to_countries'); ?></a>
			</li>			
			<li class="active">
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations/states/' .$this->session->userdata('country_iso') .'/') ?>" id="list"><?php echo lang('label_all_states'); ?></a>
			</li>
			<?php 
			break;
		case 'cities': ?>
			<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations') ?>" id="list"><?php echo lang('back_to_countries'); ?></a>
			</li>
			<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations/states/' .$this->session->userdata('country_iso') .'/') ?>" id="list"><?php echo lang('back_to_states'); ?></a>
			</li>
			<li class="active">
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations/cities/' .$this->session->userdata('state_id') .'/') ?>" id="list"><?php echo lang('label_all_cities'); ?></a>
			</li>
			<?php 
			break;
		case 'localities': ?>
			<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations') ?>" id="list"><?php echo lang('back_to_countries'); ?></a>
			</li>
			<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations/states/' .$this->session->userdata('country_iso') .'/') ?>" id="list"><?php echo lang('back_to_states'); ?></a>
			</li>
			<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations/cities/' . $this->session->userdata('state_id') .'/') ?>" id="list"><?php echo lang('back_to_cities'); ?></a>
			</li>
			<li class="active">
				<a href="<?php echo site_url(SITE_AREA .'/settings/locations/localities/' .$this->session->userdata('city_id') .'/') ?>" id="list"><?php echo lang('label_all_localities'); ?></a>
			</li>
			<?php break; ?>
	<?php }	?>
</ul>