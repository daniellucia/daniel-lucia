<?php

/**
 * daniel-lucia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package daniel-lucia
 */

if (!defined('_S_VERSION')) {
	define('_S_VERSION', '1.0.2');
}

define('NUMBER_SIDEBAR_WIDGETS', 3);

function daniel_lucia_setup()
{
	load_theme_textdomain('daniel-lucia', get_template_directory() . '/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'daniel-lucia'),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'daniel_lucia_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	add_theme_support('customize-selective-refresh-widgets');

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 88,
			'width'       => 36,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	/**
	 * Corregimos logo
	 */
	add_filter('get_custom_logo', function ($html) {
		$width = 88;
		$height = 36;

		return str_replace(
			'width="1" height="1"',
			'width="' . $width . '" height="' . $height . '"',
			$html
		);
	});
}
add_action('after_setup_theme', 'daniel_lucia_setup');


function daniel_lucia_content_width()
{
	$GLOBALS['content_width'] = apply_filters('daniel_lucia_content_width', 640);
}
add_action('after_setup_theme', 'daniel_lucia_content_width', 0);

function daniel_lucia_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'daniel-lucia'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'daniel-lucia'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('Home', 'daniel-lucia'),
			'id'            => 'home',
			'description'   => esc_html__('Add widgets here.', 'daniel-lucia'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('After Home', 'daniel-lucia'),
			'id'            => 'after-home',
			'description'   => esc_html__('Add widgets here.', 'daniel-lucia'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	for ($i = 1; $i <= (int)NUMBER_SIDEBAR_WIDGETS; $i++) {
		register_sidebar(
			array(
				'name'          => esc_html__('Footer #' . $i, 'daniel-lucia'),
				'id'            => 'footer-' . $i,
				'description'   => esc_html__('Add widgets here.', 'daniel-lucia'),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action('widgets_init', 'daniel_lucia_widgets_init');


function daniel_lucia_scripts()
{
	wp_enqueue_style('daniel-lucia-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('daniel-lucia-style', 'rtl', 'replace');

	wp_enqueue_style('daniel-lucia-fonts', get_template_directory_uri() . '/fonts/stylesheet.css', array(), _S_VERSION);
	wp_enqueue_style('daniel-lucia-home-widgets', get_template_directory_uri() . '/css/home-widgets.css', array(), _S_VERSION);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_register_script('daniellucia-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', array('jquery'), _S_VERSION);
	wp_register_script('daniellucia-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), _S_VERSION);
	wp_enqueue_script('daniellucia-woocommerce');
	wp_enqueue_script('daniellucia-functions');
}

add_action('wp_enqueue_scripts', 'daniel_lucia_scripts');

add_filter('woocommerce_checkout_fields', 'simple_virtual_checkout', 20, 1);
function simple_virtual_checkout($fields)
{
	$only_virtual_products = true;

	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		if (!$cart_item['data']->is_virtual())
			$only_virtual_products = false;
	}

	if ($only_virtual_products) {

		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_address_1']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_postcode']);
		unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_phone']);
		add_filter('woocommerce_enable_order_notes_field', '__return_false');

		unset($fields['shipping']['shipping_first_name']);
		unset($fields['shipping']['shipping_last_name']);
		unset($fields['shipping']['shipping_company']);
		unset($fields['shipping']['shipping_address_1']);
		unset($fields['shipping']['shipping_address_2']);
		unset($fields['shipping']['shipping_city']);
		unset($fields['shipping']['shipping_postcode']);
		unset($fields['shipping']['shipping_country']);
		unset($fields['shipping']['shipping_state']);
		unset($fields['shipping']['shipping_state']);

		// remove order notes
		unset($fields['order']['order_comments']);
	}
	return $fields;
}


/**
 * Formateamos titulos
 */
add_filter('get_the_archive_title', function ($title) {
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_author()) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	}
	return $title;
});

/**
 * Deshabilitamos Google Fonts en mailpoet
 */
add_filter('mailpoet_display_custom_fonts', function () {
	return false;
});

require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

//Widgets
require get_template_directory() . '/inc/widgets/hero-widget.php';
require get_template_directory() . '/inc/widgets/latest-products.php';


/**
 * Función para mostrar sidebar
 */
function is_show_sidebar(string $id = '')
{
	if ($id != '' && !is_active_sidebar($id)) {
		return false;
	}

	if (is_checkout() || is_cart() || is_account_page()) {
		return false;
	}

	return true;
}
