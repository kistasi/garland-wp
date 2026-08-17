<?php
/**
 * The 404 page.
 *
 * @package Garland
 */

get_header();
?>

<?php garland_page_title( __( 'Page not found', 'garland' ) ); ?>

<?php get_template_part( 'template-parts/region', 'top' ); ?>

<div class="clearfix">
	<div class="node">
		<div class="content clearfix">
			<p><?php esc_html_e( 'The requested page could not be found.', 'garland' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>
</div>

<?php
get_footer();
