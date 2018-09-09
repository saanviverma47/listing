	<style>
		.pg-list-1 {
			margin-top: 0px;
			background: none !important; 
			background-size: cover;
			position: relative;
			padding: 107px 0px 46px 0px !important;
			width: 100%;
			box-sizing: content-box;
		}
		.rating-xs {
			font-size: 2.2em !important;
		}
		.list-room-rati {
			padding: 0px 0px 0px 0px !important;;
		}
	</style>
	<section style='display:none;'>
		<div class="v3-list-ql">
			<div class="container">
				<div class="row">
					<div class="v3-list-ql-inn">
						<ul>
							<li class="active"><a href="#ld-abour"><i class="fa fa-user"></i> About</a>
							</li>
						<?php if ($products_count > 0): ?>
							<li><a href="#ld-ser"><i class="fa fa-cog"></i> Services</a>
						<?php endif; ?>
							</li>
						<?php if($images):?>
							<li><a href="#ld-gal"><i class="fa fa-photo"></i> Gallery</a>
							</li>
						<?php endif; ?>
							<li style='display:none;'><a href="#ld-roo"><i class="fa fa-ticket"></i> Room Booking</a>
							</li>
							<?php if(settings_item('lst.allow_review') == 1):?>
							<li><a href="#ld-rew"><i class="fa fa-edit"></i> <?php echo lang('post_review');?></a>
							</li>
							<li><a href="#ld-rer"><i class="fa fa-star-half-o"></i> <?php echo lang('all_review');?></a>
							</li>
							<?php endif; ?>
							<li><a href="#claim"><i class="fa fa-star-half-o"></i> <?php echo lang('claim_report');?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--LISTING DETAILS-->
	<style>
		.stars span {
			top: 10px;
		}
	</style>
	<section class="pg-list-1">
		<div class="container">
		<?php if (isset($title)):?>
			<div class="row">
				<div class="pg-list-1-left" style='width:80%;'> <a href="#"><h3><?php echo $title;?></h3></a>
					
					<h4 style='display:none;'>
						<?php if($ratings): //rating exist?>
						<small class="" style='color:#fff;'><span itemprop="rating" itemscope itemtype="" style='color:#fff;'><span itemprop="average" style='color:#fff;'><?php echo sprintf('%0.1f', $ratings->average_rating); ?></span>
							<?php echo lang('label_ratings');?> <span itemprop="votes" style='color:#fff;'><?php echo $ratings->total_users; ?></span></span>
							<?php echo lang('label_users_rated');?></small>
						<?php endif;?>
					</h4>
					<?php if(($package->address == 1) && ($listing->address)):?>
						<p><b>Address: </b><?php echo $listing->address?>,  <?=$listing->city?>, <?=$listing->pincode.', '?> <?=$listing->state?> <?=ucwords(strtolower($listing->country));?></p>
					<?php endif;?>
					<div class="list-number pag-p1-phone" style='display:none;'>
						<ul>
						<?php if(($package->phone == 1) && (!empty($listing->mobile_number) || !empty($listing->phone_number))):?>
							<li style='width:26.33%;'><i class="fa fa-phone" aria-hidden="true"></i> <?=$listing->mobile_number?></li>
						<?php endif;?>
						<?php if(($package->email == 1) && ($listing->email)):?>
							<li style='width:50.33%;'><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $listing->email;?></li>
						<?php endif;?>
						<?php if(($package->person  == 1) && ($listing->contact_person)):?>
							<li><i class="fa fa-user" aria-hidden="true"></i> <?php echo $listing->contact_person;?></li>
						<?php endif;?>
						</ul>
					</div>
				</div>
				<div class="pg-list-1-right" style='display:none;'>
					<div class="list-enqu-btn pg-list-1-right-p1">
						<ul>
							<li><a href="#ld-rew"><i class="fa fa-star-o" aria-hidden="true"></i> Write Review</a> </li>
							<li style='display:none;'><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> Send SMS</a> </li>
							<li><a href="tel:<?=$listing->mobile_number?$listing->mobile_number:''?>"><i class="fa fa-phone" aria-hidden="true"></i> Call Now</a> </li>
							<li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#list-quo"><i class="fa fa-usd" aria-hidden="true"></i> Get Quotes</a> </li>
						</ul>
					</div>
				</div>
			</div>
		<?php endif;?>
		</div>
	</section>

	<!--advertize--->
	<section class="list-pg-bg">
			<div class="container" style='width:100%'>
				<div class="col-sm-12"><!-- leaderboard col-sm-12 -->
				<?php if($banners): $i = 0;?>
				 <?php foreach ($banners as $banner):?>
				 <?php if((($banner['width'] == 728) && ($banner['height'] == 90)) && $banner['location'] == 'top' ):?>
				  <?php if(++$i > 1) break; //display only two banners?>
					
								<?php switch ($banner ['type']) {
									case 'image' : ?>
							<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>" style='float:left; padding:10px;'> <img
										id="<?php echo $banner['id'];?>" class="banner img-responsive"
										src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
										title="<?php echo $banner['title'];?>"
										alt="<?php echo $banner['title'];?>" /></a>
							<?php break; ?>
							<?php case 'text' :
										echo htmlspecialchars($banner ['html_text']);
										break;
								} ?>
						
				<?php endif;?>
				<?php endforeach; ?>
				<?php endif; ?>

				<?php if($banners): $i = 0;?>
				 <?php foreach ($banners as $banner):?>
				 <?php if((($banner['width'] == 190) && ($banner['height'] == 90)) && $banner['location'] == 'left'):?>
				  <?php if(++$i > 2) break; //display only two banners?>
								<?php switch ($banner ['type']) {
									case 'image' : ?>
							<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>" style='float:right;padding:10px;'> <img
										id="<?php echo $banner['id'];?>" class="banner thumbnail img-responsive"
										src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
										title="<?php echo $banner['title'];?>"
										alt="<?php echo $banner['title'];?>" /></a>
							<?php break; ?>
							<?php case 'text' :
										echo htmlspecialchars($banner ['html_text']);
										break;
								} ?>
				<?php endif;?>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
	</section>
	<!--advertize--->
	
	<section class="list-pg-bg">
		<div class="container">
			<div class="row">
				<div class="com-padd" style='padding: 0px 0px !important;'>
					<div class="list-pg-lt list-page-com-p">
						<!--LISTING DETAILS: LEFT PART 1-->
						<div class="pglist-p1 pglist-bg pglist-p-com" id="ld-abour">
							<div class="pglist-p-com-ti">
							<?php if (isset($title)):?>
								<h3><span>About</span> <?php echo $title;?></h3>
							<?php endif;?>
							</div>
							<div class="list-pg-inn-sp">
								<?php if(isset($description)):?>
									<p><?php echo $description;?></p>
								<?php endif;?>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 1-->
						<!--LISTING DETAILS: LEFT PART 2-->
					<?php if(settings_item('lst.top_advertisement') == 1):?>
						<div class="row top2">
						<div class="col-sm-12">				
							<div class="alert alert-warning" role="alert">
								<a href="#" class="close" data-dismiss="alert">&times;</a><?php echo sprintf(lang('top_advertisement'), '<a href="' .site_url('pages/' .settings_item('lst.advertisement_page')).'">'.lang('ads_click').'</a>');?>
							</div><!-- end of alert box -->
						</div><!-- end of column -->
						</div><!-- end of message -->
					<?php endif;?>


				<?php if($listings): $i=0;?>	
					<!--LISTING DETAILS: LEFT PART 4-->
						<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-roo">
							<div class="pglist-p-com-ti">
								<h3><span>Top</span> Listings</h3> 
							</div>

							<div class="list-pg-inn-sp">
							<?php if($top_featured):?>			
							<?php foreach($top_featured as $sponsor):?>
								<div class="home-list-pop list-spac list-spac-1 list-room-mar-o" style="background-color: #<?php echo $sponsor['color_scheme'];?>; border-color: #<?php echo $sponsor['border_color'];?>;">
									<!--LISTINGS IMAGE-->
									<div class="col-md-3"> 
											<?php if(!empty($sponsor['logo_url'])) { ?>
											<?php $regexp =  "/((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i";
												if(preg_match($regexp, $sponsor['logo_url'])) {?>
													<?php if(mb_strimwidth($sponsor['logo_url'], 0, 3, "") == "www") { ?>
													<img src="<?php echo 'http://'.$sponsor['logo_url']; ?>" class="img-responsive" alt="<?php echo $sponsor['title'];?>" title="<?php echo $sponsor['title'];?>" />	<?php } else { ?>
													<img src="<?php echo $sponsor['logo_url']; ?>" class="img-responsive" alt="<?php echo $sponsor['title'];?>" title="<?php echo $sponsor['title'];?>" />
													<?php } ?>
												<?php } else { ?>
												<?php preg_match('/(?<extension>\.\w+)$/im', $sponsor['logo_url'], $matches);
												$extension = $matches['extension'];
												$thumbnail = preg_replace('/(\.\w+)$/im', '', $sponsor['logo_url']) . '_thumb' . $extension; ?>
												<img src="<?php echo base_url(); ?>assets/images/logo/thumbs/<?php echo $thumbnail; ?>" class="img-responsive" alt="<?php echo $sponsor['title']?>" title="<?php echo $sponsor['title']?>" />
											<?php }?>
										<?php } else {?>
											<img src="<?= base_url(); ?>assets/images/logo/no-logo.png" alt="<?php echo $sponsor['title']?>" title="<?php echo $sponsor['title']?>" />
										<?php }?>
									</div>
									<!--LISTINGS: CONTENT-->
									<div class="col-md-9 home-list-pop-desc inn-list-pop-desc list-room-deta"> 
										<a href="<?php echo site_url('detail/' .$sponsor['slug']. '-in-' .strtolower(str_replace(" ","-", $sponsor['city'])) .'-' .$sponsor['listing_id']); ?>"><h3><?php echo $sponsor['title']?></h3></a>
										<?php if(isset($sponsor['average_rating'])):?>
										<div class="list-rat-ch list-room-rati"> <span style='float:left;'><?php echo $sponsor['average_rating'];?></span> 
											<div id="listing_rating" class="stars" style='top: -4px !important;'>
												<div class='controls'>
													<input id="input-ratings" type="number" data-disabled="true" data-show-caption="false"
														value="<?php echo $sponsor['average_rating'];?>"
														class="rating" min=0 max=5 step=0.5 data-show-clear="false"
														data-size="xs" />
												</div>
											</div>
										</div>
										<?php endif;?>
										<div class="list-room-type list-rom-ami">
											<ul>
												<li>
													<p><b>Address:</b> </p>
												</li>
												<li><img src="/images/icon/a7.png" alt=""> <?php echo $sponsor['address'];?></li>
												<li><img src="/images/icon/a4.png" alt=""> <?php echo $sponsor['city'];?> </li>
												<li><img src="/images/icon/a3.png" alt=""> <?php echo $sponsor['state'];?></li>
												<li><img src="/images/icon/a2.png" alt=""> <?php echo $sponsor['pincode'];?></li>
												<li><img src="/images/icon/a5.png" alt=""> <?php echo ucwords(strtolower($sponsor['country']));?></li>
											
												<li>
													<?php if(!empty($sponsor['mobile_number']) && !empty($sponsor['phone_number'])):?>
													<strong><?php echo lang('heading_phone');?>: </strong><?php echo $sponsor['mobile_number'] .', '.$sponsor['phone_number']; ?>
													<?php elseif(!empty($sponsor['mobile_number'])):?>
													<strong><?php echo lang('heading_phone');?>: </strong><?php echo $sponsor['mobile_number']; ?>
													<?php elseif(!empty($sponsor['phones_number'])):?>
													<strong><?php echo lang('heading_phone');?>: </strong><?php echo $sponsor['phone_number']; ?>
													<?php endif;?>
												</li>
											
											<?php if($sponsor['tags']):?>
												<li><img src="/images/icon/a7.png" alt=""> <?php echo $sponsor['tags']. ', ' ; ?></li>
											<?php endif;?>
											</ul>

										</div> <span class="home-list-pop-rat list-rom-pric" style='background: transparent !important;'><span class="glyphicon glyphicon-thumbs-up" style='font-size: 30px;'></span></span>
										<div class="list-enqu-btn">
											<ul>
												<li>
													<a href="#!" class='query'  data-toggle="modal" data-target="#query-modal" id="<?php echo $sponsor['listing_id'];?>">
														<?php echo lang('business_query');?>
													</a> 
												</li>
												<?php if($sponsor['tags']):?>
													<li>
														<a href="<?php echo site_url('detail/' .$sponsor['slug']. '-in-' .strtolower(str_replace(" ","-", $sponsor['city'])) .'-' .$sponsor['listing_id']); ?>">
															<?php echo lang('more_info');?>...
														</a> 
													</li>
												<?php endif;?>
												
											</ul>
										</div>
									</div>
								</div>
							<?php endforeach;?>
							<?php endif;?>
							</div>
							</div>
							<hr>
							<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-roo" style='background-color:#ededed;'>
							<div class="pglist-p-com-ti">
								<h3><span>Other</span> Listings</h3> 
							</div>

							<div class="list-pg-inn-sp">
							
							<?php foreach($listings as $listing):?>
								<div class="home-list-pop list-spac list-spac-1 list-room-mar-o">
									<!--LISTINGS IMAGE-->
									<div class="col-md-3"> 
										<?php if(!empty($listing['logo_url'])) { ?>
											<?php $regexp =  "/((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i";
												if(preg_match($regexp, $listing['logo_url'])) {?>
													<?php if(mb_strimwidth($listing['logo_url'], 0, 3, "") == "www") { ?>
													<img src="<?php echo 'http://'.$listing['logo_url']; ?>" class="img-responsive" alt="<?php echo $listing['title'];?>" title="<?php echo $listing['title'];?>" />	<?php } else { ?>
													<img src="<?php echo $listing['logo_url']; ?>" class="img-responsive" alt="<?php echo $listing['title'];?>" title="<?php echo $listing['title'];?>" />
													<?php } ?>
												<?php } else { ?>
												<?php preg_match('/(?<extension>\.\w+)$/im', $listing['logo_url'], $matches);
												$extension = $matches['extension'];
												$thumbnail = preg_replace('/(\.\w+)$/im', '', $listing['logo_url']) . '_thumb' . $extension; ?>
												<img src="<?php echo base_url(); ?>assets/images/logo/thumbs/<?php echo $thumbnail; ?>" class="img-responsive" alt="<?php echo $listing['title']?>" title="<?php echo $listing['title']?>" />
											<?php }?>
										<?php } else {?>
											<img src="<?= base_url(); ?>assets/images/logo/no-logo.png" alt="<?php echo $listing['title']?>" title="<?php echo $listing['title']?>" />
										<?php }?>
									</div>
									<!--LISTINGS: CONTENT-->
									<div class="col-md-9 home-list-pop-desc inn-list-pop-desc list-room-deta"> 
										<a href="<?php echo site_url('detail/' .$listing['slug']. '-in-' .strtolower(str_replace(" ","-", $listing['city'])) .'-' .$listing['listing_id']); ?>"><h3><?php echo $listing['title']; ?></h3></a>

										<?php if(isset($listing['average_rating'])):?>
										<div class="list-rat-ch list-room-rati"> <span style='float:left !important;'><?php echo $listing['average_rating'];?></span> 
											<div id="listing_rating" class="stars" style='top: -4px !important;'>
												<div class='controls'>
													<input id="input-ratings" type="number" data-disabled="true" data-show-caption="false"
														value="<?php echo $listing['average_rating'];?>"
														class="rating" min=0 max=5 step=0.5 data-show-clear="false"
														data-size="xs" />
												</div>
											</div>
										</div>
										<?php endif;?>
										<div class="list-room-type list-rom-ami">
											<ul>
												<li>
													<p><b>Address:</b> </p>
												</li>
												<li><img src="/images/icon/a7.png" alt=""> <?php echo $listing['address'];?></li>
												<li><img src="/images/icon/a4.png" alt=""> <?php echo $listing['city'];?> </li>
												<li><img src="/images/icon/a3.png" alt=""> <?php echo $listing['state'];?></li>
												<li><img src="/images/icon/a2.png" alt=""> <?php echo $listing['pincode'];?></li>
												<li><img src="/images/icon/a5.png" alt=""> <?php echo ucwords(strtolower($listing['country']));?></li>
											
												<li>
													<?php if(!empty($listing['mobile_number']) && !empty($listing['phone_number'])):?>
													<strong><?php echo lang('heading_phone');?>: </strong><?php echo $listing['mobile_number'] .', '.$listing['phone_number']; ?>
													<?php elseif(!empty($listing['mobile_number'])):?>
													<strong><?php echo lang('heading_phone');?>: </strong><?php echo $listing['mobile_number']; ?>
													<?php elseif(!empty($listing['phones_number'])):?>
													<strong><?php echo lang('heading_phone');?>: </strong><?php echo $listing['phone_number']; ?>
													<?php endif;?>
												</li>
											
											<?php if($listing['tags']):?>
												<li><img src="/images/icon/a7.png" alt=""> <?php echo $listing['tags']. ', ' ; ?></li>
											<?php endif;?>
											</ul>
										</div> <span class="home-list-pop-rat list-rom-pric" style='background: transparent !important;'><span class="glyphicon glyphicon-thumbs-up" style='font-size: 30px;'></span></span>
										<div class="list-enqu-btn">
											<ul>
												<li>
													<a href="#!" class='query'  data-toggle="modal" data-target="#query-modal" id="<?php echo $sponsor['listing_id'];?>">
														<?php echo lang('business_query');?>
													</a> 
												</li>
												<?php if($sponsor['tags']):?>
													<li>
														<a href="<?php echo site_url('detail/' .$sponsor['slug']. '-in-' .strtolower(str_replace(" ","-", $sponsor['city'])) .'-' .$sponsor['listing_id']); ?>">
															<?php echo lang('more_info');?>...
														</a> 
													</li>
												<?php endif;?>
												
											</ul>
										</div>
									</div>
								</div>
							<?php endforeach;?>	
							</div>
						</div>
				<?php endif;?>
			</div>

				

					<div class="list-pg-rt">
						<?php if($banners): $i = 0;?>
							 <?php foreach ($banners as $banner):?>
							 <?php if(((($banner['width'] <= 300) && ($banner['height'] <= 250)) || (($banner['width'] <= 336) && ($banner['height'] <= 280))) && ($banner['location'] == 'right')):?>
							 <?php if(++$i > 3) break; //display only two banners?>		 
									<div class="row">
									<div class="col-sm-12 centered-text">
										<div class="panel panel-default">
											<div class="panel-body">
										<?php switch ($banner ['type']) {
												case 'image' : ?>
										<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
													id="<?php echo $banner['id'];?>" class="img-responsive center-block banner"
													src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
													title="<?php echo $banner['title'];?>"
													alt="<?php echo $banner['title'];?>" /></a>
										<?php break; ?>
										<?php case 'text' :
													echo htmlspecialchars($banner ['html_text']);
													break;
											} ?>
											</div> <!-- end of panel-body -->
										</div> <!-- end of panel -->
									</div><!-- end of col-sm-12 -->
									</div> <!-- end of row -->	
							<?php endif;?>
							<?php endforeach; ?>
							<?php endif; ?>
						<!--END LISTING DETAILS: LEFT PART 7-->
					
					<?php switch(settings_item('lst.featured_location')) {
					case 1:
					case 4:
					case 6:
					case 7:
					if($featured_listings):?>
						
						<!--LISTING DETAILS: LEFT PART 10-->
						<div class="list-mig-like">
							<div class="list-ri-spec-tit">
								<h3><?php echo lang('featured_listings');?></h3> 
							</div>
							<?php foreach($featured_listings as $featured):?>
							
							<a href="<?php echo base_url() .'detail/' .$featured['slug']. '-in-'.strtolower(str_replace(" ","-", $featured['city'])).'-'.$featured['id'];?>">
								<div class="list-mig-like-com">
									<div class="list-mig-lc-img"> 
										<?php if($featured['url']) {
											preg_match('/(?<extension>\.\w+)$/im', $featured['url'], $matches);
											$extension = $matches['extension'];
											$thumbnail = preg_replace('/(\.\w+)$/im', '', $featured['url']) . $extension;
										?>
										<img src="<?php echo base_url(); ?>assets/images/photos/<?php echo $thumbnail;?>" alt="" /> 
										<?php } else {?>

										<img src="/assets/images/listing/1.jpg" alt="" /> 
										<?php }?>
									</div>
									<div class="list-mig-lc-con">
										<div class="list-rat-ch list-room-rati"> <span><?=sprintf('%0.1f', $featured['average_rating'])?></span></div>
										<h5><?php echo $featured['title'];?></h5>
										<?php if($featured['isAddress'] == 1): ?>
										<p><?php echo $featured['city']. ' ' .$featured['pincode']. ' ' .$featured['state'];?></p>
										<?php endif;?>
									</div>
								</div>
							</a>
							<?php endforeach;?>
						</div>
					<?php endif; }?>
						<!--END LISTING DETAILS: LEFT PART 10-->

					<?php switch(settings_item('lst.popular_location')) {
						case 1:
						case 4:
						case 6:
						case 7:
					if($popular_listings):?>
						
						<!--LISTING DETAILS: LEFT PART 10-->
						<div class="list-mig-like">
							<div class="list-ri-spec-tit">
								<h3><?php echo lang('popular_listings');?></h3> 
							</div>
							<?php foreach($popular_listings as $featured):?>
							
							<a href="<?php echo base_url() .'detail/' .$featured['slug']. '-in-'.strtolower(str_replace(" ","-", $featured['city'])).'-'.$featured['id'];?>">
								<div class="list-mig-like-com">
									<div class="list-mig-lc-img"> 
										<?php if($featured['url']) {
											preg_match('/(?<extension>\.\w+)$/im', $featured['url'], $matches);
											$extension = $matches['extension'];
											$thumbnail = preg_replace('/(\.\w+)$/im', '', $featured['url']) . $extension;
										?>
										<img src="<?php echo base_url(); ?>assets/images/photos/<?php echo $thumbnail;?>" alt="" /> 
										<?php } else {?>

										<img src="/assets/images/listing/1.jpg" alt="" /> 
										<?php }?>
									</div>
									<div class="list-mig-lc-con">
										<div class="list-rat-ch list-room-rati"> <span><?=sprintf('%0.1f', $featured['average_rating'])?></span></div>
										<h5><?php echo $featured['title'];?></h5>
										<?php if($featured['isAddress'] == 1): ?>
										<p><?php echo $featured['city']. ' ' .$featured['pincode']. ' ' .$featured['state'];?></p>
										<?php endif;?>
									</div>
								</div>
							</a>
							<?php endforeach;?>
						</div>
					<?php endif; }?>

						<?php switch(settings_item('lst.recently_added_location')) {
						case 1:
						case 4:
						case 6:
						case 7:
					if($recently_added):?>
						
						<!--LISTING DETAILS: LEFT PART 10-->
						<div class="list-mig-like">
							<div class="list-ri-spec-tit">
								<h3><?php echo lang('recently_added_listings');?></h3> 
							</div>
							<?php foreach($recently_added as $featured):?>
							
							<a href="<?php echo base_url() .'detail/' .$featured['slug']. '-in-'.strtolower(str_replace(" ","-", $featured['city'])).'-'.$featured['id'];?>">
								<div class="list-mig-like-com">
									<div class="list-mig-lc-img"> 
										<?php if($featured['url']) {
											preg_match('/(?<extension>\.\w+)$/im', $featured['url'], $matches);
											$extension = $matches['extension'];
											$thumbnail = preg_replace('/(\.\w+)$/im', '', $featured['url']) . $extension;
										?>
										<img src="<?php echo base_url(); ?>assets/images/photos/<?php echo $thumbnail;?>" alt="" /> 
										<?php } else {?>

										<img src="/assets/images/listing/1.jpg" alt="" /> 
										<?php }?>
									</div>
									<div class="list-mig-lc-con">
										<div class="list-rat-ch list-room-rati"> <span><?=sprintf('%0.1f', $featured['average_rating'])?></span></div>
										<h5><?php echo $featured['title'];?></h5>
										<?php if($featured['isAddress'] == 1): ?>
										<p><?php echo $featured['city']. ' ' .$featured['pincode']. ' ' .$featured['state'];?></p>
										<?php endif;?>
									</div>
								</div>
							</a>
							<?php endforeach;?>
						</div>
					<?php endif; }?>


					</div>
				</div>
			</div>
		</div>
	</section>


	<input id="listing_value" type="hidden" value=""/>
		<div class="modal fade" id="query-modal" tabindex="-1" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"><?php echo lang('send_business_query');?></h4>
							</div><!-- end of modal-header -->
							<form role="form" id="sendQueryForm">
							<div class="modal-body">							
								<div id="contact_form" class="row">
									<div class="col-12 col-sm-12 col-lg-12">
										<div id="contact_form_fields">											
											<div class="form-group has-feedback">
												<label class="control-label" for="message"><?php echo lang('label_message');?>*</label>
												<textarea rows="5" cols="30" class="form-control input-sm"
													id="message" name="message" placeholder="<?php echo lang('placeholder_message');?>"></textarea>
												<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_message'));?></span>
											</div>
											<div class="row">
												<div class="col-6 col-sm-6 col-lg-6">
													<div class="form-group has-feedback">
														<label class="control-label" for="name"><?php echo lang('label_name');?></label> <input
															type="text" class="form-control input-sm" id="name"
															name="name" placeholder="<?php echo lang('placeholder_name');?>" /> <span
															class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_name'));?></span>
													</div>
												</div>
												<div class="col-6 col-sm-6 col-lg-6">
													<div class="form-group has-feedback">
														<label class="control-label" for="phone"><?php echo lang('label_phone');?></label> <input
															type="tel" class="form-control input-sm optional" id="phone"
															name="phone" placeholder="<?php echo lang('placeholder_phone');?>" /> <span
															class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_phone'));?></span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-6 col-sm-6 col-lg-6">
													<div class="form-group has-feedback">
														<label class="control-label" for="email"><?php echo lang('label_email');?></label>
														<input type="email" class="form-control input-sm" id="email"
															name="email" placeholder="<?php echo lang('placeholder_email');?>" /> <span
															class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_email'));?></span>
													</div>
												</div>
												<div class="col-6 col-sm-6 col-lg-6">
													<div class="row">
														<div class="col-7 col-md-7 col-lg-7">
															<div class="form-group has-feedback">
																<label class="control-label" for="captcha_code"><?php echo lang('label_captcha');?></label> <input type="text"
																	class="form-control input-sm" name="captcha_code"
																	id="captcha_code" placeholder="<?php echo lang('placeholder_captcha');?>" /> <span
																	class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
															</div>
															<span class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
														</div>
														<div class="col-5 col-md-5 col-lg-5 pull-left">
															<img class="img-thumbnail" id="captcha"
																src="<?php echo site_url("securimage"); ?>"
																alt="CAPTCHA Image" /><span class="text-info small text-center pull-right"><?php echo lang('captcha_refresh');?> <a id="update" href="#"
																onclick="document.getElementById('captcha').src = '<?php echo site_url("securimage?"); ?>' + Math.random(); return false"><i
																class="glyphicon glyphicon-refresh"></i></a></span>
														</div>
													</div>
												</div>
											</div>
										</div>				
									</div><!--end of contact-form column-->
								</div><!--end of contact-form row-->
							</div><!-- end of modal-body -->
							<div class="modal-footer">
								<button type="submit" id="sendQuerySubmit" class="btn btn-primary" data-loading-text="Sending..."><?php echo lang('form_submit');?></button>
								<button type="button" class="btn btn-default" data-dismiss="modal" style='float:left;'><?php echo lang('form_close');?></button>								
							</div><!-- end of modal-footer -->
							</form>
						</div><!-- end of modal-content -->
					</div><!-- end of modal-dialog -->
				</div><!-- end of query-modal -->