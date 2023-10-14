<?php

/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package daniel-lucia
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function daniel_lucia_woocommerce_setup()
{
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'daniel_lucia_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function daniel_lucia_woocommerce_scripts()
{
	wp_enqueue_style('daniel-lucia-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION);
}
add_action('wp_enqueue_scripts', 'daniel_lucia_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function daniel_lucia_woocommerce_active_body_class($classes)
{
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter('body_class', 'daniel_lucia_woocommerce_active_body_class');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function daniel_lucia_woocommerce_related_products_args($args)
{
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args($defaults, $args);

	return $args;
}
add_filter('woocommerce_output_related_products_args', 'daniel_lucia_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('daniel_lucia_woocommerce_wrapper_before')) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function daniel_lucia_woocommerce_wrapper_before()
	{
?>
		<main id="primary" class="site-main">
		<?php
	}
}
add_action('woocommerce_before_main_content', 'daniel_lucia_woocommerce_wrapper_before');

if (!function_exists('daniel_lucia_woocommerce_wrapper_after')) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function daniel_lucia_woocommerce_wrapper_after()
	{
		?>
		</main><!-- #main -->
	<?php
	}
}
add_action('woocommerce_after_main_content', 'daniel_lucia_woocommerce_wrapper_after');

if (!function_exists('daniel_lucia_woocommerce_cart_link_fragment')) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function daniel_lucia_woocommerce_cart_link_fragment($fragments)
	{
		ob_start();
		daniel_lucia_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'daniel_lucia_woocommerce_cart_link_fragment');

if (!function_exists('daniel_lucia_woocommerce_cart_link')) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function daniel_lucia_woocommerce_cart_link()
	{
	?>
		<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'daniel-lucia'); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'daniel-lucia'),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span class="count"><?php echo esc_html($item_count_text); ?></span>
		</a>
	<?php
	}
}

if (!function_exists('daniel_lucia_woocommerce_header_cart')) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function daniel_lucia_woocommerce_header_cart()
	{
		if (is_cart()) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
	?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr($class); ?>">
				<?php daniel_lucia_woocommerce_cart_link(); ?>
			</li>
		</ul>
		<?php
	}
}


/**
 * Eliminamos breadcrumb woocommerce
 */
add_action('init', function () {
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
});

/**
 * Quitamos meta de la ficha de producto
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

/**
 * Movemos bloques
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('woocommerce_custom_after_content', 'woocommerce_output_product_data_tabs', 10);
add_action('woocommerce_custom_after_content', 'woocommerce_upsell_display', 15);
add_action('woocommerce_custom_after_content', 'woocommerce_output_related_products', 20);


/**
 * Plantilla para WooCommerce
 */
if (!function_exists('woocommerce_content')) {

	function woocommerce_content()
	{

		if (is_singular('product')) {

			while (have_posts()) :
				the_post();
				wc_get_template_part('content', 'single-product');
			endwhile;
		} else {
		?>

			<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>

				<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

			<?php endif; ?>

			<?php do_action('woocommerce_archive_description'); ?>

			<?php if (woocommerce_product_loop()) : ?>

				<?php do_action('woocommerce_before_shop_loop'); ?>

				<?php woocommerce_product_loop_start(); ?>

				<?php if (wc_get_loop_prop('total')) : ?>
					<?php while (have_posts()) : ?>
						<?php the_post(); ?>
						<?php wc_get_template_part('content', 'product'); ?>
					<?php endwhile; ?>
				<?php endif; ?>

				<?php woocommerce_product_loop_end(); ?>

				<?php do_action('woocommerce_after_shop_loop'); ?>

<?php
			else :
				do_action('woocommerce_no_products_found');
			endif;
		}
	}
}


/**
 * Quitamos todas las pestañas de la ficha de producto
 */
add_filter('woocommerce_product_tabs', function ($tabs) {
	return [];
}, 98);

/**
 * Sobrescribimos para dar estilo
 */

if (!function_exists('woocommerce_template_loop_product_title')) {
	function woocommerce_template_loop_product_title()
	{
		echo '<h3 class="' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '</h3>';
	}
}


/**
 * Mostramos gratis en vez de 0.00
 */
add_filter('woocommerce_get_price_html', 'custom_change_price_free', 9999, 2);
function custom_change_price_free($price, $product)
{
	if ($product->is_type('variable')) {
		$prices = $product->get_variation_prices(true);
		$min_price = current($prices['price']);

		if ($min_price === 0) {
			$max_price = end($prices['price']);
			$min_reg_price = current($prices['regular_price']);
			$max_reg_price = end($prices['regular_price']);

			if ($min_price !== $max_price) {
				$price = wc_format_price_range(__('Free', 'woocommerce'), $max_price) . $product->get_price_suffix();
			} elseif ($product->is_on_sale() && $min_reg_price === $max_reg_price) {
				$price = wc_format_sale_price(wc_price($max_reg_price), __('Free', 'woocommerce')) . $product->get_price_suffix();
			} else {
				$price = __('Free', 'woocommerce');
			}
		}
	} elseif ($product->get_price() == 0) {
		$price = '<span class="woocommerce-Price-amount amount">' . __('Free', 'woocommerce') . '</span>';
	}

	return $price;
}


/**
 * Quitamos volver a pedir
 */

remove_action('woocommerce_order_details_after_order_table', 'woocommerce_order_again_button');


/**
 * AJAX
 */

function daniellucia_ajax_add_to_cart_handler()
{
	WC_Form_Handler::add_to_cart_action();
	WC_AJAX::get_refreshed_fragments();
}
add_action('wc_ajax_ace_add_to_cart', 'daniellucia_ajax_add_to_cart_handler');
add_action('wc_ajax_nopriv_ace_add_to_cart', 'daniellucia_ajax_add_to_cart_handler');

// Remove WC Core add to cart handler to prevent double-add
remove_action('wp_loaded', array('WC_Form_Handler', 'add_to_cart_action'), 20);

function daniel_luciaajax_add_to_cart_add_fragments($fragments)
{
	$all_notices  = WC()->session->get('wc_notices', array());
	$notice_types = apply_filters('woocommerce_notice_types', array('error', 'success', 'notice'));

	ob_start();
	foreach ($notice_types as $notice_type) {
		if (wc_notice_count($notice_type) > 0) {
			wc_get_template("notices/{$notice_type}.php", array(
				'notices' => array_filter($all_notices[$notice_type]),
			));
		}
	}
	$fragments['notices_html'] = ob_get_clean();

	wc_clear_notices();

	return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'daniel_luciaajax_add_to_cart_add_fragments');


/**
 * Reemplazamos descripcion corta por descripción
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
add_action('woocommerce_single_product_summary', function () {
	echo the_content();
});

/**
 * Deshabilitar zoom imagenes
 */
add_action( 'wp', function() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}, 100 );