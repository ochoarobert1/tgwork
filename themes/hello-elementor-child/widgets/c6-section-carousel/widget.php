<?php

/*
 * C6 Section Carousel
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if (!defined('ABSPATH')) {
	exit;
}

class C6SectionCarousel extends Widget_Base
{
	public function get_name()
	{
		return esc_attr('C6SectionCarousel');
	}

	public function get_title()
	{
		return esc_html__('C6 Section Carousel', 'tgores');
	}

	public function get_icon()
	{
		return esc_attr('eicon-bullet-list');
	}

	public function get_categories()
	{
		return ['tg-category'];
	}

	public function get_keywords()
	{
		return ['C6 Section Carousel', 'Section Carousel', 'Tom Gores'];
	}

	public function get_style_depends()
	{
		return ['swiper', 'c6-section-carousel-style'];
	}

	public function get_script_depends()
	{
		return ['swiper', 'c6-section-carousel-script'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'tgores'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'textTitle',
			[
				'label' => esc_html__('Section Title', 'tgores'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Element Heading', 'elementor-oembed-widget')
			]
		);

		$this->add_control(
			'textContent',
			[
				'label' => esc_html__('Section Content', 'tgores'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__('Default description', 'tgores'),
				'placeholder' => esc_html__('Type your description here', 'tgores')
			]
		);

		$this->add_control(
			'btnText',
			[
				'label' => esc_html__('Button CTA Text', 'tgores'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Read More', 'tgores')
			]
		);

		$this->add_control(
			'btnLink',
			[
				'label' => esc_html__('Button CTA Link URL', 'tgores'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'tgores'),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'itemText',
			[
				'label' => esc_html__('Item Text', 'tgores'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Say Detroit', 'tgores'),
				'default' => esc_html__('Say Detroit', 'tgores'),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'itemLink',
			[
				'label' => esc_html__('Item Link URL', 'tgores'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'tgores'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'itemImage',
			[
				'label' => esc_html__('Choose Item Image', 'tgores'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		/* End repeater */

		$this->add_control(
			'imageArray',
			[
				'label' => esc_html__('Image Items', 'tgores'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'itemText' => esc_html__('Item #1', 'tgores'),
						'itemLink' => '',
					],
					[
						'itemText' => esc_html__('Item #2', 'tgores'),
						'itemLink' => '',
					],
					[
						'itemText' => esc_html__('Item #3', 'tgores'),
						'itemLink' => '',
					],
				],
				'title_field' => '{{ itemText }}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__('Style', 'tgores'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '{{WRAPPER}} .your-class',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'tgores'),
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
				'label' => esc_html__('Marker Style', 'tgores'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'marker_color',
			[
				'label' => esc_html__('Color', 'tgores'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-list-widget-text::marker' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
?>
		<section class="section-carousel container">
			<div class="row align-items-center justify-content-center">
				<div class="section-carousel-images col-xl-3 col-md-6 col-12">
					<?php $arrayImgs = $settings['imageArray']; ?>
					<div class="section-carousel-swiper-content">
						<div class="swiper">
							<div class="swiper-wrapper">
								<?php foreach ($arrayImgs as $img) : ?>
									<div class="swiper-slide">
										<div class="section-carousel-item">
											<?php if ($img['itemLink']['url'] != '') : ?>
												<a href="<?php echo esc_url($img['itemLink']['url']); ?>"><?php echo esc_html($img['itemText']); ?></a>
											<?php endif; ?>
											<img src="<?php echo esc_url($img['itemImage']['url']); ?>" class="img-fluid" alt="<?php echo esc_attr($img['itemText']); ?>" loading="lazy?>">
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="swiper-pagination"></div>
							<div class="swiper-button-prev"></div>
							<div class="swiper-button-next"></div>
						</div>
					</div>
				</div>
				<div class="section-carousel-content col-xl-6 col-md-6 col-12">
					<h3><?php echo esc_html($settings['textTitle']); ?></h3>
					<?php echo wp_kses_post($settings['textContent']); ?>

					<?php if ($settings['btnText'] != '') : ?>
						<a href="<?php esc_url($settings['btnLink']['url']); ?>" class="btn btn-primary"><?php echo esc_html($settings['btnText']); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php
	}

	protected function content_template()
	{
	?>
		<section class="section-carousel container">
			<div class="row align-items-center justify-content-center">
				<div class="section-carousel-images col-xl-4 col-md-6 col-12">
					<div class="section-carousel-content">
						<div class="swiper">
							<div class="swiper-wrapper">
								<# _.each( settings.imageArray, function( item, index ) { var repeater_setting_key=view.getRepeaterSettingKey( 'text' , 'imageArray' , index ); view.addRenderAttribute( repeater_setting_key, 'class' , 'elementor-list-widget-text' ); view.addInlineEditingAttributes( repeater_setting_key ); #>
									<div class="swiper-slide">
										<div class="section-carousel-item">
											<# if ( item.itemLink ) { #>
												<# view.addRenderAttribute( `link_${index}`, item.itemLink ); #>
													<a href="{{ item.itemLink.url }}" {{ view.getRenderAttributeString( `link_${index}` ) }}>
														{{item.itemText}}
													</a>
													<# } else { #>
														{{item.itemText}}
														<# } #>
															<img src="{{ item.itemImage.url }}" class="img-fluid" alt="{{item.itemText}}" loading="lazy" />
										</div>
									</div>
									<# } ); #>
							</div>
							<div class="swiper-pagination"></div>
							<div class="swiper-button-prev"></div>
							<div class="swiper-button-next"></div>
						</div>
					</div>
				</div>
				<div class="section-carousel-content col-xl-4 col-md-6 col-12">
					<h3>{{ settings.textTitle }}</h3>
					<p>{{ settings.textContent }}</p>

					<# if ( settings.btnText ) { #>
						<# view.addRenderAttribute( `link_${index}`, settings.btnLink ); #>
							<a href="{{ settings.btnLink.url }}" {{ view.getRenderAttributeString( `link_${index}` ) }}>
								{{settings.btnText}}
							</a>
							<# } #>
				</div>
			</div>
		</section>
<?php
	}
}
