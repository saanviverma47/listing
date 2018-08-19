$(document).ready(function(){
/*----------------------------------------------------*/
/*	Move Carousel Automatically
/*----------------------------------------------------*/
$('.carousel').carousel({
	interval: 6000
})

/*----------------------------------------------------*/
/*	Fixed Navigation with Topbar
/*----------------------------------------------------*/
$('#nav').affix({
      offset: {
        top: $('header').height()
     }
});

/*----------------------------------------------------*/
/*	Language Selection Section
/*----------------------------------------------------*/
var site_url = $('#site_url').val();
var csrf_token = $.cookie('ci_csrf_token');
$(".input-btn-group a").click(function(){
	$('#site_language').val($(this).attr('id'));
	document.forms['language-change'].submit();
});

/*----------------------------------------------------*/
/*	Footer Menu
/*----------------------------------------------------*/
$(function () {
	$('#menu').metisMenu({
	toggle: false, // disable the auto collapse. Default: true
	doubleTapToGo: true
	});
});

/*----------------------------------------------------*/
/*	AJAX Search
/*----------------------------------------------------*/
$('#search').typeahead({	
	onSelect: function(item) {
    },
    ajax: { 
            url: site_url + 'listings/ajax_search/',
            displayField: "title", // object property to match 
            items: 10, // maximum number of items to show in the results. 
            timeout: 500, // time to wait for keyboard input to stop
            triggerLength: 2, // minimum length of text to take action on
            loadingClass: "loading-circle",
            preDispatch: function (query) {
                //showLoadingMask(true);
                return {
                    search: query
                }
            },
			preProcess: function (data) {
			    //showLoadingMask(false);
			    if (data.success === false) {
			        // Hide the list, there was some error
			        return false;
			    }
			    return data;
			}
          }
});
/*----------------------------------------------------*/
/*	Banner Click
/*----------------------------------------------------*/
var timer;
$( ".banner" ).each(function(index) {
    $(this).on("click", function(){
    	var id = $(this).attr('id');    	
    	$.post(site_url +'listings/updateBannerClicks/', { id: id, 'ci_csrf_token': csrf_token })
    });
    $(this).on({ // update only when user is on banner for 1000 ms
    	'mouseover' : function(){
    	var id = $(this).attr('id');
    	timer = setTimeout(function () { 
    	      	$.post(site_url +'listings/updateBannerImpressions/', { id: id, 'ci_csrf_token': csrf_token })    		
    	}, 1000);
    }, 'mouseout' : function () { // clear timeout on mouseout
        clearTimeout(timer);
    }
    });
});
});