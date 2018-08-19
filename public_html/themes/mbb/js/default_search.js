/*----------------------------------------------------*/
/*	Location Selection Section
/*----------------------------------------------------*/
var site_url = $('#site_url').val();
var csrf_token = $.cookie('ci_csrf_token');
var xhr;
var select_country, $select_country;
var select_state, $select_state;
var select_city, $select_city;
var select_locality, $select_locality;
var search_location = $('#search-location').val(); // get specified user location
if (search_location == 1) {
		$select_country = $('#select-country').selectize({
		    onChange: function(value) {
		        if (!value.length) return;
		        select_state.clearOptions();
		        select_state.load(function(callback) {
		            xhr && xhr.abort();
		            xhr = $.ajax({
		                url: site_url + 'listings/loadData/' + value,
		                success: function(results) {
		                    select_state.enable();
		                    callback(results);
		                },
		                error: function() {
		                    callback();
		                }
		            })
		        });
		    }
		});
		
		$select_state = $('#select-state').selectize({
		    valueField: 'id',
		    labelField: 'name',
		    searchField: ['name']
		});
		
		select_state  = $select_state[0].selectize;
		select_country = $select_country[0].selectize;
} 
$select_city = $('#select-city').selectize({
    onChange: function(value) {
        if (!value.length) return;
        select_locality.clearOptions();
        select_locality.load(function(callback) {
            xhr && xhr.abort();
            xhr = $.ajax({
                url: site_url + 'listings/loadLocalities/' + value,
                success: function(results) {
                    callback(results);
                },
                error: function() {
                    callback();
                }
            })
        });
    }
});

$select_locality = $('#select-locality').selectize({
    valueField: 'id',
    labelField: 'name',
    searchField: ['name'],
    onChange: function(value) {
    	if (!value.length) return;
    	$.ajax({
    		type: "POST",
            url: site_url + 'listings/ajax_selection',
            data: {'locality' : value, 'ci_csrf_token': csrf_token }
    	});
    }
});

select_locality  = $select_locality[0].selectize;
select_city = $select_city[0].selectize;

/*----------------------------------------------------*/
/*	Search Form Validation
/*----------------------------------------------------*/
$('#search-form').submit(function() {
	var searchterm = $.trim($("#search").val());
    if (searchterm.length < 4) {
        alert('You must type at least 4 characters into the search box.');
        return false;
    }
});