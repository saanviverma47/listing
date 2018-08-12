<?php echo theme_view('_header');?>
<div class="container-fluid">
	<!-- Start of Main Container -->
	<!-- row 1: navigation -->
	<div class="row">	
	<input type="hidden" name="search-location" id="search-location" value="<?php echo settings_item('adv.search_location');?>" /> 
		<!-- NAVBAR -->
		<header id="header">
			<div class="top-bar">
			<div class="slidedown">
				<div class="container-fluid">						
						<div class="phone-email pull-left">						
							<ul class="list-inline" style="display:inline">	
								<li><a href="<?php echo site_url();?>"><strong><?php echo lang('detail_home');?></strong></a></li>
								<?php if(settings_item('site.display_top_menu') == 1):?>		
								<?php foreach($menu_links as $menu_link):?>
								<?php if((($menu_link->location == 'header') || ($menu_link->location == 'both')) && ($menu_link->parent_id == 0)):?>
									<li><a href="<?php echo site_url("/pages/" .$menu_link->slug);?>"><?php echo $menu_link->sub_page;?></a></li>
								<?php endif;?>								
								<?php endforeach;?>
								<?php endif;?>	
							</ul>										
						<?php if(settings_item('site.call_us')):?><span class="phone"><i class="fa fa-phone"></i><?php echo lang('header_call_us');?> : 					
							<strong><?php echo settings_item('site.call_us');?></strong></span>
						<?php endif;?>
						<?php if(settings_item('site.display_email') == 1):?><i class="fa fa-envelope"></i><?php echo lang('header_email');?> : <a
							href="mailto:<?php echo settings_item('site.system_email');?>"><?php echo settings_item('site.system_email');?></a>
						<?php endif;?>
						</div>	
						<ul class="social pull-right">
							<?php if(settings_item('site.facebook_url')):?>
			                	<li class="facebook"><a href="<?php echo settings_item('site.facebook_url');?>" data-toggle="tooltip" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
			                <?php endif;?>
			                <?php if(settings_item('site.twitter_url')):?>
			                     <li class="twitter"><a href="<?php echo settings_item('site.twitter_url');?>" data-toggle="tooltip" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
			                <?php endif;?>
			                <?php if(settings_item('site.googleplus_url')):?>
			                     <li class="gplus"><a href="<?php echo settings_item('site.googleplus_url');?>" data-toggle="tooltip" title="Google Plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
			                <?php endif;?>
			                <?php if(settings_item('site.youtube_url')):?>
			                     <li class="youtube"><a href="<?php echo settings_item('site.youtube_url');?>" data-toggle="tooltip" title="Youtube" target="_blank"><i class="fa fa-youtube"></i></a></li>
			                <?php endif;?>
			            </ul>
						<div class="user pull-right">
                          <a href="<?php echo site_url('members');?>"><i class="fa fa-user"></i><span><?php echo lang('header_my_account');?></span></a>
                    	</div>
				</div>
				</div>
				<div class="topnav hidden-lg hidden-md hidden-sm">
					<!-- TopNav Start -->
                     <span data-toggle="collapse" data-target=".slidedown" style="cursor: pointer;">
                     <i class="glyphicon glyphicon-chevron-down"></i></span>
                     </div>				
				</div>				
		</header>
		<div id="nav" class="affix">
		<div class="navbar navbar-default navbar-static-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target=".navbar-ex1-collapse">
						<span class="sr-only"><?php echo lang('header_toggle_navigation');?></span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>
					<div class="navbar-brand img-responsive">
						<a class="brand" href="/"><img id="brand-logo"
							src="<?= base_url(); ?>assets/images/<?= settings_item('site.logo');?>" alt="<?php echo settings_item('site.title');?>"
							title="<?php echo settings_item('site.title');?>" /></a>
					</div>
				</div><!-- end navbar-header -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<form class="navbar-form" role="search" method="post"
						id="search-form" action="<?php echo base_url('listings/search');?>" name="search-form">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
						<?php if(settings_item('adv.search_blocks') == 1):?>
						<div class="row">
							<input type="hidden" name="search-country" id="search-country" value="<?php echo $default_country;?>" />
			    			<input type="hidden" name="search-state" id="search-state" value="<?php echo $default_state; ?>" />
							<div class="col-sm-6">
							<div class="input-group">
								<select name="select-city" id="select-city" class="demo-default span6"
										placeholder="<?php echo lang('header_select_city');?>">
									<option value =""><?php echo lang('header_select_city');?></option>
									<?php if($cities):?>
									<?php foreach($cities as $city): ?>
			            				<option value ="<?php echo $city->id;?>" <?php echo (isset($default_city) && ($default_city==$city->id)) ? 'selected': ''; ?>><?php echo $city->name;?></option>
			           			 	<?php endforeach; ?>
			           			 	<?php endif;?>
								</select>
							</div>
							</div>
							<div class="col-sm-6">
								<div class="sandbox">
									<select id="select-locality" name="select-locality" class="demo-default span6"
										placeholder="<?php echo lang('header_select_locality');?>">
											<option value ="-1" <?php echo (isset($search_locality) && ($search_locality == -1)) ? 'selected': ''; ?>><?php echo lang('header_select_locality');?></option>
										<?php if($localities):?>
										<?php foreach($localities as $locality): ?>
			            					<option value ="<?php echo $locality->id;?>" <?php echo (isset($search_locality) && ($search_locality == $locality->id)) ? 'selected': ''; ?>><?php echo $locality->name;?></option>
			           			 		<?php endforeach; ?>
			           			 		<?php endif;?>
									</select>
								</div>
							</div>						
						</div>
						<?php elseif(settings_item('adv.search_blocks') == 2): ?>
						<div class="row" style="margin-bottom: 5px;">
							<div class="col-sm-6">
								<div class="form-group" style="display: inline;">
										<div class="input-group">
											<input class="form-control" name="location"
												autocomplete="off" type="text" id="location"
												value="<?php echo isset($search_location) ? $search_location : '';?>"
												placeholder="<?php echo lang('header_location_term');?>">
										</div>
								</div>
						</div>
						<div class="col-sm-6">
							<div class="sandbox">
									<select id="select-category" name="select-category"
										class="demo-default span6"
										placeholder="<?php echo lang('header_category_term');?>">
										<option value="-1"><?php echo lang('header_select_category');?></option>
									<?php if($header_categories):?>
									<?php foreach($header_categories as $category): ?>
			            				<option value="<?php echo $category->id;?>" <?php echo (isset($search_category) && ($search_category == $category->id)) ? 'selected': ''; ?>><?php echo $category->name;?></option>
			           		 		<?php endforeach; ?>
			           		 		<?php endif;?>
								</select>
							</div>
						</div>						
						</div>						
						<?php elseif(settings_item('adv.search_blocks') == 3):?>
						<div class="row top2">
						<div class="col-sm-6">
							<div class="form-group" style="display: inline;">
								<div class="input-group">
									<input class="form-control" name="location"
										autocomplete="off" type="text" id="location"
										value="<?php echo isset($search_location) ? $search_location : '';?>"
										placeholder="<?php echo lang('header_location_term');?>">
								</div>
							</div>
						</div>
						<div class="col-sm-6">
						<?php endif;?>
						<div class="form-group" style="display: inline;">
							<div class="input-group">
								<input class="form-control" name="search" autocomplete="off"
									type="text" id="search" value="<?php echo isset($searchterm) ? $searchterm : '';?>"
									placeholder="<?php echo lang('header_search_term');?>">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-info" id="searchSubmit" name="searchSubmit">
										<span class="glyphicon glyphicon-search"></span>
									</button>
								</div>
							</div>
						</div>
						<?php if(settings_item('adv.search_blocks') == 3):?>
						</div>
						</div>
						<?php endif;?>
					</form><!-- end form -->
					<?php switch(settings_item('adv.search_location')) {
								case 2: 
									break;
								case 3:
									if(settings_item('adv.search_blocks') != 1) {
										break;
									}									
								case 1:?>
					<div class="hidden-xs btnTOP text-center">
					<div class="btn-group">
						<a href="#selectLocation" role="button" class="btn btn-info"
						data-toggle="modal"> <span class="glyphicon glyphicon-globe"></span>
						<?php echo ((settings_item('adv.search_location') == 1) && (settings_item('adv.search_blocks') == 1)) ? lang('header_change_country_state') : ((settings_item('adv.search_blocks') == 1) ? lang('header_change_state') : lang('header_change_country'));?>							
						</a>
					</div>
					</div>
					<?php break;?>
					<?php }?>
					<?php if(settings_item('adv.search_location') != 2):?>
					<!-- Select Location Form -->
					<div class="modal fade" id="selectLocation">
						<div class="modal-dialog">
						<form role="form" id="selectedLocation" method="post">
							<div class="modal-content">
								<div class="modal-header">
									<button class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><?php echo ((settings_item('adv.search_location') == 1) && (settings_item('adv.search_blocks') == 1)) ? lang('header_change_country_state') : ((settings_item('adv.search_blocks') == 1) ? lang('header_change_state') : lang('header_change_country'));?></h4>
								</div>
								<!-- end modal-header -->
								<div class="modal-body">
								<?php if(settings_item('adv.search_location') == 1):?>
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
								<div class="sandbox">
									<select name="select-country" id="select-country" class="demo-default span3">
							            <?php foreach($countries as $country){ ?>
							            <option value ="<?php echo $country->iso;?>" <?php echo (isset($default_country) && ($default_country==$country->iso)) ? 'selected': ''; ?>><?php echo ucwords(strtolower($country->name));?></option>
							            <?php } ?>
							        </select>
						        </div>
						        <?php endif;?>
						        <?php if(settings_item('adv.search_blocks') == 1):?>
						        <div class="sandbox">						        
							        <select name="select-state" id="select-state" class="demo-default span3" placeholder="<?php echo lang('header_select_state');?>">
							        <?php foreach($states as $state){ ?>
							            <option value ="<?php echo $state->id;?>" <?php echo (isset($default_state) && ($default_state==$state->id)) ? 'selected': ''; ?>><?php echo $state->name;?></option>
							        <?php }?>
							        </select>
						        </div>        		        
						        <?php endif;?>
								</div><!-- end modal-body -->
								<div class="modal-footer">
									<button type="submit" id="locationSubmit" name="locationSubmit"
											class="btn btn-primary btn-sm" data-loading-text="Submitting..."
											style="display: block; margin-top: 10px;" value="locationSubmit"><?php echo lang('header_form_submit');?>
									</button>	
								</div><!-- end modal-footer -->
							</div><!-- end modal-content -->
							</form>				
						</div><!-- end modal-dialog -->
						</div><!-- end location selection -->
						<?php endif;?>
					<div class="hidden-xs text-center <?php echo settings_item('adv.search_location') != 2 ? 'lst-add' : 'btnTOP';?>">
					<div class="btn-group">						
						<a href="<?php echo site_url('members/add_business');?>" class="btn btn-md btn-warning"><span class="glyphicon glyphicon-plus"></span><?php echo lang('header_add_business');?></a>
					</div>
					</div>
				</div><!-- end collapse -->
			</div><!-- end container-fluid -->
		</div><!-- end navbar -->
		</div>
	</div><!-- end row -->
    <?php echo isset ( $content ) ? $content : Template::content (); ?>
</div><!-- end of main container -->
<?php echo theme_view('_footer'); ?>