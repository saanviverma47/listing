var site_url = $('#site_url').val();
$( '.load-cities' ).each(function(index) {
    $(this).on("click", function(){
    	var id = $(this).attr('id');
    	$('#collapse-' + id).remove(); // remove collapse or it will append data
    	$('.state-' + id).after('<div id="collapse-'+ id +'" class="panel-collapse collapse"><ul class="list-group"></ul></div>'); 
    	$.ajax({
      		type: "POST",
      		dataType:'json',
      		url: "<?php echo site_url('loadCities');?>",
      		data: { id: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' },
      		success: function(data) {
      			populateCities($("#collapse-" + id + " .list-group"), data);
      		}
      	});
    });
});
function populateCities(select, data) {	
    var items = [];
    $.each(data, function (id, option) {
       items.push('<li class="list-group-item"><a href="' + site_url + 'location/' + option.name.toLowerCase().replace(/[^a-zA-Z0-9]+/g,'-') + '-' + option.id + '">' + option.name + '</a></li>');
    }); 
    select.html(items.join(''));
}