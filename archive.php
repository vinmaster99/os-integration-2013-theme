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

<?php // Get the current archive category ?>
<?php $category_object = get_the_category($post->ID);	$category = $category_object[0]->slug; ?>

<?php global $page; ?>

<div class="container">
<div id="subheader" class="container">
			<?php
			// This is the back button
			$back_url = htmlspecialchars($_SERVER['HTTP_REFERER']);
			echo "<a href='{$back_url}' class='list' action='action' type='button'>Back to previous page</a>";
			?>
<h1 class="header" style="text-transform: capitalize;" >
<?php echo $page_title; ?></h1>	<?php if ($page_title == 'articles') { ?>
	
		<div class="navbar">
			<ul class="nav">
			  <li><a href="/resources/">Resources</a></li>
			  <li><a href="/resources/case-studies/">Case Studies</a></li>
			  <li><a href="/resources/industry-guides/">Industry Guides</a></li>
			  <li><a href="/resources/whitepapers/">Whitepapers</a></li>
			  <li><a href="/blog/">Blog</a></li>
			  <li class="active"><a href="/category/resources/articles/">Articles</a></li>
			</ul>
		</div>
	</div>
	<?  } else {
			echo '';
		}
	?>
	<div class="row-fluid">
		<div class="span8">
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
				<h2 class="post-list-title header"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="cat-date-author"><small><a href="<?php echo $category_link; ?>"><?php echo $temp->name; ?></small></a><small><span> &nbsp|&nbsp </span></small><small><span><?php echo mysql2date('F j, Y', $post->post_date); ?></span></small><!--<span> &nbsp|&nbsp </span><a href="<?php echo get_author_posts_url($post->post_author); ?>">By <?php echo $author_name; ?></a>--></div>
			</div>
			<a href="<?php the_permalink(); ?>" class="post-list-image">
			</a>
			<?php if ($post->post_excerpt != '') $excerpt = $post->post_excerpt; else $excerpt = get_onescreen_excerpt($post->ID, 600); ?>
			<p class="post-list-content"><?php echo $excerpt; ?></p>

			<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>

			<?php // Social div ?>
			<?php //social_div(); ?>

			<?php // draw divider ?>
			<div class="osdivider"></div>
			
			<?php endwhile; ?>
			<?php endif; ?>

			<?php // PAGINATE POSTS HERE ?>
			<?php kriesi_pagination('', 2); ?>

		</div>
		<?php // Sidebar ?>

		<div class="span4">
			<div class="sidebar">
				<h2 class="header">Search</h2>
				<?php echo do_shortcode('[search_bar]'); ?>
				<h2 class="header">Categories</h2>
				<?php echo do_shortcode('[filter_by_categories]'); ?>
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