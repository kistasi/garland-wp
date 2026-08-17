<?php
/**
 * Garland colour schemes.
 *
 * Port of the Drupal theme's color/color.inc. Drupal's Color module recoloured
 * the theme by regenerating images and rewriting stylesheets on save. WordPress
 * has no equivalent, and this port has no images to regenerate: the schemes are
 * kept as data here and applied by re-declaring the design tokens that
 * css/colors.css sets up. The derived tints are computed the same way Drupal's
 * blend did, by mixing the base colour toward the blend target (white).
 *
 * @package Garland
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * All colour schemes from color/color.inc.
 *
 * Schemes that omitted a key in Drupal inherit it from the default scheme.
 */
function garland_color_schemes() {
	$schemes = array(
		'default'       => array(
			'title'  => __( 'Blue Lagoon (Default)', 'garland' ),
			'colors' => array(
				'base'   => '#0072b9',
				'link'   => '#027ac6',
				'top'    => '#2385c2',
				'bottom' => '#5ab5ee',
				'text'   => '#494949',
			),
		),
		'ash'           => array(
			'title'  => __( 'Ash', 'garland' ),
			'colors' => array(
				'base'   => '#464849',
				'link'   => '#2f416f',
				'top'    => '#2a2b2d',
				'bottom' => '#5d6779',
			),
		),
		'aquamarine'    => array(
			'title'  => __( 'Aquamarine', 'garland' ),
			'colors' => array(
				'base'   => '#55c0e2',
				'link'   => '#000000',
				'text'   => '#696969',
				'top'    => '#085360',
				'bottom' => '#007e94',
			),
		),
		'chocolate'     => array(
			'title'  => __( 'Belgian Chocolate', 'garland' ),
			'colors' => array(
				'base'   => '#d5b048',
				'link'   => '#6c420e',
				'top'    => '#331900',
				'bottom' => '#971702',
			),
		),
		'bluemarine'    => array(
			'title'  => __( 'Bluemarine', 'garland' ),
			'colors' => array(
				'base'   => '#3f3f3f',
				'link'   => '#336699',
				'text'   => '#000000',
				'top'    => '#6598cb',
				'bottom' => '#6598cb',
			),
		),
		'citrus'        => array(
			'title'  => __( 'Citrus Blast', 'garland' ),
			'colors' => array(
				'base'   => '#d0cb9a',
				'link'   => '#917803',
				'top'    => '#efde01',
				'bottom' => '#e6fb2d',
			),
		),
		'cold'          => array(
			'title'  => __( 'Cold Day', 'garland' ),
			'colors' => array(
				'base'   => '#0f005c',
				'link'   => '#434f8c',
				'text'   => '#000000',
				'top'    => '#4d91ff',
				'bottom' => '#1a1575',
			),
		),
		'greenbeam'     => array(
			'title'  => __( 'Greenbeam', 'garland' ),
			'colors' => array(
				'base'   => '#c9c497',
				'link'   => '#0c7a00',
				'top'    => '#03961e',
				'bottom' => '#7be000',
			),
		),
		'mediterrano'   => array(
			'title'  => __( 'Mediterrano', 'garland' ),
			'colors' => array(
				'base'   => '#ffe23d',
				'link'   => '#a9290a',
				'top'    => '#fc6d1d',
				'bottom' => '#a30f42',
			),
		),
		'mercury'       => array(
			'title'  => __( 'Mercury', 'garland' ),
			'colors' => array(
				'base'   => '#788597',
				'link'   => '#3f728d',
				'top'    => '#a9adbc',
				'bottom' => '#d4d4d4',
				'text'   => '#707070',
			),
		),
		'nocturnal'     => array(
			'title'  => __( 'Nocturnal', 'garland' ),
			'colors' => array(
				'base'   => '#5b5fa9',
				'link'   => '#5b5faa',
				'top'    => '#0a2352',
				'bottom' => '#9fa8d5',
			),
		),
		'olivia'        => array(
			'title'  => __( 'Olivia', 'garland' ),
			'colors' => array(
				'base'   => '#7db323',
				'link'   => '#6a9915',
				'top'    => '#b5d52a',
				'bottom' => '#7db323',
				'text'   => '#191a19',
			),
		),
		'pink_plastic'  => array(
			'title'  => __( 'Pink Plastic', 'garland' ),
			'colors' => array(
				'base'   => '#12020b',
				'link'   => '#1b1a13',
				'top'    => '#f391c6',
				'bottom' => '#f41063',
				'text'   => '#898080',
			),
		),
		'shiny_tomato'  => array(
			'title'  => __( 'Shiny Tomato', 'garland' ),
			'colors' => array(
				'base'   => '#b7a0ba',
				'link'   => '#c70000',
				'top'    => '#a1443a',
				'bottom' => '#f21107',
				'text'   => '#515d52',
			),
		),
		'teal_top'      => array(
			'title'  => __( 'Teal Top', 'garland' ),
			'colors' => array(
				'base'   => '#18583d',
				'link'   => '#1b5f42',
				'top'    => '#34775a',
				'bottom' => '#52bf90',
				'text'   => '#2d2d2d',
			),
		),
	);

	$defaults = $schemes['default']['colors'];

	foreach ( $schemes as $key => $scheme ) {
		$schemes[ $key ]['colors'] = array_merge( $defaults, $scheme['colors'] );
	}

	return $schemes;
}

/**
 * Convert a hex colour to an array of RGB components.
 */
function garland_hex_to_rgb( $hex ) {
	$hex = ltrim( (string) $hex, '#' );

	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	if ( ! preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
		$hex = '000000';
	}

	return array(
		hexdec( substr( $hex, 0, 2 ) ),
		hexdec( substr( $hex, 2, 2 ) ),
		hexdec( substr( $hex, 4, 2 ) ),
	);
}

/**
 * Mix a colour toward white, the way Drupal's colour blending did.
 *
 * @param string $hex    Colour to blend.
 * @param float  $amount 0 = untouched, 1 = white.
 */
function garland_tint( $hex, $amount ) {
	list( $r, $g, $b ) = garland_hex_to_rgb( $hex );
	$amount            = max( 0, min( 1, (float) $amount ) );

	return sprintf(
		'#%02x%02x%02x',
		(int) round( $r + ( 255 - $r ) * $amount ),
		(int) round( $g + ( 255 - $g ) * $amount ),
		(int) round( $b + ( 255 - $b ) * $amount )
	);
}

/**
 * Darken a colour by a fraction.
 */
function garland_shade( $hex, $amount ) {
	list( $r, $g, $b ) = garland_hex_to_rgb( $hex );
	$factor            = max( 0, 1 - max( 0, min( 1, (float) $amount ) ) );

	return sprintf(
		'#%02x%02x%02x',
		(int) round( $r * $factor ),
		(int) round( $g * $factor ),
		(int) round( $b * $factor )
	);
}

/**
 * Build the CSS for a colour scheme.
 *
 * Every colour in the stylesheets is a custom property declared on :root in
 * css/colors.css, so a scheme only has to re-declare those properties: the
 * gradients, rules and hover states that consume them follow on their own.
 * The tints below use the same ratios the default token values were read off.
 *
 * The default scheme is what css/colors.css already declares, so it emits
 * nothing.
 *
 * @param string $scheme_id Scheme key.
 * @return string CSS.
 */
function garland_color_scheme_css( $scheme_id ) {
	$schemes = garland_color_schemes();

	if ( 'default' === $scheme_id || ! isset( $schemes[ $scheme_id ] ) ) {
		return '';
	}

	$c = $schemes[ $scheme_id ]['colors'];

	$base   = $c['base'];
	$link   = $c['link'];
	$top    = $c['top'];
	$bottom = $c['bottom'];

	$tokens = array(
		'header-edge'      => garland_shade( $top, 0.45 ),
		'header-top'       => $top,
		'header-bottom'    => $bottom,
		'header-shadow'    => garland_shade( $bottom, 0.3 ),
		'on-header-muted'  => garland_tint( $top, 0.8 ),

		'text'             => $c['text'],
		'link'             => $link,
		'link-hover'       => garland_shade( $link, 0.2 ),
		'link-active'      => garland_tint( $link, 0.35 ),

		'surface-tint'     => garland_tint( $base, 0.92 ),
		'sidebar-top'      => garland_tint( $base, 0.79 ),
		'sidebar-bottom'   => garland_tint( $base, 0.93 ),
		'content-top'      => garland_tint( $base, 0.92 ),
		'row-alt'          => garland_tint( $base, 0.93 ),

		'crumb-start'      => garland_tint( $base, 0.76 ),
		'crumb-end'        => garland_tint( $base, 0.84 ),
		'crumb-text'       => garland_tint( $base, 0.35 ),

		'rule'             => garland_tint( $base, 0.83 ),
		'rule-soft'        => garland_tint( $base, 0.90 ),
		'rule-form'        => garland_tint( $base, 0.85 ),

		'tab-top'          => garland_tint( $base, 0.65 ),
		'tab-bottom'       => garland_tint( $base, 0.51 ),
	);

	$css = ":root {\n";
	foreach ( $tokens as $name => $value ) {
		$css .= "\t--garland-{$name}: " . esc_html( $value ) . ";\n";
	}
	$css .= "}\n";

	return $css;
}
