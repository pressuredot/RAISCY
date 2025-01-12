<?php
/**
 * Theme functions and definitions
 *
 * @package Bosa AI Robotics 1.0.0
 */

require get_stylesheet_directory() . '/inc/customizer/customizer.php';
require get_stylesheet_directory() . '/inc/customizer/loader.php';

if ( ! function_exists( 'bosa_ai_robotics_enqueue_styles' ) ) :
	/**
	 * @since Bosa AI Robotics 1.0.0
	 */
	function bosa_ai_robotics_enqueue_styles() {
        require_once get_theme_file_path ( 'inc/wptt-webfont-loader.php');

		wp_enqueue_style( 'bosa-ai-robotics-style-parent', get_template_directory_uri() . '/style.css',
			array(
				'bootstrap',
				'slick',
				'slicknav',
				'slick-theme',
				'fontawesome',
				'bosa-blocks',
				'bosa-google-font'
				)
		);

	    wp_enqueue_style(
            'bosa-ai-robotics-google-fonts',
            wptt_get_webfont_url( "https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" ),
            false
        );

        wp_enqueue_style(
            'bosa-ai-robotics-google-fonts-two',
            wptt_get_webfont_url( "https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" ),
            false
        );

	}

endif;
add_action( 'wp_enqueue_scripts', 'bosa_ai_robotics_enqueue_styles', 10 );

/**
 * Registers menu location. 
 * @since Bosa AI Robotics 1.0.0
 */
function bosa_ai_robotics_menu_register(){
    register_nav_menu(
        'menu-4', esc_html__( 'Category Menu', 'bosa-ai-robotics' )
    );
}
add_action( 'after_setup_theme', 'bosa_ai_robotics_menu_register' );

/**
 * Custom Post Type for Applications
 */
function create_application_cpt() {

    $labels = array(
        'name'                  => _x('Applications', 'Post Type General Name', 'bosa-ai-robotics'),
        'singular_name'         => _x('Application', 'Post Type Singular Name', 'bosa-ai-robotics'),
        'menu_name'             => __('Applications', 'bosa-ai-robotics'),
        'all_items'             => __('All Applications', 'bosa-ai-robotics'),
        'add_new_item'          => __('Add New Application', 'bosa-ai-robotics'),
        'edit_item'             => __('Edit Application', 'bosa-ai-robotics'),
        'new_item'              => __('New Application', 'bosa-ai-robotics'),
        'view_item'             => __('View Application', 'bosa-ai-robotics'),
        'search_items'          => __('Search Applications', 'bosa-ai-robotics'),
    );

    $args = array(
        'label'                 => __('Application', 'bosa-ai-robotics'),
        'description'           => __('Post type for managing applications', 'bosa-ai-robotics'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'custom-fields'),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-clipboard',
        'has_archive'           => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('application', $args);
}
add_action('init', 'create_application_cpt');

/**
 * Add Meta Box for Applications
 */
function application_meta_box() {
    add_meta_box(
        'application_details',
        'Application Details',
        'application_meta_box_callback',
        'application',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'application_meta_box');

function application_meta_box_callback($post) {
    $mobile = get_post_meta($post->ID, 'application_mobile', true);
    $vat_number = get_post_meta($post->ID, 'application_vat', true);
    $topic = get_post_meta($post->ID, 'application_topic', true);

    echo '<label for="application_mobile">Mobile:</label>';
    echo '<input type="text" id="application_mobile" name="application_mobile" value="' . esc_attr($mobile) . '" size="25" /><br>';
    echo '<label for="application_vat">VAT Number:</label>';
    echo '<input type="text" id="application_vat" name="application_vat" value="' . esc_attr($vat_number) . '" size="25" /><br>';
    echo '<label for="application_topic">Topic:</label>';
    echo '<input type="text" id="application_topic" name="application_topic" value="' . esc_attr($topic) . '" size="25" /><br>';
}

/**
 * Save Meta Box Data
 */
function save_application_meta_box_data($post_id) {
    if (array_key_exists('application_mobile', $_POST)) {
        update_post_meta($post_id, 'application_mobile', sanitize_text_field($_POST['application_mobile']));
    }
    if (array_key_exists('application_vat', $_POST)) {
        update_post_meta($post_id, 'application_vat', sanitize_text_field($_POST['application_vat']));
    }
    if (array_key_exists('application_topic', $_POST)) {
        update_post_meta($post_id, 'application_topic', sanitize_text_field($_POST['application_topic']));
    }
}
add_action('save_post', 'save_application_meta_box_data');
