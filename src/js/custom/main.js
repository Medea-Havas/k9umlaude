jQuery(function ($) {
	// SmoothScroll
	var scroll = new SmoothScroll('a[href*="#"]', {
		offset: 109,
	});
	// Custom scroll
	// if ($("#custom-scroll").length) {
	// 	$("#custom-scroll").overlayScrollbars({
	// 		scrollbars: {
	// 			autohide: "move",
	// 		},
	// 	});
	// }
	/* ON INIT */
	$("#temario .module.selected").find(".info").show();
	$(".owl-carousel").owlCarousel({
		loop: true,
		nav: false,
		dots: true,
		animateOut: "fadeOut",
		smartSpeed: 1000,
		autoplay: true,
		autoplayTimeout: 4000,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1,
			},
			600: {
				items: 2,
			},
			1300: {
				items: 3,
			},
			2000: {
				items: 4,
			},
			2600: {
				items: 5,
			},
		},
	});
	if ($("ul.chapters").length) {
		var nxt = $(".chapters .enabled").nextAll(".chapter-header").first();
		if (nxt.length) {
			$(nxt).addClass("enabled");
		}
	}
	/* EVENTS */
	// CLICK
	$("#temario .module").click(function (e) {
		e.preventDefault();
		$(this).toggleClass("selected");
		$(this).find(".info").slideToggle();
	});
	$("#btn-goToStep1").click(function (e) {
		e.preventDefault();
		$(this).hide(0);
		$("#image").hide(0);
		$("#steps, #step1").fadeIn("slow");
	});
	$("#btn-goToStep2").click(function (e) {
		e.preventDefault();
		var name = $("#name").val();
		var first_lastname = $("#first-lastname").val();
		var second_lastname = $("#second-lastname").val();
		$("#acf-_post_title").val(`${name} ${first_lastname} ${second_lastname}`);
		if (!$(this).hasClass("disabled")) {
			$("#step2").show(100);
			$(".step").css({
				transform: "translateX(-100%)",
				transition: ".5s all ease-in",
			});
			setTimeout(() => {
				$("#progressbar li:nth-child(2)").addClass("active");
			}, 500);
		}
	});
	$("#btn-goToStep3").click(function (e) {
		e.preventDefault();
		$("#step3").show(100);
		$(".step").css({
			transform: "translateX(-200%)",
			transition: ".5s all ease-in",
		});
		setTimeout(() => {
			$("#progressbar li:nth-child(3)").addClass("active");
		}, 500);
	});
	$("#test .container").click(function (e) {
		$(this).find("input").attr("checked", "checked");
	});
	$(".avatar").click(function (e) {
		e.preventDefault();
		$(this).parent().find(".button").toggleClass("mob-visible");
	});
	if ($("#poll").length) {
		// Fill user data form fields
		let usrId = $('.acf-form-submit input[type="submit"]').data("id");
		let usr = $('.acf-form-submit input[type="submit"]').data("usr");
		$('.acf-field[data-name="user_id"] input').val(usrId);
		$('.acf-field[data-name="user_name"] input').val(usr);
		$(".acf-field--post-title input").val(usr);
		// When form is sent succesfully
		if ($(".alert").length) {
			$(".alert").addClass("active");
			setTimeout(() => {
				$(".alert").removeClass("active");
				window.location.href = `${directory_uri.rootUrl}/curso/actualizacion-del-abordaje-terapeutico-del-paciente-con-dislipemia/`;
			}, 4000);
		}
	}
	// PRESS
	$("label").keypress(function (e) {
		e.preventDefault();
		if (e.which === 32) {
			var ischecked = $(this).parent().find("input").prop("checked");
			$(this).parent().find("input").prop("checked", !ischecked);
		}
	});
});
