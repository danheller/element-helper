<?php

namespace ElementHelper\Widget;

use \Elementor\Group_Control_Text_Shadow;
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

class Featured extends Element_El_Widget {

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
		return 'featured';
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
		return __( 'Featured', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/icon-box/';
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
		return 'eicon-preview-medium';
	}

	public function get_keywords() {
		return [ 'featured', 'list', 'icon' ];
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
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->end_controls_section();

		// section title
		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Heading', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => __( 'Image', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'day',
			[
				'label'       => __( 'Day', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'month',
			[
				'label'       => __( 'Month', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$repeater->add_control(
			'time',
			[
				'label'       => __( 'Time', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'lists',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Item"); #>'
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

	/**
	 * Render widget output on the frontend.
	 *
	 * Used to generate the final HTML displayed on the frontend.
	 *
	 * Note that if skin is selected, it will be rendered by the skin itself,
	 * not the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
        <div class="featured-area pt-55 pb-75">
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                    <div class="col-xl-12">
                        <div class="featured-title">
							<?php if ( ! empty( $settings['sub_title'] ) ): ?>
                                <p><?php echo $settings['sub_title'] ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $settings['title'] ) ): ?>
                                <h2><?php echo $settings['title'] ?></h2>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                    <div class="col-xl-12">
						<?php if ( ! empty( $settings['lists'] ) ): ?>
                            <div class="featured-slider-active">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
										<?php foreach ( $settings['lists'] as $item ): ?>
											<?php $image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : ''; ?>
                                            <div class="swiper-slide single-slide">
                                                <div class="featured-content-wrap">
                                                    <div class="thumb">
                                                        <img src="<?php echo $image; ?>" alt="thumb">
                                                    </div>
                                                    <div class="content">
                                                        <div class="date">
															<?php if ( ! empty( $item['day'] ) ): ?>
                                                                <span><?php echo $item['day'] ?></span>
															<?php endif; ?>
															<?php if ( ! empty( $item['month'] ) ): ?>
                                                                <p><?php echo $item['month'] ?></p>
															<?php endif; ?>
                                                        </div>
														<?php if ( ! empty( $item['title'] ) ): ?>
                                                            <h3><?php echo $item['title'] ?></h3>
														<?php endif; ?>
														<?php if ( ! empty( $item['time'] ) ): ?>
                                                            <div class="time">
                                                                <i class="fa-regular fa-clock"></i> <?php echo $item['time'] ?>
                                                            </div>
														<?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
										<?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="featured-button-prev">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/left-icon-1.svg"
                                         alt="icon">
                                </div>
                                <div class="featured-button-next">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/right-icon-1.svg"
                                         alt="icon">
                                </div>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

}