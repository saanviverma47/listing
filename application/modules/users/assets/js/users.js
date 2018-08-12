$(document)
		.ready(
				function() {
					var telInput = $("#mobile_number"), errorMsg = $("#error-msg"), validMsg = $("#valid-msg");
					var defaultCountry = $('#mobile_country_iso').val(); // get default country value from hidden field
					// initialise plugin
					telInput.intlTelInput({
						defaultCountry : defaultCountry,
						utilsScript : site_url + "js/utils.js"
					});
					$(".intl-tel-input.inside").css('width', '100%');

					// on blur: validate
					telInput.blur(function() {
						if ($.trim(telInput.val())) {
							if (telInput.intlTelInput("isValidNumber")) {
								validMsg.removeClass("hide");
							} else {
								telInput.addClass("error");
								errorMsg.removeClass("hide");
								validMsg.addClass("hide");
							}
						}
					});

					// on keydown: reset
					telInput.keydown(function() {
						telInput.removeClass("error");
						errorMsg.addClass("hide");
						validMsg.addClass("hide");
					});

					/*----------------------------------------------------*/
					/*
					 * Login Form - Retaining Selected Form on Page Refresh
					 * /*----------------------------------------------------
					 */
					// load form on click event and set cookie with a custom
					// value
					$('a#reset_password_box').click(function() {
						$('#loginbox').hide();
						$('#signupbox').hide();
						$('#passwordresetbox').show();
						// $('#passwordresetalert').clear(); //clear all errors
						// of previous forms
						$.cookie('formbox', 'reset');
						return false;
					});

					$('a#signup_box').click(function() {
						$('#passwordresetbox').hide();
						$('#loginbox').hide();
						$('#signupbox').show();
						// $('#signupalert').clear();
						$.cookie('formbox', 'signup');
						return false;
					});

					$('a#signin_box').click(function() {
						$('#passwordresetbox').hide();
						$('#loginbox').show();
						$('#signupbox').hide();
						$.cookie('formbox', 'login');
						return false;
					});

					// on page load retrieve the cookie and show formbox based
					// on cookie value
					$(function() {
						if ($.cookie('formbox') == 'reset') {
							$('#loginbox').hide();
							$('#passwordresetbox').show();
							$('#signupbox').hide();
						} else if ($.cookie('formbox') == 'signup') {
							$('#passwordresetbox').hide();
							$('#loginbox').hide();
							$('#signupbox').show();
						} else {
							$('#loginbox').show();
							$('#signupbox').hide();
							$('#passwordresetbox').hide();
						}
					});
				});