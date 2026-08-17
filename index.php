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

<?php if ( ! is_front_page() && ( is_home() || is_archive() || is_search() ) ) : ?>
	<div class="region region-title-tabs clearfix">
		<div class="block block-page-title-block">
			<h1 class="title">
				<?php
				if ( is_home() ) {
					echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) );
				} elseif ( is_search() ) {
					/* translators: %s: search query. */
					printf( esc_html__( 'Search results for "%s"', 'garland' ), esc_html( get_search_query() ) );
				} else {
					the_archive_title();
				}
				?>
			</h1>
		</div>
	</div>
	<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
<?php endif; ?>

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
