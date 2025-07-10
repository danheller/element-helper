<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Generic_Listing extends Element_El_Widget {

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
		return 'generic-listing';
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
		return __( 'Generic Listing', 'elementhelper' );
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
		return [ 'genericlisting', 'generic', 'listing' ];
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
		
		$this->add_control(
			'is_homepage_hero',
			[
				'label'        => __( 'Is Homepage Hero', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'use_slick',
			[
				'label'        => __( 'Use Slick', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'use_custom_arrows',
			[
				'label'        => __( 'Use Custom Arrows', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'add_custom_arrow_container',
			[
				'label'        => __( 'Add Container Custom Arrows', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'use_custom_dots',
			[
				'label'        => __( 'Use Custom Dots', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'use_custom_dots_inside_arrows',
			[
				'label'        => __( 'Use Custom Dots Inside Arrows', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'custom_slick_prev_btn',
			[
				'label'       => __( 'Custom Previous Arrow Class Name', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'custom_slick_dots',
			[
				'label'       => __( 'Custom Dots Class Name', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'custom_slick_next_btn',
			[
				'label'       => __( 'Custom Next Arrow Class Name', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'add_list_content_container',
			[
				'label'        => __( 'Add Container List Content', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);


		$this->add_control(
			'slick_listing_class_name',
			[
				'label'       => __( 'Slick Listing Class Name', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image_background',
			[
				'label'   => __( 'Image Background', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);
		
		$repeater->add_control(
			'image_before_header',
			[
				'label'   => __( 'Image Before Header', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);
		
		$repeater->add_control(
			'use_video_background',
			[
				'label'        => __( 'Use Video Background', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$repeater->add_control(
			'video_id',
			[
				'label'       => __( 'Video ID', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label'       => __( 'Item Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_sub_title',
			[
				'label'       => __( 'Item Sub-Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_link_label',
			[
				'label'       => __( 'Item Link Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_link',
			[
				'label'       => __( 'Item Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_cta_label',
			[
				'label'       => __( 'Item CTA Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_cta_link',
			[
				'label'       => __( 'Item CTA Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_cta_class',
			[
				'label'       => __( 'Item CTA Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'add_arrow_long_up',
			[
				'label'        => __( 'Add Arrow Long Up', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$repeater->add_control(
			'item_cta_label2',
			[
				'label'       => __( 'Item CTA Label 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_cta_link2',
			[
				'label'       => __( 'Item CTA Link 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_cta_class2',
			[
				'label'       => __( 'Item CTA Class 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'add_arrow_long_up2',
			[
				'label'        => __( 'Add Arrow Long Up 2', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$repeater->add_control(
			'item_cta_label3',
			[
				'label'       => __( 'Item CTA Label 3', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_cta_link3',
			[
				'label'       => __( 'Item CTA Link 3', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'item_cta_class3',
			[
				'label'       => __( 'Item CTA Class 3', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'add_arrow_long_up3',
			[
				'label'        => __( 'Add Arrow Long Up 3', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'generic_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(item_title || "Item"); #>',
				'prevent_empty' => false,
			]
		);
		
		$this->add_control(
			'show_json_listing',
			[
				'label'        => __( 'Show JSON Listing', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'json_listing1',
			[
				'label'       => __( 'JSON Listing 1', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
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
			'generic_listing_class',
			[
				'label'       => __( 'Generic Listing Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'generic_listing_item_class',
			[
				'label'       => __( 'Generic Listing Item Class', 'elementhelper' ),
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
		$thisJsonListing = !empty($settings['json_listing1']) ? json_decode($settings['json_listing1']) : [];
		$hasJsonListing = $settings['show_json_listing'] === 'yes' && !empty($thisJsonListing);
		?>

        <div class="generic-listing-wrapper <?php echo $settings['module_class']; ?>">
			
			<?php if($settings['add_main_container'] === 'yes') { ?>
			<div class="container">
			<?php } ?>
				
			<div class="generic-listing-wrap <?php echo $settings['module_wrap_class']; ?>" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php if($settings['aos_animate_once'] === 'yes') { ?>data-aos-once="true" <?php } ?><?php } ?>>
			
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
				
				<?php if( count($settings['generic_list'])) { ?>
				<div class="generic-listing-items-wrapper <?php echo $settings['generic_listing_class']; ?> <?php echo $settings['slick_listing_class_name']; ?>">
					<?php foreach($settings['generic_list'] as $idx => $thisItem) { ?>
					<?php $image_background = ! empty( $thisItem['image_background']['url'] ) ? wp_get_attachment_image_url( $thisItem['image_background']['id'], 'full' ) : ''; ?>
					<?php $image_before_header = ! empty( $thisItem['image_before_header']['url'] ) ? wp_get_attachment_image_url( $thisItem['image_before_header']['id'], 'full' ) : ''; ?>
					<div class="generic-listing-item-outer">
						<div class="generic-listing-item-wrapper <?php echo $settings['generic_listing_item_class']; ?>" style="<?php if ( ! empty($image_background) ) { ?> background-image: url(<?php echo $image_background; ?>); <?php } ?>">
							
							<?php if($thisItem['use_video_background'] === 'yes') { ?>
							<div class="video-background-wrapper">
								<video width="320" height="240" muted autoplay loop playsinline id="heroVideo<?php echo $thisItem['video_id']; ?>">
									<source src="https://gould.usc.edu/wp-content/uploads/Website_b-roll.mp4" type="video/mp4">
									<track src="captions_en.vtt" kind="captions" srclang="en" label="english_captions">
									Your browser does not support the video tag.
								</video>
							</div>
							<?php } ?>
								
							<?php if($settings['add_list_content_container'] === 'yes') { ?>
							<div class="container">
							<?php } ?>
								
							<div class="generic-listing-item-content">
								<?php if( !empty($image_before_header) ) { ?>
								<div class="generic-listing-item-image-before-header">
									<img src="<?php echo $image_before_header; ?>" />
								</div>
								<?php } ?>
								<div class="generic-listing-item-title">
									<?php echo $thisItem['item_title']; ?>
								</div>
								<div class="generic-listing-item-sub-title">
									<?php echo $thisItem['item_sub_title']; ?>
								</div>
								
								<?php if( !empty($thisItem['item_link_label']) && !empty($thisItem['item_link'])) { ?>
								<div class="generic-listing-item-link-wrapper">
									<a href="<?php echo $thisItem['item_link']; ?>">
										<?php echo $thisItem['item_link_label']; ?>
										<svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0807 11.5855L13.581 12.0816L19.3712 6.34061L13.581 0.59961L13.0807 1.09575L18.013 5.98622L1 5.98622L1 6.69499L18.013 6.69499L13.0807 11.5855Z" fill="#990000" stroke="#990000" stroke-width="0.5"></path></svg>
									</a>
								</div>
								<?php } ?>
								
								<?php if( !empty($thisItem['item_cta_label']) && !empty($thisItem['item_cta_link'])) { ?>
								<div class="generic-listing-item-cta-wrapper">
									<a href="<?php echo $thisItem['item_cta_link']; ?>" class="<?php echo $thisItem['item_cta_class']; ?>"><?php echo $thisItem['item_cta_label']; ?></a>
									<a href="<?php echo $thisItem['item_cta_link2']; ?>" class="<?php echo $thisItem['item_cta_class2']; ?>"><?php echo $thisItem['item_cta_label2']; ?></a>
									<a href="<?php echo $thisItem['item_cta_link3']; ?>" class="<?php echo $thisItem['item_cta_class3']; ?>"><?php echo $thisItem['item_cta_label3']; ?></a>
								</div>
								<?php } ?>
								
								<?php if($thisItem['use_video_background'] === 'yes') { ?>
								<div class="video-play-control">
									<button aria-label="Click to play" id="heroPlayVideo" onclick="playHeroVideo('<?php echo $thisItem['video_id']; ?>')"> <i class="fa-solid fa-play"></i> <span>Play</span></button>
									<button aria-label="Click to pause" id="heroPauseVideo" onclick="pauseHeroVideo('<?php echo $thisItem['video_id']; ?>')"> <i class="fa-solid fa-pause"></i> <span>Pause</span></button>
								</div>
								<script language="javascript">
									if( document.getElementById('heroVideo<?php echo $thisItem['video_id']; ?>') ) {
										myHeroVideo['<?php echo $thisItem['video_id']; ?>'] = document.getElementById('heroVideo<?php echo $thisItem['video_id']; ?>');
}
									//myHeroVideo['<?php echo $thisItem['video_id']; ?>'] = document.getElementById('heroVideo<?php echo $thisItem['video_id']; ?>');
								</script>
								<?php } ?>
								
							</div>
								
							<?php if($settings['add_list_content_container'] === 'yes') { ?>
							</div>
							<?php } ?>
							
						</div>
					</div>
					<?php } ?>
				</div>
				
				<?php if($settings['use_custom_arrows'] === 'yes') { ?>
				<div class="custom-slick-arrows">
					<?php if($settings['add_custom_arrow_container'] === 'yes') { ?>
					<div class="container">
					<?php } ?>
					<button class="custom-slick-prev-btn <?php echo $settings['custom_slick_prev_btn'] ?>"><i class="fa-regular fa-angle-left"></i> <span>Prev</span></button>
					<?php if($settings['use_custom_dots_inside_arrows'] === 'yes') { ?>
					<div class="custom-slick-dots-inside-arrows <?php echo $settings['custom_slick_dots'] ?>"></div>
					<?php } ?>
					<button class="custom-slick-next-btn <?php echo $settings['custom_slick_next_btn'] ?>"><i class="fa-regular fa-angle-right"></i> <span>Next</span></button>
					<?php if($settings['add_custom_arrow_container'] === 'yes') { ?>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				
				<?php if($settings['use_custom_dots'] === 'yes') { ?>
				<div class="custom-slick-dots <?php echo $settings['custom_slick_dots'] ?>"></div>
				<?php } ?>
				
				<?php if ( $hasJsonListing ) { ?>
				<div class="json-listing-wrapper">
					<div class="container">
						<div class="json-listing total-cols-5">
							<div class="json-listing-inner">
								<ul class="json-listing-items">
									<?php foreach($thisJsonListing as $thisItem) { ?>
									<li class="json-listing-item">
										<div class="json-listing-item-wrapper">
											<div class="item-image-wrapper">
												<img decoding="async" src="<?php echo $thisItem->image_url; ?>" alt="" class="no-lazyload" />
											</div>
											<div class="item-title-wrapper">
												<?php echo $thisItem->title; ?>
											</div>
											<div class="item-subtitle-wrapper">
												<?php echo $thisItem->subtitle; ?>
											</div>
										</div>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div>

					</div>
				</div>
				<?php } ?>
				
				<?php } ?>
				
			</div>
			<?php if($settings['add_main_container'] === 'yes') { ?>
			</div>
			<?php } ?>
			
        </div>


<?php if($settings['use_slick'] === 'yes' && !empty($settings['slick_listing_class_name'])) { ?>
<script language="javascript">
	jQuery('.<?php echo $settings['slick_listing_class_name']; ?>').slick({
		<?php if($settings['is_homepage_hero'] === 'yes') { ?>
		slidesToShow: 1,
		infinite: false,
		dots: true,
		prevArrow: jQuery('.generic-listing-wrapper .custom-slick-arrows .custom-slick-prev-btn.<?php echo $settings['custom_slick_prev_btn'] ?>'),
		nextArrow: jQuery('.generic-listing-wrapper .custom-slick-arrows .custom-slick-next-btn.<?php echo $settings['custom_slick_next_btn'] ?>'),
		appendDots: jQuery('.generic-listing-wrapper .custom-slick-arrows .custom-slick-dots-inside-arrows.<?php echo $settings['custom_slick_dots'] ?>'),
		<?php } else { ?>
		slidesToShow: 3,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					centerMode: true,
					centerPadding: '35px'
				}

			}
		]
		<?php } ?>
	});
</script>
<?php } ?>


		<?php
	}

}