<?php
/**
 * Garland Customizer settings.
 *
 * Port of theme-settings.php (the content width radios) and of the scheme
 * picker that Drupal's Color module added to the theme settings form.
 *
 * @package Garland
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme options.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function garland_customize_register( $wp_customize ) {
	$defaults = garland_option_defaults();

	$wp_customize->add_section(
		'garland_options',
		array(
			'title'    => __( 'Garland Options', 'garland' ),
			'priority' => 30,
		)
	);

	// theme-settings.php: garland_width.
	$wp_customize->add_setting(
		'garland_width',
		array(
			'default'           => $defaults['garland_width'],
			'sanitize_callback' => 'garland_sanitize_width',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'garland_width',
		array(
			'label'       => __( 'Content width', 'garland' ),
			'description' => __( 'Specify whether the content will wrap to a fixed width or will fluidly expand to the width of the browser window.', 'garland' ),
			'section'     => 'garland_options',
			'type'        => 'radio',
			'choices'     => array(
				'fluid' => __( 'Fluid width', 'garland' ),
				'fixed' => __( 'Fixed width', 'garland' ),
			),
		)
	);

	// color.inc: colour schemes.
	$choices = array();
	foreach ( garland_color_schemes() as $key => $scheme ) {
		$choices[ $key ] = $scheme['title'];
	}

	$wp_customize->add_setting(
		'garland_color_scheme',
		array(
			'default'           => $defaults['garland_color_scheme'],
			'sanitize_callback' => 'garland_sanitize_color_scheme',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'garland_color_scheme',
		array(
			'label'       => __( 'Color scheme', 'garland' ),
			'description' => __( 'The colour schemes shipped with the original theme. A scheme recolours the whole theme -- gradients, links, rules, tabs and the navigation pointer alike.', 'garland' ),
			'section'     => 'garland_options',
			'type'        => 'select',
			'choices'     => $choices,
		)
	);

	// Live preview for the built-in site identity controls. Both settings are
	// core's, so they are only ours to adjust when they are actually there.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$partials = array(
		'blogname'        => array(
			'selector'        => '#branding span',
			'render_callback' => function () {
				return get_bloginfo( 'name', 'display' );
			},
		),
		'blogdescription' => array(
			'selector'        => '#site-slogan',
			'render_callback' => function () {
				return get_bloginfo( 'description', 'display' );
			},
		),
	);

	foreach ( $partials as $id => $partial ) {
		$setting = $wp_customize->get_setting( $id );

		if ( ! $setting ) {
			continue;
		}

		$setting->transport = 'postMessage';
		$wp_customize->selective_refresh->add_partial( $id, $partial );
	}
}
add_action( 'customize_register', 'garland_customize_register' );

/**
 * Sanitize the width setting.
 */
function garland_sanitize_width( $value ) {
	$defaults = garland_option_defaults();

	return in_array( $value, array( 'fluid', 'fixed' ), true ) ? $value : $defaults['garland_width'];
}

/**
 * Sanitize the colour scheme setting.
 */
function garland_sanitize_color_scheme( $value ) {
	$defaults = garland_option_defaults();

	return array_key_exists( $value, garland_color_schemes() ) ? $value : $defaults['garland_color_scheme'];
}
