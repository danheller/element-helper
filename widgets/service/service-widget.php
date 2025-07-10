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

class Service extends Element_El_Widget {

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
		return 'service';
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
		return __( 'Service', 'elementhelper' );
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
		return [ 'service', 'list', 'icon' ];
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
			'btn_text_1',
			[
				'label'       => __( 'Button Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'btn_link_1',
			[
				'label'       => __( 'Button Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				]
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
			'number',
			[
				'label'       => __( 'Number', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
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
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
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
        <div class="service-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
						<?php if ( ! empty( $settings['lists'] ) ): ?>
                            <div class="service-layout d-none d-xl-grid" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
								<?php foreach ( $settings['lists'] as $item ): ?>
									<?php $image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : ''; ?>
                                    <div class="service-wrap">
                                        <div class="icon">
                                            <img src="<?php echo $image; ?>" alt="icons">
                                        </div>
                                        <div class="content">
											<?php if ( ! empty( $item['number'] ) ): ?>
                                                <span><?php echo $item['number'] ?></span>
											<?php endif; ?>
											<?php if ( ! empty( $item['title'] ) ): ?>
                                                <h4><?php echo $item['title'] ?></h4>
											<?php endif; ?>
											<?php if ( ! empty( $item['description'] ) ): ?>
                                                <p><?php echo $item['description'] ?></p>
											<?php endif; ?>
                                        </div>
                                    </div>
								<?php endforeach; ?>
                            </div>

                            <div class="service-slider-active d-block d-xl-none" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
										<?php foreach ( $settings['lists'] as $key => $item ): ?>
											<?php $image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : ''; ?>
											<?php if ( $key === 0 || $key === 2 || $key === 4 ): ?>
                                                <div class="swiper-slide single-slide">
											<?php endif; ?>
                                            <div class="service-wrap">
                                                <div class="icon">
                                                    <img src="<?php echo $image; ?>" alt="icons">
                                                </div>
                                                <div class="content">
													<?php if ( ! empty( $item['number'] ) ): ?>
                                                        <span><?php echo $item['number'] ?></span>
													<?php endif; ?>
													<?php if ( ! empty( $item['title'] ) ): ?>
                                                        <h4><?php echo $item['title'] ?></h4>
													<?php endif; ?>
													<?php if ( ! empty( $item['description'] ) ): ?>
                                                        <p><?php echo $item['description'] ?></p>
													<?php endif; ?>
                                                </div>
                                            </div>
											<?php if ( $key === 1 || $key === 3 || $key === 4 ): ?>
                                                </div>
											<?php endif; ?>
										<?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="service-control-wrap">
                                    <div class="service-button-prev"><i class="fa-regular fa-angle-left"></i></div>
                                    <div class="service-pagination"></div>
                                    <div class="service-button-next"><i class="fa-regular fa-angle-right"></i></div>
                                </div>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
				<?php if ( ! empty( $settings['btn_text_1'] ) ): ?>
                    <div class="row mt-25" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                        <div class="col-xl-12 text-center">
                            <div class="service-btn">
                                <a href="<?php echo $settings['btn_link_1']; ?>">
									<?php echo $settings['btn_text_1']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
		<?php
	}

}