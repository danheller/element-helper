<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Wufoo_Form extends Element_El_Widget {

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
		return 'wufoo-form';
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
		return __( 'Wufoo Form', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/programCta/';
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
		return [ 'faculty', 'listing', 'facultylisting' ];
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
			'title_tag',
			[
				'label'              => __( 'Title Tag', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'H2' => __( 'h2', 'elementhelper' ),
					'H3' => __( 'h3', 'elementhelper' ),
					'H4' => __( 'h4', 'elementhelper' ),
					'H5' => __( 'h5', 'elementhelper' ),
					'H6' => __( 'h6', 'elementhelper' ),
					'H1' => __( 'h1', 'elementhelper' ),
				],
				'default'            => 'H2',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$this->add_control(
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
		
		$this->add_control(
			'wufoo_type',
			[
				'label'              => __( 'Wufoo Type', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'Form' => __( 'Form', 'elementhelper' ),
					'Report' => __( 'Report', 'elementhelper' ),
				],
				'default'            => 'Form',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);


		$this->add_control(
			'form_code',
			[
				'label'       => __( 'Form ID', 'elementhelper' ),
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
		//var_dump($settings['form_code']);
		?>

		<div class="wufoo-form-wrapper">
			
			<?php if($settings['wufoo_type'] === 'Form') { ?>
				<div id="wufoo-<?php echo $settings['form_code']; ?>"> Fill out my <a href="https://uscgould.wufoo.com/forms/<?php echo $settings['form_code']; ?>">online form</a>. </div> <script type="text/javascript"> var <?php echo $settings['form_code']; ?>; (function(d, t) { var s = d.createElement(t), options = { 'userName':'uscgould', 'formHash':'<?php echo $settings['form_code']; ?>', 'autoResize':true, 'height':'505', 'async':true, 'host':'wufoo.com', 'header':'show', 'ssl':true }; s.src = ('https:' == d.location.protocol ?'https://':'http://') + 'secure.wufoo.com/scripts/embed/form.js'; s.onload = s.onreadystatechange = function() { var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return; try { <?php echo $settings['form_code']; ?> = new WufooForm(); <?php echo $settings['form_code']; ?>.initialize(options); <?php echo $settings['form_code']; ?>.display(); } catch (e) { } }; var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr); })(document, 'script'); </script>
			<?php } ?>
			<?php if($settings['wufoo_type'] === 'Report') { ?>
				<script src="https://uscgould.wufoo.com/scripts/widget/embed.js?w=<?php echo $settings['form_code']; ?>" type="text/javascript"></script>
			<?php } ?>
		</div>

		<?php
	}

}