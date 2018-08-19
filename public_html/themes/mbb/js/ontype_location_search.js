/*----------------------------------------------------*/
/*	Location Selection Section
/*----------------------------------------------------*/
var csrf_token = $.cookie('ci_csrf_token');
$('#select-country').selectize({
    valueField: 'id',
    labelField: 'name',
    searchField: ['name']
});
$('#select-category').selectize({
    valueField: 'id',
    labelField: 'name',
    searchField: ['name'],
    onChange: function(value) {
    	if (!value.length) return;
    	$.ajax({
    		type: "POST",
            url: site_url + 'listings/ajax_selection',
            data: {'category' : value, 'ci_csrf_token': csrf_token }
    	});
    }
});
/*----------------------------------------------------*/
/*	AJAX Search City, Zipcode
/*----------------------------------------------------*/
var site_url = $('#site_url').val();
$('#location').typeahead({	
	onSelect: function(item) {
		
    },
    ajax: { 
            url: site_url + 'listings/ajax_search_location/',
            displayField: "name", // object property to match 
            items: 10, // maximum number of items to show in the results. 
            //timeout: 100, // time to wait for keyboard input to stop
            triggerLength: 1, // minimum length of text to take action on
            loadingClass: "loading-circle",
            preDispatch: function (query) {
                return {
                    search: query
                }
            },
			preProcess: function (data) {
			    if (data.success === false) {
			        // Hide the list, there was some error
			        return false;
			    }
			    return data;
			}
          }
});

/*----------------------------------------------------*/
/*	Search Form Validation
/*----------------------------------------------------*/
$('#search-form').submit(function() {
	var searchterm = $.trim($("#search").val());
    if (searchterm.length < 4) {
        alert('You must type at least 4 characters into the search box.');
        return false;
    }
    var searchlocation = $.trim($("#location").val());
    if (searchlocation.length < 4) {
        alert('You must type at least 4 characters into the location box.');
        return false;
    }
});