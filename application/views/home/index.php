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
	<section class="com-padd">
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
										<div class="dir-hli-3"><img src="<?php echo Template::theme_url("images/hci1.png")?>" alt=""> </div>
										<div class="dir-hli-4"> </div> 
										<a href="<?php echo site_url('category/' .$category->slug .'-'. $category->id);?>">
										<img src="<?php echo Template::theme_url("images/services/15.jpg")?>" alt=""></a> </div>
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
			<div class="row">
				<div class="com-title">
					<h2>Featured <span>Listings</span></h2>
					<p>Explore some of the best tips from around the world from our partners and friends.</p>
				</div>
				<div class="col-md-6">
					<div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> <img src="<?php echo Template::theme_url("images/services/tr1.jpg")?>" alt="" /> </div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="automobile-listing-details.php"><h3>Import Motor America</h3></a>
								<h4>Express Avenue Mall, Santa Monica</h4>
								<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p> <span class="home-list-pop-rat">4.2</span>
								<div class="hom-list-share">
									<ul>
										<li><a href="#!"><i class="fa fa-bar-chart" aria-hidden="true"></i> 52</a> </li>
										<li><a href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 32</a> </li>
										<li><a href="#!"><i class="fa fa-eye" aria-hidden="true"></i> 420</a> </li>
										<li><a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i> 570</a> </li>
									</ul>
								</div>
							</div>
						</div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> <img src="<?php echo Template::theme_url("images/services/tr2.jpg")?>" alt="" /> </div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="property-listing-details.php"><h3>Luxury Property</h3></a>
								<h4>Express Avenue Mall, New York</h4>
								<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p> <span class="home-list-pop-rat">4.2</span>
								<div class="hom-list-share">
									<ul>
										<li><a href="#!"><i class="fa fa-bar-chart" aria-hidden="true"></i> 52</a> </li>
										<li><a href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 32</a> </li>
										<li><a href="#!"><i class="fa fa-eye" aria-hidden="true"></i> 420</a> </li>
										<li><a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i> 570</a> </li>
									</ul>
								</div>
							</div>
						</div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> <img src="<?php echo Template::theme_url("images/services/tr3.jpg")?>" alt="" /> </div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="shop-listing-details.php"><h3>Spicy Supermarket Shop</h3></a>
								<h4>Express Avenue Mall, Chicago</h4>
								<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p> <span class="home-list-pop-rat">4.2</span>
								<div class="hom-list-share">
									<ul>
										<li><a href="#!"><i class="fa fa-bar-chart" aria-hidden="true"></i> 52</a> </li>
										<li><a href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 32</a> </li>
										<li><a href="#!"><i class="fa fa-eye" aria-hidden="true"></i> 420</a> </li>
										<li><a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i> 570</a> </li>
									</ul>
								</div>
							</div>
						</div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> <img src="<?php echo Template::theme_url("images/services/s4.jpeg")?>" alt="" /> </div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="list-lead.php"><h3>Packers and Movers</h3></a>
								<h4>Express Avenue Mall, Toronto</h4>
								<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p> <span class="home-list-pop-rat">4.2</span>
								<div class="hom-list-share">
									<ul>
										<li><a href="#!"><i class="fa fa-bar-chart" aria-hidden="true"></i> 52</a> </li>
										<li><a href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 32</a> </li>
										<li><a href="#!"><i class="fa fa-eye" aria-hidden="true"></i> 420</a> </li>
										<li><a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i> 570</a> </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> <img src="<?php echo Template::theme_url("images/services/s5.jpeg")?>" alt="" /> </div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="list-lead.php"><h3>Tour and Travels</h3></a>
								<h4>Express Avenue Mall, Los Angeles</h4>
								<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p> <span class="home-list-pop-rat">4.2</span>
								<div class="hom-list-share">
									<ul>
										<li><a href="#!"><i class="fa fa-bar-chart" aria-hidden="true"></i> 52</a> </li>
										<li><a href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 32</a> </li>
										<li><a href="#!"><i class="fa fa-eye" aria-hidden="true"></i> 420</a> </li>
										<li><a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i> 570</a> </li>
									</ul>
								</div>
							</div>
						</div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> <img src="<?php echo Template::theme_url("images/services/s6.jpeg")?>" alt="" /> </div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="list-lead.php"><h3>Andru Modular Kitchen</h3></a>
								<h4>Express Avenue Mall, San Diego</h4>
								<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p> <span class="home-list-pop-rat">4.2</span>
								<div class="hom-list-share">
									<ul>
										<li><a href="#!"><i class="fa fa-bar-chart" aria-hidden="true"></i> 52</a> </li>
										<li><a href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 32</a> </li>
										<li><a href="#!"><i class="fa fa-eye" aria-hidden="true"></i> 420</a> </li>
										<li><a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i> 570</a> </li>
									</ul>
								</div>
							</div>
						</div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> <img src="<?php echo Template::theme_url("images/services/s7.jpeg")?>" alt="" /> </div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="list-lead.php"><h3>Rute Skin Care & Treatment</h3></a>
								<h4>Express Avenue Mall, Toronto</h4>
								<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p> <span class="home-list-pop-rat">4.2</span>
								<div class="hom-list-share">
									<ul>
										<li><a href="#!"><i class="fa fa-bar-chart" aria-hidden="true"></i> 52</a> </li>
										<li><a href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 32</a> </li>
										<li><a href="#!"><i class="fa fa-eye" aria-hidden="true"></i> 420</a> </li>
										<li><a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i> 570</a> </li>
									</ul>
								</div>
							</div>
						</div>
						<!--POPULAR LISTINGS-->
						<div class="home-list-pop mar-bot-red-0">
							<!--POPULAR LISTINGS IMAGE-->
							<div class="col-md-3"> <img src="<?php echo Template::theme_url("images/services/s8.jpg")?>" alt="" /> </div>
							<!--POPULAR LISTINGS: CONTENT-->
							<div class="col-md-9 home-list-pop-desc"> <a href="list-lead.php"><h3>Health and Fitness</h3></a>
								<h4>Express Avenue Mall, San Diego</h4>
								<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A.</p> <span class="home-list-pop-rat">4.2</span>
								<div class="hom-list-share">
									<ul>
										<li><a href="#!"><i class="fa fa-bar-chart" aria-hidden="true"></i> 52</a> </li>
										<li><a href="#!"><i class="fa fa-heart-o" aria-hidden="true"></i> 32</a> </li>
										<li><a href="#!"><i class="fa fa-eye" aria-hidden="true"></i> 420</a> </li>
										<li><a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i> 570</a> </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>