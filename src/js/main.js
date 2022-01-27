jQuery(function ($) {
	$("#custom-scroll").overlayScrollbars({
		scrollbars: {
			autohide: "move",
		},
	});
	// SELECT FIRST SUBCHAPTER (JUST FOR TEST)
	$("#module").ready(function () {
		$(".subchapters li:first a").addClass("selected");
		getVideoFromSubchapter($(".subchapters .selected").data("id"));
	});
	// CHANGES REMAINING TIME (JUST FOR TEST)
	let count = 0;
	$(".count").each(function () {
		count = count + parseInt($(this).text());
	});
	setTimeout(() => {
		$(".remaining span").html(count);
	}, 1000);

	$(".subchapters a").click(function (e) {
		e.preventDefault();
		$(".subchapters a").removeClass("selected");
		$(this).addClass("selected");
		console.log($(this).data("id"));
		getVideoFromSubchapter($(this).data("id"));
	});

	function getVideoFromSubchapter(subchapterId) {
		$("#content .module-content-display").html(
			`<div class="loader"><img src="${directory_uri.templateUrl}/static/img/loader.gif"></div>`
		);
		$.get(
			"http://localhost:3000/k9umlaude2/wp-json/wp/v2/subcapitulo/" +
				subchapterId,
			function (subchapter) {
				$.get(
					"http://localhost:3000/k9umlaude2/wp-json/wp/v2/media/" +
						subchapter.acf.video,
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
