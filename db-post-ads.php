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
							<a href="db-listing-add.php"><img src="images/icon/dbl3.png" alt="" /> Add New Listing</a>
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
							<a href="db-post-ads.php" class="tz-lma"><img src="images/icon/dbl11.png" alt="" /> Ad Summary</a>
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
					<h4>Ads</h4>
					<div class="db-list-com tz-db-table">
						<div class="ds-boar-title">
							<h2>Post your Ads</h2>
							<p>Note: Ads banner size - Header-900px X 150px, Footer-900px X 150px, Home-400px X 400px, Listing-400px X 400px, Supported file formets .jpg, .png, .jpeg, .gif</p>
						</div>
						<div class="tz2-form-pay tz2-form-com">
							<form class="col s12">
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
										<label>Date will show (DD/MM/YYYY)</label>
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
						<div class="db-mak-pay-bot">
							<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p> <a href="db-setting.php" class="waves-effect waves-light btn-large">Ads Settings</a> </div>
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