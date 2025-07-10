<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Program_List extends Element_El_Widget {


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
		return 'program_list';
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
		return __( 'Program List', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/programList/';
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
			'l_cat_text_1',
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
			'l_cat_link_1',
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
			'l_date',
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
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater = new Repeater();

        $repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
        $repeater->add_control(
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
		$repeater->add_control(
			'list',
			[
				'label'       => __( 'List', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'r_list',
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
            <div class="col-xl-12">
                <div class="p-faculty-wrapper">
                    <div class="p-faculty-background"></div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="p-faculty-card-wrap">
	                            <?php if ( ! empty( $image ) ): ?>
                                <div class="p-faculty-thumb">
                                    <img src="<?php echo $image ?>" alt="thumb">
                                </div>
	                            <?php endif; ?>
                                <div class="card-content">
									<?php if ( ! empty( $settings['l_cat_text_1'] ) ): ?>
                                        <div class="tag">
                                            <a href="<?php echo $settings['l_cat_link_1'] ?>"><?php echo $settings['l_cat_text_1'] ?></a>
                                        </div>
									<?php endif; ?>
									<?php if ( ! empty( $settings['l_title'] ) ): ?>
                                        <h3><?php echo $settings['l_title'] ?></h3>
									<?php endif; ?>
									<?php if ( ! empty( $settings['l_date'] ) ): ?>
                                        <p><?php echo $settings['l_date'] ?></p>
									<?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="p-faculty-wrap pl-10">
                                <div class="p-faculty-title">
									<?php if ( ! empty( $settings['r_title'] ) ): ?>
                                        <h2><?php echo $settings['r_title'] ?></h2>
									<?php endif; ?>
									<?php if ( ! empty( $settings['r_description'] ) ): ?>
                                        <p><?php echo $settings['r_description'] ?></p>
									<?php endif; ?>
                                </div>
                                <div class="p-faculty-link-wrap">
                                    <ul>
										<?php foreach ( $settings['r_list'] as $item ): ?>
											<?php
											$class_name = '';
											?>
                                            <li>
                                                <a href="<?php echo $item["link"]; ?>"> <?php echo $item["title"]; ?></a>
												<?php echo $item["list"]; ?>
                                            </li>
										<?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


		<?php
	}

}