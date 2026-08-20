<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'carfran-v2' ); ?></a>

	<header id="masthead" class="site-header glass-panel">
		<div class="container header-top-area">
			<div class="site-branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-logo">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-lubacar.png" alt="LubaCar - Productos Automotrices" width="690" height="198">
				</a>
			</div><!-- .site-branding -->

			<button type="button" id="mobile-menu-toggle" class="mobile-menu-toggle" aria-expanded="false" aria-controls="site-navigation" aria-label="Abrir menú">
				<span></span><span></span><span></span>
			</button>

			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<div class="header-search">
				<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" id="woocommerce-product-search-field-0" class="search-field" placeholder="Buscar productos..." value="<?php echo get_search_query(); ?>" name="s" />
					<input type="hidden" name="post_type" value="product" />
					<button type="submit" value="Buscar"><i class="fa fa-search"></i></button>
				</form>
			</div>

			<div class="header-cart">
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-link" title="Ver Cotización">
					<i class="fa fa-shopping-cart"></i>
					<span class="cart-label">Cotización</span>
					<span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
				</a>
			</div>
			<?php endif; ?>
		</div>

		<div class="header-nav-area">
			<nav id="site-navigation" class="main-navigation container">
				<?php
				// Fallback to WooCommerce categories if no menu is assigned
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
					) );
				} else {
					echo '<ul id="primary-menu" class="menu">';
					if ( class_exists('WooCommerce') ) {
						$categories = get_terms( 'product_cat', array('orderby' => 'name', 'hide_empty' => true, 'number' => 8) );
						foreach($categories as $cat) {
							echo '<li><a href="'.get_term_link($cat).'">'.esc_html($cat->name).'</a></li>';
						}
					} else {
						wp_list_pages( array('title_li' => '') );
					}
					echo '</ul>';
				}
				?>
			</nav>
		</div>
	</header><!-- #masthead -->

	<script>
	(function () {
		var toggle = document.getElementById( 'mobile-menu-toggle' );
		var navArea = document.querySelector( '.header-nav-area' );
		if ( ! toggle || ! navArea ) {
			return;
		}
		toggle.addEventListener( 'click', function () {
			var isOpen = navArea.classList.toggle( 'nav-open' );
			toggle.classList.toggle( 'is-active', isOpen );
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );
	})();
	</script>
