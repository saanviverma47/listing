<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link
	href="<?= base_url('assets/assets/plugins/bootstrap-switch/bootstrap-switch.min.css') ?>"
	rel="stylesheet">
<div
	class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="row page-titles">

			<div class="col-md-7 col-4 align-self-center">
				<div class="d-flex m-t-10 justify-content-end">
					<div class="">
						<button
							class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10">
							<i class="ti-settings text-white"></i>
						</button>
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
						<h4 class="card-title" style="float: left">Categories</h4>
						<a id="deselect-all" class="btn btn-info" href="/admin/category/add"
							style="float: right">Add Category</a>
						<div class="table m-t-40">
							<table id="example23"
								class="display nowrap table table-hover table-striped table-bordered"
								cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Name</th>
										<th>Parent</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Name</th>
										<th>Parent</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</tfoot>
								<tbody>
								<?php foreach ($categories as $category): ?>
									<tr>
										<td><?=$category->category;?></td>
										<td><?php echo $category->parent==null?"Root":$category->parent;?></td>
										<td><input id="<?=$category->id;?>" type="checkbox" class='changeStatus' <?=$category->status == 0?'checked':''?> data-size="mini" /></td>
										<td class="footable-editing">
										<a href="/admin/category/edit?id=<?=$category->id;?>" class="footable-edit"> <span
												class="fas fa-pencil-alt" aria-hidden="true"></span> </a>&nbsp;
											<!-- a href="?id=<?=$category->id;?>" class="footable-delete"> <span
												class="fas fa-trash-alt" aria-hidden="true"></span> </a -->
										</td>
									</tr>
									<?php endforeach; ?>
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
	<script
		src="<?= base_url('assets/assets/plugins/datatables/datatables.min.js') ?>"></script>
	<!-- start - This is for export functionality only -->
	<script
		src="<?= base_url('assets/assets/plugins/datatables/dataTables.buttons.min.js') ?>"></script>
	<script
		src="<?= base_url('assets/assets/plugins/datatables/buttons.flash.min.js') ?>"></script>
	<script
		src="<?= base_url('assets/assets/plugins/datatables/jszip.min.js') ?>"></script>
	<script
		src="<?= base_url('assets/assets/plugins/datatables/pdfmake.min.js') ?>"></script>
	<script
		src="<?= base_url('assets/assets/plugins/datatables/vfs_fonts.js') ?>"></script>
	<script
		src="<?= base_url('assets/assets/plugins/datatables/buttons.html5.min.js') ?>"></script>
	<script
		src="<?= base_url('assets/assets/plugins/datatables/buttons.print.min.js') ?>"></script>

	<!-- bt-switch -->
	<script
		src="<?= base_url('assets/assets/plugins/bootstrap-switch/bootstrap-switch.min.js') ?>"></script>

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
					var value = $(this).val();
					var id = $(this).attr('id');
					 $.ajax({url: '/admin/category/updateStatus?id='+id+'&status='+value, success: function(result){}});
				}
			});
		}
    });
    </script>