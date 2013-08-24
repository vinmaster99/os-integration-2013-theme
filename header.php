<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title('', true, 'right'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
		<?php register_jquery(); ?>
		<?php wp_head(); // Extra wordpress head?>
	</head>
	<body>
		<div id="header" class="container">
			<div class="navbar">
				<a href="#" class="brand"><img alt="OneScreen Logo" src="http://www.onescreen.com/wp-content/themes/NewOneScreen/images/onescreen_logo.png"></a>
				<?php wp_nav_menu( array('menu' => 'Header Navigation', 'container' => 'false', 'menu_class' => 'nav pull-right')); ?>
			</div>
		</div>