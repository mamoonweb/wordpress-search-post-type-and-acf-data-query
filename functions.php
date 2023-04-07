<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function dgt_custom_search_form(){
	ob_start();
	include('shortcodes/dgt_custom_search_form.php');
	return ob_get_clean();
}
add_shortcode('dgt_custom_search_form', 'dgt_custom_search_form');


function dgt_cc_search_result(){
	ob_start();
	include('shortcodes/search-result.php');
	return ob_get_clean();
}
add_shortcode('dgt_cc_search_result', 'dgt_cc_search_result');

// Agent Register
include('inc/agent-register.php');

// Logout register shortcode
function cc_logout() { 
 echo wp_logout_url( get_permalink() ); 
}
add_shortcode('cc_logout', 'cc_logout');

// Author Email Get shortcode
function cc_author_email_get() { 
	ob_start();
	$author_id = get_the_author_meta( 'ID' ); 
	$author_email = get_the_author_meta( 'email', $author_id ); 
	echo $author_email;
	return ob_get_clean();
}
add_shortcode('cc_author_email_get', 'cc_author_email_get');