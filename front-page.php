<?php
/**
 * Corporate Front Page Template
 */

get_header(); ?>

<main id="primary" class="site-main corporate-home">

	<!-- Hero Section -->
	<section class="b2b-hero" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-banner.jpg');">
		<div class="container hero-content">
			<h1>Distribuidor Oficial de Lubricantes <span class="highlight-goodyear">Goodyear</span></h1>
			<p>Abastecemos a empresas, talleres y sub-distribuidores a lo largo de todo Chile con el más amplio catálogo de productos automotrices de clase mundial.</p>
			<div class="hero-actions">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary">Cotizar Ahora</a>
				<a href="#marcas" class="btn-secondary">Nuestras Marcas</a>
			</div>
		</div>
	</section>

	<!-- Trust Features -->
	<section class="b2b-features container">
		<div class="feature-box glass-panel">
			<i class="fas fa-truck-fast"></i>
			<h3>Despacho Nacional</h3>
			<p>Logística eficiente para asegurar que tu inventario nunca se detenga.</p>
		</div>
		<div class="feature-box glass-panel">
			<i class="fas fa-certificate"></i>
			<h3>100% Originales</h3>
			<p>Garantía directa de fábrica en todos nuestros lubricantes y aditivos.</p>
		</div>
		<div class="feature-box glass-panel">
			<i class="fas fa-headset"></i>
			<h3>Asesoría B2B</h3>
			<p>Atención personalizada para talleres y grandes flotas.</p>
		</div>
	</section>

	<!-- Brands Section -->
	<section id="marcas" class="b2b-brands">
		<div class="container">
			<h2>Nuestras Marcas Aliadas</h2>
			<div class="brands-grid">
				<div class="brand-item featured-brand">
					<!-- Goodyear Logo placeholder (CSS styled or text for now) -->
					<h3 style="color:#005A9B; font-size: 2.5rem; font-weight:900; font-family:'Arial Black', sans-serif; margin:0;">GOOD<span style="color:#FFB81C;">YEAR</span></h3>
				</div>
				<div class="brand-item"><h3>MOTUL</h3></div>
				<div class="brand-item"><h3>VISTONY</h3></div>
				<div class="brand-item"><h3>LITTLE TREES</h3></div>
			</div>
		</div>
	</section>

	<!-- Catalog Call to Action -->
	<section class="b2b-catalog container">
		<h2 style="text-align: center; margin-bottom: 40px;">Explora Nuestro Catálogo</h2>
		<?php echo do_shortcode('[product_categories number="4" columns="4" hide_empty="0"]'); ?>
		
		<div style="text-align: center; margin-top: 50px;">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary" style="padding: 15px 40px; font-size: 1.2rem;">Ver Todos los Productos</a>
		</div>
	</section>

</main>

<?php get_footer();
