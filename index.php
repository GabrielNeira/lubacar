<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 */

get_header(); ?>

<main id="primary" class="site-main container" style="margin-top: 40px; margin-bottom: 60px;">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	} else {
		// Fallback: If no posts are found, try to show the WooCommerce catalog manually
		if ( class_exists( 'WooCommerce' ) ) {
			echo '<h2 style="text-align:center; margin-bottom: 30px; text-transform: uppercase;">Nuestro Catálogo Actualizado</h2>';
			
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 12,
				'post_status' => 'publish'
			);
			$loop = new WP_Query( $args );

			if ( $loop->have_posts() ) {
				echo '<div class="woocommerce"><ul class="products">';
				while ( $loop->have_posts() ) : $loop->the_post();
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
					echo '<a href="' . esc_url( $permalink ) . '">' . $image_html . '</a>';
					echo '<h2 class="woocommerce-loop-product__title"><a href="' . esc_url( $permalink ) . '">' . esc_html( $title ) . '</a></h2>';
					if ( $price_html ) {
						echo '<span class="price">' . $price_html . '</span>';
					}
					echo '<a href="' . esc_url( $add_to_cart_url ) . '" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="' . esc_attr( $product_id ) . '" rel="nofollow">' . esc_html( $add_to_cart_text ) . '</a>';
					echo '</li>';
				endwhile;
				echo '</ul></div>';
			} else {
				echo '<p style="text-align:center;">Aún no hay productos publicados.</p>';
			}
			wp_reset_postdata();
		} else {
			echo '<p style="text-align:center; padding: 40px;">No content found</p>';
		}
	}
	?>
</main><!-- #primary -->

<?php
get_footer();
