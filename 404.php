<?php
/**
 * The 404 page.
 *
 * @package Garland
 */

get_header();
?>

<div class="region region-title-tabs clearfix">
	<div class="block block-page-title-block">
		<h1 class="title"><?php esc_html_e( 'Page not found', 'garland' ); ?></h1>
	</div>
</div>

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
