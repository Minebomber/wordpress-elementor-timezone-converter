<?php

/**
 * Plugin Name: Timezone Converter Widget
 * Description: Widget for converting time between timezones
 * Version:     1.0.3
 * Text Domain: tz-converter
 *
 * Elementor tested up to: 3.7.8
 * Elementor Pro tested up to: 3.7.7
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Register widget.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function tzc_register_widget($widgets_manager)
{

	require_once(__DIR__ . '/includes/converter-widget.php');

	$widgets_manager->register(new \Converter_Widget());
}
add_action('elementor/widgets/register', 'tzc_register_widget');

/**
 * Load plugin textdomain.
 *
 * @since 1.0.1
 * @return void
 */
function tzc_load_textdomain()
{
	load_plugin_textdomain('tz-converter', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('init', 'tzc_load_textdomain');
