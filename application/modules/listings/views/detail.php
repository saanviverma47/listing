	
	<section>
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
			<div class="row">
				<div class="pg-list-1-left"> <a href="#"><h3><?php echo $listing->title;?></h3></a>
					
					<div id="listing_rating" class="stars" style="width: 35%;">
						<div class='controls'>
							<input id="input-ratings" type="number"	value="<?php echo isset($ratings->average_rating) ? sprintf('%0.1f', $ratings->average_rating) : ''; ?>" class="rating" min=0 max=5 step=0.5 data-show-clear="false" data-size="sm" />
						</div>
						<div id="rating_feedback"></div>
					</div>
					<h4>
						<?php if($ratings): //rating exist?>
						<small class="" style='color:#fff;'><span itemprop="rating" itemscope itemtype="" style='color:#fff;'><span itemprop="average" style='color:#fff;'><?php echo sprintf('%0.1f', $ratings->average_rating); ?></span>
							<?php echo lang('label_ratings');?> <span itemprop="votes" style='color:#fff;'><?php echo $ratings->total_users; ?></span></span>
							<?php echo lang('label_users_rated');?></small>
						<?php endif;?>
					</h4>
					<?php if(($package->address == 1) && ($listing->address)):?>
						<p><b>Address: </b><?php echo $listing->address?>,  <?=$listing->city?>, <?=$listing->pincode.', '?> <?=$listing->state?> <?=ucwords(strtolower($listing->country));?></p>
					<?php endif;?>
					<div class="list-number pag-p1-phone">
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
				<div class="pg-list-1-right">
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
		</div>
	</section>
	<?php echo Template::message(); ?>
	<?php
		if ($listing) : // listing exist
			echo form_hidden ( 'listing_id', $listing->id );
		?>
	<?php endif; ?>
	<section class="list-pg-bg">
		<div class="container">
			<div class="row">
				<div class="com-padd">
					<div class="list-pg-lt list-page-com-p">
						<!--LISTING DETAILS: LEFT PART 1-->
						<div class="pglist-p1 pglist-bg pglist-p-com" id="ld-abour">
							<div class="pglist-p-com-ti">
								<h3><span>About</span> <?=$listing->title?$listing->title:''?></h3> </div>
							<div class="list-pg-inn-sp">
								<?php if((settings_item('lst.allow_facebook_url') == 1) || (settings_item('lst.allow_twitter_url') == 1) || (settings_item('lst.allow_googleplus_url') == 1)):?>
									<div class="share-btn">
										<ul>
											<?php if(!empty($listing->facebook_url)):?>
												<li><a href="<?php echo $listing->facebook_url; ?>"><i class="fa fa-facebook fb1"></i> Share On Facebook</a> </li>
											<?php endif;?>
											<?php if(!empty($listing->twitter_url)):?>
												<li><a href="<?php echo $listing->twitter_url; ?>"><i class="fa fa-twitter tw1"></i> Share On Twitter</a> </li>
											<?php endif;?>
											<?php if(!empty($listing->googleplus_url)):?>
												<li><a href="<?php echo $listing->googleplus_url; ?>"><i class="fa fa-google-plus gp1"></i> Share On Google Plus</a> </li>
											<?php endif;?>
										</ul>
									</div>
								<?php endif;?>
								<?php if($listing->description):?>
									<p><?php echo $listing->description;?></p>
								<?php endif;?>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 1-->
						<!--LISTING DETAILS: LEFT PART 2-->
					<?php if ($products_count > 0): ?>
						<div class="pglist-p2 pglist-bg pglist-p-com" id="ld-ser">
							<div class="pglist-p-com-ti">
								<h3><?php echo lang('detail_services');?></h3>
								
							</div>
							<div class="list-pg-inn-sp">
								<p style='display:none;'>Taj Luxury Hotels & Resorts provide 24-hour Business Centre, Clinic, Internet Access Centre, Babysitting, Butler Service in Villas and Seaview Suite, House Doctor on Call, Airport Butler Service, Lobby Lounge </p>
								<div class="row pg-list-ser">
									<ul>
									<?php if(!empty($products)): foreach($products as $product): ?>
									<?php if($product->type == 'product'): ?>
										<li class="col-md-4">
											<div class="pg-list-ser-p1">
											<?php if($product->image){?> 
												<img src="<?php echo base_url();?>assets/images/products/<?php echo $product->image; ?>"/>
											<?php }else{;?>
												<img src="/assets/images/listing/1.jpg" alt="" />
											<?php };?>
											</div>
											<div class="pg-list-ser-p2">
												<h4><?php echo $product->title; ?><?php if($product->price):?><?php echo " ".settings_item('site.currency') .$product->price;?><?php endif;?></h4> </div>
										</li>
									<?php endif; endforeach; endif; ?>
									</ul>
								</div>
							</div>
						</div>
					<?php  endif; ?>
						<!--END LISTING DETAILS: LEFT PART 2-->
				
				
				<?php if($images):?>
						<!--LISTING DETAILS: LEFT PART 3-->
						<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-gal">
							<div class="pglist-p-com-ti">
								<h3><?php echo lang('detail_gallery');?></div>
							<div class="list-pg-inn-sp">
								<div id="myCarousel" class="carousel slide" data-ride="carousel">
									<!-- Indicators -->
									<ol class="carousel-indicators">
										<?php if ((isset($images) && count($images)) || !empty($videos)):?>	
											<?php for($i = 0;$i < count($images); $i++){ ?>
											<li data-target="#myCarousel" data-slide-to="<?=$i?>" class="active"></li>
											<?php } ?>
											
										<?php endif;?>
									</ol>
									<!-- Wrapper for slides -->
									<div class="carousel-inner">
										<?php if ((isset($images) && count($images)) || !empty($videos)):?>	
											<?php if(!empty($images)):?>
											<?php foreach($images as $index=> $image){ ?>
												<div class="item <?=$index == 0?'active':''?>"> 
													<img src="<?php echo base_url();?>assets/images/photos/<?php echo $image->url; ?>" <?php if(!empty($image->title)): ?>
														title="<?php echo $image->title;?>"
														alt="<?php echo $image->title;?>" <?php endif; ?> /> 
												</div>
												
											<?php };?>
											<?php endif;?>
										<?php endif;?>
									</div>
									<!-- Left and right controls -->
									<a class="left carousel-control" href="#myCarousel" data-slide="prev"> <i class="fa fa-angle-left list-slider-nav" aria-hidden="true"></i> </a>
									<a class="right carousel-control" href="#myCarousel" data-slide="next"> <i class="fa fa-angle-right list-slider-nav list-slider-nav-rp" aria-hidden="true"></i> </a>
								</div>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 3-->

				<?php  endif; ?>


						<!--LISTING DETAILS: LEFT PART 4-->
						<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-roo" style='display:none;'>
							<div class="pglist-p-com-ti">
								<h3><span>Room</span> Booking</h3> </div>
							<div class="list-pg-inn-sp">
								<div class="home-list-pop list-spac list-spac-1 list-room-mar-o">
									<!--LISTINGS IMAGE-->
									<div class="col-md-3"> <img src="/assets/images/listing/1.jpg" alt=""> </div>
									<!--LISTINGS: CONTENT-->
									<div class="col-md-9 home-list-pop-desc inn-list-pop-desc list-room-deta"> <a href="#!"><h3>Ultra Deluxe Rooms</h3></a>
										<div class="list-rat-ch list-room-rati"> <span>5.0</span> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> </div>
										<div class="list-room-type list-rom-ami">
											<ul>
												<li>
													<p><b>Amenities:</b> </p>
												</li>
												<li><img src="/images/icon/a7.png" alt=""> Wi-Fi</li>
												<li><img src="/images/icon/a4.png" alt=""> Air Conditioner </li>
												<li><img src="/images/icon/a3.png" alt=""> Swimming Pool</li>
												<li><img src="/images/icon/a2.png" alt=""> Bar</li>
												<li><img src="/images/icon/a5.png" alt=""> Bathroom</li>
												<li><img src="/images/icon/a6.png" alt=""> TV</li>
												<li><img src="/images/icon/a9.png" alt=""> Spa</li>
												<li><img src="/images/icon/a10.png" alt=""> Music</li>
												<li><img src="/images/icon/a11.png" alt=""> Parking</li>
											</ul>
										</div> <span class="home-list-pop-rat list-rom-pric">$940</span>
										<div class="list-enqu-btn">
											<ul>
												<li><a href="#!"><i class="fa fa-usd" aria-hidden="true"></i> Get Quotes</a> </li>
												<li><a href="#!"><i class="fa fa-commenting-o" aria-hidden="true"></i> Send SMS</a> </li>
												<li><a href="#!"><i class="fa fa-phone" aria-hidden="true"></i> Call Now</a> </li>
												<li><a href="#!"><i class="fa fa-usd" aria-hidden="true"></i> Book Now</a> </li>
											</ul>
										</div>
									</div>
								</div>
								<div class="home-list-pop list-spac list-spac-1 list-room-mar-o">
									<!--LISTINGS IMAGE-->
									<div class="col-md-3"> <img src="/assets/images/listing/1.jpg" alt=""> </div>
									<!--LISTINGS: CONTENT-->
									<div class="col-md-9 home-list-pop-desc inn-list-pop-desc list-room-deta"> <a href="#!"><h3>Premium Rooms(Executive)</h3></a>
										<div class="list-rat-ch list-room-rati"> <span>4.0</span> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
										<div class="list-room-type list-rom-ami">
											<ul>
												<li>
													<p><b>Amenities:</b> </p>
												</li>
												<li><img src="/images/icon/a7.png" alt=""> Wi-Fi</li>
												<li><img src="/images/icon/a4.png" alt=""> Air Conditioner </li>
												<li><img src="/images/icon/a3.png" alt=""> Swimming Pool</li>
												<li><img src="/images/icon/a2.png" alt=""> Bar</li>
												<li><img src="/images/icon/a5.png" alt=""> Bathroom</li>
												<li><img src="/images/icon/a6.png" alt=""> TV</li>
											</ul>
										</div> <span class="home-list-pop-rat list-rom-pric">$620</span>
										<div class="list-enqu-btn">
											<ul>
												<li><a href="#!"><i class="fa fa-usd" aria-hidden="true"></i> Get Quotes</a> </li>
												<li><a href="#!"><i class="fa fa-commenting-o" aria-hidden="true"></i> Send SMS</a> </li>
												<li><a href="#!"><i class="fa fa-phone" aria-hidden="true"></i> Call Now</a> </li>
												<li><a href="#!"><i class="fa fa-usd" aria-hidden="true"></i> Book Now</a> </li>
											</ul>
										</div>
									</div>
								</div>
								<div class="home-list-pop list-spac list-spac-1 list-room-mar-o">
									<!--LISTINGS IMAGE-->
									<div class="col-md-3"> <img src="/assets/images/listing/1.jpg" alt=""> </div>
									<!--LISTINGS: CONTENT-->
									<div class="col-md-9 home-list-pop-desc inn-list-pop-desc list-room-deta"> <a href="#!"><h3>Normal Rooms(Executive)</h3></a>
										<div class="list-rat-ch list-room-rati"> <span>3.0</span> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> </div>
										<div class="list-room-type list-rom-ami">
											<ul>
												<li>
													<p><b>Amenities:</b> </p>
												</li>
												<li><img src="/images/icon/a7.png" alt=""> Wi-Fi</li>
												<li><img src="/images/icon/a4.png" alt=""> Air Conditioner </li>
												<li><img src="/images/icon/a3.png" alt=""> Swimming Pool</li>
												<li><img src="/images/icon/a2.png" alt=""> Bar</li>
											</ul>
										</div> <span class="home-list-pop-rat list-rom-pric">$420</span>
										<div class="list-enqu-btn">
											<ul>
												<li><a href="#!"><i class="fa fa-usd" aria-hidden="true"></i> Get Quotes</a> </li>
												<li><a href="#!"><i class="fa fa-commenting-o" aria-hidden="true"></i> Send SMS</a> </li>
												<li><a href="#!"><i class="fa fa-phone" aria-hidden="true"></i> Call Now</a> </li>
												<li><a href="#!"><i class="fa fa-usd" aria-hidden="true"></i> Book Now</a> </li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					
						
						<?php if(settings_item('lst.allow_review') == 1):?>
						<!--LISTING DETAILS: LEFT PART 6-->
						<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-rew">
							<div class="pglist-p-com-ti">
								<h3><?php echo lang('post_review');?></h3> </div>
							<div class="list-pg-inn-sp">
								<div class="list-pg-write-rev">
								<?php if(!$this->auth->is_logged_in() && settings_item('lst.loggedin_review_only') == 1):?>
								<?php $this->session->set_userdata('listing_url', $this->uri->segment(2));?>
								<div class="alert alert-info"><?php echo lang('error_loggedin_review_only') . ' <a href="' .site_url('login') .'"><strong>Click Here</strong></a> to login.';?></div>
								<?php else:?>
								<div id="reviewMessage"></div>
									<form role="form" id="commentForm">
										<div class="form-group has-feedback">
											<label class="control-label" for="review_title"><?php echo lang('label_title');?>*</label> <input
												type="text" class="form-control input-sm" id="review_title"
												name="review_title" placeholder="<?php echo lang('placeholder_title');?>" maxlength="100"/> <span
												class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_title'));?></span>
										</div>

										<div class="form-group has-feedback">
											<label class="control-label" for="review_message"><?php echo lang('label_review');?>*</label>
											<textarea rows="5" cols="30" class="form-control input-sm"
												id="review_message" name="review_message"
												placeholder="<?php echo lang('placeholder_review');?>" maxlength="2000"></textarea>
											<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_review'));?></span>
										</div>
										
										<?php if($this->session->userdata('user_id')): ?>
												<input type="hidden" id="user_name" name="user_name"
											value="<?php echo $this->session->userdata('user_id') ? $user_info->display_name : '';?>"
											class="optional" />
										<?php else: ?>
										<div class="form-group has-feedback">
											<label class="control-label" for="user_name"><?php echo lang('label_name');?>*</label> <input
												type="text" class="form-control input-sm" id="user_name"
												name="user_name" placeholder="<?php echo lang('placeholder_name');?>"
												value="<?php echo set_value('user_name', $this->session->userdata('user_id') ? $user_info->display_name : ''); ?>" />
											<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_name'));?></span>
										</div>	
										<?php ?>
										<?php endif;?>													
									
										<div class="row">
											<div class="col-7 col-md-7 col-lg-7">
												<div class="form-group has-feedback">
													<label class="control-label" for="review_captcha_code"><?php echo lang('label_captcha');?>*</label> 
													<input type="text"
														class="form-control input-sm" name="review_captcha_code"
														id="review_captcha_code"
														placeholder="<?php echo lang('placeholder_captcha');?>" /> <span
														class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
												</div>
												<span class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
											</div>
											<div class="col-5 col-md-5 col-lg-5" style="padding-top: 20px;">
												<img class="img-thumbnail" id="review_captcha"
													src="<?php echo site_url("securimage"); ?>"
													alt="CAPTCHA Image" /> <a id="review_update" href="#"
													onclick="document.getElementById('review_captcha').src = '<?php echo site_url("securimage?"); ?>' + Math.random(); return false"><i
													class="glyphicon glyphicon-refresh"></i></a>
											</div>
										</div>
										<button type="submit" id="commentSubmit"
											class="btn btn-primary btn-sm" data-loading-text="Sending..."
											style="display: block; margin-top: 10px;"><?php echo lang('form_submit');?></button>
									</form>
									<?php endif;?>
								</div>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 6-->


						




						<!--LISTING DETAILS: LEFT PART 5-->
						<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-rer">
							<div class="pglist-p-com-ti">
								<h3><span>User</span> Reviews</h3> </div>
							<div class="list-pg-inn-sp">
								<div class="lp-ur-all">
									
									<div class="lp-ur-all-right">
										<h5>Overall Ratings</h5>
										<p><span><?php echo isset($ratings->average_rating) ? sprintf('%0.1f', $ratings->average_rating) : ''; ?><i class="fa fa-star" aria-hidden="true"></i></span> based on <?php echo $ratings->total_users; ?> reviews</p>
									</div>
								</div>
								<div class="lp-ur-all-rat">
									<h5><span><?php echo lang('reviews_of')?></span><?php echo $listing->title .' ' .$listing->city;?></h5>
									<ul>
										<?php if ($comments) :
											foreach ( $comments as $comment ) : ?>
											<li>
												<div class="lr-user-wr-img"> <img src="/images/users/2.png" alt=""> </div>
												<div class="lr-user-wr-con">
													<h6><?php echo $comment->comment_title;?> by <?php echo $comment->username;?></h6> <span class="lr-revi-date"><?php echo $comment->created_on;?></span>
													<p><?php echo $comment->comment;?></p>
												</div>
											</li>
										<?php endforeach; else : // reviews does not exist		?>
											<div class="alert alert-info"><?php echo lang('error_no_review');?></div>
										<?php endif; ?>
									</ul>
								</div>
							</div>
						</div>
				<?php endif;?>
					<!--END LISTING DETAILS: LEFT PART 5-->

					<!--claim report-->
						<div class="pglist-p3 pglist-bg pglist-p-com" id="claim">
							<div class="pglist-p-com-ti">
								<h3><?php echo lang('claim_report');?></h3> </div>
							<div class="list-pg-inn-sp">
								<div class="list-pg-write-rev">
								<div id="claim_report_form" class="row">
						<div class="col-12 col-sm-12 col-lg-12">
							<div id="claimMessage"></div>
							<form role="form" id="claimReportForm">
								<div class="form-group has-feedback">
									<label class="control-label" for="claim_report_type"><?php echo lang('claim_report_type');?>*</label> 
									<select name="claim_report_type" class="" size="1">
										<option value="1"><?php echo lang('claim_option_first');?></option>
										<option value="2"><?php echo lang('claim_option_second');?></option>
										<option value="3"><?php echo lang('claim_option_third');?></option>
										<option value="4"><?php echo lang('claim_option_fourth');?></option>
										<option value="5"><?php echo lang('claim_option_fifth');?></option>
									</select>
								</div>
								<div class="form-group has-feedback">
									<label class="control-label" for="claim_report_description"><?php echo lang('label_description');?>*</label>
									<textarea rows="5" cols="s" class="form-control input-sm"
										id="claim_report_description" name="claim_report_description"
										placeholder="<?php echo lang('placeholder_description');?>"></textarea>
									<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_description'));?></span>
								</div>								
								<?php if($this->session->userdata('user_id')): ?>
									<input type="hidden" id="claim_report_name"
									name="claim_report_name"
									value="<?php echo $this->session->userdata('user_id') ? $user_info->display_name : '';?>"
									class="optional" /> <input type="hidden"
									id="claim_report_email" name="claim_report_email"
									value="<?php echo $this->session->userdata('user_id') ? $user_info->email : '';?>"
									class="optional" />
								<?php else :?>
								<div class="row">
									<div class="col-6 col-sm-6 col-lg-6">
										<div class="form-group has-feedback">
											<label class="control-label" for="claim_report_name"><?php echo lang('label_name');?></label>
											<input type="text" class="form-control input-sm"
												id="claim_report_name" name="claim_report_name"
												placeholder="<?php echo lang('placeholder_name');?>" /> <span class="help-block"
												style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_name'));?></span>
										</div>
									</div>
									<div class="col-6 col-sm-6 col-lg-6">
										<div class="form-group has-feedback">
											<label class="control-label" for="claim_report_email"><?php echo lang('label_email');?></label> <input type="email"
												class="form-control input-sm" id="claim_report_email"
												name="claim_report_email" placeholder="<?php echo lang('placeholder_email');?>" />
											<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_email'));?></span>
										</div>
									</div>
								</div>
								<?php endif;?>
								<div class="row">
									<div class="col-5 col-sm-5 col-lg-5">
										<div class="form-group has-feedback">
											<label class="control-label" for="claim_report_phone"><?php echo lang('label_phone');?></label>
											<input type="tel" class="form-control input-sm optional"
												id="claim_report_phone" name="claim_report_phone"
												placeholder="<?php echo lang('placeholder_phone');?>" /> <span
												class="help-block" style="display: none;"><?php echo lang('error_mobile');?></span>
										</div>
									</div>
									<div class="col-7 col-sm-7 col-lg-7">
										<div class="row">
											<div class="col-7 col-md-7 col-lg-7">
												<div class="form-group has-feedback">
													<label class="control-label"
														for="claim_report_captcha_code"><?php echo lang('label_captcha');?></label>
													<input type="text" class="form-control input-sm"
														name="claim_report_captcha_code"
														id="claim_report_captcha_code"
														placeholder="<?php echo lang('placeholder_captcha');?>" /> <span
														class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
												</div>
												<span class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
											</div>
											<div class="col-5 col-md-5 col-lg-5" style='padding-top:15px;'>
												<img class="img-thumbnail" id="claim_report_captcha"
													src="<?php echo site_url("securimage"); ?>"
													alt="CAPTCHA Image" /> <a id="claim_report_update" href="#"
													onclick="document.getElementById('claim_report_captcha').src = '<?php echo site_url("securimage?"); ?>' + Math.random(); return false"><i
													class="glyphicon glyphicon-refresh"></i></a>
											</div>
										</div>
									</div>
								</div>
								<button type="submit" id="claimReportSubmit"
									class="btn btn-primary btn-sm" data-loading-text="Sending..."
									style="display: block; margin-top: 10px;"><?php echo lang('form_submit');?></button>
							</form>
							<!-- end form -->
						</div>
						<!-- end col span 12 -->
					</div>
								</div>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 6-->

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
	<section>
		<!-- GET QUOTES POPUP -->
		<div class="modal fade dir-pop-com" id="list-quo" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header dir-pop-head">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h4 class="modal-title">Ask Query</h4>
						<div id="businessFormMessage"></div>
						<!--<i class="fa fa-pencil dir-pop-head-icon" aria-hidden="true"></i>-->
					</div>
					<div class="modal-body dir-pop-body">
						<form method="post" id="businessQueryForm">
							<div class="form-group has-feedback">
								<label class="control-label" for="message"><?php echo lang('label_message');?>*</label>
								<textarea rows="5" cols="30" class="form-control input-sm"
									id="message" name="message" placeholder="<?php echo lang('placeholder_message');?>"></textarea>
								<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_message'));?></span>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-lg-12">
									<div class="form-group has-feedback">
										<label class="control-label" for="name"><?php echo lang('label_name');?>*</label> <input
											type="text" class="form-control input-sm" id="name"
											name="name" placeholder="<?php echo lang('placeholder_name');?>" /> <span
											class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_name'));?></span>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-lg-12">
									<div class="form-group has-feedback">
										<label class="control-label" for="phone"><?php echo lang('label_phone');?></label> <input
											type="tel" class="form-control input-sm optional" id="phone"
											name="phone" placeholder="<?php echo lang('placeholder_phone');?>" /> <span
											class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_phone'));?></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-12 col-lg-12">
									<div class="form-group has-feedback">
										<label class="control-label" for="email"><?php echo lang('label_email');?></label>
										<input type="email" class="form-control input-sm" id="email"
											name="email" placeholder="<?php echo lang('placeholder_email');?>" /> <span
											class="help-block" style="display: none;"><?php echo lang('error_message_email');?></span>
									</div>
								</div>
								<div class="col-12 col-sm-12 col-lg-12">
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
										<div class="col-5 col-md-5 col-lg-5">
											<img class="img-thumbnail" id="captcha"
												src="<?php echo site_url("securimage"); ?>"
												alt="CAPTCHA Image" /> <a id="update" href="#"
												onclick="document.getElementById('captcha').src = '<?php echo site_url("securimage?"); ?>' + Math.random(); return false"><i
												class="glyphicon glyphicon-refresh"></i></a>
										</div>
									</div>
								</div>
							</div>
							<button type="submit" id="feedbackSubmit"
								class="btn btn-primary btn-sm" data-loading-text="Sending..."
								style="display: block; margin-top: 10px;"><?php echo lang('business_query');?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- GET QUOTES Popup END -->
	</section>
