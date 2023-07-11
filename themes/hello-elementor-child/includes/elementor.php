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
		add_action('elementor/elements/categories_registered', [$this, 'widget_categories']);
		add_action('wp_enqueue_scripts', [$this, 'widgets_dependencies'], 80);
		add_action('elementor/widgets/register', [$this, 'widgets_register']);
	}

	public function widget_categories($elements_manager)
	{
		$elements_manager->add_category(
			'tg-category',
			[
				'title' => esc_html__('Tom Gores Components', 'tgores'),
				'icon' => 'fa fa-plug',
			]
		);
	}

	function widgets_dependencies()
	{
		$folders = $this->get_widget_folders();

		if (count($folders) < 1)
			return;

		foreach ($folders as $folder) {
			wp_register_style(
				$folder . '-style',
				get_stylesheet_directory_uri() . '/assets/css/elementor/' .  $folder . '.css',
				[],
				HELLO_ELEMENTOR_CHILD_VERSION,
				'all'
			);

			wp_register_script(
				$folder . '-script',
				get_stylesheet_directory_uri() . '/assets/js/elementor/' .  $folder . '.min.js',
				['jquery'],
				HELLO_ELEMENTOR_CHILD_VERSION,
				true
			);
		}
	}

	public function widgets_register($widgets_manager)
	{
		$path = get_stylesheet_directory() . '/widgets';
		$folders = $this->get_widget_folders();

		if (count($folders) < 1)
			return;

		foreach ($folders as $folder) {
			$className = '\\' . preg_replace('/\s+/', '', ucwords(preg_replace('/[-]/', ' ', $folder)));
			require_once $path . '/' . $folder . '/widget.php';

			$widgets_manager->register(new $className());
		}
	}

	public function get_widget_folders()
	{
		$path = get_stylesheet_directory() . '/widgets';
		$folders = scandir($path);
		unset($folders[array_search('.', $folders, true)]);
		unset($folders[array_search('..', $folders, true)]);

		return $folders;
	}
}

new TGElementorWidgets;
