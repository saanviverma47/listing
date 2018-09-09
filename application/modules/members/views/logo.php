<?php
 echo form_open_multipart($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING'], 'class="form-horizontal"'); ?>
<div class="col-sm-6 top2 bottom2 v-center">
	<div class="table-cell-middle">
		<div class="input-group">
			<input id='listings_logo' type='file' name='listings_logo' maxlength="100" class="form-control" />
			<span class='help-block'><?php echo form_error('image'); ?></span> <span
				class="input-group-btn">
				<button class="btn btn-default" type="submit" name="submit"><?php echo lang('listings_action_logo_update'); ?></button>
			</span>
		</div>
	</div>
</div>
<div class="col-sm-4 col-sm-offset-2">
	<div class="fileinput-preview thumbnail" data-trigger="fileinput"
		style="width: 200px; height: 200px;">
					<?php if($logo) {?>
						<img src="<?= base_url(); ?>assets/images/logo/<?= $logo; ?>"
			class="fileinput-preview thumbnail" alt="<?php echo $listing_title;?>" title="<?php echo $listing_title;?>" />
					<?php } else {?>
						<img src="<?= base_url(); ?>assets/images/no-logo.png"
			class="fileinput-preview thumbnail" alt="<?php echo $listing_title;?>"
			title="<?php echo $listing_title;?>" />
					<?php }?>
				</div>
</div>
<?php echo form_close(); ?>