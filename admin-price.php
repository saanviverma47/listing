<?php include_once 'includes/admin_header.php';?>
<?php include_once 'includes/admin_left.php';?>
<!--== BODY INNER CONTAINER ==-->
<div class="sb2-2">
	<!--== breadcrumbs ==-->
<div class="sb2-2-2">
	<ul>
		<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a> </li>
		<li class="active-bre"><a href="#">Listing Price</a> </li>
		<li class="page-back"><a href="admin.php"><i class="fa fa-backward" aria-hidden="true"></i> Back</a> </li>
	</ul>
</div>
<div class="tz-2 tz-2-admin">
	<div class="tz-2-com tz-2-main">
		<h4>Listing Price</h4> <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list"><i class="material-icons">more_vert</i></a>
		<ul id="dr-list" class="dropdown-content">
			<li><a href="#!">Add New</a> </li>
			<li><a href="#!">Edit</a> </li>
			<li><a href="#!">Update</a> </li>
			<li class="divider"></li>
			<li><a href="#!"><i class="material-icons">delete</i>Delete</a> </li>
			<li><a href="#!"><i class="material-icons">subject</i>View All</a> </li>
			<li><a href="#!"><i class="material-icons">play_for_work</i>Download</a> </li>
		</ul>
		<!-- Dropdown Structure -->
			<div class="split-row">
				<div class="col-md-12">
					<div class="box-inn-sp ad-inn-page">
						<div class="tab-inn ad-tab-inn">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Select</th>
											<th>Listing Type</th>
											<th>Descriptions</th>
											<th>Offers</th>
											<th>Status</th>
											<th>Edit</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<input type="checkbox" class="filled-in" id="filled-in-box-1" />
												<label for="filled-in-box-1"></label>
											</td>
											<td><a href="#"><span class="list-enq-name">Free</span></a> </td>
											<td>Listing, Descriptions, Contact Info, Photo Gallery, Rating & Reviews</td>
											<td> <span class="label label-primary">10%</span> </td>
											<td> <span class="label label-primary">Active</span> </td>
											<td> <a href="admin-price-list-edit.php"><i class="fa fa-edit"></i></a> </td>
										</tr>
										<tr>
											<td>
												<input type="checkbox" class="filled-in" id="filled-in-box-2" />
												<label for="filled-in-box-2"></label>
											</td>
											<td><a href="#"><span class="list-enq-name">Pro Listing</span></a> </td>
											<td>Listing, Descriptions, Contact Info, Photo Gallery, Rating & Reviews, Social Media, SEO Optomization, Unlimited Listing</td>
											<td> <span class="label label-primary">50%</span> </td>
											<td> <span class="label label-primary">Active</span> </td>
											<td> <a href="admin-price-list-edit.php"><i class="fa fa-edit"></i></a> </td>
										</tr>
										<tr>
											<td>
												<input type="checkbox" class="filled-in" id="filled-in-box-3" />
												<label for="filled-in-box-3"></label>
											</td>
											<td><a href="#"><span class="list-enq-name">Pro Plus Listing</span></a> </td>
											<td>Listing, Descriptions, Contact Info, Photo Gallery, Rating & Reviews, Social Media, SEO Optomization, Unlimited Listing, Listing Priority, Video Gallery, Verified Listing</td>
											<td> <span class="label label-primary">20%</span> </td>
											<td> <span class="label label-primary">Active</span> </td>
											<td> <a href="admin-price-list-edit.php"><i class="fa fa-edit"></i></a> </td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="admin-pag-na">
						<ul class="pagination list-pagenat">
							<li class="disabled"><a href="#!!"><i class="material-icons">chevron_left</i></a> </li>
							<li class="active"><a href="#!">1</a> </li>
							<li class="waves-effect"><a href="#!">2</a> </li>
							<li class="waves-effect"><a href="#!">3</a> </li>
							<li class="waves-effect"><a href="#!">4</a> </li>
							<li class="waves-effect"><a href="#!">5</a> </li>
							<li class="waves-effect"><a href="#!">6</a> </li>
							<li class="waves-effect"><a href="#!">7</a> </li>
							<li class="waves-effect"><a href="#!">8</a> </li>
							<li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once 'includes/admin_footer.php';?>