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

<?php if (!is_checkout() && !is_cart()): ?>
	<div class="site-header-container">
		<header id="masthead" class="site-header">
			<div class="site-branding">
				<?php the_custom_logo(); ?>
			</div>

			<?php get_search_form(); ?>

			<input type="checkbox" id="menu-toggle" />
			<div class="menu-container">
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

				<?php

				if ((bool)get_theme_mod('active_shop')) {
					if ( function_exists( 'daniel_lucia_woocommerce_header_cart' ) ) {
						daniel_lucia_woocommerce_header_cart();
					}
				}

				?>

				<?php if ((bool)get_theme_mod('active_shop')): ?>
				
				<div class="my-account-link">
					<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/iconos/user.svg" alt="<?php echo __('My account', 'daniel-lucia'); ?>" height="32" width="32"/>
					</a>
				</div>

				<?php endif; ?>

			</div>

			<div class="menu-link">
				<label for="menu-toggle">
					<span></span>
					<span></span>
					<span></span>
				</label>
			</div>

		</header>
	</div>
<?php endif; ?>

<div id="page" class="site">

	<?php if (function_exists('bcn_display') && !is_front_page() && !is_checkout() && !is_cart()): ?>
		<div class="breadcrumbs">
			<?php bcn_display(); ?>
		</div>
	<?php endif; ?>

	<?php if (is_checkout() || is_cart()): ?>
	<div class="button-back">
		<a class="button button-link" href="<?php echo get_home_url(); ?>"><?php echo __('Back to web', 'daniel-lucia'); ?></a>
	</div>
	<?php endif; ?>



