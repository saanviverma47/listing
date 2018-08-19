<!--HOME PROJECTS-->
	<section class="proj mar-bot-red-m30" style='display:none;'>
		<div class="container">
			<div class="row">
				<!--HOME PROJECTS: 1-->
				<div class="col-md-3 col-sm-6">
					<div class="hom-pro"> <img src="<?php echo Template::theme_url("images/icon/1.png")?>" alt="" />
						<h4>24 Million Business</h4>
						<p>Choose from a collection of handpicked luxury villas & apartments</p> <a href="#!">Explore Now</a> </div>
				</div>
				<!--HOME PROJECTS: 1-->
				<div class="col-md-3 col-sm-6">
					<div class="hom-pro"> <img src="<?php echo Template::theme_url("images/icon/2.png")?>" alt="" />
						<h4>1,200 Services Offered</h4>
						<p>Choose from a collection of handpicked luxury villas & apartments</p> <a href="#!">Explore Now</a> </div>
				</div>
				<!--HOME PROJECTS: 1-->
				<div class="col-md-3 col-sm-6">
					<div class="hom-pro"> <img src="<?php echo Template::theme_url("images/icon/3.png")?>" alt="" />
						<h4>05 Million Visitors</h4>
						<p>Choose from a collection of handpicked luxury villas & apartments</p> <a href="#!">Explore Now</a> </div>
				</div>
				<!--HOME PROJECTS: 1-->
				<div class="col-md-3 col-sm-6">
					<div class="hom-pro"> <img src="<?php echo Template::theme_url("images/icon/7.png")?>" alt="" />
						<h4>24 Million Business</h4>
						<p>Choose from a collection of handpicked luxury villas & apartments</p> <a href="#!">Explore Now</a> </div>
				</div>
			</div>
		</div>
	</section>
	<!--FIND YOUR SERVICE-->
	<section class="com-padd web-app">
		<div class="container">
			<div class="row">
				<div class="com-title">
					<h2>Find your <span>Services</span></h2>
					<p>Explore some of the best business from around the world from our partners and friends.</p>
				</div>
				<div class="dir-hli">
					<ul>
						<!--=====LISTINGS======-->
						<?php $counter = 1;?>
						<?php if($categories):?>
						<?php foreach($categories as $category):?>  	  	
						<?php  if($category->parent_id == 0): ?>
						<?php $counter++; if($counter >= 14){
							continue;
						}?>
						<li class="col-md-3 col-sm-6">
							<a href="list.php">
								<div class="dir-hli-5">
									<div class="dir-hli-1">
										<div class="dir-hli-3"><img src="<?php echo base_url(); ?>assets/images/categories/<?php echo $category->image_url;?>" alt=""> </div>
										<div class="dir-hli-4"> </div> 
										<a href="<?php echo site_url('category/' .$category->slug .'-'. $category->id);?>">
										<img src="<?php echo base_url(); ?>assets/images/categories/<?php echo $category->image_url;?>" alt=""></a> </div>
									<div class="dir-hli-2">
										<h4 style='font-size:12px;'><?php echo $category->name .' ('.$category->counts.')'; ?> </h4> </div>
								</div>
							</a>
						</li>
						<?php endif;?>
						<?php endforeach;?>
						<?php endif;?>
 					</ul>
				</div>
			</div>
		</div>
	</section>
	<!--ADD BUSINESS-->
	
	<!--BEST THINGS-->
	<section class="">
		<div class="container dir-hom-pre-tit">
		<?php if($featured_listings):?>
		
			<div class="row">
				<div class="com-title">
					<h2>Featured <span>Listings</span></h2>
					<p>Explore some of the best tips from around the world from our partners and friends.</p>
				</div>
						<!--POPULAR LISTINGS-->
					<?php $flag = 1;?>
					<?php foreach($featured_listings as $featured_listing):?>
					<?php $flag++;?>
					<?php if($flag%2 == 1){?>
					<div class="col-md-6">
						<div>	
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> 
							<?php if($featured_listing['logo_url']) {
								preg_match('/(?<extension>\.\w+)$/im', $featured_listing['logo_url'], $matches);
								$extension = $matches['extension'];
								$thumbnail = preg_replace('/(\.\w+)$/im', '', $featured_listing['logo_url']) . '_thumb' . $extension;
							?>
								<img src="<?php echo base_url(); ?>assets/images/logo/thumbs/<?php echo $thumbnail;?>" alt="" /> 
							<?php } else {?>
								<img src="<?= base_url(); ?>assets/images/no-logo.png" alt="" /> 
							<?php }?>
							</div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><h3><?php echo $featured_listing['title'];?></h3></a>
								<h4 style='display:none;'>Express Avenue Mall, Santa Monica</h4>
							<?php if($featured_listing['isAddress'] == 1): ?>
								<p><?php echo $featured_listing['address'].' '.$featured_listing['city']. ' ' .$featured_listing['pincode'].' '.$featured_listing['state'].', ' .ucwords(strtolower($featured_listing['country']));?></p>
							<?php endif;?>
							
								<span class="home-list-pop-rat"><?=sprintf('%0.1f', $featured_listing['average_rating'])?></span>
								<div class="hom-list-share">
									<ul>
										<li><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
										<li><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
										<li><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><i class="fa fa-eye" aria-hidden="true"></i> <?=$featured_listing['hits']?$featured_listing['hits']:0?></a> </li>
										<li><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><i class="fa fa-globe" aria-hidden="true"></i></a> </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php }else{?>
				<div class="col-md-6">
					<div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> 
							<?php if($featured_listing['logo_url']) {
								preg_match('/(?<extension>\.\w+)$/im', $featured_listing['logo_url'], $matches);
								$extension = $matches['extension'];
								$thumbnail = preg_replace('/(\.\w+)$/im', '', $featured_listing['logo_url']) . '_thumb' . $extension;
							?>
								<img src="<?php echo base_url(); ?>assets/images/logo/thumbs/<?php echo $thumbnail;?>" alt="" /> 
							<?php } else {?>
								<img src="<?= base_url(); ?>assets/images/no-logo.png" alt="" /> 
							<?php }?>
							</div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><h3><?php echo $featured_listing['title'];?></h3></a>
								<h4 style='display:none;'>Express Avenue Mall, Santa Monica</h4>
							<?php if($featured_listing['isAddress'] == 1): ?>
								<p><?php echo $featured_listing['address'].' '.$featured_listing['city']. ' ' .$featured_listing['pincode'].' '.$featured_listing['state'].', ' .ucwords(strtolower($featured_listing['country']));?></p>
							<?php endif;?>
							<span class="home-list-pop-rat"><?=sprintf('%0.1f', $featured_listing['average_rating'])?></span>
								<div class="hom-list-share">
									<ul>
										<li><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
										<li><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
										<li><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><i class="fa fa-eye" aria-hidden="true"></i> <?=$featured_listing['hits']?$featured_listing['hits']:0?></a> </li>
										<li><a href="<?php echo site_url('detail/' .$featured_listing['slug'] .'-in-'.strtolower(str_replace(" ","-", $featured_listing['city'])).'-'.$featured_listing['id'])?>"><i class="fa fa-globe" aria-hidden="true"></i></a> </li>
									</ul>
								</div>
							</div>
						</div>

					</div>
				</div>
			<?php } ?>
			<?php endforeach;?>
			</div>
		<?php endif;?>
		</div>
	</section>

	<!--ADD BUSINESS-->
	<section class="com-padd home-dis">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>30% Off</span> Promote Your Business with us <a href="/members/add_business">Add My Business</a></h2> </div>
			</div>
		</div>
	</section>
		<!--BEST THINGS-->
	<section class="com-padd">
		<div class="container dir-hom-pre-tit">
		<?php switch(settings_item('lst.popular_location')) {
				case 1:
				case 2:
				case 5:
				case 6:
		if($popular_listings):?>
		
			<div class="row">
				<div class="com-title">
					<h2>Popular <span>Listings</span></h2>
					<p>Explore some of the best tips from around the world from our partners and friends.</p>
				</div>
						<!--POPULAR LISTINGS-->
					<?php $flag = 1;?>
					<?php foreach($popular_listings as $popular):?>
					<?php $flag++;?>
					<?php if($flag%2 == 1){?>
					<div class="col-md-6">
						<div>	
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> 
							<?php if($popular['logo_url']) {
								preg_match('/(?<extension>\.\w+)$/im', $popular['logo_url'], $matches);
								$extension = $matches['extension'];
								$thumbnail = preg_replace('/(\.\w+)$/im', '', $popular['logo_url']) . '_thumb' . $extension;
							?>
								<img src="<?php echo base_url(); ?>assets/images/logo/thumbs/<?php echo $thumbnail;?>" alt="" /> 
							<?php } else {?>
								<img src="<?= base_url(); ?>assets/images/no-logo.png" alt="" /> 
							<?php }?>
							</div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><h3><?php echo $popular['title'];?></h3></a>
								<h4 style='display:none;'>Express Avenue Mall, Santa Monica</h4>
							<?php if($popular['isAddress'] == 1): ?>
								<p><?php echo $popular['address'].' '.$popular['city']. ' ' .$popular['pincode'].' '.$popular['state'].', ' .ucwords(strtolower($popular['country']));?></p>
							<?php endif;?>
							
								<span class="home-list-pop-rat"><?=sprintf('%0.1f', $popular['average_rating'])?></span>
								<div class="hom-list-share">
									<ul>
										<li><a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
										<li><a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
										<li><a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><i class="fa fa-eye" aria-hidden="true"></i> <?=$popular['hits']?$popular['hits']:0?></a> </li>
										<li><a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><i class="fa fa-globe" aria-hidden="true"></i></a> </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
		<?php }else{?>
				<div class="col-md-6">
					<div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> 
							<?php if($popular['logo_url']) {
								preg_match('/(?<extension>\.\w+)$/im', $popular['logo_url'], $matches);
								$extension = $matches['extension'];
								$thumbnail = preg_replace('/(\.\w+)$/im', '', $popular['logo_url']) . '_thumb' . $extension;
							?>
								<img src="<?php echo base_url(); ?>assets/images/logo/thumbs/<?php echo $thumbnail;?>" alt="" /> 
							<?php } else {?>
								<img src="<?= base_url(); ?>assets/images/no-logo.png" alt="" /> 
							<?php }?>
							</div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><h3><?php echo $popular['title'];?></h3></a>
								<h4 style='display:none;'>Express Avenue Mall, Santa Monica</h4>
							<?php if($popular['isAddress'] == 1): ?>
								<p><?php echo $popular['address'].' '.$popular['city']. ' ' .$popular['pincode'].' '.$popular['state'].', ' .ucwords(strtolower($popular['country']));?></p>
							<?php endif;?>
							<span class="home-list-pop-rat"><?=sprintf('%0.1f', $popular['average_rating'])?></span>
								<div class="hom-list-share">
									<ul>
										<li><a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
										<li><a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
										<li><a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><i class="fa fa-eye" aria-hidden="true"></i> <?=$popular['hits']?$popular['hits']:0?></a> </li>
										<li><a href="<?php echo site_url('detail/' .$popular['slug'] .'-in-'.strtolower(str_replace(" ","-", $popular['city'])).'-'.$popular['id'])?>"><i class="fa fa-globe" aria-hidden="true"></i></a> </li>
									</ul>
								</div>
							</div>
						</div>

					</div>
				</div>
			<?php } ?>
			<?php endforeach;?>
			</div>
		<?php endif;?>
		<?php }?>
		</div>
	</section>