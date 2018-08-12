/*----------------------------------------------------*/
/*	Send Email Form
/*----------------------------------------------------*/
$('#sendEmailForm input').not('.optional,.no-asterisk').after('<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>');
  $("#sendEmail").click(function() {
    var $btn = $(this);
    $btn.button('loading');
    emailForm.clearErrors();

    var hasErrors = false;
    $('#email_to, #email_captcha_code').not('.optional').each(function() {
      var $this = $(this);
      if (($this.is(':checkbox') && !$this.is(':checked')) || !$this.val()) {
      	hasErrors = true;
        emailForm.addError($(this));        
      }
    });
    
    var $email = $('#email_to');
    if (!contactForm.isValidEmail($email.val())) {
      hasErrors = true;
      contactForm.addError($email);
    }
    
    if (hasErrors) {
      $btn.button('reset');
      return false;
    }

    var sendEmailData = $("#sendEmailForm").serialize();
    var listing_id = $('#listing_id').val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('sendEmail');?>",
      data: sendEmailData + '&listing_id='+listing_id + '&<?php echo $this->security->get_csrf_token_name(); ?>=' +'<?php echo $this->security->get_csrf_hash(); ?>',
      success: function(data) {
        emailForm.addAjaxMessage(data.message, false);
        emailForm.clearForm();
		$("#email_captcha").attr('src', '<?php echo site_url('securimage?');?>' + Math.random());
      },
      error: function(response) {
        emailForm.addAjaxMessage($.parseJSON(response.responseText).message, true);
      },
      complete: function() {
        $btn.button('reset');        
      }
   });
    return false;
  });
  $('#sendEmailForm input').change(function () {
    var asteriskSpan = $(this).siblings('.glyphicon-asterisk');
    if ($(this).val()) {
      asteriskSpan.css('color', '#00FF00');
    } else {
      asteriskSpan.css('color', 'black');
    }
  });

var emailForm = {
  isValidEmail: function (email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  },  
  clearErrors: function () {
    $('#emailFeedback').remove();
    $('#sendEmailForm .help-block').hide();
    $('#sendEmailForm .form-group').removeClass('has-error');
  },
  clearForm: function () {
    $('.glyphicon-asterisk').css('color', 'black');
    $('#email_to, #email_captcha_code').val("");
  },
  addError: function ($input) {
    var parentFormGroup = $input.parents('.form-group');
    parentFormGroup.children('.help-block').show();
    parentFormGroup.addClass('has-error');
  },
  addAjaxMessage: function(msg, isError) {
    $("#emailAlert").before('<div id="emailFeedback" class="alert alert-' + (isError ? 'danger' : 'success') + '">' + $('<div></div>').text(msg).html() + '</div>'); 
  } 
}; 

// SEND Email Captcha Refresh 
$( "#email_update" ).on( "click", function( e ) { 
	var $icon = $( this ).find(".glyphicon.glyphicon-refresh" ), 
	animateClass = "glyphicon-refresh-animate"; $icon.addClass( animateClass );
	window.setTimeout( function() { $icon.removeClass( animateClass ); },2000 ); 
});