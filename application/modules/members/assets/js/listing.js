$(document).ready(function() {
var site_url = $('#site_url').val();
var listing_id = $('#listing_id').val(); //To enable subcategory state and country on edit function
var listings_categories_level = $('#listings_categories_level').val();
var listings_country_selection = $('#listings_country_selection').val();
var xhr;
/*----------------------------------------------------*/
/*	CATEGORIES AND SUBCATEGORIES SELECTION
/*----------------------------------------------------*/
var select_parent, $select_parent;
var select_sub, $select_sub;
if(listings_categories_level == 1) {
	$('#listings_category_id').selectize({
		valueField: 'id',
		labelField: 'name',
		searchField: ['name']
	});
} else if(listings_categories_level == 2 || listings_categories_level == 3) {
	$select_parent = $('#listings_category_id').selectize({	
		onChange: function(value) {
			if (!value.length) return;
			select_sub.disable();
			select_sub.clearOptions();
			select_sub.load(function(callback) {
				xhr && xhr.abort();
				xhr = $.ajax({
					url: site_url + 'members/loadSubCategories/' + value,
					success: function(results) {
						select_sub.enable();
						callback(results);
					},
					error: function() {
						callback();
					}
				})
			});
		}
	});	
}

if(listings_categories_level == 2) {
	$select_sub = $('#listings_subcategory_id').selectize({
		valueField: 'id',
		labelField: 'name',
		searchField: ['name']
	});
	select_sub  = $select_sub[0].selectize;
	select_parent = $select_parent[0].selectize;

	//disable fields only if listing_id is not set
	if((listing_id =='') && (select_parent.getValue() == '')) {
		select_sub.disable();
	}
} else if(listings_categories_level == 3) {
	$select_sub = $('#listings_subcategory_id').selectize({	
		valueField: 'id',
		labelField: 'name',
		searchField: ['name'],
		onChange: function(value) {
			if (!value.length) return;
			select_subsub.disable();
			select_subsub.clearOptions();
			select_subsub.load(function(callback) {
				xhr && xhr.abort();
				xhr = $.ajax({
					url: site_url + 'members/loadSubCategories/' + value,
					success: function(results) {
						select_subsub.enable();
						callback(results);
					},
					error: function() {
						callback();
					}
				})
			});
		}
	});

	$select_subsub = $('#listings_subsubcategory_id').selectize({
		valueField: 'id',
		labelField: 'name',
		searchField: ['name']
	});

	select_subsub  = $select_subsub[0].selectize;
	select_sub  = $select_sub[0].selectize;
	select_parent = $select_parent[0].selectize;
}

/*----------------------------------------------------*/
/*	COUNTRY, STATE AND CITY SELECTION
/*----------------------------------------------------*/
var select_country, $select_country;
var select_state, $select_state;
var select_city, $select_city;
var select_locality, $select_locality;

if(listings_country_selection == 1) {
	$select_country = $('#listings_country_id').selectize({	
		onChange: function(value) {
			if (!value.length) return;
			select_state.disable();
			select_state.clearOptions();
			select_state.load(function(callback) {
				xhr && xhr.abort();
				xhr = $.ajax({
					url: site_url + 'members/loadLocations/state/' + value,
					success: function(results) {
						select_city.disable();
						select_city.clearOptions();
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
	select_country = $select_country[0].selectize;
}

$select_state = $('#listings_state_id').selectize({
	valueField: 'id',
	labelField: 'name',
	searchField: ['name'],
	onChange: function(value) {
		//initialize(this.getItem(value)[0].innerHTML); //GET MAP OF SELECTED STATE
		if (!value.length) return;
		select_city.disable();
		select_city.clearOptions();
		select_city.load(function(callback) {
			xhr && xhr.abort();
			xhr = $.ajax({
				url: site_url + 'members/loadLocations/city/' + value,
				success: function(results) {
					select_city.enable();
					callback(results);
				},
				error: function() {
					callback();
				}
			})
		});
	}
});

$select_city = $('#listings_city_id').selectize({
	valueField: 'id',
	labelField: 'name',
	searchField: ['name'],
	onChange: function(value) {
		if(listings_country_selection == 1) {
			var address = this.getItem(value)[0].innerHTML + ', '+ select_state.getItem(select_state.getValue())[0].innerHTML + ', ' + select_country.getItem(select_country.getValue())[0].innerHTML;
		} else {
			var address = this.getItem(value)[0].innerHTML + ', '+ select_state.getItem(select_state.getValue())[0].innerHTML;
		}
		initialize(address); //GET MAP OF SELECTED STATE
	}
});
select_city  = $select_city[0].selectize;
select_state  = $select_state[0].selectize;

//disable fields only if listing_id is not set
if((listing_id =='') && (select_state.getValue() == '') && (listings_country_selection == 1)) {
	select_state.disable();
	select_city.disable();
}

/*----------------------------------------------------*/
/*	GOOGLE MAPS
/*----------------------------------------------------*/
//SET LATITUDE AND LONGITUDE HIDDEN FILED
function updateLatLngTextFields(newLat, newLng)
{
	// pass user selected location latitute and langitude values to respective text fields
	$("#listings_latitude").val(newLat);
	$("#listings_longitude").val(newLng);
}

// Standard google maps function
function initialize(address) {
	var geocoder =  new google.maps.Geocoder();
    geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
    var myLatlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
    var myOptions = {
        zoom: 14,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    LoadMarker(results[0].geometry.location.lat(), results[0].geometry.location.lng());
    }
});
}

// Function for adding a marker to the page.
function addMarker(location) {
    marker = new google.maps.Marker({
        position: location,
        map: map,
        draggable: true
    });
    //PASS LATITUDE AND LONGITUDE VALUES TO ANOTHER FUNCTION
    google.maps.event.addListener(marker, "dragend", function(event) {
		updateLatLngTextFields(event.latLng.lat(), event.latLng.lng());
	});
}

// Testing the addMarker function
function LoadMarker(lat,lng) {
       Location = new google.maps.LatLng(lat,lng);
       addMarker(Location);
}

/*----------------------------------------------------*/
/*	Payment Gateway Selectize
/*----------------------------------------------------*/
$('#payment_gateways').selectize();
});