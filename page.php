<?php
/**
 * A static page.
 *
 * @package Garland
 */

get_header();
?>

<?php garland_page_title( single_post_title( '', false ) ); ?>

<?php get_template_part( 'template-parts/region', 'top' ); ?>

<div class="clearfix">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', 'page' );
	endwhile;
	?>
</div>

<?php
get_footer();
