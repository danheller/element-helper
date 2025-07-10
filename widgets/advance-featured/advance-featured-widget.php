<?php

namespace ElementHelper\Widget;


use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Core\Schemes\Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Advance_Featured extends Element_El_Widget {

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
		return 'advance_featured';
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
		return __( 'Advance Featured', 'elementhelper' );
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

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_icon_1',
			[
				'label' => __( 'Featured List', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'field_condition',
			[
				'label'              => __( 'Field condition', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'style_1' => __( 'Style 1(Author)', 'elementhelper' ),
					'style_2' => __( 'Style 2 (Video)', 'elementhelper' ),
					'style_3' => __( 'Style 3 (Audio)', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'type'      => Controls_Manager::MEDIA,
				'label'     => __( 'Image', 'elementhelper' ),
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'field_condition' => [ 'style_1', 'style_2' ],
				],
				'dynamic'   => [
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
				'placeholder' => __( 'Type Title', 'elementhelper' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'sub-title',
			[
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Type Sub Title', 'elementhelper' ),
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => __( 'Type Description', 'elementhelper' ),
				'condition'   => [
					'field_condition' => [ 'style_1' ],
				],
				'dynamic'     => [
					'active' => true,
				]
			]
		);

//
//		$repeater->add_control(
//			'video_link',
//			[
//				'label'       => __( 'Video Link', 'elementhelper' ),
//				'type'        => Controls_Manager::TEXT,
//				'label_block' => true,
//				'placeholder' => __( 'Video Link', 'elementhelper' ),
//				'condition'   => [
//					'field_condition' => [ 'style_2' ],
//				],
//				'dynamic'     => [
//					'active' => true,
//				]
//			]
//		);

//		$repeater->add_control(
//			'audio_link',
//			[
//				'label'       => __( 'Audio Link', 'elementhelper' ),
//				'type'        => Controls_Manager::TEXT,
//				'label_block' => true,
//				'placeholder' => __( 'Audio Link', 'elementhelper' ),
//				'condition'   => [
//					'field_condition' => [ 'style_3' ],
//				],
//				'dynamic'     => [
//					'active' => true,
//				]
//			]
//		);

		$repeater->add_control(
			'video_file',
			[
				'label'      => esc_html__( 'Video File', 'elementor' ),
				'type'       => Controls_Manager::MEDIA,
				'dynamic'    => [
					'active'     => true,
					'categories' => [
						TagsModule::MEDIA_CATEGORY,
					],
				],
				'media_type' => 'video',
				'condition'  => [
					'field_condition' => [ 'style_2' ],
				],
			]
		);

		$repeater->add_control(
			'audio_file',
			[
				'label'      => esc_html__( 'Audio File', 'elementor' ),
				'type'       => Controls_Manager::MEDIA,
				'dynamic'    => [
					'active'     => true,
					'categories' => [
						TagsModule::MEDIA_CATEGORY,
					],
				],
				'media_type' => 'audio',
				'condition'  => [
					'field_condition' => [ 'style_3' ],
				],
			]
		);


		$this->add_control(
			'features',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Carousel Item"); #>'
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
		$this->add_render_attribute( 'button', 'class', 'a-btn' );
		if ( ! empty( $settings['button_link'] ) ) {
			$this->add_link_attributes( 'button', $settings['button_link'] );
		}
		?>
        <div class="feature-area">
            <div class="container">
                <div class="row feature-wrapper mt-90 mt-lg-50 mt-md-10 mt-xs-10">
					<?php foreach ( $settings['features'] as $key => $feature ):
						$image = ( ! empty( $feature['image']['id'] ) ) ? wp_get_attachment_image_url( $feature['image']['id'], 'full' ) : '';
						?>
                        <div class="col-xl-4 col-lg-6 mb-30">
							<?php if ( $feature['field_condition'] == 'style_1' ): ?>
                                <div class="feature-box-wrap-author">
									<?php if ( ! empty( $image ) ): ?>
                                        <div class="thumb">
                                            <img src="<?php echo esc_url( $image ); ?>" alt="author">
                                        </div>
									<?php endif; ?>
									<?php if ( ! empty( $feature['description'] ) ): ?>
                                        <p>
											<?php echo elh_element_kses_basic( $feature['description'] ) ?>
                                        </p>
									<?php endif; ?>
                                    <div class="author-wrap">
										<?php if ( ! empty( $feature['title'] ) ): ?>
                                            <h5 class="name">
												<?php echo elh_element_kses_basic( $feature['title'] ) ?>
                                            </h5>
										<?php endif; ?>
										<?php if ( ! empty( $feature['sub-title'] ) ): ?>
                                            <span>
			                                <?php echo elh_element_kses_basic( $feature['sub-title'] ) ?>
                                        </span>
										<?php endif; ?>
                                    </div>
                                </div>
							<?php elseif ( $feature['field_condition'] == 'style_2' ): ?>
                                <div class="feature-box-wrap-video">
									<?php if ( ! empty( $image ) ): ?>
                                        <div class="thumb">
                                            <img src="<?php echo esc_url( $image ); ?>" alt="author">
                                        </div>
									<?php endif; ?>

									<?php if ( ! empty( $feature['video_file'] ) ): ?>
                                        <button type="button" class="popup-video" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal<?php echo $key; ?>">
                                            <i class="fas fa-play"></i>
                                        </button>

                                        <div class="modal fade" id="exampleModal<?php echo $key; ?>" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <video controls>
                                                            <source src="<?php echo $feature['video_file']['url']; ?>"
                                                                    type="video/mp4">
                                                            <source src="<?php echo $feature['video_file']['url']; ?>"
                                                                    type="video/ogg">
                                                        </video>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									<?php endif; ?>
                                </div>
							<?php else: ?>
                                <div class="feature-box-wrap-audio">
                                    <div class="audio-wrap">
	                                    <?php if ( ! empty( $feature['audio_file'] ) ): ?>
                                            <button type="button" class="popup-video" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal<?php echo $key; ?>">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <div class="shape">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/shape-3.png"
                                                     alt="shape">
                                            </div>

                                            <div class="modal fade" id="exampleModal<?php echo $key; ?>" tabindex="-1"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <audio controls>
                                                                <source src="<?php echo $feature['audio_file']['url']; ?>"
                                                                        type="audio/ogg">
                                                                <source src="<?php echo $feature['audio_file']['url']; ?>"
                                                                        type="audio/mpeg">
                                                                No audio support.
                                                            </audio>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
	                                    <?php endif; ?>
                                    </div>
                                    <div class="author-wrap">
										<?php if ( ! empty( $feature['title'] ) ): ?>
                                            <h5 class="name">
												<?php echo elh_element_kses_basic( $feature['title'] ) ?>
                                            </h5>
										<?php endif; ?>
										<?php if ( ! empty( $feature['sub-title'] ) ): ?>
                                            <span>
                                                <?php echo elh_element_kses_basic( $feature['sub-title'] ) ?>
                                            </span>
										<?php endif; ?>
                                    </div>
                                </div>
							<?php endif; ?>
                        </div>
					<?php endforeach; ?>

                </div>
            </div>
        </div>
		<?php
	}

}
