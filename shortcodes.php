<?php 
// Included in functions.php to allow shortcodes on website


// Shortcode Test
function shortcode_test(){
	return '<h1>SHORTCODE WORKS!</h1>';
}
add_shortcode('test', 'shortcode_test');


//Short Code to display links for 3 most recent posts
function showRecentPosts($attributes) {
    // Register shortcodes stylesheet
    wp_enqueue_style('theme_shortcodes', get_template_directory_uri().'/shortcodes.css');

    $attributes = shortcode_atts(
        array(
            'img_url' => '',
            'img_href' => '#',
            'description' => '',
            'title' => 'Featured Content', 
            'category' => '',
            'count' => '3',
            'side' => 'left',
            'read_more' => 'Read More'
        ), $attributes
    );

    extract($attributes);

    if (empty($category)) return;

    $category_slug = str_replace(' ', '-', $category);

    if ($side == 'left'){
        $margin = 'margin:35px 35px 0 0;';
    } else $margin = 'margin:35px 0 0 0;';
    $content = '<style>.featured-category-container .featured-content ul li:hover { text-decoration: underline;}</style>
        <div class="featured-category-container" style="width:315px; float:left; '.$margin.'">
            <a href="'.$img_href.'"><img src="' . $img_url .'" /></a>
            <div class="featured-category-description" style="margin:10px 0;">' . $description . '</div>
            <a href="'.home_url().'/category/'.$category_slug.'" /><h3 class="featured-content-title">' . $title . '</h3></a>
            <div class="featured-content" style="">
                <ul class="featured-content-list" style="list-style-type:none; margin-left:0px; padding:0;">';
    // return $content;
    $addon_content = '';

    // wp_reset_query();
    $query = objectToArray(query_posts( array( 'category_name' => $category, 'posts_per_page' => $count ) ));
    
    for ($i = 0; $i < $count; $i++) {
        $post = $query[$i];
        $permalink = get_permalink($post['ID']);
        $title = get_the_title($post['ID']);
        if ($title != "Insights") {
            // print_r($title . "<br />");
            $addon_content .= '<li><a href='.$permalink.' style="text-decoration:none; color:#0096C3;" >'.$title.'</a></li>';
        }
    }

    // $addon_content .= '</ul></div></div>';
    // $content .= $addon_content;
    $addon_content .= '</ul></div>';
    if ($read_more == 'Read More') $read_more .= ' ' . $category;
    $addon_content .= '<div class="read-more"><a href="'.home_url().'/resources/'.$category_slug.'">'.$read_more.' &#8594;</a></div></div>';
    $content .= $addon_content;

    return '[raw]'.$content.'[/raw]';

}
add_shortcode('displayPosts', 'showRecentPosts');


// Shortcode for first row in homewidgets div
function onescreen_service($attributes, $content = null){

	// Register shortcodes stylesheet
	wp_enqueue_style('theme_shortcodes', get_template_directory_uri().'/shortcodes.css');

	$attributes = shortcode_atts(
		array(
			'img_src' => 'error: missing image src',
			'title' => 'error: missing title',
			'description' => 'error: missing description',
			'learn_more_url' => 'error: missing url',
			'learn_more_text' => 'Learn More',
			'contact_us_url' => '#',
			'contact_us_text' => 'Contact Us'
		), $attributes
	);
	extract($attributes);

	return '
		<div class="os-service">
		<img src="'.$img_src.'" />
		<h2>'.$title.'</h2>
		<p>'.$description.'</p>
		<a href="'.$learn_more_url.'">'.$learn_more_text.'</a>
		<span>|</span>
		<a href="'.$contact_us_url.'">'.$contact_us_text.'</a>
		</div>
	';

}
add_shortcode('os_service', 'onescreen_service');
add_filter('widget_text', 'do_shortcode');

// Shortcode for second row in homewidgets div
function oslist($attributes){
	// Register shortcodes stylesheet (if not enqueued yet)

	$attributes = shortcode_atts(
		array(
			'post_id' => '',
			'category' => '',
			'count' => '4',
			'thumbnails' => 'false',
			'img' => '',
			'show_excerpt' => 'yes'
		), $attributes);
	extract($attributes);

	// print_array($category);

	if (isset($post_id) && $post_id != ''){
		$post_id = str_replace(', ', ',', $post_id);
		$posts = explode(',', $post_id);
	}
	else if (isset($category) && $category != ''){
		if (!is_numeric($category)){	
			$category_object = get_category_by_slug($category);
			$category = $category_object->cat_ID;
		}
		$posts = get_posts( array('category' => $category, 'numberposts' => $count, 'orderby' => 'post_date', 'order' => 'DESC') );
	}

	// explode image sources
	$img = str_replace(' ', '', $img);
	$img = explode(',', $img);

	$content = '';
	$content .= '<ul class="unstyled oslist-secondrow">';

	$count = 0;
	foreach ($posts as $post) {
		// checks if current post is post_id or post_object
		if (is_numeric($post)) $post = get_post($post);

		// Gets image thumbnail if true
		if ($thumbnails == 'true'){
			// if img item has 'http://' then consider it an img
			if ( stripos($img[$count], 'http://') !== false ){
				$image = '<img src="'.$img[$count].'" />';
			}
			else {
				$thumb = get_post_thumbnail_id( $post->ID );
				if (isset($thumb) && $thumb != ''){
					$thumbnail_array = wp_get_attachment_image_src( $thumb );
					$image = '<img src="'.$thumbnail_array[0].'" />';
				}
				else $image = '';
			}
		}
		$url = get_permalink($post->ID);
		$title = $post->post_title;
		if ($post->post_excerpt != '') $description = $post->post_excerpt;
		else $description = get_onescreen_excerpt($post->ID, 200);

		if ($show_excerpt === 'yes') {
			$content .= '<li class="oslist-section-li">'.$image.'<div><a href="'.$url.'">'.$title.'</a><p><small>'.$description.'</small></p></div></li>';
		} else {
			$content .= '<li class="oslist-section-li">'.$image.'<div><a href="'.$url.'">'.$title.'</a></div></li>';
		}
		$count++;
	}

	$content .= '</ul>';

	return $content;
}
add_shortcode('oslist', 'oslist');


/* FEATURE A POST (created for press page) */
function feature_post($attributes){
	// Register shortcodes stylesheet
	wp_enqueue_style('theme_shortcodes', get_template_directory_uri().'/shortcodes.css');
	$attributes = shortcode_atts(
		array(
			'post_id' => '',
			'category' => 'press',
			'excerpt' => ''
		), $attributes
	);
	extract($attributes);

	// set the post variable and the featured image
	if (isset($post_id) && $post_id != ''){
		$post = get_post($post_id);
		$thumb = get_post_thumbnail_id( $post_id, 'full' );
		if (isset($thumb) && $thumb != ''){
			$thumbnail_array = wp_get_attachment_image_src( $thumb );
			$featured_image = $thumbnail_array[0];
			$featured_image = str_replace('-150x150', '', $featured_image);
		}
	}
	else {
		$args = array( 'posts_per_page' => 1, 'numberposts' => 1, 'category' => get_cat_ID($category), 'order' => 'DESC', 'orderby' => 'post_date', 'post_status' => 'publish' );
		$posts = get_posts($args);
		$post = $posts[0];
		$thumb = get_post_thumbnail_id( $post->ID, 'full' );
		if (isset($thumb) && $thumb != ''){
			$thumbnail_array = wp_get_attachment_image_src( $thumb );
			$featured_image = $thumbnail_array[0];
			$featured_image = str_replace('-150x150', '', $featured_image);
		}

	}

	$content = '';
	$content .= '<a href="'.$post->guid.'" id="featured-image"><img src="'.$featured_image.'" /></a>';
	$content .= '<a href="'.$post->guid.'"<h3 class="featured-title">'.$post->post_title.'</h3></a>';
	$content .= '<div class="date category-icon '. $category .'">'.mysql2date('F j, Y', $post->post_date).'</div>';
	$description = (isset($excerpt) && $excerpt != '') ? $excerpt : get_onescreen_excerpt($post->ID, 200);
	$content .= '<div class="featured-excerpt">'.$description.'</div>';

	return $content;
}
add_shortcode('feature_post', 'feature_post');


/* LIST POSTS HORIZONTALLY (used on press page) */
function oslist_horizontal($attributes){
	// Register shortcodes stylesheet
	wp_enqueue_style('theme_shortcodes', get_template_directory_uri().'/shortcodes.css');

	$attributes = shortcode_atts(
		array(
			'post_id' => '',
			'category' => 'press',
			'count' => '3'
		), $attributes
	);
	extract($attributes);

	// set the posts array
	if (isset($post_id) && $post_id != ''){
		$post_id = str_replace(', ', ',', $post_id);
		$posts = explode(',', $post_id);
	}
	else {
		$args = array( 'posts_per_page' => intval($count), 'numberposts' => intval($count), 'category' => get_cat_ID($category), 'order' => 'DESC', 'orderby' => 'post_date', 'post_status' => 'publish' );
		$posts = get_posts($args);
	}

	$content = '';

	foreach ($posts as $post){
		// if $post is actually $post_id
		if (is_numeric($post)) $post = get_post($post);

		$thumb = get_post_thumbnail_id( $post->ID, 'full' );
		if (isset($thumb) && $thumb != ''){
			$thumbnail_array = wp_get_attachment_image_src( $thumb );
			$featured_image = $thumbnail_array[0];
			$featured_image = str_replace('-150x150', '', $featured_image);
		}

		$content .= '<div class="oslist-horizontal">';
		$content .= '<a href="'.$post->guid.'" class="featured-thumb"><img src="'.$featured_image.'" /></a>';
		$content .= '<h3 class="featured-title"><a href="'.$post->guid.'">'.$post->post_title.'</a></h3>';
		$content .= '<div class="date category-icon '. $category .'">'.mysql2date('F j, Y', $post->post_date).'</div>';
		if ($post->post_excerpt != '') $content .= '<div class="featured-excerpt">'.$post->post_excerpt.'</div>';
		else $content .= '<div class="featured-excerpt">'.get_onescreen_excerpt($post->ID, 200).'</div>';
		$content .= '<div class="read-more"><a href="'.$post->guid.'">Read More</a></div>';
		$content .= '</div>';

	}
	return $content;
}
add_shortcode('oslist_horizontal', 'oslist_horizontal');

/* TABLE LIST (used on press page) */
function os_tablelist($attributes){
	// Register shortcodes stylesheet
	wp_enqueue_style('theme_shortcodes', get_template_directory_uri().'/shortcodes.css');

	$attributes = shortcode_atts(
		array(
			'title' => 'Table List',
			'category' => 'press',
			'count' => '10'
		), $attributes
	);
	extract($attributes);

	$args = array( 'posts_per_page' => intval($count), 'numberposts' => -1, 'category' => get_cat_ID($category), 'order' => 'DESC', 'orderby' => 'post_date', 'post_status' => 'publish', 'paged' => max(1 , get_query_var('paged')) );

	$posts = get_posts($args);

	$content = '';
	$content = '<div class="os-tablelist">';
	$content .= '<div class="tablelist-title"><h2>'.$title.'</h2></div>';
	$content .= '<table>';

	foreach ($posts as $post){
		$content .= '<tr>';
		$content .= '<td><a href="'.$post->guid.'">'.$post->post_title.'</a><div class="date category-icon">'.mysql2date('F j, Y', $post->post_date).'</div></td>';
		$content .= '</tr>';
	}

	$content .= '</table>';
	$content .= '</div>';

	return $content;

}
add_shortcode('os_tablelist', 'os_tablelist');


/* New Carousel/Slider Shortcode */
function new_slider($attributes){
	// wp_enqueue_style('new-slider-style', get_template_directory_uri().'/slider.css');
	wp_enqueue_script('slider_shortcode_script', get_template_directory_uri().'/js/slider.js', array(), '', false);

	$attributes = shortcode_atts(
		array(
			'post_id' => '',
			'category' => '',
			'count' => '5',
			'height' => '250px',
			'width'	=> '960px',
			'pagination' => 'false',
			'interval' => '5000',
			'auto_start' => 'true'
		), $attributes);
	extract($attributes);

	// if post_id is set, display only these posts
	if (isset($post_id) && $post_id != ''){
		// removes white space
		$post_id = str_replace(' ,', ',', $post_id);
		$posts = explode(',', $post_id);
	}// else if category is set and post_id is not set, then show these posts in slide 
	else if (isset($category) && $category != ''){
		if (!is_numeric($category)){
			$category_object = get_category_by_slug($category);
			$category = $category_object->cat_ID;
		}
		$posts = get_posts( array('category' => $category, 'numberposts' => $count, 'orderby' => 'post_date', 'order' => 'desc') );
	}

	$content = '<div class="span12">';
	$content = '<div id="myCarousel" class="carousel slide" style="clear:both;"><div class="carousel-inner">';

	$first = true;

	foreach ($posts as $post) {
		if (is_numeric($post)) $post = get_post($post);

		// checks if current post is featured in slider (for slider options)
		// if not, the SKIP
		$featured = get_post_meta($post->ID, 'carousel_checkbox', true);
		if (stripos($featured, 'no') !== false || $featured == '') continue;

		$img_array = get_post_meta($post->ID, 'slider_background_image', true);
		$img_src = $img_array['url'];
		$title_style = get_post_meta($post->ID, 'slider_title_css', true);
		$button_text = get_post_meta($post->ID, 'slider_button_text', true);
		$button_style = get_post_meta($post->ID, 'slider_button_css', true);
		$button_url = get_post_meta($post->ID, 'slider_button_url', true);

		if (!empty($button_url)) $href = $button_url;
		else $href = $post->guid;
		$target = ( stripos($href, 'www.onescreen.com') !== false ) ? '' : '_blank';

		if ($first) {
			$content .= '<div class="active item">';
			$first = false;
		}
		else $content .= '<div class="item">';
		
		$content .= '<a href="'.$href.'"><img class="slider_img" style="left: 0; top:0; " width="100%" src="'.$img_src.'"/></a>';
		// $content .= '<div onclick="location.href=\''.$href.'\';" style="cursor: pointer; background-size: 100% auto; background:url('.$img_src.') no-repeat center center; height:'.$height.';" class="slider-background span12"></div>';
		
		$content .= '</div>';
	}

	$content .= '</div>';
	$content .= '
	<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a></div>';
	
	$content .= '</div>';

	return '[raw]'.$content.'[/raw]';
}
add_shortcode('slider', 'new_slider');

// Shortcode for title
function title_shortcode(){
	global $post;
	global $parent_page;
	return "<h1 id='post-title'>{$post->post_title}</h1>";
}
add_shortcode('title', 'title_shortcode');

// Shortcode for breadcrumbs
function breadcrumbs_shortcode() {
	global $post;
	$breadcrumbs = "No Breadcrumbs";
	if ( function_exists('yoast_breadcrumb') ) {
		$breadcrumbs = yoast_breadcrumb('<p id="breadcrumbs">', '</p>', false);
	}
	return $breadcrumbs;
}
add_shortcode('breadcrumbs', 'breadcrumbs_shortcode');

// Shortcode for Company/Press page to display 4 feature posts
function press_feature_posts($attributes) {
	extract(shortcode_atts( 
		array('featured_post' => '', 
			'post_id' => ''), $attributes));

	if (isset($featured_post) && $featured_post != '' && isset($post_id) && $post_id != '')
	{
		$content = '<div class="row-fluid"><div class="span9" style="padding-right: 20px; border-right: 1px solid #d9d9d9;"><a id="featured-image" href="';

		global $post;
		$original_post = $post;

		$post = get_post($featured_post);
		$post_link = get_permalink($featured_post);
		$post_excerpt = get_the_excerpt();
		$post_title = get_the_title();
		$post_date = get_the_date();
		$thumb = get_post_thumbnail_id( $featured_post, 'full' );
		$featured_image = os_get_featured_image($thumb);

		$content .= $post_link;
		$content .= '"><img src="';
		$content .= $featured_image;
		$content .= '" alt="" /></a>
		<h3 class="featured-title"><a href="';
		$content .= $post_link;
		$content .= '">';
		$content .= $post_title;
		$content .= '</a></h3>
		<div class="date category-icon press">';
		$content .= $post_date;
		$content .= '</div>
		<div class="featured-excerpt">';
		$content .= $post_excerpt;
		$content .= '</div>
	</div>';

		$other_posts = explode(",", $post_id);
		$content .= '<div class="span3"><div class="row-fluid"><div class="span12">';
		foreach ($other_posts as $key => $value) {
			$post = get_post($value);
			$post_link = get_permalink($value);
			$post_excerpt = get_the_excerpt();
			$post_title = get_the_title();
			$post_date = get_the_date();
			$thumb = get_post_thumbnail_id( $value, 'full' );
			$featured_image = os_get_featured_image($thumb);

			$content .= '<a class="featured-thumb" href="';
			$content .= $post_link;
			$content .= '"><img src="';
			$content .= $featured_image;
			$content .= '" alt=""/></a><div class="date category-icon press">';
			$content .= $post_date;
			$content .= '</div><a href="';
			$content .= $post_link;
			$content .= '">';
			$content .= $post_title;
			$content .= '</a>';
		}
		$content .= '</div>
		</div>
	</div>
</div>';
		$post = $original_post;
		return $content;
	} else
	{
		return "Shortcode error";
	}
	
}
add_shortcode('press', 'press_feature_posts');

// New post carousel for company.onescreen.com
function post_carousel($attributes) {
	wp_enqueue_script('slider_shortcode_script', get_template_directory_uri().'/js/slider.js', array(), '', false);

	$attributes = shortcode_atts(
		array(
			'post_id' => '',
			'excerpt_length' => '750',
			'post_images' => 'none',
			'show_arrows' => 'yes'
		), $attributes);
	extract($attributes);

	if (isset($post_id) && $post_id != ''){
		// removes white space
		$post_id = str_replace(' ,', ',', $post_id);
		$posts = explode(',', $post_id);
	}

	$post_count = count($posts);

	$content = '<div class="carousel slide" id="myCarousel"><ol class="carousel-indicators" style="bottom: 15px !important; top: auto !important;">';
	for ($i = 0; $i < $post_count; $i++) {
		if ($i === 0)
			$content .= '<li class="active" data-slide-to="'.$i.'" data-target="#myCarousel"></li>';
		else
			$content .= '<li class="" data-slide-to="'.$i.'" data-target="#myCarousel"></li>';
	}
	$content .= '</ol><div class="carousel-inner">';

	$first = true;
	$count = 0;
	if ($post_images != 'none') {
		$post_images = explode(',', $post_images);
	}

	foreach ($posts as $post_id) {
		$post = get_post($post_id);
		$post_link = get_permalink($post_id);
		$post_title = get_the_title($post_id);

		// fetch image if no image url were given
		if ($post_images == 'none') {
			$thumb = get_post_thumbnail_id( $post_id, 'full' );
			if (isset($thumb) && $thumb != ''){
				$thumbnail_array = wp_get_attachment_image_src( $thumb );
				$featured_image = $thumbnail_array[0];
				$featured_image = str_replace('-150x150', '', $featured_image);
			}
		} else {
			if (isset($post_images[$count]))
				$featured_image = $post_images[$count];
		}
		if ($excerpt_length != 0) {
			$excerpt = get_excerpt_by_id($post_id);
			$excerpt = substr($excerpt, 0, $excerpt_length);
		}

		if ($first) {
			$content .= '<div class="item active">';
			$first = false;
		} else {
			$content .= '<div class="item">';
		}
		$content .= '<a href="'.$post_link.'"><img alt="" src="'.$featured_image.'"></a>';
		$content .= '<div class="carousel-caption">';
        $content .= '<a style="color: white; line-height:22px !important;" href="'.$post_link.'" >'.$post_title.'</a>';
        $content .= '</br>';
        if ($excerpt_length != 0) {
        	$content .= '<p style="line-height:18px !important;">'.$excerpt.'</p>';
        }
      	$content .= '</div>';
      	$content .= '</div>';
      	$count++;
	}
	$content .= '</div>';
	if ($show_arrows == 'yes')
		$content .= '<a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a><a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>';
	$content .= '</div>';

    return $content;
}
add_shortcode('post_carousel', 'post_carousel');

// Show blog stream
function blog_posts($attributes) {
	global $wp_query, $paged, $post;
	$page_title = get_the_title($post->ID);

	$blog_cat = get_blog_categories();
	$blog_catID = array();
	// Turn the category names into ID's
	foreach ($blog_cat as $key => $value) {
		array_push($blog_catID, get_cat_ID($value));
	}
	$blog_catID = implode(',', $blog_catID);

	$temp = $wp_query; $wp_query= null;
	$wp_query = new WP_Query(); $wp_query->query('cat='.$blog_catID.'&posts_per_page=10' . '&paged='.$paged);
	
	$content = '';

	// for each post format it to display nicely on page
	while ($wp_query->have_posts()) {
		$wp_query->the_post();

		$category = get_the_category();
		if (in_array($category[0]->name, get_blog_categories()) === false) {
			continue;
		}

		$content .= '<h2 class="header"><a href="'.get_permalink().'" title="Read more">'.get_the_title().'</a></h2>';

		$category_object = get_the_category($post->ID);
		$temp = $category_object[0];
		$category_link = get_category_link($temp->cat_ID);
		$author_id = $post->post_author; $user = get_userdata($author_id); $author_name = $user->first_name . ' ' . $user->last_name;
		
		$content .= '<div class="cat-date-author"><small><a href="';
		$content .= $category_link.'">';
		$content .= $temp->name;
		$content .= '</a></small><small> &nbsp;|&nbsp; </small><small>';
		$content .= mysql2date('F j, Y', $post->post_date);
		$content .= '</small>';
		$content .= '</div>';
		$content .= get_the_excerpt();
		$content .= '<p><a href="'. get_permalink().'" class="read-more">Read More</a></p>';

		// $content .= social_div_text();

		$content .= '<div class="osdivider"></div>';
	}

	// Show pagination
	$content .= kriesi_pagination_text('', 2);

	// This is for the facebook counters
	wp_enqueue_script('social_sharing', get_template_directory_uri().'/js/social.js', array('jquery'));

	wp_reset_postdata();

	return $content;
}
add_shortcode('blog_posts', 'blog_posts');

// show press stream
function press_posts() {
	global $wp_query, $paged, $post;
	$page_title = get_the_title($post->ID);

	$press_cat = get_press_categories();
	$press_catID = array();
	// Turn the category names into ID's
	foreach ($press_cat as $key => $value) {
		array_push($press_catID, get_cat_ID($value));
	}
	$press_catID = implode(',', $press_catID);

	$temp = $wp_query; $wp_query= null;
	$wp_query = new WP_Query(); $wp_query->query('cat='.$press_catID.'&posts_per_page=10' . '&paged='.$paged);
	
	$content = '';

	// for each post format it to display nicely on page
	while ($wp_query->have_posts()) {
		$wp_query->the_post();

		$category = get_the_category();
		if (in_array($category[0]->name, get_press_categories()) === false) {
			continue;
		}

		$content .= '<h2 class="header"><a href="'.get_permalink().'" title="Read more">'.get_the_title().'</a></h2>';

		$category_object = get_the_category($post->ID);
		$temp = $category_object[0];
		$category_link = get_category_link($temp->cat_ID);
		
		$content .= '<div class="cat-date-author"><small><a href="';
		$content .= $category_link.'">';
		$content .= $temp->name;
		$content .= '</a></small><small> &nbsp;|&nbsp; </small><small>';
		$content .= mysql2date('F j, Y', $post->post_date);
		$content .= '</small>';
		$content .= '</div>';
		$content .= get_the_excerpt();
		$content .= '<p><a href="'. get_permalink().'" class="read-more">Read More</a></p>';

		// $content .= social_div_text();

		$content .= '<div class="osdivider"></div>';
	}

	// Show pagination
	$content .= kriesi_pagination_text('', 2);

	// This is for the facebook counters
	wp_enqueue_script('social_sharing', get_template_directory_uri().'/js/social.js', array('jquery'));

	wp_reset_postdata();

	return $content;
}
add_shortcode('press_posts', 'press_posts');

// display the page title
function page_title() {
	global $post;
	$page_title = get_the_title($post->ID);
	return $page_title;
}
add_shortcode('page_title', 'page_title');

// display list of categories to list in stream
function filter_by_categories() {
	// List all the categories and their id
	// $categories = get_categories();
	// $categories_array = array();
	// foreach ($categories as $key => $value) {
	// 	print_r($value->name);
	// 	print_r($value->cat_ID);
	// 	echo get_category_link($value->cat_ID);
	// 	array_push($categories_array, $value->name);
	// 	echo "</br>";
	// }

	$page_id = get_cat_ID( 'Press' );
	$blog_id = get_cat_ID( 'Blog' );
	return wp_list_categories( array('feed_image' => get_bloginfo("template_directory")."/images/rss_small.png", 'feed' => 'RSS Feed', 'exclude' => $page_id, 'echo' => 0, 'title_li' => '', 'child_of' => $blog_id));
}
add_shortcode('filter_by_categories', 'filter_by_categories');

// filter the stream to display posts by month
function filter_by_months() {
	return wp_get_archives( array('limit' => 6, 'echo' => 0));
}
add_shortcode('filter_by_months', 'filter_by_months');

// get the list of categories for blog
function blog_categories() {
	return print_r($get_blog_categories(), true);
}
add_shortcode('blog_categories', 'blog_categories');

// show the sidebar widget to sign up for newsletter
function newsletter() {
	$content = '<div class="row-fluid">
	<form action="http://newsletter.onescreen.com/t/t/s/tyqh/" method="post">
	<div class="row-fluid">
	<div class=""><label for="fieldName">Name</label></div>
	<div class="span12"><input id="fieldName" name="cm-name" type="text" /></div>
	</div>
	<div class="row-fluid">
	<div class=""><label for="fieldEmail">Email</label></div>
	<div class="span12"><input id="fieldEmail" name="cm-tyqh-tyqh" type="email" required /></div>
	</div><button class="os-btn" type="submit" onclick="_gaq.push(['."'_trackEvent'".', '."'email'".', '."'subscribe'".', '."''".',, false]);">Subscribe</button>
	</form></div>';
	return $content;
}
add_shortcode('newsletter', 'newsletter');

// show the sidebar widget to search post
function search_bar() {
	$content = '<form method="get" id="searchform" action="'.home_url().'/">
	<input type="text" class="input" value="';
	$content .= '" name="s" id="s" /></br><input class="os-btn" type="submit" id="searchsubmit" value="Search" /></form>';
	return $content;
}
add_shortcode('search_bar', 'search_bar');

// Use Twitter's widget and embeded on the website
function twitter_feed() {
	$content = '<a class="twitter-timeline" href="https://twitter.com/onescreen" data-widget-id="373237180576985088">Tweets by @onescreen</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
';
	return $content;
}
add_shortcode('twitter_feed', 'twitter_feed');

// link to about onescreen page
function posts_by_category($attributes) {
	extract(shortcode_atts( 
		array('category_name' => 'Press'), $attributes));

	global $wp_query, $paged, $post;
	$page_title = get_the_title($post->ID);

	$blog_catID = get_cat_ID($category_name);
	
	$temp = $wp_query; $wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query('cat='.$blog_catID.'&posts_per_page=10' . '&paged='.$paged);

	$content = '';

	// for each post format it to display nicely on page
	while ($wp_query->have_posts()) {
		$wp_query->the_post();

		$category = get_the_category();

		$content .= '<h2 class="header"><a href="'.get_permalink().'" title="Read more">'.get_the_title().'</a></h2>';

		$category_object = get_the_category($post->ID);
		$temp = $category_object[0];
		$category_link = get_category_link($temp->cat_ID);
		$author_id = $post->post_author; $user = get_userdata($author_id); $author_name = $user->first_name . ' ' . $user->last_name;
		
		$content .= '<div class="cat-date-author"><small><a href="';
		$content .= $category_link.'">';
		$content .= $temp->name;
		$content .= '</a></small><small> &nbsp;|&nbsp; </small><small>';
		$content .= mysql2date('F j, Y', $post->post_date);
		$content .= '</small>';
		$content .= '</div>';
		$content .= get_the_excerpt();
		$content .= '<p><a href="'. get_permalink().'" class="read-more">Read More</a></p>';

		// $content .= social_div_text();

		$content .= '<div class="osdivider"></div>';
	}

	// Show pagination
	$content .= kriesi_pagination_text('', 2);

	// This is for the facebook counters
	wp_enqueue_script('social_sharing', get_template_directory_uri().'/js/social.js', array('jquery'));

	wp_reset_postdata();

	return $content;
}
add_shortcode('posts_by_category', 'posts_by_category');

function quicklinks_sidebar($attributes) {
	extract(shortcode_atts( 
		array('title' => 'Quicklinks', 
			'page_id' => ''), $attributes));

	$content = '<h2 class="header">'.$title.'</h2>
	<ul>';
	if ($page_id !== '') {
		$pages = explode(',', $page_id);
		foreach ($pages as $key => $value) {
			$title = get_the_title($value);
			$link = get_page_link($value);
			$content .= '<li><a href="'.$link.'">'.$title.'</a></li>';
		}
	}
	$content .= '</ul>';
	return $content;
}
add_shortcode('quicklinks_sidebar', 'quicklinks_sidebar');

function social_shortcode($attributes) {
	extract(shortcode_atts( 
		array('social_link' => 'none', 
			'title' => 'none'), $attributes));

	$content = '<ul class="social">';
	if ($social_link == 'none')
		$social_link = get_permalink();
	if ($title == 'none')
		$title = get_the_title();

	$content .= '<li class="facebook-share" style="display: inline;">';
	$content .= '<div style="margin-top: -2px; float:left;"><a href="https://www.facebook.com/sharer/sharer.php?u='.$social_link.'" target="_blank"><img src="http://company.onescreen.com/files/fb_share_button.png"></a></div>';
	$content .= '<div class="arrow_box pluginCountButton">0</div></li>';

	$content .= '<li style="display: inline;"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$social_link.'" data-text="'.$title.'" data-via="onescreen">Tweet</a>';
	$content .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script>';
	$content .= '</li>';

	$content .= '<li style="display: inline;"><script src="//platform.linkedin.com/in.js" type="text/javascript">';
	$content .= 'lang: en_US</script>';
	$content .= '<script type="IN/Share" data-url="'.$social_link.'" data-counter="right"></script>';
	$content .= '</li>';

	$content .= '<li style="display: inline;"><div class="g-plus" data-action="share" data-annotation="bubble" data-href="'.$social_link.'"></div>';
	$content .= "<div><script type='text/javascript'>
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/plusone.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script></div></li>";

	$content .= '</ul>';

	return $content;
}
add_shortcode('social_shortcode', 'social_shortcode');

?>