<?php
if (validation_errors()) : ?>
<div class="alert alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<p><?php echo validation_errors(); ?></p>
</div>
<?php endif; ?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string.'?'.$_SERVER['QUERY_STRING'], array('class' => "form-horizontal", 'id' => 'businss_hours_form')); ?>
		<div class="alert alert-info fade in">
			<a class="close" data-dismiss="alert">&times;</a><?php echo lang('message_business_hours');?>
		</div>
		<?php echo form_hidden('listing_id', $listing_id); ?>
		<div class="table-responsive">
		<table class="table table-striped table-condensed">
			<thead>
				<tr>
					<th></th>
					<th><?php echo lang('label_day');?></th>
					<th><?php echo lang('label_from');?></th>
					<th><?php echo lang('label_to');?></th>
				</tr>
			</thead>
			<tbody>
			<?php
				//HIDDEN FIELD CONTAINS ID OF BUSINESS HOURS FOR DELETION 
				if ($records) 
				{
					foreach($records as $record){ echo form_hidden('id[]', $record->id); } 
				}
			?>
				<tr>				
					<td>
						<input type='checkbox' id='monday' name='business_hours_day_of_week[]' value='1' <?php if ($records) { foreach($records as $record){ echo (isset($record->day_of_week) && $record->day_of_week == 1) ? 'checked="checked"' : set_checkbox('business_hours_day_of_week', 1); } } ?>>
						<span class='help-block'><?php echo form_error('day_of_week'); ?></span>
					</td>
					<td><?php echo lang('label_monday');?></td>
					<td>
						<input id="monday_from" type="text" name="open_time_1" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('open_time', (isset($record->open_time) && $record->day_of_week == 1)  ? $record->open_time : ''); } }?>" />
					</td>
					<td>
						<input id="monday_to" type="text" name="close_time_1" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('close_time', (isset($record->close_time) && $record->day_of_week == 1) ? $record->close_time : ''); } }?>" />
					</td>
				
				</tr>
				<tr>
					<td>
						<input type='checkbox' id='tuesday' name='business_hours_day_of_week[]' value='2' <?php if ($records) { foreach($records as $record){ echo (isset($record->day_of_week) && $record->day_of_week == 2) ? 'checked="checked"' : set_checkbox('business_hours_day_of_week', 2); }} ?>>
						<span class='help-block'><?php echo form_error('day_of_week'); ?></span>
					</td>
					<td><?php echo lang('label_tuesday');?></td>
					<td>
						<input id="tuesday_from" type="text" name="open_time_2" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('open_time', (isset($record->open_time) && $record->day_of_week == 2) ? $record->open_time : ''); }}?>" />
					</td>
					<td>
						<input id="tuesday_to" type="text" name="close_time_2" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('close_time', (isset($record->close_time) && $record->day_of_week == 2) ? $record->close_time : ''); }}?>" />
					</td>
				</tr>
				
				<tr>
					<td>
						<?php //echo form_hidden('id', $records[1]->id); ?>
						<input type='checkbox' id='tuesday' name='business_hours_day_of_week[]' value='3' <?php if ($records) { foreach($records as $record){ echo (isset($record->day_of_week) && $record->day_of_week == 3) ? 'checked="checked"' : set_checkbox('business_hours_day_of_week', 3); } }?>>
						<span class='help-block'><?php echo form_error('day_of_week'); ?></span>
					</td>
					<td><?php echo lang('label_wednesday');?></td>
					<td>
						<input id="wednesday_from" type="text" name="open_time_3" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('open_time', (isset($record->open_time) && $record->day_of_week == 3) ? $record->open_time : ''); }}?>" />
					</td>
					<td>
						<input id="wednesday_to" type="text" name="close_time_3" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('close_time', (isset($record->close_time) && $record->day_of_week == 3) ? $record->close_time : ''); }}?>" />
					</td>
				</tr>
				
				<tr>
					<td>
						<?php //echo form_hidden('id', $records[1]->id); ?>
						<input type='checkbox' id='tuesday' name='business_hours_day_of_week[]' value='4' <?php if ($records) { foreach($records as $record){ echo (isset($record->day_of_week) && $record->day_of_week == 4) ? 'checked="checked"' : set_checkbox('business_hours_day_of_week', 4); } }?>>
						<span class='help-block'><?php echo form_error('day_of_week'); ?></span>
					</td>
					<td><?php echo lang('label_thursday');?></td>
					<td>
						<input id="thursday_from" type="text" name="open_time_4" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('open_time', (isset($record->open_time) && $record->day_of_week == 4) ? $record->open_time : ''); }}?>" />
					</td>
					<td>
						<input id="thursday_to" type="text" name="close_time_4" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('close_time', (isset($record->close_time) && $record->day_of_week == 4) ? $record->close_time : ''); }}?>" />
					</td>
				</tr>
				
				<tr>
					<td>
						<?php //echo form_hidden('id', $records[1]->id); ?>
						<input type='checkbox' id='tuesday' name='business_hours_day_of_week[]' value='5' <?php if ($records) { foreach($records as $record){ echo (isset($record->day_of_week) && $record->day_of_week == 5) ? 'checked="checked"' : set_checkbox('business_hours_day_of_week', 5); } }?>>
						<span class='help-block'><?php echo form_error('day_of_week'); ?></span>
					</td>
					<td><?php echo lang('label_friday');?></td>
					<td>
						<input id="friday_from" type="text" name="open_time_5" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('open_time', (isset($record->open_time) && $record->day_of_week == 5) ? $record->open_time : ''); }}?>" />
					</td>
					<td>
						<input id="friday_to" type="text" name="close_time_5" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('close_time', (isset($record->close_time) && $record->day_of_week == 5) ? $record->close_time : ''); }}?>" />
					</td>
				</tr>
				
				<tr>
					<td>
						<?php //echo form_hidden('id', $records[1]->id); ?>
						<input type='checkbox' id='tuesday' name='business_hours_day_of_week[]' value='6' <?php if ($records) { foreach($records as $record){ echo (isset($record->day_of_week) && $record->day_of_week == 6) ? 'checked="checked"' : set_checkbox('business_hours_day_of_week', 6); } }?>>
						<span class='help-block'><?php echo form_error('day_of_week'); ?></span>
					</td>
					<td><?php echo lang('label_saturday');?></td>
					<td>
						<input id="saturday_from" type="text" name="open_time_6" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('open_time', (isset($record->open_time) && $record->day_of_week == 6) ? $record->open_time : ''); }}?>" />
					</td>
					<td>
						<input id="saturday_to" type="text" name="close_time_6" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('close_time', (isset($record->close_time) && $record->day_of_week == 6) ? $record->close_time : ''); }}?>" />
					</td>
				</tr>
				
				<tr>
					<td>
						<input type='checkbox' id='tuesday' name='business_hours_day_of_week[]' value='7' <?php if ($records) { foreach($records as $record){ echo (isset($record->day_of_week) && $record->day_of_week == 7) ? 'checked="checked"' : set_checkbox('business_hours_day_of_week', 7); } }?>>
						<span class='help-block'><?php echo form_error('day_of_week'); ?></span>
					</td>
					<td><?php echo lang('label_sunday');?></td>
					<td>
						<input id="sunday_from" type="text" name="open_time_7" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('open_time', (isset($record->open_time) && $record->day_of_week == 7) ? $record->open_time : ''); }}?>" />
					</td>
					<td>
						<input id="sunday_to" type="text" name="close_time_7" class="medium" value="<?php if ($records) { foreach($records as $record){ echo set_value('close_time', (isset($record->close_time) && $record->day_of_week == 7) ? $record->close_time : ''); }}?>" />
					</td>
				</tr>

				<tr>
					<td colspan="4" style="text-align: center"><input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_save') ?>" /></td>
				</tr>
			</tbody>
		</table>
</div>
<?php echo form_close(); ?>

</div>
