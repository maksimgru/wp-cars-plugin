<?php

/**
 * Define the widget functionality.
 *
 * Register and defines the widget for this plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Define the widget functionality.
 *
 * Register and defines the widget for this plugin.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Wp_Cars_Test_Widget extends WP_Widget {

	/*
    * Description: Constructor of MY Widget
    *
    */
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'wp-cars-test-widget',
			'description' => __('Description of this WP CARS Widget', $this->get_widget_textdomain()),
		);

		$control_ops = array(
			'width' => 200,
			'height' => 350,
			'id_base' => 'wp-cars-test-widget'
		);

		$this->WP_Widget( 'wp-cars-test-widget', __('WP CARS WIDGET', $this->get_widget_textdomain()), $widget_ops, $control_ops );
	}







	/*
    * Description: Textdomain string of this empty Widget
    *
    */
	function get_widget_textdomain() {
		return 'wp-cars-test';
	}





	/*
    * Description: Output Widget
    *
    */
	function widget( $args, $instance ) {
		extract( $args );

		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$description = $instance['description'];
		$number_posts = $instance['number_posts'] ? $instance['number_posts'] : 1;

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

		if ( $description ) echo '<div class="widget-description">' . $description . '</div>';
?>
				<div class="car-content-wrapper"></div>
				<button class="btn show-next-car"
					data-current-post-id=""
					data-target=".car-content-wrapper"
					data-number-posts="<?php echo $number_posts; ?>">
					<?php _e('Show Next Car', 'plugin-name'); ?>
				</button>
<?php

		echo $after_widget;
	}




	/*
    * Description: Update Widget
    *
    */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Strip tags from title and name to remove HTML
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['description'] = sanitize_text_field( $new_instance['description'] );
		$instance['number_posts'] = (int)$new_instance['number_posts'];

		return $instance;
	}





	/*
    * Description: Form for widget's options
    *
    */
	function form( $instance ) {

		// Set up some default widget settings.
		$defaults = array(
			'title' => 'WP Cars Test Widget',
			'description' => 'Description of this widget',
			'number_posts' => '1',
		);

		// Extend default widget settings
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

		<div class="title">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title:', $this->get_widget_textdomain()); ?></label>
			<br/>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>"
				value="<?php echo esc_attr($instance['title']); ?>" />
			<br/>
			<br/>
		</div>

		<div class="description">
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Widget Description:', $this->get_widget_textdomain()); ?></label>
			<br/>
			<textarea id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo esc_attr($instance['description']); ?></textarea>
			<br/>
			<br/>
		</div>

		<div class="number-posts">
			<label for="<?php echo $this->get_field_id( 'number_posts' ); ?>"><?php _e('Number Cars To Display:', $this->get_widget_textdomain()); ?></label>
			<br/>
			<input id="<?php echo $this->get_field_id( 'number_posts' ); ?>"
				type="number"
				min="1"
				name="<?php echo $this->get_field_name( 'number_posts' ); ?>"
				value="<?php echo esc_attr($instance['number_posts']); ?>" />
			<br/>
			<br/>
		</div>
<?php
	}

} //end of CLASS
