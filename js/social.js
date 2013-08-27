jQuery(document).ready(function($){
	// Facebook fetching share count for blog posts
	var fb_share = $(".facebook-share");

	$.each(fb_share, function(index, value){
		var post_link = fb_share[index].children[0].children[0].href.replace('https://www.facebook.com/sharer/sharer.php?u=', '');

		$.getJSON('http://graph.facebook.com/?id='+post_link, function(data) {
			var shared = data.shares;
			if (shared > 1000000) {
				shared = Math.floor(shared/1000000) +'m';
			}else if (shared > 1000) {
				shared = Math.floor(shared/1000) + 'k';
			} else if (shared === undefined) {
				shared = 0;
			}
			fb_share[index].children[1].innerHTML=shared;
		});
	});
});