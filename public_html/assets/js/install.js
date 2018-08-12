var $tabs = $('.tabbable li');
$('#nexttab').on('click', function() {
			$tabs.filter('.active').next('li').find('a[data-toggle-next="conf"]').tab('show');
			$('#ov').removeClass('progress-bar-info');
			$('#db').removeClass('progress-bar-info');
			$('#conf').addClass('progress-bar-info');
});

$('#confprevtab').on('click', function() {
			$tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
			$('#db').removeClass('progress-bar-info');
			$('#conf').removeClass('progress-bar-info');
			$('#ov').addClass('progress-bar-info');
});

$('#confnexttab').on('click', function() {
			$tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
			$('#ov').removeClass('progress-bar-info');
			$('#conf').removeClass('progress-bar-info');
			$('#db').addClass('progress-bar-info');
});

$('#prevtab').on('click', function() {
			$tabs.filter('.active').prev('li').find('a[data-toggle-next="conf"]').tab('show');
			$('#ov').removeClass('progress-bar-info');
			$('#db').removeClass('progress-bar-info');
			$('#conf').addClass('progress-bar-info');			
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	var target = $(e.target).attr("class") // activated tab
	// remove class from all tab
	$('#ov').removeClass('progress-bar-info');
	$('#conf').removeClass('progress-bar-info');
	$('#db').removeClass('progress-bar-info');
	// add class to specific tab
	$('#' + target).addClass('progress-bar-info');
});

// Retrieve last tab during postback
$(function() { 
	  //for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
	  $('a[data-toggle="tab"]').on('click', function (e) {
	    //save the latest tab; use cookies if you like 'em better:
	    localStorage.setItem('lastTab', $(e.target).attr('href'));
	  });

	  //go to the latest tab, if it exists:
	  var lastTab = localStorage.getItem('lastTab');

	  if (lastTab) {
	      $('a[href="'+lastTab+'"]').click();
	  }
	});