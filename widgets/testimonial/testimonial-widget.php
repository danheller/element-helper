<?php

namespace ElementHelper\Widget;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Control_Media;
use \Elementor\Core\Schemes\Typography;
use Elementor\Repeater;
use \Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Testimonial extends Element_El_Widget {

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
		return 'testimonial';
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
		return __( 'Testimonial', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/testimonial/';
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
		return 'eicon-blockquote';
	}

	public function get_keywords() {
		return [ 'testimonial', 'review', 'feedback' ];
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
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_testimonial',
			[
				'label' => __( 'Testimonial', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'content',
			[
				'label'       => __( 'Message', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);


		$repeater->add_control(
			'name',
			[
				'label'       => __( 'Author Name', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'destination',
			[
				'label'       => __( 'Author Destination', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'testimonials',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(name || "Testimonial Item"); #>'
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
		?>
		<?php if ( $settings['design_style'] === 'style_2' ): ?>
		<?php else: ?>
            <div class="testimonial-area pt-150 pb-115 pt-md-100 pb-md-100 pt-xs-100 pb-xs-100">
                <div class="container">
					<?php if ( ! empty( $settings['title'] ) ): ?>
                        <div class="row">
                            <div class="col-xl-12" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <div class="section-title text-center mb-35">
                                    <h2 class="title">
										<?php echo elh_element_kses_intermediate( $settings['title'] ); ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['testimonials'] ) ): ?>
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="testimonial-slider-active" data-aos="fade-up" data-aos-delay="500"
                                     data-aos-duration="1000">
                                    <div class="swiper-container">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper">
											<?php foreach ( $settings['testimonials'] as $testimonial ):
												$image = ( ! empty( $testimonial['image']['id'] ) ) ? wp_get_attachment_image_url( $testimonial['image']['id'], 'full' ) : '';
												?>
                                                <div class="swiper-slide single-slide">
                                                    <div class="testimonial-wrap">
                                                        <?php if($image): ?>
                                                            <div class="thumb">
                                                                <img src="<?php echo $image?>" alt="thumb">
                                                            </div>
                                                        <?php endif; ?>
														<?php if ( ! empty( $testimonial['content'] ) ) : ?>
                                                            <div class="text">
                                                                <p>
																	<?php echo elh_element_kses_basic( $testimonial['content'] ); ?>
                                                                </p>
                                                            </div>
														<?php endif; ?>
                                                        <div class="author">
															<?php if ( ! empty( $testimonial['name'] ) ) : ?>
                                                                <h4 class="name">
																	<?php echo elh_element_kses_basic( $testimonial['name'] ); ?>
                                                                </h4>
															<?php endif; ?>
															<?php if ( ! empty( $testimonial['destination'] ) ) : ?>
                                                                <p>
																	<?php echo elh_element_kses_basic( $testimonial['destination'] ); ?>
                                                                </p>
															<?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
											<?php endforeach; ?>
                                        </div>
                                    </div>
                                    <!-- If we need pagination -->
                                    <div class="swiper-pagination"></div>
                                    <!-- If we need navigation buttons -->
                                    <div class="testimonial-button-prev"><i class="fa-regular fa-arrow-left"></i></div>
                                    <div class="testimonial-button-next"><i class="fa-regular fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
					<?php endif; ?>
                </div>
            </div>
		<?php endif; ?>
		<?php
	}
}
