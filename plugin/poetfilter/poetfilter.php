<?php
/*
   Plugin Name:  Poetfilter
   Plugin URI:
   Description:  Small plugin for filtering poets
   Version:      1.0
   Author:       lislis
   Author URI:   lislis.xyz
   Text Domain:  poetfilter
 */

function my_plugin_activate() {

  add_option( 'Activated_Plugin', 'poetfilter' );

  /* activation code here */
}
register_activation_hook( __FILE__, 'my_plugin_activate' );

function load_poet_plugin() {

  if ( is_admin() && get_option( 'Activated_Plugin' ) == 'poetfilter' ) {

    delete_option( 'Activated_Plugin' );

    /* do stuff once right after activation */

  }
}
add_action( 'admin_init', 'load_poet_plugin' );

function poetfilter_register_script() {
    // registering the JS file
    wp_register_script('poetfilter-script', plugin_dir_url(__DIR__) . 'poetfilter/index.js', array(), '0.1.0', true);

    global $post;
    // and add globals
    wp_localize_script(
        'poetfilter-script',
        'poetfilterData',
        array(
            'template_directory_uri' => get_stylesheet_directory_uri(), // child theme directory path.
            'rest_url' => untrailingslashit( esc_url_raw( rest_url() ) ),
            'plugin_url' => plugin_dir_url( __DIR__ ),
            'app_path' => $post->post_name,
            'custom' => "foobar",
            'dataUrl' => 'http://localhost:5173/data/alphas20241211.csv',
            'cols2Display' => array('name', 'city', 'country', 'website', 'facebook', 'alpha', 'pronouns', 'instagram', 'twitter', 'tiktok'),
            'cols2Filter' => array("name", "city", "instagram"),
        )
    );
    wp_enqueue_script('poetfilter-script');

}
add_action('wp_enqueue_scripts', 'poetfilter_register_script');


function poetfilter_make_shortcode() {

    return 'this works <br><div id="poetfilter"></div>';
}
add_shortcode('poetfilter', 'poetfilter_make_shortcode');
