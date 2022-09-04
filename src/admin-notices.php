<?php
/**
 * Show relevant admin notices.
 *
 * @package     DeWittePrins\VisualHooks
 * @since       1.0.0
 * @author      hansschuijff
 * @link        https://dewitteprins.nl
 * @license     GNU-2.0+
 */
namespace DeWittePrins\VisualHooks;

/**
 * Show a notice in admin to show that the plugin is running and should not run in production.
 *
 * @return void
 */
function show_admin_notice() {
	?>
    <div class="notice notice-warning" >
        <p><?php _e( 'The Visual Hook Guide is currently active. If this is a production site, remember to deactivate after use.', 'visual-hooks' ); ?></p>
    </div>
<?php
}
add_action( 'admin_notices', __NAMESPACE__ . '\show_admin_notice' );

