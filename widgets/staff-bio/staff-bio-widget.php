<?php

namespace ElementHelper\Widget;

use \Elementor\Group_Control_Css_Filter;
use \Elementor\Core\Schemes\Typography;
use Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Staff_Bio extends Element_El_Widget {


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
		return 'staff_Bio';
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
		return __( 'Staff Bio', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/staffBio/';
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
		return [ 'staffBio', 'blurb', 'infobox', 'content', 'block', 'box' ];
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
			'l_title_link',
			[
				'label'       => __( 'Title Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
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

		$this->add_control(
			'l_cat',
			[
				'label'       => __( 'Category Name', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'l_cat_link',
			[
				'label'       => __( 'Category Link', 'elementhelper' ),
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
			'r_short_description',
			[
				'label'       => __( 'Short Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
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

            <div class="row pt-50">
                <div class="col-xl-12">
                    <div class="s-faculty-wrapper pb-75">
                        <div class="s-faculty-background"></div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="s-faculty-card-wrap">
									<?php if ( ! empty( $image ) ): ?>
                                        <div class="s-faculty-thumb">
                                            <img src="<?php echo $image; ?>" alt="thumb">
                                        </div>
									<?php endif; ?>

                                    <div class="card-content">
										<?php if ( ! empty( $settings['l_cat'] ) ): ?>
                                            <div class="tag">
                                                <a href="<?php echo $settings['l_cat_link']; ?>">
													<?php echo $settings['l_cat']; ?>
                                                </a>
                                            </div>
										<?php endif; ?>
										<?php if ( ! empty( $settings['l_title'] ) ): ?>
                                            <h3>
                                                <a href="<?php echo $settings['l_title_link']; ?>">
													<?php echo $settings['l_title']; ?>
                                                </a>
                                            </h3>
										<?php endif; ?>

										<?php if ( ! empty( $settings['l_date'] ) ): ?>
                                            <p><?php echo $settings['l_date']; ?></p>
										<?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="s-faculty-wrap">
                                    <div class="s-faculty-title">
										<?php if ( ! empty( $settings['r_title'] ) ): ?>
                                            <h2>
												<?php echo $settings['r_title']; ?>
                                            </h2>
										<?php endif; ?>
										<?php echo $settings['r_short_description']; ?>
                                    </div>
									<?php if ( ! empty( $settings['r_description'] ) ): ?>
                                        <div class="p-faculty-description">
											<?php echo $settings['r_description']; ?>
                                        </div>
									<?php endif; ?>
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