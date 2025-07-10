<?php

namespace ElementHelper\Widget;

use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;

defined( 'ABSPATH' ) || die();

class Video_Info extends Element_El_Widget {

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
		return 'video_info';
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
		return __( 'Video Info', 'elementhelper' );
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
		return 'eicon-video-camera';
	}

	public function get_keywords() {
		return [ 'info', 'video', 'box', 'text', 'content' ];
	}

	/**
	 * Register content related controls
	 */
	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title & Description', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'video_url',
			[
				'label'       => __( 'Video URL', 'elementhelper' ),
				'description' => elh_element_get_allowed_html_desc( 'intermediate' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Elhvideo url goes here', 'elementhelper' ),
				'placeholder' => __( 'Set Video URL', 'elementhelper' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
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
        <div class="video-area pt-100 pb-100">
            <div class="play-btn">
                <a class="popup-video" href="<?php echo esc_url( $settings['video_url'] ); ?>">
                    <i class="fa fa-play"></i>
                </a>
            </div>
        </div>
		<?php
	}
}
