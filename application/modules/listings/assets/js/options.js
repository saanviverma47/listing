//VIDEOS
if($(".admin-youtube").length) {
	$(".admin-youtube").YouTubeModal({autoplay:0, width:550, height:385, useYouTubeTitle: false});
}

$('#listings_expires_on').datepicker({ dateFormat: 'yy-mm-dd'});

//DEALS
$('#classifieds_from').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});
$('#classifieds_to').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});

//BUSINESS HOURS
$('#monday_from').timepicker({ timeFormat: 'h:mm TT', ampm: true});
$('#monday_to').timepicker({ timeFormat: 'h:mm TT', ampm: true});
$('#tuesday_from').timepicker({  timeFormat: 'h:mm TT', ampm: true});
$('#tuesday_to').timepicker({ timeFormat: 'h:mm TT', ampm: true});
$('#wednesday_from').timepicker({  timeFormat: 'h:mm TT', ampm: true});
$('#wednesday_to').timepicker({ timeFormat: 'h:mm TT', ampm: true});
$('#thursday_from').timepicker({ timeFormat: 'h:mm TT', ampm: true});
$('#thursday_to').timepicker({ timeFormat: 'h:mm TT', ampm: true});
$('#friday_from').timepicker({  timeFormat: 'h:mm TT', ampm: true});
$('#friday_to').timepicker({ timeFormat: 'h:mm TT', ampm: true});
$('#saturday_from').timepicker({  timeFormat: 'h:mm TT', ampm: true});
$('#saturday_to').timepicker({ timeFormat: 'h:mm TT', ampm: true});
$('#sunday_from').timepicker({  timeFormat: 'h:mm TT', ampm: true});
$('#sunday_to').timepicker({ timeFormat: 'h:mm TT', ampm: true});


var site_url = $('#site_url').val();
var listings_categories_level = $('#listings_categories_level').val();
var listings_country_selection = $('#listings_country_selection').val();
//CATEGORY AND SUBCATEGORY AJAX FUNCTION
var csrf_token = $.cookie('ci_csrf_token');
if(listings_categories_level == 2 || listings_categories_level == 3) {
$('#listings_category_id').change(function(){ //any select change on the dropdown with id options trigger this code
	$("#listings_subcategory_id > option").remove(); //first of all clear select items
    $("#listings_subcategory_id").html("<option value=''>-- Select Sub Category --</option>");
    $("#listings_subsubcategory_id > option").remove(); //first of all clear select items
    $("#listings_subsubcategory_id").html("<option value=''>-- Select Sub Sub Category --</option>");
    $("#listings_subsubcategory_id").attr('disabled', true);
    var option = $('#listings_category_id').val();  // here we are taking option id of the selected one.
    $("#listings_subcategory_id").removeAttr('disabled'); // enable dropdown if there is subcategory

    if(option == ''){
      	 $("#listings_subcategory_id").html("<option value=''>-- Select Sub Category --</option>"); //If parent category is null set text of parent category
       	 $("#listings_subcategory_id").attr('disabled', true); // disable subcategory dropdown        	 
       	 return false; // return false after clearing sub options if 'please select was chosen'
    }
    $.ajax({
         type: "POST",
         url: site_url + "/content/listings/get_sub_categories/"+option, //here we are calling our dropdown controller and getsuboptions method passing the option
         data: 'ci_csrf_token=' + csrf_token,
         success: function(suboptions) //we're calling the response json array 'suboptions'
         {
           	if(suboptions != undefined){
            $.each(suboptions,function(id,value) //here we're doing a foeach loop round each sub option with id as the key and value as the value
            {               	
               var opt = $('<option />'); // here we're creating a new select option for each suboption
               opt.val(id);
               opt.text(value);
               $('#listings_subcategory_id').append(opt); //here we will append these new select options to a dropdown with the id 'suboptions
            });
            }},
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                console.log('An Ajax error was thrown.');
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            }
   });
});
} 
if(listings_categories_level == 3) {
// Third level categories
$('#listings_subcategory_id').change(function(){ //any select change on the dropdown with id options trigger this code
    $("#listings_subsubcategory_id > option").remove(); //first of all clear select items
    $("#listings_subsubcategory_id").html("<option value=''>-- Select Sub Sub Category --</option>");
    var option = $('#listings_subcategory_id').val();  // here we are taking option id of the selected one.
    $("#listings_subsubcategory_id").removeAttr('disabled'); // enable dropdown if there is subcategory

    if(option == ''){
    	 $("#listings_subsubcategory_id").html("<option value=''>-- Select Sub Sub Category --</option>"); //If parent category is null set text of parent category
    	 $("#listings_subsubcategory_id").attr('disabled', true); // disable subcategory dropdown
    	 return false; // return false after clearing sub options if 'please select was chosen'
    }
    $.ajax({
        type: "POST",
        url: site_url + "/content/listings/get_sub_categories/"+option, //here we are calling our dropdown controller and getsuboptions method passing the option
        data: 'ci_csrf_token=' + csrf_token,
        success: function(suboptions) //we're calling the response json array 'suboptions'
        {
        	if(suboptions != undefined){
            $.each(suboptions,function(id,value) //here we're doing a foeach loop round each sub option with id as the key and value as the value
            {               	
                var opt = $('<option />'); // here we're creating a new select option for each suboption
                opt.val(id);
                opt.text(value);
                $('#listings_subsubcategory_id').append(opt); //here we will append these new select options to a dropdown with the id 'suboptions
            });
        	}
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            console.log('An Ajax error was thrown.');
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });

});
}

/*----------------------------------------------------*/
/*	Ajax Dropdown Country, State and City
/*----------------------------------------------------*/ 
if(listings_country_selection == 1) {
	function selectState(country_id){
		if(country_id!=""){
			$("#listings_state_id").removeAttr('disabled');
		    loadData('state',country_id);
		    initialize($("#listings_country_id option:selected").text()); //GET MAP OF SELECTED COUNTRY
		    $("#listings_city_id").html("<option value=''>-- Select City --</option>");
		} else{
		    $("#listings_state_id").html("<option value=''>-- Select State --</option>");
		    $("#listings_city_id").html("<option value=''>-- Select City --</option>");
		}
	}
}

function selectCity(state_id){
	  if(state_id!=""){
		$("#listings_city_id").removeAttr('disabled'); // REMOVE DISABLED PROPERTY FROM CITY DROPDOWN
	   loadData('city',state_id); //GET CITIES
	   
	   //GET MAP OF SELECTED STATE
	   var address = $("#listings_state_id option:selected").text() + ', ' + $("#listings_country_id option:selected").text();
	   initialize(address); 
	  }else{
	   $("#listings_city_id").html("<option value=''>-- Select City --</option>");
	  }
	}

function selectLocality(city_id) {
	  if(city_id!=""){
		$("#listings_locality_id").removeAttr('disabled'); // REMOVE DISABLED PROPERTY FROM CITY DROPDOWN
	   loadData('locality',city_id); //GET CITIES
	  }else{
	   $("#listings_locality_id").html("<option value=''>-- Select Locality --</option>");
	  }
	}

function GetCityMap(city_id) {
	  if(city_id!=""){
	   var address = $("#listings_city_id option:selected").text()+ ', '+ $("#listings_state_id option:selected").text() + ', ' + $("#listings_country_id option:selected").text();
	   initialize(address); //GET MAP OF SELECTED STATE
	}
}

//TO CAPITALISE FIRST WORD
function capitalise(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

function loadData(loadType,loadId){
	  var dataString = 'loadType='+ loadType +'&loadId='+ loadId + '&ci_csrf_token=' + csrf_token;
	  $("#"+loadType+"_loader").show();
	  $("#"+loadType+"_loader").fadeIn(400).html();
	  $.ajax({
	    type: "GET",
	    url: site_url + "/content/listings/loadData",
	    data: dataString,
	    cache: false,
	    success: function(result){
	      $("#"+loadType+"_loader").hide();
	      $("#listings_"+loadType+"_id").html("<option value=''>-- Select "+ capitalise(loadType) +" --</option>");
	      $("#listings_"+loadType+"_id").append(result);
	    }
	 });
	}

/*----------------------------------------------------*/
/*	Google Map
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