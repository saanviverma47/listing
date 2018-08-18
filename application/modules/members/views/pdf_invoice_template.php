<table style="width: 100%;">
	<tr>
		<td><h2><?php echo lang('invoice_title');?></h2><br /></td>
		<td><h3 style="text-align: right;"><?php echo lang('invoice_order');?> {{invoice}}</h3><br /></td>
	</tr>
	<tr>
		<td><strong><?php echo lang('invoice_billed_to');?></strong><br />{{display_name}}<br /></td>
		<td style="text-align: right;"><strong><?php echo lang('invoice_shipped_to');?></strong><br />{{display_name}}<br /></td>
	</tr>
	<tr>
		<td><strong><?php echo lang('invoice_payment_method');?></strong><br />{{payment_method}}<br />{{email}}<br /></td>
		<td style="text-align: right;"><strong><?php echo lang('invoice_order_date');?></strong><br />{{order_date}}<br /></td>
	</tr>
</table>
<table cellspacing="0" cellpadding="1" border="1">
	<thead>
		<tr style="background-color: #f5f5f5;">
			<th style="text-align: left; width: 60%;"><strong><?php echo lang('invoice_item');?></strong></th>
			<th style="text-align: center; width: 10%;"><strong><?php echo lang('invoice_item_price');?></strong></th>
			<th width="20%" style="text-align: center; width: 20%;"><strong><?php echo lang('invoice_item_quantity');?></strong></th>
			<th width="10%" style="text-align: center; width: 10%;"><strong><?php echo lang('invoice_item_totals');?></strong></th>
		</tr>
	</thead>
	<tbody>
		<!-- foreach ($order->lineItems as $line) or some such thing here -->
		<tr>
			<td width="60%">{{package_title}} - {{listing_title}}</td>
			<td style="text-align: center; width: 10%;">{{currency}}{{amount}}</td>
			<td style="text-align: center; width: 20%;">{{quantity}}</td>
			<td style="text-align: center; width: 10%;">{{currency}}{{amount}}</td>
		</tr>
		<tr>
			<td colspan="3" style="text-align: right"><strong><?php echo lang('invoice_subtotal');?></strong></td>
			<td style="text-align: center; width: 10%;">{{currency}}{{amount}}</td>
		</tr>
		<tr>
			<td colspan="3" style="text-align: right"><strong><?php echo lang('invoice_total');?></strong></td>
			<td style="text-align: center; width: 10%;">{{currency}}{{amount}}</td>
		</tr>
	</tbody>
</table>
<h4><?php echo lang('invoice_status');?> {{status}}</h4>
<p>
	<?php echo lang('invoice_message');?><a href="{{url}}">{{url}}</a>
</p>