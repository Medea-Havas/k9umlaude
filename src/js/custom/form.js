jQuery(function ($) {
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
			if ($(this).val() !== "")
				$("#acf-form #acf-field_621f42a531b11").val($(this).val());
			else $(this).addClass("wrong");
		});
		// First Last Name
		$("#register #first-lastname").focusout(function (e) {
			if ($(this).val() !== "")
				$("#acf-form #acf-field_621f42d131b12").val($(this).val());
			else $(this).addClass("wrong");
			isValidDataForm();
		});
		// Second Last Name
		$("#register #second-lastname").focusout(function (e) {
			if ($(this).val() !== "")
				$("#acf-form #acf-field_621f433731b13").val($(this).val());
			else $(this).addClass("wrong");
			isValidDataForm();
		});
		// DNI-NIE
		$("#register #dni").focusout(function (e) {
			if ($(this).val() !== "") {
				var value = $(this).val().toUpperCase();
				var isValid = checkNIFNIE(value);
				if (isValid) {
					$("#acf-form #acf-field_621f442e31b15").val($(this).val());
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
				$("#acf-form #acf-field_621f475731b16").val($(this).val());
			} else $(this).addClass("wrong");
			isValidDataForm();
		});
		// Phone
		$("#register #phone").focusout(function (e) {
			var value = $(this).val();
			var isValid = $.isNumeric(value) && parseInt(value) > 111111111;
			if (isValid) {
				$("#acf-form #acf-field_621f572531b1e").val(value);
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
			$(".acf-field-621f434731b14 .select-styled").html(selected);
			$("#acf-form #acf-field_621f434731b14 option").removeAttr("selected");
			$(
				"#acf-form #acf-field_621f434731b14 option[value='" + selected + "']"
			).attr("selected", "selected");
			isValidDataForm();
		});
		// CHECK-VALIDATE
		function isValidDataForm() {
			var name = $("#acf-field_621f42a531b11").val();
			var first_lastname = $("#acf-field_621f42d131b12").val();
			var second_lastname = $("#acf-field_621f433731b13").val();
			var dni = $("#acf-field_621f442e31b15").val();
			var email = $("acf-field_621f475731b16").val();
			var phone = $("acf-field_621f572531b1e").val();
			if (
				name !== "" &&
				first_lastname !== "" &&
				second_lastname !== "" &&
				dni !== "" &&
				email !== "" &&
				phone !== ""
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
				$(".acf-field-621f488a31b17 .select-styled").text(value);
				$("#acf-form #acf-form #acf-field_621f488a31b17 option").removeAttr(
					"selected"
				);
				$(
					"#acf-form #acf-field_621f488a31b17 option[value='" + value + "']"
				).attr("selected", "selected");
				$("#register #specialty")
					.parent()
					.find(".select-styled")
					.removeClass("wrong");
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
				$(".acf-field-621f57ea31b1f .select-styled").text(value);
				$("#acf-form #acf-form #acf-field_621f57ea31b1f option").removeAttr(
					"selected"
				);
				$(
					"#acf-form #acf-field_621f57ea31b1f option[value='" + value + "']"
				).attr("selected", "selected");
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
				$(".acf-field-621f502731b18 .select-styled").text(value);
				$("#acf-form #acf-field_621f502731b18 option").removeAttr("selected");
				var trimedValue = value.replace(/\s+/g, "");
				$("#acf-field_621f502731b18 option[value='" + trimedValue + "']").attr(
					"selected",
					"selected"
				);
				$("#register #collegenumber1")
					.parent()
					.find(".select-styled")
					.removeClass("wrong");
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
				$(".acf-field-621f528331b1a .select-styled").text(value);
				$("#acf-form #acf-field_621f528331b1a option").removeAttr("selected");
				var trimedValue = value.replace(/\s+/g, "");
				$("#acf-field_621f528331b1a option[value='" + trimedValue + "']").attr(
					"selected",
					"selected"
				);
				$("#register #collegenumber2")
					.parent()
					.find(".select-styled")
					.removeClass("wrong");
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
				$("#acf-form #acf-field_621f50f131b19").val($(this).val());
				$(this).removeClass("wrong");
			}
			isValidProfessionalForm();
		});
		function isValidProfessionalForm() {
			var specialty = $("#acf-field_621f488a31b17").val();
			var collegenumber1 = $("#acf-field_621f502731b18").val();
			var collegenumber2 = $("#acf-field_621f528331b1a").val();
			var correlativenum = $("#acf-field_621f50f131b19").val();
			if (
				specialty !== "" &&
				collegenumber1 !== "" &&
				collegenumber2 !== "" &&
				correlativenum !== ""
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
				$("#acf-field_621f566d31b1c").attr("checked", function (_, attr) {
					return !attr;
				});
			});
		$("#register #accept3")
			.parent()
			.find("label")
			.click(function () {
				$("#acf-field_621f56a231b1d").attr("checked", function (_, attr) {
					return !attr;
				});
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
				$("#acf-field_621f560831b1b").val(pass);
			}
		}
		function isValidPasswordAndLegal() {
			var pass = $("#acf-field_621f560831b1b").val();
			var legal = $("#acf-field_621f566d31b1c").val();
			if (pass !== "" && legal) {
				$("#btn-submit").removeClass("disabled");
			}
		}
		// submit
		$("#btn-submit").click(function (e) {
			e.preventDefault();
			$(".acf-form-submit input").trigger("click");
		});
	}
});
