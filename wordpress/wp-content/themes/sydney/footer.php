<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sydney
 */
?>
			</div>
		</div>
	</div><!-- #content -->

	<?php do_action('sydney_before_footer'); ?>

	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<?php get_sidebar('footer'); ?>
	<?php endif; ?>

    <!-- <a class="go-top"><i class="fa fa-angle-up"></i></a> -->

	<footer id="colophon" class="site-footer <?php footer_check(); ?>" role="contentinfo">
		<div class="site-info container">
			<span>Copyright © 2018 | <a href="mailto:jsdp3@alu.ua.es">Jesús Sánchez de Pablo</a> | Ingeniería Multimedia | Trabajo Fin de Grado UA | <a href="ayuda">Ayuda de uso de la página</a> </span>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

	<?php do_action('sydney_after_footer'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>



<!-- MIS FUNCIONES  -->
<?php
	function footer_check() {
		$url = $_SERVER["REQUEST_URI"];
		$url_index = "/wordpress/";

		if (strcmp($url, $url_index) !== 0) {
				echo 'down-position';
		}
		else{
			echo "";
		}
	}
?>


<!--  -->
