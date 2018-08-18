<?php
$num_columns	= 8;
$can_delete	= $this->auth->restrict();
$can_edit		= $this->auth->restrict();
$has_records	= isset($records) && is_array($records) && count($records);
echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING']); ?>
	<input id="query_id" type="hidden" value=""/>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					<th width="5%"><?php echo lang('label_id');?></th>
					<th width="15%"><?php echo lang('label_listing');?></th>
					<th width="10%"><?php echo lang('label_name');?></th>
					<th width="15%"><?php echo lang('label_email');?></th>
					<th width="10%"><?php echo lang('label_phone');?></th>
					<th width="25%"><?php echo lang('label_message');?></th>
					<th width="15%"><?php echo lang('label_posted_on');?></th>
					<th width="5%"><?php echo lang('label_reply');?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					<td><?php e($record->id); ?></td>
					<td><?php e($record->title); ?></td>
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(site_url('members/edit_classified/' . $record->id), '<span class="icon-pencil"></span>' .  $record->name); ?></td>
				<?php else : ?>
					<td><?php e($record->name); ?></td>
				<?php endif; ?>
					<td> 
					<?php e($record->email) ?></td>
					<td><?php e($record->phone) ?></td>
					<td><?php e($record->message) ?></td>
					<td><?php e($record->posted_on) ?></td>
					<td><a href="#sendEmailModal" role="button" class="query btn" id="<?php echo $record->id;?>"
					data-toggle="modal"><span class="glyphicon glyphicon-envelope"></span></a></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>"><?php echo lang('error_no_record_found');?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		</div>
	<?php echo form_close(); ?>
	<div class="row">
			<div class="col-sm-12 centered-text">
				<?php echo $this->pagination->create_links(); ?>
			</div><!-- end of pagination column -->
		</div><!-- end of pagination row -->	
<!-- Send Email Form -->
		<div class="modal fade" id="sendEmailModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><?php echo lang('send_email_heading');?></h4>
					</div>
					<!-- end modal-header -->
					<form role="form" id="sendEmailForm">
					<div class="modal-body">
						<p>
							<small class="text-muted"><?php echo lang('form_heading_title');?></small>
						</p>
						<div id="emailAlert"></div>
						<div id="sendEmail_form" class="row">
							<div class="col-12 col-sm-12 col-lg-12">								
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
									<div class="row">
										<div class="col-12 col-sm-12 col-lg-12">
											<div class="form-group has-feedback">
											<label class="control-label" for="email_subject"><?php echo lang('label_subject');?></label> <input
															type="text" class="form-control input-sm" id="email_subject"
															name="email_subject" placeholder="<?php echo lang('placeholder_subject');?>" /> <span
															class="help-block" style="display: none;"><?php echo lang('placeholder_subject');?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group has-feedback">
												<label class="control-label" for="email_message">Your Message</label>
												<textarea class="form-control" rows="5"
													id="email_message" name="email_message"></textarea>
												<span class="help-block" style="display: none;">Please enter your message.</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-7 col-md-7 col-lg-7">
											<div class="form-group has-feedback">
												<label class="control-label" for="email_captcha_code"><?php echo lang('label_captcha');?></label> <input type="text"
													class="form-control input-sm" name="email_captcha_code"
													id="email_captcha_code"
													placeholder="<?php echo lang('placeholder_captcha');?>Please enter the code." /> <span
													class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
											</div>
											<span class="help-block" style="display: none;"><?php echo lang('error_captcha');?></span>
										</div>
										<div class="col-5 col-md-5 col-lg-5">
											<img class="img-thumbnail" id="email_captcha"
												src="<?php echo site_url("listings/securimage"); ?>"
												alt="CAPTCHA Image" /> <a id="email_update" href="#"
												onclick="document.getElementById('email_captcha').src = '<?php echo site_url("listings/securimage?"); ?>' + Math.random(); return false"><i
												class="glyphicon glyphicon-refresh"></i></a>
										</div>
									</div>
							</div>
							<!--/span-->
						</div>
						<!--/row-->
					</div>
					<!-- end modal-body -->
					<div class="modal-footer">
							<button type="submit" id="sendEmail" class="btn btn-primary" data-loading-text="Sending..." type="button"><?php echo lang('form_submit');?></button>
							<button class="btn btn-default" data-dismiss="modal" type="button"><?php echo lang('form_close');?></button>																			
					</div><!-- end of modal-footer -->
					</form>
				</div>
				<!-- end modal-content -->
			</div>
			<!-- end modal-dialog -->
		</div>
		<!-- end sendEmail -->