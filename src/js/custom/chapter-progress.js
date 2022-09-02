jQuery(function ($) {
	// Goes to last chapter completed in the module
	if ($("#module").length) {
		const userId = document.getElementById("account").dataset.id;
		$.get(
			`${directory_uri.rootUrl}/wp-json/user-chapters/completed_chapters?userId=${userId}`,
			function (completed_chapters) {
				let lastChapter = 0;
				$(".chapter-header").each(function (index, element) {
					if (
						jQuery.inArray($(element).data("id"), completed_chapters) !== -1
					) {
						lastChapter = $(element).data("id");
					}
				});
				let selected = $(`.chapter-header[data-id=${lastChapter}]`);
				if (selected.data("id") === undefined) {
					selected = $(".chapter-header")[0];
				}
				$(selected).addClass("selected");
				getVideoFromChapter(selected.attr("data-id"));
			}
		);
	}
	/* EVENTS */
	// CLICK
	$(".chapters a").click(function (e) {
		e.preventDefault();
		$(".chapters a").removeClass("selected");
		$(this).addClass("selected");
		getVideoFromChapter($(this).data("id"));
	});

	/* FUNCTIONS */
	function checkModule(userId, moduleId) {
		let completed = 0;
		$(".chapter-header").each(function (chapter) {
			if (!$(chapter).hasClass("enabled")) {
				completed = 1;
				return false;
			}
		});
		if (completed) {
			$.post(`${directory_uri.rootUrl}/wp-json/user-modules/post`, {
				userId: userId.dataset.id,
				moduleId: moduleId,
			}).then(function (res) {
				$(".nextModule-link").addClass("completedModule");
			});
		}
	}
	function getVideoFromChapter(chapterId) {
		$("#content .module-content-display").html(
			`<div class="loader"><img src="${directory_uri.stylesheetUrl}/static/img/loader.gif"></div>`
		);
		const userId = document.getElementById("account").dataset.id;

		$.get(
			`${directory_uri.rootUrl}/wp-json/wp/v2/chapter/${chapterId}`,
			function (chapter) {
				$.get(
					`${directory_uri.rootUrl}/wp-json/wp/v2/media?parent=${chapterId}`,
					function (data) {
						$.get(
							`${directory_uri.rootUrl}/wp-json/user-chapters/video_at?chapterId=${chapterId}&userId=${userId}`,
							function (video_at) {
								if (chapter.title) {
									$("#content .module-content-display").html(
										`
                    <div class="content">
                      <video id="module_video" controls poster="${directory_uri.stylesheetUrl}/static/img/poster.jpg" preload="metadata" data-id="${chapter.id}">
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
                      <video id="module_video" controls>
                        <source src="${data[0].source_url}#t=${video_at.posicion_video}" type="video/mp4">
                        Su navegador no soporta vídeos
                      </video>
                    </div>`
									);
								}
								$("#module_video").contextmenu(function () {
									return false;
								});
							}
						);
						setTimeout(function () {
							$("#content .module-content-display div").css({
								visibility: "visible",
							});
							// PAUSE
							const video = document.querySelector("video");
							const userId = document.getElementById("account");
							video.onpause = (event) => {
								let currentTime = event.target.currentTime;
								if (currentTime === event.target.duration) {
									currentTime = 0;
								}
								$.post(
									`${directory_uri.rootUrl}/wp-json/user-chapters/update`,
									{
										position: currentTime,
										id: event.target.dataset.id,
										userId: userId.dataset.id,
									}
								);
							};
							// COMPLETE
							video.onended = (event) => {
								$.post(`${directory_uri.rootUrl}/wp-json/user-chapters/post`, {
									userId: userId.dataset.id,
									chapterId: event.target.dataset.id,
								}).then(function () {
									$(".chapter-header").each(function (index, element) {
										if ($(element).hasClass("selected")) {
											$(
												".chapter-header.selected .chapter-header-title svg"
											).remove();
											$(
												".chapter-header.selected .chapter-header-title img"
											).remove();
											$(
												".chapter-header.selected .chapter-header-title"
											).prepend(
												`<img src='${directory_uri.stylesheetUrl}/static/img/svg/check-done.svg' class='check-done'>`
											);
											$(".chapter-header.selected")
												.removeClass("selected")
												.next()
												.next()
												.addClass("enabled");
											$(this).next().next().trigger("click");
											checkModule(userId, chapter.acf.belongs_to);
											return false;
										}
									});
								});
							};
						}, 2000);
					}
				);
			}
		);
	}
});
