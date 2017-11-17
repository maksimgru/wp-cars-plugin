<?php

/**
 * Provide a public-facing Widget view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.m-dev.net
 * @since      1.0.0
 *
 * @package    Wp_Cars_Test
 * @subpackage Wp_Cars_Test/public/partials
 */
?>

<div class="car-content">
    <div class="car-image"><?php echo get_the_post_thumbnail($postID, 'medium'); ?></div>
    <div class="car-title"><?php echo get_the_title($postID); ?></div>
    <div class="car-description"><?php the_content(); ?></div>
    <div class="car-meta">
        <ul>
            <li>
                <span class="meta-label"><?php _e('Engine:', 'plugin-name'); ?></span>
                <span class="meta-value"><?php echo get_post_meta($postID, 'engine', true); ?></span>
            </li>
            <li>
                <span class="meta-label"><?php _e('Body Type:', 'plugin-name'); ?></span>
                <span class="meta-value"><?php echo get_post_meta($postID, 'body_type', true); ?></span>
            </li>
            <li>
                <span class="meta-label"><?php _e('Number Doors:', 'plugin-name'); ?></span>
                <span class="meta-value"><?php echo get_post_meta($postID, 'number_doors', true); ?></span>
            </li>
            <li>
                <span class="meta-label"><?php _e('Year:', 'plugin-name'); ?></span>
                <span class="meta-value"><?php echo get_post_meta($postID, 'year', true); ?></span>
            </li>
        </ul>
    </div>
</div>