<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Listing</title>
    <!-- Bootstrap Core CSS -->
	<link href="<?= base_url('assets/assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/assets/plugins/datatables/media/css/dataTables.bootstrap4.css') ?>" rel="stylesheet">
    <!-- chartist CSS -->
	<link href="<?= base_url('assets/assets/plugins/chartist-js/dist/chartist.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/assets/plugins/chartist-js/dist/chartist-init.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/assets/plugins/css-chart/css-chart.css') ?>" rel="stylesheet">
    <!-- Vector CSS -->
	<link href="<?= base_url('assets/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
	<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <!-- You can change the theme colors from here -->
	<link href="<?= base_url('assets/css/colors/blue.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/assets/plugins/bootstrap-switch/bootstrap-switch.min.css') ?>" rel="stylesheet" />
	<style type="text/css">
	.card-body {
		color: #000;
	}
	</style>
    </head>

<body class="fix-header fix-sidebar card-no-border logo-center">
        <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    
    <div id="main-wrapper">
        
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?= base_url() ?>">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?= base_url('assets/assets/images/logo-icon.png') ?>" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="<?= base_url('assets/assets/images/logo-light-icon.png') ?>" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                       <span style='color:#fff;font-weight:bold;'>
                         Listing
					   </span> 
					</a>
                </div>
                
                <div class="navbar-collapse">
                    
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
						<!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?= base_url('assets/assets/images/users/1.jpg') ?>" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img" style='width: 45px;'><img src="<?= base_url('assets/assets/images/users/1.jpg') ?>" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?=$_SESSION['first_name']?></h4>
                                                <p class="text-muted" style='font-size:10px;'><?=$_SESSION['email']?></p>
											</div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                   <li><a href="/admin/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        