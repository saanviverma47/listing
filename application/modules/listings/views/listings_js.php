/*----------------------------------------------------*/
/*	Business Query Form
/*----------------------------------------------------*/
  if ($("#phone").intlTelInput) {
    $("#phone").intlTelInput({defaultCountry: "<?php echo strtolower($this->session->userdata('search_country'));?>", validationScript: "<?php echo base_url("assets/js/isValidNumber.js"); ?>"});
    $(".intl-tel-input.inside").css('width', '100%');
  }

  $('#businessQueryForm input')
    .not('.optional,.no-asterisk')
    .after('<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>');

  $("#feedbackSubmit").click(function() {
    var $btn = $(this);
    $btn.button('loading');
    contactForm.clearErrors();

    //do a little client-side validation -- check that each field has a value and is in proper format
    var hasErrors = false;
    $('#message, #name, #phone, #email, #captcha_code').not('.optional').each(function() {
      var $this = $(this);
      if (($this.is(':checkbox') && !$this.is(':checked')) || !$this.val()) {
      	hasErrors = true;
        contactForm.addError($(this));        
      }
    });
    var $email = $('#email');
    if (!contactForm.isValidEmail($email.val())) {
      hasErrors = true;
      contactForm.addError($email);
    }

    var $phone = $('#phone');
    if ($phone.val() && $phone.intlTelInput && !$phone.intlTelInput("isValidNumber")) {
      hasErrors = true;
      contactForm.addError($phone.parent());
    }

    if (hasErrors) {
      $btn.button('reset');
      return false;
    }

    var businessQueryData = $("#businessQueryForm").serialize();
    var listing_id = $('#listing_id').val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('businessQuery');?>",
      data: businessQueryData + '&listing_id='+listing_id + '&<?php echo $this->security->get_csrf_token_name(); ?>=' +'<?php echo $this->security->get_csrf_hash(); ?>',
      success: function(data) {
        contactForm.addAjaxMessage(data.message, false);
        contactForm.clearForm();
        //get new Captcha on success
		$("#captcha").attr('src', '<?php echo site_url('securimage?');?>' + Math.random());
      },
      error: function(response) {
        contactForm.addAjaxMessage($.parseJSON(response.responseText).message, true);
      },
      complete: function() {
        $btn.button('reset');
      }
   });
    return false;
  });
  $('#businessQueryForm input').change(function () {
    var asteriskSpan = $(this).siblings('.glyphicon-asterisk');
    if ($(this).val()) {
      asteriskSpan.css('color', '#00FF00');
    } else {
      asteriskSpan.css('color', 'black');
    }
  });

// Namespace as not to pollute global namespace
var contactForm = {
  isValidEmail: function (email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  },
  clearErrors: function () {
    $('#businessQueryAlert').remove(); // important or message will be displayed repeatedly
    $('#businessQueryForm .help-block').hide();
    $('#businessQueryForm .form-group').removeClass('has-error');
  },
  clearForm: function () {
    $('.glyphicon-asterisk').css('color', 'black');
    $('#businessQueryForm input,textarea').val("");
  },
  addError: function ($input) {
    var parentFormGroup = $input.parents('.form-group');
    parentFormGroup.children('.help-block').show();
    parentFormGroup.addClass('has-error');
  },
  addAjaxMessage: function(msg, isError) {
    $("#businessFormMessage").after('<div id="businessQueryAlert" class="alert alert-' + (isError ? 'danger' : 'success') + '" style="margin-top: 5px;"> ' + $('<div></div>').text(msg).html() + '</div>');
  }
};

// Business Query Captcha Refresh
  $( "#update" ).on( "click", function( e ) {
    var $icon = $( this ).find( ".glyphicon.glyphicon-refresh" ),
      animateClass = "glyphicon-refresh-animate";

    $icon.addClass( animateClass );
    // setTimeout is to indicate some async operation
    window.setTimeout( function() {
      $icon.removeClass( animateClass );
    }, 2000 );
});
    
/*----------------------------------------------------*/
/*	Send Review Form
/*----------------------------------------------------*/
$('#commentForm input') .not('.optional,.no-asterisk') .after('<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>');
  $("#commentSubmit").click(function() {
    var $btn = $(this);
    $btn.button('loading');
    reviewForm.clearErrors();

    var hasErrors = false;
    $('#user_name, #review_title, #review_message, #review_captcha_code').not('.optional').each(function() {
      var $this = $(this);
      if (($this.is(':checkbox') && !$this.is(':checked')) || !$this.val()) {
      	hasErrors = true;
        reviewForm.addError($(this));        
      }
    });
    
    if (hasErrors) {
      $btn.button('reset');
      return false;
    }
	var commentFormData = $("#commentForm").serialize();
    var listing_id = $('#listing_id').val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('review');?>",
      data: commentFormData + '&listing_id='+listing_id + '&<?php echo $this->security->get_csrf_token_name(); ?>=' +'<?php echo $this->security->get_csrf_hash(); ?>',
      success: function(data) {
        reviewForm.addAjaxMessage(data.message, false);
        reviewForm.clearForm();
		$("#review_captcha").attr('src', '<?php echo site_url('securimage?');?>' + Math.random());
      },
      error: function(response) {
        reviewForm.addAjaxMessage($.parseJSON(response.responseText).message, true);
      },
      complete: function() {
        $btn.button('reset');
      }
   });
    return false;
  });
  $('#commentForm input').change(function () {
    var asteriskSpan = $(this).siblings('.glyphicon-asterisk');
    if ($(this).val()) {
      asteriskSpan.css('color', '#00FF00');
    } else {
      asteriskSpan.css('color', 'black');
    }
  });

var reviewForm = {
  clearErrors: function () {
    $('#commentFeedback').remove(); 
    $('#commentForm .help-block').hide();
    $('#commentForm .form-group').removeClass('has-error');
  },
  clearForm: function () {
    $('.glyphicon-asterisk').css('color', 'black');
    $('#review_title, #user_name, #review_message, #review_captcha_code').val("");
  },
  addError: function ($input) {
    var parentFormGroup = $input.parents('.form-group');
    parentFormGroup.children('.help-block').show();
    parentFormGroup.addClass('has-error');
  },
  addAjaxMessage: function(msg, isError) {
    $("#reviewMessage").after('<div id="commentFeedback" class="alert alert-' + (isError ? 'danger' : 'success') + '" style="margin-top: 5px;"> ' + $(' <div></div>').text(msg).html() + '</div>');
  }
};

// Review Form Captcha Refresh
$( "#review_update" ).on( "click", function( e ) {
    var $icon = $( this ).find( ".glyphicon.glyphicon-refresh" ),
      animateClass = "glyphicon-refresh-animate";

    $icon.addClass( animateClass );
    window.setTimeout( function() {
      $icon.removeClass( animateClass );
    }, 2000 );
});    

/*----------------------------------------------------*/
/*	Claim/Report Form
/*----------------------------------------------------*/
  if ($("#claim_report_phone").intlTelInput) {
    $("#claim_report_phone").intlTelInput({defaultCountry: "<?php echo strtolower($this->session->userdata('search_country'));?>", validationScript: "<?php echo base_url("assets/js/isValidNumber.js"); ?>"});
    $(".intl-tel-input.inside").css('width', '100%');
  }

  $('#claimReportForm input')
    .not('.optional,.no-asterisk')
    .after('<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>');

  $("#claimReportSubmit").click(function() {
    var $btn = $(this);
    $btn.button('loading');
    claimReportForm.clearErrors();

    var hasErrors = false;
    $('#claim_report_description, #claim_report_name, #claim_report_phone, #claim_report_email, #claim_report_captcha_code').not('.optional').each(function() {
      var $this = $(this);
      if (($this.is(':checkbox') && !$this.is(':checked')) || !$this.val()) {
      	hasErrors = true;
        claimReportForm.addError($(this));        
      }
    });
    var $email = $('#claim_report_email');
    if (!claimReportForm.isValidEmail($email.val())) {
      hasErrors = true;
      claimReportForm.addError($email);
    }

    var $phone = $('#claim_report_phone');
    if ($phone.val() && $phone.intlTelInput && !$phone.intlTelInput("isValidNumber")) {
      hasErrors = true;
      claimReportForm.addError($phone.parent());
    }

    if (hasErrors) {
      $btn.button('reset');
      return false;
    }

    var claimReportQueryData = $("#claimReportForm").serialize();
    var listing_id = $('#listing_id').val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('claim');?>",
      data: claimReportQueryData + '&listing_id='+listing_id + '&<?php echo $this->security->get_csrf_token_name(); ?>=' +'<?php echo $this->security->get_csrf_hash(); ?>',
      success: function(data) {
        claimReportForm.addAjaxMessage(data.message, false);
        claimReportForm.clearForm();
		$("#claim_report_captcha").attr('src', '<?php echo site_url('securimage?');?>' + Math.random());
      },
      error: function(response) {
        claimReportForm.addAjaxMessage($.parseJSON(response.responseText).message, true);
      },
      complete: function() {
        $btn.button('reset');
      }
   });
    return false;
  });
  $('#claimReportForm input').change(function () {
    var asteriskSpan = $(this).siblings('.glyphicon-asterisk');
    if ($(this).val()) {
      asteriskSpan.css('color', '#00FF00');
    } else {
      asteriskSpan.css('color', 'black');
    }
  });

var claimReportForm = {
  isValidEmail: function (email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  },
  clearErrors: function () {
    $('#claimFeedback').remove();
    $('#claimReportForm .help-block').hide();
    $('#claimReportForm .form-group').removeClass('has-error');
  },
  clearForm: function () {
    $('.glyphicon-asterisk').css('color', 'black');
    $('#claim_report_description, #claim_report_phone, #claim_report_captcha_code').val("");
  },
  addError: function ($input) {
    var parentFormGroup = $input.parents('.form-group');
    parentFormGroup.children('.help-block').show();
    parentFormGroup.addClass('has-error');
  },
  addAjaxMessage: function(msg, isError) {
    $("#claimMessage").after('<div id="claimFeedback"	class="alert alert-' + (isError ? 'danger' : 'success') + '" style="margin-top: 5px;">' + $('<div></div>').text(msg).html() + '</div>');
  }
};

// Claim/Report Captcha Refresh
  $( "#claim_report_update" ).on( "click", function( e ) {
    var $icon = $( this ).find( ".glyphicon.glyphicon-refresh" ),
      animateClass = "glyphicon-refresh-animate";

    $icon.addClass( animateClass );
    window.setTimeout( function() {
      $icon.removeClass( animateClass );
    }, 2000 );
});    

/*----------------------------------------------------*/
/*	Gallery
/*----------------------------------------------------*/
$("[rel^='lightbox']").prettyPhoto();
// Disable social tools
$("a[rel^='lightbox']").prettyPhoto({social_tools:false}); 

/*----------------------------------------------------*/
/*	Star Rating
/*----------------------------------------------------*/
$('#input-ratings').on('rating.change', function(event, value) {
	var listing_id = $('#listing_id').val(); 	
    $.ajax({
	      type: "POST",
	      url: "<?php echo site_url('starRating');?>",
	      dataType: 'json',
	      data: {ratings: value, listing_id: listing_id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
	      success: function(data) {
	      	$('#rating_feedback').html(data.result);
	      }
      });
});

$('#input-ratings').rating('refresh', {
	showClear: false, 
	showCaption: true,
	// The default caption text, which will be displayed when no caption is setup for the rating in the starCaptions array. 
	defaultCaption: '{rating} <?php echo lang('label_stars');?>',
	
	// the caption titles corresponding to each of the star rating selected
	starCaptions: {
	  0.5: '<?php echo lang('label_half_star');?>',
	  1: '<?php echo lang('label_one_star');?>',
	  1.5: '<?php echo lang('label_one_half_star');?>',
	  2: '<?php echo lang('label_two_stars');?>',
	  2.5: '<?php echo lang('label_two_half_stars');?>',
	  3: '<?php echo lang('label_three_stars');?>',
	  3.5: '<?php echo lang('label_three_half_stars');?>',
	  4: '<?php echo lang('label_four_stars');?>',
	  4.5: '<?php echo lang('label_four_half_stars');?>',
	  5: '<?php echo lang('label_five_stars');?>'
	},
	
	// the caption displayed when clear button is clicked
	clearCaption: '<?php echo lang('label_not_rated');?>'
});

/*----------------------------------------------------*/
/*	Tag Click Submit Function
/*----------------------------------------------------*/
$( ".tag" ).each(function(index) {
    $(this).on("click", function(){
    	$('#search').val($(this).attr('id'));
    	document.forms['search-form'].submit();
    });
});

/*----------------------------------------------------*/
/*	Google Map
/*----------------------------------------------------*/
$("address").each(function(){                        
    var embed ="<div class=\"embed-responsive embed-responsive-16by9\"><iframe class=\"embed-responsive-item\" frameborder='0' scrolling='no'  marginheight='0' marginwidth='0'   src='https://maps.google.com/maps?&amp;q="+ encodeURIComponent( $(this).text() ) +"&amp;output=embed'></iframe></div>";
    $(this).html(embed);                            
});

/*----------------------------------------------------*/
/*	Click to Call Module
/*----------------------------------------------------*/
$('#click_to_call_btn').click(function() {
 	var listing_id = $('#listing_id').val(); 
	if(navigator.userAgent.match(/iPad/i)){
		device = 1;
	} else if(navigator.userAgent.match(/iPhone/i)){
	 	device = 2;
	} else if(navigator.userAgent.match(/Android/i)){
	 	device = 3; 
	} else if(navigator.userAgent.match(/BlackBerry/i)){
	 	device = 4;
	} else if(navigator.userAgent.match(/webOS/i)){
	 	device = 5;
	} else {
		device = 0;
	}
	$('#click_to_call_btn').hide();
	$('#click_to_call_no').slideToggle("fast");
	$.ajax({
	      type: "POST",
	      url: "<?php echo site_url('clickToCall');?>",
	      dataType: 'json',
	      data: {device: device, listing_id: listing_id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
    });
 });