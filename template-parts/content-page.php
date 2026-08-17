<?php
/**
 * A static page.
 *
 * Same as content.php minus the submitted byline and the post links, which
 * Drupal's page content type also hid by default.
 *
 * @package Garland
 */

?>
<div id="node-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="content clearfix">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="field field-image"><?php the_post_thumbnail( 'large' ); ?></div>
		<?php endif; ?>

		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="node-pages">' . esc_html__( 'Pages:', 'garland' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<div class="clearfix">
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	</div>

</div>
