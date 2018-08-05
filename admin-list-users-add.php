<?php include_once 'includes/admin_header.php';?>
<?php include_once 'includes/admin_left.php';?>
<!--== BODY INNER CONTAINER ==-->
<div class="sb2-2">
	<!--== breadcrumbs ==-->
<div class="sb2-2-2">
	<ul>
		<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a> </li>
		<li class="active-bre"><a href="#"> Add User</a> </li>
		<li class="page-back"><a href="#"><i class="fa fa-backward" aria-hidden="true"></i> Back</a> </li>
	</ul>
</div>
<div class="tz-2 tz-2-admin">
	<div class="tz-2-com tz-2-main">
		<h4>Add New User</h4> <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list"><i class="material-icons">more_vert</i></a>
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
							<div class="hom-cre-acc-left hom-cre-acc-right">
								<div class="">
									<form class="">
										<div class="row">
											<div class="input-field col s6">
												<input id="first_name" type="text" class="validate">
												<label for="first_name">First Name</label>
											</div>
											<div class="input-field col s6">
												<input id="last_name" type="text" class="validate">
												<label for="last_name">Last Name</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<input id="list_phone" type="text" class="validate">
												<label for="list_phone">Phone</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<input id="email" type="email" class="validate">
												<label for="email">Email</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<input id="list_addr" type="text" class="validate">
												<label for="list_addr">Address</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<select>
													<option value="" disabled selected>User Type</option>
													<option value="1">Free</option>
													<option value="2">Premium</option>
													<option value="3">Premium Plus</option>
													<option value="3">Ultra Premium Plus</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<select>
													<option value="" disabled selected>Choose your city</option>
													<option value="1">Kyoto</option>
													<option value="2">Charleston</option>
													<option value="3">Florence</option>
													<option value="">Rome</option>
													<option value="">Mexico City</option>
													<option value="">Barcelona</option>
													<option value="">San Francisco</option>
													<option value="">Chicago</option>
													<option value="">Paris</option>
													<option value="">Tokyo</option>
													<option value="">Beijing</option>
													<option value="">Jerusalem</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<textarea id="textarea1" class="materialize-textarea"></textarea>
												<label for="textarea1">User Descriptions</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12"> <a class="waves-effect waves-light btn-large full-btn" href="#!">Submit User</a> </div>
										</div>
									</form>
								</div>
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