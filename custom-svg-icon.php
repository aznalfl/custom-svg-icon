<?php
/**
 * Plugin Name: Custom SVG Icon
 * Description: Add a custom SVG Icon widget with dynamic tag support for Elementor.
 * Version:     1.0.0
 * Author:      Luke Lanza
 * Text Domain: custom-svg-icon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Register the widget with Elementor
function register_custom_svg_widget( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/custom-svg-icon.php' );
    $widgets_manager->register_widget_type( new \Custom_SVG_Icon() );
}
add_action( 'elementor/widgets/register', 'register_custom_svg_widget' );
?>
