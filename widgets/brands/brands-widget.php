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

class Brands extends Element_El_Widget {

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
		return 'brands';
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
		return __( 'Brands', 'elementhelper' );
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
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
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
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'btn_text',
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
			'btn_link',
			[
				'label'       => __( 'Button Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				]
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

		$this->add_control(
			'brands',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print("brand Item"); #>'
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
		<?php if ( $settings['design_style'] === 'style_2' ): ?>
		<?php else:
			$image = ( ! empty( $settings['image']['id'] ) ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';
			?>
            <div class="brand-section pt-80 pb-80">
                <div class="container">
                    <div class="row">
						<?php if ( ! empty( $settings['title'] ) ): ?>
                            <div class="col-xl-12 mb-65" data-aos="fade-up" data-aos-delay="300"
                                 data-aos-duration="1000">
                                <div class="brand-title text-center">
                                    <h2 class="title">
										<?php echo elh_element_kses_intermediate( $settings['title'] ); ?>
                                    </h2>
                                </div>
                            </div>
						<?php endif; ?>
                        <div class="col-xl-12 d-none d-lg-block">
                            <div class="brand-wrap" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
								<?php foreach ( $settings['brands'] as $key => $brand ):
									$image = ( ! empty( $brand['image']['id'] ) ) ? wp_get_attachment_image_url( $brand['image']['id'], 'full' ) : '';
									if ( $key <= 4 ):
										?>
										<?php if ( ! empty( $image ) ): ?>
                                        <div class="brand-item">
                                            <img src="<?php echo $image ?>" alt="brand">
                                        </div>
									<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
                            </div>
                            <div class="brand-wrap mt-60" data-aos="fade-up" data-aos-delay="600"
                                 data-aos-duration="1000">
								<?php foreach ( $settings['brands'] as $key => $brand ):
									$image = ( ! empty( $brand['image']['id'] ) ) ? wp_get_attachment_image_url( $brand['image']['id'], 'full' ) : '';
									if ( $key > 4 ):
										?>
										<?php if ( ! empty( $image ) ): ?>
                                        <div class="brand-item">
                                            <img src="<?php echo $image ?>" alt="brand">
                                        </div>
									<?php endif; endif; ?>
								<?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-xl-12 d-block d-lg-none">
                            <div class="brand-wrap" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
								<?php foreach ( $settings['brands'] as $key => $brand ):
									$image = ( ! empty( $brand['image']['id'] ) ) ? wp_get_attachment_image_url( $brand['image']['id'], 'full' ) : '';
									?>
									<?php if ( ! empty( $image ) ): ?>
                                    <div class="brand-item">
                                        <img src="<?php echo $image ?>" alt="brand">
                                    </div>
								<?php endif; ?>
								<?php endforeach; ?>
                            </div>
                        </div>
						<?php if ( ! empty( $settings['btn_text'] ) ): ?>
                            <div class="col-xl-12 mt-60" data-aos="fade-up" data-aos-delay="700"
                                 data-aos-duration="1000">
                                <div class="brand-btn">
                                    <a href="<?php echo esc_url( $settings['btn_link'] ); ?>">
										<?php echo elh_element_kses_intermediate( $settings['btn_text'] ); ?>
                                    </a>
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
