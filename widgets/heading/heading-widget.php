<?php

namespace ElementHelper\Widget;


use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;


defined( 'ABSPATH' ) || die();

class Heading extends Element_El_Widget {


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
		return 'heading';
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
		return __( 'Heading', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/gradient-heading/';
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
		return 'eicon-t-letter';
	}

	public function get_keywords() {
		return [ 'gradient', 'advanced', 'heading', 'title', 'colorful' ];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title & Description', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => 'Heading Title',
				'placeholder' => __( 'Heading Text', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Heading Sub Text', 'elementhelper' ),
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
			'_section_settings',
			[
				'label' => __( 'Settings', 'elementhelper' ),
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
					'style_3' => __( 'Style 3', 'elementhelper' ),
					'style_4' => __( 'Style 4', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_button',
			[
				'label'     => __( 'Button', 'elementhelper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_style' => 'style_10'
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Text', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Button Text',
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
				'placeholder' => 'http://elementor.sabber.com/',
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
				'default'        => 'before',
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
				'condition' => $condition,
				'selectors' => [
					'{{WRAPPER}} .elh-btn--icon-before .elh-btn-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elh-btn--icon-after .elh-btn-icon'  => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


	}

	protected function register_style_controls() {
		$this->start_controls_section(
			'_section_style_title',
			[
				'label' => __( 'Title & Description', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'_heading_title',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Title', 'elementhelper' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => __( 'Margin', 'elementhelper' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => __( 'Padding', 'elementhelper' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title',
				'selector' => '{{WRAPPER}} .heading-title',
				'scheme'   => Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title',
				'label'    => __( 'Text Shadow', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .heading-title',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Text Color', 'elementhelper' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label'     => __( 'Blend Mode', 'elementhelper' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => __( 'Normal', 'elementhelper' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'difference'  => 'Difference',
					'exclusion'   => 'Exclusion',
					'hue'         => 'Hue',
					'luminosity'  => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .heading-title' => 'mix-blend-mode: {{VALUE}};',
				],
				'separator' => 'none',
			]
		);

		// subtitle
		$this->add_control(
			'_heading_subtitle',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Sub Title', 'elementhelper' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'heading_subtitle_margin',
			[
				'label'      => __( 'Margin', 'elementhelper' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_subtitle_padding',
			[
				'label'      => __( 'Padding', 'elementhelper' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sub-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle',
				'selector' => '{{WRAPPER}} .sub-title',
				'scheme'   => Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'subtitle',
				'label'    => __( 'Text Shadow', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .sub-title',
			]
		);

		$this->add_control(
			'heading_subtitle_color',
			[
				'label'     => __( 'Text Color', 'elementhelper' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		// content

		$this->add_control(
			'_heading_description',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Content', 'elementhelper' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'heading_desc_margin',
			[
				'label'      => __( 'Margin', 'elementhelper' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .section-heading p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_desc_padding',
			[
				'label'      => __( 'Padding', 'elementhelper' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .section-heading p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description',
				'selector' => '{{WRAPPER}} .section-heading p',
				'scheme'   => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'description',
				'label'    => __( 'Text Shadow', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .section-heading p',
			]
		);

		$this->add_control(
			'heading_desc_color',
			[
				'label'     => __( 'Text Color', 'elementhelper' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .section-heading p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'_heading_sub_border',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Border Color', 'elementhelper' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'heading_sub_title_border_color',
			[
				'label'     => __( 'Border Color', 'elementhelper' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sub-title:before,{{WRAPPER}} .sub-title:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_render_attribute( 'title', 'class', 'heading-title title' );

		$title = elh_element_kses_basic( $settings['title'] );
		?>
		<?php if ( $settings['design_style'] === 'style_4' ):
			$this->add_render_attribute( 'title', 'class', 'heading-title title text-white' );
            ?>
			<?php if ( ! empty( $settings['title'] ) ): ?>
                <div class="section-title-2">
					<?php printf( '<%1$s %2$s>%3$s</%1$s>',
						tag_escape( $settings['title_tag'] ),
						$this->get_render_attribute_string( 'title' ),
						$title
					); ?>

					<?php if ( ! empty( $settings['description'] ) ) : ?>
                        <p><?php echo elh_element_kses_intermediate( $settings['description'] ); ?></p>
					<?php endif; ?>
                </div>
			<?php endif; ?>
		<?php elseif ( $settings['design_style'] === 'style_3' ): ?>
			<?php if ( ! empty( $settings['title'] ) ): ?>
                <div class="section-title-2">
					<?php printf( '<%1$s %2$s>%3$s</%1$s>',
						tag_escape( $settings['title_tag'] ),
						$this->get_render_attribute_string( 'title' ),
						$title
					); ?>

	                <?php if ( ! empty( $settings['description'] ) ) : ?>
                        <p><?php echo elh_element_kses_intermediate( $settings['description'] ); ?></p>
	                <?php endif; ?>
                </div>
			<?php endif; ?>
		<?php elseif ( $settings['design_style'] === 'style_2' ): ?>
			<?php if ( ! empty( $settings['title'] ) ): ?>
                <div class="section-title-2">
					<?php printf( '<%1$s %2$s>%3$s</%1$s>',
						tag_escape( $settings['title_tag'] ),
						$this->get_render_attribute_string( 'title' ),
						$title
					); ?>
                </div>
			<?php endif; ?>
		<?php else: ?>
			<?php if ( ! empty( $settings['title'] ) ): ?>
                <div class="section-title">
					<?php printf( '<%1$s %2$s>%3$s</%1$s>',
						tag_escape( $settings['title_tag'] ),
						$this->get_render_attribute_string( 'title' ),
						$title
					); ?>
                </div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
	}
}
