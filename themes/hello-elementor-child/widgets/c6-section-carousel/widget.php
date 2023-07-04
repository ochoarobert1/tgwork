<?php

/**
 * C6 Section Carousel
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * C6SectionCarousel
 */
class C6SectionCarousel extends Widget_Base
{
	public function get_name()
	{
		return 'C6SectionCarousel';
	}

	public function get_title()
	{
		return esc_html__('C6 Section Carousel', 'elementor-list-widget');
	}

	public function get_icon()
	{
		return 'eicon-bullet-list';
	}

	public function get_categories()
	{
		return ['tg-category'];
	}


	public function get_keywords()
	{
		return ['C6 Section Carousel', 'Section Carousel', 'Tom Gores'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'elementor-list-widget'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'textTitle',
			[
				'label' => esc_html__('Section Title', 'elementor-list-widget'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Element Heading', 'elementor-oembed-widget')
			]
		);

		$this->add_control(
			'textContent',
			[
				'label' => esc_html__('Section Content', 'elementor-list-widget'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__('Default description', 'elementor-list-widget'),
				'placeholder' => esc_html__('Type your description here', 'elementor-list-widget')
			]
		);

		$this->add_control(
			'btnText',
			[
				'label' => esc_html__('Button CTA Text', 'elementor-list-widget'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Read More', 'elementor-list-widget')
			]
		);

		$this->add_control(
			'btnLink',
			[
				'label' => esc_html__('Button CTA Link URL', 'elementor-list-widget'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'elementor-list-widget'),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'itemText',
			[
				'label' => esc_html__('Item Text', 'elementor-list-widget'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Say Detroit', 'elementor-list-widget'),
				'default' => esc_html__('Say Detroit', 'elementor-list-widget'),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'itemLink',
			[
				'label' => esc_html__('Item Link URL', 'elementor-list-widget'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'elementor-list-widget'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'itemImage',
			[
				'label' => esc_html__('Choose Item Image', 'elementor-list-widget'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		/* End repeater */

		$this->add_control(
			'imageArray',
			[
				'label' => esc_html__('Image Items', 'elementor-list-widget'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'itemText' => esc_html__('Item #1', 'elementor-list-widget'),
						'itemLink' => '',
					],
					[
						'itemText' => esc_html__('Item #2', 'elementor-list-widget'),
						'itemLink' => '',
					],
					[
						'itemText' => esc_html__('Item #3', 'elementor-list-widget'),
						'itemLink' => '',
					],
				],
				'title_field' => '{{{ itemText }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__('Style', 'elementor-list-widget'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'elementor-list-widget'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-list-widget-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-list-widget-text > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .elementor-list-widget-text, {{WRAPPER}} .elementor-list-widget-text > a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-list-widget-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_marker_section',
			[
				'label' => esc_html__('Marker Style', 'elementor-list-widget'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'marker_color',
			[
				'label' => esc_html__('Color', 'elementor-list-widget'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-list-widget-text::marker' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'marker_spacing',
			[
				'label' => esc_html__('Spacing', 'elementor-list-widget'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem', 'custom'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					// '{{WRAPPER}} .elementor-list-widget' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-list-widget' => 'padding-inline-start: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
	}

	protected function content_template()
	{
	}
}
