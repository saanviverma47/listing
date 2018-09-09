/*----------------------------------------------------*/
/*	Category View Enquiry Form
/*----------------------------------------------------*/
if ($("#phone").intlTelInput) {
    $("#phone").intlTelInput({defaultCountry: "<?php echo strtolower($this->session->userdata('search_country'));?>", validationScript: "<?php echo base_url("assets/js/isValidNumber.js"); ?>"});
    $(".intl-tel-input.inside").css('width', '100%');
  }
  
$('.query').click(function(){
  	var listing_id =  $(this).attr('id'); // retrieve value from form
  	 $("#listing_value").val(listing_id);  // Store value into hidden input
  	 $('#contact_form_fields').show(); // Show fields on query click  	 
  });

  $('#sendQueryForm input')
    .not('.optional,.no-asterisk')
    .after('<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>');

  $("#sendQuerySubmit").click(function() {
 
    var $btn = $(this);
    $btn.button('loading');
    contactForm.clearErrors();

    var hasErrors = false;
    $('#message').not('.optional').each(function() {
      var $this = $(this);
      if (($this.is(':checkbox') && !$this.is(':checked')) || !$this.val()) {
      	hasErrors = true;
        contactForm.addError($(this));        
      }
    });
	
    $('#name, #captcha_code').not('.optional').each(function() {
      var $this = $(this);
      if (($this.is(':checkbox') && !$this.is(':checked')) || !$this.val()) {
      	hasErrors = true;
        contactForm.addError($(this));        
      }
    });
	
    $('#captcha_code').each(function() {
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

    var sendQueryData = $("#sendQueryForm").serialize();
    var listing_id = $('#listing_value').val();
	 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('businessQuery');?>",
      data: sendQueryData + '&listing_id='+ listing_id + '&<?php echo $this->security->get_csrf_token_name(); ?>=' +'<?php echo $this->security->get_csrf_hash(); ?>',
      success: function(data) {
        contactForm.addAjaxMessage(data.message, false);
        contactForm.clearForm();
		$("#captcha").attr('src', '<?php echo site_url('securimage?');?>' + Math.random());
		$('#query-modal').data('hideInterval', setTimeout(function(){
            $('#query-modal').modal('hide');
        }, 1000));
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
  $('#sendQueryForm input').change(function () {
    var asteriskSpan = $(this).siblings('.glyphicon-asterisk');
    if ($(this).val()) {
      asteriskSpan.css('color', '#00FF00');
    } else {
      asteriskSpan.css('color', 'black');
    }
  });

var contactForm = {
  isValidEmail: function (email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  },
  clearErrors: function () {
    $('#sendQueryAlert').remove(); // important or message will be displayed repeatedly
    $('#sendQueryForm .help-block').hide();
    $('#sendQueryForm .form-group').removeClass('has-error');
  },
  clearForm: function () {
    $('.glyphicon-asterisk').css('color', 'black');
    $('#message, #name, #phone, #email, #captcha_code').val("");
    $('#contact_form_fields').hide(); // hide all fields after submission
  },
  addError: function ($input) {
    var parentFormGroup = $input.parents('.form-group');
    parentFormGroup.children('.help-block').show();
    parentFormGroup.addClass('has-error');
  },
  addAjaxMessage: function(msg, isError) {
    $("#contact_form").before('<div id="sendQueryAlert"	class="alert alert-' + (isError ? 'danger' : 'success') + '" style="margin-top: 5px;">' + $('<div></div>').text(msg).html() + '</div>');
  }
};

/*----------------------------------------------------*/
/*	Captcha Refresh Icon Spin Code
/*----------------------------------------------------*/
  $( "#update" ).on( "click", function( e ) {
    var $icon = $( this ).find( ".glyphicon.glyphicon-refresh" ),
      animateClass = "glyphicon-refresh-animate";

    $icon.addClass( animateClass );
    window.setTimeout( function() {
      $icon.removeClass( animateClass );
    }, 1000 );
}); 
