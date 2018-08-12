<?php

$checkSegment = $this->uri->segment(4);
$logsUrl = site_url(SITE_AREA . '/developer/logs');

?>
<ul class="nav nav-pills">
	<li<?php echo $checkSegment != 'settings' ? ' class="active"' : ''; ?>>
		<a href="<?php echo $logsUrl; ?>"><?php echo lang('logs_logs'); ?></a>
	</li>
	<li<?php echo $checkSegment == 'settings' ? ' class="active"' : ''; ?>>
		<a href='<?php echo "{$logsUrl}/settings"; ?>'><?php echo lang('logs_settings'); ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'purge_cache' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/developer/logs/purge_cache') ?>"><?php echo lang('logs_purge_cache'); ?></a>
	</li>
</ul>