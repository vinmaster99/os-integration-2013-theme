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

<?php // LOAD BANNER OPTIONS ?>
<?php $show_banner = get_post_meta($post->ID, 'show_banner', true); ?>
<?php // ARCHIVE Page banner height adjustment ?>
<?php global $page; ?>
<?php if ($page) { ?>
<?php $banner_height = get_post_meta($page->ID, 'banner_height', true); ?>
<?php } ?>
<?php //$banner_background_css = get_post_meta($post->ID, 'banner_background_css', true); ?>
<div id="banner" style="background-image:url('<?php echo $featured_image; ?>');
	<?php echo (isset($show_banner) && $show_banner == 'no') ? 'background-image:none' : ''; ?>;
	background-position:top center;
	">
	<span id="banner-background" style="<?php echo $banner_background_css; ?>"></span>
	<?php // <div id="fade-gradient"></div> ?>
	<!-- <img src="<?php //echo (isset($featured_image)) ? $featured_image : ''; ?>"> -->
	<div class="container" style="height:100%;">
		<h1 id="page-title" style="top:250px;"><?php if ($page_title === '') echo 'Archive'; else echo $page_title; ?></h1>
	</div>
</div>
<?php // END OF ARCHIVE PAGE BANNER ?>

<div id="primary" class="container">

	<?php // background left ?>
	<!-- <div class="container-left"></div> -->

	<?php // background right ?>
	<!-- <div class="container-right"></div>  -->

	<?php // content ?>
	<div class="row-fluid" id="content-container">
		<!-- <div id="container-inside"> -->
			<div id="content" class="span8">
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
			    <?php $cat_array =  get_cat_array(); ?>
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

				<div class="osdivider"></div>
				
				<?php endwhile; ?>
				<?php endif; ?>

				<?php // PAGINATE POSTS HERE ?>
				<?php kriesi_pagination('', 2); ?>

			</div>
		<!-- </div> --> 	<?php // end of inside container ?>
	</div> 	<?php // end of container ?>

</div>	<?php // end of primary ?>


<?php wp_enqueue_script('social_sharing', get_template_directory_uri().'/js/social.js', array('jquery')); ?>

<?php get_footer(); ?>