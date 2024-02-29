<?php


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