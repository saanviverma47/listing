/*----------------------------------------------------*/
/*	Contact Us Form
 /*----------------------------------------------------*/
if ($("#phone").intlTelInput) {
	$("#phone").intlTelInput({defaultCountry: "<?php echo strtolower(settings_item('adv.default_country'));?>", validationScript: "<?php echo base_url("assets/js/isValidNumber.js"); ?>"});
	$(".intl-tel-input.inside").css('width', '100%');
}

$('#contactUsForm input')
.not('.optional,.no-asterisk')
.after('<span class="glyphicon glyphicon-asterisk form-control-feedback"></span>');

$("#contactSubmit").click(function() {
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

	var businessQueryData = $("#contactUsForm").serialize();
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('contactQuery');?>",
		data: businessQueryData + '&<?php echo $this->security->get_csrf_token_name(); ?>=' +'<?php echo $this->security->get_csrf_hash(); ?>',
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
$('#contactUsForm input').change(function () {
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
			$('#contactUsForm .help-block').hide();
			$('#contactUsForm .form-group').removeClass('has-error');
		},
		clearForm: function () {
			$('.glyphicon-asterisk').css('color', 'black');
			$('#contactUsForm input,textarea').val("");
		},
		addError: function ($input) {
			var parentFormGroup = $input.parents('.form-group');
			parentFormGroup.children('.help-block').show();
			parentFormGroup.addClass('has-error');
		},
		addAjaxMessage: function(msg, isError) {
			$("#contactUsMessage").after('<div id="contactQueryAlert" class="alert alert-' + (isError ? 'danger' : 'success') + '" style="margin-top: 5px;"> ' + $('<div></div>').text(msg).html() + '</div>');
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

