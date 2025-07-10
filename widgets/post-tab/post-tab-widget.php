<?php
namespace ElementHelper\Widget;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;
use ElementHelperor\Controls\Select2;

defined( 'ABSPATH' ) || die();

class Post_Tab extends Element_El_Widget {

	/**
     * Get widget name.
     *
     * Retrieve Element Helper widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'post_tab';
    }

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title () {
		return __( 'Post Tab', 'elementhelper' );
	}

	public function get_custom_help_url () {
		return 'http://elementor.sabber.net//widgets/post-tab/';
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon () {
		return 'eicon-post';
	}

	public function get_keywords () {
		return [ 'posts', 'post', 'post-tab', 'tab', 'news' ];
	}

	/**
	 * Get a list of All Post Types
	 *
	 * @return array
	 */
	public static function get_post_types () {
		$diff_key = [
			'elementor_library' => '',
			'attachment' => '',
			'page' => ''
		];
		$post_types = elh_element_get_post_types( [], $diff_key );
		return $post_types;
	}

	/**
	 * Get a list of Taxonomy
	 *
	 * @return array
	 */
	public static function get_taxonomies ( $post_type = '' ) {
		$list = [];
		if ( $post_type ) {
			$tax = elh_element_get_taxonomies( [ 'public' => true, "object_type" => [ $post_type ] ], 'object', true );
			$list[$post_type] = count( $tax ) !== 0 ? $tax : '';
		} else {
			$list = elh_element_get_taxonomies( [ 'public' => true ], 'object', true );
		}
		return $list;
	}

	protected function register_content_controls () {

        // section title
        $this->start_controls_section(
            '_section_title',
            [
                'label' => __( 'Title & Description', 'elementhelper' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading_switch',
            [
                'label' => __( 'Show', 'elementhelper' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementhelper' ),
                'label_off' => __( 'Hide', 'elementhelper' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __( 'Sub Title', 'elementhelper' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => __( 'ElhInfo Box Sub Title', 'elementhelper' ),
                'placeholder' => __( 'Type Info Box Sub Title', 'elementhelper' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'elementhelper' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => __( 'ElhInfo Box Title', 'elementhelper' ),
                'placeholder' => __( 'Type Info Box Title', 'elementhelper' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->end_controls_section();    

		$this->start_controls_section(
			'_section_post_tab_query',
			[
				'label' => __( 'Query', 'elementhelper' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Source', 'elementhelper' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_post_types(),
				'default' => key( $this->get_post_types() ),
			]
		);

		foreach ( self::get_post_types() as $key => $value ) {
			$taxonomy = self::get_taxonomies( $key );
			if ( ! $taxonomy[$key] )
				continue;
			$this->add_control(
				'tax_type_' . $key,
				[
					'label' => __( 'Taxonomies', 'elementhelper' ),
					'type' => Controls_Manager::SELECT,
					'options' => $taxonomy[$key],
					'default' => key( $taxonomy[$key] ),
					'condition' => [
						'post_type' => $key
					],
				]
			);

			foreach ( $taxonomy[$key] as $tax_key => $tax_value ) {

				$this->add_control(
					'tax_ids_' . $tax_key,
					[
						'label' => __( 'Select ', 'elementhelper' ) . $tax_value,
						'label_block' => true,
						'type' => 'elementhelper-select2',
						'multiple' => true,
						'placeholder' => 'Search ' . $tax_value,
						'data_options' => [
							'tax_id' => $tax_key,
							'action' => 'elh_element_post_tab_select_query'
						],
						'condition' => [
							'post_type' => $key,
							'tax_type_' . $key => $tax_key
						],
						'render_type' => 'template',
					]
				);
			}
		}

		$this->add_control(
			'item_limit',
			[
				'label' => __( 'Item Limit', 'elementhelper' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls () {

		$this->start_controls_section(
            '_section_style_title',
            [
                'label' => __( 'Title & Desccription', 'elementhelper' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_heading_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Title', 'elementhelper' ),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => __( 'Margin', 'elementhelper' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_padding',
            [
                'label' => __( 'Padding', 'elementhelper' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .section-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'selector' => '{{WRAPPER}} .section-title',
                'scheme' => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title',
                'label' => __( 'Text Shadow', 'elementhelper' ),
                'selector' => '{{WRAPPER}} .section-title',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __( 'Text Color', 'elementhelper' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .section-title' => 'color: {{VALUE}};',
                ],
            ]
        );        

        $this->add_control(
            'back_heading_color',
            [
                'label' => __( 'Back Text Color', 'elementhelper' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .text-border-title1' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label' => __( 'Blend Mode', 'elementhelper' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'Normal', 'elementhelper' ),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'difference' => 'Difference',
                    'exclusion' => 'Exclusion',
                    'hue' => 'Hue',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .section-title' => 'mix-blend-mode: {{VALUE}};',
                ],
                'separator' => 'none',
            ]
        );

        // subtitle
        $this->add_control(
            '_heading_subtitle',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Sub Title', 'elementhelper' ),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'heading_subtitle_margin',
            [
                'label' => __( 'Margin', 'elementhelper' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_subtitle_padding',
            [
                'label' => __( 'Padding', 'elementhelper' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sub-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle',
                'selector' => '{{WRAPPER}} .sub-title',
                'scheme' => Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'subtitle',
                'label' => __( 'Text Shadow', 'elementhelper' ),
                'selector' => '{{WRAPPER}} .sub-title',
            ]
        );

        $this->add_control(
            'heading_subtitle_color',
            [
                'label' => __( 'Text Color', 'elementhelper' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // content

        $this->add_control(
            '_heading_description',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Content', 'elementhelper' ),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'heading_desc_margin',
            [
                'label' => __( 'Margin', 'elementhelper' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .section-heading p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_desc_padding',
            [
                'label' => __( 'Padding', 'elementhelper' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .section-heading p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desccription',
                'selector' => '{{WRAPPER}} .section-heading p',
                'scheme' => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'desccription',
                'label' => __( 'Text Shadow', 'elementhelper' ),
                'selector' => '{{WRAPPER}} .section-heading p',
            ]
        );

        $this->add_control(
            'heading_desc_color',
            [
                'label' => __( 'Text Color', 'elementhelper' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .section-heading p' => 'color: {{VALUE}};',
                ],
            ]
        );        

        $this->end_controls_section();

		$this->start_controls_section(
			'_section_post_tab_filter',
			[
				'label' => __( 'Tab', 'elementhelper' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_line_color',
			[
				'label' => __( 'Tab Line BG', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .project-filter-box::before' => 'background: {{VALUE}}',
				],
			]
		);		

		$this->add_control(
			'tab_box_color',
			[
				'label' => __( 'Tab Box BG', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .project-filter-box' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tab_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'elementhelper' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .project-filter-box' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'filter_pos' => 'top',
				],
			]
		);

		$this->add_responsive_control(
			'tab_padding',
			[
				'label' => __( 'Padding', 'elementhelper' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .project-filter-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tab_shadow',
				'label' => __( 'Box Shadow', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .project-filter-box',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_border',
				'label' => __( 'Border', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .project-filter-box',
			]
		);

		$this->add_responsive_control(
			'tab_item',
			[
				'label' => __( 'Tab Item', 'elementhelper' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tab_item_margin',
			[
				'label' => __( 'Margin', 'elementhelper' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .project-filter-box button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_item_padding',
			[
				'label' => __( 'Padding', 'elementhelper' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .project-filter-box button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs( 'tab_item_tabs' );
		$this->start_controls_tab(
			'tab_item_normal_tab',
			[
				'label' => __( 'Normal', 'elementhelper' ),
			]
		);

		$this->add_control(
			'tab_item_color',
			[
				'label' => __( 'Color', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .project-filter-box button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tab_item_background',
				'label' => __( 'Background', 'elementhelper' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .project-filter-box button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover_tab',
			[
				'label' => __( 'Hover', 'elementhelper' ),
			]
		);

		$this->add_control(
			'tab_item_hvr_color',
			[
				'label' => __( 'Color', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .project-filter-box button.active' => 'color: {{VALUE}}',
					'{{WRAPPER}} .project-filter-box button:hover' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'tab_item_hvr_background',
				'label' => __( 'Background', 'elementhelper' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .project-filter-box button.active,{{WRAPPER}} .project-filter-box button:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_item_typography',
				'label' => __( 'Typography', 'elementhelper' ),
				'scheme' => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .project-filter-box button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tab_item_border',
				'label' => __( 'Border', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .project-filter-box button',
			]
		);

		$this->add_responsive_control(
			'tab_item_border_radius',
			[
				'label' => __( 'Border Radius', 'elementhelper' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .project-filter-box button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->end_controls_section();

		//Column
		$this->start_controls_section(
			'_section_post_tab_column',
			[
				'label' => __( 'Column', 'elementhelper' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'post_item_space',
			[
				'label' => __( 'Space Between', 'elementhelper' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_item_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'elementhelper' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_item_padding',
			[
				'label' => __( 'Padding', 'elementhelper' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'post_item_background',
				'label' => __( 'Background', 'elementhelper' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'post_item_box_shadow',
				'label' => __( 'Box Shadow', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'post_item_border',
				'label' => __( 'Border', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner',
			]
		);

		$this->add_responsive_control(
			'post_item_border_radius',
			[
				'label' => __( 'Border Radius', 'elementhelper' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->end_controls_section();

		//Content Style
		$this->start_controls_section(
			'_section_post_tab_content',
			[
				'label' => __( 'Content', 'elementhelper' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'post_content_image',
			[
				'label' => __( 'Image', 'elementhelper' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'post_item_content_img_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'elementhelper' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner .elementhelper-post-tab-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_boder',
				'label' => __( 'Border', 'elementhelper' ),
				'selector' => '{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner .elementhelper-post-tab-thumb img',
			]
		);

		$this->add_responsive_control(
			'image_boder_radius',
			[
				'label' => __( 'Border Radius', 'elementhelper' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner .elementhelper-post-tab-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_content_title',
			[
				'label' => __( 'Title', 'elementhelper' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'post_content_margin_btm',
			[
				'label' => __( 'Margin Bottom', 'elementhelper' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner .elementhelper-post-tab-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'elementhelper' ),
				'scheme' => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner .elementhelper-post-tab-title',
			]
		);

		$this->start_controls_tabs( 'title_tabs' );
		$this->start_controls_tab(
			'title_normal_tab',
			[
				'label' => __( 'Normal', 'elementhelper' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner .elementhelper-post-tab-title a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_hover_tab',
			[
				'label' => __( 'Hover', 'elementhelper' ),
			]
		);

		$this->add_control(
			'title_hvr_color',
			[
				'label' => __( 'Color', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-item-inner .elementhelper-post-tab-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'post_content_meta',
			[
				'label' => __( 'Meta', 'elementhelper' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'label' => __( 'Typography', 'elementhelper' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-meta span',
			]
		);

		$this->start_controls_tabs( 'meta_tabs' );
		$this->start_controls_tab(
			'meta_normal_tab',
			[
				'label' => __( 'Normal', 'elementhelper' ),
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => __( 'Color', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-meta span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-meta span a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'meta_hover_tab',
			[
				'label' => __( 'Hover', 'elementhelper' ),
			]
		);

		$this->add_control(
			'meta_hvr_color',
			[
				'label' => __( 'Color', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-meta span:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-meta span:hover a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'meta__margin',
			[
				'label' => __( 'Margin', 'elementhelper' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-meta span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'post_content_excerpt',
			[
				'label' => __( 'Excerpt', 'elementhelper' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'excerpt' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'label' => __( 'Typography', 'elementhelper' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-excerpt p',
				'condition' => [
					'excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Color', 'elementhelper' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-excerpt p' => 'color: {{VALUE}};',
				],
				'condition' => [
					'excerpt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_margin_top',
			[
				'label' => __( 'Margin Top', 'elementhelper' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .elementhelper-post-tab .elementhelper-post-tab-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render () {

		$settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'title', 'basic' );
        $this->add_render_attribute( 'title', 'class', 'section-title shape' );
        $this->add_render_attribute( 'title3', 'class', 'section-title d-block' );

		$title = elh_element_kses_basic( $settings['title' ] );

		if ( ! $settings['post_type'] )
			return;

		$taxonomy = $settings['tax_type_' . $settings['post_type']];
		$terms_ids = $settings['tax_ids_' . $taxonomy];
		$terms_args = [
			'taxonomy' => $taxonomy,
			'hide_empty' => true,
			'include' => $terms_ids,
			'orderby' => 'term_id',
		];
		$filter_list = get_terms( $terms_args );

		$post_args = [
			'post_status' => 'publish',
			'post_type' => $settings['post_type'],
			'posts_per_page' => $settings['item_limit'],
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'term_id',
					'terms' => $terms_ids ? $terms_ids : '',
				),
			),
		];

		$posts = query_posts( $post_args );

		$query_settings = [
			'post_type' => $settings['post_type'],
			'taxonomy' => $taxonomy,
			'item_limit' => $settings['item_limit'],
		];
		$query_settings = json_encode( $query_settings, true );


		$wrapper_class = [
			'case__area',
		];
		$this->add_render_attribute( 'wrapper', 'class', $wrapper_class );
		$this->add_render_attribute( 'wrapper', 'data-query-args', $query_settings );
		$this->add_render_attribute( 'project-filter', 'class', [ 'masonary-menu filter-button-group' ] );
		$this->add_render_attribute( 'project-body', 'class', [ 'row row-portfolio' ] );
		$i = 1;

		if ( !empty( $settings['design_style'] ) AND $settings['design_style'] == 'style_2' ):
		
		if ( !empty($terms_ids) && count( $posts ) !== 0 ) :?>

            <section class="portfolio__area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="portfolio__menu mb-40 wow fadeInUp" data-wow-delay=".3s">
                                <span>Filter by: </span>

                                <div class="masonary-menu filter-button-group d-sm-inline-block">
                                    <?php foreach ( $filter_list as $list ): ?>
                                        <?php if ( $i === 1 ): $i++; ?>
                                        <button class="active" data-filter="*"><?php echo esc_html__( 'See All','elementhelper' ); ?></button>
                                        <button data-filter=".<?php echo esc_attr( $list->slug ); ?>"><?php echo esc_html( $list->name ); ?></button>
                                        <?php else: ?>
                                        <button data-filter=".<?php echo esc_attr( $list->slug ); ?>"><?php echo esc_html( $list->name ); ?></button>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row grid">
                        <?php 
                        if ( have_posts() ) : while ( have_posts() ) : the_post();
                            $cases_author_name = function_exists('get_field') ? get_field('cases_author_name') : '';
                            $feature_image = function_exists('get_field') ? get_field('feature_image') : '';
                            $project_button = function_exists('get_field') ? get_field('project_button') : '';
                            $item_classes = '';
                            $item_cat_names = '';
                            $item_cats = get_the_terms( get_the_id(), $taxonomy );
                            if( !empty($item_cats) ):
                                $count = count($item_cats) - 1;
                                foreach($item_cats as $key => $item_cat) {
                                    $item_classes .= $item_cat->slug . ' ';
                                    $item_cat_names .= ( $count > $key ) ? $item_cat->name  . ', ' : $item_cat->name;
                                }
                            endif;
                        ?>
                        <div class="<?php echo (!empty($feature_image[0]) && $feature_image[0] == 'yes') ? 'col-xl-8 col-lg-8' : 'col-xl-4 col-lg-4'; ?> col-md-6 col-sm-6 grid-item <?php echo $item_classes; ?>">
                            <div class="portfolio__item p-relative mb-30">
                                <div class="portfolio__thumb w-img fix">
                                    <?php if ( has_post_thumbnail() ): ?>
                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="case">
                                    <?php endif; ?>
                                    <div class="portfolio__plus p-absolute transition-3">
                                        <a href="<?php echo get_the_post_thumbnail_url(); ?>" data-fancybox="gallery">
                                            <i class="fal fa-plus"></i>
                                            <i class="fal fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="portfolio__content">
                                    <h4><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h4>
                                    <p><?php echo esc_html($item_cat_names); ?></p>
                                    <div class="portfolio__more p-absolute transition-3">
                                        <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="link-btn-2">
                                            <?php print esc_html($project_button); ?> 
                                            <i class="fal fa-long-arrow-right"></i>
                                            <i class="fal fa-long-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; 
                        wp_reset_query();
                        endif; ?>
                    </div>
                    <div class="row d-none">
                        <div class="col-xl-2">
                            <div class="portfolio__load mt-25">
                                <a href="https://www.devsnews.com/wp/zibber/portfolio/" class="z-btn z-btn-border"><i class="fal fa-redo"></i> Load more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


		<?php
		else:
			printf( '%1$s',
				__( 'No  Posts  Found', 'elementhelper' )
			);
		endif;

		 else: 
		if ( !empty($terms_ids) && count( $posts ) !== 0 ) :?>

            <section <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="case__menu text-center mb-40 wow fadeInUp" data-wow-delay=".6s">
                                <div <?php $this->print_render_attribute_string( 'project-filter' ); ?>>
                                    <?php foreach ( $filter_list as $list ): ?>
                                        <?php if ( $i === 1 ): $i++; ?>
                                        <button class="active" data-filter="*"><?php echo esc_html( 'All' ); ?></button>
                                        <button data-filter=".<?php echo esc_attr( $list->slug ); ?>"><?php echo esc_html( $list->name ); ?></button>
                                        <?php else: ?>
                                        <button data-filter=".<?php echo esc_attr( $list->slug ); ?>"><?php echo esc_html( $list->name ); ?></button>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row grid">
                        <?php 
                        if ( have_posts() ) : while ( have_posts() ) : the_post();
                            $cases_author_name = function_exists('get_field') ? get_field('cases_author_name') : '';
                            $feature_image = function_exists('get_field') ? get_field('feature_image') : '';
                            $item_classes = '';
                            $item_cat_names = '';
                            $item_cats = get_the_terms( get_the_id(), $taxonomy );
                            if( !empty($item_cats) ):
                                $count = count($item_cats) - 1;
                                foreach($item_cats as $key => $item_cat) {
                                    $item_classes .= $item_cat->slug . ' ';
                                    $item_cat_names .= ( $count > $key ) ? $item_cat->name  . ', ' : $item_cat->name;
                                }
                            endif;
                        ?>
                        <div class="<?php echo (!empty($feature_image[0]) && $feature_image[0] == 'yes') ? 'col-xl-6 col-lg-6' : 'col-xl-3 col-lg-3'; ?> col-md-6 grid-item <?php echo $item_classes; ?> fadeInUp" data-wow-delay=".2s">
                            <div class="case__item mb-30 fix">
                                <div class="case__thumb w-img p-relative">
                                    <?php if ( has_post_thumbnail() ): ?>
                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="case">
                                    <?php endif; ?>
                                    <div class="case__info p-absolute transition-3">
                                        <h4><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h4>
                                        <span><?php echo esc_html($item_cat_names); ?></span>
                                    </div>
                                    <div class="case__info case__info-2 p-absolute transition-3">
                                        <h4><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a></h4>
                                        <span><?php echo esc_html($item_cat_names); ?></span>
                                    </div>
                                    <div class="case__plus p-absolute transition-3">
                                        <a href="<?php echo get_the_post_thumbnail_url(); ?>" data-fancybox="gallery">
                                            <i class="fal fa-plus"></i>
                                            <i class="fal fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; 
                        wp_reset_query();
                        endif; ?>
                    </div>
                </div>
            </section>

		<?php else:
			printf( '%1$s',
				__( 'No  Posts  Found', 'elementhelper' )
			);
		endif; 
		endif;
		

	}
}
