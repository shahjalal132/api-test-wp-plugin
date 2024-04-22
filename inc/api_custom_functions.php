<?php


/**
 * Function to save response data to a file.
 *
 * @param string $data The response data to be saved.
 */
function put_api_response_data( $data ) {
    // Ensure directory exists to store response data
    $directory = API_PLUGIN_PATH . '/api_response/';
    if ( !file_exists( $directory ) ) {
        mkdir( $directory, 0777, true );
    }

    // Construct file path for response data
    $fileName = $directory . 'response.txt';

    // Get the current date and time
    $current_datetime = date( 'Y-m-d H:i:s' );

    // Append current date and time to the response data
    $data = $data . ' - ' . $current_datetime;

    // Append new response data to the existing file
    if ( file_put_contents( $fileName, $data . PHP_EOL, FILE_APPEND | LOCK_EX ) !== false ) {
        return "Data appended to file successfully.";
    } else {
        return "Failed to append data to file.";
    }
}

/**
 * Write an error message to a file.
 *
 * @param string $error_message The error message to be written to the file.
 * @return string Return a success or failure message.
 */
function put_api_error_message( $error_message ) {
    // Ensure directory exists to store error logs
    $directory = API_PLUGIN_PATH . '/api_response/';
    if ( !file_exists( $directory ) ) {
        mkdir( $directory, 0777, true );
    }

    // Construct file path for error log
    $fileName = $directory . 'error-log.txt';

    // Get the current date and time
    $current_datetime = date( 'Y-m-d H:i:s' );

    // Append current date and time to the error message
    $error_message = $error_message . ' - ' . $current_datetime;

    // Append new error message to the existing file
    if ( file_put_contents( $fileName, $error_message . PHP_EOL, FILE_APPEND | LOCK_EX ) !== false ) {
        return "Error message appended to file successfully.";
    } else {
        return "Failed to append error message to file.";
    }
}