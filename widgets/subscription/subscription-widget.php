<?php

namespace ElementHelper\Widget;

use \Elementor\Group_Control_Css_Filter;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Subscription extends Element_El_Widget {


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
		return 'subscription';
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
		return __( 'Subscription', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/hero/';
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
		return 'eicon-elementor';
	}

	public function get_keywords() {
		return [ 'hero', 'blurb', 'infobox', 'content', 'block', 'box' ];
	}

	protected function register_content_controls() {
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
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'shortcode',
			[
				'label'       => __( 'Shortcode', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->start_controls_section(
			'_section_style_image',
			[
				'label' => __( 'Image', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'offset_toggle',
			[
				'label'        => __( 'Offset', 'elementhelper' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'elementhelper' ),
				'label_on'     => __( 'Custom', 'elementhelper' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
        <div class="subscribe-form-area pt-150 pb-150 pt-lg-90 pb-lg-10 pt-md-90 pb-md-10 pt-xs-90 pb-xs-10">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="subscribe-wrap text-center">
                            <div class="subscribe-heading" data-aos="fade-up" data-aos-delay="300"
                                 data-aos-duration="2000">
								<?php if ( ! empty( $settings['title'] ) ): ?>
                                    <h3 class="title">
										<?php echo elh_element_kses_basic( $settings['title'] ) ?>
                                    </h3>
								<?php endif; ?>
								<?php if ( ! empty( $settings['description'] ) ): ?>
                                    <p>
										<?php echo elh_element_kses_basic( $settings['description'] ) ?>
                                    </p>
								<?php endif; ?>
                            </div>
							<?php if ( ! empty( $settings['shortcode'] ) ): ?>
                                <div class="subscribe-form" data-aos="fade-up" data-aos-delay="600"
                                     data-aos-duration="2000">
									<?php echo do_shortcode( $settings['shortcode'] ) ?>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

}