<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php the_custom_logo(); ?>
		</div>

		<nav id="site-navigation" class="main-navigation">
			<?php
			wp_nav_menu(
				[
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				]
			);
			?>
		</nav>
	</header>

	<?php 
	if (function_exists('bcn_display')) {
		echo '<div class="breadcrumbs">';
		bcn_display();
		echo '</div>';
	}
	?>
