jQuery(function ($) {
	var acceptPrivacy = 0;
	$("#login-form #submit").click(function (e) {
		e.preventDefault();
		if (!$(this).hasClass("disabled")) {
			$(this).parent().find(".submit").trigger("click");
		}
	});
	$("#login-form #accept")
		.parent()
		.find("label")
		.click(function () {
			acceptPrivacy = !acceptPrivacy;
			checkLoginForm();
		});
	$("#login-form").keypress(function (e) {
		if (
			e.which === 13 &&
			!$(this).parent().find("#submit").hasClass("disabled")
		) {
			$(this).find(".submit").trigger("click");
		}
	});
	$("#login-form #accept")
		.parent()
		.find("label")
		.keypress(function (e) {
			if (e.which === 32) {
				acceptPrivacy = !acceptPrivacy;
				checkLoginForm();
			}
		});

	function checkLoginForm() {
		if ($("#login-form #email").val() && $("#pass").val() && acceptPrivacy) {
			$("#login-form #submit").removeClass("disabled");
		} else {
			$("#login-form #submit").addClass("disabled");
		}
	}
});
