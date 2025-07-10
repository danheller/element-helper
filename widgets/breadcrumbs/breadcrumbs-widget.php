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

class Breadcrumbs extends Element_El_Widget {


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
		return 'breadcrumbs';
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
		return __( 'Breadcrumbs', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/breadcrumbs/';
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
		return [ 'breadcrumbs', 'blurb', 'infobox', 'content', 'block', 'box' ];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title & Description', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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

        <div class="breadcrumb-wrap">
            <ul>
                <?php foreach($settings['slider'] as $item): ?>
                    <li>
                        <a href="<?php echo $item["link"];?>">
	                        <?php echo $item["title"];?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
		<?php
	}

}