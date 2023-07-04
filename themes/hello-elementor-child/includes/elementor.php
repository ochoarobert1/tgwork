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
		//add_action('wp_enqueue_scripts', [$this, 'elementor_test_widgets_dependencies'], 80);
		add_action('elementor/widgets/register', [$this, 'register_list_widget']);
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

	function elementor_test_widgets_dependencies($widgets)
	{
	}

	public function register_list_widget($widgets_manager )
	{
		$path = get_stylesheet_directory() . '/widgets';
		$ffs = scandir($path);
		unset($ffs[array_search('.', $ffs, true)]);
		unset($ffs[array_search('..', $ffs, true)]);

		// prevent empty ordered elements
		if (count($ffs) < 1)
			return;

		foreach ($ffs as $ff) {
			$className = '\\' . preg_replace('/\s+/', '', ucwords(preg_replace('/[-]/', ' ', $ff)));
			require_once $path . '/' . $ff . '/widget.php';

			$widgets_manager->register(new $className());
		}
	}
}

new TGElementorWidgets;
