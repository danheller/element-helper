<?php

namespace ElementHelper\Widget;

use \Elementor\Repeater;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Utils;


defined( 'ABSPATH' ) || die();

class CTA extends Element_El_Widget {


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
		return 'cta';
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
		return __( 'CTA', 'elementhelper' );
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

		//Settings
		$this->start_controls_section(
			'_section_settings',
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
					'next_steps' => __( 'Next Steps', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->end_controls_section();

		//desc
		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title & Desccription', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
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
				],
				'condition' => [
					'design_style' => ['style_1'],
				],
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'       => __( 'Button Text', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Heading Description Text', 'elementhelper' ),
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
				'placeholder' => __( 'Heading Description Text', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => __( 'Image', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
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
		$image = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';

		if ( $settings['design_style'] === 'style_2' ):
			?>
            <div class="cta-area pt-95 pb-95 mb-125 mb-xs-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-5">
                            <div class="cta-content">
								<?php if ( ! empty( $settings['title'] ) ) : ?>
                                    <h2 class="title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['title'] ); ?>
                                    </h2>
								<?php endif; ?>
								<?php if ( ! empty( $settings['btn_text'] ) ) : ?>
                                    <a href="<?php echo esc_url( $settings['btn_link'] ); ?>" class="read-more"
                                       data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
										<?php echo elh_element_kses_intermediate( $settings['btn_text'] ); ?>
                                    </a>
								<?php endif; ?>
                            </div>
                        </div>
						<?php if ( ! empty( $image ) ): ?>
                            <div class="col-xl-5 offset-lg-1 col-lg-6">
                                <div class="cta-thumb pt-md-100 pb-md-100 mt-md-150 pt-xs-50 pb-xs-50 mt-xs-150"
                                     data-aos="fade-up"
                                     data-aos-delay="500" data-aos-duration="1000">
                                    <img src="<?php echo $image ?>" alt="thumb">
                                </div>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>

		<?php else:
			?>
            <div class="about-area pt-40 pb-40">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-lg-6">
                            <div class="about-content">
								<?php if ( ! empty( $settings['title'] ) ) : ?>
                                    <h2 class="title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['title'] ); ?>
                                    </h2>
								<?php endif; ?>
								<?php if ( ! empty( $settings['description'] ) ) : ?>
                                    <p data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['description'] ); ?>
                                    </p>
								<?php endif; ?>
								<?php if ( ! empty( $settings['btn_text'] ) ) : ?>
                                    <a href="<?php echo esc_url( $settings['btn_link'] ); ?>" class="read-more"
                                       data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
										<?php echo elh_element_kses_intermediate( $settings['btn_text'] ); ?>
                                    </a>
								<?php endif; ?>
                            </div>
                        </div>
						<?php if ( ! empty( $image ) ): ?>
                            <div class="col-xl-6 col-lg-6 text-lg-end text-start mt-md-30 mt-xs-30">
                                <div class="about-thumb" data-aos="fade-up" data-aos-delay="600"
                                     data-aos-duration="1000">
                                    <img src="<?php echo $image ?>" alt="thumb">
                                </div>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
		<?php endif; ?>
		<?php
	}
}
