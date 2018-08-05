<?php include_once 'includes/admin_header.php';?>
<?php include_once 'includes/admin_left.php';?>
<!--== BODY INNER CONTAINER ==-->
<div class="sb2-2">
	<!--== breadcrumbs ==-->
	<div class="sb2-2-2">
		<ul>
			<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a> </li>
			<li class="active-bre"><a href="#"> Create New Ads</a> </li>
			<li class="page-back"><a href="#"><i class="fa fa-backward" aria-hidden="true"></i> Back</a> </li>
		</ul>
	</div>
	<div class="tz-2 tz-2-admin">
		<div class="tz-2-com tz-2-main">
			<h4>New Ads</h4> <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list"><i class="material-icons">more_vert</i></a>
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
					<div class="box-inn-sp ad-mar-to-min">
						<div class="tab-inn ad-tab-inn">
							<div class="tz2-form-pay tz2-form-com">
								<div class="tz2-form-pay tz2-form-com">
									<form>
										<div class="row">
											<div class="input-field col s12">
												<input type="number" class="validate">
												<label>User Name</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12 m6">
												<input type="email" class="validate">
												<label>Email id</label>
											</div>
											<div class="input-field col s12 m6">
												<input type="number" class="validate">
												<label>Phone</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<select>
													<option value="" disabled selected>Where your Ads show</option>
													<option value="1">Home Page</option>
													<option value="2">Listing Page</option>
													<option value="3">Footer Part</option>
													<option value="3">Header Part</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<select>
													<option value="" disabled selected>Select Duration</option>
													<option value="1">Demo - 5mins - Free</option>
													<option value="1">One Day - $10</option>
													<option value="1">One Week - $50</option>
													<option value="2">One Month - $ 200</option>
													<option value="3">Two Months - $350</option>
													<option value="3">Six Months - $700</option>
													<option value="3">One Year - $1000</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<select>
													<option value="" disabled selected>Select Status</option>
													<option value="1">Active</option>
													<option value="2">Non-Active</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<input type="text" class="validate">
												<label>Start Date (DD/MM/YYYY)</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<input type="text" class="validate">
												<label>End Date (DD/MM/YYYY)</label>
											</div>
										</div>													
										<div class="row tz-file-upload">
											<div class="file-field input-field">
												<div class="tz-up-btn"> <span>File</span>
													<input type="file"> </div>
												<div class="file-path-wrapper">
													<input class="file-path validate" type="text"> </div>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<input type="submit" value="SUBMIT ADS" class="waves-effect waves-light full-btn"> </div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once 'includes/admin_footer.php';?>