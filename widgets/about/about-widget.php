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

class About extends Element_El_Widget {

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
		return 'about';
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
		return __( 'About', 'elementhelper' );
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
		return 'eicon-single-post';
	}

	public function get_keywords() {
		return [ 'info', 'blurb', 'box', 'about', 'content' ];
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

		$this->add_control(
			'title',
			[
				'label'       => __( 'Section Title', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => __( 'Section Title', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'       => __( 'Button Text', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'btn_link',
			[
				'label'       => __( 'Button Link', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_about_1',
			[
				'label' => __( 'About left', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'a_title_1',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'a_sub_title_1',
			[
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'a_description_1',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_about_2',
			[
				'label' => __( 'About left', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'a_title_2',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'a_sub_title_2',
			[
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'a_description_2',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
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
		?>
		<?php if ( $settings['design_style'] === 'style_6' ): ?>

		<?php else: ?>
            <div class="info-area pt-150 pb-150">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="section-title text-center mb-65">
								<?php if ( ! empty( $settings['title'] ) ): ?>
                                    <h2 class="title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['title'] ); ?>
                                    </h2>
								<?php endif; ?>
								<?php if ( ! empty( $settings['description'] ) ): ?>
                                    <p data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['description'] ); ?>
                                    </p>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-9">
                            <div class="info-wrapper-wrap" data-aos="fade-up" data-aos-delay="500"
                                 data-aos-duration="1000">
                                <div class="info-wrapper">
                                    <div class="info-layout">
                                        <div class="info-item">
                                            <div class="title-wrap">
												<?php if ( ! empty( $settings['a_title_1'] ) ): ?>
                                                    <h4 class="title">
														<?php echo elh_element_kses_intermediate( $settings['a_title_1'] ); ?>
                                                    </h4>
												<?php endif; ?>
												<?php if ( ! empty( $settings['a_sub_title_1'] ) ): ?>
                                                    <p class="sub-title">
														<?php echo elh_element_kses_intermediate( $settings['a_sub_title_1'] ); ?>
                                                    </p>
												<?php endif; ?>
                                            </div>
											<?php if ( ! empty( $settings['a_description_1'] ) ): ?>
                                                <div class="info-separator"></div>
                                                <div class="text">
                                                    <p>
														<?php echo elh_element_kses_intermediate( $settings['a_description_1'] ); ?>
                                                    </p>
                                                </div>
											<?php endif; ?>
                                        </div>
                                        <div class="info-item">
                                            <div class="title-wrap">
												<?php if ( ! empty( $settings['a_title_2'] ) ): ?>
                                                    <h4 class="title">
														<?php echo elh_element_kses_intermediate( $settings['a_title_2'] ); ?>
                                                    </h4>
												<?php endif; ?>
												<?php if ( ! empty( $settings['a_sub_title_2'] ) ): ?>
                                                    <p class="sub-title">
														<?php echo elh_element_kses_intermediate( $settings['a_sub_title_2'] ); ?>
                                                    </p>
												<?php endif; ?>
                                            </div>
											<?php if ( ! empty( $settings['a_description_2'] ) ): ?>
                                                <div class="info-separator"></div>
                                                <div class="text">
                                                    <p>
														<?php echo elh_element_kses_intermediate( $settings['a_description_2'] ); ?>
                                                    </p>
                                                </div>
											<?php endif; ?>
                                        </div>
                                    </div>
									<?php if ( ! empty( $settings['btn_link'] ) ): ?>
                                        <div class="info-btn-wrap text-center">
                                            <a href="<?php echo esc_url( $settings['btn_link'] ); ?>">
                                            <span class="icon">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </span>
												<?php echo elh_element_kses_intermediate( $settings['btn_text'] ); ?>
                                            </a>
                                        </div>
									<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php endif; ?>
		<?php
	}
}
