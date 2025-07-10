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

class Hero extends Element_El_Widget {


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
		return 'hero';
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
		return __( 'Hero', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/hero/';
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
		return [ 'hero', 'blurb', 'infobox', 'content', 'block', 'box' ];
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
			'field_condition',
			[
				'label'              => __( 'Slide Style', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'style_1' => __( 'Style 1', 'elementhelper' ),
					'style_2' => __( 'Style 2', 'elementhelper' ),
					'style_3' => __( 'Style 3', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'     => __( 'Image', 'elementhelper' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'field_condition' => [ 'style_1', 'style_2', 'style_3' ],
				],
			]
		);
		
		$repeater->add_control(
			'use_video',
			[
				'label'        => __( 'Use Video', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$repeater->add_control(
			'video_link',
			[
				'label'       => __( 'Video Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_2', 'style_3' ],
				],
			]
		);

		$repeater->add_control(
			'show_video_control',
			[
				'label'        => __( 'Show Video Control', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$repeater->add_control(
			'item_id',
			[
				'label'       => __( 'Item ID', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_2', 'style_3' ],
				],
			]
		);

		$repeater->add_control(
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
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_2', 'style_3' ],
				],
				'default'            => 'H2',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_2', 'style_3' ],
				],
			]
		);

		$repeater->add_control(
			'sub_title',
			[
				'label'       => __( 'Sub Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_2' ],
				],
			]
		);
		
		$repeater->add_control(
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_2' ],
				],
			]
		);

		$repeater->add_control(
			'btn_text_1',
			[
				'label'       => __( 'Button Text 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);

		$repeater->add_control(
			'btn_link_1',
			[
				'label'       => __( 'Button Link 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);
		
		$repeater->add_control(
			'btn_class_1',
			[
				'label'       => __( 'Button Class 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);

		$repeater->add_control(
			'btn_target_1',
			[
				'label'       => __( 'Button Target 1', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
				'default'      => '_self',
			]
		);

		$repeater->add_control(
			'btn_text_2',
			[
				'label'       => __( 'Button Text 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);

		$repeater->add_control(
			'btn_link_2',
			[
				'label'       => __( 'Button Link 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);
		
		$repeater->add_control(
			'btn_class_2',
			[
				'label'       => __( 'Button Class 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);

		$repeater->add_control(
			'btn_target_2',
			[
				'label'       => __( 'Button Target 2', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
				'default'      => '_self',
			]
		);

		$repeater->add_control(
			'btn_text_3',
			[
				'label'       => __( 'Button Text 3', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);

		$repeater->add_control(
			'btn_link_3',
			[
				'label'       => __( 'Button Link 3', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);
		
		$repeater->add_control(
			'btn_class_3',
			[
				'label'       => __( 'Button Class 3', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
			]
		);
		
		$repeater->add_control(
			'btn_target_3',
			[
				'label'       => __( 'Button Target 3', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'field_condition' => [ 'style_1', 'style_3' ],
				],
				'default'      => '_self',
			]
		);

		$this->add_control(
			'slider',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Slide Item"); #>',
				'prevent_empty' => false,
			]
		);

		$repeater2 = new Repeater();

		$repeater2->add_control(
			'show_listing',
			[
				'label'        => __( 'Show Listing', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$repeater2->add_control(
			'json_listing',
			[
				'label'       => __( 'JSON Listing', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);
		
		$repeater2->add_control(
			'listing_title',
			[
				'label'       => __( 'Listing Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$this->add_control(
			'listing',
			[
				'label'       => __( 'Listing Item', 'elementhelper' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater2->get_controls(),
				'title_field' => '<# print(listing_title || "Item"); #>',
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
			'hero_wrapper_class',
			[
				'label'       => __( 'Hero Wrapper Class', 'elementhelper' ),
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
		?>

        <div class="hero-wrapper <?php echo $settings['hero_wrapper_class']; ?>">
			<?php if ( ! empty( $settings['slider'] ) ): ?>
                <div class="hero-slider-active">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
							<?php foreach ( $settings['slider'] as $itemIdx => $item ): ?>
								<?php $image = ! empty( $item['image']['url'] ) ? wp_get_attachment_image_url( $item['image']['id'], 'full' ) : ''; ?>
								<?php if ( $item['field_condition'] === 'style_1' ): ?>
                                    <div class="swiper-slide single-slide">
										<div class="hero-content-wrapper" <?php if( $item['use_video'] !== 'yes' ) { ?>style="background-image: url(<?php echo $image; ?>)"<?php } ?>>
											<?php if( $item['use_video'] === 'yes' ) { ?>
											<div class="video-background-wrapper">
												<video width="320" height="240" muted autoplay loop playsinline id="heroVideo<?php echo $item['item_id']; ?>">
													<source src="<?php echo $item['video_link']; ?>" type="video/mp4">
													<source src="movie.ogg" type="video/ogg">
													<track src="captions_en.vtt" kind="captions" srclang="en" label="english_captions">
													Your browser does not support the video tag.
												</video>
											</div>
											<?php } ?>
											<div class="container">
												<div class="content">
													<?php if ( ! empty( $item['title'] ) || ! empty( $item['sub_title'] ) ) { ?>
													<div class="header-wrap <?php echo $settings['header_wrap_class']; ?>">
													<?php if ( ! empty( $item['title'] ) ): ?>
													<?php echo '<' . $item['title_tag'] . ' class="title ' . $settings['title_class'] . '" data-animation="fadeInUp-None" data-delay="0.4s">'; ?>
													<span><?php echo $item['title'] ?></span>
													<?php echo '</' . $item['title_tag'] . '>'; ?>
													<?php endif; ?>
													<?php if ( ! empty( $item['sub_title'] ) ): ?>
													<span data-animation="fadeInUp-None"
														  data-delay="0.2s">
														<?php echo $item['sub_title'] ?>
													</span>
													<?php endif; ?>
													</div>
													<?php } ?>
													<?php if ( ! empty( $item['description'] ) ): ?>
													<p data-animation="fadeInUp-None" data-delay="0.6s">
														<?php echo $item['description'] ?>
													</p>
													<?php endif; ?>
													<?php
														$setTabIndexTo = $itemIdx !== 0 ? '1' : '1';
													?>
													<div class="h-tags" data-animation="fadeInUp-None" data-delay="0.4s">
														<?php if ( ! empty( $item['btn_text_1'] ) ): ?>
														<a href="<?php echo $item['btn_link_1'] ?>" class="btn <?php echo $item['btn_class_1'] ?>" target="<?php echo $item['btn_target_1'] ?>" <?php if($itemIdx !== 0) { ?>tabindex="-1"<?php } ?>>
															<?php echo $item['btn_text_1'] ?>
														</a>
														<?php endif; ?>
														<?php if ( ! empty( $item['btn_text_2'] ) ): ?>
														<a href="<?php echo $item['btn_link_2'] ?>" class="btn <?php echo $item['btn_class_2'] ?>" target="<?php echo $item['btn_target_2'] ?>" <?php if($itemIdx !== 0) { ?>tabindex="-1"<?php } ?>>
															<?php echo $item['btn_text_2'] ?>
														</a>
														<?php endif; ?>
														<?php if ( ! empty( $item['btn_text_3'] ) ): ?>
														<a href="<?php echo $item['btn_link_3'] ?>" class="btn <?php echo $item['btn_class_3'] ?>" target="<?php echo $item['btn_target_3'] ?>" <?php if($itemIdx !== 0) { ?>tabindex="-1"<?php } ?>>
															<?php echo $item['btn_text_3'] ?>
														</a>
														<?php endif; ?>
													</div>
													<?php if( $item['show_video_control'] === 'yes' ) { ?>
													<div class="video-play-control">
														<button aria-label="Click to play" id="heroPlayVideo" onclick="playHeroVideo('<?php echo $item['item_id']; ?>')"> <i class="fa-solid fa-play"></i> <span>Play</span></button>
														<button aria-label="Click to pause" id="heroPauseVideo" onclick="pauseHeroVideo('<?php echo $item['item_id']; ?>')"> <i class="fa-solid fa-pause"></i> <span>Pause</span></button>
													</div>
													<script language="javascript">
														myHeroVideo['<?php echo $item['item_id']; ?>'] = document.getElementById('heroVideo<?php echo $item['item_id']; ?>');
													</script>
													<?php } ?>
													<?php
													$listingActive = count($settings['listing']) > $itemIdx && $settings['listing'][$itemIdx]['show_listing'] === 'yes' ? true : false;
													if($listingActive) {
														$thisListing = json_decode($settings['listing'][$itemIdx]['json_listing']);
													?>
													<div class="hero-listing-wrapper <?php if($listingActive) { echo ' total-cols-' . count($thisListing) ; } ?>">
														<div class="hero-listing-inner">
															<ul class="hero-listing-items">
																<?php 
																foreach ( $thisListing as $lIdx => $lItem ) { 
																?>
																<li class="hero-listing-item">
																	<div class="hero-listing-item-wrapper">
																		<?php if ( ! empty($lItem->image_url) ) { ?>
																			<div class="item-image-wrapper">
																				<img src="<?php echo $lItem->image_url; ?>" alt="" />
																			</div>
																		<?php } ?>
																		<?php if ( ! empty($lItem->title) ) { ?>
																			<div class="item-title-wrapper">
																				<?php echo $lItem->title; ?>
																			</div>
																		<?php } ?>
																		<?php if ( ! empty($lItem->subtitle) ) { ?>
																			<div class="item-subtitle-wrapper">
																				<?php echo $lItem->subtitle; ?>
																			</div>
																		<?php } ?>
																	</div>
																</li>
																<?php } ?>
															</ul>
														</div>
													</div>
													<?php } ?>
												</div>
												
                                            </div>
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( $item['field_condition'] === 'style_2' ): ?>
                                    <div class="swiper-slide single-slide">
                                        <div class="hero-content-wrapper-2"
                                             style="background-image: url(<?php echo $image; ?>)">
                                            <div class="shape">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/shape-2.png"
                                                     alt="thumb">
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xl-10">
                                                        <div class="content">
															<?php if ( ! empty( $item['sub_title'] ) ): ?>
                                                                <span data-animation="fadeInUp" data-delay="0.2s">
                                                                    <?php echo $item['sub_title'] ?>
                                                                </span>
															<?php endif; ?>
															<?php if ( ! empty( $item['title'] ) ): ?>
                                                                <h1 data-animation="fadeInUp" data-delay="0.4s">
																	<?php echo $item['title'] ?>
                                                                </h1>
															<?php endif; ?>
															<?php if ( ! empty( $item['description'] ) ): ?>
                                                                <p data-animation="fadeInUp" data-delay="0.6s">
																	<?php echo $item['description'] ?>
                                                                </p>
															<?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								<?php endif; ?>
								<?php if ( $item['field_condition'] === 'style_3' ): ?>
                                    <div class="swiper-slide single-slide">
                                        <div class="hero-content-wrapper-3"
                                             style="background-image: url(<?php echo $image; ?>)">
                                            <div class="shape">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/shape/shape-3.png"
                                                     alt="thumb">
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xl-10">
                                                        <div class="content">
															<?php if ( ! empty( $item['title'] ) ): ?>
                                                                <h1 data-animation="fadeInUp" data-delay="0.2s">
																	<?php echo $item['title'] ?>
                                                                </h1>
															<?php endif; ?>
                                                            <div class="h-tags" data-animation="fadeInUp"
                                                                 data-delay="0.4s">
																<?php if ( ! empty( $item['btn_text_1'] ) ): ?>
                                                                    <a href="<?php echo $item['btn_link_1'] ?>" target="<?php echo $item['btn_target_1'] ?>">
																		<?php echo $item['btn_text_1'] ?>
                                                                    </a>
																<?php endif; ?>
																<?php if ( ! empty( $item['btn_text_2'] ) ): ?>
                                                                    <a href="<?php echo $item['btn_link_2'] ?>" target="<?php echo $item['btn_target_2'] ?>">
																		<?php echo $item['btn_text_2'] ?>
                                                                    </a>
																<?php endif; ?>
																<?php if ( ! empty( $item['btn_text_3'] ) ): ?>
                                                                    <a href="<?php echo $item['btn_link_3'] ?>" target="<?php echo $item['btn_target_3'] ?>">
																		<?php echo $item['btn_text_3'] ?>
                                                                    </a>
																<?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								<?php endif; ?>
							<?php endforeach; ?>
                        </div>
                    </div>

					
                    <div class="hero-control-wrap-wrapper">
						<div class="container">
							<div class="hero-control-wrap">
								<div class="hero-control-wrap-inner">
									<div class="hero-button-prev"><i class="fa-regular fa-angle-left"></i></div>
									<div class="hero-pagination"></div>
									<div class="hero-button-next"><i class="fa-regular fa-angle-right"></i></div>
								</div>
							</div>
						</div>
                    </div>
                </div>
			<?php endif; ?>
        </div>
		<?php
	}

}