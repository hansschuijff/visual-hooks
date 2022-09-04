<?php
/**
 * Plugin Name: Visual Hooks
 * Plugin URI: https://github.com/hansschuijff/visual-hooks
 * GitHub Plugin URI: https://github.com/hansschuijff/Visual-Hooks
 * Description: Make the locations and names of hooks visible. Supports Genesis child-themes, The Event Calendar plugin and WooCommerce.
 * Version: 1.0.1
 * Author: Hans Schuijff
 * Author URI: https://dewitteprins.nl
 * Text Domain: visual-hooks
 * License: GPLv2
 */

namespace DeWittePrins\VisualHooks;

use function \add_action;
use function \wp_enqueue_style;
use function \plugins_url;

define( 'VISUAL_HOOKS_PREFIX', 'vhg' );

/**
 * Are the plugin requirements met?
 *
 * @return bool True when plugin dependencies are met, otherwise false.
 */
function should_plugin_run() {
	return is_theme_a_genesis_child()
		|| is_sensei_lms_active()
		|| is_the_events_calendar_active()
		|| is_woocommerce_active();
}

/**
 * Enqueues relevant plugin styles.
 *
 * @return void
 */
function enqueue_stylesheet() {

	$plugin_url = plugins_url( null, __FILE__ );

	if ( should_show( '', array( 'actions', 'filters' ) ) ) {
		wp_enqueue_style( 'vhg_styles', $plugin_url . '/css/styles.css' );
	}
	/* Visualization of genesis markup is implemented by just using css. */
	if ( should_show( 'genesis', 'markup' ) ) {
		wp_enqueue_style( 'vhg_genesis_markup_styles', $plugin_url . '/css/markup.css' );
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_stylesheet' );

require_once 'src/helper-functions.php';
require_once 'src/handle-query-args.php';
require_once 'src/admin-bar-menu.php';
require_once 'src/admin-notices.php';
require_once 'src/visualize-actions.php';
require_once 'src/visualize-filters.php';
