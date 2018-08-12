<?php 
 
 
 
 
 
 
 
 
 
 
 
 

?>
<!-- main row -->
<div class="row">
	<div class="col-sm-2"> 
	<div class="row">
	<div class="col-sm-12">
	<!-- Leftside Banner -->		
		 <?php if($banners): $i = 0;?>
		 <?php foreach ($banners as $banner):?>
		 <?php if((($banner['width'] == 190) && ($banner['height'] == 90)) && $banner['location'] == 'left'):?>
		  <?php if(++$i > 2) break; //display only two banners?>
			<div class="row">
			<div class="col-sm-12"><!-- leaderboard col-sm-12 -->
						<?php switch ($banner ['type']) {
							case 'image' : ?>
			 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
			 					id="<?php echo $banner['id'];?>" class="banner thumbnail img-responsive"
								src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
								title="<?php echo $banner['title'];?>"
								alt="<?php echo $banner['title'];?>" /></a><br />
					<?php break; ?>
					<?php case 'text' :
								echo htmlspecialchars($banner ['html_text']);
								break;
						} ?>
				</div><!-- end of leaderboard col-sm-12 -->
			</div><!-- end of row -->
		<?php endif;?>
		<?php endforeach; ?>
		<?php endif; ?>
		<!-- End of Leftside Banner -->
		<div class="panel-group" id="accordion">
		<?php if(isset($child_categories)):?>
            <div class="panel panel-info">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><?php echo $category_heading;?></a>
                </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse in">
                <ul class="list-group">
                	<?php foreach ($child_categories as $category):?>
                  	<li class="list-group-item"><a href="<?php echo site_url('category/' .$category->slug .'-' .$category->id)?>"><?php echo $category->name .' (' . $category->counts .')'; ?></a></li>
                  	<?php endforeach;?>
                </ul>
              </div>
            </div>
          <?php endif;?>
          <?php if($categories):?>
            <div class="panel panel-info">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="glyphicon glyphicon-th-list">
                    </span><?php echo lang('header_select_category');?></a>
                </h4>
              </div>              
              <div id="collapseFive" class="panel-collapse collapse <?php if(!isset($child_categories)): echo 'in'; endif;?>">              
              <ul class="list-group">
                	<?php foreach ($categories as $category):?>
                  	<li class="list-group-item"><a href="<?php echo site_url('category/' .$category->slug .'-' .$category->id)?>"><?php echo $category->name .' (' . $category->counts .')'; ?></a></li>
                  	<?php endforeach;?>
              </ul>               
              </div>              
            </div>
            <?php endif;?>
          </div><!-- end of accordion -->
	</div>
	</div>
	</div><!-- end of left -->
	<div class="col-sm-7 bottom2">	
	<!-- Leaderboard Banner -->		
		 <?php if($banners): $i = 0;?>
		 <?php foreach ($banners as $banner):?>
		 <?php if((($banner['width'] == 728) && ($banner['height'] == 90)) && $banner['location'] == 'top'):?>
		  <?php if(++$i > 1) break; //display only two banners?>
			<div class="row">
			<div class="col-sm-12"><!-- leaderboard col-sm-12 -->
						<?php switch ($banner ['type']) {
							case 'image' : ?>
			 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
			 					id="<?php echo $banner['id'];?>" class="banner img-responsive"
								src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
								title="<?php echo $banner['title'];?>"
								alt="<?php echo $banner['title'];?>" /></a>
					<?php break; ?>
					<?php case 'text' :
								echo htmlspecialchars($banner ['html_text']);
								break;
						} ?>
				</div><!-- end of leaderboard col-sm-12 -->
			</div><!-- end of row -->
		<?php endif;?>
		<?php endforeach; ?>
		<?php endif; ?>
		<!-- End of Leaderboard Banner -->
		<!-- Category and Location Description -->
		<?php if (isset($title)):?>
		<div class="row">
			<div class="col-sm-12">
			<h1><?php echo $title;?></h1>
			<?php if(isset($description)):?>
			<?php echo $description;?>
			<?php endif;?>
			</div>
		</div>
		<?php endif;?>
		
		<div class ="row"><!-- content row -->
			<div class="col-sm-12"><!-- content col-sm-12 -->
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
			<div class="row top2">	
				<div class="col-sm-12 alert alert-info" role="alert">
					<?php echo form_open()?>			
						<div class="pull-left">			
						<label class="control-label" for="selectRows"><?php echo lang('show_limit');?></label>
						 <select name="selectRows" id="selectRows" onchange="this.form.submit()">
							<option value="10" <?php echo isset($limit) && ($limit == 10) ? 'selected' : ''?>>10</option>
							<option value="15" <?php echo isset($limit) && ($limit == 15)  ? 'selected' : ''?>>15</option>
							<option value="20" <?php echo isset($limit) && ($limit == 20)  ? 'selected' : ''?>>20</option>
						</select>
						</div>
						<div class="pull-right">			
						<label class="control-label" for="sortBy"><?php echo lang('label_sort_by');?></label>
						 <select name="sortBy" id="sortBy" onchange="this.form.submit()">
						 	<option value="rating_default" <?php echo isset($sort_by) && ($sort_by == 'rating_default') ? 'selected' : ''?>><?php echo lang('label_sort_by_default');?></option>
							<option value="rating_highest" <?php echo isset($sort_by) && ($sort_by == 'rating_highest') ? 'selected' : ''?>><?php echo lang('label_sort_by_rating_high');?></option>
							<option value="rating_lowest" <?php echo isset($sort_by) && ($sort_by == 'rating_lowest') ? 'selected' : ''?>><?php echo lang('label_sort_by_rating_low');?></option>
						</select>
						</div>
					<?php echo form_close();?>
				</div><!-- end of dropdown column -->
			</div><!-- end of dropdown row -->			
			<div class="row hidden-xs hidden-sm">
				<div class="col-md-2"><strong><?php echo lang('heading_logo');?></strong></div>
				<div class="col-md-4"><strong><?php echo lang('heading_title');?></strong></div>
				<div class="col-md-2"><strong><?php echo lang('heading_area');?></strong></div>
				<div class="col-md-4"><strong><?php echo lang('heading_address');?></strong></div>
			</div><!-- end of header row -->
			<?php if($top_featured):?>			
			<?php foreach($top_featured as $sponsor):?>
			<hr>
			<div class="row alert alert-info" style="background-color: #<?php echo $sponsor['color_scheme'];?>; border-color: #<?php echo $sponsor['border_color'];?>;" role="alert">
			<div class="col-sm-12">
			<div class="row"><!-- content row -->
				<div class="col-md-2">
					<div class="fileinput-preview thumbnail" data-trigger="fileinput">
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
					<?php if(isset($sponsor['average_rating'])):?>
					<div class="row">
						<div class="col-sm-12">
							<div id="listing_rating" class="stars">
								<div class='controls'>
									<input id="input-ratings" type="number" data-disabled="true" data-show-caption="false"
										value="<?php echo $sponsor['average_rating'];?>"
										class="rating" min=0 max=5 step=0.5 data-show-clear="false"
										data-size="xs" />
								</div>
							</div>
						</div>
					</div>
				<?php endif;?>
				</div>
				<div class="col-md-4">
				<div class="row col-sm-12">
				<a href="<?php echo site_url('detail/' .$sponsor['slug']. '-in-' .strtolower(str_replace(" ","-", $sponsor['city'])) .'-' .$sponsor['listing_id']); ?>"><?php echo $sponsor['title']; ?></a>
				</div>
				<div class="row col-sm-12">
				<button type="button" class="query btn btn-sm btn-primary" data-toggle="modal" data-target="#query-modal" id="<?php echo $sponsor['listing_id'];?>">
				<?php echo lang('business_query');?></button>							
				</div><!-- end of ask query -->
				</div>
				<div class="col-md-2">
				<?php if((isset($search_locality) && ($search_locality == $sponsor['locality_id'])) || (!empty($search_locality))):?>
					<strong><?php echo $sponsor['locality']; ?></strong>
				<?php else:?>
					<strong><?php echo $sponsor['city'];?></strong>
				<?php endif;?><br />
				<span class="glyphicon glyphicon-thumbs-up"></span>
				</div>
				<div class="col-md-4"><?php echo $sponsor['address'] .'<br />' .$sponsor['city'] .', '.$sponsor['state'] . ' ' .$sponsor['pincode']. '<br />' . ucwords(strtolower($sponsor['country'])); ?>
				<?php if(!empty($sponsor['mobile_number']) && !empty($sponsor['phone_number'])):?>
				<br /><strong><?php echo lang('heading_phone');?>: </strong><?php echo $sponsor['mobile_number'] .', '.$sponsor['phone_number']; ?>
				<?php elseif(!empty($sponsor['mobile_number'])):?>
				<br /><strong><?php echo lang('heading_phone');?>: </strong><?php echo $sponsor['mobile_number']; ?>
				<?php elseif(!empty($sponsor['phones_number'])):?>
				<br /><strong><?php echo lang('heading_phone');?>: </strong><?php echo $sponsor['phone_number']; ?>
				<?php endif;?>
				</div>
			</div><!-- end of content row -->
			<?php if($sponsor['tags']):?>
			<div class="row top2"><!-- tag and business query -->	
				<div class="col-sm-2"></div>			
				<div class="col-sm-10"><?php echo $sponsor['tags']. ', ' ; ?> <a href="<?php echo site_url('detail/' .$sponsor['slug']. '-in-' .strtolower(str_replace(" ","-", $sponsor['city'])) .'-' .$sponsor['listing_id']); ?>"><?php echo lang('more_info');?>...</a></div>
			</div><!-- end of tag and business query -->
			<?php endif;?>
			<?php if($sponsor['description']):?>
			<div class="row"><!-- description -->
				<div class="col-sm-12">
					<div class="wrap">
						<a class="readmorebtn" onclick="$(this).text($(this).text() == '+<?php echo lang('more_info');?>' ? '-<?php echo lang('less_info');?>' : '+<?php echo lang('more_info');?>').next('#listing_description_<?php echo $sponsor['listing_id'];?>').slideToggle('fast');">+<?php echo lang('more_info');?></a>
						<div id ="listing_description_<?php echo $sponsor['listing_id']; ?>" style="display:none"><?php echo $sponsor['description']; ?></div>
					</div><!-- end of wrap -->
				</div><!-- end of col-sm-12 -->
			</div><!-- end of description -->
			<?php endif;?>
			</div>
			</div>
			<?php endforeach;?>
			<?php endif;?><!-- end of top featured -->
			<?php foreach($listings as $listing):?>
			<hr>
			<div class="row"><!-- content row -->
				<div class="col-md-2">
					<div class="fileinput-preview thumbnail" data-trigger="fileinput">
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
					<?php if(isset($listing['average_rating'])):?>
					<div class="row">
						<div class="col-sm-12">
							<div id="listing_rating" class="stars">
								<div class='controls'>
									<input id="input-ratings" type="number" data-disabled="true" data-show-caption="false"
										value="<?php echo $listing['average_rating'];?>"
										class="rating" min=0 max=5 step=0.5 data-show-clear="false"
										data-size="xs" />
									<small class="text-muted"><span>Rating: <?php echo $listing['average_rating']; ?></span>
									- <span><?php echo $listing['total_users']; ?> reviews</span>
									</small>
								</div>
							</div>
						</div>
					</div>
					<?php endif;?>
				</div>
				<div class="col-md-4">
				<div class="row col-sm-12">
				<a href="<?php echo site_url('detail/' .$listing['slug']. '-in-' .strtolower(str_replace(" ","-", $listing['city'])) .'-' .$listing['listing_id']); ?>"><?php echo $listing['title']; ?></a>
				</div>
				<div class="row col-sm-12">
				<button type="button" class="query btn btn-sm btn-primary" data-toggle="modal" data-target="#query-modal" id="<?php echo $listing['listing_id'];?>">
				<?php echo lang('business_query');?></button>							
				</div><!-- end of ask query -->
				</div>
				<?php if((isset($search_locality) && ($search_locality == $listing['locality_id'])) || (!empty($search_locality))):?>
					<div class="col-md-2"><strong><?php echo $listing['locality']; ?></strong></div>
				<?php else:?>
					<div class="col-md-2"><strong><?php echo $listing['city'];?></strong></div>
				<?php endif;?>
				<div class="col-md-4"><?php echo $listing['address'] .'<br />' .$listing['city'] .', '.$listing['state'] .'<br />'.ucwords(strtolower($listing['country'])); ?>
				<?php if(!empty($listing['mobile_number']) && !empty($listing['phone_number'])):?>
				<br /><strong><?php echo lang('heading_phone');?>: </strong><?php echo $listing['mobile_number'] .', '.$listing['phone_number']; ?>
				<?php elseif(!empty($listing['mobile_number'])):?>
				<br /><strong><?php echo lang('heading_phone');?>: </strong><?php echo $listing['mobile_number']; ?>
				<?php elseif(!empty($listing['phone_number'])):?>
				<br /><strong><?php echo lang('heading_phone');?>: </strong><?php echo $listing['phone_number']; ?>
				<?php endif;?>
				</div>
			</div><!-- end of content row -->
			<?php if($listing['tags']):?>
			<div class="row top2"><!-- tag and business query -->	
				<div class="col-sm-2"></div>			
				<div class="col-sm-10"><?php echo $listing['tags']. ', ' ; ?> <a href="<?php echo site_url('detail/' .$listing['slug']. '-in-' .strtolower(str_replace(" ","-", $listing['city'])) .'-' .$listing['listing_id']); ?>"><?php echo lang('more_info');?>...</a></div>
			</div><!-- end of tag and business query -->
			<?php endif;?>
			<?php if($listing['description']):?>
			<div class="row"><!-- description -->
				<div class="col-sm-12">
					<div class="wrap">
						<a class="readmorebtn" onclick="$(this).text($(this).text() == '+<?php echo lang('more_info');?>' ? '-<?php echo lang('less_info');?>' : '+<?php echo lang('more_info');?>').next('#listing_description_<?php echo $listing['listing_id'];?>').slideToggle('fast');">+<?php echo lang('more_info');?></a>
						<div id ="listing_description_<?php echo $listing['listing_id']; ?>" style="display:none"><?php echo $listing['description']; ?></div>
					</div><!-- end of wrap -->
				</div><!-- end of col-sm-12 -->
			</div><!-- end of description -->
			<?php endif;?>
			<?php $i++;?>
			<?php if($i == 2): //get first four results?><!-- Advertisements -->			
			<?php if($banners): $j = 0;?>
			<?php foreach ($banners as $banner):?>
			<?php if((($banner['width'] <= 180) && ($banner['height'] <= 90)) && ($banner['location'] == 'middle')):?>
			<hr>
			<div class="row">
			<?php $j++; ?>
			 <?php if($j > 2) break; //display only two banners?>		
					<div class="col-sm-4">
				 		<?php switch ($banner ['type']) {
								case 'image' : ?>
				 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
				 					id="<?php echo $banner['id'];?>" class="banner img-responsive"
									src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
									title="<?php echo $banner['title'];?>"
									alt="<?php echo $banner['title'];?>" /></a>
						<?php break; ?>
						<?php case 'text' :
									echo htmlspecialchars($banner ['html_text']);
									break;
							} ?>
					</div><!-- end of col-sm-12 -->
			<?php if($j == 1):?>
				<div class="col-sm-4"></div>
			<?php endif;?><!-- middle space of no use -->
			</div><!-- end of banner row -->
			<?php endif;?><!-- end of banner statement -->
			<?php endforeach; ?><!-- end of banner foreach -->
			<?php endif; ?><!-- end of banner if code -->
			<?php endif;?><!-- end of advertisement -->	
			<?php endforeach;?>
			 <?php else:?>
		     <div class="alert alert-info"><?php echo lang('error_not_exist');?></div>
		    <?php endif;?>
			</div><!-- end of content col-sm-12 -->
			</div><!-- end of content row -->			
			<div class="row top2">
			<?php if($banners): $k = 0;?>
			 <?php foreach ($banners as $banner):?>
			 <?php if((($banner['width'] <= 468) && ($banner['height'] <= 15)) && ($banner['location'] == 'bottom')):?>
			 <?php if(++$k > 2) break; //display only two banners?>		
					<div class="col-sm-12 centered-text">
				 		<?php switch ($banner ['type']) {
								case 'image' : ?>
				 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
				 					id="<?php echo $banner['id'];?>" class="banner img-responsive"
									src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
									title="<?php echo $banner['title'];?>"
									alt="<?php echo $banner['title'];?>" /></a>
						<?php break; ?>
						<?php case 'text' :
									echo htmlspecialchars($banner ['html_text']);
									break;
							} ?>
					</div><!-- end of col-sm-12 -->			
			<?php endif;?><!-- end of banner statement -->
			<?php endforeach; ?><!-- end of banner foreach -->
			<?php endif; ?><!-- end of banner if code -->
			</div><!-- banner bottom -->
			<div class="row">
				<div class="col-sm-12 centered-text">
					<?php echo $this->pagination->create_links(); ?>
				</div><!-- end of pagination column -->
			</div><!-- end of pagination row -->		
	</div><!-- end of middle -->
	<div class="col-sm-3">
	<?php if($banners): $i = 0;?>
		 <?php foreach ($banners as $banner):?>
		 <?php if(((($banner['width'] <= 300) && ($banner['height'] <= 250))) && ($banner['location'] == 'right')):?>
		 <?php if(++$i > 2) break; //display only two banners?>
				<div class="row top2">
				<div class="col-sm-12">
			 		<?php switch ($banner ['type']) {
							case 'image' : ?>
			 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
			 					id="<?php echo $banner['id'];?>" class="banner img-responsive"
								src="<?php echo base_url();?>assets/images/banners/<?php echo $banner['image']; ?>"
								title="<?php echo $banner['title'];?>"
								alt="<?php echo $banner['title'];?>" /></a>
					<?php break; ?>
					<?php case 'text' :
								echo htmlspecialchars($banner ['html_text']);
								break;
						} ?>
				</div><!-- end of col-sm-12 -->
			</div> <!-- end of row -->	
		<?php endif;?>
		<?php endforeach; ?>
		<?php endif; ?>
		<?php switch(settings_item('lst.featured_location')) {
				case 1:
				case 3:
				case 5:
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
		    <h5><a href="<?php echo site_url('detail/' .$featured['slug']. '-in-' .strtolower(str_replace(" ","-", $featured['city'])) .'-' .$featured['listing_id']); ?>"><?php echo $featured['title'];?></a></h5>
		    <?php if($featured['isAddress'] == 1): ?>
		    <p><?php echo $featured['address'].'<br />'.$featured['city']. ' ' .$featured['pincode']. '<br />' .$featured['state'].', ' .ucwords(strtolower($featured['country']));?></p>
		    <?php endif;?>
		    <?php if(!empty($featured['description'])):?>
		    <div class="wrap">
				<a class="readmorebtn" onclick="$(this).text($(this).text() == '+<?php echo lang('more_info');?>' ? '-<?php echo lang('less_info');?>' : '+<?php echo lang('more_info');?>').next('#listing_description_<?php echo $featured['listing_id'];?>').slideToggle('fast');">+<?php echo lang('more_info');?></a>
				<div id ="listing_description_<?php echo $featured['listing_id']; ?>" style="display:none"><?php echo strip_tags(word_limiter($featured['description'], 20));?>...</div>
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
				case 3:
				case 5:
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
		    <?php endif; ?>
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
		    <?php endforeach;?>
		    </ul>
		</div>
		</div>
		</div><!-- end of popular listing -->
		<?php endif; }?>
		<?php switch(settings_item('lst.recently_added_location')) {
				case 1:
				case 3:
				case 5:
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
		</div> <!-- end of column -->
		
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
							<button type="submit" id="sendQuerySubmit"
												class="btn btn-primary" data-loading-text="Sending..."><?php echo lang('form_submit');?></button>
								<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('form_close');?></button>								
							</div><!-- end of modal-footer -->
							</form>
						</div><!-- end of modal-content -->
					</div><!-- end of modal-dialog -->
				</div><!-- end of query-modal -->
</div><!-- end of main row -->