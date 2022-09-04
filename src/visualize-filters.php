<?php
/**
 * Visualize filter hooks.
 *
 * @package     DeWittePrins\VisualHooks
 * @since       1.0.0
 * @author      hansschuijff
 * @link        https://dewitteprins.nl
 * @license     GNU-2.0+
 */
namespace DeWittePrins\VisualHooks;

use function \add_filter;
use function \add_action;
use function \__;
use function \current_filter;

/**
 * Starts the visualization of action hooks if that is requested.
 *
 * @return void
 */
function start_filters_visualizer() {

	/** removes query-args that lack the necessary plugin or theme  */
	clean_query_args();

	if ( should_show( 'genesis', 'filters' ) ) {
		visualize_genesis_filters();
	}
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\start_filters_visualizer' );

/**
 * Initiate the visualization of genesis filters.
 * 
 * Hooks a function to each folder that will replace the content of the hook 
 * with a presentation of the hooks name.
 *
 * @return void
 */
function visualize_genesis_filters() {
	if ( ! should_show( 'genesis', 'filters' ) ) {
		return;
	}
	add_filter( 'genesis_seo_title', __NAMESPACE__ . '\visualize_filter_genesis_seo_title', 10, 3 );
	add_filter( 'genesis_seo_description', __NAMESPACE__ . '\visualize_filter_genesis_seo_description', 10, 3 );
	add_filter( 'genesis_title_comments', __NAMESPACE__ . '\visualize_filter_genesis_title_comments');
	add_filter( 'genesis_comment_form_args', __NAMESPACE__ . '\visualize_filter_genesis_comment_form_args');
	add_filter( 'genesis_comments_closed_text', __NAMESPACE__ . '\visualize_filter_genesis_comments_closed_text');
	add_filter( 'comment_author_says_text', __NAMESPACE__ . '\visualize_filter_genesis_comment_author_says_text');
	add_filter( 'genesis_no_comments_text', __NAMESPACE__ . '\visualize_filter_genesis_no_comments_text');
	add_filter( 'genesis_title_pings', __NAMESPACE__ . '\visualize_filter_genesis_title_pings');
	add_filter( 'ping_author_says_text', __NAMESPACE__ . '\visualize_filter_genesis_ping_author_says_text');
	add_filter( 'genesis_no_pings_text', __NAMESPACE__ . '\visualize_filter_genesis_no_pings_text');
	add_filter( 'genesis_breadcrumb_args', __NAMESPACE__ . '\visualize_filter_genesis_breadcrumb_args');
	add_filter( 'genesis_footer_backtotop_text', __NAMESPACE__ . '\visualize_filter_genesis_footer_backtotop_text', 100);
	//add_filter( 'genesis_footer_output', __NAMESPACE__ . '\visualize_filter_genesis_footer_output', 100, 3);
	add_filter( 'genesis_author_box_title', __NAMESPACE__ . '\visualize_filter_genesis_author_box_title' );
	add_filter( 'genesis_post_info', __NAMESPACE__ . '\visualize_filter_genesis_post_info' );
	add_filter( 'genesis_post_meta', __NAMESPACE__ . '\visualize_filter_genesis_post_meta' );
	add_filter( 'genesis_post_title_text', __NAMESPACE__ . '\visualize_filter_genesis_post_title_text');
	add_filter( 'genesis_noposts_text', __NAMESPACE__ . '\visualize_filter_genesis_noposts_text');
	add_filter( 'genesis_search_text', __NAMESPACE__ . '\visualize_filter_genesis_search_text');
	add_filter( 'genesis_search_button_text', __NAMESPACE__ . '\visualize_filter_genesis_search_button_text');
	add_filter( 'genesis_nav_home_text', __NAMESPACE__ . '\visualize_filter_genesis_nav_home_text');
	add_filter( 'genesis_favicon_url', __NAMESPACE__ . '\visualize_filter_genesis_favicon_url');
	add_filter( 'genesis_pre_get_option_footer_text', __NAMESPACE__ . '\visualize_filter_genesis_pre_get_option_footer_text');
}

/**
 * Render the filter-name for display.
 * 
 * Wraps the filter name in a html tag and adds an optional description as title attribute.
 *
 * @param string $wrap          An tagname that will be used to wrap the filter-name.
 * @param string $description   An optional description that will be used as title attribute.
 * @return void
 */
function render_filter_name( $wrap, $description = null ) {
	$filter_name = current_filter();
	return '<' . $wrap . ' class="vhg-filter" data-vhg-filter="' . $filter_name . '" title="' . $description . '">' . $filter_name . '</' . $wrap . '>';
}

/**
 * Visualize genesis_seo_title filter.
 *
 * @param string $title  The SEO title.
 * @param string $inside The inner portion of the SEO title.
 * @param string $wrap   The html element to wrap the title in.
 * @return string The markup to display the filter hook
 */
function visualize_filter_genesis_seo_title( $title, $inside, $wrap ) {
	return sprintf(
		'<%2$s id="title">%1$s</%2$s>',
		render_filter_name(
			'span', 
			'Applied to the output of the genesis_seo_site_title function which depending on the SEO option set by the user will either wrap the title in <h1> or <p> tags. Default value: $title, $inside, $wrap'
		),
		$wrap
	);
}

/**
 * Visualizes genesis_seo_description filter.
 *
 * @param string $description The SEO description
 * @param string $inside      The inner portion of the SEO title.
 * @param string $wrap        The html element to wrap the title in.
 * @return string The markup to display the filter hook.
 */
function visualize_filter_genesis_seo_description( $description, $inside, $wrap ) {
	return sprintf(
		'<%2$s id="title">%1$s</%2$s>',
		render_filter_name(
			'span',
			'Applied to the output of the genesis_seo_site_description function which depending on the SEO option set by the user will either wrap the description in <h1> or <p> tags. Default value: $description, $inside, $wrap'
		),
		$wrap
	);
}

function visualize_filter_genesis_author_box_title() {
	return '<strong>' . render_filter_name( 'span' ) . '</strong>';
}

function visualize_filter_genesis_comment_author_says_text() {
	return render_filter_name( 'span' );
}

function visualize_filter_genesis_ping_author_says_text() {
	return render_filter_name( 'span' );
}

function visualize_filter_genesis_footer_backtotop_text() {
	return render_filter_name( 'div' );
}

function visualize_filter_genesis_pre_get_option_footer_text() {
	return render_filter_name( 'div' );
}

function visualize_filter_genesis_footer_output( $output, $backtotop_text, $creds ) {
	return render_filter_name( 'div' ) . $backtotop_text . $creds;
}

function visualize_filter_genesis_breadcrumb_args( $args ) {
	$args['prefix']           = '<div class="breadcrumb"><span class="filter">genesis_breadcrumb_args</span> ';
	$args['suffix']           = '</div>';
	$args['home']             = __('<span class="filter">[\'home\']</span>', 'genesis');
	$args['sep']              = '<span class="filter">[\'sep\']</span>';
	$args['labels']['prefix'] = __('<span class="filter">[\'labels\'][\'prefix\']</span> ', 'genesis');
	return $args;
}

function visualize_filter_genesis_title_pings() {
	echo render_filter_name( 'h3' );
}

function visualize_filter_genesis_no_pings_text() {
	echo render_filter_name( 'p' );
}

function visualize_filter_genesis_title_comments() {
	echo render_filter_name( 'h3' );
}

function visualize_filter_genesis_comments_closed_text() {
	echo render_filter_name( 'p' );
}

function visualize_filter_genesis_no_comments_text() {
	echo render_filter_name( 'p' );
}

function visualize_filter_genesis_comment_form_args( $args ) {
	$args['title_reply']          = '<span class="filter">genesis_comment_form_args [\'title_reply\']</span>';
	$args['comment_notes_before'] = '<span class="filter">genesis_comment_form_args [\'comment_notes_before\']</span>';
	$args['comment_notes_after']  = '<span class="filter">genesis_comment_form_args [\'comment_notes_after\']</span>';
	return $args;
}

function visualize_filter_genesis_favicon_url() {
	return current_filter();
}

function visualize_filter_genesis_post_info() {
	return render_filter_name( 'span' );
}

function visualize_filter_genesis_post_meta() {
	return render_filter_name( 'span' );
}

function visualize_filter_genesis_post_title_text() {
	return render_filter_name( 'span' );
}

function visualize_filter_genesis_noposts_text() {
	return render_filter_name( 'span' );
}

function visualize_filter_genesis_search_text() {
	return current_filter();
}

function visualize_filter_genesis_search_button_text() {
	return current_filter();
}

function visualize_filter_genesis_nav_home_text() {
	return render_filter_name( 'span' );
}
