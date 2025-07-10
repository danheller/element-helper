<?php

namespace ElementHelper\Widget;

use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class History extends Element_El_Widget {

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
		return 'history';
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
		return __( 'History', 'elementhelper' );
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
		return 'eicon-button';
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
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_features_list',
			[
				'label' => __( 'Features List', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'label'       => __( 'Title', 'elementhelper' ),
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
				'placeholder' => __( 'Type description here', 'elementhelper' ),
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
			]
		);

		$this->end_controls_section();


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
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'ElhInfo Box Title', 'elementhelper' ),
				'placeholder' => __( 'Type Info Box Title', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
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
		$settings = $this->get_settings_for_display(); ?>
		<?php if ( $settings['design_style'] === 'style_1' ): ?>
            <div class="history-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="history-title text-center mb-40">
	                            <?php if ( $settings['title'] ) : ?>
                                    <h3 class="title"><?php echo elh_element_kses_basic( $settings['title'] ); ?></h3>
	                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row history-wrapper">
						<?php foreach ( $settings['slides'] as $key => $slide ) :
							$history_col = "col-lg-6 text-lg-end text-start";
							if ( $key % 2 == 0 ) {
								$history_col = "col-lg-6 offset-lg-6";
							}
							?>
                            <div class="<?php echo esc_attr( $history_col ); ?>">
                                <div class="history-wrap">
									<?php if ( $slide['title'] ) : ?>
                                        <h4 class="title"><?php echo elh_element_kses_basic( $slide['title'] ); ?></h4>
									<?php endif; ?>
									<?php if ( $slide['description'] ) : ?>
                                        <p><?php echo elh_element_kses_basic( $slide['description'] ); ?></p>
									<?php endif; ?>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
		<?php
		endif;
	}
}
