<?php
/**
 * The header: everything up to and including the opening of #content.
 *
 * Port of the top half of templates/page.html.twig, plus the parts Drupal
 * generated from html.html.twig.
 *
 * @package Garland
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="skip-link">
	<a href="#main-content" class="visually-hidden focusable"><?php esc_html_e( 'Skip to main content', 'garland' ); ?></a>
</div>

<div id="header">

	<?php garland_branding(); ?>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<div class="region region-primary-menu">
			<nav role="navigation" aria-labelledby="primary-menu-heading">
				<h2 id="primary-menu-heading" class="visually-hidden"><?php esc_html_e( 'Primary menu', 'garland' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'links inline main-menu menu clearfix',
						'depth'          => 1,
					)
				);
				?>
			</nav>
		</div>
	<?php endif; ?>

	<?php if ( has_nav_menu( 'secondary' ) ) : ?>
		<div class="region region-secondary-menu">
			<nav role="navigation" aria-labelledby="secondary-menu-heading">
				<h2 id="secondary-menu-heading" class="visually-hidden"><?php esc_html_e( 'Secondary menu', 'garland' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'secondary',
						'container'      => false,
						'menu_class'     => 'links inline secondary-menu menu clearfix',
						'depth'          => 1,
					)
				);
				?>
			</nav>
		</div>
	<?php endif; ?>

	<?php
	/*
	 * The header region is printed last on purpose. The branding is taken out
	 * of flow by #logo-floater and the two menu regions are floated right, so
	 * any in-flow content placed before them would land on top of the logo and
	 * push the floats out of #header. See the header rules in css/wordpress.css.
	 */
	?>
	<?php if ( is_active_sidebar( 'header' ) ) : ?>
		<div class="region region-header clearfix">
			<?php dynamic_sidebar( 'header' ); ?>
		</div>
	<?php endif; ?>

</div> <!-- /#header -->

<div id="container" class="clearfix">

	<div id="center">

		<div id="breadcrumb">
			<div id="breadcrumb-inner">
				<div class="region region-breadcrumb">
					<?php garland_breadcrumb(); ?>
				</div>
			</div>
		</div>

		<div id="content">
