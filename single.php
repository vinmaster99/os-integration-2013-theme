<?php

$post = $wp_query->post;

$category = get_the_category();
$category_id = $category[0]->cat_ID;

// Send to correct single page for blog or press categories
switch ($category_id) {
	// Blog
	case get_cat_ID('Blog'):
	// Content Partnerships
	case get_cat_ID('Content Partnerships'):
	// Market Statistics
	case get_cat_ID('Market Statistics'):
	// News & Events
	case get_cat_ID('News &amp; Events'):
	// Opinions
	case get_cat_ID('Opinions'):
	// Tech
	case get_cat_ID('Tech'):
	// Television
	case get_cat_ID('Television'):
	// Video Industry
	case get_cat_ID('Video Industry'):
	// Video Piracy
	case get_cat_ID('Video Piracy'):
		include(TEMPLATEPATH . '/single-blog.php');
		break;
	// Press
	case get_cat_ID('Press'):
	// Announcements
	case get_cat_ID('Announcements'):
	// Articles
	case get_cat_ID('Articles'):
	// Events
	case get_cat_ID('Events'):
	// Releases
	case get_cat_ID('Releases'):
		include(TEMPLATEPATH . '/single-press.php');
		break;
	default:
		include(TEMPLATEPATH . '/single-blog.php');
		break;
}

// if ( in_category('2') ) {

// include(TEMPLATEPATH . '/single-blog.php'); } 

// elseif ( in_category('15') ) {

// include(TEMPLATEPATH . '/single-press.php'); } 

// elseif ( in_category('18') ) {

// include(TEMPLATEPATH . '/single-video.php'); } 

// else {

// include(TEMPLATEPATH . '/single-default.php');

// }

?>