<?php 
 
 
 
 
 
 
 
 
 
 
 
 

echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); 
?>
<fieldset>
<div class="table-responsive"> 
    <table class="table table-striped table-bordered">
    <tr>
    <td>
				<div class="control-group <?php echo form_error('image') ? 'error' : ''; ?>">
				<?php echo form_label(lang('label_logo'), 'listings_logo', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='listings_logo' type='file' name='listings_logo' maxlength="100" />
					<span class='help-inline'><?php echo form_error('image'); ?></span>
				</div>
				</div>
				</td><td>
				<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 200px;">
					<?php if($logo !== NULL) {?>
						<img src="<?= base_url(); ?>assets/images/logo/<?= $logo; ?>" alt="<?php echo $title;?>" title="<?php echo $title;?>" />
					<?php } else {?>
						<img src="<?= base_url(); ?>assets/images/no-logo.png" alt="<?php echo $title;?>" title="<?php echo $title;?>" />
					<?php }?>
				</div></td>
				</tr>
				</table>
				</div>
			<div class="form-actions">
				<input type="submit" name="submit" class="btn btn-primary" value="<?php echo lang('listings_action_logo_update'); ?>"  />				
			</div>
</fieldset>
<?php echo form_close(); ?>