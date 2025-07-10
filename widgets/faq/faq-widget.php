<?php

namespace ElementHelper\Widget;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Repeater;
use \Elementor\Utils;

defined( 'ABSPATH' ) || die();

class FAQ extends Element_El_Widget {

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
		return 'faq';
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
		return __( 'FAQ', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/contact-7-form/';
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
		return 'eicon-edit';
	}

	public function get_keywords() {
		return [ 'services', 'tab' ];
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
					'style_2' => __( 'Style 2', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title ', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Heading Sub Title',
				'placeholder' => __( 'Heading Sub Text', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => 'Heading Title',
				'placeholder' => __( 'Heading Text', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Heading Description Text', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => __( 'Title HTML Tag', 'elementhelper' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'h1' => [
						'title' => __( 'H1', 'elementhelper' ),
						'icon'  => 'eicon-editor-h1'
					],
					'h2' => [
						'title' => __( 'H2', 'elementhelper' ),
						'icon'  => 'eicon-editor-h2'
					],
					'h3' => [
						'title' => __( 'H3', 'elementhelper' ),
						'icon'  => 'eicon-editor-h3'
					],
					'h4' => [
						'title' => __( 'H4', 'elementhelper' ),
						'icon'  => 'eicon-editor-h4'
					],
					'h5' => [
						'title' => __( 'H5', 'elementhelper' ),
						'icon'  => 'eicon-editor-h5'
					],
					'h6' => [
						'title' => __( 'H6', 'elementhelper' ),
						'icon'  => 'eicon-editor-h6'
					]
				],
				'default' => 'h2',
				'toggle'  => false,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'elementhelper' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'elementhelper' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementhelper' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'elementhelper' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_slides',
			[
				'label' => __( 'Faq List', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'label'       => __( 'Tab Title', 'elementhelper' ),
				'default'     => __( 'Tab Title', 'elementhelper' ),
				'placeholder' => __( 'Type title here', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'tab_content_info',
			[
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'show_label'  => false,
				'default'     => __( 'Content Here', 'elementhelper' ),
				'placeholder' => __( 'Type subtitle here', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'image',
			[
				'type'    => Controls_Manager::MEDIA,
				'label'   => __( 'Image', 'elementhelper' ),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		// REPEATER
		$this->add_control(
			'slides',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(tab_title || "Carousel Item"); #>',
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
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_button',
			[
				'label'     => __( 'Button', 'elementhelper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_style' => [ 'style_1', 'style_2' ],
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Text', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Button Text', 'elementhelper' ),
				'placeholder' => __( 'Type button text here', 'elementhelper' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => __( 'Link', 'elementhelper' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'http://elementor.sabber.com/', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		if ( elh_element_is_elementor_version( '<', '2.6.0' ) ) {
			$this->add_control(
				'button_icon',
				[
					'label'       => __( 'Icon', 'elementhelper' ),
					'label_block' => true,
					'type'        => Controls_Manager::ICON,
					'options'     => elh_element_get_elh_element_icons(),
					'default'     => 'fa fa-angle-right',
				]
			);

			$condition = [ 'button_icon!' => '' ];
		} else {
			$this->add_control(
				'button_selected_icon',
				[
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'button_icon',
					'label_block'      => true,
				]
			);
			$condition = [ 'button_selected_icon[value]!' => '' ];
		}

		$this->add_control(
			'button_icon_position',
			[
				'label'          => __( 'Icon Position', 'elementhelper' ),
				'type'           => Controls_Manager::CHOOSE,
				'label_block'    => false,
				'options'        => [
					'before' => [
						'title' => __( 'Before', 'elementhelper' ),
						'icon'  => 'eicon-h-align-left',
					],
					'after'  => [
						'title' => __( 'After', 'elementhelper' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'        => 'after',
				'toggle'         => false,
				'condition'      => $condition,
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'button_icon_spacing',
			[
				'label'     => __( 'Icon Spacing', 'elementhelper' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 10
				],
				'condition' => $condition,
				'selectors' => [
					'{{WRAPPER}} .btn--icon-before .btn-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .btn--icon-after .btn-icon'  => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	// register_style_controls
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
		$this->add_render_attribute( 'title', 'class', 'big_title text-white mb-0' );
		$title = elh_element_kses_basic( $settings['title'] );

		// img
		if ( ! empty( $settings['tab_big_image']['id'] ) ) {
			$tab_big_image = wp_get_attachment_image_url( ! empty( $settings['tab_big_image']['id'] ), ! empty( $settings['tab_big_image_size'] ) );
			if ( ! $tab_big_image ) {
				$tab_big_image = $settings['tab_big_image']['url'];
			}
		}

		// img small
		if ( ! empty( $settings['tab_small_image']['id'] ) ) {
			$tab_small_image = wp_get_attachment_image_url( ! empty( $settings['tab_small_image']['id'] ), ! empty( $settings['tab_big_image_size'] ) );
			if ( ! $tab_small_image ) {
				$tab_small_image = $settings['tab_small_image']['url'];
			}
		}

		if ( empty( $settings['slides'] ) ) {
			return;
		}
		?>
		<?php if ( $settings['design_style'] === 'style_2' ):
			$this->add_render_attribute( 'button', 'class', 'a-btn' );
			?>
            <div class="faq-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="faq-wrapper">
                                <div class="faq-title text-center">
									<?php if ( ! empty( $settings['title'] ) ): ?>
                                        <h2 class="title"><?php echo elh_element_kses_intermediate( $settings['title'] ); ?></h2>
									<?php endif; ?>
                                </div>
                                <div class="accordion mb-40" id="accordionExample">
									<?php foreach ( $settings['slides'] as $id => $slide ) :
										$collapsed_tab = ( $id == 0 ) ? '' : 'collapsed';
										$area_expanded = ( $id == 0 ) ? 'true' : 'false';
										$active_show_tab = ( $id == 0 ) ? 'show' : '';
										?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading<?php echo esc_attr( $id ); ?>">
                                                <button class="accordion-button <?php echo esc_attr( $collapsed_tab ); ?>"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse<?php echo esc_attr( $id ); ?>"
                                                        aria-expanded="<?php echo esc_attr( $area_expanded ); ?>"
                                                        aria-controls="collapse<?php echo esc_attr( $id ); ?>">
													<?php if ( ! empty( $slide['tab_title'] ) ): ?>
														<?php echo elh_element_kses_basic( $slide['tab_title'] ); ?>
													<?php endif; ?>
                                                </button>
                                            </h2>
                                            <div id="collapse<?php echo esc_attr( $id ); ?>"
                                                 class="accordion-collapse collapse <?php echo esc_attr( $active_show_tab ); ?>"
                                                 aria-labelledby="heading<?php echo esc_attr( $id ); ?>"
                                                 data-bs-parent="#accordionExample">
												<?php if ( ! empty( $slide['tab_content_info'] ) ): ?>
                                                    <div class="accordion-body">
														<?php echo elh_element_kses_basic( $slide['tab_content_info'] ); ?>
                                                    </div>
												<?php endif; ?>
                                            </div>
                                        </div>
									<?php endforeach; ?>
                                </div>
                                <div class="faq-btn-wrap">
									<?php if ( $settings['button_text'] && ( ( empty( $settings['button_selected_icon'] ) || empty( $settings['button_selected_icon']['value'] ) ) && empty( $settings['button_icon'] ) ) ) :
										printf( '<a %1$s href="%3$s">%2$s</a>',
											$this->get_render_attribute_string( 'button' ),
											esc_html( $settings['button_text'] ),
											esc_url( $settings['button_link']['url'] )
										);
                                    elseif ( empty( $settings['button_text'] ) && ( ( ! empty( $settings['button_selected_icon'] ) || empty( $settings['button_selected_icon']['value'] ) ) || ! empty( $settings['button_icon'] ) ) ) : ?>
                                        <a <?php $this->print_render_attribute_string( 'button' ); ?>><?php elh_element_render_icon( $settings, 'button_icon', 'button_selected_icon' ); ?></a>
									<?php elseif ( $settings['button_text'] && ( ( ! empty( $settings['button_selected_icon'] ) || empty( $settings['button_selected_icon']['value'] ) ) || ! empty( $settings['button_icon'] ) ) ) :
										if ( $settings['button_icon_position'] === 'before' ): ?>
                                            <a <?php $this->print_render_attribute_string( 'button' ); ?>><?php elh_element_render_icon( $settings, 'button_icon', 'button_selected_icon', [ 'class' => 'elh-btn-icon' ] ); ?>
                                                <span><?php echo esc_html( $settings['button_text'] ); ?></span></a>
										<?php
										else: ?>
                                            <a <?php $this->print_render_attribute_string( 'button' ); ?>>
                                                <span><?php echo esc_html( $settings['button_text'] ); ?></span>
												<?php elh_element_render_icon( $settings, 'button_icon', 'button_selected_icon', [ 'class' => 'elh-btn-icon' ] ); ?>
                                            </a>
										<?php
										endif;
									endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php else:
			$this->add_render_attribute( 'button', 'class', 'a-btn' );
			?>
            <div class="faq-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="faq-wrapper">
                                <div class="faq-title text-center">
									<?php if ( ! empty( $settings['title'] ) ): ?>
                                        <h2 class="title"><?php echo elh_element_kses_intermediate( $settings['title'] ); ?></h2>
									<?php endif; ?>
                                </div>
                                <div class="accordion mb-40" id="accordionExample">
									<?php foreach ( $settings['slides'] as $id => $slide ) :
										$collapsed_tab = ( $id == 0 ) ? '' : 'collapsed';
										$area_expanded = ( $id == 0 ) ? 'true' : 'false';
										$active_show_tab = ( $id == 0 ) ? 'show' : '';
										?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading<?php echo esc_attr( $id ); ?>">
                                                <button class="accordion-button <?php echo esc_attr( $collapsed_tab ); ?>"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse<?php echo esc_attr( $id ); ?>"
                                                        aria-expanded="<?php echo esc_attr( $area_expanded ); ?>"
                                                        aria-controls="collapse<?php echo esc_attr( $id ); ?>">
													<?php if ( ! empty( $slide['tab_title'] ) ): ?>
														<?php echo elh_element_kses_basic( $slide['tab_title'] ); ?>
													<?php endif; ?>
                                                </button>
                                            </h2>
                                            <div id="collapse<?php echo esc_attr( $id ); ?>"
                                                 class="accordion-collapse collapse <?php echo esc_attr( $active_show_tab ); ?>"
                                                 aria-labelledby="heading<?php echo esc_attr( $id ); ?>"
                                                 data-bs-parent="#accordionExample">
												<?php if ( ! empty( $slide['tab_content_info'] ) ): ?>
                                                    <div class="accordion-body">
														<?php echo elh_element_kses_basic( $slide['tab_content_info'] ); ?>
                                                    </div>
												<?php endif; ?>
                                            </div>
                                        </div>
									<?php endforeach; ?>
                                </div>
                                <div class="faq-btn-wrap text-center">
									<?php if ( $settings['button_text'] && ( ( empty( $settings['button_selected_icon'] ) || empty( $settings['button_selected_icon']['value'] ) ) && empty( $settings['button_icon'] ) ) ) :
										printf( '<a %1$s href="%3$s">%2$s</a>',
											$this->get_render_attribute_string( 'button' ),
											esc_html( $settings['button_text'] ),
											esc_url( $settings['button_link']['url'] )
										);
                                    elseif ( empty( $settings['button_text'] ) && ( ( ! empty( $settings['button_selected_icon'] ) || empty( $settings['button_selected_icon']['value'] ) ) || ! empty( $settings['button_icon'] ) ) ) : ?>
                                        <a <?php $this->print_render_attribute_string( 'button' ); ?>><?php elh_element_render_icon( $settings, 'button_icon', 'button_selected_icon' ); ?></a>
									<?php elseif ( $settings['button_text'] && ( ( ! empty( $settings['button_selected_icon'] ) || empty( $settings['button_selected_icon']['value'] ) ) || ! empty( $settings['button_icon'] ) ) ) :
										if ( $settings['button_icon_position'] === 'before' ): ?>
                                            <a <?php $this->print_render_attribute_string( 'button' ); ?>><?php elh_element_render_icon( $settings, 'button_icon', 'button_selected_icon', [ 'class' => 'elh-btn-icon' ] ); ?>
                                                <span><?php echo esc_html( $settings['button_text'] ); ?></span></a>
										<?php
										else: ?>
                                            <a <?php $this->print_render_attribute_string( 'button' ); ?>>
                                                <span><?php echo esc_html( $settings['button_text'] ); ?></span>
												<?php elh_element_render_icon( $settings, 'button_icon', 'button_selected_icon', [ 'class' => 'elh-btn-icon' ] ); ?>
                                            </a>
										<?php
										endif;
									endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php
		endif;
	}
}