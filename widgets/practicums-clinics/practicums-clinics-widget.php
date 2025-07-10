<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Practicums_Clinics extends Element_El_Widget {


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
		return 'practicums_clinics';
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
		return __( 'Practicums Clinics', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/practicumsClinics/';
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
		return [ 'staffDetails', 'blurb', 'infobox', 'content', 'block', 'box' ];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Section Title', 'elementhelper' ),
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
				],
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
			'_section_item',
			[
				'label' => __( 'Items', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'       => __( 'Image', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
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

		$this->add_control(
			'pc_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Item"); #>'
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'_section_bottom',
			[
				'label' => __( 'Bottom Section', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'text',
			[
				'label'       => __( 'Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'title_2',
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
			'description_2',
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
		?>

        <div class="row">
            <div class="cool-xl-12">
                <div class="pc-clinic-title">
					<?php if ( ! empty( $settings['title'] ) ): ?>
                        <h2><?php echo $settings['title'] ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $settings['description'] ) ): ?>
                        <p><?php echo $settings['description'] ?></p>
					<?php endif; ?>
                </div>


                <div class="pc-clinic-content-wrapper">


					<?php foreach ( $settings['pc_list'] as $item ): ?>
						<?php
						$image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : '';
						?>
                        <div class="pc-clinic-content-warp">
                            <div class="pc-clinic-icon">
                                <img src="<?php echo $image; ?>" alt="icons">
                            </div>
                            <div class="pc-clinic-content">
                                <h3><?php echo $item["title"]; ?></h3>
                                <p><?php echo $item["description"]; ?></p>
                            </div>
                        </div>
					<?php endforeach; ?>
                </div>

                <div class="pc-clinic-description">
					<?php if ( ! empty( $settings['text'] ) ): ?>
                        <p><?php echo $settings['text'] ?></p>
					<?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="col-xl-12">
                <div class="pc-practicum-title">
					<?php if ( ! empty( $settings['title_2'] ) ): ?>
                        <h2><?php echo $settings['title_2'] ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $settings['description_2'] ) ): ?>
                        <p><?php echo $settings['description_2'] ?></p>
					<?php endif; ?>
                </div>
            </div>
        </div>

		<?php
	}

}