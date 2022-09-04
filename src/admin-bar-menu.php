<?php
/**
 * Add a submenu to the admin toolbar
 *
 * @package     DeWittePrins\VisualHooks
 * @since       1.0.0
 * @author      hansschuijff
 * @link        https://dewitteprins.nl
 * @license     GNU-2.0+
 */
namespace DeWittePrins\VisualHooks;

use function \is_admin;
use function \add_query_arg;
use function \__;
use function \esc_url;
use function \add_action;

/**
 * Builds the admin toolbar menu for this plugin.
 *
 * @return void
 */
function add_admin_bar_menu() {
	global $wp_admin_bar;
	if ( is_admin() ) {
		return;
	}
	if ( ! should_plugin_run() ) {
		// don't add menu when none of the dependent theme's or plugins are active
		return;
	}
	$wp_admin_bar->add_menu(
		array(
			'id'       => 'vhg_visual_hooks_menu',
			'title'    => __( 'Visual Hooks', 'visual-hooks' ),
			'href'     => '',
			'position' => 0,
		)
	);
	if ( is_theme_a_genesis_child() ) {
		$wp_admin_bar->add_menu(
			array(
				'id'       => 'vhg_genesis_visual_hooks_submenu',
				'parent'   => 'vhg_visual_hooks_menu',
				'title'    => __( 'Genesis', 'visual-hooks' ),
				'href'     => esc_url( add_query_arg( query_arg_key( 'genesis', 'actions' ), 'show' ) ),
				'position' => 10,
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'id'       => 'vhg_genesis_visual_action_hooks',
				'parent'   => 'vhg_genesis_visual_hooks_submenu',
				'title'    => __( 'Actions', 'visual-hooks' ),
				'href'     => esc_url( add_query_arg( query_arg_key( 'genesis', 'actions' ), 'show' ) ),
				'position' => 10,
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'id'       => 'vhg_genesis_visual_filter_hooks',
				'parent'   => 'vhg_genesis_visual_hooks_submenu',
				'title'    => __( 'Filters', 'visual-hooks' ),
				'href'     => esc_url( add_query_arg( query_arg_key( 'genesis', 'filters' ), 'show' ) ),
				'position' => 10,
			)
		);
		$wp_admin_bar->add_menu(
			array(
				'id'       => 'vhg_genesis_visual_markup',
				'parent'   => 'vhg_genesis_visual_hooks_submenu',
				'title'    => __( 'Markup', 'visual-hooks' ),
				'href'     => esc_url( add_query_arg( query_arg_key( 'genesis', 'markup' ), 'show' ) ),
				'position' => 10,
			)
		);
	}
	if ( is_sensei_lms_active() ) {
		$wp_admin_bar->add_menu(
			array(
				'id'       => 'vhg_sensei_visual_action_hooks',
				'parent'   => 'vhg_visual_hooks_menu',
				'title'    => __( 'Sensei LMS', 'visual-hooks' ),
				'href'     => esc_url( add_query_arg( query_arg_key( 'sensei', 'actions' ), 'show' ) ),
				'position' => 10,
			)
		);
	}
	if ( is_the_events_calendar_active() ) {
		$wp_admin_bar->add_menu(
			array(
				'id'       => 'vhg_event_action_hooks',
				'parent'   => 'vhg_visual_hooks_menu',
				'title'    => __( 'The Event Calendar', 'visual-hooks' ),
				'href'     => esc_url( add_query_arg( query_arg_key( 'tribe', 'actions' ), 'show' ) ),
				'position' => 10,
			)
		);
	}
	if ( is_woocommerce_active() ) {
		$wp_admin_bar->add_menu(
			array(
				'id'       => 'vhg_woocommerce_visual_action_hooks',
				'parent'   => 'vhg_visual_hooks_menu',
				'title'    => __( 'WooCommerce', 'visual-hooks' ),
				'href'     => esc_url( add_query_arg( query_arg_key( 'woocommerce', 'actions' ), 'show' ) ),
				'position' => 10,
			)
		);
	}
	$wp_admin_bar->add_menu(
		array(
			'id'       => 'vhg_reset_visual_hooks',
			'parent'   => 'vhg_visual_hooks_menu',
			'title'    => __( 'Reset', 'visual-hooks' ),
			'href'     => clean_url(),
			'position' => 10,
		)
	);
}
add_action( 'admin_bar_menu', __NAMESPACE__ . '\add_admin_bar_menu', 100 );
