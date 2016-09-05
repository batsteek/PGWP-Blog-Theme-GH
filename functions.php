<?php
if ( ! function_exists( 'pg_blog_setup' ) ) :

function pg_blog_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    /* Pinegrow generated Load Text Domain Begin */
    load_theme_textdomain( 'pg_blog', get_template_directory() . '/languages' );
    /* Pinegrow generated Load Text Domain End */

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 825, 510, true );

    // Add menus.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'pg_blog' ),
        'social'  => __( 'Social Links Menu', 'pg_blog' ),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
     * Enable support for Post Formats.
     */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ) );
}
endif; // pg_blog_setup

add_action( 'after_setup_theme', 'pg_blog_setup' );


if ( ! function_exists( 'pg_blog_init' ) ) :

function pg_blog_init() {


    // Use categories and tags with attachments
    register_taxonomy_for_object_type( 'category', 'attachment' );
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );

    /*
     * Register custom post types. You can also move this code to a plugin.
     */
    /* Pinegrow generated Custom Post Types Begin */

    /* Pinegrow generated Custom Post Types End */

    /*
     * Register custom taxonomies. You can also move this code to a plugin.
     */
    /* Pinegrow generated Taxonomies Begin */

    /* Pinegrow generated Taxonomies End */

}
endif; // pg_blog_setup

add_action( 'init', 'pg_blog_init' );


if ( ! function_exists( 'pg_blog_widgets_init' ) ) :

function pg_blog_widgets_init() {

    /*
     * Register widget areas.
     */
    /* Pinegrow generated Register Sidebars Begin */

    /* Pinegrow generated Register Sidebars End */
}
add_action( 'widgets_init', 'pg_blog_widgets_init' );
endif;// pg_blog_widgets_init



if ( ! function_exists( 'pg_blog_customize_register' ) ) :

function pg_blog_customize_register( $wp_customize ) {
    // Do stuff with $wp_customize, the WP_Customize_Manager object.

    /* Pinegrow generated Customizer Controls Begin */

    /* Pinegrow generated Customizer Controls End */

}
add_action( 'customize_register', 'pg_blog_customize_register' );
endif;// pg_blog_customize_register


if ( ! function_exists( 'pg_blog_enqueue_scripts' ) ) :
    function pg_blog_enqueue_scripts() {

        /* Pinegrow generated Enqueue Scripts Begin */

    /* Pinegrow generated Enqueue Scripts End */

        /* Pinegrow generated Enqueue Styles Begin */

    wp_deregister_style( 'style' );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/css/style.css', false, null, 'all');

    wp_deregister_style( 'wp_core' );
    wp_enqueue_style( 'wp_core', get_template_directory_uri() . '/css/wp_core.css', false, null, 'all');

    wp_deregister_style( 'fontawesome' );
    wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css', false, null, 'all');

    wp_deregister_style( 'social_icons' );
    wp_enqueue_style( 'social_icons', get_template_directory_uri() . '/css/social_icons.css', false, null, 'all');

    /* Pinegrow generated Enqueue Styles End */

    }
    add_action( 'wp_enqueue_scripts', 'pg_blog_enqueue_scripts' );
endif;

/*
 * Resource files included by Pinegrow.
 */
/* Pinegrow generated Include Resources Begin */

    /* Pinegrow generated Include Resources End */

    // Change the default image settings
    // http://writenowdesign.com/blog/wordpress/wordpress-how-to/change-wordpress-default-image-alignment-link-type/

    add_action( 'after_setup_theme', 'pg_blog_default_image_settings' );

    function pg_blog_default_image_settings() {
        update_option( 'image_default_align', 'center' );
        update_option( 'image_default_link_type', 'none' );
        update_option( 'image_default_size', 'large' );
    }

    // Set Theme Content Width http://codex.wordpress.org/Content_Width //

    if ( ! isset( $content_width ) )
    $content_width = 880;

    // Theme Support for WordPress Custom Backgrounds
    // https://codex.wordpress.org/Custom_Backgrounds

    $custombackground_defaults = array(
    	'default-color'          => '',
    	'default-image'          => '',
    	'default-repeat'         => '',
    	'default-position-x'     => '',
    	'default-attachment'     => '',
      'default-size'           => 'cover',
    	'wp-head-callback'       => '_custom_background_cb',
    	'admin-head-callback'    => '',
    	'admin-preview-callback' => ''
    );
    add_theme_support( 'custom-background', $custombackground_defaults );

    // Theme Support for WordPress Custom Headers
    // https://codex.wordpress.org/Custom_Headers

    $customheader_defaults = array(
    	'default-image'          => '',
    	'width'                  => 1600,
    	'height'                 => 900,
    	'flex-height'            => false,
    	'flex-width'             => false,
    	'uploads'                => true,
    	'random-default'         => false,
    	'header-text'            => false,
    	'default-text-color'     => '',
    	'wp-head-callback'       => '',
    	'admin-head-callback'    => '',
    	'admin-preview-callback' => '',
    );
    add_theme_support( 'custom-header', $customheader_defaults );

    // Add Custom Logo Support
    // http://www.mavengang.com/2016/06/02/change-wordpress-custom-logo-class/

    function pg_starter_custom_logo_setup() {

    add_theme_support( 'custom-logo', array(
    	'height'      => 120,
    	'width'       => 120,
    	'flex-height' => true,
    	'flex-width'  => true,
    	// 'header-text' => array( 'site-title', 'site-description' ),
    ) );

    }
    add_action( 'after_setup_theme', 'pg_starter_custom_logo_setup' );

    // Bootstrap navbar with wordpress custom logo
    // http://www.mavengang.com/2016/06/02/change-wordpress-custom-logo-class/

    function pg_starter_the_custom_logo() {

    	if ( function_exists( 'the_custom_logo' ) ) {
    		the_custom_logo();
    	}

    }

// Add class to links generated by WordPress “next_post_link” and “previous_post_link” functions
// http://justinklemm.com/add-class-to-wordpress-next_post_link-and-previous_post_link-links/

    add_filter('next_post_link', 'post_link_attributes');
    add_filter('previous_post_link', 'post_link_attributes');

    function post_link_attributes($output) {
        $code = 'class="big-button post-navigation-link"';
        return str_replace('<a href=', '<a '.$code.' href=', $output);
    }

// Add class to links generated by next_posts_link and previous_posts_link
https://css-tricks.com/snippets/wordpress/add-class-to-links-generated-by-next_posts_link-and-previous_posts_link/

    add_filter('next_posts_link_attributes', 'posts_link_attributes');
    add_filter('previous_posts_link_attributes', 'posts_link_attributes');

    function posts_link_attributes() {
        return 'class="posts-navigation-link"';
    }

// IMAGES MANIPULATIONS //

// Set JPEG Compression Quality for Thumbnails
add_filter( 'jpeg_quality', create_function( '', 'return 80;' ) );

// 1200 pixels wide by 675 pixels tall, hard crop mode
add_image_size( 'pgblog-header', 1200, 675, true );

// 782 pixels wide by resizing the image proportionally (without distorting it)
add_image_size( 'pgblog-index', 782 );


// New Image Sizes in Media Selector
// https://wpthememakeover.com/2015/01/29/how-to-add-custom-image-sizes-to-the-wordpress-media-library/

function pg_blog_custom_sizes( $sizes ) {
  return array_merge( $sizes, array(
    'pgblog-index' => __( 'Medium Size for Blog Posts' ),
  ) );
}
add_filter( 'image_size_names_choose', 'pg_blog_custom_sizes' );

// SHORTCODES

// Function to add a blog divider to posts and pages

  function pg_blog_divider_shortcode() {
    return '<div class="blog-divider"></div>';
}
add_shortcode('divider', 'pg_blog_divider_shortcode');


// Remove Default wp-embed
// or use https://wordpress.org/plugins/disable-embeds/

function pg_blog_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'pg_blog_deregister_scripts' );

// Filter to replace the [caption] shortcode text with HTML5 compliant code
// @return text HTML content describing embedded figure
// http://wordpress.stackexchange.com/questions/107358/make-wordpress-image-captions-responsive
// https://developer.wordpress.org/reference/functions/add_filter/#Example

add_filter('img_caption_shortcode', 'pg_blog_img_caption_shortcode_filter',10,3);

function pg_blog_img_caption_shortcode_filter($val, $attr, $content = null)
{
    extract(shortcode_atts(array(
        'id'    => '',
        'align' => '',
        'width' => '',
        'caption' => ''
    ), $attr));

    if ( 1 > (int) $width || empty($caption) )
        return $val;

    $capid = '';
    if ( $id ) {
        $id = esc_attr($id);
        $capid = 'id="figcaption_'. $id . '" ';
        $id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
    }

    return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >'
    . do_shortcode( $content ) . '<figcaption ' . $capid
    . 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
}

// https://premium.wpmudev.org/blog/enable-or-disable-all-html-tags-in-wordpress-author-biography-profiles/
//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter('pre_user_description', 'wp_filter_kses');

//add sanitization for WordPress posts
add_filter( 'pre_user_description', 'wp_filter_post_kses');
