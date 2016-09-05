<?php
/**
 * 	Plugin Name: 	WordPress Functionality Plugin
 * 	Plugin URI: 	http://pinegrow.com
 * 	Description: 	Core WordPress customizations that are theme independent.
 * 	Author: 		Pinegrow Team
 * 	Author URI: 	http://pinegrow.com
 *
 *
 * 	Version: 		1.2
 * 	License: 		GPLv2
 *
 * Fork of Rick R. Duncan WordPress Functionality Plugin
 * https://gist.github.com/rickrduncan/2ffd0c25baefb7ac702b#file-wordpress-functionality-plugin-php
 *
 *  WordPress Functionality Plugin is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License, or
 *  any later version.
 *
 *  WordPress Functionality Plugin is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with WP Functional Plugin. If not, see <http://www.gnu.org/licenses/>.
 */


//* Remove 'Editor' from 'Appearance' Menu.
//* This stops users and hackers from being able to edit files from within WordPress.
define( 'DISALLOW_FILE_EDIT', true );


//* Add the ability to use shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );


//* Prevent WordPress from compressing images
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );


//* Disable any and all mention of emoji's
//* Source code credit: http://ottopress.com/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );


//* Remove items from the <head> section
remove_action( 'wp_head', 'wp_generator' );							//* Remove WP Version number
remove_action( 'wp_head', 'wlwmanifest_link' );						//* Remove wlwmanifest_link
remove_action( 'wp_head', 'rsd_link' );								//* Remove rsd_link
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );			//* Remove shortlink
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );	//* Remove previous/next post links


//* Limit the number of post revisions to keep
add_filter( 'wp_revisions_to_keep', 'pg_set_revision_max', 10, 2 );

if ( ! function_exists( 'pg_set_revision_max' ) ) :
function pg_set_revision_max( $num, $post ) {

    $num = 5; //change 5 to match your preferred number of revisions to keep
    return $num;

}
endif;

/** ---:[ place your custom code below this line ]:--- */

//* Login Screen: Change login logo
add_action( 'login_head', 'pg_custom_login_logo' );

if ( ! function_exists( 'pg_custom_login_logo' ) ) :
function pg_custom_login_logo() {
	echo '<style type="text/css">
    h1 a { background-image:url('.get_stylesheet_directory_uri().'/images/login-logo.png) !important; background-size: 156px 156px !important;height: 156px !important; width: 156px !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
    .login form { margin-top: 10px !important; }
    </style>';
}
endif;

//* Login Screen: Use your own URL for login logo link
add_filter( 'login_headerurl', 'pg_url_login' );

if ( ! function_exists( 'pg_url_login' ) ) :
function pg_url_login(){

	return get_bloginfo( 'wpurl' ); //This line keeps the link on current website instead of WordPress.org
}
endif;

//* Login Screen: Set 'remember me' to be checked
add_action( 'init', 'pg_login_checked_remember_me' );

if ( ! function_exists( 'pg_login_checked_remember_me' ) ) :
function pg_login_checked_remember_me() {

  add_filter( 'login_footer', 'pg_rememberme_checked' )
  ;
}
endif;

if ( ! function_exists( 'pg_rememberme_checked' ) ) :
function pg_rememberme_checked() {

  echo "<script>document.getElementById('rememberme').checked = true;</script>";

}
endif;


//* Login Screen: Don't inform user which piece of credential was incorrect
add_filter ( 'login_errors', 'pg_failed_login' );

if ( ! function_exists( 'pg_failed_login' ) ) :
function pg_failed_login () {

  return 'The login information you have entered is incorrect. Please try again.';

}
endif;


//* Modify the admin footer text
add_filter( 'admin_footer_text', 'pg_modify_footer_admin' );

if ( ! function_exists( 'pg_modify_footer_admin' ) ) :
function pg_modify_footer_admin () {

  echo '<span id="footer-thankyou">Theme Development by <a href="http://pinegrow.com" target="_blank">Pinegrow Web Editor</a></span>';

}
endif;


//* Add theme info box into WordPress Dashboard
add_action('wp_dashboard_setup', 'pg_add_dashboard_widgets' );

if ( ! function_exists( 'pg_add_dashboard_widgets' ) ) :
function pg_add_dashboard_widgets() {

  wp_add_dashboard_widget('wp_dashboard_widget', 'Theme Details', 'pg_theme_info');

}
endif;

if ( ! function_exists( 'pg_theme_info' ) ) :
function pg_theme_info() {

  echo "<ul>
  <li><strong>Developed By:</strong> Pinegrow Web Editor</li>
  <li><strong>Website:</strong> <a href='http://pinegrow.com'>pinegrow.com</a></li>
  <li><strong>Contact:</strong> <a href='mailto:support@pinegrow.com'>support@pinegrow.com</a></li>
  </ul>";

}
endif;


//* Add Custom Post Types to Tags and Categories in WordPress
//* https://premium.wpmudev.org/blog/add-custom-post-types-to-tags-and-categories-in-wordpress/
//* If you’d like to add only specific post types to listings of tags and categories you can replace the line:
//* $post_types = get_post_types();
//* with
//* $post_types = array( 'post', 'your_custom_type' );

if ( ! function_exists( 'pg_set_add_custom_types_to_tax' ) ) :
function pg_set_add_custom_types_to_tax( $query ) {
if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {

//* Get all your post types
$post_types = get_post_types();

$query->set( 'post_type', $post_types );
return $query;
}
}
endif;

add_filter( 'pre_get_posts', 'pg_set_add_custom_types_to_tax' );

//* Remove Jetpack Sharing Buttons to appear in Excerpts
//* https://wordpress.org/support/topic/sharing-icons-show-after-excerpt-and-content

if ( ! function_exists( 'pg_jptweak_remove_exshare' ) ) :
function pg_jptweak_remove_exshare() {
	remove_filter( 'the_excerpt', 'sharing_display',19 );
}
endif;

add_action( 'loop_end', 'pg_jptweak_remove_exshare' );

//* Relevanssi Search Shortcode
//* invoke the search form with [search_form].
add_shortcode('search_form', 'pg_rlv_search_form');

if ( ! function_exists( 'pg_rlv_search_form' ) ) :
function pg_rlv_search_form() {
$url = get_site_url();
$form = <<<EOH
<form role="search" method="get" id="searchform" class="searchform" action="$url">
<label class="screen-reader-text" for="s">Search for:</label>
<input type="text" value="" name="s" id="s" />
<input type="submit" id="searchsubmit" value="Search" />
</form>
EOH;
return $form;
}
endif;


//* Jetpack Social menu
//* https://themeshaper.com/2016/02/12/jetpack-social-menu/
//* https://jetpack.com/support/social-menu/

if ( ! function_exists( 'pg_jetpackme_social_menu' ) ) :
 function pg_jetpackme_social_menu() {
     if ( ! function_exists( 'pg_jetpackme_social_menu' ) ) {
         return;
     } else {
         jetpack_social_menu();
     }
 }
endif;


 //* Change Jetpack Related Post Headline
//* https://jetpack.com/support/related-posts/customize-related-posts/#headline

if ( ! function_exists( 'pg_jetpackme_related_posts_headline' ) ) :
function pg_jetpackme_related_posts_headline( $headline ) {
$headline = sprintf(
'<h3 class="jp-relatedposts-headline"><strong>%s</strong></h3>',
esc_html( 'Similar Stuff Going On' )//change your headline here
);
return $headline;
}
endif;

add_filter( 'jetpack_relatedposts_filter_headline', 'pg_jetpackme_related_posts_headline' );

//* Remove the Related Posts from your posts
//* https://jetpack.com/support/related-posts/customize-related-posts/

if ( ! function_exists( 'pg_jetpackme_remove_rp' ) ) :
function pg_jetpackme_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'the_content', $callback, 40 );
    }
}
endif;

add_filter( 'wp', 'pg_jetpackme_remove_rp', 20 );


//* Add background color button in TinyMCE Editor
//* https://shellcreeper.com/how-to-add-background-color-highlight-option-in-wordpress-editor-tinymce/

//* Hook to init Background Color Button in TinyMCE Editor */
add_action( 'init', 'pg_my_editor_background_color' );

//* Add TinyMCE Button

function pg_my_editor_background_color(){

//* Add the button/option in second row */
    add_filter( 'mce_buttons_2', 'pg_my_editor_background_color_button', 1, 2 ); // 2nd row
}


//* Modify 2nd Row in TinyMCE and Add Background Color After Text Color Option
function pg_my_editor_background_color_button( $buttons, $id ){

    /* Only add this for content editor, you can remove this line to activate in all editor instance */
    if ( 'content' != $id ) return $buttons;

    /* Add the button/option after 4th item */
    array_splice( $buttons, 4, 0, 'backcolor' );

    return $buttons;
}


//* MORE MISC USEFUL SNIPPETS //

//* Use Related Posts with Custom Post Types
//* https://jetpack.com/support/related-posts/customize-related-posts/#related-posts-custom-post-types
// function allow_my_post_types($allowed_post_types) {
//     $allowed_post_types[] = 'your-post-type';
//     return $allowed_post_types;
// }
// add_filter( 'rest_api_allowed_post_types', 'allow_my_post_types' );


/* Prevent Page Scroll When Clicking the More Link */

// function remove_more_link_scroll( $link ) {
// 	$link = preg_replace( '|#more-[0-9]+|', '', $link );
// 	return $link;
// }
// add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

/*  Change excerpt length */
/*  By default the excerpt length is set to return 55 words */

// function custom_excerpt_length( $length ) {
// 	return 30;
// }
// add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/* Displaying a "more…" link when using the the_excerpt() */

// function new_excerpt_more($more) {
//        global $post;
// 	return '<br><br><a class="more-link" href="'. get_permalink($post->ID) . '">Read More</a>';
// }
// add_filter('excerpt_more', 'new_excerpt_more');
