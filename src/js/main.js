jQuery(function ($) {
	$("#custom-scroll").overlayScrollbars({
		scrollbars: {
			autohide: "move",
		},
	});
	// SELECTS FIRST SUBCHAPTER (JUST FOR TEST)
	$("#module").ready(function () {
		$(".subchapters li:first a").addClass("selected");
		getVideoFromSubchapter($(".subchapters .selected").data("id"));
	});
	// CHANGES REMAINING TIME (JUST FOR TEST)
	let count = 0;
	$(".count").each(function () {
		count = count + parseInt($(this).text());
	});
	// ON PRESSING ENTER IN A FORM FOLLOWS .submit URL (JUST FOR TEST)
	$("form").keypress(function (e) {
		e.preventDefault();
		if (e.which === 13) {
			var button = $(this).find(".submit")[0];
			var url = $(button).attr("href");
			window.location.href = url;
		}
	});
	setTimeout(() => {
		$(".remaining span").html(count);
	}, 1000);
	/* ON INIT */
	$("#program .module.selected").find(".info").show();
	$(".owl-carousel").owlCarousel({
		loop: true,
		nav: false,
		dots: false,
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
	/* EVENTS */
	// CLICK
	$("#program .module").click(function (e) {
		e.preventDefault();
		$(this).toggleClass("selected");
		$(this).find(".info").slideToggle();
	});
	$(".subchapters a").click(function (e) {
		e.preventDefault();
		$(".subchapters a").removeClass("selected");
		$(this).addClass("selected");
		console.log($(this).data("id"));
		getVideoFromSubchapter($(this).data("id"));
	});
	$("#btn-goToStep1").click(function (e) {
		e.preventDefault();
		$(this).hide(0);
		$("#image").hide(0);
		$("#steps").fadeIn("slow");
	});
	$("#btn-goToStep2").click(function (e) {
		e.preventDefault();
		$(".step").css({
			transform: "translateX(-100%)",
			transition: ".5s all ease-in",
		});
		setTimeout(() => {
			$("#progressbar li:nth-child(2)").addClass("active");
		}, 500);
	});
	$("#btn-goToStep3").click(function (e) {
		e.preventDefault();
		$(".step").css({
			transform: "translateX(-200%)",
			transition: ".5s all ease-in",
		});
		setTimeout(() => {
			$("#progressbar li:nth-child(3)").addClass("active");
		}, 500);
	});
	// PRESS
	$("label").keypress(function (e) {
		e.preventDefault();
		if (e.which === 32) {
			var ischecked = $(this).parent().find("input").prop("checked");
			$(this).parent().find("input").prop("checked", !ischecked);
		}
	});

	function getVideoFromSubchapter(subchapterId) {
		$("#content .module-content-display").html(
			`<div class="loader"><img src="${directory_uri.stylesheetUrl}/static/img/loader.gif"></div>`
		);
		$.get(
			`${directory_uri.rootUrl}/wp-json/wp/v2/subcapitulo/${subchapterId}`,
			function (subchapter) {
				$.get(
					`${directory_uri.rootUrl}/wp-json/wp/v2/media/${subchapter.acf.video}`,
					function (data) {
						if (subchapter.acf.text) {
							console.log(subchapter);
							$("#content .module-content-display").html(
								`
									<div class="content">
										<video controls>
											<source src="${data.source_url}" type="video/mp4">
											Su navegador no soporta vídeos
										</video>
										<div class="subchapter-text">
											<h2>${subchapter.title.rendered}</h2>
											<p>${subchapter.acf.text}</p>
										</div>
									</div>`
							);
						} else {
							$("#content .module-content-display").html(
								`
									<div class="content">
										<video controls>
											<source src="${data.source_url}" type="video/mp4">
											Su navegador no soporta vídeos
										</video>
									</div>`
							);
						}
						setTimeout(function () {
							$("#content .module-content-display div").css({
								visibility: "visible",
								transition: ".1s all ease-in",
							});
						}, 200);
					}
				);
			}
		);
	}
});
