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

class Featured_List extends Element_El_Widget {

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
		return 'featured_list';
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
		return __( 'Featured List', 'elementhelper' );
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
					'style_2' => __( 'Style 2', 'elementhelper' ),
					'style_3' => __( 'Style 3', 'elementhelper' ),
					'style_4' => __( 'Style 4', 'elementhelper' ),
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
				'condition'   => [
					'design_style' => 'style_1'
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_feature_1',
			[
				'label'     => __( 'Featured Content 1', 'elementhelper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_style' => 'style_1'
				],
			]
		);

		$this->add_control(
			'f_title_1',
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
			'f_description_1',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_btn_text_1',
			[
				'label'       => __( 'Btn Text', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_btn_link_1',
			[
				'label'       => __( 'Btn Link', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_image_1',
			[
				'label'   => __( 'Image 1', 'elementhelper' ),
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
			'f_image_2',
			[
				'label'   => __( 'Image 2', 'elementhelper' ),
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

		$this->start_controls_section(
			'_section_feature_2',
			[
				'label'     => __( 'Featured Content 2', 'elementhelper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_style' => 'style_2'
				],
			]
		);

		$this->add_control(
			'f_title_2',
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
			'f_description_2',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_description_2_2',
			[
				'label'       => __( 'Description 2', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_btn_text_2',
			[
				'label'       => __( 'Btn Text', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_btn_link_2',
			[
				'label'       => __( 'Btn Link', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_image_2_1',
			[
				'label'   => __( 'Image 1', 'elementhelper' ),
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
			'f_image_2_2',
			[
				'label'   => __( 'Image 2', 'elementhelper' ),
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
			'f_image_2_3',
			[
				'label'   => __( 'Image 3', 'elementhelper' ),
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
			'f_image_2_4',
			[
				'label'   => __( 'Image 4', 'elementhelper' ),
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

		$this->start_controls_section(
			'_section_feature_3',
			[
				'label'     => __( 'Featured Content 3', 'elementhelper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_style' => 'style_3'
				],
			]
		);

		$this->add_control(
			'f_title_3',
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
			'f_description_3',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_description_3_2',
			[
				'label'       => __( 'Description 2', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_btn_text_3',
			[
				'label'       => __( 'Btn Text', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_btn_link_3',
			[
				'label'       => __( 'Btn Link', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_image_3_1',
			[
				'label'   => __( 'Image 1', 'elementhelper' ),
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
			'f_list_text_1',
			[
				'label'       => __( 'List Text 1', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_list_text_2',
			[
				'label'       => __( 'List Text 2', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_list_text_3',
			[
				'label'       => __( 'List Text 3', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_list_text_4',
			[
				'label'       => __( 'List Text 4', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_feature_4',
			[
				'label'     => __( 'Featured Content 4', 'elementhelper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'design_style' => 'style_4'
				],
			]
		);

		$this->add_control(
			'f_title_4',
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
			'f_description_4',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_description_4_2',
			[
				'label'       => __( 'Description 2', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_btn_text_4',
			[
				'label'       => __( 'Btn Text', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'f_btn_link_4',
			[
				'label'       => __( 'Btn Link', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
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

		$this->add_control(
			'features_4',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Feature Item"); #>'
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
		$settings        = $this->get_settings_for_display();
		?>

		<?php if ( $settings['design_style'] === 'style_4' ): ?>
            <div class="feature-area pt-100 pb-150 pt-md-100 pt-xs-100 pb-md-100 pb-xs-100">
                <div class="container">
                    <div class="row align-items-center">
						<?php if ( ! empty( $settings['features_4'] ) ): ?>
                            <div class="col-xl-6 col-lg-7 mb-md-50 mb-xs-50">
                                <div class="feature-list-wrapper">
									<?php
									$count = 3;
									foreach ( $settings['features_4'] as $features ):
										$image = ( ! empty( $features['image']['id'] ) ) ? wp_get_attachment_image_url( $features['image']['id'], 'full' ) : '';
										?>
                                        <div class="feature-list-wrap" data-aos="fade-up"
                                             data-aos-delay="<?php echo $count; ?>00" data-aos-duration="1000">
											<?php if ( ! empty( $image ) ): ?>
                                                <div class="thumb">
                                                    <img src="<?php echo $image ?>" alt="thumb">
                                                </div>
											<?php endif; ?>

											<?php if ( ! empty( $features['title'] ) ) : ?>
                                                <div class="title">
                                                    <h4><?php echo elh_element_kses_basic( $features['title'] ); ?></h4>
                                                </div>
											<?php endif; ?>
                                        </div>
										<?php $count ++; endforeach; ?>
                                </div>
                            </div>
						<?php endif; ?>
                        <div class="col-xl-6 col-lg-5">
                            <div class="feature-content-4">
								<?php if ( ! empty( $settings['f_title_4'] ) ): ?>
                                    <h2 class="title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['f_title_4'] ); ?>
                                    </h2>
								<?php endif; ?>

								<?php if ( ! empty( $settings['f_description_4'] ) ): ?>
                                    <div class="text" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                                        <p>
											<?php echo elh_element_kses_intermediate( $settings['f_description_4'] ); ?>
                                        </p>
                                        <p>
											<?php echo elh_element_kses_intermediate( $settings['f_description_4_2'] ); ?>
                                        </p>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $settings['f_btn_text_4'] ) ): ?>
                                    <a href="<?php echo esc_url( $settings['f_btn_text_4'] ) ?>" class="read-more"
                                       data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
										<?php echo elh_element_kses_intermediate( $settings['f_btn_text_4'] ); ?>
                                    </a>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		<?php elseif ( $settings['design_style'] === 'style_3' ):
			$f_image_3_1 = ! empty( $settings['f_image_3_1']['url'] ) ? wp_get_attachment_image_url( $settings['f_image_3_1']['id'], 'full' ) : '';
			?>

            <div class="feature-area pt-165 pb-65 pt-md-100 pt-xs-100 pb-lg-10 pb-md-10 pb-xs-10">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-lg-6 order-lg-1 order-2">
                            <div class="feature-content-3">
								<?php if ( ! empty( $settings['f_title_3'] ) ): ?>
                                    <h2 class="title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['f_title_3'] ); ?>
                                    </h2>
								<?php endif; ?>

								<?php if ( ! empty( $settings['f_description_3'] ) ): ?>
                                    <div class="text" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                                        <p>
											<?php echo elh_element_kses_intermediate( $settings['f_description_3'] ); ?>
                                        </p>
                                        <p>
											<?php echo elh_element_kses_intermediate( $settings['f_description_3_2'] ); ?>
                                        </p>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $settings['f_btn_text_3'] ) ): ?>
                                    <a href="<?php echo esc_url( $settings['f_btn_text_3'] ) ?>" class="read-more"
                                       data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
										<?php echo elh_element_kses_intermediate( $settings['f_btn_text_3'] ); ?>
                                    </a>
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 order-lg-2 order-1 mb-md-70 mb-xs-50 text-lg-start text-center">
                            <div class="feature-thumb-wrapper-2 text-center">
								<?php if ( ! empty( $f_image_3_1 ) ): ?>
                                    <div class="feature-thumb-5 mb-40" data-aos="fade-up" data-aos-delay="400"
                                         data-aos-duration="1000">
                                        <img src="<?php echo $f_image_3_1; ?>" alt="thumb">
										<?php if ( ! empty( $settings['f_list_text_1'] ) ): ?>
                                            <div class="feature-list-1">
                                            <span data-aos="zoom-in" data-aos-delay="800" data-aos-duration="1000">
                                                <?php echo elh_element_kses_intermediate( $settings['f_list_text_1'] ); ?>
                                            </span>
                                            </div>
										<?php endif; ?>
										<?php if ( ! empty( $settings['f_list_text_2'] ) ): ?>
                                            <div class="feature-list-2">
                                            <span data-aos="zoom-in" data-aos-delay="1000" data-aos-duration="1000">
                                                <?php echo elh_element_kses_intermediate( $settings['f_list_text_2'] ); ?>
                                            </span>
                                            </div>
										<?php endif; ?>
										<?php if ( ! empty( $settings['f_list_text_3'] ) ): ?>
                                            <div class="feature-list-3">
                                            <span data-aos="zoom-in" data-aos-delay="1200" data-aos-duration="1000">
                                                <?php echo elh_element_kses_intermediate( $settings['f_list_text_3'] ); ?>
                                            </span>
                                            </div>
										<?php endif; ?>
										<?php if ( ! empty( $settings['f_list_text_4'] ) ): ?>
                                            <div class="feature-list-4">
                                                <span data-aos="zoom-in" data-aos-delay="1400" data-aos-duration="1000">
                                                    <?php echo elh_element_kses_intermediate( $settings['f_list_text_4'] ); ?>
                                                </span>
                                            </div>
										<?php endif; ?>
                                    </div>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		<?php elseif ( $settings['design_style'] === 'style_2' ):
			$f_image_2_1 = ! empty( $settings['f_image_2_1']['url'] ) ? wp_get_attachment_image_url( $settings['f_image_2_1']['id'], 'full' ) : '';
			$f_image_2_2 = ! empty( $settings['f_image_2_2']['url'] ) ? wp_get_attachment_image_url( $settings['f_image_2_2']['id'], 'full' ) : '';
			$f_image_2_3 = ! empty( $settings['f_image_2_3']['url'] ) ? wp_get_attachment_image_url( $settings['f_image_2_3']['id'], 'full' ) : '';
			$f_image_2_4 = ! empty( $settings['f_image_2_4']['url'] ) ? wp_get_attachment_image_url( $settings['f_image_2_4']['id'], 'full' ) : '';
			?>

            <div class="feature-area pt-120 pt-md-100 pt-xs-100 pb-md-100 pb-xs-50">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-lg-6 mb-md-50 mb-xs-50 text-lg-start text-center">
                            <div class="feature-thumb-wrapper">
								<?php if ( ! empty( $f_image_2_1 ) ): ?>
                                    <div class="feature-thumb-3 mb-40" data-aos="fade-up" data-aos-delay="300"
                                         data-aos-duration="1000">
                                        <img src="<?php echo $f_image_2_1; ?>" alt="thumb">
                                    </div>
								<?php endif; ?>
                                <div class="feature-thumb-group">
									<?php if ( ! empty( $f_image_2_2 ) ): ?>
                                        <div class="feature-thumb-4" data-aos="fade-up" data-aos-delay="400"
                                             data-aos-duration="1000">
                                            <img src="<?php echo $f_image_2_2; ?>" alt="thumb">
                                        </div>
									<?php endif; ?>
									<?php if ( ! empty( $f_image_2_3 ) ): ?>
                                        <div class="feature-thumb-4" data-aos="fade-up" data-aos-delay="500"
                                             data-aos-duration="1000">
                                            <img src="<?php echo $f_image_2_3; ?>" alt="thumb">
                                        </div>
									<?php endif; ?>
									<?php if ( ! empty( $f_image_2_4 ) ): ?>
                                        <div class="feature-thumb-4" data-aos="fade-up" data-aos-delay="600"
                                             data-aos-duration="1000">
                                            <img src="<?php echo $f_image_2_4; ?>" alt="thumb">
                                        </div>
									<?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="feature-content-2">
								<?php if ( ! empty( $settings['f_title_2'] ) ): ?>
                                    <h2 class="title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['f_title_2'] ); ?>
                                    </h2>
								<?php endif; ?>
								<?php if ( ! empty( $settings['f_description_2'] ) ): ?>
                                    <div class="text" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                                        <p>
											<?php echo elh_element_kses_intermediate( $settings['f_description_2'] ); ?>
                                        </p>
                                        <p>
											<?php echo elh_element_kses_intermediate( $settings['f_description_2_2'] ); ?>
                                        </p>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $settings['f_btn_text_2'] ) ): ?>
                                    <a href="<?php echo esc_url( $settings['f_btn_text_2'] ) ?>" class="read-more"
                                       data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
										<?php echo elh_element_kses_intermediate( $settings['f_btn_text_2'] ); ?>
                                    </a>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		<?php else:
			$f_image_1 = ! empty( $settings['f_image_1']['url'] ) ? wp_get_attachment_image_url( $settings['f_image_1']['id'], 'full' ) : '';
			$f_image_2   = ! empty( $settings['f_image_2']['url'] ) ? wp_get_attachment_image_url( $settings['f_image_2']['id'], 'full' ) : '';
			?>
            <div class="feature-area pt-150 pt-md-100 pt-xs-100">
                <div class="container">
					<?php if ( ! empty( $settings['title'] ) ) : ?>
                        <div class="row">
                            <div class="col-xl-12" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <div class="section-title text-center mb-65">
                                    <h2 class="title"><?php echo elh_element_kses_intermediate( $settings['title'] ); ?></h2>
                                </div>
                            </div>
                        </div>
					<?php endif; ?>
                    <div class="row align-items-center">
                        <div class="col-xl-5 col-lg-6 order-lg-1 order-2">
                            <div class="feature-content">
								<?php if ( ! empty( $settings['f_title_1'] ) ): ?>
                                    <h2 class="title" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
										<?php echo elh_element_kses_intermediate( $settings['f_title_1'] ); ?>
                                    </h2>
								<?php endif; ?>
								<?php if ( ! empty( $settings['f_description_1'] ) ): ?>
                                    <div class="text" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
                                        <p>
											<?php echo elh_element_kses_intermediate( $settings['f_description_1'] ); ?>
                                        </p>
                                    </div>
								<?php endif; ?>
								<?php if ( ! empty( $settings['f_btn_text_1'] ) ): ?>
                                    <a href="<?php echo esc_url( $settings['f_btn_text_1'] ) ?>" class="read-more"
                                       data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                                        <span class="icon">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </span>
										<?php echo elh_element_kses_intermediate( $settings['f_btn_text_1'] ); ?>
                                    </a>
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xl-5 offset-xl-1 col-lg-6 order-lg-2 order-1 mb-md-50 mb-xs-50 text-lg-start text-center">
							<?php if ( ! empty( $f_image_1 ) ): ?>
                                <div class="feature-thumb-1 text-center" data-aos="fade-up" data-aos-delay="500"
                                     data-aos-duration="1000">
                                    <img src="<?php echo $f_image_1; ?>" alt="thumb">
                                </div>
							<?php endif; ?>
							<?php if ( ! empty( $f_image_2 ) ): ?>
                                <div class="feature-thumb-2" data-aos="fade-up" data-aos-delay="600"
                                     data-aos-duration="1000">
                                    <img src="<?php echo $f_image_2; ?>" alt="thumb">
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
		<?php endif; ?>
		<?php
	}

}
