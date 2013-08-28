<?php

$post = $wp_query->post;

$category = get_the_category();
$category_id = $category[0]->cat_ID;

// Send to correct single page for blog or press categories

// Get the categories names of blog and press
$blog_cat = get_blog_categories();
$press_cat = get_press_categories();

$blog_catID = array();
$press_catID = array();

// Turn the category names into ID's
foreach ($blog_cat as $key => $value) {
	array_push($blog_catID, get_cat_ID($value));
}

foreach ($press_cat as $key => $value) {
	array_push($press_catID, get_cat_ID($value));
}

// Check against the category id of current post
if (in_array($category_id, $blog_catID)) {
	include(TEMPLATEPATH . '/single-blog.php');
} else if (in_array($category_id, $press_catID)) {
	include(TEMPLATEPATH . '/single-press.php');
} else {
	include(TEMPLATEPATH . '/single-blog.php');
}

?>