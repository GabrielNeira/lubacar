<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<header class="woocommerce-products-header glass-panel" style="padding: 30px; margin-bottom: 40px; text-align: center;">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php

	do_action( 'woocommerce_before_shop_loop' );

	echo '<div class="woocommerce"><ul class="products">';
	
	// Robust manual query for the current category
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 24,
		'post_status' => 'publish',
	);
	
	$queried_object = get_queried_object();
	if ( is_product_category() && $queried_object ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $queried_object->term_id,
			),
		);
	}

	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) {
			$loop->the_post();
			
			$product_id = get_the_ID();
			$product = wc_get_product( $product_id );
			if ( ! $product ) continue;
			
			$image_html = $product->get_image( 'large' ); 
			$title = $product->get_title();
			$price_html = $product->get_price_html();
			$permalink = $product->get_permalink();
			$add_to_cart_url = $product->add_to_cart_url();
			$add_to_cart_text = apply_filters( 'woocommerce_product_add_to_cart_text', __( 'Añadir a Cotización', 'woocommerce' ) );
			
			echo '<li class="product">';
			echo '<a href="' . esc_url( $permalink ) . '" class="product-image-link">' . $image_html . '</a>';
			echo '<h2 class="woocommerce-loop-product__title"><a href="' . esc_url( $permalink ) . '">' . esc_html( $title ) . '</a></h2>';
			if ( $price_html ) {
				echo '<span class="price">' . $price_html . '</span>';
			}
			echo '<a href="' . esc_url( $add_to_cart_url ) . '" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="' . esc_attr( $product_id ) . '" rel="nofollow">' . esc_html( $add_to_cart_text ) . '</a>';
			echo '</li>';
		}
	} else {
		echo '<p style="text-align:center; width: 100%;">No hay productos en esta categoría.</p>';
	}
	wp_reset_postdata();

	echo '</ul></div>';

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
