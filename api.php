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
 * Callback function to display content on the External API menu page.
 * This function sends a GET request to an external API and saves the response data to a file.
 */
function test_api_admin_callback() {
    $url  = "https://jsonplaceholder.typicode.com/users"; // API endpoint URL
    $args = [
        'method'       => 'GET',                      // HTTP request method
        'Content-Type' => 'application/json',         // Content type header
    ];

    $response = wp_remote_get( $url, $args ); // Send GET request

    // If request is successful (HTTP status code 200)
    if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
        $data = wp_remote_retrieve_body( $response ); // Get response body
        put_response_data( $data );                   // Save response data to a file
    }

    // If request fails or returns an error
    if ( 200 !== wp_remote_retrieve_response_code( $response ) || is_wp_error( $response ) ) {
        // Get the error message
        $error_message = wp_remote_retrieve_response_message( $response );
        $error_message = date( 'Y-m-d H:i:s' ) . ' - ' . $error_message . PHP_EOL;
        put_error_message( $error_message ); // Save error message to a file
    }
}

/**
 * Function to save response data to a file.
 *
 * @param string $data The response data to be saved.
 */
function put_response_data( $data ) {
    // Ensure directory exists to store response data
    $directory = API_PLUGIN_PATH . '/data/';
    if ( !file_exists( $directory ) ) {
        mkdir( $directory, 0777, true );
    }

    // Construct file path for response data
    $fileName = $directory . 'response.json';

    // Write response data to file
    if ( file_put_contents( $fileName, $data ) !== false ) {
        return "Data written to file successfully.";
    } else {
        return "Failed to write data to file.";
    }
}

/**
 * Write an error message to a file.
 *
 * @param string $error_message The error message to be written to the file.
 * @return string Return a success or failure message.
 */
function put_error_message( $error_message ) {
    // Ensure directory exists to store error logs
    $directory = API_PLUGIN_PATH . '/errors/';
    if ( !file_exists( $directory ) ) {
        mkdir( $directory, 0777, true );
    }

    // Construct file path for error log
    $fileName = $directory . 'error-log.txt';

    // Write error message to file
    if ( file_put_contents( $fileName, $error_message ) !== false ) {
        return "Error message written to file successfully.";
    } else {
        return "Failed to write error message to file.";
    }
}
