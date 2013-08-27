<?php
/*
Template Name: Archive
*/
?>

<?php get_header(); ?>

<?php global $post; ?>
<?php global $wp_query; ?>
<?php $query = $wp_query->query; ?>
<?php if (isset($query['category_name'])) { ?>
<?php $categories = explode('/', $query['category_name']); ?>
<?php if (count($categories) > 1) $page_title = $categories[1]; else $page_title = $categories[0]; ?>
<?php } else $page_title = 'Archive'; ?>

<?php // ARCHIVE PAGE TEMPLATE BANNER ?>
<?php 	// Set up banner image url 
		// else use 'company' page banner
			$page = get_page_by_title('offerings');
			if ($page != null || $page != '' || isset($page) != false){
				$thumb = get_post_thumbnail_id( $page->ID, 'full' ); 
				if (isset($thumb) && $thumb != ''){
					$thumbnail_array = wp_get_attachment_image_src( $thumb );
					$featured_image = $thumbnail_array[0];
					$featured_image = str_replace('-150x150', '', $featured_image);
					$banner_background_css = get_post_meta($page->ID, 'banner_background_css', true);
				}
			}
?>

<?php // Get the current archive category ?>
<?php $category_object = get_the_category($post->ID);	$category = $category_object[0]->slug; ?>

<?php global $page; ?>

<div class="container">
	<div class="row-fluid">
		<div class="span8">
			<?php
				$back_url = htmlspecialchars($_SERVER['HTTP_REFERER']);
				echo "<a href='{$back_url}' class='list' action='action' type='button'>Back to previous page</a>";
			?>
			<?php
				if ( isset($query['category_name']) && $query['category_name'] != '' ){
					$args = array( 'category_name' => $query['category_name'], 'paged' => max(1 , get_query_var('paged')), 'posts_per_page' => 10, 'orderby' => 'post_date', 'order' => 'desc', 'post_status' => 'publish' );
					$posts = query_posts($args);
				}
		    ?>
		    <?php // LIST THE POSTS ?>
		    <?php $cat_array =  get_blog_categories();?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php $category_object = get_the_category($post->ID); ?>
			<?php $temp = $category_object[0]; ?>
			<?php $category_link = get_category_link($temp->cat_ID); ?>
			<?php $author_id = $post->post_author; $user = get_userdata($author_id); $author_name = $user->first_name . ' ' . $user->last_name; ?>

			<?php
				if ($page_title === '' && !in_array($temp->name, $cat_array)) {
					continue;
				}
			?>
			<div class="post-info">
				<h2 class="post-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="cat-date-author"><a href="<?php echo $category_link; ?>"><?php echo $temp->name; ?></a><span> &nbsp|&nbsp </span><span><?php echo mysql2date('F j, Y', $post->post_date); ?></span><!--<span> &nbsp|&nbsp </span><a href="<?php echo get_author_posts_url($post->post_author); ?>">By <?php echo $author_name; ?></a>--></div>
			</div>
			<a href="<?php the_permalink(); ?>" class="post-list-image">
			<?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
			</a>
			<?php if ($post->post_excerpt != '') $excerpt = $post->post_excerpt; else $excerpt = get_onescreen_excerpt($post->ID, 600); ?>
			<p class="post-list-content"><?php echo $excerpt; ?></p>

			<a href="<?php the_permalink(); ?>" class="keep-reading">keep reading</a>

			<?php // Social div ?>
			<?php social_div(); ?>

			<div class="osdivider"></div>
			
			<?php endwhile; ?>
			<?php endif; ?>

			<?php // PAGINATE POSTS HERE ?>
			<?php kriesi_pagination('', 2); ?>

		</div>
	</div> 	<?php // end of container ?>
</div>	<?php // end of primary ?>


<?php wp_enqueue_script('social_sharing', get_template_directory_uri().'/js/social.js', array('jquery')); ?>

<?php get_footer(); ?>