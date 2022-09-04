<?php
/**
 * Helper functions.
 *
 * @package     DeWittePrins\VisualHooks
 * @since       1.0.0
 * @author      hansschuijff
 * @link        https://dewitteprins.nl
 * @license     GNU-2.0+
 */
namespace DeWittePrins\VisualHooks;

/**
 * Returns the prefix of the hook name (until the first underscore).
 *
 * @param string $hook_name The name of a hook.
 * @return void
 */
function get_hook_prefix( $hook_name ) {
	return strtok( $hook_name, '_' );
}

/**
 * Is this hook an action hook?
 *
 * @param string $hook_name The name of a hook or filter.
 * @return boolean
 */
function is_action_hook( $hook_name ) {
	global $wp_actions;
	return isset( $wp_actions[ $hook_name ] );
}

/**
 * Is WooCommerce installed and active?
 *
 * @since 1.0.0
 * @return boolean
 */
function is_woocommerce_active() {
	return is_plugin_active( 'woocommerce/woocommerce.php' );
}

/**
 * Is Sensei LMS (free or paid version) installed and active?
 *
 * @since 1.0.0
 * @return boolean
 */
function is_sensei_lms_active() {
	return is_plugin_active( 'sensei-lms/sensei-lms.php' ) || is_plugin_active( 'woothemes-sensei/woothemes-sensei.php' );
}

/**
 * Is The Events Calendar installed and active?
 *
 * @since 1.0.0
 * @return boolean
 */
function is_the_events_calendar_active() {
	return is_plugin_active( 'the-events-calendar/the-events-calendar.php' );
}

/**
 * Is the active theme a child theme of the genesis framework?
 *
 * @since 1.0.0
 * @return boolean
 */
function is_theme_a_genesis_child() {
	static $is_genesis_theme = null;
	if ( null !== $is_genesis_theme ) {
		return $is_genesis_theme;
	}
	$parent_theme = \wp_get_theme( \get_template() );
	if ( ! $parent_theme->exists() ) {
		return false;
	}
	if ( 'genesis' !== strtolower( $parent_theme->name )
	|| 'studiopress' !== strtolower( $parent_theme->get( 'Author' ) ) ) {
		$is_genesis_theme = false;
		return $is_genesis_theme;
	}
	$is_genesis_theme = true;
	return $is_genesis_theme;
}

/**
 * Is the soure of this hook (theme/plugin) available?
 *
 * @param [type] $source
 * @return boolean
 */
function is_hook_source_available( $source ) {
	switch ( $source ) {
		case 'genesis':
			return is_theme_a_genesis_child();
			break;

		case 'woocommerce':
			return is_woocommerce_active();
			break;

		case 'sensei':
			return is_sensei_lms_active();
			break;

		case 'tribe':
			return is_the_events_calendar_active();
			break;

		default:
			return false;
			break;
	}
}
