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

class Staff_List extends Element_El_Widget {


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
		return 'staff_list';
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
		return __( 'Staff List', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/staff/';
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
		return [ 'staff', 'blurb', 'infobox', 'content', 'block', 'box' ];
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
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'title_style_2',
			[
				'label'        => esc_html__( 'Title Style 2', 'elementhelper' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elementhelper' ),
				'label_off'    => esc_html__( 'No', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => __( 'Image', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
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
			'slider',
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
		?>
		<?php
		$class_name = 's-letter-wrap';
		if ( $settings['title_style_2'] === 'yes' ) {
			$class_name = 's-letter-wrap style-2';
		}
		?>
        <div class="staff-list-wrapper">
			<?php if ( ! empty( $settings['title'] ) ): ?>
                <div class="row pb-25">
                    <div class="col-xl-12">
                        <div class="<?php echo $class_name; ?>">
                            <h2><?php echo $settings['title']; ?></h2>
                        </div>
                    </div>
                </div>
			<?php endif; ?>

            <div class="row">
				<?php foreach ( $settings['slider'] as $item ): ?>
					<?php $image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : ''; ?>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="s-profile-content-wrap">
                            <div class="s-profile-thumb">
                                <img src="<?php echo $image; ?>" alt="thumb">
                            </div>
                            <div class="s-profile-content">
                                <a href="<?php echo $item["link"]; ?>">
									<?php echo $item["title"]; ?>
                                </a>
                                <p>
									<?php echo $item["description"]; ?>
                                </p>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
		<?php
	}

}