<?php 

/* ONESCREEN CUSTOM WIDGETS */

/* HOME WIDGET */
// Prints Section Title, Image, Sub-Title, Description (on homepage)
class home_widget extends WP_Widget {

	function home_widget(){
		$widget_ops = array( 'classname' => 'Home Widget Class', 'description' => 'Shows a featured section\'s article' );

		$control_ops = array( 'width' => 294, 'id_base' => 'home_widget' );

		$this->WP_Widget( 'home_widget', 'Home Widget', $widget_ops, $control_ops );

		if (is_active_widget(false, false, $this->id_base)) wp_enqueue_style( 'custom-widgets', get_template_directory_uri() . '/widgets.css' );
	}

	function widget($args, $instance){
		extract($args);

		// $instance is an array of variables
		// you can easily add new variables
		// ex. $title = $instance['title']
		$widget_title = $instance['widget_title'];
		$img = $instance['image'];
		$article_title = $instance['article_title'];
		$article_content = $instance['article_description'];

		?>
		<div class="home-widget">
			<h1><?php echo $widget_title; ?></h1>
			<img src="<?php echo $img; ?>">
			<h2><?php echo $article_title; ?></h2>
			<h3><?php echo $article_content; ?></h3>
		</div>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;

		// Strip tags fromt itle and name to remove HTML
		$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		$instance['image'] = strip_tags( $new_instance['image'] );
		$instance['article_title'] = strip_tags( $new_instance['article_title'] );
		$instance['article_description'] = strip_tags( $new_instance['article_description'] );

		return $instance;
	}

	function form($instance){
		// Set up some default widget settings.
		// $defaults = array( 'widget_title' => __('Example', 'example'), 'name' => __('Bilal Shaheen', 'example'), 'show_info' => true );
		// $instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e('Section Title:'); ?></label><br />
			<input class="homewidget-input" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo $instance['widget_title']; ?>" />
		</p>
		<!-- Image -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e('Image URL:'); ?></label><br />
			<textarea class="homewidget-textarea" name="<?php echo $this->get_field_name( 'image' ); ?>" ><?php echo $instance['image']; ?></textarea>
		</p>
		<!-- Article Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'article_title' ); ?>"><?php _e('Article Title:'); ?></label><br />
			<input class="homewidget-input" name="<?php echo $this->get_field_name( 'article_title' ); ?>" value="<?php echo $instance['article_title']; ?>" />
		</p>
		<!-- Article Content -->
		<p>
			<label for="<?php echo $this->get_field_id( 'article_description' ); ?>"><?php _e('Article Description:'); ?></label><br />
			<textarea class="homewidget-textarea" name="<?php echo $this->get_field_name( 'article_description' ); ?>" ><?php echo $instance['article_description']; ?></textarea>
		</p>

		<?php
	}
}

/* CONNECT WITH ONESCREEN WIDGET */
class connect_with_onescreen extends WP_Widget {
	function connect_with_onescreen(){
		$widget_ops = array( 'classname' => 'Connect With Onescreen Class', 'description' => 'Display\'s "Connect With OneScreen" widget at the bottom of the footer.' );

		$control_ops = array( 'width' => 290, 'id_base' => 'connect_with_onescreen' );

		$this->WP_Widget( 'connect_with_onescreen', 'Connect With ONESCREEN', $widget_ops, $control_ops );

		if (is_active_widget(false, false, $this->id_base)) wp_enqueue_style( 'custom-widgets', get_template_directory_uri() . '/widgets.css' );
	}
	function widget($args, $instance){
		extract($args);

		// widget variables
		$widget_title = $instance['widget_title'];
		$widget_id = $instance['widget_id'];
		$onescreen_text = $instance['connect_onescreen_text'];
		$onescreen_url = 'mailto:connect@onescreen.com';
		$osmail_text = $instance['connect_osmail_text'];
		$osmail_url = 'mailto:connect@onescreen.com';
		$google_text = $instance['connect_google_text'];
		$google_url = 'http://www.gplus.to/onescreen';
		$facebook_text = $instance['connect_facebook_text'];
		$facebook_url = 'http://www.fb.com/onescreen';
		$twitter_text = $instance['connect_twitter_text'];
		$twitter_url = 'http://www.twitter.com/onescreen';
		$linkedin_text = $instance['connect_linkedin_text'];
		$linkedin_url = 'http://www.linkedin.com/company/onescreen';

		// $pinterest_text = $instance['connect_pinterest_text'];
		// $pinterest_url = 'http://www.pinterest.com/onescreen';
		// $tumblr_text = $instance['connect_tumblr_text'];
		// $tumblr_url = 'http://www.onescreen.tumblr.com';
		// $instagram_text = $instance['connect_instagram_text'];
		// $instagram_url = 'http://www.instagram.com/onescreen';


		?>
		<div id=id="<?php echo ( isset($widget_id) && $widget_id != '' ) ? $widget_id : 'connect-with-onescreen'; ?>">
		<ul>
			<h4><?php echo $widget_title; ?></h4>
			<li><a href="<?php echo $onescreen_url; ?>"><img src="<?php echo (isset($onescreen_icon) && $onescreen_icon != '' ) ? $onescreen_icon : bloginfo('template_url').'/images/icon_phone.png'; ?>"></a><a href="<?php echo $onescreen_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($onescreen_text) && $onescreen_text != '' ) ? $onescreen_text : '949-525-4466 | 855-ONESCREEN'; ?></a></li>
			<li><a href="<?php echo $osmail_url; ?>"><img src="<?php echo (isset($osmail_icon) && $osmail_icon != '' ) ? $onescreen_icon : bloginfo('template_url').'/images/icon_email.png'; ?>"></a><a href="<?php echo $osmail_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($osmail_text) && $osmail_text != '' ) ? $osmail_text : 'connect@onescreen.com'; ?></a></li>			
			<li><a href="<?php echo $google_url; ?>" target="_blank"><img src="<?php echo (isset($google_icon) && $google_icon != '' ) ? $google_icon : bloginfo('template_url').'/images/icon_google.png'; ?>"></a><a href="<?php echo $google_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($google_text) && $google_text != '' ) ? $google_text : 'gplus.to/onescreen'; ?></a></li>
			<li><a href="<?php echo $facebook_url; ?>" target="_blank"><img src="<?php echo (isset($facebook_icon) && $facebook_icon != '' ) ? $facebook_icon : bloginfo('template_url').'/images/icon_facebook.png'; ?>"></a><a href="<?php echo $facebook_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($facebook_text) && $facebook_text != '' ) ? $facebook_text : 'fb.com/onescreen'; ?></a></li>
			<li><a href="<?php echo $twitter_url; ?>" target="_blank"><img src="<?php echo (isset($twitter_icon) && $twitter_icon != '' ) ? $twitter_icon : bloginfo('template_url').'/images/icon_twitter.png'; ?>"></a><a href="<?php echo $twitter_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($twitter_text) && $twitter_text != '' ) ? $twitter_text : 'twitter.com/onescreen'; ?></a></li>
			<li><a href="<?php echo $linkedin_url; ?>" target="_blank"><img src="<?php echo (isset($linkedin_icon) && $linkedin_icon != '' ) ? $linkedin_icon : bloginfo('template_url').'/images/icon_linkedin.png'; ?>"></a><a href="<?php echo $linkedin_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($linkedin_text) && $linkedin_text != '' ) ? $linkedin_text : 'linkedin.com/company/onescreen'; ?></a></li>
			<!-- <li><a href="<?php echo $pinterest_url; ?>" target="_blank"><img src="<?php echo (isset($pinterest_icon) && $pinterest_icon != '' ) ? $pinterest_icon : bloginfo('template_url').'/images/icon_pinterest.png'; ?>"></a><a href="<?php echo $pinterest_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($pinterest_text) && $pinterest_text != '' ) ? $pinterest_text : 'pinterest.com/onescreen'; ?></a></li> -->
			<!-- <li><a href="<?php echo $tumblr_url; ?>" target="_blank"><img src="<?php echo (isset($tumblr_icon) && $tumblr_icon != '' ) ? $tumblr_icon : bloginfo('template_url').'/images/icon_tumblr.png'; ?>"></a><a href="<?php echo $tumblr_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($tumblr_text) && $tumblr_text != '' ) ? $tumblr_text : 'onescreen.tumblr.com' ?></a></li> -->
			<!-- <li><a href="<?php echo $instagram_url; ?>" target="_blank"><img src="<?php echo (isset($instagram_icon) && $instagram_icon != '' ) ? $instagram_icon : bloginfo('template_url').'/images/icon_instagram.png'; ?>"></a><a href="<?php echo $instagram_url; ?>" class="connect-with-url" target="_blank"><?php echo ( isset($instagram_text) && $instagram_text != '' ) ? $instagram_text : 'instagram.com/onescreen'; ?></a></li> -->
			
		</ul>
		</div>
		<?php
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		$instance['widget_id'] = strip_tags( $new_instance['widget_id'] );
		$instance['connect_onescreen_text'] = strip_tags( $new_instance['connect_onescreen_text'] );
		$instance['connect_osmail_text'] = strip_tags( $new_instance['connect_osmail_text'] );
		$instance['connect_google_text'] = strip_tags( $new_instance['connect_google_text'] );
		$instance['connect_facebook_text'] = strip_tags( $new_instance['connect_facebook_text'] );
		$instance['connect_twitter_text'] = strip_tags( $new_instance['connect_twitter_text'] );
		$instance['connect_linkedin_text'] = strip_tags( $new_instance['connect_linkedin_text'] );

		// $instance['connect_pinterest_text'] = strip_tags( $new_instance['connect_pinterest_text'] );
		// $instance['connect_tumblr_text'] = strip_tags( $new_instance['connect_tumblr_text'] );
		// $instance['connect_instagram_text'] = strip_tags( $new_instance['connect_instagram_text'] );

		return $instance;
	}
	function form($instance){
		$count = 0;
		?>
		</script>
		<!-- CONNECT WITH ONESCREEN DIV -->
		<div id="connect-with-onescreen-container">
			<p><label>Title: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo $instance['widget_title']; ?>" /></p>
			<p><label>Widget ID (for custom styling): </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'widget_id' ); ?>" value="<?php echo $instance['widget_id']; ?>" /></p>
			<p><label>OneScreen Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_onescreen_text' ); ?>" value="<?php echo $instance['connect_onescreen_text']; ?>" /></p>
			<p><label>Email Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_osmail_text' ); ?>" value="<?php echo $instance['connect_osmail_text']; ?>" /></p>
			<p><label>Google Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_google_text' ); ?>" value="<?php echo $instance['connect_google_url']; ?>" /></p>
			<p><label>Facebook Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_facebook_text' ); ?>" value="<?php echo $instance['connect_facebook_text']; ?>" /></p>
			<p><label>Twitter Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_twitter_text' ); ?>" value="<?php echo $instance['connect_twitter_text']; ?>" /></p>
			<p><label>Linkedin Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_linkedin_text' ); ?>" value="<?php echo $instance['connect_linkedin_text']; ?>" /></p>
			<!-- <p><label>Pinterest Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_pinterest_text' ); ?>" value="<?php echo $instance['connect_pinterest_text']; ?>" /></p> -->
			<!-- <p><label>Tumblr Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_tumblr_text' ); ?>" value="<?php echo $instance['connect_tumblr_text']; ?>" /></p> -->
			<!-- <p><label>Instagram Text: </label><br /><input class="homewidget-input" name="<?php echo $this->get_field_name( 'connect_instagram_text' ); ?>" value="<?php echo $instance['connect_instagram_text']; ?>" /></p> -->

		</div>
		<?php
	}
}

class about_onescreen extends WP_Widget {
	function about_onescreen(){
		$widget_ops = array( 'classname' => 'About OneScreen Class', 'description' => 'The "About OneScreen" Section in the footer' );

		$control_ops = array( 'width' => 290, 'id_base' => 'about_onescreen' );

		$this->WP_Widget( 'about_onescreen', 'About OneScreen', $widget_ops, $control_ops );
	}
	function widget($args, $instance){
		extract($args);
		$title = $instance['about_onescreen_title'];
		$description = $instance['about_onescreen_description'];
		?>
		<div id="about-onescreen">
		<h4><?php echo $title; ?></h4>
		<p><?php echo $description; ?></p>
		</div>
		<?php
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['about_onescreen_title'] = strip_tags( $new_instance['about_onescreen_title'] );
		$instance['about_onescreen_description'] = strip_tags( $new_instance['about_onescreen_description'] );

		return $instance;
	}
	function form($instance){
		?>
		<p>
			<label><?php _e('Title:'); ?></label><br />
			<input class="homewidget-input" name="<?php echo $this->get_field_name( 'about_onescreen_title' ); ?>" value="<?php echo $instance['about_onescreen_title']; ?>" />
		</p>
		<p>
			<label><?php _e('Description:'); ?></label><br />
			<textarea class="homewidget-textarea" name="<?php echo $this->get_field_name( 'about_onescreen_description' ); ?>" ><?php echo $instance['about_onescreen_description']; ?></textarea>
		</p>
		<?php
	}
}

/* FILTER WIDGET (FOR BLOG PAGE) */
class filter_by_widget extends WP_Widget {
	function filter_by_widget(){
		$widget_ops = array( 'classname' => 'Filter By Widget', 'description' => 'Displays links on the sidebar which allow user to filter posts either by views, category, month or all' );

		$control_ops = array( 'width' => 250, 'id_base' => 'filter_by_widget' );

		$this->WP_Widget('filter_by_widget', 'Filter By Widget', $widget_ops, $control_ops);
	}
	function widget($args, $instance){
		extract($args);

		$blog_url = home_url() . '/blog';
		$current_url = curPageURL();
		$post = get_page_by_title('blog');
		$categories = get_post_meta($post->ID, 'categories_to_include', true);
		$categories = str_replace(', ', ',', $categories);
		$categories = explode(',', $categories);

		?>
		<div class="filter-by-container">
			<ul class="filter-by-list">
				<li class="<?php echo (stripos($current_url, $blog_url) !== false) ? 'current_page_item' : ''; ?>"><a href="<?php echo $blog_url; ?>">Show All</a></li>
				<!-- <li class="<?php //echo (stripos($current_url, 'filter_by=views') !== false) ? 'current_page_item' : ''; ?>"><a href="?filter_by=views">Filter By Views</a></li> -->
				<li class="<?php echo (stripos($current_url, 'filter_by=category') !== false) ? 'current_page_item' : ''; ?>">
					<a href="?filter_by=category">Filter By Category</a>
					<ul>
						<?php foreach ($categories as $category) : ?>
						<?php if (is_numeric($category)) { $category_object = get_category($category); $category = $category_object->name; $category_slug = $category_object->slug; } else $category_slug = str_replace(' ', '-', $category); ?>
							<li class="<?php echo (stripos($current_url, $category) !== false) ? 'current_page_item' : ''; ?>"><a href="<?php echo home_url().'/category/'.$category_slug; ?>"><?php echo $category; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<li class="<?php echo (stripos($current_url, 'filter_by=month') !== false) ? 'current_page_item' : ''; ?>">
					<a href="?filter_by=month">Filter By Month</a>
					<ul>
						<?php wp_get_archives( array('limit' => 6) ); ?>
					</ul>
				</li>
			</ul>
		</div>
		<?php
	}
	function update($new_instance, $old_instance){

	}
	function form($instance){

	}
}

/*
	Widget to show the post with the most views.
	Requires 'Popular Posts by Views' plugin
*/
class most_popular_posts extends WP_Widget {

	// Constructor
	public function most_popular_posts() {
		// Process widget
		$widget_ops = array( 'classname' => 'Most Popular Posts', 'description' => 'Display top posts by views' );

		$control_ops = array( 'width' => 250, 'id_base' => 'most_popular_posts' );

		$this->WP_Widget('most_popular_posts', 'Most Popular Posts', $widget_ops, $control_ops);
	}

	public function widget($args, $instance) {
		// Outputs the content of the widget
		extract($args);

		if (!isset($instance['widget_title'])) {
			$widget_title = "Most Popular Posts";
		} else {
			$widget_title = $instance['widget_title'];
		}

		echo "<div id='popular_by_views'>"; // create a container
			echo $widget_title;
			global $wpdb, $ppbv_tablename; // call global for use in function
		    
		    echo "<ul id='popular_by_views_list'>"; // create an ordered list
		        $popular = $wpdb->get_results("SELECT * FROM {$ppbv_tablename} ORDER BY views DESC LIMIT 0,5",ARRAY_N);
		        foreach($popular as $post){ // loop through the returned array of popular posts
		            $ID = $post[1]; // store the data in a variable to save a few characters and keep the code cleaner
		            $post_category = get_the_category($ID);
		            if (false) {

		            }
		            $views = number_format($post[2]); // number_format adds the commas in the right spots for numbers (ex: 12543 to 12,543)
		            $post_url = get_permalink($ID); // get the URL of the current post in the loop
		            $title = get_the_title($ID); // get the title of the current post in the loop
		            if ($views != 0) {
		            	echo "<li class='list'><a href='{$post_url}'>{$title}</a></li>"; // echo out the information in a list-item
		            }
		        } // end the loop
		    echo "</ul>"; // close the ordered list

		echo "</div>"; // close the container
	}

	public function form($instance) {
		?>
		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e('Section Title:'); ?></label><br />
			<input class="homewidget-input" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php if(!isset($instance['widget_title'])) echo "Most Popular Posts"; else echo $instance['widget_title']; ?>" />
		</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		// Processes widget options to be saved

		$instance = $old_instance;

		// Strip tags fromt itle and name to remove HTML
		$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		return $instance;
	}
}

/*
	Widget to show the post with the most comments.
*/
class most_commented_posts extends WP_Widget {

	// Constructor
	public function most_commented_posts() {
		// Process widget
		$widget_ops = array( 'classname' => 'Most Commented Posts', 'description' => 'Display top posts by comment count' );

		$control_ops = array( 'width' => 250, 'id_base' => 'most_commented_posts' );

		$this->WP_Widget('most_commented_posts', 'Most Commented Posts', $widget_ops, $control_ops);
	}

	public function widget($args, $instance) {
		// Outputs the content of the widget
		extract($args);

		if (!isset($instance['widget_title'])) {
			$widget_title = "Most Commented Posts";
		} else {
			$widget_title = $instance['widget_title'];
		}

		echo "<div id='popular_by_comments'>";
			echo $widget_title;
			echo "<ul id='popular_by_comments_list'>";

				global $wpdb; // call global for use in function
				$popular = $wpdb->get_results("SELECT * FROM wp_posts ORDER BY comment_count DESC LIMIT 0,5",ARRAY_N);
				foreach($popular as $post){ // loop through the returned array of popular posts
				    $ID = $post[0]; // store the data in a variable to save a few characters and keep the code cleaner
				    $views = number_format($post[22]); // number_format adds the commas in the right spots for numbers (ex: 12543 to 12,543)
				    $post_url = get_permalink($ID); // get the URL of the current post in the loop
				    // $title = get_the_title($ID); // get the title of the current post in the loop
				    $title = $post[5];
				    if ($views != 0) {
				    	echo "<li class='list'><a href='{$post_url}'>{$title}</a></li>"; // echo out the information in a list-item
					}
				} // end the loop
			echo "</ul>";
		echo "</div>";
	}

	public function form($instance) {
		// Outputs the options form on admin
		?>
		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e('Section Title:'); ?></label><br />
			<input class="homewidget-input" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php if(!isset($instance['widget_title'])) echo "Most Commented Posts"; else echo $instance['widget_title']; ?>" />
		</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		// Processes widget options to be saved
		$instance = $old_instance;

		// Strip tags fromt itle and name to remove HTML
		$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		return $instance;
	}
}

/* Custom text widget without the footer-widget div class */
class custom_text extends WP_Widget {
	// Constructor
	public function custom_text() {
		// Process widget
		$widget_ops = array( 'classname' => 'Custom Text', 'description' => 'Display text or HTML without extra div' );

		$control_ops = array( 'width' => 400, 'id_base' => 'custom_text' );

		$this->WP_Widget('custom_text', 'Custom Text', $widget_ops, $control_ops);
	}

	public function widget($args, $instance) {
		// Outputs the content of the widget
		extract($args);

		if (!isset($instance['widget_text'])) {
			$widget_text = "Footer";
		} else {
			$widget_text = $instance['widget_text'];
		}
		// echo wpautop(apply_filters('the_content', $widget_text));
		echo $widget_text; // This does not allow shortcodes
	}

	public function form($instance) {
		?>
		<!-- Widget Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_text' ); ?>">Text to display:</label><br />
			<textarea class="homewidget-input" style="height: 300px;" name="<?php echo $this->get_field_name( 'widget_text' ); ?>"><?php if(!isset($instance['widget_text'])) echo "Enter text here..."; else echo $instance['widget_text']; ?></textarea>
		</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		// Processes widget options to be saved

		$instance = $old_instance;

		// Strip tags fromt itle and name to remove HTML
		$instance['widget_text'] = $new_instance['widget_text'];
		return $instance;
	}
}

/* Dashboard widget - Search post by id */
function register_search_post_by_id() {
	wp_add_dashboard_widget(
                 'search-post-by-id',         // Widget slug.
                 'Search Post By Id',         // Title.
                 'search_post_by_id_function' // Display function.
        );
}
add_action( 'wp_dashboard_setup', 'register_search_post_by_id' );
function search_post_by_id_function() {
	echo "Input an ID of a post";
	echo '<form id="searchpost" method="get" action="/wp-admin/post.php">
		<div class="search-box" style="height:50px;">
			<input type="search" name="post">
			<input type="hidden" name="action" value="edit">
			<input type="submit" name="" id="submit" class="button" value="Search by ID">
		</div>
		</form>';
	echo "Input name of a post";
	echo '<form id="posts-filter" action="/wp-admin/edit.php" method="get">
        <div class="search-box" style="height:50px;">
            <input type="search" name="s" value="">
            <input type="submit" name="" id="submit" class="button" value="Search by name"></p>
        </div>
        </form>';
}


/* REGISTER WIDGETS */
add_action('widgets_init', 'load_onescreen_widgets');
function load_onescreen_widgets()
{
	if ( is_admin() ) {
		wp_enqueue_style( 'custom-widgets-options', get_template_directory_uri() . '/widgets-options.css' );
		// wp_enqueue_script( 'jquery1.9', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js' );
		// wp_enqueue_script( 'custom-widgets-options-js', get_template_directory_uri() . '/js/widgets-options.js', array('jquery') );
	}
	register_widget('home_widget');
	register_widget('connect_with_onescreen');
	register_widget('about_onescreen');
	register_widget('filter_by_widget');
	register_widget('most_popular_posts');\
	register_widget('most_commented_posts');
	register_widget('custom_text');
}
?>