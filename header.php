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

<?php
/*
 * #header carries the gradient and spans the window; .header-inner is the
 * part that lines up with the content below it, and in "fixed width" mode it
 * is the element the max width applies to. See css/layout.css.
 */
?>
<div id="header">
	<div class="header-inner">

		<?php garland_branding(); ?>

		<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'secondary' ) ) : ?>
			<div class="header-menus">

				<?php if ( has_nav_menu( 'primary' ) ) : ?>
					<div class="region region-primary-menu">
						<nav role="navigation" aria-labelledby="primary-menu-heading">
							<h2 id="primary-menu-heading" class="visually-hidden"><?php esc_html_e( 'Primary menu', 'garland' ); ?></h2>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'container'      => false,
									'menu_class'     => 'links inline main-menu menu',
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
									'menu_class'     => 'links inline secondary-menu menu',
									'depth'          => 1,
								)
							);
							?>
						</nav>
					</div>
				<?php endif; ?>

			</div> <!-- /.header-menus -->
		<?php endif; ?>

		<?php
		/*
		 * .header-inner is a flex row that wraps: branding and .header-menus share
		 * the first line, and this region takes the full width of the next one.
		 */
		?>
		<?php if ( is_active_sidebar( 'header' ) ) : ?>
			<div class="region region-header">
				<?php dynamic_sidebar( 'header' ); ?>
			</div>
		<?php endif; ?>

	</div> <!-- /.header-inner -->
</div> <!-- /#header -->

<div id="container" class="clearfix">

	<div id="center">

		<?php
		/*
		 * The breadcrumb bar laps up onto the header; it is drawn only when
		 * there is a trail to put in it. One element does it: the gradient
		 * runs in from both ends in a single multi-stop linear-gradient, so
		 * the inner wrapper the Drupal theme needed is gone.
		 */
		$garland_breadcrumb = garland_get_breadcrumb();
		?>
		<?php if ( $garland_breadcrumb ) : ?>
			<div id="breadcrumb">
				<div class="region region-breadcrumb">
					<?php echo $garland_breadcrumb; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		<?php endif; ?>

		<div id="content">
