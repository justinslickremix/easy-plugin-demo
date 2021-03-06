<?php
/**
 * Dashboard Functions
 *
 * @package     EPD
 * @subpackage  Functions
 * @copyright   Copyright (c) 2018, Mike Howard
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.1
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Remove the welcome panel.
 *
 * @since	1.0.1
 * @return	void
 */
function epd_manage_dashboard_welcome_panel()	{
	if ( get_current_blog_id() == get_network()->blog_id )	{
		return;
	}

	if ( epd_get_option( 'hide_welcome' ) )	{
		remove_action( 'welcome_panel', 'wp_welcome_panel' );
	}

	if ( epd_get_option( 'custom_welcome' ) )	{
		add_action( 'welcome_panel', 'epd_render_custom_welcome_panel' );
	}
} // epd_manage_dashboard_welcome_panel
add_action( 'wp_dashboard_setup', 'epd_manage_dashboard_welcome_panel' );

/**
 * Adds the EPD site count to the "Right Now" network dashboard.
 *
 * @since   1.0.2
 * @return  void
 */
function epd_right_now_dashboard_site_count()   {
    $site_count = epd_get_registered_demo_sites_count();

    if ( empty( $site_count ) ) {
        return;
    }

    $sites    = sprintf( _n( '%s site', '%s sites', $site_count, 'easy-plugin-demo' ), number_format_i18n( $site_count ) );
    $sentence = sprintf(
        __( '%s have been provisioned by <a href="%s" target="_blank">Easy Plugin Demo</a>.', 'easy-plugin-demo' ),
        $sites,
        'https://wordpress.org/plugins/easy-plugin-demo/'
    );

    $settings = add_query_arg( 'page', 'epd-settings', network_admin_url( 'settings' ) );

    ?>
    <p class="youhave"><?php echo $sentence; ?></p>
    <?php
} // epd_right_now_dashboard_site_count
add_action( 'mu_rightnow_end', 'epd_right_now_dashboard_site_count' );
