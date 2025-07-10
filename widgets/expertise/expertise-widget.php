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

class Expertise extends Element_El_Widget {

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
		return 'expertise';
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
		return __( 'Expertise', 'elementhelper' );
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
		return [ 'expertise', 'list', 'icon' ];
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
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_e1',
			[
				'label' => __( 'Section 1', 'elementhelper' ),
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
			'cat_name',
			[
				'label'       => __( 'Category Name', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);
		$repeater->add_control(
			'cat_link',
			[
				'label'       => __( 'Category Link', 'elementhelper' ),
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
			'date',
			[
				'label'       => __( 'Date', 'elementhelper' ),
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


		$this->start_controls_section(
			'_section_e1',
			[
				'label' => __( 'Section 1', 'elementhelper' ),
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
			'title2',
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

		$repeater->add_control(
			'button_text_1',
			[
				'label'       => __( 'Button Text 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'button_link_1',
			[
				'label'       => __( 'Button Button 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
			]
		);


		$this->add_control(
			'lists_2',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title2 || "Item"); #>'
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
        <div class="expertise-area pt-115 pb-155 pt-lg-100 pb-lg-100 pt-md-100 pb-md-100 pt-xs-60 pb-xs-30">
            <div class="container">
				<?php if ( ! empty( $settings['title'] ) ): ?>
                    <div class="row" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                        <div class="col-xl-12">
                            <div class="expertise-title">
                                <h3><?php echo $settings['title'] ?></h3>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ( ! empty( $settings['lists'] ) ): ?>
                    <div class="row d-none d-lg-flex" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
						<?php foreach ( $settings['lists'] as $item ): ?>
							<?php $image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : ''; ?>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="expertise-content-wrap">
                                    <div class="thumb">
                                        <img src="<?php echo $image; ?>" alt=thumb">
                                    </div>
                                    <div class="content">
										<?php if ( ! empty( $item['cat_name'] ) ): ?>
                                            <div class="tag">
                                                <a href="<?php echo $item['cat_link'] ?>">
													<?php echo $item['cat_name'] ?>
                                                </a>
                                            </div>
										<?php endif; ?>
										<?php if ( ! empty( $item['title'] ) ): ?>
                                            <h4><?php echo $item['title'] ?></h4>
										<?php endif; ?>
										<?php if ( ! empty( $item['date'] ) ): ?>
                                            <p><?php echo $item['date'] ?></p>
										<?php endif; ?>
                                    </div>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                    <div class="row mb-40 d-flex d-lg-none" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                        <div class="col-xl-12">
                            <div class="expertise-slider-active">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
										<?php foreach ( $settings['lists'] as $item ): ?>
											<?php $image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : ''; ?>
                                            <div class="swiper-slide single-slide">
                                                <div class="expertise-content-wrap">
                                                    <div class="thumb">
                                                        <img src="<?php echo $image; ?>" alt=thumb">
                                                    </div>
                                                    <div class="content">
														<?php if ( ! empty( $item['cat_name'] ) ): ?>
                                                            <div class="tag">
                                                                <a href="<?php echo $item['cat_link'] ?>">
																	<?php echo $item['cat_name'] ?>
                                                                </a>
                                                            </div>
														<?php endif; ?>
														<?php if ( ! empty( $item['title'] ) ): ?>
                                                            <h4><?php echo $item['title'] ?></h4>
														<?php endif; ?>
														<?php if ( ! empty( $item['date'] ) ): ?>
                                                            <p><?php echo $item['date'] ?></p>
														<?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
										<?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="expertise-control-wrap">
                                    <div class="expertise-button-prev"><i class="fa-regular fa-angle-left"></i></div>
                                    <div class="expertise-pagination"></div>
                                    <div class="expertise-button-next"><i class="fa-regular fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ( ! empty( $settings['lists_2'] ) ): ?>
                    <div class="row" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
						<?php foreach ( $settings['lists_2'] as $item ): ?>
							<?php $image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : ''; ?>
                            <div class="col-xl-4 col-lg-6 mb-30">
                                <div class="expertise-card-wrap">
                                    <div class="thumb">
                                        <img src="<?php echo $image; ?>" alt=thumb">
                                    </div>
                                    <div class="card-content">
										<?php if ( ! empty( $item['title2'] ) ): ?>
                                            <div class="card-content-top">
                                                <h3>
													<?php echo $item['title2'] ?>
                                                </h3>
                                            </div>
										<?php endif; ?>
										<?php if ( ! empty( $item['description'] ) ): ?>
                                            <p><?php echo $item['description'] ?></p>
										<?php endif; ?>
										<?php if ( ! empty( $item['button_text_1'] ) ): ?>
                                            <div class="read-more">
                                                <a href="<?php echo $item['button_link_1'] ?>">
													<?php echo $item['button_text_1'] ?>
                                                </a>
                                            </div>
										<?php endif; ?>
                                    </div>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
		<?php
	}

}