<?php

// Register AJAX action for sending the GET request
add_action( 'wp_ajax_send_get_request', 'send_get_request_callback' );
function send_get_request_callback() {

    $url  = "https://jsonplaceholder.typicode.com/users"; // API endpoint URL. Replace with your API endpoint
    $args = [
        'method'       => 'GET',                      // HTTP request method
        'Content-Type' => 'application/json',         // Content type header. Replace with your content type
    ];

    $response = wp_remote_get( $url, $args ); // Send GET request

    // If request is successful (HTTP status code 200)
    if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
        $data = wp_remote_retrieve_body( $response ); // Get response body
        put_response_data( $data );                   // Save response data to a file
        echo '<div class="updated"><p>Response received:</p><pre>' . esc_html( $data ) . '</pre></div>';
    }

    // If request fails or returns an error
    if ( 200 !== wp_remote_retrieve_response_code( $response ) || is_wp_error( $response ) ) {
        // Get the error message
        $error_message = wp_remote_retrieve_response_message( $response );
        $error_message = date( 'Y-m-d H:i:s' ) . ' - ' . $error_message . PHP_EOL;
        put_error_message( $error_message ); // Save error message to a file
        echo '<div class="error">Error: ' . esc_html( $error_message ) . '</div>';
    }

    // Always die in the end to prevent extra output
    wp_die();
}