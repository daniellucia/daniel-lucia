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
				if ( function_exists( 'daniel_lucia_woocommerce_header_cart' ) ) {
					daniel_lucia_woocommerce_header_cart();
				}
			?>

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



