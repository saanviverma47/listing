/*----------------------------------------------------*/
/*	Datatable to allow user to search information
/*----------------------------------------------------*/
/*For a button which has been placed outside the form
(due to limitations in supported CSS).

No attempt is made to distinguish the submission from
e.g. a real submit button on the form.
That would probably be acheived by DOM manipulation,
but it wouldn't be safe, because some browser's history
mechanisms (quite understandably) preserve the DOM.
*/
$("#flex_table").dataTable({
		"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap",
		"iDisplayLength": <?php echo ($this->settings_lib->item('site.list_limit')) ? $this->settings_lib->item('site.list_limit') : ''; ?>,
		"bInfo": false,
		"bPaginate": false,
		"bProcessing": true,
		"bServerSide": false,
		//"sAjaxSource": "<?php echo site_url(SITE_AREA ."/content/listings/search")?>",
		"bLengthChange": false,
		//"aaSorting": [[2,'desc']],
		"bAutoWidth": false,
		"aoColumns": [
			{ "mData": "", sDefaultContent: "" },
			{ "mData": "ID", sDefaultContent: "" },
			{ "mData": "title", sDefaultContent: "" },
			{ "mData": "email", sDefaultContent: "" },
			{ "mData": "created", sDefaultContent: "" },
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