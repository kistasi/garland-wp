<?php
/**
 * A static page.
 *
 * @package Garland
 */

get_header();
?>

<div class="region region-title-tabs clearfix">
	<div class="block block-page-title-block">
		<h1 class="title"><?php the_title(); ?></h1>
	</div>
</div>

<?php get_template_part( 'template-parts/region', 'top' ); ?>

<a id="main-content"></a>

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
