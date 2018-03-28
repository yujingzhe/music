$(function() {
	popDiyTags();
});
function popDiyTags() {
	function removeTags() {
		$(".selected-list01 .selected-del").click(function() {
			var t1 = $(this).parent().find("span").text();
			$(this).parent().remove();
			$(".selected-list02 li span").each(function() {
				if ($(this).text() == t1) {
					$(this).parent().remove();
				}
			});
			$(".popDiyTags-list dd a").each(function() {
				if ($(this).text() == t1) {
					$(this).removeClass("selected");
				}
			});
			$(".selected-index span").text($(".selected-list li").length / 2);
			return false;
		});
		$(".selected-list02 .selected-del").click(function() {
			var t2 = $(this).parent().find("span").text();
			$(this).parent().remove();
			$(".selected-list01 li span").each(function() {
				if ($(this).text() == t2) {
					$(this).parent().remove();
				}
			});
			$(".popDiyTags-list dd a").each(function() {
				if ($(this).text() == t2) {
					$(this).removeClass("selected");
				}
			});
			$(".selected-index span").text($(".selected-list li").length / 2);
			return false;
		})
	}
	$(".popDiyTags-list dd a").click(function() {
		var a = $(this).text();
		if ($(this).hasClass("selected")) {
			asyncbox.tips("标签已经选择！", "wait", 1000);
			return false;
		} else {
			if ($(".selected-list li").length < 10) {
				$(this).addClass("selected");
				$(".selected-index span").text($(".selected-list li").length / 2 + 1);
				$(".selected-list01").append("<li><span>" + a + "</span><a class='selected-del' href='#'></a></li>");
				$(".selected-list02").append("<li><span>" + a + "</span><a class='selected-del' href='#'></a></li>");
				removeTags();
				return false;
			} else {
				asyncbox.tips("最多选择5个标签！", "wait", 1000);
				return false;
			}
		}
	});
	$(".popDiyTags-title .btnTure").click(function() {
		if ($(".selected-list01 li").length == 0) {
			asyncbox.tips("至少选择1个标签！", "wait", 1000);
			return false;
		} else {
			var tagArraySave = new Array();
			$(".selected-list01 li").each(function(i) {
				tagArraySave.push($(this).find("span").text())
			});
			$.each(tagArraySave,
			function(i) {
				$(".div-info .tags").append("<a href='javascript:void(0);'>" + tagArraySave[i] + "</a>")
			});
			$(".div-info .tips span").text($(".div-info .tags a").length);
			ReturnValue(tagArraySave);
			return false;
		}
	})
}