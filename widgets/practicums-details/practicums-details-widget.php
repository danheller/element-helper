<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Practicums_Details extends Element_El_Widget {

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
		return 'practicums_Details';
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
		return __( 'Practicums Details', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/practicumsDetails/';
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
		return [ 'practicumsDetails', 'blurb', 'infobox', 'content', 'block', 'box' ];
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
			'banner',
			[
				'label'   => __( 'Banner', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
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
			'l_title',
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
			'l_description',
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
			'_section_right',
			[
				'label' => __( 'Right Content', 'elementhelper' ),
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
			'r_link',
			[
				'label'       => __( 'Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'r_cat_text_1',
			[
				'label'       => __( 'Category Text 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'r_cat_link_1',
			[
				'label'       => __( 'Category Link 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);



		$this->add_control(
			'r_date',
			[
				'label'       => __( 'Date', 'elementhelper' ),
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
        <div class="pc-content-wrapper  pl-25">
            <div class="row">
                <div class="col-xl-12">
                    <div class="pc-undergraduate-wrap mb-25">
	                    <?php if(!empty($settings['title'])): ?>
                            <div class="title">
                                <h2><?php echo $settings['title'] ?></h2>
                            </div>
	                    <?php endif; ?>
	                    <?php if(!empty($banner)): ?>
                            <div class="pc-undergraduate-thumb">
                                <img src="<?php echo $banner; ?>" alt="thumb">
                            </div>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <div class="pc-about-wrap pt-30">
	                    <?php if(!empty($settings['l_title'])): ?>
                            <h3><?php echo $settings['l_title'] ?></h3>
	                    <?php endif; ?>
	                    <?php if(!empty($settings['l_description'])): ?>
                            <p><?php echo $settings['l_description'] ?></p>
	                    <?php endif; ?>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="pc-about-card-wrap">
	                    <?php if(!empty($image)): ?>
                            <div class="pc-about-thumb">
                                <img src="<?php echo $image; ?>" alt="thumb">
                            </div>
	                    <?php endif; ?>
                        <div class="card-content">
	                        <?php if(!empty($settings['r_cat_text_1'])): ?>
                                <div class="tag">
                                    <a href="<?php echo $settings['r_cat_link_1'] ?>"><?php echo $settings['r_cat_text_1'] ?></a>
                                </div>
	                        <?php endif; ?>
	                        <?php if(!empty($settings['r_title'])): ?>
                                <div class="title">
                                    <a href="<?php echo $settings['r_link'] ?>"><?php echo $settings['r_title'] ?></a>
                                </div>
	                        <?php endif; ?>
	                        <?php if(!empty($settings['r_date'])): ?>
                                <p><?php echo $settings['r_date'] ?></p>
	                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
		<?php
	}

}