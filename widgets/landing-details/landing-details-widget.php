<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Landing_Details extends Element_El_Widget {


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
		return 'landing_Details';
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
		return __( 'Landing Details', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/landingDetails/';
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
		return [ 'landingDetails', 'blurb', 'infobox', 'content', 'block', 'box' ];
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
				'label'       => __( 'Section Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Section Sub-Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'banner',
			[
				'label'   => __( 'Banner', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
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
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_left',
			[
				'label' => __( 'Left Content', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'image',
			[
				'label'   => __( 'Image', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_right',
			[
				'label' => __( 'Right Content', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'r_title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'r_description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
			]
		);


		$this->add_control(
			'read_more',
			[
				'label'       => __( 'Read More', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

        $this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
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
		$image    = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';
		$banner    = ! empty( $settings['banner']['url'] ) ? wp_get_attachment_image_url( $settings['banner']['id'], 'full' ) : '';
		?>

        <div class="l-content-wrapper  pl-25">
            <div class="row">
                <div class="col-xl-12">
                    <div class="l-undergraduate-wrap mb-25">
	                    <?php if ( ! empty( $settings['title'] ) ): ?>
                            <div class="title">
                                <h2><?php echo $settings['title'] ?></h2>
                            </div>
	                    <?php endif; ?>
	                    <?php if ( ! empty( $settings['subtitle'] ) ): ?>
                            <div class="sub-title">
                                <h5><?php echo $settings['subtitle'] ?></h5>
                            </div>
	                    <?php endif; ?>
	                    <?php if ( ! empty( $banner ) ): ?>
                            <div class="l-undergraduate-thumb">
                                <img src="<?php echo $banner; ?>" alt="thumb">
                            </div>
	                    <?php endif; ?>
	                    <?php if ( ! empty( $settings['description'] ) ): ?>
                            <div class="l-undergraduate-description mt-20 mb-30">
                                <p><?php echo $settings['description'] ?></p>
                            </div>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row align-items-center pb-45">
                <div class="col-xl-6 col-lg-6 mb-md-30 mb-xs-30">
	                <?php if ( ! empty( $image ) ): ?>
                        <div class="l-about-thumb">
                            <img src="<?php echo $image; ?>"
                                 alt="thumb">
                        </div>
	                <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 pl-30">
                    <div class="l-about-content">
	                    <?php if ( ! empty( $settings['r_title'] ) ): ?>
                            <h3><?php echo $settings['r_title'] ?></h3>
	                    <?php endif; ?>
	                    <?php if ( ! empty( $settings['r_description'] ) ): ?>
                            <p><?php echo $settings['r_description'] ?></p>
	                    <?php endif; ?>
                    </div>
                </div>
                <div class="col-xl-12 text-center pt-55">
	                <?php if ( ! empty( $settings['read_more'] ) ): ?>
                        <div class="l-about-read-more">
                            <a href="<?php echo $settings['link'] ?>"><?php echo $settings['read_more'] ?></a>
                        </div>
	                <?php endif; ?>
                </div>
            </div>
        </div>

		<?php
	}

}