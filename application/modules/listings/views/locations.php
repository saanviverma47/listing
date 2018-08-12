<div class="row">
<?php if($states): ?>
<?php foreach($states as $state):?>
<div class="col-sm-4"> 
<div class="panel-group" id="accordion">
	<div class="panel panel-info">
		<div class="panel-heading state-<?php echo $state->id;?>">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" class="load-cities" id="<?php echo $state->id;?>"
					href="#collapse-<?php echo $state->id;?>"><span class="glyphicon glyphicon-th-list"> </span>
					</a><?php echo $state->name;?>
			</h4>
		</div>
	</div>
</div>
<!-- end of accordion -->
</div>
<?php endforeach;?>
<?php endif;?>
</div>
