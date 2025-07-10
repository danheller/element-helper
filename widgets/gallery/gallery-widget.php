<?php

namespace ElementHelper\Widget;

use \Elementor\Group_Control_Background;
use \Elementor\Repeater;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Gallery extends Element_El_Widget {


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
		return 'gallery';
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
		return __( 'Gallery', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/fact/';
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
		return 'eicon-photo-library';
	}

	public function get_keywords() {
		return [ 'brand', 'image', 'counter' ];
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

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_slides',
			[
				'label' => __( 'Gallery', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'large',
			[
				'label'              => __( 'Large', 'elementhelper' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Yes', 'elementhelper' ),
				'label_off'          => __( 'No', 'elementhelper' ),
				'return_value'       => 'yes',
				'default'            => 'no',
				'frontend_available' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'type'    => Controls_Manager::MEDIA,
				'label'   => __( 'Image', 'elementhelper' ),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
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
				'title_field' => esc_html__( 'Gallery Item', 'elh-elementor' ),
				'default'     => [
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
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
		?>
		<?php if ( $settings['design_style'] === 'style_2' ): ?>
		<?php else: ?>
            <div class="gallery-area">
                <div class="container">
                    <div class="row gallery-grid">
						<?php foreach ( $settings['slides'] as $key => $slide ) :
							$image = ! empty( $slide['image']['url'] ) ? wp_get_attachment_image_url( $slide['image']['id'], 'full' ) : '';

							$class_name = 'col-xl-3 col-lg-6 col-md-6 grid-item';
							if ( $slide['large'] == 'yes' ) {
								$class_name = 'col-xl-6 grid-item';
							}
							?>
                            <div class="<?php echo $class_name; ?>" data-aos="fade-up"
                                 data-aos-delay="<?php echo $key + 5; ?>000"
                                 data-aos-duration="2000">
                                <div class="gallery-wrap">
                                    <a href="<?php print esc_url( $image ); ?>" class="popup-image"
                                       data-gall="gallery-1">
                                        <img src="<?php print esc_url( $image ); ?>" alt="gallery">
                                    </a>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
                <div class="line-shape-1"></div>
                <div class="line-shape-2"></div>
                <div class="line-shape-3"></div>
            </div>

		<?php endif; ?>

		<?php
	}
}
