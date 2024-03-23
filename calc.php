<?php
/*
Plugin Name: Composite Calc
Description: ExlineLabs Composite Calculator Plugin Project. the shortcode is [composite_calc]
Version: 1.0
Author: Mujahith MhMd
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CALC_DIR', __DIR__ );
define( 'CALC_FILE', __FILE__ );
define( 'CALC_PATH', dirname( CALC_FILE ) );

// Enqueue scripts and styles
function enqueue_vue_plugin_scripts() {
    // Enqueue Tailwind CSS
    wp_enqueue_style('tailwindcss', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_vue_plugin_scripts');

// Shortcode callback function
function my_vue_plugin_shortcode() {
    ob_start();
    ?>

<?php require_once CALC_PATH . '/template/header.php'?>
<?php require_once CALC_PATH . '/template/body.php' ?>
<?php require_once CALC_PATH . '/template/footer.php' ?>

    <?php
    return ob_get_clean();
}
add_shortcode('composite_calc', 'my_vue_plugin_shortcode');