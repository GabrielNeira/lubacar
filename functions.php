<?php
/**
 * Carfran V2 Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme Setup
 */
function carfran_v2_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Register Menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'carfran-v2' ),
			'footer'  => esc_html__( 'Footer Menu', 'carfran-v2' ),
		)
	);

	// Add theme support for Custom Logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 320,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// HTML5 markup support
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

	// WooCommerce Support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'carfran_v2_setup' );

/**
 * Enqueue scripts and styles.
 */
function carfran_v2_scripts() {
	// Enqueue Google Fonts
	wp_enqueue_style( 'carfran-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap', array(), null );

	// Enqueue FontAwesome (for icons, if needed)
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

	// Enqueue Main Stylesheet
	wp_enqueue_style( 'carfran-v2-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'carfran_v2_scripts' );

/**
 * WooCommerce Overrides & Tweaks
 */

// Remove default WooCommerce wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Add custom wrapper
add_action( 'woocommerce_before_main_content', 'carfran_v2_wrapper_start', 10 );
function carfran_v2_wrapper_start() {
	echo '<main id="primary" class="site-main container" role="main">';
}

add_action( 'woocommerce_after_main_content', 'carfran_v2_wrapper_end', 10 );
function carfran_v2_wrapper_end() {
	echo '</main>';
}

/**
 * Quotation Cart Text Replacements
 */
add_filter( 'woocommerce_product_single_add_to_cart_text', 'carfran_custom_cart_button_text' );
add_filter( 'woocommerce_product_add_to_cart_text', 'carfran_custom_cart_button_text' );
function carfran_custom_cart_button_text() {
	return __( 'Añadir a Cotización', 'woocommerce' );
}

add_filter( 'woocommerce_order_button_text', 'carfran_custom_order_button_text' );
function carfran_custom_order_button_text() {
	return __( 'Enviar Cotización', 'woocommerce' );
}

add_filter( 'gettext', 'carfran_translate_woocommerce_strings', 999, 3 );
function carfran_translate_woocommerce_strings( $translated, $text, $domain ) {
	if ( ! is_admin() && 'woocommerce' === $domain ) {
		switch ( $translated ) {
			case 'View cart':
			case 'Ver carrito':
				$translated = 'Ver Cotización';
				break;
			case 'Cart':
			case 'Carrito':
				$translated = 'Cotización';
				break;
			case 'Checkout':
			case 'Finalizar compra':
				$translated = 'Procesar Cotización';
				break;
			case 'Your cart is currently empty.':
			case 'Your cart is currently empty!':
			case 'Tu carrito está actualmente vacío.':
				$translated = 'Tu carro de cotización está vacío actualmente.';
				break;
		}
	}
	return $translated;
}

/**
 * Force products without prices to be purchasable (for Quotations)
 */
add_filter( 'woocommerce_is_purchasable', '__return_true' );

/**
 * Automatically set cart item price to 0 if it's empty to prevent cart errors
 */
add_action( 'woocommerce_before_calculate_totals', 'carfran_set_empty_price_to_zero', 10, 1 );
function carfran_set_empty_price_to_zero( $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
	foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
		if ( '' === $cart_item['data']->get_price() ) {
			$cart_item['data']->set_price( 0 );
		}
	}
}

/**
 * Auto-recover missing WooCommerce Cart and Checkout pages
 */
add_action( 'init', 'carfran_auto_create_cart_page' );
function carfran_auto_create_cart_page() {
    if ( class_exists( 'WooCommerce' ) ) {
        $cart_page_id = get_option( 'woocommerce_cart_page_id' );
        if ( ! $cart_page_id || get_post_status( $cart_page_id ) !== 'publish' ) {
            $cart_page = get_page_by_path( 'carrito' );
            if ( ! $cart_page ) $cart_page = get_page_by_path( 'cart' );
            if ( ! $cart_page ) {
                $cart_page_id = wp_insert_post( array(
                    'post_title'     => 'Carrito de Cotización',
                    'post_name'      => 'carrito',
                    'post_content'   => '[woocommerce_cart]',
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                ) );
            } else {
                $cart_page_id = $cart_page->ID;
            }
            update_option( 'woocommerce_cart_page_id', $cart_page_id );
        }
        
        $checkout_page_id = get_option( 'woocommerce_checkout_page_id' );
        if ( ! $checkout_page_id || get_post_status( $checkout_page_id ) !== 'publish' ) {
            $checkout_page = get_page_by_path( 'finalizar-compra' );
            if ( ! $checkout_page ) $checkout_page = get_page_by_path( 'checkout' );
            if ( ! $checkout_page ) {
                $checkout_page_id = wp_insert_post( array(
                    'post_title'     => 'Finalizar Cotización',
                    'post_name'      => 'finalizar-compra',
                    'post_content'   => '[woocommerce_checkout]',
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                ) );
            } else {
                $checkout_page_id = $checkout_page->ID;
            }
            update_option( 'woocommerce_checkout_page_id', $checkout_page_id );
        }
    }
}

