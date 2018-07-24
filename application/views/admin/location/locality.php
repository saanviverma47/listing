<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?= base_url('assets/assets/plugins/bootstrap-switch/bootstrap-switch.min.css') ?>" rel="stylesheet">
 <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin/location/">Locations</a></li>
							<li class="breadcrumb-item"><a href="/admin/location/states/<?=$_SESSION['country_id']?>">States</a></li>
							<li class="breadcrumb-item"><a href="/admin/location/cities/<?=$_SESSION['state_id']?>">Cities</a></li>
                            <li class="breadcrumb-item active">Locality</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
								<div class='col-md-12'>
									<div class='col-md-6 pull-left' style="float:left;padding-left:0px;">
										<h4 class="card-title">Locality of <?=$cityName?></h4>
									</div>
									<div class='col-md-6 pull-right' style="float:right;">
										<a id="deselect-all" style="float:right; color:#fff;" class="btn btn-info">Add Locality</a>
									</div>
								</div>
                                <div class="table m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
											if(!empty($localities)){
												foreach($localities as $index=>$localities):
										?>
                                            <tr>
                                                <td><?=$index+1?></td>
                                                <td><?=$localities->name?></td>
                                                <td><input type="checkbox" class='changeStatus' <?=$localities->status == 1?'checked':''?> data-size="mini" /></td>
                                            </tr>
                                        <?php 
												endforeach;
											}
										?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
               
            </div>
	<!-- This is data table -->
    <script src="<?= base_url('assets/assets/plugins/datatables/datatables.min.js') ?>"></script>
    <!-- start - This is for export functionality only -->
    <script src="<?= base_url('assets/assets/plugins/datatables/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('assets/assets/plugins/datatables/buttons.flash.min.js') ?>"></script>
    <script src="<?= base_url('assets/assets/plugins/datatables/jszip.min.js') ?>"></script>
    <script src="<?= base_url('assets/assets/plugins/datatables/pdfmake.min.js') ?>"></script>
    <script src="<?= base_url('assets/assets/plugins/datatables/vfs_fonts.js') ?>"></script>
    <script src="<?= base_url('assets/assets/plugins/datatables/buttons.html5.min.js') ?>"></script>
    <script src="<?= base_url('assets/assets/plugins/datatables/buttons.print.min.js') ?>"></script>

	<!-- bt-switch -->
    <script src="<?= base_url('assets/assets/plugins/bootstrap-switch/bootstrap-switch.min.js') ?>"></script>
	
	<script>
	 $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
		"fnDrawCallback": function() {
			$('.changeStatus').bootstrapSwitch({
				size: 'mini',
				onText: 'Active',
				offText: 'Inactive',
				onColor: 'primary',
				offColor: 'danger',
				onSwitchChange: function (event, state) {

					$(this).val(state ? 0 : 1);

					var pk = $(this).data('key');
					var value = $(this).val();
					var publishDate = $('[data-published-id="' + pk + '"]');
					var featureDate = $('[data-featured-id="' + pk + '"]');
					var action = $(this).data('action');
					alert(value);
					$.ajax({
						url: "/admin/posts/" + pk,
						type: "POST",
						data: {
							released: value,
							action: action,
							_token: '{{csrf_token()}}',
							_method: 'PUT'
						},
						success: function (data) {
							if (data.action == "publish") {
								publishDate.html(data.date);
							} else {
								featureDate.html(data.date);
							}
							toastr.success(data.message);
						}
					});
				}
			});
		}
    });
    </script>
            