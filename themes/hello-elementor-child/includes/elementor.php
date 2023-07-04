<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    TGElementorWidgets
 * @subpackage includes/elementor
 * @author     Robert Ochoa <rochoa@modusagency.comas>
 */

class TGElementorWidgets
{

	public function __construct()
	{
		add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
		add_action('wp_enqueue_scripts', [$this, 'elementor_test_widgets_dependencies'], 80);
	}

	public function add_elementor_widget_categories($elements_manager)
	{
		$elements_manager->add_category(
			'tg-category',
			[
				'title' => esc_html__('Tom Gores Components', 'textdomain'),
				'icon' => 'fa fa-plug',
			]
		);
	}

	function elementor_test_widgets_dependencies()
	{
		$path = get_template_directory_uri() . '/assets/css/elementor';
		$files = array_diff(scandir($path), array('.', '..'));
	}
}
