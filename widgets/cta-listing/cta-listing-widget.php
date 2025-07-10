<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Cta_Listing extends Element_El_Widget {

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
		return 'cta_listing';
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
		return __( 'Cta Listing', 'elementhelper' );
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
		return [ 'ctalisting', 'cta', 'listing' ];
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
				'label'       => __( 'Section Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'sub_title',
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
			'flip_title_subtitle',
			[
				'label'        => __( 'Flip Title & SubTitle', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image_icon',
			[
				'label'   => __( 'Image Icon', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater->add_control(
			'cta_title',
			[
				'label'       => __( 'CTA Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'cta_sub_title',
			[
				'label'       => __( 'CTA Sub-Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'cta_link',
			[
				'label'       => __( 'CTA Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'cta_target',
			[
				'label'       => __( 'CTA Target', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '_self',
			]
		);

		$repeater->add_control(
			'cta_aria_label',
			[
				'label'       => __( 'CTA Aria Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$repeater->add_control(
			'cta_add_arrow_right',
			[
				'label'        => __( 'CTA Add Arrow Right', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'cta_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(cta_title || "Item"); #>',
				'prevent_empty' => false,
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
			'module_class',
			[
				'label'       => __( 'Module Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'module_wrap_class',
			[
				'label'       => __( 'Module Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mb-25',
			]
		);
		
		$this->add_control(
			'add_aos_animate',
			[
				'label'        => __( 'Add AOS Animate', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		
		$this->add_control(
			'aos_animate_once',
			[
				'label'        => __( 'AOS Animate Once', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		
		$this->add_control(
			'header_wrap_class',
			[
				'label'       => __( 'Header Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'title_class',
			[
				'label'       => __( 'Title Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'description_wrapper_class',
			[
				'label'       => __( 'Description Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mt-20 mb-30',
			]
		);
		
		$this->add_control(
			'add_main_container',
			[
				'label'        => __( 'Add Main Container', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'cta_listing_class',
			[
				'label'       => __( 'CTA Listing Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'cta_each_class',
			[
				'label'       => __( 'CTA Each Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		//$image    = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';
		//var_dump($settings['cta_list']);
		?>

        <div class="cta-listing-wrapper <?php echo $settings['module_class']; ?>">
			
			<?php if($settings['add_main_container'] === 'yes') { ?>
			<div class="container">
			<?php } ?>
				
			<div class="cta-listing-wrap <?php echo $settings['module_wrap_class']; ?>" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php if($settings['aos_animate_once'] === 'yes') { ?>data-aos-once="true" <?php } ?><?php } ?>>
			
				<?php if ( ! empty( $settings['title'] ) OR ! empty( $settings['sub_title'] ) ): ?>
				<div class="header-wrap <?php echo $settings['header_wrap_class']; ?>">
					<?php endif; ?>
					<?php if($settings['flip_title_subtitle'] === 'yes' && ! empty( $settings['sub_title'] )) { ?>
					<div class="sub-title">
						<?php echo $settings['sub_title'] ?>
					</div>
					<?php } ?>
					<?php if ( ! empty( $settings['title'] ) ): ?>
					<?php echo '<' . $settings['title_tag'] . ' class="title ' . $settings['title_class'] . '">'; ?>
					<span><?php echo $settings['title'] ?></span>
					<?php echo '</' . $settings['title_tag'] . '>'; ?>
					<?php endif; ?>
					<?php if ( $settings['flip_title_subtitle'] !== 'yes' && ! empty( $settings['sub_title'] ) ): ?>
					<div class="sub-title">
						<?php echo $settings['sub_title'] ?>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['title'] ) OR ! empty( $settings['sub_title'] ) ): ?>
				</div>
				<?php endif; ?>
				
				<?php if( count($settings['cta_list'])) { ?>
				<div class="cta-listing-items-wrapper <?php echo $settings['cta_listing_class']; ?>">
					<?php foreach($settings['cta_list'] as $idx => $thisCTA) { ?>
					<?php $image_icon = ! empty( $thisCTA['image_icon']['url'] ) ? wp_get_attachment_image_url( $thisCTA['image_icon']['id'], 'full' ) : ''; ?>
					<?php $image_alt_text = ! empty( $thisCTA['image_icon']['url'] ) ? get_post_meta( $thisCTA['image_icon']['id'], '_wp_attachment_image_alt', true ) : 'placeholder image alternative text'; ?>
					<?php $image_alt_text = ! empty($image_alt_text) ? $image_alt_text : 'placeholder image alternative text'; ?>
					<?php $cta_link_aria_label = ! empty( $thisCTA['cta_aria_label'] ) ? $thisCTA['cta_aria_label'] : 'Placeholder cta aria label click link'; ?>
					<div class="cta-listing-item-wrapper <?php echo $settings['cta_each_class']; ?>">
						<a href="<?php echo $thisCTA['cta_link']; ?>" class="cta-listing-item-link" target="<?php echo $thisCTA['cta_target']; ?>" aria-label="<?php echo $cta_link_aria_label; ?>" ><span class="hide"><?php echo $thisCTA['cta_title']; ?></span></a>
						<?php if ( ! empty($image_icon) ) { ?>
						<div class="cta-listing-item-icon">
							<img src="<?php echo $image_icon; ?>" alt="<?php echo $image_alt_text; ?>" />
						</div>
						<?php } ?>
						<div class="cta-listing-item-content">
							<div class="cta-listing-item-title">
								<?php echo $thisCTA['cta_title']; ?>
							</div>
							<div class="cta-listing-item-sub-title">
								<?php echo $thisCTA['cta_sub_title']; ?>
							</div>
						</div>
						<?php if($thisCTA['cta_add_arrow_right'] === 'yes') { ?>
						<div class="cta-listing-item-arrow">
							<i class="fa-solid fa-chevron-right"></i>
						</div>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				
			</div>
			<?php if($settings['add_main_container'] === 'yes') { ?>
			</div>
			<?php } ?>
			
        </div>



		<?php
	}

}