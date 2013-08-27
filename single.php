
<?php get_header(); ?>

<?php global $post; ?>

<?php $parent_page; ?>

<?php 	
	// SET UP BANNER URL

	// set up sidebar for posts
	$category = get_the_category($post->ID);

	// flag for a post in a subcategory of the blog page
	$category = $category[0];
	$page_category = $category;
	if ($category->parent != 0){
		$cat_id = $category->parent;
		$category = get_category($cat_id);
	}

	$cat_slug = $category->name;
	$page = get_page_by_title($cat_slug);
	$parent_id = $page->ID;
	$thumb;
	if ($parent_id != 0){ 
		while ($parent_id != 0 || !isset($thumb)){ 
			$parent_page = get_page($parent_id); 
			$thumb = get_post_thumbnail_id($parent_page->ID, 'full');
			$parent_id = $parent_page->post_parent; 
		} 
		$featured_image = os_get_featured_image($thumb);
		$banner_background_css = get_post_meta($parent_page->ID, 'banner_background_css', true); 
	}
	// CHECK IF CURRENT POST HAS FEATURED IMAGE
	// if post has featured image
	// $thumb = get_post_thumbnail_id( $post->ID, 'full' ); 
	// if (isset($thumb) && $thumb != ''){
	// $featured_image = os_get_featured_image($thumb);
	// 	$banner_background_css = get_post_meta($post->ID, 'banner_background_css', true); 
	// }
	// else check if post category has a page,
	// if category has page, check if page has featured image and use that
	// else {
	if (!isset($thumb)){
		$thumb = get_post_thumbnail_id($page->ID, 'full');
		if ( ($page != null || $page != '' || isset($page) != false) && isset($thumb) && $thumb != '' ){
			$featured_image = os_get_featured_image($thumb);
			$banner_background_css = get_post_meta($page->ID, 'banner_background_css', true); 
		}
		else {	// else use 'offerings' page banner
			$defaultpage = get_page_by_title('offerings');
			if ($defaultpage != null || $defaultpage != '' || isset($defaultpage) != false){
				$thumb = get_post_thumbnail_id( $defaultpage->ID, 'full' ); 
				if (isset($thumb) && $thumb != ''){
					$featured_image = os_get_featured_image($thumb);
					$banner_background_css = get_post_meta($defaultpage->ID, 'banner_background_css', true); 
				}
			}
		}
	}
	// }

	$show_banner = get_post_meta($post->ID, 'show_banner', true);
	$banner_height = get_post_meta($post->ID, 'banner_height', true);
	
?>


<div class="container" id="content-container">
	<h1 id="page-title"><?php  echo ( !empty($page) && stripos($page->post_title, 'blog') !== false ) ? $page->post_title : $page_category->name; ?></h1>
	<!-- <div id="container-inside"> -->
		<div id="content" class="span7">
			<h1 id="post-title"><?php echo $post->post_title; ?></h1>

			<?php // Social div ?>
			<?php social_div(); ?>
			
			<?php $category_object = get_the_category($post->ID); ?>
			<?php $temp = $category_object[0]; ?>
			<?php $category_link = get_category_link($temp->cat_ID); ?>
			<div class="post-info"><div class="cat-date-author"><a href="<?php echo $category_link; ?>"><?php echo $temp->name; ?></a><?php echo " &nbsp|&nbsp ".mysql2date('F j, Y', $post->post_date); ?></div></div>
			
			<!-- BUG: for some reason adding an excerpt to the post messes up post content display -->
			<!-- Had to apply [raw] shortcode for shortcodes & content to display correctly (when adding an excerpt to post) -->
			<?php if (!empty($post->post_excerpt) || $post->excerpt != '') : ?>
				<?php $content = '[raw]'.$post->post_content.'[/raw]'; ?>
			<?php else : ?>
				<?php $content = $post->post_content; ?>
			<?php endif; ?>
			<p><?php echo wpautop(apply_filters('the_content', $content)); ?></p>

			<?php // LIST TAGS IF ANY ?>
			<?php $tags = wp_get_post_tags($post->ID); ?>
			<?php if (count($tags) > 0) : ?>
				<div class="post-tags">
					<ul class="ul-tags">
						<li>Tags:</li>
						<?php foreach ($tags as $tag) : ?>
							<li><a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
			
			<?php
				// Cat to exclude for previous and next post links
				$cat_to_include = get_blog_categories();
				$cat_ID_to_exclude = array();
				foreach ($cat_to_include as $key => $value) {
					array_push($cat_ID_to_exclude, get_cat_ID($value));
				}
				$cat_to_exclude_array = get_categories('orderby=name&exclude='.implode(',', $cat_ID_to_exclude));
				$cat_to_exclude = array();
				foreach ($cat_to_exclude_array as $key => $value) {
					array_push($cat_to_exclude, $value->cat_ID);
				}
			?>

			<?php // Previous and next post ?>
			<div class="nav-between-posts">
			<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'wordpress-onescreen' ) . '</span> %title', FALSE, $cat_to_exclude); ?></span>
			<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'wordpress-onescreen' ) . '</span>', FALSE, $cat_to_exclude ); ?></span>
			</div>
			<?php // Comment area ?>
			<?php comments_template(); ?>
			<?php if(!comments_open($post->ID))	{ echo "Comments are closed"; } ?>
		</div>
	<!-- </div> -->
</div>

<?php // This is for the facebook counters ?>
<?php wp_enqueue_script('social_sharing', get_template_directory_uri().'/js/social.js', array('jquery')); ?>

<?php get_footer(); ?>