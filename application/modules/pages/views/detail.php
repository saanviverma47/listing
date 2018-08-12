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
				<!-- End of Leftside Banner -->
			</div>
		</div>
	</div><!-- end of left -->
	<div class="col-sm-7">
		<div class="row">
			<div class="col-sm-12">
				<h1><?php echo $page_detail->title;?></h1>
				<?php echo $page_detail->body;?>
			</div><!-- end of content column -->
		</div><!-- end of content row -->
	</div><!-- end of middle -->
	<div class="col-sm-3">
	<div class="row">
			<div class="col-sm-12">
				<!-- Leftside Banner -->		
					 <?php if($banners): $i = 0;?>
					 <?php foreach ($banners as $banner):?>
					 <?php if((($banner['width'] == 300) && ($banner['height'] == 250)) && $banner['location'] == 'right'):?>
					  <?php if(++$i > 2) break; //display only two banners?>
						<div class="row">
						<div class="col-sm-12"><!-- leaderboard col-sm-12 -->
									<?php switch ($banner ['type']) {
										case 'image' : ?>
						 		<a href="<?php echo $banner['url']; ?>" target="<?php echo $banner['target']; ?>"> <img
						 					id="<?php echo $banner['id'];?>" class="banner thumbnail img-responsive"
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
					<!-- End of Leftside Banner -->
				</div>
			</div>
	</div><!-- end of right -->
</div><!-- end of row -->