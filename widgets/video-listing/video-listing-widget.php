<?php

namespace ElementHelper\Widget;

use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;

defined( 'ABSPATH' ) || die();

class Video_Listing extends Element_El_Widget {

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
		return 'video-listing';
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
		return __( 'Video Listing', 'elementhelper' );
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
		return [ 'listing', 'video', 'box', 'text', 'content' ];
	}

	/**
	 * Register content related controls
	 */
	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title & Description', 'elementhelper' ),
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
			'show_header_in_video_list',
			[
				'label'        => __( 'Show Header in Video List', 'elementhelper' ),
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
			'image_background_external',
			[
				'label'       => __( 'Image Background External URL', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'image_backgroud',
			[
				'label'   => __( 'Image Background', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);
		
		$this->add_control(
			'show_cta',
			[
				'label'        => __( 'Show CTA', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$repeater = new Repeater();

		$repeater->add_control(
			'cta_text',
			[
				'label'       => __( 'CTA Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
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
			'cta_class',
			[
				'label'       => __( 'CTA Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'btn btn-primary',
			]
		);
		
		$repeater->add_control(
			'cta_image_before_text',
			[
				'label'       => __( 'CTA Image Before Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'cta_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(cta_text || "Item"); #>',
				'prevent_empty' => false,
			]
		);
		
		$this->add_control(
			'show_video',
			[
				'label'        => __( 'Show Video', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'swap_video_content',
			[
				'label'        => __( 'Swap Video Content', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'video_swappable_id',
			[
				'label'       => __( 'Video Swap ID', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'videoId',
			]
		);
		
		$this->add_control(
			'video_swappable_wrapper_class',
			[
				'label'       => __( 'Video Swap Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$repeater2 = new Repeater();

		$repeater2->add_control(
			'video_title',
			[
				'label'       => __( 'Video Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$repeater2->add_control(
			'video_thumbnail',
			[
				'label'   => __( 'Video Thumbnail', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater2->add_control(
			'video_embed',
			[
				'label'       => __( 'Video Embed', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'video_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater2->get_controls(),
				'title_field' => '<# print(video_title || "Item"); #>',
				'prevent_empty' => false,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Register styles related controls
	 */
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
				'default'      => '',
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
			'cta_wrapper_class',
			[
				'label'       => __( 'CTA Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'collapse_wrapper_class',
			[
				'label'       => __( 'Collapse Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
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
			'add_div_before_wrap',
			[
				'label'        => __( 'Add Div Before Wrap', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'div_before_wrap_class',
			[
				'label'       => __( 'Div Before Wrap Class', 'elementhelper' ),
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
		$image_background    = ! empty( $settings['image_backgroud']['url'] ) ? wp_get_attachment_image_url( $settings['image_backgroud']['id'], 'full' ) : '';
		?>
        
		<div class="video-listing-wrapper <?php echo $settings['module_class']; ?>"style="<?php if ( ! empty($image_background) || ! empty( $settings['image_background_external']) ) { ?> background-image: url(<?php echo ! empty( $settings['image_background_external'] ) ? $settings['image_background_external'] : $image_background; ?>); <?php } ?>">
			<?php if($settings['add_main_container'] === 'yes') { ?>
			<div class="container">
			<?php } ?>
			<?php if($settings['add_div_before_wrap'] === 'yes') { ?>
			<div class="video-listing-before-wrap <?php echo $settings['div_before_wrap_class']; ?>">
			<?php } ?>
			<div class="video-listing-wrap <?php echo $settings['module_wrap_class']; ?>" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php } ?></di>>
				<?php if ( $settings['show_header_in_video_list'] !== 'yes' AND (! empty( $settings['title'] ) OR ! empty( $settings['sub_title'] ) ) ): ?>
				<div class="header-wrap <?php echo $settings['header_wrap_class']; ?>">
					<?php if ( ! empty( $settings['title'] ) ): ?>
					<?php echo '<' . $settings['title_tag'] . ' class="title ' . $settings['title_class'] . '">'; ?>
					<?php echo $settings['title'] ?>
					<?php echo '</' . $settings['title_tag'] . '>'; ?>
					<?php endif; ?>
					<?php if ( ! empty( $settings['sub_title'] ) ): ?>
					<div class="sub-title">
						<?php echo $settings['sub_title'] ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<?php if ( ! empty( $settings['description'] ) ): ?>
				<div class="description-wrapper  <?php echo $settings['description_wrapper_class']; ?>">
					<?php echo $settings['description'] ?>
				</div>
				<?php endif; ?>
				<?php if($settings['show_video'] === 'yes' && count($settings['video_list'])): ?>
				<div class="video-list-wrapper" id="<?php echo $settings['video_swappable_id']; ?>">
					<?php if($settings['swap_video_content'] === 'yes') { ?>
						<div class="video-swappable-wrapper  <?php echo $settings['video_swappable_wrapper_class']; ?>">
							<div class="video-swap-left">
								<?php if ( $settings['show_header_in_video_list'] === 'yes' AND (! empty( $settings['title'] ) OR ! empty( $settings['sub_title'] ) ) ): ?>
								<div class="header-wrap <?php echo $settings['header_wrap_class']; ?>">
									<?php if ( ! empty( $settings['title'] ) ): ?>
									<?php echo '<' . $settings['title_tag'] . ' class="title ' . $settings['title_class'] . '">'; ?>
									<?php echo $settings['title'] ?>
									<?php echo '</' . $settings['title_tag'] . '>'; ?>
									<?php endif; ?>
									<?php if ( ! empty( $settings['sub_title'] ) ): ?>
									<div class="sub-title">
										<?php echo $settings['sub_title'] ?>
									</div>
									<?php endif; ?>
								</div>
								<?php endif; ?>
								<?php if ( ! empty( $settings['video_list'][0]['video_title'] ) ): ?>
								<h5>Now Playing</h5>
								<div class="video-swap-title" dataid="0">
									<?php echo $settings['video_list'][0]['video_title']; ?>
								</div>
								<?php endif; ?>
							</div>
							<div class="video-swap-middle">
								<div class="video-swap-embed">
									<?php echo $settings['video_list'][0]['video_embed']; ?>
								</div>
							</div>
							<div class="video-swap-right">
								<div class="video-swap-counter">
									<div class="video-swap-current-counter">1</div>
									/
									<div class="video-swap-max-counter"><?php echo count($settings['video_list']); ?></div>
								</div>
							</div>
						</div>
					<div class="video-swappable-list-wrapper">
						<?php 
							foreach( $settings['video_list'] as $videoIdx => $videoItem ) { 
								$video_thumbnail = ! empty( $videoItem['video_thumbnail']['url'] ) ? wp_get_attachment_image_url( $videoItem['video_thumbnail']['id'], 'full' ) : '';
						?>
						<div class="video-swappable-item">
							<div class="video-swappable-item-inner">
								<div class="video-swappable-item-thumbnail"  data-id="<?php echo $videoIdx; ?>">
									<a href="#" class="video-swappable-action <?php echo $videoIdx === 0 ? 'active' : ''; ?>" data-id="<?php echo $videoIdx; ?>" data-scope="<?php echo $settings['video_swappable_id']; ?>"><img src="<?php echo $video_thumbnail; ?>" alt="Video Thumbnail" /></a>
								</div>
								<div class="video-swap-next-title"  data-id="1">
									<a href="#" class="video-swappable-action" data-id="<?php echo $videoIdx; ?>" data-scope="<?php echo $settings['video_swappable_id']; ?>"><?php echo $videoItem['video_title']; ?></a>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					<?php } else { ?>
						<?php foreach( $settings['video_list'] as $videoIdx => $videoItem ) { ?>
						<?php
							$video_thumbnail = ! empty( $videoItem['video_thumbnail'] ) ? wp_get_attachment_image_url( $videoItem['video_thumbnail'], 'full' ) : '';
						?>
						<div class="video-item" data-index="<?php echo $videoItem; ?>">
							<?php if ( ! empty( $videoItem['video_title'] ) ): ?>
							<div class="video-item-title"><?php echo $videoItem['video_title']; ?></div>
							<?php endif; ?> 
							<?php if ( ! empty( $video_thumbnail ) ): ?>
							<diiv class="video-item-thumbnail"><img class="video-thumbnail" src="<?php echo $video_thumbnail; ?>" alt="Video Thumbnail" /></diiv>
							<?php endif; ?> 
							<?php if ( ! empty( $videoItem['video_embed'] ) ): ?>
							<diiv class="video-item-embed"><?php echo $videoItem['video_embed']; ?></diiv>
							<?php endif; ?> 
						</div>
						<?php } ?>
					<?php } ?>
				</div>
				<?php endif; ?>
				<?php if($settings['show_cta'] === 'yes' && count($settings['cta_list'])) { ?>
				<div class="cta-wrapper <?php echo $settings['cta_wrapper_class']; ?>">
					<?php foreach( $settings['cta_list'] as $ctaItem ) { ?>
					<a href="<?php echo $ctaItem['cta_link']; ?>" target="<?php echo $ctaItem['cta_target']; ?>" class="<?php echo $ctaItem['cta_class']; ?>">
						<?php if( ! empty($ctaItem['cta_image_before_text']) ) { echo '<img src="'.$ctaItem['cta_image_before_text'].'" class="cta-image-before-text" alt="Image" />'; } ?>
						<?php echo $ctaItem['cta_text']; ?>
					</a>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<?php if($settings['add_div_before_wrap'] === 'yes') { ?>
			</div>
			<?php } ?>
			<?php if($settings['add_main_container'] === 'yes') { ?>
			</div>
			<?php } ?>
			
        </div>

		<?php if($settings['swap_video_content'] === 'yes' AND count($settings['video_list']) > 1) { ?>
		<script language="javascript">
			window.swappable_video['<?php echo $settings['video_swappable_id']; ?>'] = { cur_idx: 0, cur_num: 1, max_idx: <?php echo (count($settings['video_list']) - 1); ?>, max_num: <?php echo count($settings['video_list']); ?>, video_list: [] };
			<?php 
			foreach( $settings['video_list'] as $videoIdx => $videoItem ) { 
				$video_thumbnail = ! empty( $videoItem['video_thumbnail']['url'] ) ? wp_get_attachment_image_url( $videoItem['video_thumbnail']['id'], 'full' ) : '';

			?>
			window.swappable_video['<?php echo $settings['video_swappable_id']; ?>'].video_list.push( { 
				idx: <?php echo $videoIdx; ?>, 
				title: '<?php echo str_replace("'", "\'", $videoItem['video_title']); ?>',
				thumb: '<?php echo ! empty( $video_thumbnail ) ? '<img src="' . $video_thumbnail . '" alt="Video Thumbnail" />' : ''; ?>',
				embed: '<?php echo str_replace("'", "\'", $videoItem['video_embed']); ?>',
			} );
			<?php } ?>
			jQuery('.video-swappable-list-wrapper').slick({
				slidesToShow: 5,
				slidesToScroll: 1,
				responsive: [
					{
						breakpoint: 1200,
						settings: {
							/*centerMode: true,
							centerPadding: '40px',*/
							slidesToShow: 4
						}
					},
					{
						breakpoint: 992,
						settings: {
							/*centerMode: true,
							centerPadding: '40px',*/
							slidesToShow: 3
						}
					},
					{
						breakpoint: 768,
						settings: {
							centerMode: true,
							centerPadding: '40px',
							slidesToShow: 2
						}
					}
				]
			});
		</script>
		<?php } ?>


		<?php
	}
}
