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

class Programs extends Element_El_Widget {

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
		return 'programs';
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
		return __( 'Programs', 'elementhelper' );
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
		return [ 'programs', 'list', 'icon' ];
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
			'field_condition',
			[
				'label'              => __( 'Slide Style', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'style_1' => __( 'Style 1', 'elementhelper' ),
					'style_2' => __( 'Style 2', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

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

		$repeater->add_control(
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

		$repeater->add_control(
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
        <div class="programs-area pt-170 pb-200 pt-lg-100 pb-lg-100 pt-md-100 pb-md-100 pt-xs-50 pb-xs-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 mb-lg-30 mb-md-30 mb-xs-30" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                        <div class="programs-title style-2">
							<?php if ( ! empty( $settings['sub_title'] ) ): ?>
                                <p><?php echo $settings['sub_title'] ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $settings['title'] ) ): ?>
                                <h2><?php echo $settings['title'] ?></h2>
							<?php endif; ?>
                        </div>
                    </div>
                    <div class="col-xl-8" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
                        <div class="row">
							<?php foreach ( $settings['lists'] as $item ): ?>
								<?php
								$col_class = '';
								if ( $item['field_condition'] == 'style_2' ) {
									$col_class = ' style-2';
								}
								$image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : '';
								?>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-6">
                                    <div class="programs-content-wrap <?php echo $col_class ?>">
                                        <div class="icon">
                                            <img src="<?php echo $image; ?>" alt="icons">
                                        </div>
                                        <div class="content">
											<?php if ( ! empty( $item['title'] ) ): ?>
                                                <h3><?php echo $item['title'] ?></h3>
											<?php endif; ?>
											<?php if ( ! empty( $item['description'] ) ): ?>
                                                <p><?php echo $item['description'] ?></p>
											<?php endif; ?>
											<?php if ( ! empty( $item['btn_text_1'] ) ): ?>
                                                <div class="read-more">
                                                    <a href="<?php echo $item['btn_link_1'] ?>">
														<?php echo $item['btn_text_1'] ?>
                                                    </a>
                                                </div>
											<?php endif; ?>
                                        </div>
                                    </div>
                                </div>
							<?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

}