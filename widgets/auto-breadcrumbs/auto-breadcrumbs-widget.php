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

class Auto_Breadcrumbs extends Element_El_Widget {


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
		return 'auto-breadcrumbs';
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
		return __( 'Auto Breadcrumbs', 'elementhelper' );
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
		return [ 'breadcrumbs', 'auto' ];
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
			'hide_in_mobile',
			[
				'label'        => __( 'Hide in Mobile', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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
		
		$max_loop = 5;
		$current_post_id = get_the_id();
		$breadHtml = '';
		while( $current_post_id !== 0 && $max_loop > 0 ) {
			$thisPost = get_posts([
				'post_type' => 'page',
				'post_status' => 'publish',
				'numberposts' => 1,
				'p' => $current_post_id,
			]);
			$thisPerm = get_permalink($current_post_id);
			$thisTitle = get_the_title($current_post_id);
			$breadHtml = '<li><a href="' . $thisPerm . '">' . $thisTitle . '</a></li>' . $breadHtml;
			//var_dump($thisPost); echo '<br />';
			//var_dump(get_the_title($current_post_id), $current_post_id, wp_get_post_parent_id($current_post_id), $max_loop); echo '<br /><br />';
			$current_post_id = wp_get_post_parent_id($current_post_id);
			$max_loop--;
		}
		$breadHtml = '<li><a href="/">Home</a></li>' . $breadHtml;
		
		?>

        <div class="auto-breadcrumb-wrap <?php if($settings['hide_in_mobile'] === 'yes') { ?> hide-in-mobile <?php } ?>">
			<?php echo auto_breadcrump_generation(); ?>
        </div>
		<?php
	}

}