<!-- main row -->
<div class="row">
<div class="col-sm-9">
<?php if($frontend_slider): $i = 0; $j = 0;?>
<div class="row">
	<div class="col-sm-12">
		<div class="carousel slide" id="frontSlider">
		<!-- indications -->
		<ol class="carousel-indicators">
			<?php foreach($frontend_slider as $slide):?>
			<li <?php if(++$i == 1) { echo 'class="active"'; }?> data-slide-to="<?php echo $j++;?>" data-target="#frontSlider"></li>
			<?php endforeach;?>
		</ol>
		<!-- slides wrapper -->
			<div class="carousel-inner">
				<?php $i = 0; foreach($frontend_slider as $slide):?>
				<div class="item <?php if(++$i == 1) { echo 'active'; }?>" id="slide<?php echo $i;?>">
				<a href="<?php echo $slide['url']; ?>" target="<?php echo $slide['target']; ?>">
				<img src="<?php echo base_url();?>assets/images/banners/<?php echo $slide['image']; ?>"
					id="<?php echo $slide['id'];?>" class="banner"
					title="<?php echo $slide['title'];?>"
					alt="<?php echo $slide['title'];?>" />
				</a>
					<div class="carousel-caption">
						<h4><?php echo $slide['slider_heading'];?></h4>
						<p><?php echo $slide['html_text'];?></p>
					</div><!-- end carousel-caption -->
				</div><!-- end item -->
				<?php endforeach;?>
			</div><!-- carousel-inner -->
			<!-- slide controls -->
			<a class="left carousel-control" data-slide="prev" href="#frontSlider"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<a class="right carousel-control" data-slide="next" href="#frontSlider"><span class="glyphicon glyphicon-chevron-right"></span></a>
		</div><!-- end of front slider -->
	</div><!-- end of slider column -->
</div><!-- end of slider -->
<?php endif;?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo lang('home_category_browse');?></h3>
  </div>
  <div class="panel-body">
  	<ul class="list-inline">
  	<?php if($categories):?>
  	<?php foreach($categories as $category):?>  	  	
  	<?php if($category->parent_id == 0): ?>
  	<li class="horizontalLayout" style="width: 300px";>
	  	<span class="readmorebtn" role="button" tabindex="0" onclick="$(this).text($(this).text() == '+' ? '-' : '+').next().next('#sub_categories_<?php echo $category->id;?>').slideToggle('fast');">+</span>
	  	<a href="<?php echo site_url('category/' .$category->slug .'-'. $category->id);?>"><?php echo $category->name .' ('.$category->counts.')'; ?></a>
	  	<div id ="sub_categories_<?php echo $category->id; ?>" style="display:none">
		  	<ul>
			  	<?php foreach($categories as $sub):?>
			  		<?php if($sub->parent_id == $category->id):?>  		
			  		<li><a href="<?php echo site_url('category/' .$sub->slug .'-'. $sub->id);?>"><?php echo $sub->name.' ('.$sub->counts .')'; ?></a></li>  					
			  		<?php endif;?>
			  	<?php endforeach;?>
		  	</ul>
	  	</div>
  	</li>	
  	<?php endif;?>
  	<?php endforeach;?>
  	<?php endif;?>
  	</ul>
  </div>
</div>
</div><!-- end of category panel col-sm-12 -->
</div><!-- end of category panel row -->
<?php if($featured_listings):?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo lang('featured_listings');?></h3>
  </div>
  <div class="panel-body">    
    <div class="row">
    <?php foreach($featured_listings as $featured_listing):?>
    	<div class="col-sm-3">
		<div class="fileinput-preview thumbnail table-cell-middle" data-trigger="fileinput" style="max-width: 150px; width: 150px; max-height: 150px; height: 150px;">
					<?php if($featured_listing['logo_url']) {
						preg_match('/(?<extension>\.\w+)$/im', $featured_listing['logo_url'], $matches);
						$extension = $matches['extension'];
						$thumbnail = preg_replace('/(\.\w+)$/im', '', $featured_listing['logo_url']) . '_thumb' . $extension;
					?>
						<img src="<?php echo base_url(); ?>assets/images/logo/thumbs/<?php echo $thumbnail;?>"
			class="img-responsive" alt="<?php echo $featured_listing['title']?>" title="<?php echo $featured_listing['title']?>" />
					<?php } else {?>
						<img src="<?= base_url(); ?>assets/images/no-logo.png"
			class="img-responsive" alt="<?php echo $featured_listing['title']?>"
			title="<?php echo $featured_listing['title']?>" />
					<?php }?>
		</div>
    	<h5><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><?php echo $featured_listing['title'];?></a></h5>
    	<?php if($featured_listing['isAddress'] == 1): ?>
    	<p class="text-muted"><?php echo $featured_listing['address'].'<br />'.$featured_listing['city']. ' ' .$featured_listing['pincode'].'<br />'.$featured_listing['state'].', ' .ucwords(strtolower($featured_listing['country']));?></p>
    	<?php endif;?>
    	<?php if(!empty($featured_listing['description'])): ?>
    	<div class="wrap">
				<a class="readmorebtn" onclick="$(this).text($(this).text() == '+<?php echo lang('more_info');?>' ? '-<?php echo lang('less_info');?>' : '+<?php echo lang('more_info');?>').next('#listing_description_<?php echo $featured_listing['id'];?>').slideToggle('fast');">+<?php echo lang('more_info');?></a>
				<div id ="listing_description_<?php echo $featured_listing['id']; ?>" style="display:none"><?php echo strip_tags(word_limiter($featured_listing['description'], 10));?></div>
		</div><!-- end of wrap -->
		<?php endif;?>
    	</div>
    <?php endforeach;?>
    </div><!-- upper row -->
    <div class="row">
    </div><!-- lower row -->    
  </div>
</div>
</div><!-- end of location panel col-sm-12 -->
</div><!-- end of location panel row -->
<?php endif;?>
</div><!-- end of col-sm-9 -->
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
					<?php case 'html' :
								echo $banner ['html_text'];
								break;
							case 'text' :
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
				case 2:
				case 5:
				case 6:
				if($featured_listings): $i = 0;?>
		<div class="row top2"><!-- featured listing -->
		<div class="col-sm-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php echo lang('featured_listings');?></h3>
		  </div>	  
		  	<ul class="list-group">
		  	<?php foreach($featured_listings as $featured):?>
		  	 <?php if(++$i > (int)settings_item('lst.right_featured_count')) break;?>
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
		<?php endif;?>
		<?php }?>
		<?php switch(settings_item('lst.popular_location')) {
				case 1:
				case 2:
				case 5:
				case 6:
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
		    <h5><a href="<?php echo base_url() .'detail/' .$popular['slug']. '-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'];?>"><?php echo $popular['title'];?></a></h5>
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
		    <?php endforeach;?>		    
		    </ul>
		</div>
		</div>
		</div><!-- end of popular listing -->
		<?php endif;?>
		<?php }?>
		<?php switch(settings_item('lst.recently_added_location')) {
				case 1:
				case 2:
				case 5:
				case 6:
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
		    <h5><a href="<?php echo base_url() .'detail/' .$latest['slug']. '-in-'.strtolower(str_replace(" ","-", $latest['city'])).'-'.$latest['id'];?>"><?php echo $latest['title'];?></a></h5>
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
		<?php endif;?>	
		<?php }?>
</div><!-- end of col-sm-3 -->
</div><!-- end of main row -->

