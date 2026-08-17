<?php
/**
 * A single post.
 *
 * The title is printed by the page-title block, as Drupal's page_title_block
 * did in the title_tabs region, so node.html.twig's title is suppressed.
 *
 * @package Garland
 */

get_header();
?>

<?php
// single_post_title() reads the queried object, so it is safe before the loop.
garland_page_title( single_post_title( '', false ) );
?>

<?php get_template_part( 'template-parts/region', 'top' ); ?>

<div class="clearfix">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', get_post_type() );
	endwhile;
	?>

	<?php
	the_post_navigation(
		array(
			'prev_text' => '<span class="nav-previous">&laquo; %title</span>',
			'next_text' => '<span class="nav-next">%title &raquo;</span>',
			'class'     => 'links inline node-navigation',
		)
	);
	?>
</div>

<?php
get_footer();
