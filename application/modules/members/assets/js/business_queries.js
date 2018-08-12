/*----------------------------------------------------*/
/*	Send Email Query
/*----------------------------------------------------*/
$(document).ready(function() {
  var csrf_token = $.cookie('ci_csrf_token');
  var site_url = $('#site_url').val();
  $('#email_subject, #email_captcha_code')
    .not('.optional,.no-asterisk')
    .after('<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>');

  $("#sendEmail").click(function() {
    var $btn = $(this);
    $btn.button('loading');
    emailForm.clearErrors();

    var hasErrors = false;
    $('#email_subject, #email_message, #email_captcha_code').not('.optional').each(function() {
      var $this = $(this);
      if (($this.is(':checkbox') && !$this.is(':checked')) || !$this.val()) {
      	hasErrors = true;
        emailForm.addError($(this));        
      }
    });
    
    if (hasErrors) {
      $btn.button('reset');
      return false;
    }

    var sendEmailData = $("#sendEmailForm").serialize();
    var query_id = $('#query_id').val();
    //send the feedback e-mail
    $.ajax({
      type: "POST",
      url: site_url + 'members/sendEmail',
      data: sendEmailData + '&query_id='+ query_id +'&ci_csrf_token=' + csrf_token,
      success: function(data) {
        emailForm.addAjaxMessage(data.message, false);
        emailForm.clearForm();
		$("#email_captcha").attr('src', site_url + 'listings/securimage?' + Math.random());
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

//namespace as not to pollute global namespace
var emailForm = {
  isValidEmail: function (email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  },  
  clearErrors: function () {
    $('#emailFeedback').remove(); // important or message will be displayed repeatedly
    $('#sendEmailForm .help-block').hide();
    $('#sendEmailForm .form-group').removeClass('has-error');
  },
  clearForm: function () {
    $('.glyphicon-asterisk').css('color', 'black');
    $('#email_subject, #email_message, #email_captcha_code').val("");
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

// Reply Captcha Refresh
  $( "#email_update" ).on( "click", function( e ) {
    var $icon = $( this ).find( ".glyphicon.glyphicon-refresh" ),
      animateClass = "glyphicon-refresh-animate";

    $icon.addClass( animateClass );
    window.setTimeout( function() {
      $icon.removeClass( animateClass );
    }, 2000 );
});
  
/*----------------------------------------------------*/
/*	Get Form ID To Send Message
/*----------------------------------------------------*/
$('.query').click(function(){
  	var query_id =  $(this).attr('id'); // retrieve value from form
  	$("#query_id").val(query_id);  // Store value into hidden input
  });
});