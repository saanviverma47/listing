$('#allow_name_change').change(function(){
	var allow_change = $(this).attr('checked');
	if (allow_change == 'checked') {
		$('#name-change-settings').css('display', 'block');
	} else {
		$('#name-change-settings').css('display', 'none');
	}
});
	
$('#allow_remember').change(function(){
	var allow_change = $(this).attr('checked');
	if (allow_change == 'checked') {
			$('#remember-length').css('display', 'block');
		} else {
			$('#remember-length').css('display', 'none');
		}
});
var csrf_token = $.cookie('ci_csrf_token');
var site_url = $('#site_url').val();

/*----------------------------------------------------*/
/*	Ajax Dropdown Country, State and City
/*----------------------------------------------------*/
function selectState(country_id){
	  if(country_id!=""){
	    loadData('state',country_id);
	    $("#default_city").html("<option value=''>-- Select City --</option>");
	  }else{
	    $("#default_state").html("<option value=''>-- Select State --</option>");
	    $("#defaulty_city").html("<option value=''>-- Select City --</option>");
	  }
	}

function selectCity(state_id){
	  if(state_id!=""){
	   loadData('city',state_id); //GET CITIES
	  }else{
	   $("#defaulty_city").html("<option value=''>-- Select City --</option>");
	  }
	}

//TO CAPITALISE FIRST WORD
function capitalise(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

function loadData(loadType,loadId){
	  var dataString = 'loadType='+ loadType +'&loadId='+ loadId +'&ci_csrf_token=' + csrf_token;
	  $("#default_"+loadType+"_loader").show();
	  $("#default_"+loadType+"_loader").fadeIn(400).html();
	  $.ajax({
	    type: "POST",
	    url: site_url + "/settings/settings/loadData",
	    data: dataString,
	    cache: false,
	    success: function(result){
	      $("#default_"+loadType+"_loader").hide();
	      $("#default_"+loadType).html("<option value=''>-- Select "+ capitalise(loadType) +" --</option>");
	      $("#default_"+loadType).append(result);
	    }
	 });
	}
