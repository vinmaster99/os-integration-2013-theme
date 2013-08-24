<?php get_header(); ?>

<?php global $post; ?>
<?php global $wpdb; ?>
<?php $page_id = $wpdb->get_col("select ID from $wpdb->posts where post_title like 'Home Page'"); ?>
<?php $args = array( 'post__in' => $page_id, 'post_type' => 'page', 'orderby' => 'title', 'order' => 'asc' ); ?>
<?php $posts = new WP_Query($args); ?>

<?php // HAD TO USE WORDPRESS LOOP BECAUSE FOR SOME REASON SHORTCODES DONT WORK OUTSIDE LOOP ?>
<?php if ($posts->have_posts()) : while ($posts->have_posts()) : $posts->the_post(); ?>
	<?php the_content(); ?>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>