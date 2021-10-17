<?php

/**
 * Attachment Uploader class
 *
 */
class Wecarry_Upload {

    public function __construct() {
        add_action( 'wp_ajax_wecarry_upload_file', array( $this, 'wecarry_upload_file' ) );
        add_action( 'wp_ajax_nopriv_wecarry_upload_file', array( $this, 'wecarry_upload_file' ) );
    }

    public function wecarry_upload_file( $image_only = false ) {


        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'taslim-admin-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'wecarry' )
            ] );
        }

        if ( ! is_user_logged_in() ) {
        	die( 'error' );
        }

        $wecarry_file = isset( $_FILES['wecarry_file'] ) ? $_FILES['wecarry_file'] : [];

        $file_name      = pathinfo( $wecarry_file['name'], PATHINFO_FILENAME );
        $file_extension = pathinfo( $wecarry_file['name'], PATHINFO_EXTENSION );
        $hash           = wp_hash( time() );
        $hash           = substr( $hash, 0, 8 );

		$allowed_extensions = array( 'jpg', 'jpeg', 'png' );
		$file_type = wp_check_filetype( $_FILES['wecarry_file']['name'] );
		// Check for valid file extension
		if ( ! in_array( $file_extension, $allowed_extensions ) ) {
            wp_send_json_error( [
                'message' => sprintf(  esc_html__( 'Invalid file extension, only allowed: %s', 'theme-text-domain' ), implode( ', ', $allowed_extensions ) )
            ] );
		}


		$allowed_file_size = 2048000; // Here we are setting the file size limit to 500 KB = 500 × 1024
		// Check for file size limit
		if ( $wecarry_file['size'] >= $allowed_file_size ) {
            wp_send_json_error( [
                'message' =>  'File size limit exceeded, file size should be smaller than 2 MB'
            ] );

		}

        $upload = [
            'name'     => $file_name . '-' . $hash . '.' . $file_extension,
            'type'     => $wecarry_file['type'],
            'tmp_name' => $wecarry_file['tmp_name'],
            'error'    => $wecarry_file['error'],
            'size'     => $wecarry_file['size'],
        ];

        header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );

        $attach = $this->handle_upload( $upload );

        if ( $attach['success'] ) {
            $response = [ 'success' => true ];
	        wp_send_json_success([
	            'fileid' => $attach['attach_id'],
	            'fileurl' => wp_get_attachment_url( $attach['attach_id'] ),
	            'message' => __( 'Enquiry has been sent successfully!', 'wecarry' )
	        ]);
        } else {
            wp_send_json_error( [
                'message' => wp_kses_post( $attach['error'] )
            ] );
        }

        exit;
    }

    /**
     * Generic function to upload a file
     */
    public function handle_upload( $upload_data ) {

        $uploaded_file = wp_handle_upload( $upload_data, [ 'test_form' => false ] );

        // If the wp_handle_upload call returned a local path for the image
        if ( isset( $uploaded_file['file'] ) ) {
            $file_loc    = $uploaded_file['file'];
            $file_name   = basename( $upload_data['name'] );
            $upload_hash = md5( $upload_data['name'] . $upload_data['size'] );
            $file_type   = wp_check_filetype( $file_name );

            $attachment = [
                'post_mime_type' => $file_type['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
                'post_content'   => '',
                'post_status'    => 'inherit',
            ];

            $attach_id   = wp_insert_attachment( $attachment, $file_loc );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file_loc );
            wp_update_attachment_metadata( $attach_id, $attach_data );
           // update_post_meta( $attach_id, 'wpuf_file_hash', $upload_hash );

		   $my_post = array(
		      'ID'          => $attach_id,
		      'post_author' => get_current_user_id()
		    );
		    wp_update_post( $my_post );

            return [ 'success' => true, 'attach_id' => $attach_id ];
        }

        return [ 'success' => false, 'error' => $uploaded_file['error'] ];
    }

}

new Wecarry_Upload();