<?php include_once 'includes/admin_header.php';?>
<?php include_once 'includes/admin_left.php';?>

			<!--== BODY INNER CONTAINER ==-->
			<div class="sb2-2">
				<!--== breadcrumbs ==-->
				<div class="sb2-2-2">
					<ul>
						<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a> </li>
						<li class="active-bre"><a href="#"> Add Listing</a> </li>
						<li class="page-back"><a href="#"><i class="fa fa-backward" aria-hidden="true"></i> Back</a> </li>
					</ul>
				</div>
				<div class="tz-2 tz-2-admin">
					<div class="tz-2-com tz-2-main">
						<h4>Add New Listing</h4> <a class="dropdown-button drop-down-meta drop-down-meta-inn" href="#" data-activates="dr-list"><i class="material-icons">more_vert</i></a>
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
											<input id="list_name" type="text" class="validate">
											<label for="list_name">Listing Title</label>
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
												<option value="" disabled selected>Listing Type</option>
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
											<select multiple>
												<option value="" disabled selected>Select Category</option>
												<option value="">Hotels & Resorts</option>
												<option value="">Real Estate</option>
												<option value="">Trainings</option>
												<option value="">Education</option>
												<option value="">Hospitals</option>
												<option value="">Transportation</option>
												<option value="">Automobilers</option>
												<option value="">Computer Repair</option>
												<option value="">Property</option>
												<option value="">Food Court</option>
												<option value="">Sports Events</option>
												<option value="">Tour & Travels</option>
												<option value="">Health Care</option>
												<option value="">Gym & Fitness</option>
												<option value="">Packers and Movers</option>
												<option value="">Interior Design</option>
												<option value="">Clubs</option>
												<option value="">Mobile Shops</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s12">
											<select multiple>
												<option value="" disabled selected>Opening Days</option>
												<option value="">All Days</option>
												<option value="">Monday</option>
												<option value="">Tuesday</option>
												<option value="">Wednesday</option>
												<option value="">Thursday</option>
												<option value="">Friday</option>
												<option value="">Saturday</option>
												<option value="">Sunday</option>
											</select>
										</div>
									</div>
								<div class="row">
									<div class="input-field col s6">
										<select>
											<option value="" disabled selected>Open Time</option>
											<option value="">12:00 AM</option>
											<option value="">01:00 AM</option>
											<option value="">02:00 AM</option>
											<option value="">03:00 AM</option>
											<option value="">04:00 AM</option>
											<option value="">05:00 AM</option>
											<option value="">06:00 AM</option>
											<option value="">07:00 AM</option>
											<option value="">08:00 AM</option>
											<option value="">09:00 AM</option>
											<option value="">10:00 AM</option>
											<option value="">11:00 AM</option>
											<option value="">12:00 PM</option>
											<option value="">01:00 PM</option>
											<option value="">02:00 PM</option>
											<option value="">03:00 PM</option>
											<option value="">04:00 PM</option>
											<option value="">05:00 PM</option>
											<option value="">06:00 PM</option>
											<option value="">07:00 PM</option>
											<option value="">08:00 PM</option>
											<option value="">09:00 PM</option>
											<option value="">10:00 PM</option>
											<option value="">11:00 PM</option>											
										</select>
									</div>
									<div class="input-field col s6">
										<select>
											<option value="" disabled selected>Closing Time</option>
											<option value="">12:00 AM</option>
											<option value="">01:00 AM</option>
											<option value="">02:00 AM</option>
											<option value="">03:00 AM</option>
											<option value="">04:00 AM</option>
											<option value="">05:00 AM</option>
											<option value="">06:00 AM</option>
											<option value="">07:00 AM</option>
											<option value="">08:00 AM</option>
											<option value="">09:00 AM</option>
											<option value="">10:00 AM</option>
											<option value="">11:00 AM</option>
											<option value="">12:00 PM</option>
											<option value="">01:00 PM</option>
											<option value="">02:00 PM</option>
											<option value="">03:00 PM</option>
											<option value="">04:00 PM</option>
											<option value="">05:00 PM</option>
											<option value="">06:00 PM</option>
											<option value="">07:00 PM</option>
											<option value="">08:00 PM</option>
											<option value="">09:00 PM</option>
											<option value="">10:00 PM</option>
											<option value="">11:00 PM</option>	
										</select>
									</div>
								</div>
									<div class="row"> </div>
									<div class="row">
										<div class="input-field col s12">
											<textarea id="textarea1" class="materialize-textarea"></textarea>
											<label for="textarea1">Listing Descriptions</label>
										</div>
									</div>
									<div class="row">
										<div class="db-v2-list-form-inn-tit">
											<h5>Social Media Informations:</h5>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s12">
											<input type="text" class="validate">
											<label>www.facebook.com/directory</label>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s12">
											<input type="text" class="validate">
											<label>www.googleplus.com/directory</label>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s12">
											<input type="text" class="validate">
											<label>www.twitter.com/directory</label>
										</div>
									</div>	
									<div class="row">
										<div class="db-v2-list-form-inn-tit">
											<h5>Listing Guarantee:</h5>
										</div>
									</div>	
									<div class="row">
										<div class="input-field col s12">
											<select>
												<option value="" disabled selected>Select Service Guarantee</option>
												<option value="1">Upto 2 month of service</option>
												<option value="2">Upto 6 month of service</option>
												<option value="3">Upto 1 year of service</option>
												<option value="4">Upto 2 year of service</option>
												<option value="5">Upto 5 year of service</option>
											</select>
										</div>
									</div>									
									<div class="row">
										<div class="input-field col s12">
											<select>
												<option value="" disabled selected>Are you a Professionals for this service?</option>
												<option value="1">Yes</option>
												<option value="2">No</option>
											</select>
										</div>
									</div>									
									<div class="row">
										<div class="input-field col s12">
											<select>
												<option value="" disabled selected>Insurance Limits</option>
												<option value="1">Upto $5,000</option>
												<option value="2">Upto $10,000</option>
												<option value="3">Upto $15,000</option>
											</select>
										</div>
									</div>	
									<div class="row">
										<div class="db-v2-list-form-inn-tit">
											<h5>Google Map:</h5>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s12">
											<input type="text" class="validate">
											<label>Past your iframe code here</label>
										</div>
									</div>
									<div class="row">
										<div class="db-v2-list-form-inn-tit">
											<h5>360 Degree View:</h5>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s12">
											<input type="text" class="validate">
											<label>Past your iframe code here</label>
										</div>
									</div>									
									<div class="row">
										<div class="db-v2-list-form-inn-tit">
											<h5>Cover Image <span class="v2-db-form-note">(image size 1350x500):<span></h5>
										</div>
									</div>
									<div class="row tz-file-upload">
										<div class="file-field input-field">
											<div class="tz-up-btn"> <span>File</span>
												<input type="file"> </div>
											<div class="file-path-wrapper db-v2-pg-inp">
												<input class="file-path validate" type="text"> 
											</div>
										</div>
									</div>
									<div class="row">
										<div class="db-v2-list-form-inn-tit">
											<h5>Photo Gallery <span class="v2-db-form-note">(upload multiple photos note:size 750x500):<span></h5>
										</div>
									</div>
									<div class="row tz-file-upload">
										<div class="file-field input-field">
											<div class="tz-up-btn"> <span>File</span>
												<input type="file" multiple> </div>
											<div class="file-path-wrapper db-v2-pg-inp">
												<input class="file-path validate" type="text"> 
											</div>
										</div>
									</div>									
									<div class="row">
										<div class="db-v2-list-form-inn-tit">
											<h5>Services Offered <span class="v2-db-form-note">(Enter service name and upload service image note:size 400x250):<span>:</h5>
										</div>
									</div>	
									<div class="row">
										<div class="input-field col s6">
											<input type="text" class="validate">
											<label>Service Name (ex:Room Booking)</label>
										</div>
										<div class="col s6">
											<div class="row tz-file-upload">
												<div class="file-field input-field">
													<div class="tz-up-btn"> <span>File</span>
														<input type="file"> </div>
													<div class="file-path-wrapper db-v2-pg-inp">
														<input class="file-path validate" type="text"> 
													</div>
												</div>
											</div>
										</div>										
									</div>
									<div class="row">
										<div class="input-field col s6">
											<input type="text" class="validate">
											<label>Service Name (ex:Java Development)</label>
										</div>
										<div class="col s6">
											<div class="row tz-file-upload">
												<div class="file-field input-field">
													<div class="tz-up-btn"> <span>File</span>
														<input type="file"> </div>
													<div class="file-path-wrapper db-v2-pg-inp">
														<input class="file-path validate" type="text"> 
													</div>
												</div>
											</div>
										</div>										
									</div>
									<div class="row">
										<div class="input-field col s6">
											<input type="text" class="validate">
											<label>Service Name (ex:Home Lones)</label>
										</div>
										<div class="col s6">
											<div class="row tz-file-upload">
												<div class="file-field input-field">
													<div class="tz-up-btn"> <span>File</span>
														<input type="file"> </div>
													<div class="file-path-wrapper db-v2-pg-inp">
														<input class="file-path validate" type="text"> 
													</div>
												</div>
											</div>
										</div>										
									</div>
									<div class="row">
										<div class="input-field col s6">
											<input type="text" class="validate">
											<label>Service Name (ex:Property Rent)</label>
										</div>
										<div class="col s6">
											<div class="row tz-file-upload">
												<div class="file-field input-field">
													<div class="tz-up-btn"> <span>File</span>
														<input type="file"> </div>
													<div class="file-path-wrapper db-v2-pg-inp">
														<input class="file-path validate" type="text"> 
													</div>
												</div>
											</div>
										</div>										
									</div>
									<div class="row">
										<div class="input-field col s6">
											<input type="text" class="validate">
											<label>Service Name (ex:Job Trainings)</label>
										</div>
										<div class="col s6">
											<div class="row tz-file-upload">
												<div class="file-field input-field">
													<div class="tz-up-btn"> <span>File</span>
														<input type="file"> </div>
													<div class="file-path-wrapper db-v2-pg-inp">
														<input class="file-path validate" type="text"> 
													</div>
												</div>
											</div>
										</div>										
									</div>
									<div class="row">
										<div class="input-field col s6">
											<input type="text" class="validate">
											<label>Service Name (ex:Travels)</label>
										</div>
										<div class="col s6">
											<div class="row tz-file-upload">
												<div class="file-field input-field">
													<div class="tz-up-btn"> <span>File</span>
														<input type="file"> </div>
													<div class="file-path-wrapper db-v2-pg-inp">
														<input class="file-path validate" type="text"> 
													</div>
												</div>
											</div>
										</div>										
									</div>									
									<div class="row">
										<div class="input-field col s12 v2-mar-top-40"> <a class="waves-effect waves-light btn-large full-btn" href="db-payment.php">Submit Listing & Pay</a> </div>
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