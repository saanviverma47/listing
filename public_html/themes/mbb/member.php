<?php echo theme_view('_header'); ?>

<!--DASHBOARD-->
	<section>
		<div class="tz">
			<!--LEFT SECTION-->
			<div class="tz-l">
				<div class="tz-l-2">
					<ul>
					<li><a href="<?php echo site_url('members');?>"><?php echo lang('members_dashboard');?></a></li>
                  <li ><a href="<?php echo site_url('members/add_business');?>"><?php echo lang('header_add_business');?></a></li>
                  <li><a href="<?php echo site_url('members/view_business_queries');?>"><?php echo lang('members_business_queries');?> (<?php echo isset($total_business_queries)? $total_business_queries : ''?>)</a></li>
                  <li><a href="<?php echo site_url('members/view_comments');?>"><?php echo lang('members_comments');?> (<?php echo isset($total_comments)? $total_comments : ''?>)</a></li>
                  <?php if($total_transactions):?>
                  <li><a href="<?php echo site_url('members/invoices');?>"><?php echo lang('members_invoices');?> (<?php echo isset($total_transactions)? $total_transactions : ''?>)</a></li>                  
                  <?php endif;?>
                  <li><a href="<?php echo site_url('users/profile');?>"><?php echo lang('members_profile');?></a></li>
                  <li><a href="<?php echo site_url('logout');?>"><?php echo lang('members_logout');?></a></li>
					</ul>
				</div>
				 <?php if($admin_messages):?>
	            <div class="tz-l-2">
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
				<div class="tz-l-2">
					<div><h4><?php echo lang('members_login_information');?></h4></div>
					<br/>
					<div>
						<ul>
							<li><strong><?php echo lang('members_display_name');?>:</strong> <?php echo $users_info->display_name;?></li>
							<li><strong><?php echo lang('members_last_login');?>: </strong> <?php echo $users_info->last_login;?></li>
							<li><strong><?php echo lang('members_last_ip');?>:</strong> <?php echo $users_info->last_ip;?></li>
						</ul>
					</div>
				</div>
			</div>
			<!--CENTER SECTION-->
			<div style="line-height: 10px;">&nbsp;</div>
			<div class="tz-2">
				<div class="tz-2-com tz-2-main">
					<?php echo Template::message(); ?>
					<h4><?php echo isset($title) ? $title : ''; ?></h4>
					<div class="db-list-com tz-db-table">
						<?php echo isset($help_message) ? '<div class="alert alert-info">' .$help_message .'</div>' : ''; ?>
              			<?php echo isset($content) ? $content : Template::content(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php echo theme_view('_footer'); ?>