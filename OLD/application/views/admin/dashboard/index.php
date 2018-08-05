<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Listing</title>
    <!-- Bootstrap Core CSS -->
	<link href="<?= base_url('assets/assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
	<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <!-- You can change the theme colors from here -->
	<link href="<?= base_url('assets/css/colors/blue.css') ?>" rel="stylesheet">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== login-register.jpg-->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(<?= base_url('assets/assets/images/background/logo5_s.JPG') ?>);">
        <div class="login-box card">
            <div class="card-body">
			   <?= form_open() ?>
                    <a href="javascript:void(0)" class="text-center db"><img src="<?= base_url('assets/assets/images/logo-icon.png') ?>" alt="Home" /><br/><span style='color:#000;font-weight:bold;'>Listing</span></a>
					<?= validation_errors() ?>
					<?php if (isset($error)) : ?>
						<div class="col-md-12">
							<div class="alert alert-danger" role="alert">
								<?= $error ?>
							</div>
						</div>
					<?php endif; ?>
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="email" placeholder="Username" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" required="" placeholder="Password" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex no-block align-items-center">
                            <div class="checkbox checkbox-primary p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <div class="ml-auto">
                                <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" id="recoverform" action="/">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url('assets/assets/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url('assets/assets/plugins/popper/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url('assets/js/jquery.slimscroll.js') ?>"></script>
    <!--Wave Effects -->
    <script src="<?= base_url('assets/js/waves.js') ?>"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url('assets/js/sidebarmenu.js') ?>"></script>
    <!--stickey kit -->
    <script src="<?= base_url('assets/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') ?>"></script>
    <script src="<?= base_url('assets/assets/plugins/sparkline/jquery.sparkline.min.js') ?>"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url('assets/js/custom.min.js') ?>"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?= base_url('assets/assets/plugins/styleswitcher/jQuery.style.switcher.js') ?>"></script>
</body>
</html>