<?php
/**
 * The footer: closes #content and #center, prints the sidebars and closes
 * #container.
 *
 * Port of the bottom half of templates/page.html.twig. The sidebars are
 * siblings of #center inside #container, as the flexbox layout expects.
 *
 * @package Garland
 */

?>
		</div> <!-- /#content -->

		<?php if ( is_active_sidebar( 'footer' ) ) : ?>
			<div class="region region-footer">
				<?php dynamic_sidebar( 'footer' ); ?>
			</div>
		<?php endif; ?>

	</div> <!-- /#center -->

	<?php get_sidebar( 'first' ); ?>
	<?php get_sidebar( 'second' ); ?>

</div> <!-- /#container -->

<?php wp_footer(); ?>
</body>
</html>
