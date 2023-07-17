<?php

/*
Plugin Name: Oxy Math
Author: Renato Corluka
Author URI: https://recoda.me
Description: Easy Peasy Calculations inside Oxygen Builder
Version: 1.0.0
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action('plugins_loaded', 'oxymath_elements_init');

function oxymath_elements_init()
{

    if (!class_exists('OxygenElement')) {
        return;
    }

    foreach (glob(plugin_dir_path(__FILE__) . "elements/*.php") as $filename) {
        include $filename;
    }
    //add_action( 'oxygen_enqueue_frontend_scripts', 'custom_enqueue_assets' );

    add_action('oxygen_enqueue_scripts', 'oxymath_enqueue_assets');
    /**
     * Load assets on front end only.
     */
    function oxymath_enqueue_assets()
    {
        // if ( ! is_admin() && ! defined( 'SHOW_CT_BUILDER' ) ) {
            wp_enqueue_script('oxymath', plugin_dir_url(__FILE__) . 'frontendscripts/oxymath.js');
    }
}
