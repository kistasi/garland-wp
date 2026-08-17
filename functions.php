<?php
/**
 * Garland theme functions and definitions.
 *
 * WordPress port of the Drupal Garland theme. The Drupal hooks map over as:
 *
 *   garland.info.yml regions   -> nav menus + widget areas
 *   garland_preprocess_html()  -> garland_body_classes()
 *   theme-settings.php         -> Customizer (Garland Options panel)
 *   color/color.inc            -> Customizer color schemes (inc/color-schemes.php)
 *
 * @package Garland
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GARLAND_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/color-schemes.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Theme setup.
 */
function garland_setup() {
	load_theme_textdomain( 'garland', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 89,
			'width'       => 89,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Garland's "Primary menu" and "Secondary menu" regions.
	register_nav_menus(
		array(
			'primary'   => __( 'Primary menu', 'garland' ),
			'secondary' => __( 'Secondary menu', 'garland' ),
		)
	);

	if ( ! isset( $GLOBALS['content_width'] ) ) {
		$GLOBALS['content_width'] = 640;
	}
}
add_action( 'after_setup_theme', 'garland_setup' );

/**
 * Register the widget areas that stand in for Garland's block regions.
 */
function garland_widgets_init() {
	$regions = array(
		'header'         => __( 'Header', 'garland' ),
		'highlighted'    => __( 'Highlighted', 'garland' ),
		'help'           => __( 'Help', 'garland' ),
		'sidebar-first'  => __( 'Sidebar first', 'garland' ),
		'sidebar-second' => __( 'Sidebar second', 'garland' ),
		'footer'         => __( 'Footer', 'garland' ),
	);

	foreach ( $regions as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				/* translators: %s: region name. */
				'description'   => sprintf( __( 'Widgets in the %s region.', 'garland' ), $name ),
				'before_widget' => '<div id="%1$s" class="block %2$s clearfix">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'garland_widgets_init' );

/**
 * Enqueue styles and scripts.
 *
 * Mirrors garland.libraries.yml: layout, then theme colors, then general
 * styling, then the print stylesheet.
 */
function garland_scripts() {
	wp_enqueue_style( 'garland-layout', get_theme_file_uri( 'css/layout.css' ), array(), GARLAND_VERSION );
	wp_enqueue_style( 'garland-colors', get_theme_file_uri( 'css/colors.css' ), array( 'garland-layout' ), GARLAND_VERSION );
	wp_enqueue_style( 'garland-general', get_theme_file_uri( 'css/garland.css' ), array( 'garland-colors' ), GARLAND_VERSION );
	wp_enqueue_style( 'garland-wordpress', get_theme_file_uri( 'css/wordpress.css' ), array( 'garland-general' ), GARLAND_VERSION );
	wp_enqueue_style( 'garland-print', get_theme_file_uri( 'css/print.css' ), array( 'garland-general' ), GARLAND_VERSION, 'print' );

	if ( is_rtl() ) {
		wp_enqueue_style( 'garland-rtl', get_theme_file_uri( 'css/style-rtl.css' ), array( 'garland-wordpress' ), GARLAND_VERSION );
	}

	// style.css carries the theme header; enqueued so child themes can depend on it.
	wp_enqueue_style( 'garland-style', get_stylesheet_uri(), array( 'garland-wordpress' ), GARLAND_VERSION );

	// Customizer-driven overrides: fixed/fluid width and the colour scheme.
	wp_add_inline_style( 'garland-style', garland_dynamic_css() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'garland_scripts' );

/**
 * Body classes.
 *
 * Port of garland_preprocess_html(): width toggle plus the sidebar-count
 * classes the layout and print stylesheets key off.
 */
function garland_body_classes( $classes ) {
	$classes[] = ( 'fixed' === garland_get_option( 'garland_width' ) ) ? 'fixed-width' : 'fluid-width';

	$first  = is_active_sidebar( 'sidebar-first' );
	$second = is_active_sidebar( 'sidebar-second' );

	if ( $first && $second ) {
		$classes[] = 'layout-two-sidebars';
	} elseif ( $first ) {
		$classes[] = 'layout-one-sidebar';
		$classes[] = 'sidebar-first';
	} elseif ( $second ) {
		$classes[] = 'layout-one-sidebar';
		$classes[] = 'sidebar-second';
	} else {
		$classes[] = 'layout-no-sidebars';
	}

	if ( is_singular() ) {
		$classes[] = 'page-node';
	}

	return $classes;
}
add_filter( 'body_class', 'garland_body_classes' );

/**
 * Post classes: Drupal's node classes, so the ported CSS applies unchanged.
 */
function garland_post_classes( $classes, $css_class, $post_id ) {
	$classes[] = 'node';
	$classes[] = 'node-' . get_post_type( $post_id );
	$classes[] = is_singular() ? 'view-mode-full' : 'view-mode-teaser';

	if ( is_sticky( $post_id ) && ! is_singular() ) {
		$classes[] = 'node-sticky';
	}

	return $classes;
}
add_filter( 'post_class', 'garland_post_classes', 10, 3 );

/**
 * Comment classes: add Garland's zebra striping.
 */
function garland_comment_classes( $classes ) {
	static $count = 0;

	$classes[] = ( $count % 2 ) ? 'odd' : 'even';
	$count++;

	return $classes;
}
add_filter( 'comment_class', 'garland_comment_classes' );

/**
 * Read a theme option, falling back to the theme default.
 */
function garland_get_option( $name ) {
	$defaults = array(
		'garland_width'        => 'fluid',
		'garland_color_scheme' => 'default',
	);

	$default = isset( $defaults[ $name ] ) ? $defaults[ $name ] : '';

	return get_theme_mod( $name, $default );
}

/**
 * Build the inline CSS for the width toggle and the active colour scheme.
 */
function garland_dynamic_css() {
	$css = '';

	if ( 'fixed' === garland_get_option( 'garland_width' ) ) {
		$css .= "#header, #container { max-width: 960px; margin-left: auto; margin-right: auto; }\n";
	}

	$css .= garland_color_scheme_css( garland_get_option( 'garland_color_scheme' ) );

	return $css;
}

/**
 * Excerpt tweaks: Garland's teaser read-more link.
 */
function garland_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'garland_excerpt_more' );

/**
 * Give the search form Garland's markup hooks.
 */
function garland_search_form_class( $form ) {
	return str_replace( '<form ', '<form class="search-form" ', $form );
}
add_filter( 'get_search_form', 'garland_search_form_class' );
