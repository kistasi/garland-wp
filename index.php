<?php
/**
 * The main template: post listings (blog index, archives, search fallback).
 *
 * Corresponds to the {{ page.content }} area of page.html.twig.
 *
 * @package Garland
 */

get_header();
?>

<?php
/*
 * The listing's own title. The front page gets none -- Garland showed the
 * site name in the header there and nothing above the teasers.
 */
$garland_title = '';

if ( ! is_front_page() ) {
	if ( is_search() ) {
		$garland_title = sprintf(
			/* translators: %s: search query. */
			esc_html__( 'Search results for "%s"', 'garland' ),
			esc_html( get_search_query() )
		);
	} elseif ( is_home() ) {
		// The blog's own page title, or the site name when posts are not on a page.
		$garland_title = get_the_title( get_option( 'page_for_posts' ) );

		if ( '' === $garland_title ) {
			$garland_title = get_bloginfo( 'name', 'display' );
		}
	} else {
		$garland_title = get_the_archive_title();
	}
}

garland_page_title( $garland_title );
the_archive_description( '<div class="archive-description">', '</div>' );
?>

<?php get_template_part( 'template-parts/region', 'top' ); ?>

<div class="clearfix">
	<?php if ( have_posts() ) : ?>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		endwhile;
		?>

		<?php garland_pager(); ?>

	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</div>

<?php
get_footer();
