
<!-- row 3: article/aside -->
<div class="row">
	<div class="col-lg-8 col-sm-7">
		<div class="row"><!-- breadcrumb row -->
			<div class="col-sm-12">
			<!-- Breadcrumb Navigation -->
			<ol class="breadcrumb hidden-xs">
				<li><a href="<?php echo site_url(); ?>"><?php echo lang('detail_home');?></a> <span class="glyphicon glyphicon-circle-arrow-right"></span></li>
				<?php if(!empty($categories->parent_id)):?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php echo '<a href="' . site_url() .'category/' .$categories->parent_slug .'-' .$categories->parent_id . '" itemprop="url"><span itemprop="title">' . $categories->parent_category .'</span></a> <span class="glyphicon glyphicon-circle-arrow-right"></span>'?></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php echo '<a href="' . site_url() .'category/' .$categories->sub_slug .'-' .$categories->sub_id . '" itemprop="url"><span itemprop="title">' . $categories->sub_category .'</span></a> <span class="glyphicon glyphicon-circle-arrow-right"></span>'?></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php echo '<a href="' . site_url() .'category/' .$categories->subsub_slug .'-' .$categories->subsub_id . '" itemprop="url"><span itemprop="title">' . $categories->subsub_category .'</span></a>'?></li>
				<?php elseif(!empty($categories->sub_id)):?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php echo '<a href="' . site_url() .'category/' .$categories->sub_slug .'-' .$categories->sub_id . '" itemprop="url"><span itemprop="title">' . $categories->sub_category .'</span></a> <span class="glyphicon glyphicon-circle-arrow-right"></span>'?></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php echo '<a href="' . site_url() .'category/' .$categories->subsub_slug .'-' .$categories->subsub_id . '" itemprop="url"><span itemprop="title">' . $categories->subsub_category .'</span></a>'?></li>
				<?php else:?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php echo '<a href="' . site_url() .'category/' .$categories->subsub_slug .'-' .$categories->subsub_id . '" itemprop="url"><span itemprop="title">' . $categories->subsub_category .'</span></a>'?></li>
				<?php endif;?>				
			</ol>
			</div><!-- end of col-sm-12 -->
		</div><!-- end of breadcrumb -->
		<!-- End of Breadcrumb Navigation -->
		<div class="row"><!-- tabs row -->	
		<div class="col-sm-12"><!-- tabs col-sm-12 -->
		<?php echo Template::message(); ?>
		<?php
		if ($listing) : // listing exist
			echo form_hidden ( 'listing_id', $listing->id );
		?>
		<!-- List navigation for tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#home" data-toggle="tab"><span
					class="glyphicon glyphicon-home"></span><?php echo lang('detail_home');?></a></li>
			<?php if ($products_count > 0): ?>
			<li><a href="#products" data-toggle="tab"><span
					class="glyphicon glyphicon-shopping-cart"></span><?php echo lang('detail_products');?></a></li>
			
			<?php endif;
			if ($services_count > 0) :
				?>
			<li><a href="#services" data-toggle="tab"><span
					class="glyphicon glyphicon-th-large"></span><?php echo lang('detail_services');?></a></li>
			<?php endif; ?>
			<?php if($images):?>
			<li><a href="#gallery" data-toggle="tab"><span
					class="glyphicon glyphicon-film"></span><?php echo lang('detail_gallery');?></a></li>
			<?php endif;?>	
			<?php if($classifieds):?>	
			<li><a href="#classifieds" data-toggle="tab"><span
					class="glyphicon glyphicon-bullhorn"></span><?php echo lang('detail_classifieds');?></a></li>
			<?php endif;?>
			<li><a href="#query" data-toggle="tab"><span
					class="glyphicon glyphicon-envelope"></span><?php echo lang('business_query');?></a></li>
		</ul>

		<!-- Text for each callout -->
		<!-- Home -->
		<div class="tab-content">
			<div class="tab-pane fade active in" id="home">
			<div itemscope itemtype="http://schema.org/Organization"> 
			<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
				<div class="row row-spaced">
					<div class="col-md-6 col-sm-12">
						<?php if($package->logo == 1):?>
						<div class="row">
							<div class="col-sm-12">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width: 415px; max-height: 292px;">
								<?php if($listing->logo_url) {?>
									<?php $regexp =  "/((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i";
									if(preg_match($regexp, $listing->logo_url)) {?>
									<?php if(mb_strimwidth($listing->logo_url, 0, 3, "") == "www") { ?>
									<img src="<?php echo 'http://'.$listing->logo_url; ?>" alt="<?php echo $listing->title;?>" title="<?php echo $listing->title;?>" />				
									<?php } else { ?>
									<img src="<?php echo $listing->logo_url; ?>" alt="<?php echo $listing->title;?>" title="<?php echo $listing->title;?>" />
									<?php }} else {?>
									<img src="<?php echo base_url(); ?>assets/images/logo/<?php echo $listing->logo_url; ?>" alt="<?php echo $listing->title;?>" title="<?php echo $listing->title;?>" />
									<?php }?>
								<?php } else {?>
								<img src="<?= base_url(); ?>assets/images/no-logo.png" alt="<?php echo $listing->title;?>" title="<?php echo $listing->title;?>" />
								<?php }?>							
								</div>
							</div>												
						</div>
						<?php endif;?>
						<div class="row">
							<div class="col-sm-12">
								<div id="listing_rating" class="stars">
									<div class='controls'>
										<input id="input-ratings" type="number"
											value="<?php echo isset($ratings->average_rating) ? $ratings->average_rating : ''; ?>"
											class="rating" min=0 max=5 step=0.5 data-show-clear="false"
											data-size="sm" />
									</div>
									<div id="rating_feedback"></div>
								</div>
								<?php if($ratings): //rating exist?>
								<small class="text-muted"><span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating"><span itemprop="average"><?php echo $ratings->average_rating; ?></span>
									<?php echo lang('label_ratings');?> <span itemprop="votes"><?php echo $ratings->total_users; ?></span></span>
									<?php echo lang('label_users_rated');?></small>
								<?php endif;?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<span itemprop="name"><span itemprop="itemreviewed">
									<h1 class="panel-title"><?php echo $listing->title;?></h1>
								</span></span>
							</div>

							<ul class="list-group">
								<?php if(($package->address == 1) && ($listing->address)):?>
								<li itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="list-group-item"><span itemprop="streetAddress"><?php echo $listing->address . '</span><br /><span itemprop="addressLocality">' . $listing->city . '</span> ' . $listing->pincode . '<br /><span itemprop="addressRegion">' . $listing->state . '</span> ' . ucwords(strtolower($listing->country));?></span></li>
								<?php endif;?>
								<?php if(($package->person  == 1) && ($listing->contact_person)):?>
								<li class="list-group-item"><span
									class="glyphicon glyphicon glyphicon-user"></span><span>
										<?php echo $listing->contact_person;?></span></li>
								<?php endif;?>
								<?php if(($package->phone == 1) && (!empty($listing->mobile_number) || !empty($listing->phone_number))):?>
								<li class="list-group-item">								
									<span class="glyphicon glyphicon-earphone"></span>
									<span>
									<?php 
										 if(isset($listing->mobile_number) && isset($listing->phone_number)) {
										 	echo $listing->mobile_number . ', <span itemprop="telephone">' . $listing->phone_number .'</span>';
										} elseif ($listing->mobile_number) {
											echo '<span itemprop="telephone">' . $listing->mobile_number .'</span>';
										} else { echo '<span itemprop="telephone">' . $listing->phone_number .'</span>'; }
									?>
									</span>
									</li>
								<?php endif;?>
								<?php if(($package->email == 1) && ($listing->email)):?>
								<li class="list-group-item"><span
									class="glyphicon glyphicon-envelope"></span><span>
										<?php echo $listing->email;?></span></li>
								<?php endif;?>
								<?php if((($package->website == 1) && ($listing->website)) || ((!empty($listing->facebook_url)) || (!empty($listing->twitter_url)) || (!empty($listing->googleplus_url)))):?>
								<li class="list-group-item">
									<?php if(($package->website == 1) && ($listing->website)):?>
									<span class="glyphicon glyphicon-globe"></span>
									<?php if(mb_strimwidth($listing->website, 0, 3, "") == "www") { ?>
									<a href="<?php echo 'http://'.$listing->website;?>" itemprop="url" rel="nofollow" target="_blank"><?php echo $listing->website;?></a>
									<?php } else {?>
									<a href="<?php echo $listing->website;?>" itemprop="url" rel="nofollow" target="_blank"><?php echo $listing->website;?></a>
									<?php } ?>
									<?php endif;?>
									<?php if((settings_item('lst.allow_facebook_url') == 1) || (settings_item('lst.allow_twitter_url') == 1) || (settings_item('lst.allow_googleplus_url') == 1)):?>
									<ul class="social <?php echo (($package->website == 1) && ($listing->website)) ? 'pull-right' : ''; ?>">
										<?php if(!empty($listing->facebook_url)):?>
									  	<li class="facebook"><a href="<?php echo $listing->facebook_url; ?>" rel="nofollow" data-toggle="tooltip" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
									  	<?php endif;?>
									  	<?php if(!empty($listing->twitter_url)):?>
			                		    <li class="twitter"><a href="<?php echo $listing->twitter_url; ?>" rel="nofollow" data-toggle="tooltip" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
			                		    <?php endif;?>
			                		    <?php if(!empty($listing->googleplus_url)):?>
			                		    <li class="gplus"><a href="<?php echo $listing->googleplus_url; ?>" rel="nofollow" data-toggle="tooltip" title="Google Plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
			                		    <?php endif;?>
			                		</ul>			
									<?php endif;?>
									</li>
								<?php endif;?>
							</ul>
						</div>
					</div>
				</div>
				<?php if($listing->description):?>
				<!-- Business description -->
				<div class="row">
					<div class="col-md-2 col-sm-4">
						<strong><?php echo lang('detail_description');?>:</strong>
					</div>
					<div class="col-md-10 col-sm-8"><span itemprop="description"><?php echo $listing->description;?></span></div>
				</div>
				<!-- End of business description -->
				<?php endif;?>
				<?php if($listing->tags):?>
				<!-- Tags -->
				<div class="row top2">
					<div class="col-md-2 col-sm-4">
						<strong><?php echo lang('detail_provides');?>:</strong>
					</div>
					<div class="col-md-10 col-sm-8"><?php echo $listing->tags?></div>
				</div>
				<!-- End of Tags -->
				<?php endif;?>
				<div class="row">
				<?php if($package->map == 1): ?>
					<div class="col-sm-12">
				<?php if($listing->latitude && $listing->longitude): //Map Exist?>
				<!-- Google Map -->
				<?php echo $map['js']; ?>
					<div id="map_canvas" style="width: 100%; height: 300px;"></div>
				<?php else:?>
					<address><?php echo $listing->address . ' ' . $listing->city . ', ' . $listing->state . ' ' . $listing->pincode . ' ' . ucwords(strtolower($listing->country)); ?></address>
				<!-- End of Google Map -->
				<?php endif; ?>				
					</div><!-- End of Google Map Column -->
				<?php endif; ?>					
				</div>
			</div>
			</div>
			</div><!-- end of home -->

			<!-- Products -->
			<div class="tab-pane fade" id="products">
			<?php if(!empty($products)): foreach($products as $product): ?>
			<?php if($product->type == 'product'): ?>
			<h3><?php echo $product->title; ?>
			<?php if($product->price):?>				 
					<span class="btn btn-primary btn-small pull-right"><span
						class="glyphicon glyphicon-tag"></span>
						<?php echo '<strong>Price:</strong> ' .settings_item('site.currency') .$product->price;?>
					</span>
					<!-- end of button -->
					<?php endif;?>				
			</h3>
				<hr>
			<?php if($product->image): ?> 
				<div class="gallery">
					<ul class="thumbnails">
						<li class="col-sm-6"><a class="thumbnail" rel="lightbox[group]"
							href="<?php echo base_url();?>assets/images/products/<?php echo $product->image; ?>"><img
								class="group1"
								src="<?php echo base_url();?>assets/images/products/<?php echo $product->image; ?>"
								title="<?php echo $product->title;?>"
								alt="<?php echo $product->title;?>" /></a></li>
						<!--end thumb -->
					</ul>
				</div>
			<?php endif;?>
			<?php echo $product->description; ?>
			<?php endif; endforeach; endif; ?>
			</div>
			<!-- End of Products -->



			<!-- Services -->
			<div class="tab-pane fade" id="services">
			<?php if(!empty($products)): foreach($products as $product): ?>
			<?php if($product->type == 'service'): ?>
			<h3><?php echo $product->title; ?>
			<?php if($product->price):?>				 
					<span class="btn btn-primary btn-small pull-right"><span
						class="glyphicon glyphicon-tag"></span>
						<?php echo '<strong>Price:</strong> ' .settings_item('site.currency') .$product->price;?>
					</span>
					<!-- end of button -->
					<?php endif;?>				
			</h3>
				<hr>
			<?php if($product->image): ?> 
				<div class="gallery">
					<ul class="thumbnails">
						<li class="col-sm-6"><a class="thumbnail" rel="lightbox[group]"
							href="<?php echo base_url();?>assets/images/products/<?php echo $product->image; ?>"><img
								class="group1"
								src="<?php echo base_url();?>assets/images/products/<?php echo $product->image; ?>"
								title="<?php echo $product->title;?>"
								alt="<?php echo $product->title;?>" /></a></li>
						<!--end thumb -->
					</ul>
				</div>
			<?php endif;?>
			<?php echo $product->description; ?>
			<?php endif; endforeach; endif; ?>
			</div>
			<!-- End of Services -->
			<?php if ((isset($images) && count($images)) || !empty($videos)):?>			
			<!-- Gallery -->
			<div class="tab-pane fade" id="gallery">
				<div class="row">
					<div class="gallery">
						<?php if(!empty($images)):?>
						<ul class="thumbnails">						
							<?php foreach($images as $image): ?>
							<li class="col-sm-3 bottom2"><a class="thumbnail" rel="lightbox[group]"
								href="<?php echo base_url();?>assets/images/photos/<?php echo $image->url; ?>"><img
									class="group1"
									src="<?php echo base_url();?>assets/images/photos/<?php echo $image->url; ?>"
									<?php if(!empty($image->title)): ?>
									title="<?php echo $image->title;?>"
									alt="<?php echo $image->title;?>" <?php endif; ?> /></a></li>
							<!--end thumb -->							
							<?php endforeach; //end thumbnails?>
							<!--end thumb -->
						</ul>
						<!--end thumbnails -->
						<?php endif;?>
						<?php if(!empty($videos)):?>
						<h2><?php echo lang('label_video_gallery');?></h2>
						<ul class="thumbnails">						
									<?php foreach($videos as $video): ?>
									<li class="col-sm-3"><a class="thumbnail" rel="lightbox[group]"
								href="https://www.youtube.com/watch?v=<?php echo $video->url;?>"><img
									class="group1"
									src="http://img.youtube.com/vi/<?php echo $video->url;?>/0.jpg"
									title="<?php echo $video->title;?>"
									alt="<?php echo $video->title;?>" /></a></li>
							<!--end thumb -->							
									<?php endforeach; //end thumbnails?>
									<!--end thumb -->
						</ul>
						<!--end thumbnails -->
					<?php endif; //end video gallery?>
					</div>
					<!-- end gallery -->
				</div>
				<!-- end row -->
			</div>							
			<?php endif; //end image gallery?>
			<?php if($classifieds):?>
			<!-- Classifieds -->
			<div class="tab-pane fade" id="classifieds">
			<?php foreach($classifieds as $classified): ?>
			<h3><?php echo $classified->title; ?>
			<?php if($classified->price):?>				 
					<span class="btn btn-primary btn-small pull-right"><span
						class="glyphicon glyphicon-tag"></span>
						<?php echo '<strong>'.lang('classifieds_price').':</strong> ' .settings_item('site.currency') .$classified->price;?>
					</span>
					<!-- end of button -->
					<?php endif;?>				
			</h3>
				<hr>
				<div class="row">
					<div class="col-sm-7">
			<?php if($classified->image): ?> 
				<div class="gallery">
							<ul class="thumbnails">
								<li class="col-sm-12"><a class="thumbnail" rel="lightbox[group]"
									href="<?php echo base_url();?>assets/images/classifieds/<?php echo $classified->image; ?>"><img
										class="group1"
										src="<?php echo base_url();?>assets/images/classifieds/<?php echo $classified->image; ?>"
										title="<?php echo $classified->title;?>"
										alt="<?php echo $classified->title;?>" /></a></li>
								<!--end thumb -->
							</ul>
						</div>
			<?php else:?>
				<div class="thumbnail">
							<img src="<?php echo base_url();?>assets/images/no-image.png"
								title="<?php echo $classified->title;?>"
								alt="<?php echo $classified->title;?>" />
						</div>
			<?php endif;?>
			</div>
					<div class="col-sm-5">
						<h4><?php echo lang('classifieds_overview');?></h4>
						<hr>
			<?php if($classified->from) :?>
				<div>
							<strong><?php echo lang('classifieds_from');?>: </strong><?php echo $classified->from; ?></div>
			
				<?php endif;
				if ($classified->to) :
					?>
				<div>
							<strong><?php echo lang('classifieds_to');?>: </strong><?php echo $classified->to; ?></div>
			
				<?php endif;
				if ($classified->url) :
					?>
				<div>
							<strong><?php echo lang('classifieds_buy');?>: </strong><?php echo $classified->url; ?></div>
			<?php endif;?>
			</div>
				</div>
				<h4><?php echo lang('detail_description');?></h4>
				<hr>
			<?php echo $classified->description; ?>
			<?php endforeach; ?>			
			</div>
			<!-- end of classifieds -->
			<?php endif; ?>
			<!-- Query -->
			<div class="tab-pane fade" id="query">
				<div id="contact_form" class="row">
					<div class="col-12 col-sm-12 col-lg-12">
						<h2><?php echo lang('query_heading');?></h2>
						<p><?php echo lang('query_summary');?></p>
						<div id="businessFormMessage"></div>
						<form role="form" id="businessQueryForm">
							<div class="form-group has-feedback">
								<label class="control-label" for="message"><?php echo lang('label_message');?>*</label>
								<textarea rows="5" cols="30" class="form-control input-sm"
									id="message" name="message" placeholder="<?php echo lang('placeholder_message');?>"></textarea>
								<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_message'));?></span>
							</div>
							<div class="row">
								<div class="col-6 col-sm-6 col-lg-6">
									<div class="form-group has-feedback">
										<label class="control-label" for="name"><?php echo lang('label_name');?>*</label> <input
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
											class="help-block" style="display: none;"><?php echo lang('error_message_email');?></span>
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
					<!--/span-->
				</div>
				<!--/row-->
			</div>

		</div>
<?php else: //listing does not exist?>
    <div class="alert alert-info"><?php echo lang('error_not_exist');?>
		</div>
<?php endif; ?>
</div><!-- end of tabs col-sm-12 -->
</div><!-- end of tabs row -->
<!-- Leaderboard Banner -->		
		 <?php if($banners): $i = 0;?>
		 <?php foreach ($banners as $banner):?>
		 <?php if((($banner['width'] == 728) && ($banner['height'] == 90)) && ($banner['location'] == 'bottom') || ($banner['location'] == 'top')):?>
		  <?php if(++$i > 1) break; //display only two banners?>
			<div class="row top2 hidden-xs">
			<div class="col-sm-12"><!-- leaderboard col-sm-12 -->
				<div class="panel panel-default">
					<div class="panel-body">
						<?php switch ($banner ['type']) {
							case 'image' : ?>
			 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img class="img-responsive center-block"
			 					id="<?php echo $banner['id'];?>" class="banner"
								src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
								title="<?php echo $banner['title'];?>"
								alt="<?php echo $banner['title'];?>" /></a>
					<?php break; ?>
					<?php case 'text' :
								echo htmlspecialchars($banner ['html_text']);
								break;
						} ?>
						</div> <!-- end of panel-body -->
				</div><!-- end of panel -->
				</div><!-- end of leaderboard col-sm-12 -->
			</div><!-- end of row -->
		<?php endif;?>
		<?php endforeach; ?>
		<?php endif; ?>
		<!-- End of Leaderboard Banner -->
		<?php if(!empty($listing)): //listing exist; display share and review information?>
		<?php if((settings_item('lst.allow_email') == 0) && (settings_item('lst.allow_print') == 0)):?>
		<?php else:?>
		<!-- Send this information -->
		<div class="row top2">
			<div class="col-sm-2 clearfix">
				<strong><?php echo lang('share_info');?>:</strong>
			</div>
			<?php if(settings_item('lst.allow_email') == 1):?>
			<div class="col-sm-5">
				<a href="#sendEmailModal" role="button" class="btn btn-info"
					data-toggle="modal"> <span class="glyphicon glyphicon-envelope"></span>
					<?php echo lang('send_email');?>
				</a>
			</div>
			<?php endif;?>
			<?php if(settings_item('lst.allow_print') == 1):?>
			<div class="col-sm-5">
			<?php echo anchor('createPDF/'.$listing->slug. '-in-' .strtolower(str_replace(" ","-", $listing->city)) .'-' .$listing->id, '<span class="glyphicon glyphicon-print"></span> '.lang('print_info').'', 'class="btn btn-warning"'); ?>			
			</div>
			<?php endif;?>
		</div>
		<!-- End of send information -->
		<?php endif;?>
		<?php if(settings_item('lst.allow_email') == 1):?>
		<!-- Send Email Form -->
		<div class="modal fade" id="sendEmailModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><?php echo lang('send_email_heading');?></h4>
					</div>
					<!-- end modal-header -->
					<form role="form" id="sendEmailForm">
					<div class="modal-body">
						<p>
							<small class="text-muted"><?php echo lang('form_heading_title');?></small>
						</p>
						<div id="emailAlert"></div>
						<div id="sendEmail_form" class="row">
							<div class="col-12 col-sm-12 col-lg-12">								
									<div class="form-group has-feedback">
										<label class="control-label" for="email_to"><?php echo lang('label_friends_email');?></label> <input
											type="email" class="form-control input-sm" id="email_to"
											name="email_to" placeholder="<?php echo lang('placeholder_friends_email');?>" /> <span
											class="help-block" style="display: none;"><?php echo lang('error_email');?></span>
									</div>
									<div class="row">
										<div class="col-6 col-sm-6 col-lg-6">
											<div class="form-group has-feedback">
												<label class="control-label" for="email_from"><?php echo lang('label_your_email');?></label>
												<input type="email" class="form-control input-sm"
													id="email_from" name="email_from"
													placeholder="<?php echo lang('placeholder_email');?>"
													value="<?php echo $this->session->userdata('user_id') ? $user_info->email : '';?>" />
												<span class="help-block" style="display: none;"><?php echo lang('error_email');?></span>
											</div>
										</div>
										<div class="col-6 col-sm-6 col-lg-6">
											<div class="form-group has-feedback">
												<label class="control-label" for="email_from_name"><?php echo lang('label_name');?></label>
												<input type="text" class="form-control input-sm"
													id="email_from_name" name="email_from_name"
													placeholder="<?php echo lang('placeholder_name');?>"
													value="<?php echo $this->session->userdata('user_id') ? $user_info->display_name : '';?>" />
												<span class="help-block" style="display: none;"><?php echo sprintf(lang('error_message'), lang('label_name'));?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-7 col-md-7 col-lg-7">
											<div class="form-group has-feedback">
												<label class="control-label" for="email_captcha_code"><?php echo lang('label_captcha');?></label> <input type="text"
													class="form-control input-sm" name="email_captcha_code"
													id="email_captcha_code"
													placeholder="<?php echo lang('placeholder_captcha');?>" /> <span
													class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
											</div>
											<span class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
										</div>
										<div class="col-5 col-md-5 col-lg-5">
											<img class="img-thumbnail" id="email_captcha"
												src="<?php echo site_url("securimage"); ?>"
												alt="CAPTCHA Image" /> <a id="email_update" href="#"
												onclick="document.getElementById('email_captcha').src = '<?php echo site_url("securimage?"); ?>' + Math.random(); return false"><i
												class="glyphicon glyphicon-refresh"></i></a>
										</div>
									</div>
							</div>
							<!--/span-->
						</div>
						<!--/row-->
					</div>
					<!-- end modal-body -->
					<div class="modal-footer">
									<button type="submit" id="sendEmail" class="btn btn-primary"
											data-loading-text="Sending..." type="button"><?php echo lang('form_submit');?></button>
									<button class="btn btn-default" data-dismiss="modal" type="button"><?php echo lang('form_close');?></button>
																			
					</div><!-- end of modal-footer -->
				</form>
				</div><!-- end modal-content -->
			</div><!-- end modal-dialog -->
		</div>
		<!-- end sendEmail -->
		<!-- End of Send Email Form -->
		<?php endif;?>
		<!-- list navigation for tabs -->
		<div class="row top2 bottom2">
		<div class="col-sm-12">
			<ul class="nav nav-tabs">
				<?php if(settings_item('lst.allow_review') == 1):?>
				<li class="active"><a href="#reviews" data-toggle="tab"><span
						class="glyphicon glyphicon-comment"></span><?php echo lang('all_review');?></a></li>
				<li><a href="#postreview" data-toggle="tab"><span
						class="glyphicon glyphicon-share"></span><?php echo lang('post_review');?></a></li>
				<?php endif;?>
				<li <?php if(settings_item('lst.allow_review') == 0): echo 'class="active"'; endif;?>><a href="#claim" data-toggle="tab"><span
						class="glyphicon glyphicon-warning-sign"></span><?php echo lang('claim_report');?></a></li>
			</ul>

			<!-- text for each callout -->
			<!-- Reviews -->
			<div class="tab-content">
				<?php if(settings_item('lst.allow_review') == 1):?>
				<div class="tab-pane fade active in" id="reviews">
					<p>
						<strong><?php echo lang('reviews_of'). $listing->title .' ' .$listing->city;?></strong>
					</p>						
					<?php if ($comments) :
					foreach ( $comments as $comment ) : ?>
						<div class="row">
						<div class="col-sm-12">
							<span class="pull-left"><strong><?php echo $comment->comment_title;?></strong> by <?php echo $comment->username;?></span><span
								class="pull-right"><small><?php echo $comment->created_on;?></small></span>
						</div>
						<!-- end column -->
					</div>
					<!-- end row -->
					<p><?php echo $comment->comment;?></p>
						<?php endforeach; else : // reviews does not exist		?>
						    <div class="alert alert-info"><?php echo lang('error_no_review');?></div>
						<?php endif; ?>
				</div>
				<!-- end reviews tab pane -->
				<!-- Post Review -->
				<div class="tab-pane fade" id="postreview">
					<div id="review_form" class="row">
					<div class="col-12 col-sm-12 col-lg-12">
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
									<div class="col-5 col-md-5 col-lg-5">
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
						<!--/span-->
					</div>
					<!--/row-->
				</div>
				<?php endif;?>
				<!-- Claim -->
				<div class="tab-pane fade <?php if(settings_item('lst.allow_review') == 0): echo 'active in'; endif;?>" id="claim">
					<div id="claim_report_form" class="row">
						<div class="col-12 col-sm-12 col-lg-12">
							<div id="claimMessage"></div>
							<form role="form" id="claimReportForm">
								<div class="form-group has-feedback">
									<label class="control-label" for="claim_report_type"><?php echo lang('claim_report_type');?>*</label> 
									<select name="claim_report_type"
										class="form-control input-sm" size="1">
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
									<div class="col-6 col-sm-6 col-lg-6">
										<div class="form-group has-feedback">
											<label class="control-label" for="claim_report_phone"><?php echo lang('label_phone');?></label>
											<input type="tel" class="form-control input-sm optional"
												id="claim_report_phone" name="claim_report_phone"
												placeholder="<?php echo lang('placeholder_phone');?>" /> <span
												class="help-block" style="display: none;"><?php echo lang('error_mobile');?></span>
										</div>
									</div>
									<div class="col-6 col-sm-6 col-lg-6">
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
											<div class="col-5 col-md-5 col-lg-5">
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
					<!-- end row -->
				</div>
				<!-- end tab pane claim/report -->
			</div>
			</div><!-- end of review col-sm-12 -->
		</div>
		<!-- end row top2 -->
<?php endif; ?>
</div><!-- end of col-lg-8 -->
		<div class="col-lg-4 col-sm-5 hidden-xs">
		<?php if($banners): $i = 0;?>
		 <?php foreach ($banners as $banner):?>
		 <?php if(((($banner['width'] <= 300) && ($banner['height'] <= 250)) || (($banner['width'] <= 336) && ($banner['height'] <= 280))) && ($banner['location'] == 'right')):?>
		 <?php if(++$i > 2) break; //display only two banners?>		 
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
	<?php switch(settings_item('lst.featured_location')) {
				case 1:
				case 4:
				case 6:
				case 7:
				if($featured_listings):?>
		<div class="row top2"><!-- featured listing -->
		<div class="col-sm-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php echo lang('featured_listings');?></h3>
		  </div>
		    <ul class="list-group">
		  	<?php foreach($featured_listings as $featured):?>
		  	<li class="list-group-item"><span class="glyphicon glyphicon-map-marker pull-left"></span>  	  
		    <h5><a href="<?php echo base_url() .'detail/' .$featured['slug']. '-in-'.strtolower(str_replace(" ","-", $featured['city'])).'-'.$featured['id'];?>"><?php echo $featured['title'];?></a></h5>
		    <?php if($featured['isAddress'] == 1): ?>
		    <p><?php echo $featured['address'].'<br />'.$featured['city']. ' ' .$featured['pincode']. '<br />' .$featured['state'].', ' .ucwords(strtolower($featured['country']));?></p>
		    <?php endif;?>
		    <?php if(!empty($featured['description'])):?>
		    <div class="wrap">
				<a class="readmorebtn" onclick="$(this).text($(this).text() == '+<?php echo lang('more_info');?>' ? '-<?php echo lang('less_info');?>' : '+<?php echo lang('more_info');?>').next('#listing_description_<?php echo $featured['id'];?>').slideToggle('fast');">+<?php echo lang('more_info');?></a>
				<div id ="listing_description_<?php echo $featured['id']; ?>" style="display:none"><?php echo strip_tags(word_limiter($featured['description'], 20));?>...</div>
			</div><!-- end of wrap -->
			<?php endif;?>
			<?php if(($featured['created_on']) != '0000-00-00 00:00:00'):?>
		    <p class="small"><?php echo lang('added_on');?>: <?php echo $featured['created_on'];?> </p>
		    <?php endif;?>
		    </li>
		    <?php endforeach;?>
		    </ul>
		</div>
		</div>
		</div><!-- end of featured listing -->
		<?php endif; }?>
				<?php switch(settings_item('lst.popular_location')) {
				case 1:
				case 4:
				case 6:
				case 7:
				if($popular_listings):?>
		<div class="row top2"><!-- popular listing -->
		<div class="col-sm-12">
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php echo lang('popular_listings');?></h3>
		  </div>
		 	<ul class="list-group">
		  	<?php foreach($popular_listings as $popular):?>
		  	<li class="list-group-item"><span class="glyphicon glyphicon-map-marker pull-left"></span>  		  
		    <h5><a href="<?php echo site_url('detail/' .$popular['slug']. '-in-' .strtolower(str_replace(" ","-", $popular['city'])) .'-' .$popular['id']); ?>"><?php echo $popular['title'];?></a></h5>
		    <?php if($popular['isAddress'] == 1): ?>
		    <p><?php echo $popular['address'].'<br />'.$popular['city'].' '.$popular['pincode']. '<br />' .$popular['state'].', ' .ucwords(strtolower($popular['country']));?></p>
		    <?php endif;?>
		    <?php if(!empty($popular['description'])):?>
		    <div class="wrap">
				<a class="readmorebtn" onclick="$(this).text($(this).text() == '+<?php echo lang('more_info');?>' ? '-<?php echo lang('less_info');?>' : '+<?php echo lang('more_info');?>').next('#listing_description_<?php echo $popular['id'];?>').slideToggle('fast');">+<?php echo lang('more_info');?></a>
				<div id ="listing_description_<?php echo $popular['id']; ?>" style="display:none"><?php echo strip_tags(word_limiter($popular['description'], 10));?></div>
			</div><!-- end of wrap -->
			<?php endif;?>
			<?php if(($popular['created_on']) != '0000-00-00 00:00:00'):?>
			<p class="small"><?php echo lang('added_on');?>: <?php echo $popular['created_on'];?> </p>
			<?php endif;?>
		    </li>
		    </ul>
		    <?php endforeach;?>
		</div>
		</div>
		</div><!-- end of popular listing -->
		<?php endif; }?>
		<?php switch(settings_item('lst.recently_added_location')) {
				case 1:
				case 4:
				case 6:
				case 7:
				if($recently_added):?>
		<div class="row top2"><!-- recently added listing -->
		<div class="col-sm-12">
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php echo lang('recently_added_listings');?></h3>
		  </div>
		  <ul class="list-group">
		  	<?php foreach($recently_added as $latest):?>
		  	<li class="list-group-item"><span class="glyphicon glyphicon-map-marker pull-left"></span> 		  
		    <h5><a href="<?php echo site_url('detail/' .$latest['slug']. '-in-' .strtolower(str_replace(" ","-", $latest['city'])) .'-' .$latest['id']); ?>"><?php echo $latest['title'];?></a></h5>
		    <?php if($latest['isAddress'] == 1): ?>
		    <p><?php echo $latest['address'].'<br />'.$latest['city'].' '.$latest['pincode']. '<br />' .$latest['state'].', ' .ucwords(strtolower($latest['country']));?></p>
		    <?php endif;?>
		    <?php if(!empty($latest['description'])):?>
		    <div class="wrap">
				<a class="readmorebtn" onclick="$(this).text($(this).text() == '+<?php echo lang('more_info');?>' ? '-<?php echo lang('less_info');?>' : '+<?php echo lang('more_info');?>').next('#listing_description_<?php echo $latest['id'];?>').slideToggle('fast');">+<?php echo lang('more_info');?></a>
				<div id ="listing_description_<?php echo $latest['id']; ?>" style="display:none"><?php echo strip_tags(word_limiter($latest['description'], 10));?></div>
			</div><!-- end of wrap -->
			<?php endif;?>
			<?php if(($latest['created_on']) != '0000-00-00 00:00:00'):?>
		    <p class="small"><?php echo lang('added_on');?>: <?php echo $latest['created_on'];?> </p>
		    <?php endif;?>		    
		    </li>
		    <?php endforeach;?>
		    </ul>
		</div>
		</div>
		</div><!-- end of recently added -->
		<?php endif; }?>
		<?php switch(settings_item('lst.related_links_location')) {
				case 1:
				if($related_links):?>
		<div class="row top2"><!-- related listing -->
		<div class="col-sm-12">
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php echo lang('related_listings');?></h3>
		  </div>
		  	 <ul class="list-group">
		  	<?php foreach($related_links as $related_link):?>	
		  	<li class="list-group-item">	  
			    <h5><a href="<?php echo site_url('detail/' .$related_link['slug']. '-in-' .strtolower(str_replace(" ","-", $related_link['city'])) .'-' .$related_link['id']); ?>"><?php echo $related_link['title'] . lang('related_listings_text');?></a></h5>
			</li>
		    <?php endforeach;?>
		    </ul>		    
		</div>
		</div>
		</div><!-- end of recently added -->
		<?php endif; }?>
	</div> <!-- end of right column -->
</div><!-- end row 3 -->