<?php 
/*
Template Name: Press
*/
?>

<?php get_header(); ?>

<?php global $post; ?>

<?php if (get_the_title($post->ID) != 'Press' && get_the_title($post->post_parent) == 'Press') { // This is sub page of Press ?>

<!-- content -->
<?php echo apply_filters('the_content', $post->post_content); ?>

<?php $category_name = get_the_title($post->ID); ?>

<div id="content-container" class="container">
	<div id="content">
		<div class="row-fluid">
			<div class="span8"><?php echo do_shortcode('[posts_by_category category_name='.$category_name.']'); ?></div>
			<div class="span4">
				<div class="sidebar">
					<?php dynamic_sidebar('sidebar'); // Managed by wordpress widgets sidebar ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } else { // This is page of Press?>

<!-- content -->
<?php echo apply_filters('the_content', $post->post_content); ?>

<div id="content-container" class="container">
	<div id="content">
		<div class="row-fluid">
			<div class="span8"><?php echo do_shortcode('[press_posts]'); ?></div>
			<div class="span4">
				<div class="sidebar">l
					<?php dynamic_sidebar('sidebar'); // Managed by wordpress widgets sidebar ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>

<?php get_footer(); ?>