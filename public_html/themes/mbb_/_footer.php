<?php if (!isset($show) || $show==true) : ?>
<footer class="footer">
	<div class="container-fluid">
		<div class="row">
			<input type="hidden" name="site_url" id="site_url"
				value="<?php echo base_url();?>" />
			<div class="col-sm-2">
				<h6><?php echo lang('footer_copyright');?> <?php echo settings_item('site.title')?></h6>
			</div>
			<!-- end col-sm-2 -->
			<?php if(settings_item('site.footer_text') != ""):?>
			<div class="col-sm-4">
				<?php if(settings_item('site.footer_text') != ""):?>
				<h6><strong><?php echo lang('footer_about_us');?></strong></h6>
				<p style="text-align: justify"><?php echo settings_item('site.footer_text');?></p>
				<?php endif;?>
			</div>
			<?php endif;?>
			<!-- end col-sm-4 -->
			<?php if($menu_links):?>
			<div class="col-sm-2">
				<h6><strong><?php echo lang('footer_navigation');?></strong></h6>
				<ul class="unstyled">				
				<?php foreach($menu_links as $menu_link):?>
				<?php if(($menu_link->location == 'footer') && ($menu_link->parent_id == 0)):?>
					<li><a
						href="<?php echo site_url("/pages/" .$menu_link->slug);?>"><?php echo $menu_link->sub_page;?></a>
						<ul>						
						<?php foreach($menu_links as $sub_menu):?>
						<?php if(($sub_menu->location == 'footer') && ($sub_menu->parent_id == $menu_link->id)):?>
							<li><a
								href="<?php echo site_url("/pages/" .$sub_menu->slug);?>"><?php echo $sub_menu->sub_page;?></a></li>
						<?php endif;?>	
						<?php endforeach;?>																	
						</ul></li>
				<?php endif;?>								
				<?php endforeach;?>
					<li><a href="<?php echo site_url('contact');?>"><?php echo lang('label_contact_us');?></a></li>
				</ul>
			</div>
			<!-- end col-sm-2 navigation -->
			<?php endif;?>
			<div class="col-sm-2">
				<h6><strong><?php echo lang('footer_quick_links');?></strong></h6>
				<ul class="unstyled">
					<li><a href="<?php echo site_url('locations')?>"><?php echo lang('home_location_browse');?></a></li>
				</ul>
				<h6><strong><?php echo lang('footer_social');?></strong></h6>
				<ul class="social social-icons-footer-bottom">
				<?php if(settings_item('site.facebook_url')):?>
                	<li class="facebook"><a
						href="<?php echo settings_item('site.facebook_url');?>"
						data-toggle="tooltip" title="Facebook" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <?php endif;?>
                <?php if(settings_item('site.twitter_url')):?>
                     <li class="twitter"><a
						href="<?php echo settings_item('site.twitter_url');?>"
						data-toggle="tooltip" title="Twitter" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <?php endif;?>
                <?php if(settings_item('site.googleplus_url')):?>
                     <li class="gplus"><a
						href="<?php echo settings_item('site.googleplus_url');?>"
						data-toggle="tooltip" title="Google Plus" rel="nofollow" target="_blank"><i
							class="fa fa-google-plus"></i></a></li>
                <?php endif;?>
                <?php if(settings_item('site.youtube_url')):?>
                     <li class="youtube"><a
						href="<?php echo settings_item('site.youtube_url');?>"
						data-toggle="tooltip" title="Youtube" rel="nofollow" target="_blank"><i class="fa fa-youtube"></i></a></li>
                <?php endif;?>
            </ul>
			</div>
			<!-- end col-sm-2 -->
			<div class="col-sm-2">
			<?php if(settings_item('site.footer_partner')):?>
			<h6><strong><?php echo lang('footer_partners');?></strong></h6>
			<ul class="unstyled">
				<?php echo settings_item('site.footer_partner');?>
			</ul>
			<?php endif;?>
			<h6>Coded with <span class="glyphicon glyphicon-heart"></span>by mbb</h6>
			</div>
			<!-- end col-sm-2 -->
			<p><a href="http://www.mbb.com" target="_blank">mbb Business Directory Script </a></p>
		</div>
		<?php if(settings_item('site.display_footer_popular') == 1):?>
		<?php if($popular_categories):?>
		<div class="row">
		<div class="col-sm-8">
			<span><strong><?php echo lang('footer_popular_searches');?></strong>
				<?php echo implode(', ', $popular_categories);?>
			</span>
		</div>
		</div>
		<?php endif;?>
		<?php if($popular_cities):?>
		<div class="row">
		<div class="col-sm-8">
			<span><strong><?php echo lang('footer_popular_cities');?></strong>
				<?php echo implode(', ', $popular_cities);?>
			</span>
		</div>
		</div>
		<?php endif;?>
		<?php endif;?>
		<!-- end container-fluid -->
	</div>
	<!-- end row -->
</footer>
<?php endif; ?>
<div id="debug"></div>
<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo Template::theme_url("js/jquery-latest.min.js")?>"><\/script>')</script>

<!-- This would be a good place to use a CDN version of jQueryUI if needed -->
<?php //Assets::add_js( $this->load->view('frontend_js', null, true ), 'inline' );?>
<?php echo Assets::js(); ?>
<script>
/*----------------------------------------------------*/
/*	Theme Switcher
/*----------------------------------------------------*/
jQuery(document).ready(function() {
    ThemeSwitcher.initThemeSwitcher(); 
});
</script>

<script>
	$('a').click(function () {return false;});
</script>
</body>
</html>