<h1>{{title}}</h1>
<table>
	<tbody>
		<tr>
			<td><strong><?php echo lang('label_address');?></strong></td>
			<td>{{address}}</td>
		</tr>
		<tr>
			<td><strong><?php echo lang('label_contact_person');?></strong></td>
			<td>{{contact_person}}</td>
		</tr>
		<tr>
			<td><strong><?php echo lang('label_mobile_number');?></strong></td>
			<td>{{mobile_number}}</td>
		</tr>
		<tr>
			<td><strong><?php echo lang('label_email');?></strong></td>
			<td>{{email}}</td>
		</tr>
	</tbody>
</table>
<p>
	<?php echo lang('invoice_message');?><a href="{{url}}">{{url}}</a>
</p>