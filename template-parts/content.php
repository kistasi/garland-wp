<?php
/**
 * A single post in a listing or on its own page.
 *
 * Port of templates/node.html.twig. post_class() supplies the node classes via
 * garland_post_classes().
 *
 * @package Garland
 */

?>
<div id="node-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! is_singular() ) : ?>
		<h2 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php endif; ?>

	<?php garland_submitted(); ?>

	<div class="content clearfix">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="field field-image">
				<?php the_post_thumbnail( is_singular() ? 'large' : 'medium' ); ?>
			</div>
		<?php endif; ?>

		<?php
		if ( is_singular() ) {
			the_content();
			wp_link_pages(
				array(
					'before' => '<div class="node-pages">' . esc_html__( 'Pages:', 'garland' ),
					'after'  => '</div>',
				)
			);
		} else {
			the_excerpt();
		}
		?>
	</div>

	<div class="clearfix">
		<?php garland_entry_links(); ?>

		<?php
		if ( is_singular() && ( comments_open() || get_comments_number() ) ) {
			comments_template();
		}
		?>
	</div>

</div>
