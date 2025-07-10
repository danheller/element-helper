<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Staff_Details extends Element_El_Widget {


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
		return 'staff_Details';
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
		return __( 'Staff Details', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/staffDetails/';
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
				'label'       => __( 'Url', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'active',
			[
				'label'        => esc_html__( 'Active Title', 'elementhelper' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elementhelper' ),
				'label_off'    => esc_html__( 'No', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);


		$this->add_control(
			'letters',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Item"); #>'
			]
		);

		$this->add_control(
			'l_share_link',
			[
				'label'       => __( 'Share Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'l_share_fb',
			[
				'label'       => __( 'Share Facebook', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'l_share_email',
			[
				'label'       => __( 'Share Email', 'elementhelper' ),
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
			'r_cat_text_1',
			[
				'label'       => __( 'Cate Text 1', 'elementhelper' ),
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
				'label'       => __( 'Cate Link 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'r_cat_text_2',
			[
				'label'       => __( 'Cate Text 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'r_cat_link_2',
			[
				'label'       => __( 'Cate Link 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
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
        <div class="s-content-wrapper">
			<?php if ( ! empty( $settings['title'] ) ): ?>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="s-staff-wrap">
                            <div class="title">
                                <h2><?php echo $settings['title']; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
			<?php endif; ?>


            <div class="row">
                <div class="col-xl-12">
                    <div class="sb-menu-list-wrapper">
                        <div class="sb-list-wrap">
							<?php foreach ( $settings['letters'] as $item ): ?>
								<?php
								$class_name = '';
								if ( $item['active'] === 'yes' ) {
									$class_name = 'active';
								}
								?>
                                <a href="<?php echo $item["link"]; ?>" class="<?php echo $class_name; ?>">
									<?php echo $item["title"]; ?>
                                </a>
							<?php endforeach; ?>
                        </div>
                        <div class="sb-list-text">
                            <span>Share this</span>
                        </div>
                        <div class="sb-list-icon-wrap">
                            <ul>
								<?php if ( ! empty( $settings['l_share_link'] ) ): ?>
                                    <li>
                                        <a href="<?php echo $settings['l_share_link']; ?>">
                                            <i class="fa-solid fa-link"></i> Link
                                        </a>
                                    </li>
								<?php endif; ?>
								<?php if ( ! empty( $settings['l_share_fb'] ) ): ?>
                                    <li>
                                        <a href="<?php echo $settings['l_share_fb']; ?>">
                                            <i class="fa-brands fa-facebook"></i> Share
                                        </a>
                                    </li>
								<?php endif; ?>
								<?php if ( ! empty( $settings['l_share_email'] ) ): ?>
                                    <li>
                                        <a href="<?php echo $settings['l_share_email']; ?>">
                                            <i class="fa-solid fa-envelope"></i> Email
                                        </a>
                                    </li>
								<?php endif; ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row pb-25">
                <div class="col-xl-12">
                    <div class="sb-bio-wrapper">
                        <div class="sb-bio-thumb">
                            <img src="<?php echo $image; ?>" alt="thumb">
                        </div>
                        <div class="sb-bio-content-wrapper">
							<?php if ( ! empty( $settings['r_cat_link_1'] ) || ! empty( $settings['r_cat_link_2'] ) ): ?>
                                <div class="tag">
                                    <a href="<?php echo $settings['r_cat_link_1']; ?>">
										<?php echo $settings['r_cat_text_1']; ?>
                                    </a>
                                    <a href="<?php echo $settings['r_cat_link_2']; ?>">
										<?php echo $settings['r_cat_text_2']; ?>
                                    </a>
                                </div>
							<?php endif; ?>
							<?php if ( ! empty( $settings['r_title'] ) ): ?>
                                <h2>
									<?php echo $settings['r_title']; ?>
                                </h2>
							<?php endif; ?>
							<?php echo $settings['r_description']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

}