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

class Instagram_Feed extends Element_El_Widget {

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
		return 'instagram_feed';
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
		return __( 'Instagram Feed', 'elementhelper' );
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
		return [ 'instagram', 'list', 'icon' ];
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
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'username',
			[
				'label'       => __( 'Username', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'info',
			[
				'label'       => __( 'Info', 'elementhelper' ),
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

		$this->add_control(
			'image',
			[
				'label'   => __( 'Image', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'shortcode',
			[
				'label'       => __( 'Shortcode', 'elementhelper' ),
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

		/*$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Style Tab', 'elementhelper' ),
				'type'  => Controls_Manager::HEADING,
			]
		);*/
		
		$this->add_control(
			'add_aos_animate',
			[
				'label'        => __( 'Add AOS Animate', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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
		<?php $image = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : ''; ?>
        <div class="connected-area pt-50 pb-110">
            <div class="container-disabled">
                <div class="row" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php } ?>>
                    <div class="col-xl-12">
                        <div class="connected-content-wrap">
							<?php if ( ! empty( $settings['title'] ) ): ?>
                                <h3><span><?php echo $settings['title']; ?></span></h3>
							<?php endif; ?>
                            <div class="connected-content">
                                <div class="thumb">
                                    <img src="<?php echo $image; ?>" alt="logo">
                                </div>
                                <div class="account">
									<?php if ( ! empty( $settings['username'] ) ): ?>
                                        <p><?php echo $settings['username']; ?></p>
									<?php endif; ?>
									<?php if ( ! empty( $settings['info'] ) ): ?>
                                        <span><?php echo $settings['info']; ?></span>
									<?php endif; ?>
                                </div>
								<?php if ( ! empty( $settings['btn_text_1'] ) ): ?>
                                    <div class="connected-btn">
                                        <a href="<?php echo $settings['btn_link_1']; ?>" class="btn btn-primary">
											<?php echo $settings['btn_text_1']; ?>
                                        </a>
                                    </div>
								<?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
				<?php if ( ! empty( $settings['shortcode'] ) ): ?>
                    <div class="row mt-50" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000" <?php } ?>>
                        <div class="col-xl-12">
							<?php echo do_shortcode( $settings['shortcode'] ); ?>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
		<?php
	}
}