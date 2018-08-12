/*----------------------------------------------------*/
/*	AJAX Data Table Search
/*----------------------------------------------------*/ 
$("#flex_table").dataTable({
		"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap",
		"iDisplayLength": <?php echo ($this->settings_lib->item('site.list_limit')) ? $this->settings_lib->item('site.list_limit') : 15; ?>,
		"bInfo": false,
		"bPaginate": false,
		"bProcessing": true,
		"bServerSide": false,
		"bLengthChange": false,
		"aaSorting": [[2,'desc']],
		"bAutoWidth": false,
		"aoColumns": [
			{ "mData": "", sDefaultContent: "" },
			{ "mData": "name", sDefaultContent: "" },
			{ "mData": "created", sDefaultContent: "" },
			{ "mData": "modified", sDefaultContent: "" },
			{ "mData": "status", sDefaultContent: "" }
		],
                "oLanguage": {
                    "sProcessing":   "<?php echo lang('sProcessing') ?>",
                    "sLengthMenu":   "<?php echo lang('sLengthMenu') ?>",
                    "sZeroRecords":  "<?php echo lang('sZeroRecords') ?>",
                    "sInfo":         "<?php echo lang('sInfo') ?>",
                    "sInfoEmpty":    "<?php echo lang('sInfoEmpty') ?>",
                    "sInfoFiltered": "<?php echo lang('sInfoFiltered') ?>",
                    "sInfoPostFix":  "<?php echo lang('sInfoPostFix') ?>",
                    "sSearch":       "<?php echo lang('sSearch') ?>",
                    "sUrl":          "<?php echo lang('sUrl') ?>",
                    "oPaginate": {
                        "sFirst":    "<?php echo lang('sFirst') ?>",
                        "sPrevious": "<?php echo lang('sPrevious') ?>",
                        "sNext":     "<?php echo lang('sNext') ?>",
                        "sLast":     "<?php echo lang('sLast') ?>"
                    }
                }
});