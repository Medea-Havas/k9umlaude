jQuery(function ($) {
	var newUser = {
		name: null,
		first_lastname: null,
		second_lastname: null,
		gender: "Masculino",
		dni_nie: null,
		phone: null,
		email: null,
		specialty: null,
		medical_society: null,
		working_province: null,
		collegiate_province: null,
		assigned_number: null,
		password: null,
		legal: 0,
		personal_data: 0,
	};
	// TODO: Just for test
	$("#register .wrapper").append(`
		<div class="container newUser">
			<pre>
			${JSON.stringify(newUser, null, 2)}
			</pre>
		</div>
	`);
	/**
	 * ----- REGISTER FORM -----
	 */
	if ($("#register").length) {
		/**
		 * ----- PERSONAL DATA -----
		 */
		// Name
		$("#register input").focus(function () {
			$(this).removeClass("wrong");
		});
		$("#register #name").focusout(function () {
			if ($(this).val() !== "") {
				newUser.name = $(this).val();
				// TODO: Just for test
				updateUser();
			} else $(this).addClass("wrong");
		});
		// First Last Name
		$("#register #first-lastname").focusout(function (e) {
			if ($(this).val() !== "") {
				newUser.first_lastname = $(this).val();
				// TODO: Just for test
				updateUser();
			} else $(this).addClass("wrong");
			isValidDataForm();
		});
		// Second Last Name
		$("#register #second-lastname").focusout(function (e) {
			if ($(this).val() !== "") {
				newUser.second_lastname = $(this).val();
				// TODO: Just for test
				updateUser();
			} else $(this).addClass("wrong");
			isValidDataForm();
		});
		// DNI-NIE
		$("#register #dni").focusout(function (e) {
			if ($(this).val() !== "") {
				var value = $(this).val().toUpperCase();
				var isValid = checkNIFNIE(value);
				if (isValid) {
					newUser.dni_nie = $(this).val();
					// TODO: Just for test
					updateUser();
				} else {
					$(this).addClass("wrong");
				}
			} else $(this).addClass("wrong");
			isValidDataForm();
		});
		// Email
		$("#register #email").focusout(function (e) {
			var isValid = checkMail($(this).val());
			if (isValid) {
				newUser.email = $(this).val();
				// TODO: Just for test
				updateUser();
			} else $(this).addClass("wrong");
			isValidDataForm();
		});
		// Phone
		$("#register #phone").focusout(function (e) {
			var value = $(this).val();
			var isValid = $.isNumeric(value) && parseInt(value) > 111111111;
			if (isValid) {
				newUser.phone = $(this).val();
				// TODO: Just for test
				updateUser();
			} else $(this).addClass("wrong");
			isValidDataForm();
		});
		// Gender
		$("#register #gender input").click(function (e) {
			$("#register #gender label").removeClass("selected");
			$(this).parent().addClass("selected");
			var selected = $(this).parent().text().trim();
			if (selected === "Prefiero no especificarlo") {
				selected = "No especificado";
			}
			newUser.gender = selected;
			// TODO: Just for test
			updateUser();
			isValidDataForm();
		});
		// CHECK-VALIDATE
		function isValidDataForm() {
			if (
				newUser.name !== "" &&
				newUser.first_lastname !== "" &&
				newUser.second_lastname !== "" &&
				newUser.dni !== "" &&
				newUser.email !== "" &&
				newUser.phone !== ""
			)
				$("#btn-goToStep2").removeClass("disabled");
		}
		function checkNIFNIE(value) {
			value = value.toUpperCase();
			// Basic format test
			if (
				!value.match(
					"((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)"
				)
			) {
				return false;
			}
			// Test NIF
			if (/^[0-9]{8}[A-Z]{1}$/.test(value)) {
				return (
					"TRWAGMYFPDXBNJZSQVHLCKE".charAt(value.substring(8, 0) % 23) ===
					value.charAt(8)
				);
			}
			// Test NIE
			//XYZ
			if (/^[XYZ]{1}/.test(value)) {
				return (
					value[8] ===
					"TRWAGMYFPDXBNJZSQVHLCKE".charAt(
						value
							.replace("X", "0")
							.replace("Y", "1")
							.replace("Z", "2")
							.substring(0, 8) % 23
					)
				);
			}
			return false;
		}
		function checkMail(value) {
			if (value === "") return false;
			var regex =
				/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(value);
		}
		/**
		 * ----- PROFESSIONAL DATA -----
		 */
		// Specialty
		$("#register #specialty")
			.parent()
			.find("li")
			.click(function (e) {
				var value = $("#register #specialty")
					.parent()
					.find(".select-styled")
					.text();
				if (value) {
					newUser.specialty = value;
					$("#register #specialty")
						.parent()
						.find(".select-styled")
						.removeClass("wrong");
					// TODO: Just for test
					updateUser();
				}
				isValidProfessionalForm();
			});
		// Wrong if specialty is empty
		$("#register #specialty")
			.parent()
			.find(".select-styled")
			.click(function () {
				if ($("#register #specialty").val() === "hide") {
					$(this).addClass("wrong");
				}
			});
		// Medical Society
		$("#register #medicalsociety")
			.parent()
			.find("li")
			.click(function (e) {
				var value = $("#register #medicalsociety")
					.parent()
					.find(".select-styled")
					.text();
				newUser.medical_society = value;
				// TODO: Just for test
				updateUser();
			});
		// College number 1
		$("#register #collegenumber1")
			.parent()
			.find("li")
			.click(function (e) {
				var value = $("#register #collegenumber1")
					.parent()
					.find(".select-styled")
					.text();
				if (value) {
					$("#register #collegenumber1")
						.parent()
						.find(".select-styled")
						.removeClass("wrong");
					newUser.working_province = value;
				}
				// TODO: Just for test
				updateUser();
				isValidProfessionalForm();
			});
		// Wrong if collegenumber1 is empty
		$("#register #collegenumber1")
			.parent()
			.find(".select-styled")
			.click(function () {
				if ($("#register #collegenumber1").val() === "hide") {
					$(this).addClass("wrong");
				}
			});
		// College number 2
		$("#register #collegenumber2")
			.parent()
			.find("li")
			.click(function (e) {
				var value = $("#register #collegenumber2")
					.parent()
					.find(".select-styled")
					.text();
				if (value) {
					$("#register #collegenumber2")
						.parent()
						.find(".select-styled")
						.removeClass("wrong");
					newUser.collegiate_province = value;
				}
				// TODO: Just for test
				updateUser();
				isValidProfessionalForm();
			});
		// Wrong if collegenumber2 is empty
		$("#register #collegenumber2")
			.parent()
			.find(".select-styled")
			.click(function () {
				if ($("#register #collegenumber2").val() === "hide") {
					$(this).addClass("wrong");
				}
			});
		// Correlative number
		$("#register #correlativenum").focusout(function () {
			if ($(this).val().length !== 5 || isNaN($(this).val())) {
				$(this).addClass("wrong");
			} else {
				newUser.assigned_number = $(this).val();
				$(this).removeClass("wrong");
			}
			// TODO: Just for test
			updateUser();
			isValidProfessionalForm();
		});
		function isValidProfessionalForm() {
			if (
				newUser.specialty !== "" &&
				newUser.collegiate_province !== "" &&
				newUser.working_province !== "" &&
				newUser.correlativenum !== ""
			) {
				$("#btn-goToStep3").removeClass("disabled");
			}
		}
		/**
		 * ----- PASSWORD AND LEGAL -----
		 */
		$("#register #password").focusout(function () {
			if ($(this).val() !== "" && $(this).val().length >= 8) {
				$(this).removeClass("wrong");
				checkPass();
			} else $(this).addClass("wrong");
			isValidPasswordAndLegal();
		});
		$("#register #confirm").focusout(function () {
			if (
				$(this).val() !== "" &&
				$(this).val() === $("#register #password").val()
			) {
				$(this).removeClass("wrong");
				checkPass();
			} else $(this).addClass("wrong");
			isValidPasswordAndLegal();
		});
		$("#register #accept2")
			.parent()
			.find("label")
			.click(function () {
				if ($("#register #accept2").hasClass("off")) {
					$("#register #accept2").removeClass("off");
					$("#register #accept2").addClass("on");
					newUser.legal = 1;
				} else {
					$("#register #accept2").removeClass("on");
					$("#register #accept2").addClass("off");
					newUser.legal = 0;
				}
				// TODO: Just for test
				updateUser();
				isValidPasswordAndLegal();
			});
		$("#register #accept3")
			.parent()
			.find("label")
			.click(function () {
				if ($("#register #accept3").hasClass("off")) {
					$("#register #accept3").removeClass("off");
					$("#register #accept3").addClass("on");
					newUser.personal_data = 1;
				} else {
					$("#register #accept3").removeClass("on");
					$("#register #accept3").addClass("off");
					newUser.personal_data = 0;
				}
				// TODO: Just for test
				updateUser();
			});
		function checkPass() {
			var pass = $("#register #password").val();
			var confirm = $("#register #confirm").val();
			if (
				pass !== "" &&
				confirm !== "" &&
				pass === confirm &&
				pass.length >= 8
			) {
				newUser.password = pass;
				// TODO: Just for test
				updateUser();
			}
		}
		function isValidPasswordAndLegal() {
			if (newUser.password && newUser.legal) {
				$("#btn-submit").removeClass("disabled");
			}
		}
		// submit
		$("#btn-submit").click(function (e) {
			e.preventDefault();
			$(".acf-form-submit input").trigger("click");
		});
		// TODO: JUST FOR TEST Update user
		function updateUser() {
			$("#register .wrapper .newUser pre").html(`
				${JSON.stringify(newUser, null, 2)}
		`);
		}
	}
});
