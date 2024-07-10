<?php 
/**
 *Plugin Name: RSElements Lite
 * Description: <a href="https://rstheme.com/products/wordpress/plugins/elementor/">RS Elementor Addon</a> is the most advanced frontend drag & drop page builder addon. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design as like you want.
 * Plugin URI:  https://wordpress.org/plugins/rselements-lite/
 * Version:     1.1.5
 * Author:      rs-theme
 * Author URI:  https://rstheme.com/
 * Text Domain: rsaddon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'RSADDON_DIR_PATH_LITE', plugin_dir_path( __FILE__ ) );
define( 'RSADDON_DIR_URL_LITE', plugin_dir_url( __FILE__ ) );
define( 'RSADDON_ASSETS_LITE', trailingslashit( RSADDON_DIR_URL_LITE . 'assets' ) );



require RSADDON_DIR_PATH_LITE . 'base.php';
require RSADDON_DIR_PATH_LITE . 'post-type/post-type.php';

add_image_size( 'rsaddon-team-round-style', 500, 500, true );