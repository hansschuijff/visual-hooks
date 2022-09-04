<?php
/**
 * Visualize action hooks.
 *
 * @package     DeWittePrins\VisualHooks
 * @since       1.0.0
 * @author      hansschuijff
 * @link        https://dewitteprins.nl
 * @license     GNU-2.0+
 */
namespace DeWittePrins\VisualHooks;

use function \add_action;
use function \current_filter;

/**
 * Starts the visualization of action hooks if that is requested.
 *
 * @return void
 */
function start_action_hook_visualizer() {
	/** removes query-args that lack the necessary plugin or theme  */
	clean_query_args();
	if ( should_show( '', 'actions' ) ) {
		add_action( 'all', __NAMESPACE__ . '\action_hook_visualizer', 1 );
	}
	if ( should_show('genesis', 'actions') 
	&& is_theme_a_genesis_child() ) {
		add_action( 'genesis_header_right', '__return_empty_string', 1 );
	}
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\start_action_hook_visualizer' );

/**
 * Selects the requested action hooks and initiates visualization.
 *
 * @return void
 */
function action_hook_visualizer () {
	$hook = current_filter();
	if ( should_visualize_action_hook( $hook) ) {
		visualize_action_hook( 
			$hook,
			get_hook_context( $hook, func_get_args() )
		);
	}
}

/**
 * Should this hook be made visible?
 *
 * @param [type] $hook
 * @return boolean
 */
function should_visualize_action_hook( $hook ) {
	if ( ! is_action_hook( $hook ) ) {
		return false;
	}
	$hook_source = get_hook_prefix( $hook );
	if( ! in_array( $hook_source, supported_hook_sources(), true ) ) {
		return false;
	}
	return should_show( $hook_source, 'actions' );
}

/**
 * Add the markup to visualize an action hook. 
 *
 * @param string $hook    The name of the action hook.
 * @param string $context The context of the hook (like the template-name).
 * @return void
 */
function visualize_action_hook( $hook, $context = '' ) {
	$hook_source = get_hook_prefix( $hook );
	$context = ! empty( $context ) ? ' ( ' . $context . ' )' : '';
	$hook = $hook . $context; 
	echo '<div class="vhg-hook vhg-' . $hook_source . '-hook" title="' . $hook .  '" data-vhg-hook="' . $hook . '">'
		. $hook
		. '</div>';
		
}

/**
 * Add a context to certain hooks.
 *
 * If the hook itself may give to little information,
 * this function allows adding some argument value to it (like the name of a template).
 * 
 * @param string $hook The name of a filter or action hook.
 * @param array $args  The arguments that where passed to the hook.
 * @return void
 */
function get_hook_context( $hook, $args ) {
	switch ( $hook ) {
		case 'woocommerce_before_template_part':
		case 'woocommerce_after_template_part':
			return $args[1];
			break;
		default:
			return '';
			break;
	}
}
