<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.m-dev.net
 * @since      1.0.0
 *
 * @package    Wp_Cars
 * @subpackage Wp_Cars/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Cars
 * @subpackage Wp_Cars/public
 * @author     Maksim Petrenko <maksimgru@gmail.com>
 */
class Wp_Cars_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		define('AJAX_SECURITY_STRING', 'my-special-string');
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Cars_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Cars_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-cars-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Cars_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Cars_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-cars-public.js', array( 'jquery' ), $this->version, false );

		/* Localization custom_scripts */
		wp_localize_script(
			$this->plugin_name,
			'WPCARSAJAX',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'rest_url' => function_exists('rest_url') ? rest_url( 'wp/v2' ) : '',
				'ajax_error_message' => __('ERROR!!! Try again later or contact with site support administartor!!!', $this->plugin_name),
				'nonce'=> wp_create_nonce(AJAX_SECURITY_STRING)
			)
		);

	}

	/**
	 * Description: Handling of ajax request.
	 * action: myaction
	 * @return JSON STRING
	 */
	public function show_next_post() {
		check_ajax_referer( AJAX_SECURITY_STRING, 'security' );

		/* Set Vars */
		$args = array();
		$input = array();
		$response = array();

		/* Sanitize input data */
		foreach ($_POST as $key => $val) {
			$input[$key] = Wp_Cars::clean($val);
		}
		$input['currentPostID'] = array_key_exists('currentPostID', $input) ? $input['currentPostID'] : 0;

		/* Prepare default response */
		$response = array(
			'status' => false,
			'input' => $input,
			'html' => '',
			'currentPostID' => array(),
			'resmessage' => __('ERROR!!! Reload page and Try Again!!! If this does not help, contact with site Administrator!!!', $this->plugin_name),
		);

		// Get Cars post type (random only one)
		$args = array(
			'posts_per_page' => $input['numberPosts'],
			'ignore_sticky_posts' => true,
			'post_type' => 'cars',
			'orderby' => 'rand',
			'post__not_in' => explode(',', $input['currentPostID']),
		);
		$query = new WP_Query;
		$posts = $query->query($args);

		/* Error handling */
		if ( is_wp_error( $query ) || is_wp_error( $posts ) ) {
			$response['status'] = false;
			$response['resmessage'] = __('ERROR!!! Reload page and Try Again!!! If this does not help, contact with site Administrator!!!', $this->plugin_name);
			wp_send_json($response);
		}

		/* Success handling */
		$response['status'] = true;
		$response['resmessage'] = __('Success response!!!', $this->plugin_name);
		ob_start();
		foreach ($posts as $car) {
			setup_postdata($car);
			$postID = $car->ID;
			$response['currentPostID'][] = $car->ID;
			$file_path = plugin_dir_path( __FILE__ ) . 'partials/wp-cars-public-widget-content.php';
			if (file_exists($file_path)) {
				include $file_path;
			}
			else {
				_e('No file template exists!!!', $this->plugin_name);
			}
		}
		$response['currentPostID'] = implode(',', $response['currentPostID']);
		$response['html'] .= ob_get_clean();
		wp_reset_postdata();

		/* Send response */
		wp_send_json($response);
	}

}
