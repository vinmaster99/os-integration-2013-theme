
<?php get_header(); ?>

<?php global $post; ?>

<?php $parent_page; ?>

<div class="container">
	<div class="row-fluid">
		<div id="content" class="span7">
			<h1 id="post_title" class="header"><?php echo $post->post_title; ?></h1>

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
					<ul class="ul-tags" style="display: inline;">
						<li>Tags:</li>
						<?php foreach ($tags as $tag) : ?>
							<li><a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
			
			<?php // Comment area ?>
			<?php comments_template(); ?>
			<?php if(!comments_open($post->ID))	{ echo "Comments are closed"; } ?>
		</div>
		<?php // Sidebar ?>
		<div class="span4">
			<h2 class="header">Quick Links</h2>
			<ul>
				<li><?php echo do_shortcode('[about_onescreen_sidebar]'); ?></li>
				<li>Logo Usage &amp; Branding Guidelines</li>
				<li>Contact Us</li>
			</ul>
			<h2 class="header">Newsletter</h2>
			<p>Sign up to receive updates from OneScreen</p>
			<?php echo do_shortcode('[newsletter]'); ?>
			<h2 class="header">Join the Conversation</h2>
			<?php echo do_shortcode('[twitter_feed]'); ?>
		</div>
	</div>
</div>

<?php // This is for the facebook counters ?>
<?php wp_enqueue_script('social_sharing', get_template_directory_uri().'/js/social.js', array('jquery')); ?>

<?php get_footer(); ?>