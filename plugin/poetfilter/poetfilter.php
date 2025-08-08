<?php
/*
   Plugin Name:  Poetfilter
   Plugin URI:
   Description:  Small plugin for filtering poets
   Version:      2.0.3
   Author:       lislis
   Author URI:   lislis.xyz
   Text Domain:  poetfilter
 */

define("POETFILTER_VERSION", '2.0.3');

function poetfilter_activate() {

  add_option( 'Activated_Plugin', 'poetfilter' );

  /* activation code here */
}
register_activation_hook( __FILE__, 'poetfilter_activate' );

function load_poet_plugin() {

  if ( is_admin() && get_option( 'Activated_Plugin' ) == 'poetfilter' ) {

    delete_option( 'Activated_Plugin' );

    /* do stuff once right after activation */

  }
}
add_action( 'admin_init', 'load_poet_plugin' );


/*
 * registering the JS
 * this is the compiled file from source/dist/
 * we're also filling a window object with info we need in the Vue app
 */
function poetfilter_register_script() {
    wp_register_script('poetfilter-script', plugin_dir_url(__DIR__) . 'poetfilter/index.js', array(), POETFILTER_VERSION, true);

    wp_enqueue_style( 'poetfilter-style', plugin_dir_url(__DIR__) . 'poetfilter/index.css', array(), POETFILTER_VERSION );


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
            'dataUrl' => get_option('poetfilter_csv_url'),
            'cols2Display' => explode(",", get_option('poetfilter_display_columns')),
            'cols2Filter' => explode(",", get_option('poetfilter_filter_columns')),
            'jobDict' => explode(",", get_option('poetfilter_job_names')),
        )
    );
    wp_enqueue_script('poetfilter-script');

}
add_action('wp_enqueue_scripts', 'poetfilter_register_script');


/*
 * registering the shortcode
 * (instead of eg a page template)
 * this just adds the container for the JS to the page
 */
function poetfilter_make_shortcode() {
    return '<div id="poetfilter"></div>';
}
add_shortcode('poetfilter', 'poetfilter_make_shortcode');

/*
 * registering the settings page and adding settings
 */

function poetfilter_settings_description() { ?>
    <p>Hier kommen der Link des Spreadsheets und die Namen der Spalten, die angezeigt werden sollen, rein.</p>
    <p>Die Spaltennamen müssen genau gleich geschrieben werden!</p>
<?php
}


function poetfilter_csv_url_display() { ?>
    <input type="text" name="poetfilter_csv_url" id="poetfilter_csv_url" value="<?php echo get_option('poetfilter_csv_url'); ?>" />
<?php
}

function poetfilter_filter_columns_display() { ?>
    <input type="text" name="poetfilter_filter_columns" id="poetfilter_filter_columns" value="<?php echo get_option('poetfilter_filter_columns'); ?>" />
<?php
}

function poetfilter_display_columns_display() { ?>
    <input type="text" name="poetfilter_display_columns" id="poetfilter_display_columns" value="<?php echo get_option('poetfilter_display_columns'); ?>" />
<?php
}

function poetfilter_job_names_display() { ?>
    <input type="text" name="poetfilter_job_names" id="poetfilter_job_names" value="<?php echo get_option('poetfilter_job_names'); ?>" />
<?php
        }


function poetfilter_settings() {
    add_settings_section( 'poetfilter_page', 'CSV Einstellungen',
                          'poetfilter_settings_description','poetfilter-settings');

    add_settings_field("poetfilter_csv_url", "Link zum CSV", "poetfilter_csv_url_display", "poetfilter-settings", "poetfilter_page");
    register_setting( 'poetfilter-settings-grp', 'poetfilter_csv_url');

    add_settings_field("poetfilter_filter_columns", "Spalten zum filtern (Komma separiert)", "poetfilter_filter_columns_display", "poetfilter-settings", "poetfilter_page");
    register_setting( 'poetfilter-settings-grp', 'poetfilter_filter_columns');

    add_settings_field("poetfilter_display_columns", "Spalten in Detailansicht (Komma separiert)", "poetfilter_display_columns_display", "poetfilter-settings", "poetfilter_page");
    register_setting( 'poetfilter-settings-grp', 'poetfilter_display_columns');

    add_settings_field("poetfilter_job_names", "'Buchbar als' Jobnamen (Format beachten!)", "poetfilter_job_names_display", "poetfilter-settings", "poetfilter_page");
    register_setting( 'poetfilter-settings-grp', 'poetfilter_job_names');
}
add_action('admin_init','poetfilter_settings');


function poetfilter_settings_page() {
    ?>
    <div class="wrap">
        <h1>Poetfilter</h1>

        <p>Um die Liste einzeigen zu lassen, füge diesen Shortcode auf einer Seite ein.</p>
        <pre><code>[poetfilter]</code></pre>
        <p>Alle Einstellungen sind global, das heißt, falls mehrere Listen angezeigt werden, verhalten sich alle gleich.</p>

        <form method="post" action="options.php">
            <?php
            settings_fields("poetfilter-settings-grp");
            do_settings_sections("poetfilter-settings");
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// registering the page
function poetfilter_settings_page_hook(){
    add_options_page('Poetfilter Einstellungen', 'Poetfilter', 'manage_options', 'poetfilter-settings-page', 'poetfilter_settings_page');
}

add_action('admin_menu','poetfilter_settings_page_hook');
