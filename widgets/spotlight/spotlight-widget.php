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

class Spotlight extends Element_El_Widget {

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
		return 'spotlight';
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
		return __( 'Spotlight', 'elementhelper' );
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
		return [ 'spotlight', 'list', 'icon' ];
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

		$this->add_control(
			'btn_text_1',
			[
				'label'       => __( 'Button Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
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
				'label' => __( 'Section', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'field_condition',
			[
				'label'              => __( 'Slide Style', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'style_1' => __( 'Image', 'elementhelper' ),
					'style_2' => __( 'Video', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$repeater->add_control(
			'col',
			[
				'label'              => __( 'Slide Style', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'small' => __( 'small', 'elementhelper' ),
					'large' => __( 'Large', 'elementhelper' ),
				],
				'default'            => 'small',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'     => __( 'Image', 'elementhelper' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'field_condition' => [ 'style_1', 'style_2' ],
				],
			]
		);

		$repeater->add_control(
			'video',
			[
				'label'       => __( 'Youtube Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'condition' => [
					'field_condition' => [ 'style_2' ],
				],
			]
		);

		$this->add_control(
			'lists',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print("Item"); #>'
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
        <div class="spotlight-area pt-85 pb-90 pt-xs-50 pb-xs-50">
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                    <div class="col-xl-12 text-center">
                        <div class="spotlight-title">
							<?php if ( ! empty( $settings['sub_title'] ) ): ?>
                                <p><?php echo $settings['sub_title'] ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $settings['title'] ) ): ?>
                                <h2><?php echo $settings['title'] ?></h2>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
				<?php if ( ! empty( $settings['lists'] ) ): ?>
                    <div class="row filter-grid" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
						<?php foreach ( $settings['lists'] as $item ): ?>
							<?php
							$image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : '';

							$col_class = 'col-xl-3 col-lg-3 col-md-4 grid-item';
							if ( $item['col'] == 'large' ) {
								$col_class = 'col-xl-6 col-lg-6 col-md-6 grid-item';
							}
							?>
							<?php if ( $item['field_condition'] === 'style_1' ): ?>
                                <div class="<?php echo $col_class; ?>">
                                    <div class="spotlight-thumb">
                                        <a href="<?php echo $image; ?>" class="popup-links" data-gall="gallery01">
                                            <img src="<?php echo $image; ?>" alt="thumb">
                                        </a>
                                    </div>
                                </div>
							<?php endif; ?>
							<?php if ( $item['field_condition'] === 'style_2' ): ?>
                                <div class="<?php echo $col_class; ?>">
                                    <div class="spotlight-thumb">
                                        <a href="<?php echo $item['video']; ?>"
                                           class="popup-links" data-autoplay="true" data-vbtype="video">
                                            <img src="<?php echo $image; ?>" alt="thumb">
                                            <span class="play">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/play.svg"
                                                     alt="icon">
                                            </span>
                                        </a>
                                    </div>
                                </div>
							<?php endif; ?>
						<?php endforeach; ?>
                    </div>
				<?php endif; ?>
				<?php if ( ! empty( $settings['btn_text_1'] ) ): ?>
                    <div class="row mt-10" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                        <div class="col-xl-12 text-center">
                            <div class="spotlight-btn">
                                <a href="<?php echo $settings['btn_link_1'] ?>">
									<?php echo $settings['btn_text_1'] ?>
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