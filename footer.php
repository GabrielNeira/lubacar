	<footer id="colophon" class="site-footer">
		<div class="container footer-grid">
			<div class="footer-column footer-brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo" style="display:inline-block; margin-bottom:20px;">
					<div class="lubacar-logo" style="transform: scale(0.8); transform-origin: left;">
						<div class="checkered-flag"></div>
						<div class="logo-text">
							<span class="lubacar">LUBACAR</span>
							<span class="subtext">PRODUCTOS AUTOMOTRICES</span>
						</div>
					</div>
				</a>
				<p>Distribuidor Oficial de Lubricantes Goodyear. Somos especialistas en abastecimiento B2B para talleres, industrias y flotas a lo largo de todo Chile.</p>
			</div>

			<div class="footer-column footer-categories">
				<h3>Nuestras Categorías</h3>
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu', 'container' => false ) );
				} else {
					echo '<ul id="footer-menu" class="menu">';
					if ( class_exists('WooCommerce') ) {
						$categories = get_terms( 'product_cat', array('orderby' => 'name', 'hide_empty' => true, 'number' => 6) );
						foreach($categories as $cat) {
							echo '<li><a href="'.get_term_link($cat).'">'.esc_html($cat->name).'</a></li>';
						}
					}
					echo '</ul>';
				}
				?>
			</div>

			<div class="footer-column footer-contact">
				<h3>Contáctanos</h3>
				<ul class="contact-list">
					<li><i class="fas fa-phone"></i> <span>+56 9 3392 1690</span></li>
					<li><i class="fab fa-whatsapp"></i> <span>+56 9 3392 1690</span></li>
					<li><i class="fas fa-envelope"></i> <span>ventas@lubacar.cl</span></li>
					<li><i class="fas fa-map-marker-alt"></i> <span>Av. América 0224, San Bernardo</span></li>
					<li><i class="fab fa-instagram"></i> <span><a href="https://www.instagram.com/lubacarspa?igsh=dmNwcDBuaWZrNTls" target="_blank" rel="noopener noreferrer">@lubacarspa</a></span></li>
				</ul>
			</div>
		</div>

		<div class="site-info">
			<div class="container">
				<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos los derechos reservados para cotizaciones online.</p>
			</div>
		</div>
	</footer><!-- #colophon -->

	<!-- Floating WhatsApp Widget -->
	<a href="https://wa.me/56933921690" class="floating-whatsapp" target="_blank" rel="noopener noreferrer" title="Contáctanos por WhatsApp">
		<i class="fab fa-whatsapp"></i>
	</a>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
