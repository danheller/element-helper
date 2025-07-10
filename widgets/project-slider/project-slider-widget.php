<?php

namespace ElementHelper\Widget;

use \Elementor\Group_Control_Background;
use \Elementor\Repeater;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;

defined( 'ABSPATH' ) || die();

class  Project_Slider extends Element_El_Widget {

	/**
	 * Get widget name.
	 *
	 * Retrieve Element Helper widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'project_slider';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Project Slider', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/slider/';
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_keywords() {
		return [ 'slider', 'image', 'gallery', 'project' ];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_design_title',
			[
				'label' => __( 'Design Style', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'design_style',
			[
				'label'              => __( 'Design Style', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'style_1' => __( 'Style 1', 'elementhelper' ),
					'style_2' => __( 'Style 2', 'elementhelper' )
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->add_control(
			'section_title',
			[
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'label'       => __( 'Section Title', 'elementhelper' ),
				'placeholder' => __( 'Type title here', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_slides',
			[
				'label' => __( 'Project List', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'type',
			[
				'label'          => __( 'Media Type', 'elementhelper' ),
				'type'           => Controls_Manager::CHOOSE,
				'label_block'    => false,
				'options'        => [
					'icon'  => [
						'title' => __( 'Icon', 'elementhelper' ),
						'icon'  => 'fa fa-smile-o',
					],
					'image' => [
						'title' => __( 'Image', 'elementhelper' ),
						'icon'  => 'fa fa-image',
					],
				],
				'default'        => 'icon',
				'toggle'         => false,
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'     => __( 'Image', 'elementhelper' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'type' => 'image'
				],
				'dynamic'   => [
					'active' => true,
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'medium_large',
				'separator' => 'none',
				'exclude'   => [
					'full',
					'custom',
					'large',
					'shop_catalog',
					'shop_single',
					'shop_thumbnail'
				],
				'condition' => [
					'type' => 'image'
				]
			]
		);

		if ( elh_element_is_elementor_version( '<', '2.6.0' ) ) {
			$repeater->add_control(
				'icon',
				[
					'label'       => __( 'Icon', 'elementhelper' ),
					'label_block' => true,
					'type'        => Controls_Manager::ICON,
					'options'     => elh_element_get_elh_element_icons(),
					'default'     => 'fa fa-smile-o',
					'condition'   => [
						'type' => 'icon'
					]
				]
			);
		} else {
			$repeater->add_control(
				'selected_icon',
				[
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'label_block'      => true,
					'default'          => [
						'value'   => 'fas fa-smile-wink',
						'library' => 'fa-solid',
					],
					'condition'        => [
						'type' => 'icon'
					]
				]
			);
		}

		$repeater->add_control(
			'sub_title',
			[
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'placeholder' => __( 'Type subtitle here', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'title',
			[
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'label'       => __( 'Title', 'elementhelper' ),
				'default'     => __( 'Item List', 'elementhelper' ),
				'placeholder' => __( 'Type title here', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'description',
			[
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'label'       => __( 'Description', 'elementhelper' ),
				'default'     => __( 'Item Description', 'elementhelper' ),
				'placeholder' => __( 'Type description here', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'slide_url',
			[
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'label'       => __( 'URL', 'elementhelper' ),
				'default'     => __( '#', 'elementhelper' ),
				'placeholder' => __( 'Type url here', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'slides',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Carousel Item"); #>',
				'default'     => [
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'medium_large',
				'separator' => 'before',
				'exclude'   => [
					'custom'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Settings', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'animation_speed',
			[
				'label'              => __( 'Animation Speed', 'elementhelper' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 100,
				'step'               => 10,
				'max'                => 10000,
				'default'            => 300,
				'description'        => __( 'Slide speed in milliseconds', 'elementhelper' ),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'              => __( 'Autoplay?', 'elementhelper' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'elementhelper' ),
				'label_off'          => __( 'No', 'elementhelper' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'              => __( 'Autoplay Speed', 'elementhelper' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 100,
				'step'               => 100,
				'max'                => 10000,
				'default'            => 3000,
				'description'        => __( 'Autoplay speed in milliseconds', 'elementhelper' ),
				'condition'          => [
					'autoplay' => 'yes'
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'loop',
			[
				'label'              => __( 'Infinite Loop?', 'elementhelper' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'elementhelper' ),
				'label_off'          => __( 'No', 'elementhelper' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'vertical',
			[
				'label'              => __( 'Vertical Mode?', 'elementhelper' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'elementhelper' ),
				'label_off'          => __( 'No', 'elementhelper' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'              => __( 'Navigation', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'none'  => __( 'None', 'elementhelper' ),
					'arrow' => __( 'Arrow', 'elementhelper' ),
					'dots'  => __( 'Dots', 'elementhelper' ),
					'both'  => __( 'Arrow & Dots', 'elementhelper' ),
				],
				'default'            => 'arrow',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {

		$this->start_controls_section(
			'_section_media_style',
			[
				'label' => __( 'Icon / Image', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Style Tab', 'elementhelper' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['slides'] ) ) {
			return;
		}
		?>
		<?php if ( $settings['design_style'] === 'style_2' ): ?>
            <div class="project-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="section-title-2 mb-30">
								<?php if ( ! empty( $settings['section_title'] ) ): ?>
                                    <h3 class="title text-white text-center">
										<?php echo elh_element_kses_basic( $settings['section_title'] ); ?>
                                    </h3>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="project-slider project-slider-active">
								<?php foreach ( $settings['slides'] as $slide ) :
									if ( ! empty( $slide['image']['id'] ) ) {
										$image = wp_get_attachment_image_url( $slide['image']['id'], $settings['thumbnail_size'] );
									}
									?>
                                    <div class="single-project">
                                        <div class="project-wrap project-style-2">
											<?php if ( ! empty( $image ) ) : ?>
                                                <div class="thumb">
                                                    <img src="<?php print esc_url( $image ); ?>" alt="img">
                                                </div>
											<?php endif; ?>
                                            <div class="content">
												<?php if ( ! empty( $slide['sub_title'] ) ) : ?>
                                                    <div class="date">
														<?php echo elh_element_kses_basic( $slide['sub_title'] ); ?>
                                                    </div>
												<?php endif; ?>
												<?php if ( ! empty( $slide['title'] ) ) : ?>
                                                    <h3 class="title">
                                                        <a href="<?php echo esc_url( $slide['slide_url'] ); ?>">
															<?php echo elh_element_kses_basic( $slide['title'] ); ?>
                                                        </a>
                                                    </h3>
												<?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
								<?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php else: ?>
            <div class="project-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="section-title-2 mb-30">
								<?php if ( ! empty( $settings['section_title'] ) ): ?>
                                    <h3 class="title text-white text-center">
										<?php echo elh_element_kses_basic( $settings['section_title'] ); ?>
                                    </h3>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="project-slider project-slider-active">
								<?php foreach ( $settings['slides'] as $slide ) :
									if ( ! empty( $slide['image']['id'] ) ) {
										$image = wp_get_attachment_image_url( $slide['image']['id'], $settings['thumbnail_size'] );
									}
									?>
                                    <div class="single-project">
                                        <div class="project-wrap">
											<?php if ( ! empty( $image ) ) : ?>
                                                <div class="thumb">
                                                    <img src="<?php print esc_url( $image ); ?>" alt="img">
                                                </div>
											<?php endif; ?>
                                            <div class="content">
												<?php if ( ! empty( $slide['sub_title'] ) ) : ?>
                                                    <div class="date">
														<?php echo elh_element_kses_basic( $slide['sub_title'] ); ?>
                                                    </div>
												<?php endif; ?>
												<?php if ( ! empty( $slide['title'] ) ) : ?>
                                                    <h3 class="title">
                                                        <a href="<?php echo esc_url( $slide['slide_url'] ); ?>">
															<?php echo elh_element_kses_basic( $slide['title'] ); ?>
                                                        </a>
                                                    </h3>
												<?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
								<?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php
		endif;
	}
}
