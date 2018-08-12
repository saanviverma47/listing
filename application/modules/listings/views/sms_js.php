/*----------------------------------------------------*/
/*	Send SMS Form
/*----------------------------------------------------*/
  if ($("#sms_mobile").intlTelInput) {
    $("#sms_mobile").intlTelInput({defaultCountry: "<?php echo strtolower($this->session->userdata('search_country'));?>", validationScript: "<?php echo base_url("assets/js/isValidNumber.js"); ?>"});
    $(".intl-tel-input.inside").css('width', '100%');
  }

  $('#sendSMSForm input')
    .not('.optional,.no-asterisk')
    .after('<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>');

  $("#sendSMS").click(function() {
    var $btn = $(this);
    $btn.button('loading');
    smsForm.clearErrors();

    var hasErrors = false;
    $('#sms_mobile, #sms_captcha_code').not('.optional').each(function() {
      var $this = $(this);
      if (($this.is(':checkbox') && !$this.is(':checked')) || !$this.val()) {
      	hasErrors = true;
        smsForm.addError($(this));        
      }
    });
    
    var $mobile = $('#sms_mobile');
    if ($mobile.val() && $mobile.intlTelInput && !$mobile.intlTelInput("isValidNumber")) {
      hasErrors = true;
      smsForm.addError($mobile.parent());
    }

    if (hasErrors) {
      $btn.button('reset');
      return false;
    }

	var sendSMSData = $("#sendSMSForm").serialize();
    var listing_id = $('#listing_id').val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('sendSMS');?>",
      data: sendSMSData + '&listing_id='+listing_id + '&<?php echo $this->security->get_csrf_token_name(); ?>=' +'<?php echo $this->security->get_csrf_hash(); ?>',
      success: function(data) {
        smsForm.addAjaxMessage(data.message, false);
        smsForm.clearForm();
		$("#sms_captcha").attr('src', '<?php echo site_url('securimage?');?>' + Math.random());
      },
      error: function(response) {
        smsForm.addAjaxMessage($.parseJSON(response.responseText).message, true);
      },
      complete: function() {
        $btn.button('reset');        
      }
   });
    return false;
  });
  $('#sendSMSForm input').change(function () {
    var asteriskSpan = $(this).siblings('.glyphicon-asterisk');
    if ($(this).val()) {
      asteriskSpan.css('color', '#00FF00');
    } else {
      asteriskSpan.css('color', 'black');
    }
  });

var smsForm = {
  clearErrors: function () {
    $('#smsFeedback').remove();
    $('#sendSMSForm .help-block').hide();
    $('#sendSMSForm .form-group').removeClass('has-error');
  },
  clearForm: function () {  	
    $('.glyphicon-asterisk').css('color', 'black');
    $('#sendSMSForm input,textarea').val("");
  },
  addError: function ($input) {
    var parentFormGroup = $input.parents('.form-group');
    parentFormGroup.children('.help-block').show();
    parentFormGroup.addClass('has-error');
  },
  addAjaxMessage: function(msg, isError) {
    $("#smsAlert").before('<div id="smsFeedback" class="alert alert-' + (isError ? 'danger' : 'success') + '">' + $('<div></div>').text(msg).html() + '</div>'); 
  } 
}; 

// SEND SMS Captcha Refresh 
$( "#sms_update" ).on( "click", function( e ) { 
	var $icon = $( this ).find( ".glyphicon.glyphicon-refresh" ), 
	animateClass = "glyphicon-refresh-animate"; $icon.addClass( animateClass );
	window.setTimeout( function() { $icon.removeClass( animateClass ); },
	2000 );
}); 

