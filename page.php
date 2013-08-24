
<?php get_header(); ?>

<?php global $post; ?>

<!-- content -->
<?php echo apply_filters('the_content', $post->post_content); ?>

<?php get_footer(); ?>