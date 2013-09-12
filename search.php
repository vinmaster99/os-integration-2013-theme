<?php 
//SEARCH PAGE TEMPLATE 
?>

<?php get_header(); ?>

<div class="container">
	<div class="row-fluid">
		<div class="span8">
			<?php
			// This is the back button
			$back_url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			echo "<a href='{$back_url}' class='list' action='action' type='button'>Back to previous page</a>";
			?>
			<!-- GET CATEGORIES OF POSTS TO DISPLAY -->
			<!-- PREVSERVE PAGINATION -->
			<?php
			global $query_string;

			$query_args = explode("&", $query_string);
			$search_query = array('posts_per_page' => 10, 'numberposts' => 10);

			foreach($query_args as $key => $string) {
				$query_split = explode("=", $string);
				$search_query[$query_split[0]] = urldecode($query_split[1]);
				} // foreach

				$search = new WP_Query($search_query);
				?>
				<?php global $wp_query; ?>
				<?php $total_results = $wp_query->found_posts; ?>
				<h1 class="header" id="searchpage-title"><?php printf( __( '('.$total_results.')' . ' Search Results for: %s', 'framework' ), '<br /><span style="font-style:italic;">"' . get_search_query() . '"</span>' ); ?></h1>

				<?php $posts = $search->posts; ?>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php //print_array($post->post_status); ?>
				<?php if ($post->post_status == 'publish') : ?>

				<?php $category_object = get_the_category($post->ID); ?>
				<?php $temp = $category_object[0]; ?>
				<?php $category_link = get_category_link($temp->cat_ID); ?>
				<?php $author_id = $post->post_author; $user = get_userdata($author_id); $author_name = $user->first_name . ' ' . $user->last_name; ?>

				<div class="post-info">
					<h2 class="header post-list-title"><a href="<?php the_permalink(); ?>"><?php search_title_highlight(); ?></a></h2>
					<div class="cat-date-author">
						<?php if (isset($category_link) && $category_link != '') : ?>
						<a href="<?php echo $category_link; ?>"><?php echo $temp->name; ?></a><span> &nbsp|&nbsp </span>
					<?php endif; ?>
					<span><?php echo mysql2date('F j, Y', $post->post_date); ?></span><span> &nbsp|&nbsp </span><a href="<?php echo get_author_posts_url($post->post_author); ?>">By <?php echo $author_name; ?></a></div>
				</div>
				<a href="<?php the_permalink(); ?>" class="post-list-image">
					<?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
				</a>
				<p class="post-list-content"><?php search_excerpt_highlight(); ?></p>

				<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>

				<?php // Social div ?>
				<?php social_div(); ?>

				<div class="osdivider"></div>

			<?php endif; // if private ?>

		<?php endwhile; ?>
	<?php endif; ?>

	<!-- PAGINATE POSTS HERE -->
	<?php kriesi_pagination('', 2); ?>

	</div>
	<?php wp_reset_query(); global $post; ?>

	<?php // Sidebar ?>
	<div class="span4">
		<div class="sidebar">
			<h2 class="header">Categories</h2>
			<?php echo do_shortcode('[filter_by_categories]'); ?>
			<h2 class="header">Search</h2>
			<?php echo do_shortcode('[search_bar]'); ?>
			<h2 class="header">Month</h2>
			<?php echo do_shortcode('[filter_by_months]'); ?>
			<h2 class="header">Newsletter</h2>
			<p>Sign up to receive updates from OneScreen</p>
			<?php echo do_shortcode('[newsletter]'); ?>
		</div>
	</div>
</div>
</div>

<?php // This is for the facebook counters ?>
<?php wp_enqueue_script('social_sharing', get_template_directory_uri().'/js/social.js', array('jquery')); ?>

<?php get_footer(); ?>