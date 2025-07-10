<?php

namespace ElementHelper\Widget;

use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;

defined( 'ABSPATH' ) || die();

class InfoBox extends Element_El_Widget {

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
		return 'infobox';
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
		return __( 'Info Box', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/info-box/';
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
		return 'eicon-lightbox-expand';
	}

	public function get_keywords() {
		return [ 'info', 'blurb', 'box', 'text', 'content' ];
	}

	/**
	 * Register content related controls
	 */
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
					'style_3' => __( 'Style 3', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_media',
			[
				'label'     => __( 'Icon / Image', 'elementhelper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_style' => [ 'style_3' ]
				],
			]
		);

		$this->add_control(
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

		$this->add_control(
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

		$this->add_group_control(
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
			$this->add_control(
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
			$this->add_control(
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

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title & Description', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Type Info Box Title', 'elementhelper' ),
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
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'ElhInfo Box Title', 'elementhelper' ),
				'placeholder' => __( 'Type Info Box Title', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'title_link',
			[
				'label'       => __( 'Title Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Type link', 'elementhelper' ),
				'condition'   => [
					'design_style' => [ 'style_3' ]
				],
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'description' => elh_element_get_allowed_html_desc( 'intermediate' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __( 'Elhinfo box description goes here', 'elementhelper' ),
				'placeholder' => __( 'Type info box description', 'elementhelper' ),
				'rows'        => 5,
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
			'_section_button',
			[
				'label'     => __( 'Button', 'elementhelper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_style' => [ 'style_10' ]
				]
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
					'condition'        => [
						'design_style' => [ 'style_2', 'style_3', 'style_6', 'style_7' ]
					]
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

	/**
	 * Register styles related controls
	 */
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
		if ( ! empty( $settings['image']['id'] ) ) {
			$image = wp_get_attachment_image_url( $settings['image']['id'], 'full' );
		}
		?>
		<?php if ( $settings['design_style'] === 'style_3' ): ?>
            <div class="blog-info-widget">
                <div class="thumb">
                    <img src="<?php echo $image ?>" alt="image">
                </div>
                <div class="content">
					<?php if ( ! empty( $settings['title'] ) ) : ?>
                        <h3 class="title">
                            <a href="<?php echo esc_url( $settings['title_link'] ) ?>">
								<?php echo elh_element_kses_basic( $settings['title'] ); ?>
                            </a>
                        </h3>
					<?php endif; ?>
                </div>
            </div>
		<?php elseif ( $settings['design_style'] === 'style_2' ): ?>
            <div class="service-wrap-4 bg-white">
				<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
                    <div class="num">
						<?php echo elh_element_kses_basic( $settings['subtitle'] ); ?>
                    </div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['title'] ) ) : ?>
                    <h3 class="title">
						<?php echo elh_element_kses_basic( $settings['title'] ); ?>
                    </h3>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description'] ) ): ?>
                    <p><?php echo elh_element_kses_intermediate( $settings['description'] ); ?></p>
				<?php endif; ?>
            </div>
		<?php else: ?>
            <div class="service-wrap-4">
				<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
                    <div class="num">
						<?php echo elh_element_kses_basic( $settings['subtitle'] ); ?>
                    </div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['title'] ) ) : ?>
                    <h3 class="title">
						<?php echo elh_element_kses_basic( $settings['title'] ); ?>
                    </h3>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description'] ) ): ?>
                    <p><?php echo elh_element_kses_intermediate( $settings['description'] ); ?></p>
				<?php endif; ?>
            </div>
		<?php endif; ?>
		<?php
	}

}
