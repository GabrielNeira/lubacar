<?php
/**
 * The Template for displaying all single products
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<main id="primary" class="site-main container" role="main" style="padding: 40px 20px;">

	<?php while ( have_posts() ) : the_post(); 
		global $product;
		if ( empty( $product ) ) {
			$product = wc_get_product( get_the_ID() );
		}
		if ( ! $product ) continue;
		
		$title = $product->get_title();
		$price_html = $product->get_price_html();
		$short_description = apply_filters( 'woocommerce_short_description', $product->get_short_description() );
		if ( ! $short_description ) {
			// Fallback to content if short description is empty
			$short_description = apply_filters( 'the_content', get_the_content() );
		}
		
		$add_to_cart_url = $product->add_to_cart_url();
		$add_to_cart_text = apply_filters( 'woocommerce_product_add_to_cart_text', __( 'Añadir a Cotización', 'woocommerce' ) );
	?>
		
		<div class="cf-single-product glass-panel">
			<div class="cf-single-product-image">
				<?php woocommerce_show_product_images(); ?>
			</div>
			
			<div class="cf-single-product-summary">
				<h1 class="product_title entry-title"><?php echo esc_html( $title ); ?></h1>
				
				<?php if ( $price_html ) : ?>
					<p class="price"><?php echo $price_html; ?></p>
				<?php endif; ?>
				
				<div class="woocommerce-product-details__short-description">
					<?php echo $short_description; ?>
				</div>
				
				<div class="cf-add-to-cart-container" style="margin-top: 30px;">
					<?php 
					// We use a direct form to ensure adding to cart works regardless of plugins
					if ( $product->is_type( 'simple' ) ) { ?>
						<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
							<div class="quantity">
								<input type="number" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off">
							</div>
							<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $add_to_cart_text ); ?></button>
						</form>
					<?php } else {
						// For variable products, rely on WooCommerce standard form hook
						woocommerce_template_single_add_to_cart(); 
					} ?>
				</div>
				
				<div class="product_meta" style="margin-top: 20px; font-size: 0.9em; color: var(--cf-text);">
					<?php do_action( 'woocommerce_product_meta_start' ); ?>
					<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
						<span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>
					<?php endif; ?>
					<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
					<?php do_action( 'woocommerce_product_meta_end' ); ?>
				</div>
				
			</div>
		</div>

	<?php endwhile; // end of the loop. ?>

</main><!-- #main -->

<?php
get_footer( 'shop' );
