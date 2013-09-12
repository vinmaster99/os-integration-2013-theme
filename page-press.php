<?php 
/*
Template Name: Press
*/
?>

<?php get_header(); ?>

<?php global $post; ?>

<!-- content -->
<?php echo apply_filters('the_content', $post->post_content); ?>

<div id="content-container" class="container">
	<div id="content">
		<div class="row-fluid">
			<div class="span8"><?php echo do_shortcode('[press_posts]'); ?></div>
			<div class="span4">
				<div class="sidebar">
					<?php dynamic_sidebar('sidebar'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>