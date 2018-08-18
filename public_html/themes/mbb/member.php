<?php echo theme_view('_header'); ?>
<div class="container-fluid body">
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
                          <a href="<?php echo site_url('login');?>"><i class="fa fa-user"></i><span><?php echo lang('header_my_account');?></span></a>
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
	</div><!-- end row -->
	<div class="row-fluid">
		<div class="col-sm-3">
			<?php echo Template::block('sidebar'); ?>
			<div class="panel-group" id="accordion">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-th-list">
                    </span><?php echo lang('members_menu');?></a>
                </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse in">
                <ul class="list-group">
                  <li class="list-group-item"><span class="glyphicon glyphicon-pencil"></span><a href="<?php echo site_url('members');?>"><?php echo lang('members_dashboard');?></a></li>
                  <li class="list-group-item"><span class="fa fa-plus"></span><a href="<?php echo site_url('members/add_business');?>"><?php echo lang('header_add_business');?></a></li>
                  <li class="list-group-item"><span class="glyphicon glyphicon-file"></span><a href="<?php echo site_url('members/view_business_queries');?>"><?php echo lang('members_business_queries');?></a><span class="badge"><?php echo isset($total_business_queries)? $total_business_queries : ''?></span></li>
                  <li class="list-group-item"> <span class="glyphicon glyphicon-comment"></span><a href="<?php echo site_url('members/view_comments');?>"><?php echo lang('members_comments');?></a><span class="badge"><?php echo isset($total_comments)? $total_comments : ''?></span></li>
                  <?php if($total_transactions):?>
                  <li class="list-group-item"><span class="glyphicon glyphicon-shopping-cart"></span><a href="<?php echo site_url('members/invoices');?>"><?php echo lang('members_invoices');?></a><span class="badge"><?php echo isset($total_transactions)? $total_transactions : ''?></span></li>                  
                  <?php endif;?>
                  <li class="list-group-item"> <span class="glyphicon glyphicon-user"></span><a href="<?php echo site_url('users/profile');?>"><?php echo lang('members_profile');?></a></li>
                  <li class="list-group-item"> <span class="glyphicon glyphicon-off"></span><a href="<?php echo site_url('logout');?>"><?php echo lang('members_logout');?></a></li>
                </ul>
              </div>
            </div>
            <?php if($admin_messages):?>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="glyphicon glyphicon-envelope">
                    </span><?php echo lang('members_admin_messages');?></a>
                </h4>
              </div>              
              <div id="collapseFive" class="panel-collapse collapse">              
              <?php foreach($admin_messages as $message):?>
                <div class="list-group">
                  <a class="list-group-item">
                    <h4 class="list-group-item-heading"><?php echo $message->subject;?></h4>
                    <p class="list-group-item-text"><?php echo word_limiter($message->message_text, 20);?><br /><span class="small text-primary"><?php echo lang('members_message_more_info');?></span></p>
                  </a>
                </div>
                <?php endforeach;?>                
              </div>              
            </div>
            <?php endif;?>
          </div><!-- end of accordion -->
          <div class="panel panel-default">
		          <div class="panel-heading">
		          <h4 class="panel-title"><span class="glyphicon glyphicon-user"></span><?php echo lang('members_login_information');?></h4></div>
		  <div class="panel-body">
			  <ul class="unstyled">
			  	<li><span class="glyphicon glyphicon-eye-open"></span><strong><?php echo lang('members_display_name');?>: </strong><?php echo $users_info->display_name;?></li>
			  	<li><span class="glyphicon glyphicon-calendar"></span><strong><?php echo lang('members_last_login');?>: </strong><?php echo $users_info->last_login;?></li>
			  	<li><span class="glyphicon glyphicon-cloud"></span><strong><?php echo lang('members_last_ip');?>: </strong><?php echo $users_info->last_ip;?></li>
			  </ul>
		  </div><!-- end of panel-body -->
		  </div><!-- end of panel -->			
		</div><!-- end of left menu -->

		<div class="col-sm-9">
			<?php echo Template::message(); ?>
			<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo isset($title) ? $title : ''; ?></h3>
            </div>
            <div class="panel-body">
              <?php echo isset($help_message) ? '<div class="alert alert-info">' .$help_message .'</div>' : ''; ?>
              <?php echo isset($content) ? $content : Template::content(); ?>
            </div>
          </div>
			

		</div>
	</div>

</div><!-- end of container-fluid -->
<?php echo theme_view('_footer'); ?>