<?php

/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0');
define('HELLO_ELEMENTOR_CHILD_PREFIX', 'tgores');

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function tgores_scripts_styles()
{

	wp_enqueue_style(
		'bootstrap',
		get_stylesheet_directory_uri() . '/assets/css/app.css',
		[],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

	wp_enqueue_style(
		HELLO_ELEMENTOR_CHILD_PREFIX . '-google-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
		[],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

	wp_enqueue_style(
		HELLO_ELEMENTOR_CHILD_PREFIX . '-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			HELLO_ELEMENTOR_CHILD_PREFIX . '-google-fonts',
			'bootstrap'
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

	wp_enqueue_script(
		HELLO_ELEMENTOR_CHILD_PREFIX . '-functions',
		get_stylesheet_directory_uri() . '/assets/js/app.min.js',
		[
			'jquery'
		],
		HELLO_ELEMENTOR_CHILD_VERSION,
		true
	);
}
add_action('wp_enqueue_scripts', 'tgores_scripts_styles', 20);

function tgores_theme_setup()
{
	load_child_theme_textdomain('tgores', get_stylesheet_directory() . '/languages');
}

add_action('after_setup_theme', 'tgores_theme_setup');

function tgores_disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}

add_action('init', 'tgores_disable_emojis');

remove_action('wp_head', 'wp_generator');

require_once('includes/elementor.php');
