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
	// TODO: SELECTS FIRST SUBCHAPTER (JUST FOR TEST)
	if ($("#module").length) {
		$(".chapters li a:first").addClass("selected");
		getVideoFromChapter($(".chapters .selected").data("id"));
	}
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
	$(".chapters a").click(function (e) {
		e.preventDefault();
		$(".chapters a").removeClass("selected");
		$(this).addClass("selected");
		getVideoFromChapter($(this).data("id"));
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
	// PRESS
	$("label").keypress(function (e) {
		e.preventDefault();
		if (e.which === 32) {
			var ischecked = $(this).parent().find("input").prop("checked");
			$(this).parent().find("input").prop("checked", !ischecked);
		}
	});

	function getVideoFromChapter(chapterId) {
		$("#content .module-content-display").html(
			`<div class="loader"><img src="${directory_uri.stylesheetUrl}/static/img/loader.gif"></div>`
		);
		$.get(
			`${directory_uri.rootUrl}/wp-json/wp/v2/chapter/${chapterId}`,
			function (chapter) {
				console.log(chapter);
				$.get(
					`${directory_uri.rootUrl}/wp-json/wp/v2/media?parent=${chapterId}`,
					function (data) {
						if (chapter.title) {
							$("#content .module-content-display").html(
								`
									<div class="content">
										<video controls>
											<source src="${data[0].source_url}" type="video/mp4">
											Su navegador no soporta vídeos
										</video>
										<div class="subchapter-text">
											<h2>${chapter.title.rendered}</h2>
										</div>
										<div class="chapter-text">${chapter.acf.chapter_text}</div>
									</div>`
							);
						} else {
							$("#content .module-content-display").html(
								`
									<div class="content">
										<video controls>
											<source src="${data[0].source_url}" type="video/mp4">
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
