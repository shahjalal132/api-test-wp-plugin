<?php

/*
 * Plugin Name:       External API Test
 * Plugin URI:        #
 * Description:       External API testing
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shah jalal
 * Author URI:        #
 * License:           GPL v2 or later
 * Text Domain:       test-api
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin path
if ( !defined( 'API_PLUGIN_PATH' ) ) {
    define( 'API_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Define plugin URL
if ( !defined( 'API_PLUGIN_URI' ) ) {
    define( 'API_PLUGIN_URI', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
}

/**
 * Register an External API menu page.
 */
function external_api_testing_callback() {
    add_menu_page(
        __( 'External API', 'test-api' ), // Page title
        'External API',                   // Menu title
        'manage_options',                 // Capability required
        'external-api.php',               // Menu slug
        'test_api_admin_callback',        // Callback function
        'dashicons-admin-site',           // Icon URL or dashicons class
        85                                // Menu position
    );
}
add_action( 'admin_menu', 'external_api_testing_callback' );


/**
 * Callback function for the test API admin interface.
 */
function test_api_admin_callback() {
    ?>
    <div class="wrap">
        <h1>
            <?php _e( 'Test External API', 'test-api' ); ?>
        </h1>
        <button id="send-get-request-btn" class="button button-primary">
            <?php _e( 'Send GET Request', 'test-api' ); ?>
        </button>
        <div id="response-message"></div>
    </div>

    <script>
        jQuery(document).ready(function ($) {

            // Handle get get request button click event
            $('#send-get-request-btn').on('click', function () {
                // Send AJAX request
                $.ajax({
                    url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                    method: 'POST',
                    data: {
                        action: 'send_get_request' // AJAX action name
                    },
                    success: function (response) {
                        $('#response-message').html(response);
                    },
                    error: function (xhr, status, error) {
                        $('#response-message').html('<div class="error">Error: ' + error + '</div>');
                    }
                });
            });


        });
    </script>
    <?php
}


// include required files
require_once API_PLUGIN_PATH . '/inc/api_custom_functions.php';
require_once API_PLUGIN_PATH . '/inc/api_get_request.php';