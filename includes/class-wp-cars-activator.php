<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.m-dev.net
 * @since      1.0.0
 *
 * @package    Wp_Cars
 * @subpackage Wp_Cars/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Cars
 * @subpackage Wp_Cars/includes
 * @author     Maksim Petrenko <maksimgru@gmail.com>
 */
class Wp_Cars_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::insert_demo_data();
		flush_rewrite_rules();
	}

	/**
	 * Return Mock data to insert demo content
	 */
	private static function get_demo_data() {
		return array(
			array(
				'title' => 'Audi',
				'description' => 'This is demo audi car description',
				'engine' => '1.9 L',
				'body_type' => 'sedan',
				'number_doors' => '4',
				'year' => '1999',
				'image' =>  plugins_url( 'images/audi.jpg' , dirname(__FILE__) ),
			),
			array(
				'title' => 'BMW',
				'description' => 'This is demo bmw car description',
				'engine' => '2.0',
				'body_type' => 'hatchback',
				'number_doors' => '5',
				'year' => '2005',
				'image' =>  plugins_url( 'images/bmw.jpg' , dirname(__FILE__) ),
			),
			array(
				'title' => 'Opel',
				'description' => 'This is demo opel car description',
				'engine' => '1.4 L',
				'body_type' => 'sedan',
				'number_doors' => '4',
				'year' => '2007',
				'image' => plugins_url( 'images/opel.jpg' , dirname(__FILE__) ),
			),
		);
	}

	/**
	 * Insert Demo content
	 */
	private static function insert_demo_data() {
		$plugin_options = Wp_Cars::get_options();
		$demo_data = self::get_demo_data();
		$is_install_demo_content = (array_key_exists('is_install_demo_content', $plugin_options) && '1' === $plugin_options['is_install_demo_content']);

		if (!$is_install_demo_content) {
			foreach ($demo_data as $car) {
				$car_data = array(
					'post_title'    => $car['title'],
					'post_content'  => $car['description'],
					'post_status'   => 'publish',
					'post_type'     => 'cars',
					'post_author'   => wp_get_current_user()->ID,
					'meta_input'     => array(
						'engine' => $car['engine'],
						'body_type' => $car['body_type'],
						'number_doors' => $car['number_doors'],
						'year' => $car['year'],
					),
				);
				$car_id = wp_insert_post( $car_data, true );
				if ( is_wp_error($car_id) ){
					echo $car_id->get_error_message();
				}
				else {
					self::wp_sideload_image($car_id, $car['image'], $car['title']);
				}
			}
			$plugin_options['is_install_demo_content'] = 1;
			Wp_Cars::update_options($plugin_options);
		}
	}

	/**
	 * Description: Handler for uploads files to server and register its in WP media library.
	 * @param INT $post_id ID of the post to which you want to attach the file after download.
	 * @param ARRAY $file An array with file data is the same as $ _FILES.
	 * @param STRING $desc Description of the downloaded file. It becomes the value of the post_title field in wp_posts.
	 * @return INT | STRING | WP_ERROR attachment ID or debug message or WP_ERROR object
	 */
	private static function wp_sideload_image( $post_id, $file, $desc = null ){
		global $debug; // is defined outside the function

		if (!$post_id || !$file) {return new WP_Error();}

		if ( ! function_exists('media_handle_sideload') ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}

		// download file in temporary dir
		$tmp = download_url( $file );

		// set the variables for location
		preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $file, $matches );
		$file_array['name'] = basename( $matches[0] );
		$file_array['tmp_name'] = $tmp;

		// if error then delete temporary file
		if ( is_wp_error( $tmp ) ) {
			@unlink( $file_array['tmp_name'] );
			$file_array['tmp_name'] = '';
			if ( $debug ) {echo 'Error! No Temp downloaded file! <br />';}
			return $tmp;
		}

		// debug info
		if ( $debug ) {
			echo 'File array: <br />';
			var_dump( $file_array );
			echo '<br /> Post id: ' . $post_id . '<br />';
		}

		// Start upload handler in WP Media Library
		$attachment_id = media_handle_sideload( $file_array, $post_id, $desc );

		// handle errors
		if ( is_wp_error( $attachment_id ) ) {
			@unlink($file_array['tmp_name']);
			if ( $debug ) {var_dump( $attachment_id->get_error_messages() );}
		} else {
			update_post_meta( $post_id, '_thumbnail_id', $attachment_id );
		}

		// delete temporary file
		@unlink( $file_array['tmp_name'] );

		return $attachment_id;
	}

}
