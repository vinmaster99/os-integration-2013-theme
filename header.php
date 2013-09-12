<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title('', true, 'right'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="http://www.onescreen.com/wp-content/themes/NewOneScreen/images/favicon.ico">
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
		<?php register_jquery(); ?>
		<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<!--
		<link href="<?php echo get_bloginfo("template_directory").'/os-bootstrap.css'; ?>" rel="stylesheet">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		-->
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
		
		<?php wp_head(); // Extra wordpress head?>
	</head>
	<body>
		<div class="os-page-topper"></div>
		<div id="header" class="container">
			<div class="navbar">
				<a href="<?php echo home_url(); ?>" class="brand"><img alt="OneScreen Logo" src="http://www.onescreen.com/assets/onescreen_logo.png"></a>
				<?php wp_nav_menu( array('menu' => 'Header Navigation', 'container' => 'false', 'menu_class' => 'nav pull-right')); ?>
				<div id="menu-header-navigation-dropdown">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<div class="nav-collapse" style="height: 0px;">
						<?php wp_nav_menu( array('menu' => 'Header Navigation', 'container' => 'false', 'menu_class' => 'nav')); ?>
					</div>
				</div>
			</div>
		</div>