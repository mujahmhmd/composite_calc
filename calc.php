<?php
/*
Plugin Name: Compound Calculator
Description: Easily integrate powerful compound interest calculations directly into your WordPress website with our Compound Calculator plugin. Whether you're a financial blogger, investment advisor, or simply want to provide valuable financial tools to your visitors, this plugin offers a user-friendly solution. The shortcode is [compound_calc]
Version: 1.0
Author: Exline Labs
Author URI: https://exlinelabs.com
*/


if (!defined('ABSPATH')) {
    exit;
}

define('CALC_DIR', __DIR__);
define('CALC_FILE', __FILE__);
define('CALC_PATH', dirname(CALC_FILE));

function enqueue_calculator_assets() {
    wp_enqueue_style('calculator-style-tailwind', plugin_dir_url(__FILE__) . 'style.css');
    // Enqueue the JavaScript file
    wp_enqueue_script('calculator-script', plugin_dir_url(__FILE__) . './src/script.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_calculator_assets');



// Shortcode callback function
function composite_calculator()
{
    ob_start();
    ?>
        <?php require_once CALC_PATH . '/template/body.php'; ?>
    <?php
    return ob_get_clean();
}
add_shortcode('compound_calc', 'composite_calculator');