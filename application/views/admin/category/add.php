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

						<div class="form-group row">
							<label for="example-text-input" class="col-2 col-form-label">Category
								Name</label>
							<div class="col-10">
								<input class="form-control" name="name" type="text" value=""
									id="name">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-search-input" class="col-2 col-form-label">Category
								Parent</label>
							<div class="col-10">
								<select class="custom-select col-12" id="parent_id"
									name="parent_id">
									<option selected="">Choose...</option>
									<?php foreach ($categories_combo as $key => $value): ?>
									<option value="<?=$key;?>"><?=$value;?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-email-input" class="col-2 col-form-label">Description</label>
							<div class="col-10">
								<input class="form-control" type="text" value=""
									id="description" name="description">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-url-input" class="col-2 col-form-label">Page
								Title</label>
							<div class="col-10">
								<input class="form-control" type="text" value=""
									name="meta_title" id="meta_title">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-tel-input" class="col-2 col-form-label">Meta
								Keyword</label>
							<div class="col-10">
								<input class="form-control" type="text" value=""
									name="meta_keywords" id="meta_keywords">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-tel-input" class="col-2 col-form-label">Meta
								Description</label>
							<div class="col-10">
								<textarea class="form-control" rows="5" name="meta_description"
									id="meta_description"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-password-input" class="col-2 col-form-label">Status</label>
							<div class="col-10">
								<input name="status" type="radio" id="active" checked /> <label
									for="active">Active</label> <input name="status" type="radio"
									id="inactive" /> <label for="inactive">Inactive</label>
							</div>
						</div>

						<div class="form-group row">
							<label for="example-password-input" class="col-2 col-form-label">&nbsp;</label>
							<div class="col-10">
								<button type="submit"
									class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
								<button type="submit"
									class="btn btn-inverse waves-effect waves-light">Cancel</button>
							</div>
						</div>
					</div>
					<!-- card body end -->
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
