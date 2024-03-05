jQuery(function ($) {
	/**
	 * Check test
	 */
	$("#test #btn-submit").click(function (e) {
		e.preventDefault();
		let answers = {
			question01: $("#question1 [name='question1']:checked").val(),
			question02: $("#question2 [name='question2']:checked").val(),
			question03: $("#question3 [name='question3']:checked").val(),
			question04: $("#question4 [name='question4']:checked").val(),
			question05: $("#question5 [name='question5']:checked").val(),
			question06: $("#question6 [name='question6']:checked").val(),
			question07: $("#question7 [name='question7']:checked").val(),
			question08: $("#question8 [name='question8']:checked").val(),
			question09: $("#question9 [name='question9']:checked").val(),
			question10: $("#question10 [name='question10']:checked").val(),
			question11: $("#question11 [name='question11']:checked").val(),
			question12: $("#question12 [name='question12']:checked").val(),
			question13: $("#question13 [name='question13']:checked").val(),
			question14: $("#question14 [name='question14']:checked").val(),
			question15: $("#question15 [name='question15']:checked").val(),
			question16: $("#question16 [name='question16']:checked").val(),
			question17: $("#question17 [name='question17']:checked").val(),
			question18: $("#question18 [name='question18']:checked").val(),
			question19: $("#question19 [name='question19']:checked").val(),
			question20: $("#question20 [name='question20']:checked").val(),
			question21: $("#question21 [name='question21']:checked").val(),
			question22: $("#question22 [name='question22']:checked").val(),
			question23: $("#question23 [name='question23']:checked").val(),
			question24: $("#question24 [name='question24']:checked").val(),
			question25: $("#question25 [name='question25']:checked").val(),
			question26: $("#question26 [name='question26']:checked").val(),
			question27: $("#question27 [name='question27']:checked").val(),
			question28: $("#question28 [name='question28']:checked").val(),
			question29: $("#question29 [name='question29']:checked").val(),
			question30: $("#question30 [name='question30']:checked").val(),
		};

		let emptyValues = false;
		$.each(answers, function (key, value) {
			if (!value) {
				emptyValues = true;
				return false;
			}
		});
		if (emptyValues) {
			$(".messages").append(
				"No podrás comprobar el examen hasta enviar todas tus respuestas"
			);
			setTimeout(() => {
				$(".messages").text("");
			}, 3000);
		} else {
			$(this).remove();
			checkAnswers(answers);
		}
	});
	function checkAnswers(answers) {
		let totalPoints = 0;
		$.each(answers, function (key, value) {
			let penultimate = key.charAt(key.length - 2);
			let last = key.charAt(key.length - 1);
			let finalKey = penultimate == 0 ? last : penultimate + last;

			if (
				$(`#question${finalKey}`).find("[checked]").val() ==
				($(`#question${finalKey}`).next('input[type="hidden"]').val() * 2) / 3
			) {
				totalPoints++;
			}
		});
		let percentage = Math.ceil(totalPoints * 3.3333);
		var message = "";
		var buttons;

		$("#results").append(`
			<p class="percentage">${percentage}%</p>
			<p class="total">Has acertado ${totalPoints}/30 preguntas</p>
			<p align="center" id="spinner"><img src="${directory_uri.stylesheetUrl}/static/img/spinner.gif" width="50"></p>
		`);
		if (percentage >= 80) {
			let courseId = $("main").data("course");
			let courseCredits = $("main").data("credits");
			let userId = $("#account").data("id");

			// Pass test
			$.ajax({
				method: "POST",
				url: `${directory_uri.rootUrl}/wp-json/user-courses/post`,
				data: {
					userId: userId,
					courseId: courseId,
					credits: courseCredits,
					grade: percentage,
				},
			}).done(function (res) {
				// Get user data
				if (res.success == false && res.message == "Course already completed") {
					$("#results #spinner").remove();
					$("#results").append(`
									<p class="message">Ya se había completado el examen</p>
									<div class="buttons">
										<a id="btn-back" href="${directory_uri.rootUrl}/curso/actualizacion-del-abordaje-terapeutico-del-paciente-con-dislipemia/" class="button button-xl">Volver al curso</a>
										<a id="btn-certificate-exam" class="button button-xl">Descargar certificado</a>
									</div>
									`);
					$("#btn-certificate-exam").click((e) => registerData(e));
				} else {
					$.ajax({
						url: `${directory_uri.rootUrl}/wp-json/user/list?userId=${userId}`,
					}).done(function (userData) {
						let access = {
							user: `${directory_uri.API_USER}`,
							pass: `${directory_uri.API_PASS}`,
						};
						// Register user in certificates platform
						$.ajax({
							method: "PUT",
							url: `${directory_uri.API_HOST_PROD}/login/1`,
							headers: {
								"Content-Type": "application/json",
							},
							data: JSON.stringify(access),
						}).done(function (loginMessage) {
							let token = loginMessage.messages.data.token;
							userData.course = 14;
							$.ajax({
								method: "POST",
								headers: {
									Token: token,
								},
								url: `${directory_uri.API_HOST_PROD}/registerexternal`,
								data: JSON.stringify(userData),
							})
								.done(function (apiMessage) {
									$("#results #spinner").remove();
									$("#results").append(`
									<p class="message">¡Enhorabuena! Has aprobado el examen, descarga ya tu diploma</p>
									<div class="buttons">
										<a id="btn-back" href="${directory_uri.rootUrl}/curso/actualizacion-del-abordaje-terapeutico-del-paciente-con-dislipemia/" class="button button-xl">Volver al curso</a>
										<a id="btn-certificate-exam" class="button button-xl">Descargar certificado</a>
									</div>
									`);
									$("#btn-certificate-exam").click((e) => registerData(e));
								})
								.error(function (apiMessage) {
									if (apiMessage.error) {
										$("#results #spinner").remove();
										$("#results").append(`
										<p class="message">Ya se había completado el examen</p>
										<div class="buttons">
											<a id="btn-back" href="${directory_uri.rootUrl}/curso/actualizacion-del-abordaje-terapeutico-del-paciente-con-dislipemia/" class="button button-xl">Volver al curso</a>
											<a id="btn-certificate-exam" class="button button-xl">Descargar certificado</a>
										</div>
										`);
										$("#btn-certificate-exam").click((e) => registerData(e));
									}
								});
						});
					});
				}
			});
		} else {
			$("#results").append(`
				<p class="message">Has sacado menos del 80% de la puntuación exigida. ¡No te preocupes!, inténtalo de nuevo.</p>
					<div class="buttons">
						<a id="btn-back" href="${directory_uri.rootUrl}/curso/actualizacion-del-abordaje-terapeutico-del-paciente-con-dislipemia/" class="button button-xl">Volver al curso</a>
						<a id="btn-refresh" onClick="window.location.reload();" class="button button-xl">Intentarlo de nuevo</a>
					</div>
			`);
		}

		$("#results").css("transform", "translate(-50%, -50%)");

		$("#overlay").addClass("active");
		$("#results").addClass("active");

		/**
		 * Generate certificate
		 */
		$("#btn-certificate-exam").click((e) => registerData(e));
		// function registerData(e) {
		// 	e.preventDefault();
		// 	let userId = $("#account").data("id");
		// 	let rootUrl = `${directory_uri.rootUrl}/certificado`;

		// 	$.get(
		// 		`${directory_uri.rootUrl}/wp-json/user-courses/list?userId=${userId}`,
		// 		function (course) {
		// 			window.jsPDF = window.jspdf.jsPDF;

		// 			var options = { year: "numeric", month: "long", day: "numeric" };
		// 			var date = new Date(course.superado);
		// 			date = date.toLocaleDateString("es-ES", options);

		// 			var name = $("#account").attr("title");
		// 			var doc = new jsPDF({
		// 				orientation: "landscape",
		// 			});
		// 			var img = new Image();
		// 			img.onload = function () {
		// 				doc.addImage(this, 0, 0, 297, 210);
		// 				doc.setTextColor(88, 88, 87);

		// 				doc.setFont("Times");
		// 				doc.setFontSize(15);
		// 				/* text, x, y, null, null, alignment */
		// 				doc.text(name, 69, 86, null, null, "left");

		// 				doc.setFont("Times");
		// 				doc.setFontSize(15);
		// 				doc.text(date, 45, 132, null, null, "left");
		// 			};
		// 			img.crossOrigin = "";
		// 			if ($(this).data("certificate-type") > 0) {
		// 				img.src = `${directory_uri.stylesheetUrl}/static/img/certificado.jpg`;
		// 			} else {
		// 				img.src = `${directory_uri.stylesheetUrl}/static/img/certificado_new.jpg`;
		// 			}

		// 			var img2 = new Image();
		// 			img2.onload = function () {
		// 				doc.addImage(this, 23, 17, 25, 25);
		// 				doc.save("certificado-k9umlaude.pdf");
		// 			};
		// 			img2.crossOrigin = "";
		// 			img2.src =
		// 				"https://chart.googleapis.com/chart?cht=qr&chs=100x100&chld=L&chl=" +
		// 				rootUrl +
		// 				"?data=med" +
		// 				userId;
		// 		}
		// 	);
		// }
	}
	/**
	 * Generate certificate from course
	 */
	$("#course #btn-certificate").click((e) => registerData(e));
	function registerData(e) {
		e.preventDefault();
		let userId = $("#account").data("id");
		let rootUrl = `${directory_uri.rootUrl}/certificado`;

		$.get(
			`${directory_uri.rootUrl}/wp-json/user-courses/list?userId=${userId}`,
			function (course) {
				window.jsPDF = window.jspdf.jsPDF;

				var options = { year: "numeric", month: "long", day: "numeric" };
				var date = new Date(course.superado);
				date = date.toLocaleDateString("es-ES", options);

				var name = $("#account").attr("title");
				var doc = new jsPDF({
					orientation: "landscape",
				});
				var img = new Image();
				img.onload = function () {
					doc.addImage(this, 0, 0, 297, 210);
					doc.setTextColor(88, 88, 87);

					doc.setFont("Times");
					doc.setFontSize(15);
					/* text, x, y, null, null, alignment */
					doc.text(name, 69, 86, null, null, "left");

					doc.setFont("Times");
					doc.setFontSize(15);
					doc.text(date, 45, 132, null, null, "left");
				};
				img.crossOrigin = "";
				if ($(this).data("certificate-type") > 0) {
					img.src = `${directory_uri.stylesheetUrl}/static/img/certificado_new.jpg`;
				} else {
					img.src = `${directory_uri.stylesheetUrl}/static/img/certificado.jpg`;
				}

				var img2 = new Image();
				img2.onload = function () {
					doc.addImage(this, 23, 17, 25, 25);
					doc.save("certificado-k9umlaude.pdf");
				};
				img2.crossOrigin = "";

				var userAccess = JSON.stringify({
					user: directory_uri.API_USER,
					pass: directory_uri.API_PASS,
				});

				fetch(`${directory_uri.API_HOST_PROD}/login/1`, {
					method: "PUT",
					body: userAccess,
					headers: { "Content-type": "application/json;charset=UTF-8" },
				})
					.then((response) => response.json())
					.then((data) => {
						var dni = $("#account").data("nif");
						fetch(`${directory_uri.API_HOST_PROD}/emitcertificate/${dni}`, {
							headers: {
								"Content-type": "application/json;charset=UTF-8",
								Token: data.messages.data.token,
							},
						})
							.then((response) => response.json())
							.then((data) => {
								let cvs = encryptWithAES(
									data.data.userId + "CVS" + data.data.courseId
								).replaceAll("+", "-");
								toDataURL(
									`https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=${directory_uri.HOST_PROD}/informe?cvs=${cvs}&choe=UTF-8`,
									function (base64qr) {
										qr.value = base64qr;
									}
								);
								img2.src =
									"https://chart.googleapis.com/chart?cht=qr&chs=100x100&chld=L&chl=" +
									`${directory_uri.HOST_PROD}/informe?cvs=` +
									cvs;
							});
					});
			}
		);
	}
	const encryptWithAES = (text) => {
		const passphrase = "integracion";
		return CryptoJS.AES.encrypt(text, passphrase).toString();
	};
	const toDataURL = (url, callback) => {
		var xhr = new XMLHttpRequest();
		xhr.onload = function () {
			var reader = new FileReader();
			reader.onloadend = function () {
				callback(reader.result);
			};
			reader.readAsDataURL(xhr.response);
		};
		xhr.open("GET", url);
		xhr.responseType = "blob";
		xhr.send();
	};
});
