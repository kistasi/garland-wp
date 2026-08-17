<?php
/**
 * Garland colour schemes.
 *
 * Port of the Drupal theme's color/color.inc. Drupal's Color module recoloured
 * the theme by regenerating images and rewriting stylesheets on save. WordPress
 * has no equivalent, so the schemes are kept as data here and applied as inline
 * CSS: the derived tints are computed the same way Drupal's blend did, by
 * mixing the base colour toward the blend target (white).
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
 * Build the CSS overrides for a colour scheme.
 *
 * The default scheme is already baked into css/colors.css, so it emits nothing.
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
	$text   = $c['text'];

	// Derived tints, matching the ratios the default stylesheet uses.
	$header_edge     = garland_shade( $top, 0.45 );
	$header_shadow   = garland_shade( $bottom, 0.3 );
	$container_start = garland_tint( $base, 0.79 );
	$container_end   = garland_tint( $base, 0.93 );
	$center_start    = garland_tint( $base, 0.92 );
	$crumb_start     = garland_tint( $base, 0.76 );
	$crumb_end       = garland_tint( $base, 0.84 );
	$rule            = garland_tint( $base, 0.83 );
	$soft_rule       = garland_tint( $base, 0.90 );
	$row_odd         = garland_tint( $base, 0.93 );
	$link_hover      = garland_shade( $link, 0.2 );
	$link_active     = garland_tint( $link, 0.35 );
	$crumb_text      = garland_tint( $base, 0.35 );
	$secondary_link  = garland_tint( $top, 0.8 );

	ob_start();
	?>
body { color: <?php echo esc_html( $text ); ?>; }

a:link, a:visited { color: <?php echo esc_html( $link ); ?>; }
a:hover { color: <?php echo esc_html( $link_hover ); ?>; }
a:active, a.active { color: <?php echo esc_html( $link_active ); ?>; }

#header {
	background-image: linear-gradient(to bottom, <?php echo esc_html( $header_edge ); ?> 1px, <?php echo esc_html( $top ); ?> 5px, <?php echo esc_html( $bottom ); ?> 116px);
	background-color: <?php echo esc_html( $bottom ); ?>;
	box-shadow: inset 0 -3px 4px -2px <?php echo esc_html( $header_shadow ); ?>;
}

#container {
	background-image: linear-gradient(to bottom, <?php echo esc_html( $container_start ); ?> 0px, <?php echo esc_html( $container_end ); ?> 178px);
}

#center {
	background-image: linear-gradient(to bottom, <?php echo esc_html( $center_start ); ?> 0px, #ffffff 178px);
}

#breadcrumb {
	background-image: linear-gradient(to right, <?php echo esc_html( $crumb_start ); ?>, <?php echo esc_html( $crumb_end ); ?> 40px);
	box-shadow: -3px -3px 4px -2px <?php echo esc_html( $header_shadow ); ?>, 3px -3px 4px -2px <?php echo esc_html( $header_shadow ); ?>;
}

#breadcrumb-inner {
	background-image: linear-gradient(to left, <?php echo esc_html( $crumb_start ); ?>, <?php echo esc_html( $crumb_end ); ?> 40px, rgba(0, 0, 0, 0) 40px);
}

#container .region-breadcrumb,
#container .region-breadcrumb a { color: <?php echo esc_html( $crumb_text ); ?>; }

#branding, #branding a:link, #branding a:visited { text-shadow: <?php echo esc_html( $header_edge ); ?> 0 1px 3px; }

.region-secondary-menu ul li a,
.region-secondary-menu ul li a:link,
.region-secondary-menu ul li a:visited,
.region-secondary-menu ul li a:hover { color: <?php echo esc_html( $secondary_link ); ?>; }

thead th { border-bottom-color: <?php echo esc_html( $rule ); ?>; color: <?php echo esc_html( $text ); ?>; }
tr.even, tr.odd, tbody th { border-color: <?php echo esc_html( $rule ); ?>; }
tr.odd, tr.info { background-color: <?php echo esc_html( $row_odd ); ?>; }

.node, #comments, .comment, nav.primary-tabs, ul.secondary { border-color: <?php echo esc_html( $soft_rule ); ?>; }
	<?php
	return trim( ob_get_clean() ) . "\n";
}
