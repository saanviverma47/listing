<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
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
			<div class="col-md-5 col-8 align-self-center">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a>
					</li>
					<li class="breadcrumb-item active">Category</li>
				</ol>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<!-- Row -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title" style="float: left">Categories</h4>
						<a id="deselect-all" class="btn btn-info" href="#"
							style="float: right">Add Category</a>
						<div class="table-responsive bt-switch">
							<table id="category"
								class="display nowrap table table-striped table-bordered"
								cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Name</th>
										<th>Parent</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($categories as $category): ?>
									<tr>
										<td><?=$category->category;?></td>
										<td><?=$category->parent;?></td>
										<td>
										<input type="checkbox" 	data-toggle="toggle"  checked="true" data-off-text="Inactive"
											data-on-text="Active" checked data-size="mini" onclick="javascript:toggleOffByInput()"
											data-on-color="success" data-off-color="danger" class="status" /></td>
										<td class="footable-editing">
											<a  href="?id=<?=$category->id;?>"
												class="footable-edit">
												<span class="fas fa-pencil-alt" aria-hidden="true"></span>
											</a>&nbsp;
											<a  href="?id=<?=$category->id;?>"
												class="footable-delete">
												<span class="fas fa-trash-alt" aria-hidden="true"></span>
											</a>
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
		<!-- ./Row -->
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
	</div>
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
