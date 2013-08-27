<?php

// Allows shortcodes to be used on the site
include 'shortcodes.php';

// Include navigation menus
register_nav_menu( 'header-menu', 'Header Navigation' );

// Add theme support for featured images
add_theme_support( 'post-thumbnails' );

//Print arrays in a really nice readable format
function print_array($data) {
          echo '<pre>';
          print_r($data);
          echo '</pre>';
}

//Convert object to array
function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
 
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }

// [raw] tags to prevent wordpress from changing characters/code
function my_formatter($content) {
       $new_content = '';
       $pattern_full = '{(\[raw\].*?\[/raw\])}is';
       $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
       $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

       foreach ($pieces as $piece) {
               if (preg_match($pattern_contents, $piece, $matches)) {
                       $new_content .= $matches[1];
               } else {
                       $new_content .= wptexturize(wpautop($piece));
               }
       }

       return $new_content;
}
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'my_formatter', 99);


// Register sidebars (widgets)
function register_all_sidebars(){

	if (function_exists('register_sidebar')) {

		// Dynamic Sidebar
		register_sidebar( 
			array(
			'name' => 'Sidebar',
			'id' => 'sidebar',
			'description' => 'This is the sidebar on the right of the webpage. You can add custom widgets to dynamically change this sidebar',
		    'before_widget' => "<div class='widget-section'>",
		    'after_widget' => "</div>", 
		));

		// Homepage widgets section
		register_sidebar(
			array(
				'name' => 'Home Page Widgets',
				'id' => 'homepage-widgets',
				'description' => 'This is the section directly below the slider on the homepage. It uses three custom homepage widgets.',
				'before_widget' => '<li>',
				'after_widget' => '</li>',
				'before_title' => '<h1 class="homewidget-title">',
				'after_title' => '</h1>'
			));

		// // Blog Page Sidebar
		// register_sidebar(
		// 	array(
		// 	'name' => 'Blog Page Sidebar',
		// 	'id' => 'blog-sidebar',
		// 	'description' => 'This is the right sidebar for the blog page template.',
		// 	'before_widget' => '<div class="blog-widget">',
		// 	'after_widget' => '</div>'
		// 	)
		// );

		// Footer widgets section
		register_sidebar(
			array(
				'name' => 'Footer Widgets',
				'id' => 'footer-widgets',
				'description' => 'The designated section for widgets in the footer',
				'before_widget' => '<div class="footer-widget">',
				'after_widget' => '</div>',
				'before_title' => '<h4>',
				'after_title' => '</h4>'
			));
	}

}
add_action('widgets_init', 'register_all_sidebars');
add_filter('widget_text', 'do_shortcode');


// highlight searched terms on search page
function search_excerpt_highlight() {
    // $excerpt = get_the_excerpt();
    $excerpt = get_the_content();
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = preg_replace('/<img[^>]+./', '', $excerpt);
    $excerpt = strip_tags($excerpt);

    $keys = implode('|', explode(' ', get_search_query()));
    $excerpt = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $excerpt);

    $excerpt = substr($excerpt, 0, 750);
    $excerpt .= ' [...]';

    echo '<p>' . $excerpt . '</p>';
}

function search_title_highlight() {
    $title = get_the_title();
    $keys = implode('|', explode(' ', get_search_query()));
    $title = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $title);

    echo $title;
}

function onescreen_excerpt($words){
	$content = get_the_content();
	// strip shortcodes
	$content = strip_shortcodes($content);
	// remove images
	$content = preg_replace('/<img[^>]+./', '', $content);
	// strip html tags
	$content = strip_tags($content);
	// limit the content to 600 words
	$content = substr($content, 0, intval($words));

	echo $content . '...';
}

function get_onescreen_excerpt($post_id, $words){

	$post = get_post($post_id);
	$content = $post->post_content;
	$content = strip_shortcodes($content);
	$content = preg_replace('/<img[^>]+./', '', $content);
	$content = strip_tags($content);
	$content = substr($content, 0, intval($words));

	return $content . '...';
}


// Get Current Page URL
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


//	Add Mime type
function my_myme_types($mime_types=array()){
    $mime_types['otf'] = 'application/x-font-opentype'; //Adding otf extension
    $mime_types['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    $mime_types['eps'] = 'application/postscript';
    $mime_types['ico'] = 'image/x-icon';
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types');

// get featured image
function os_get_featured_image($thumb){
	$thumbnail_array = wp_get_attachment_image_src( $thumb );
	$featured_image = $thumbnail_array[0];
	return str_replace('-150x150', '', $featured_image);
}

// USED IN INTEGRATIONS PAGE

function get_tags_by_cat_ID($category_id) {
	$page_category = 'Integrations';
	$category_id = get_cat_ID($page_category);
	$integrations_args = array('category' => $category_id, 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => -1);
	$post_list = get_posts($integrations_args);
	$all_tags = array();
	foreach ($post_list as $post) {
		foreach (wp_get_post_tags($post->ID) as $tag) {
			$all_tags []= $tag->name;
		}
	}
	$all_tags = array_unique($all_tags);
	sort($all_tags);
	return $all_tags;
}

function filterPosts($posts) {
	if (!isset($_GET['filter']) || $_GET['filter'] == 'Show All')
		return $posts;
	$filter = $_GET['filter'];
	$page_category = 'Integrations';
	$category_id = get_cat_ID($page_category);
	$integrations_args = array('category' => $category_id, 'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => -1);
	$post_list = get_posts($integrations_args);
	foreach ($posts as $key => $value) {
		$tag_list = wp_get_post_tags($value->ID);
		$tag_name_list = array();
		foreach ($tag_list as $tag) {
			$tag_name_list []= $tag->name;
		}
		if (!in_array($filter, $tag_name_list)) {
			unset($posts[$key]);
		}
	}
	return $posts;
}

if ( ! function_exists( 'wordpress_onescreen_comment' ) ) :
// Used for comments.php
function wordpress_onescreen_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'wordpress-onescreen' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'wordpress-onescreen' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'wordpress-onescreen' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'wordpress-onescreen' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wordpress-onescreen' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'wordpress-onescreen' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'wordpress-onescreen' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

function kriesi_pagination($pages = '', $range = 2)
{
	// enqueue pagination.css to prettify our pagination links
	wp_enqueue_style('custom-pagination-style', get_template_directory_uri().'/pagination.css' );
     $showitems = ($range * 2)+1;  
     global $paged;
     if(empty($paged)) $paged = 1;
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }
         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

// Get the excerpt by id
function get_excerpt_by_id($post_id){
    global $post;  
	$save_post = $post;
	$post = get_post($post_id);
	$output = get_the_excerpt();
	$post = $save_post;
	return $output;
}

function register_jquery(){
	if (!is_admin()){
		wp_deregister_script('jquery'); 
		wp_register_script('jquery', 'http://code.jquery.com/jquery-1.10.2.min.js', array(), '', false);
		wp_enqueue_script('jquery');
	}
}

function get_blog_categories() {
	// get the categories for blog posts
	$page_id = get_page_by_title( 'Blog' );
	$cat_string = get_post_meta($page_id->ID, 'categories', true);
	$cat_array = explode(',', $cat_string);
	return $cat_array;
}

function get_press_categories() {
	// get the categories for blog posts
	$page_id = get_page_by_title( 'Press' );
	$cat_string = get_post_meta($page_id->ID, 'categories', true);
	$cat_array = explode(',', $cat_string);
	return $cat_array;
}

function social_div() {
	?>
	<div class="social">
		<?php $social_link = get_permalink(); ?>
		<?php // Facebook ?>
		<div class='facebook-share' style="clear:both;">
		<div style="margin-top: -2px; float:left;"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $social_link; ?>" target="_blank"><img src="http://www.onescreen.com/files/fb_share_button.png"></a></div>
		<div class="arrow_box pluginCountButton">0</div>
		</div>
		<?php // Twitter ?>
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $social_link; ?>" data-text="<?php echo get_the_title(); ?>" data-via="onescreen">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		<?php // Google+ ?>
		<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo $social_link; ?>"></div>
		<!-- Place this tag after the last share tag. -->
		<script type="text/javascript">
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/plusone.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
		<?php //Linkedin ?>
		<script src="//platform.linkedin.com/in.js" type="text/javascript">
		 lang: en_US
		</script>
		<script type="IN/Share" data-url="<?php echo $social_link; ?>" data-counter="right"></script>
	</div>
	<?php
}

function social_div_text() {
	$content = '<div class="social">';
	$social_link = get_permalink();

	$content .= '<div class="facebook-share">';
	$content .= '<div style="margin-top: -2px; float:left;"><a href="https://www.facebook.com/sharer/sharer.php?u='.$social_link.'" target="_blank"><img src="http://www.onescreen.com/files/fb_share_button.png"></a></div>';
	$content .= '<div class="arrow_box pluginCountButton">0</div></div>';

	$content .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$social_link.'" data-text="'.get_the_title().'" data-via="onescreen">Tweet</a>';
	$content .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script>';

	$content .= '<div class="g-plus" data-action="share" data-annotation="bubble" data-href="'.$social_link.'"></div>';
	$content .= "<script type='text/javascript'>
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/plusone.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>";

	$content .= '<script src="//platform.linkedin.com/in.js" type="text/javascript">';
	$content .= 'lang: en_US</script>';
	$content .= '<script type="IN/Share" data-url="'.$social_link.'" data-counter="right"></script>';
	$content .= '</div>';
	return $content;
}

?>