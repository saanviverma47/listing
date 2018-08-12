/*----------------------------------------------------*/
/*	Datetime Picker
/*----------------------------------------------------*/
$('#packages_created_on').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});
$('#packages_modified_on').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});
if($(".pick-a-color").length) {
	$(".pick-a-color").pickAColor();
}
