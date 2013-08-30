$().ready(function() {
	var $scrollingDiv = $("#tabs");
	var $tab_content_top = $("#my-tab-content").offset().top;
	var $tab_content_bottom = $tab_content_top + $("#my-tab-content").height();
	$(window).scroll(function(){
		if ($(window).scrollTop() > $tab_content_top) {
			if ($(window).scrollTop() < $tab_content_bottom) {
				$scrollingDiv
					.stop()
					.animate({"marginTop": ($(window).scrollTop() - $tab_content_top + 30) + "px"}, "slow" );
			}
		} else {
			$scrollingDiv.css({"marginTop": 0});
		}
	});
});
function goToByScroll(){
	// Scroll
	$('html,body').animate({
	scrollTop: $("#my-tab-content").offset().top},
	'slow');
}