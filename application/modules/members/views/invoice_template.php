    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2><?php echo lang('invoice_title');?></h2><h3 class="pull-right"><?php echo lang('invoice_order');?> {{invoice}}</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong><?php echo lang('invoice_billed_to');?></strong><br>
    					{{display_name}}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong><?php echo lang('invoice_shipped_to');?></strong><br>
    					{{display_name}}
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong><?php echo lang('invoice_payment_method');?></strong><br>
    					{{payment_method}}<br>
    					{{email}}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong><?php echo lang('invoice_order_date');?></strong><br>
    					{{order_date}}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong><?php echo lang('invoice_order_summary');?></strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong><?php echo lang('invoice_item');?></strong></td>
        							<td class="text-center"><strong><?php echo lang('invoice_item_price');?></strong></td>
        							<td class="text-center"><strong><?php echo lang('invoice_item_quantity');?></strong></td>
        							<td class="text-right"><strong><?php echo lang('invoice_item_totals');?></strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td>{{package_title}} - {{listing_title}}</td>
    								<td class="text-center">{{currency}}{{amount}}</td>
    								<td class="text-center">{{quantity}}</td>
    								<td class="text-right">{{currency}}{{amount}}</td>
    							</tr>
                               <tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong><?php echo lang('invoice_subtotal');?></strong></td>
    								<td class="thick-line text-right">{{currency}}{{amount}}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong><?php echo lang('invoice_total');?></strong></td>
    								<td class="no-line text-right">{{currency}}{{amount}}</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="row">
    <div class="col-xs-12"><h4><?php echo lang('invoice_status');?>: {{status}}</h4></div>
    </div>
<p>
	<?php echo lang('invoice_message');?><a href="{{url}}">{{url}}</a>
</p>