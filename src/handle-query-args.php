<?php
/**
 * Handling of the query-args.
 *
 * @package     DeWittePrins\VisualHooks
 * @since       1.0.0
 * @author      hansschuijff
 * @link        https://dewitteprins.nl
 * @license     GNU-2.0+
 */
namespace DeWittePrins\VisualHooks;

/**
 * Query arg key generator.
 *
 * @param string $source A sting indicating the source (theme/plugin) of the hooks or markup.
 * @param string $show   'actions' | 'filters' | 'markup'
 * @return void
 */
function query_arg_key( $source, $show ) {
	return VISUAL_HOOKS_PREFIX . '_' . $source . '_' . $show; 
}

function supported_hook_sources() {
	return array(
		'genesis',
		'sensei' ,
		'tribe' ,
		'woocommerce'
	);
}

function supported_elements() {
	return array(
		'actions',
		'filters',
		'markup'
	);
}

/**
 * Returns query var keys that are supported by this plugin. 
 *
 * @return array
 */
function supported_query_arg_keys() {
	return array(
		'vhg_genesis_actions',
		'vhg_genesis_filters',
		'vhg_genesis_markup',
		'vhg_sensei_actions',
		'vhg_tribe_actions',
		'vhg_woocommerce_actions',
	);
}

/**
 * Clears the url from vhg-query vars.
 *
 * @return url url without the vhg-query args.
 */
function clean_url() {
	return esc_url(
		remove_query_arg(
			supported_query_arg_keys()
		)
	);
}

/**
 * Remove all query_args that lack the proper requirements.
 *
 * @return void
 */
function clean_query_args() {
	foreach ( $_GET as $key => $value ) {
		if ( VISUAL_HOOKS_PREFIX === strtok( $key, '_' ) ) {
			if ( ! is_hook_source_available( strtok( '_' ) ) ) {
				unset( $_GET[ $key ] );
			}
		}
	}
}

/**
 * Checks the intention to show given hooks or markup for a given source.
 *
 * @param string|string[] $sources  The source to check for. 'any' means all supported sources.
 * @param string|string[] $elements The type of elements to visualize.
 * @return boolean true when at least one of the elements of ate least one source should be shown, otherwise false.
 */
function should_show( $sources, $elements ) {
	if ( empty( $sources ) ) {
		$sources = supported_hook_sources();
	}
	$sources  = (array) $sources;
	if ( empty( $elements ) ) {
		$elements = supported_elements();
	}
	$elements = (array) $elements;
	foreach ( $sources as $source ) {
		foreach ( $elements as $element ) {
			if ( is_query_arg_used( $source, $element ) ) {
				return true;
			}
		}
	}
	return false;
}

function is_query_arg_used( $source, $element ) {
	$key = query_arg_key( $source, $element );
	if ( is_supported_query_arg_key( $key ) ) {
		return 'show' == isset( $_GET[ $key ] );
	}
}

function is_supported_query_arg_key( $key ) {
	return in_array( $key, supported_query_arg_keys(), true );
}

