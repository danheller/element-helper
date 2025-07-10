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

class Practice extends Element_El_Widget {

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
		return 'practice';
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
		return __( 'Practice', 'elementhelper' );
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
		return [ 'practice', 'list', 'icon' ];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_design_left',
			[
				'label' => __( 'Section Left', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'btn_text_1',
			[
				'label'       => __( 'Button Text 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'btn_link_1',
			[
				'label'       => __( 'Button Link 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_design_right',
			[
				'label' => __( 'Section Right', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_2',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'description_2',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'btn_text_2',
			[
				'label'       => __( 'Button Text 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'btn_link_2',
			[
				'label'       => __( 'Button Link 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
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
        <div class="practice-area">
            <div class="practise-content">
                <div class="content" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
					<?php if ( ! empty( $settings['title'] ) ): ?>
                        <h2><?php echo $settings['title'] ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $settings['description'] ) ): ?>
                        <p><?php echo $settings['description'] ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $settings['btn_text_1'] ) ): ?>
                        <div class="practice-btn">
                            <a href="<?php echo $settings['btn_link_1'] ?>">
								<?php echo $settings['btn_text_1'] ?>
                            </a>
                        </div>
					<?php endif; ?>
                </div>
            </div>
            <div class="build-content">
                <div class="content" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
					<?php if ( ! empty( $settings['title_2'] ) ): ?>
                        <h2><?php echo $settings['title_2'] ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $settings['description_2'] ) ): ?>
                        <p><?php echo $settings['description_2'] ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $settings['btn_text_2'] ) ): ?>
                        <div class="build-btn">
                            <a href="<?php echo $settings['btn_link_2'] ?>">
								<?php echo $settings['btn_text_2'] ?>
                            </a>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </div>
		<?php
	}
}