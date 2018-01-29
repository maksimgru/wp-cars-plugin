<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.m-dev.net
 * @since      1.0.0
 *
 * @package    Wp_Cars
 * @subpackage Wp_Cars/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Cars
 * @subpackage Wp_Cars/admin
 * @author     Maksim Petrenko <maksimgru@gmail.com>
 */
class Wp_Cars_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-cars-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-cars-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register Custom Post Type
	 */
	public function register_custom_post_type () {
		$labels = array(
			'name' => _x('Cars', 'name of post type'),
			'singular_name' => _x('Car', 'name of post type'),
			'add_new' => _x('Add new car', 'project'),
			'add_new_item' => __('Add new car'),
			'edit_item' => __('Edit car'),
			'new_item' => __('New car'),
			'view_item' => __('View car'),
			'search_items' => __('Search cars'),
			'not_found' =>  __('Cars is not found'),
			'not_found_in_trash' => __('Cars is not found in trash'),
			'parent_item_colon' => '',
			'menu_name' => 'Cars'
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'post-formats')
		);

		register_post_type('cars', $args);
	}

	/**
	 * Register Custom Widgets
	 */
	public function register_custom_widget() {
		register_widget( 'Wp_Cars_Widget' ); // name of our Widget Class
	}

}
