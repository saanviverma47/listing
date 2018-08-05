<?php include_once 'includes/header.php'; ?>
	<!--DASHBOARD-->
	<section>
		<div class="tz">
			<!--LEFT SECTION-->
			<div class="tz-l">
				<div class="tz-l-1">
					<ul>
						<li><img src="images/db-profile.jpg" alt="" /> </li>
						<li><span>80%</span> profile compl</li>
						<li><span>18</span> Notifications</li>
					</ul>
				</div>
				<div class="tz-l-2">
					<ul>
						<li>
							<a href="dashboard.php"><img src="images/icon/dbl1.png" alt="" /> My Dashboard</a>
						</li>
						<li>
							<a href="db-all-listing.php"><img src="images/icon/dbl2.png" alt="" /> All Listing</a>
						</li>
						<li>
							<a href="db-listing-add.php" class="tz-lma"><img src="images/icon/dbl3.png" alt="" /> Add New Listing</a>
						</li>
						<li>
							<a href="db-message.php"><img src="images/icon/dbl14.png" alt="" /> Messages(12)</a>
						</li>
						<li>
							<a href="db-review.php"><img src="images/icon/dbl13.png" alt="" /> Reviews(05)</a>
						</li>
						<li>
							<a href="db-my-profile.php"><img src="images/icon/dbl6.png" alt="" /> My Profile</a>
						</li>
						<li>
							<a href="db-post-ads.php"><img src="images/icon/dbl11.png" alt="" /> Ad Summary</a>
						</li>
						<li>
							<a href="db-payment.php"><img src="images/icon/dbl9.png" alt=""> Check Out</a>
						</li>
						<li>
							<a href="db-invoice-all.php"><img src="images/icon/db21.png" alt="" /> Invoice</a>
						</li>						
						<li>
							<a href="db-claim.php"><img src="images/icon/dbl7.png" alt="" /> Claim & Refund</a>
						</li>
						<li>
							<a href="db-setting.php"><img src="images/icon/dbl210.png" alt="" /> Setting</a>
						</li>
						<li>
							<a href="#!"><img src="images/icon/dbl12.png" alt="" /> Log Out</a>
						</li>
					</ul>
				</div>
			</div>
			<!--CENTER SECTION-->
			<div class="tz-2">
				<div class="tz-2-com tz-2-main">
					<h4>Submit Listings</h4>
					<div class="db-list-com tz-db-table">
						<div class="ds-boar-title">
							<h2>Add New Listings</h2>
							<p>All the Lorem Ipsum generators on the All the Lorem Ipsum generators on the</p>
						</div>
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
			</div>
			<!--RIGHT SECTION-->
			<div class="tz-3">
				<h4>Notifications(18)</h4>
				<ul>
					<li>
						<a href="#!"> <img src="images/icon/dbr1.jpg" alt="" />
							<h5>Joseph, write a review</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="images/icon/dbr2.jpg" alt="" />
							<h5>14 New Messages</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="images/icon/dbr3.jpg" alt="" />
							<h5>Ads expairy soon</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="images/icon/dbr4.jpg" alt="" />
							<h5>Post free ads - today only</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="images/icon/dbr5.jpg" alt="" />
							<h5>listing limit increase</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="images/icon/dbr6.jpg" alt="" />
							<h5>mobile app launch</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="images/icon/dbr7.jpg" alt="" />
							<h5>Setting Updated</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
					<li>
						<a href="#!"> <img src="images/icon/dbr8.jpg" alt="" />
							<h5>Increase listing viewers</h5>
							<p>All the Lorem Ipsum generators on the</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</section>
	<!--END DASHBOARD-->
	<!--MOBILE APP-->
<?php include_once 'includes/footer.php'; ?>