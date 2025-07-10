<?php

namespace ElementHelper\Widget;

use \Elementor\Core\Schemes\Typography;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;
use \Elementor\Core\Schemes;
use \Elementor\Group_Control_Background;
use \ElementHelper\Element_El_Select2;

defined( 'ABSPATH' ) || die();


class News_Feed extends Element_El_Widget {

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
		return 'news-feed';
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
		return __( 'News Feed', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.net/widgets/post-list/';
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
		return 'eicon-parallax';
	}

	public function get_keywords() {
		return [ 'posts', 'post', 'post-list', 'list', 'news' ];
	}
	
	protected $academicYearDropdown = array();
	
	protected function get_all_post_categories() {
		$categories = get_categories();
		//var_dump($categories);
		$all_categories = [];
		foreach ( $categories as $idx => $category ) {
			$all_categories[$category->term_id] = $category->cat_name;
		}
		return $all_categories;
	}
	
	protected function groupByAcademicYear($post_data) {
		foreach ( $post_data as $idx => $each_post ) {
			$new_post_data = [ 'ID' => $each_post->ID, 'post_title' => $each_post->post_title, 'post_date' => $each_post->post_date, 'post_academic_year' => 0 ];
			$pDate = date_create($each_post->post_date);
			$pDateM = intval(date_format($pDate, 'n'));
			$pDateY = intval(date_format($pDate, 'Y'));
			$startAY = $pDateY - 1;
			$endAY = $pDateY;
			if($pDateM >= 7) {
				$startAY = $pDateY;
				$endAY = $pDateY + 1;
			}
			$this->academicYearDropdown[$startAY] = $startAY . ' - ' . $endAY;
			$post_data[$idx]->post_academic_year = $startAY;
		}
		return $post_data;
	}

	/**
	 * Get a list of All Post Types
	 *
	 * @return array
	 */
	protected function register_content_controls() {


		$this->start_controls_section(
			'_section_feed_info',
			[
				'label' => __( 'Feed Info', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'show_academic_year',
			[
				'label'        => __( 'Show Academic Year Dropdown', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
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
				'default' => 'Recent News',
			]
		);
		
		$this->add_control(
			'special_homepage_news_feed',
			[
				'label'        => __( 'Special Homepage News Feed', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'special_dark_news_feed',
			[
				'label'        => __( 'Special Dark News Feed', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
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
				'default'      => '',
			]
		);
		
		$this->add_control(
			'slick_class_name',
			[
				'label'       => __( 'Slick Class Name', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default' => '',
			]
		);

		$this->add_control(
			'post_categories',
			[
				'label'        => __( 'Select Post Categories', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_post_categories(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'has_main_post',
			[
				'label'        => __( 'Has Main Post', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'     => __( 'Item Limit', 'elementhelper' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'dynamic'   => [ 'active' => true ],
			]
		);
		
		$this->add_control(
			'shwo_selected_post_categories',
			[
				'label'        => __( 'Show Selected Post Categories', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_title_tag',
			[
				'label'              => __( 'News Item Title Tag', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'H2' => __( 'h2', 'elementhelper' ),
					'H3' => __( 'h3', 'elementhelper' ),
					'H4' => __( 'h4', 'elementhelper' ),
					'H5' => __( 'h5', 'elementhelper' ),
					'H6' => __( 'h6', 'elementhelper' ),
					'H1' => __( 'h1', 'elementhelper' ),
				],
				'default'            => 'H4',
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);
		
		$this->add_control(
			'show_arrow_on_read_more',
			[
				'label'        => __( 'Show Right Arrow on Read more', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'show_button_below_post',
			[
				'label'        => __( 'Show Button Below Post', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'button_below_post_text',
			[
				'label'       => __( 'Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default' => '',
			]
		);
		
		$this->add_control(
			'button_below_post_link',
			[
				'label'       => __( 'Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default' => '',
			]
		);
		
		$this->add_control(
			'button_below_post_target',
			[
				'label'       => __( 'Target', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default' => '_self',
			]
		);
		
		$this->add_control(
			'button_below_post_class',
			[
				'label'       => __( 'Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default' => '',
			]
		);

		$this->end_controls_section();

	}

	protected function register_style_controls() {

		$this->start_controls_section(
			'_section_media_style',
			[
				'label' => __( 'Style', 'elementhelper' ),
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
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_feed_title_wrap_class',
			[
				'label'       => __( 'News Feed Title Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_feed_title_class',
			[
				'label'       => __( 'News Feed Title Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_list_class',
			[
				'label'       => __( 'News List Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_class',
			[
				'label'       => __( 'News Item Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_wrapper_class',
			[
				'label'       => __( 'News Item Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_image_wrapper_class',
			[
				'label'       => __( 'News Item Image Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_image_class',
			[
				'label'       => __( 'News Item Image Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$this->add_control(
			'news_item_details_class',
			[
				'label'       => __( 'News Item Details Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_title_class',
			[
				'label'       => __( 'News Item Title Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_date_class',
			[
				'label'       => __( 'News Item Date Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$this->add_control(
			'news_item_brief_class',
			[
				'label'       => __( 'News Item Brief Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_more_class',
			[
				'label'       => __( 'News Item More Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_item_read_more_class',
			[
				'label'       => __( 'News Item Read More Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'news_button_below_post_class',
			[
				'label'       => __( 'News Button Below Post Class', 'elementhelper' ),
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
	
	protected function groupByCalendarYear($posts) {
		$new_posts = $posts;
		return $new_posts;
	}
	
	protected function icon_right_arrow() {
		return '<svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0807 11.5855L13.581 12.0816L19.3712 6.34061L13.581 0.59961L13.0807 1.09575L18.013 5.98622L1 5.98622L1 6.69499L18.013 6.69499L13.0807 11.5855Z" fill="#990000" stroke="#990000" stroke-width="0.5"/></svg>';
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if( $settings['special_homepage_news_feed'] === 'yes' && $settings['special_dark_news_feed'] === 'yes' ) {
			$student_spotlight_categories = array('546','548');
			$faculty_spotlight_categories = array('546','547');
			$alumni_spotlight_categories = array('546','53');
			$args['posts_per_page'] = 1;
			$args['category__and'] = $student_spotlight_categories;
			$args['post_type'] = 'news';
			$student_spotlight_posts = get_posts( $args )[0];
			$student_spotlight_posts->post_categories = $student_spotlight_categories;
			$student_spotlight_posts->bottom_cta_text = 'Student Affairs';
			$student_spotlight_posts->bottom_cta_link = '#';
			$args['category__and'] = $faculty_spotlight_categories;
			$args['post_type'] = 'news';
			$faculty_spotlight_posts = get_posts( $args )[0];
			$faculty_spotlight_posts->post_categories = $faculty_spotlight_categories;
			$faculty_spotlight_posts->bottom_cta_text = 'Meet Our Faculty';
			$faculty_spotlight_posts->bottom_cta_link = '/faculty/';
			$args['category__and'] = $alumni_spotlight_categories;
			$args['post_type'] = 'news';
			$alumni_spotlight_posts = get_posts( $args )[0];
			$alumni_spotlight_posts->post_categories = $alumni_spotlight_categories;
			$alumni_spotlight_posts->bottom_cta_text = 'Alumni Association';
			$alumni_spotlight_posts->bottom_cta_link = '#';
			$selected_posts = array($student_spotlight_posts, $faculty_spotlight_posts, $alumni_spotlight_posts);
			//var_dump($selected_posts);
		} else {
			$args['posts_per_page'] = $settings['posts_per_page'];
			$args['category__and'] = $settings['post_categories'];
			$args['post_type'] = 'news';
			$selected_posts = $settings['show_academic_year'] === 'yes' ? $this->groupByCalendarYear(get_posts( $args )) : get_posts( $args );
			foreach($selected_posts as $idx => $selected_post) {
				$selected_post->post_categories = $settings['post_categories'];
			}
			//$selected_posts->post_categories = $settings['post_categories'];
			if($settings['show_academic_year'] === 'yes') {
				$selected_posts = $this->groupByAcademicYear($selected_posts);
				$defaultAY = array_keys($this->academicYearDropdown)[0];
			}
			$isMediaAdvisories = in_array('67', $settings['post_categories']);
			$isRedesignBlog = in_array('58', $settings['post_categories']);
			$title = elh_element_kses_basic( $settings['title'] );
			//$selected_posts->bottom_cta_text = 'Student Affairs';
			//$selected_posts->bottom_cta_link = '#';

			$main_post = array();
			if($settings['has_main_post'] === 'yes') {
				$main_post = array_shift($selected_posts);
			}
			
			//var_dump($selected_posts);
			//exit;
		}
		
		//exit;
		?>


		<div class="news-feed-wrapper <?php echo $settings['module_class']; ?>">
			<div class="news-feed-wrap <?php echo $settings['module_wrap_class']; ?>">
				<?php if ( $settings['show_academic_year'] === 'yes' ) { ?>
				<div class="academic-year-dropdown-wrapper">
					<select name="academicYear" class="academic-year-dropdown">
						<?php foreach($this->academicYearDropdown as $ayVal => $ayLabel) { ?>
						<option value="<?php echo $ayVal; ?>"><?php echo $ayLabel; ?></option>
						<?php } ?>
					</select>
				</div>
				<?php } ?>
				<?php if ( ! empty($title) || $settings['show_academic_year'] === 'yes' ) { ?>
				<?php
					if($settings['show_academic_year'] === 'yes') {
						$title = 'News for the <span>'.$this->academicYearDropdown[$defaultAY].'</span> Academic Year';
						if($isMediaAdvisories) {
							$title = 'Media Advisories for the <span>'.$this->academicYearDropdown[$defaultAY].'</span> Academic Year';
						}
					}
				?>
				<div class="news-feed-title-wrap <?php echo $settings['news_feed_title_wrap_class']; ?>">
					<?php if ( ! empty( $title ) ): ?>
					<?php echo '<' . $settings['title_tag'] . ' class="title ' . $settings['news_feed_title_class'] . '">'; ?>
					<span><?php echo $title ?></span>
					<?php echo '</' . $settings['title_tag'] . '>'; ?>
					<?php endif; ?>
				</div>
				<?php } ?>
				<?php if( ! empty($selected_posts) ) { ?>
				<?php if( $settings['special_dark_news_feed'] === 'yes' ) { ?>
					<div class="special-dark-news-feed-wrapper <?php if ( $settings['use_slick'] === 'yes' ) { echo $settings['slick_class_name']; } ?> ">
						<?php foreach( $selected_posts as $idx => $selected_post ) { 
							$imported_image = get_post_meta( $selected_post->ID, 'news_image', true );
							$new_image = !empty($imported_image) ? $imported_image : 'https://gould.usc.edu/portal/news/images/news/placeholder.gif';
							$new_image = get_the_post_thumbnail_url($selected_post->ID) ?  get_the_post_thumbnail_url($selected_post->ID, 'large') : (!empty($imported_image) ? $imported_image : 'https://gould.usc.edu/portal/news/images/news/placeholder.gif');
							$new_image_alt = get_post_thumbnail_id($selected_post->ID) ? get_post_meta(get_post_thumbnail_id($selected_post->ID), '_wp_attachment_image_alt', TRUE) : '';
							$this_post_categories = get_the_category($selected_post->ID);
							$selected_post_categories = [];
							if( $settings['shwo_selected_post_categories'] === 'yes' ) {
								foreach( $this_post_categories as $this_post_category ) {
									//var_dump($this_post_category->term_id);
									if(in_array($this_post_category->term_id, $selected_post->post_categories)) {
										array_push($selected_post_categories, $this_post_category);
									}
								}
							}
							//var_dump($selected_post_categories);
						?>
						<div class="special-dark-news-feed">
							<div class="news-item-wrapper <?php echo $settings['news_item_wrapper_class']; ?>" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php } ?> style="background-image: url(<?php echo $new_image; ?>);">
								<div class="news-details <?php echo $settings['news_item_details_class']; ?>">
									<div class="news-item-up-arrow-wrapper">
										<img src="/wp-content/uploads/2023/06/icon-up-arrow-yellow.png" />
									</div>
									<?php
				//var_dump($selected_post_categories);
										if( count($selected_post_categories) ) {
									?>
									<div class="news-categories-wrapper">
										<?php
											foreach( $selected_post_categories as $selected_post_category ) {
										?>
										<a href="#" class="news-category-link"><?php echo $selected_post_category->cat_name ; ?></a>
										<?php
											}
										?>
									</div>
									<?php
										}
									?>
									<div class="news-title">									
										<?php echo $selected_post->post_title ?>
									</div>
									<div class="news-brief-shorten <?php echo $settings['news_item_brief_class']; ?>">
											<?php echo get_post_meta( $selected_post->ID, 'news_brief_description', true ); ?>
									</div>
									<div class="news-brief <?php echo $settings['news_item_brief_class']; ?>">
											<?php echo get_post_meta( $selected_post->ID, 'news_brief_description', true ); ?>
									</div>
									<div class="news-more <?php echo $settings['news_item_more_class']; ?>">
										<a href="<?php echo get_permalink( $selected_post->ID ); ?>" class=" <?php echo $settings['news_item_read_more_class']; ?>" aria-label="Click to read more about <?php echo $selected_post->post_title ?>">
											Read more
											<?php if ( $settings['show_arrow_on_read_more'] === 'yes' ) { ?>
											<?php echo $this->icon_right_arrow(); ?>
											<?php } ?>
										</a>
									</div>
									<?php if ( $settings['show_button_below_post'] === 'yes' ) { ?>
									<div class="button-below-post-wrapper <?php echo $settings['news_button_below_post_class']; ?>">
										<a href="<?php echo $selected_post->bottom_cta_link; ?>" class="<?php echo $settings['button_below_post_class']; ?>" target="<?php echo $settings['button_below_post_target']; ?>"><?php echo $selected_post->bottom_cta_text; ?></a>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				<?php } else if( $settings['special_homepage_news_feed'] === 'yes' ) { ?>
					<div class="special-hoempage-news-feed-wrapper <?php if ( $settings['use_slick'] === 'yes' ) { echo $settings['slick_class_name']; } ?> ">
						<?php foreach( $selected_posts as $idx => $selected_post ) { 
							$selFeaturedImage = get_the_post_thumbnail_url($selected_post->ID, 'large');
							$selFeaturedImage = str_replace("http://goulddev.usc.edu", "", $selFeaturedImage);
							$imported_image = get_post_meta( $selected_post->ID, 'news_image', true );
							$new_image = ! empty($selFeaturedImage) ? $selFeaturedImage : ( ! empty($imported_image) ? $imported_image : '/wp-content/uploads/2023/04/faculty-placeholder.png');
							//$new_image = !empty($imported_image) ? $imported_image : 'https://gould.usc.edu/portal/news/images/news/placeholder.gif';
							$new_image_alt = get_post_thumbnail_id($selected_post->ID) ? get_post_meta(get_post_thumbnail_id($selected_post->ID), '_wp_attachment_image_alt', TRUE) : '';
							$this_post_categories = get_the_category($selected_post->ID);
							$selected_post_categories = [];
							if( $settings['shwo_selected_post_categories'] === 'yes' ) {
								foreach( $this_post_categories as $this_post_category ) {
									//var_dump($this_post_category->term_id);
									if(in_array($this_post_category->term_id, $selected_post->post_categories)) {
										array_push($selected_post_categories, $this_post_category);
									}
								}
							}
							//var_dump($selected_post_categories);
						?>
						<div class="special-hoempage-news-feed">
							<div class="news-item-wrapper <?php echo $settings['news_item_wrapper_class']; ?>" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php } ?>>
								<div class="news-image <?php echo $settings['news_item_image_wrapper_class']; ?>">
									<a href="<?php echo get_permalink( $main_post->ID ); ?>" aria-label="Click to read more about <?php echo $selected_post->post_title ?>" class=" "><img src="<?php echo $new_image; ?>" class="<?php echo $settings['news_item_image_class']; ?>" alt="<?php echo $new_image_alt; ?>" /></a>
								</div>
								<div class="news-details <?php echo $settings['news_item_details_class']; ?>">
									<?php
				//var_dump($selected_post_categories);
										if( count($selected_post_categories) ) {
									?>
									<div class="news-categories-wrapper">
										<?php
											foreach( $selected_post_categories as $selected_post_category ) {
										?>
										<a href="#" class="news-category-link"><?php echo $selected_post_category->cat_name ; ?></a>
										<?php
											}
										?>
									</div>
									<?php
										}
									?>
									<div class="news-title">									
									<?php echo $selected_post->post_title ?>
									</div>
									<div class="news-brief <?php echo $settings['news_item_brief_class']; ?>">
										<?php echo get_post_meta( $selected_post->ID, 'news_brief_description', true ); ?>
									</div>
									<div class="news-date <?php echo $settings['news_item_date_class']; ?>">
										<?php echo date_format(date_create($selected_post->post_date), "F j, Y"); ?>
									</div>
									<div class="news-more <?php echo $settings['news_item_more_class']; ?>">
										<a href="<?php echo get_permalink( $selected_post->ID ); ?>" class=" <?php echo $settings['news_item_read_more_class']; ?>" aria-label="Click to read more about <?php echo $selected_post->post_title ?>">
											Read more
											<?php if ( $settings['show_arrow_on_read_more'] === 'yes' ) { ?>
											<?php echo $this->icon_right_arrow(); ?>
											<?php } ?>
										</a>
									</div>
								</div>
								<?php if ( $settings['show_button_below_post'] === 'yes' ) { ?>
								<div class="button-below-post-wrapper <?php echo $settings['news_button_below_post_class']; ?>">
									<a href="<?php echo $selected_post->bottom_cta_link; ?>" class="<?php echo $settings['button_below_post_class']; ?>" target="<?php echo $settings['button_below_post_target']; ?>"><?php echo $selected_post->bottom_cta_text; ?></a>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div>
				<?php } else { ?>
					<?php if ( $settings['has_main_post'] === 'yes' && ! empty ($main_post) ) { 
						$imported_image = get_post_meta( $main_post->ID, 'news_image', true );
						$selFeaturedImage = get_the_post_thumbnail_url($main_post->ID, 'large');
						$selFeaturedImage = str_replace("http://goulddev.usc.edu", "", $selFeaturedImage);
						$imported_image = get_post_meta( $main_post->ID, 'news_image', true );
						$new_image = ! empty($selFeaturedImage) ? $selFeaturedImage : ( ! empty($imported_image) ? $imported_image : '/wp-content/uploads/2023/04/faculty-placeholder.png');
						//$new_image = !empty($imported_image) ? $imported_image : 'https://gould.usc.edu/portal/news/images/news/placeholder.gif';
						$new_image_alt = get_post_thumbnail_id($main_post->ID) ? get_post_meta(get_post_thumbnail_id($main_post->ID), '_wp_attachment_image_alt', TRUE) : '';

					?>
					<ul class="news-list-main">
						<li class="news-item">
							<div class="news-item-wrapper <?php echo $settings['news_item_wrapper_class']; ?>" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php } ?>>
								<div class="news-image <?php echo $settings['news_item_image_wrapper_class']; ?>">
									<a href="<?php echo get_permalink( $main_post->ID ); ?>" class=" " aria-label="Click to read more about <?php echo $main_post->post_title ?>"><img src="<?php echo $new_image; ?>" class="<?php echo $settings['news_item_image_class']; ?>" alt="<?php echo $new_image_alt; ?>" /></a>
								</div>
								<div class="news-details <?php echo $settings['news_item_details_class']; ?>">
									<?php echo '<' . $settings['news_item_title_tag'] . ' class="news-title ' . $settings['news_item_title_class'] . '">'; ?>
									<?php echo $main_post->post_title ?>
									<?php echo '</' . $settings['news_item_title_tag'] . '>'; ?>								
									<div class="news-date <?php echo $settings['news_item_date_class']; ?>">
										<?php echo date_format(date_create($main_post->post_date), "F j, Y"); ?>
									</div>
									<div class="news-brief <?php echo $settings['news_item_brief_class']; ?>">
										<?php echo get_post_meta( $main_post->ID, 'news_brief_description', true ); ?>
									</div>
									<div class="news-more <?php echo $settings['news_item_more_class']; ?>">
										<a href="<?php echo get_permalink( $main_post->ID ); ?>" class=" <?php echo $settings['news_item_read_more_class']; ?>">
											Read more
											<?php if ( $settings['show_arrow_on_read_more'] === 'yes' ) { ?>
											<img src="/wp-content/uploads/2023/03/icon-right-arrow.png" class="right-arrow-read-more" alt="Right arrow icon" />
											<?php } ?>
										</a>
									</div>
								</div>
								<?php if ( $settings['show_button_below_post'] === 'yes' ) { ?>
								<div class="button-below-post-wrapper <?php echo $settings['news_button_below_post_class']; ?>">
									<a href="<?php echo $settings['button_below_post_link']; ?>" class="<?php echo $settings['button_below_post_class']; ?>" target="<?php echo $settings['button_below_post_target']; ?>"><?php echo $settings['button_below_post_text']; ?></a>
								</div>
								<?php } ?>
							</div>
						</li>
					</ul>
					<?php } ?>
					<?php if ( $settings['use_slick'] === 'yes' ) { ?>
					<div class="news-list <?php echo $settings['news_list_class'] . ' ' . $settings['slick_class_name'];; ?> ">
					<?php } else { ?>
					<ul class="news-list <?php echo $settings['news_list_class']; ?>">
					<?php } ?>
						<?php foreach( $selected_posts as $idx => $selected_post ) { 
							$imported_image = get_post_meta( $selected_post->ID, 'news_image', true );

							$selFeaturedImage = get_the_post_thumbnail_url($selected_post->ID, 'large');
							$selFeaturedImage = str_replace("http://goulddev.usc.edu", "", $selFeaturedImage);
							$imported_image = get_post_meta( $selected_post->ID, 'news_image', true );
							$new_image = ! empty($selFeaturedImage) ? $selFeaturedImage : ( ! empty($imported_image) ? $imported_image : '/wp-content/uploads/2023/04/faculty-placeholder.png');
							//$new_image = !empty($imported_image) ? $imported_image : 'https://gould.usc.edu/portal/news/images/news/placeholder.gif';
							$new_image_alt = get_post_thumbnail_id($selected_post->ID) ? get_post_meta(get_post_thumbnail_id($selected_post->ID), '_wp_attachment_image_alt', TRUE) : '';
							$this_post_categories = get_the_category($selected_post->ID);
							$selected_post_categories = [];
							if( $settings['shwo_selected_post_categories'] === 'yes' ) {
								foreach( $this_post_categories as $this_post_category ) {
									//var_dump($this_post_category->term_id);
									if(in_array($this_post_category->term_id, $settings['post_categories'])) {
										array_push($selected_post_categories, $this_post_category);
									}
								}
							}
							//var_dump($selected_post_categories);
						?>
						<?php if ( $settings['use_slick'] === 'yes' ) { ?>
						<div class="news-item <?php echo $settings['news_item_class']; ?>">
						<?php } else { ?>
						<li class="news-item <?php echo $settings['news_item_class']; ?> <?php echo 'academic-year-' . $selected_post->post_academic_year; ?>  <?php if($settings['show_academic_year'] === 'yes' && $defaultAY !== $selected_post->post_academic_year) { echo ' hide '; } ?>">
						<?php } ?>
							<div class="news-item-wrapper <?php echo $settings['news_item_wrapper_class']; ?>" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php } ?>>
								<a href="<?php echo get_permalink( $selected_post->ID ); ?>" class="full-size-link" tabindex="0" aria-label="Click to read more about <?php echo $selected_post->post_title ?>"><span class="hide"><?php echo $selected_post->post_title ?></span></a>
								<div class="news-image <?php echo $settings['news_item_image_wrapper_class']; ?>">
									<a href="<?php echo get_permalink( $selected_post->ID ); ?>" class=" " aria-label="Click to read more about <?php echo $selected_post->post_title ?>"><img src="<?php echo $new_image; ?>" class="<?php echo $settings['news_item_image_class']; ?>" alt="<?php echo $new_image_alt; ?>" /></a>
								</div>
								<div class="news-details <?php echo $settings['news_item_details_class']; ?>">
									<div class="news-title">									
									<?php echo $selected_post->post_title ?>
									</div>
									<div class="news-brief <?php echo $settings['news_item_brief_class']; ?>">
										<?php echo get_post_meta( $selected_post->ID, 'news_brief_description', true ); ?>
									</div>
									<div class="news-date <?php echo $settings['news_item_date_class']; ?>">
										<?php echo date_format(date_create($selected_post->post_date), "F j, Y"); ?>
									</div>
									<div class="news-more <?php echo $settings['news_item_more_class']; ?>">
										<a href="<?php echo get_permalink( $selected_post->ID ); ?>" class=" <?php echo $settings['news_item_read_more_class']; ?>" aria-label="Click to read more about <?php echo $selected_post->post_title ?>">
											Read more
											<?php if ( $settings['show_arrow_on_read_more'] === 'yes' ) { ?>
											<?php echo $this->icon_right_arrow(); ?>
											<?php } ?>
										</a>
									</div>
									<?php
				//var_dump($selected_post_categories);
										if( count($selected_post_categories) ) {
									?>
									<div class="news-categories-wrapper">
										<?php
											foreach( $selected_post_categories as $selected_post_category ) {
												$post_category_permalink = get_category_link($selected_post_category->term_id);
												//var_dump($post_category_permalink);
										?>
										<a href="<?php echo $post_category_permalink; ?>" class="news-category-link"><?php echo $selected_post_category->cat_name ; ?></a>
										<?php
											}
										?>
									</div>
									<?php
										}
									?>
								</div>
								<?php if ( $settings['show_button_below_post'] === 'yes' ) { ?>
								<div class="button-below-post-wrapper <?php echo $settings['news_button_below_post_class']; ?>">
									<a href="<?php echo $settings['button_below_post_link']; ?>" class="<?php echo $settings['button_below_post_class']; ?>" target="<?php echo $settings['button_below_post_target']; ?>"><?php echo $settings['button_below_post_text']; ?></a>
								</div>
								<?php } ?>
							</div>
						<?php if ( $settings['use_slick'] === 'yes' ) { ?>
						</div>
						<?php } else { ?>
						</li>
						<?php } ?>
						<?php } ?>
					<?php if ( $settings['use_slick'] === 'yes' ) { ?>
					</div>
					<?php } else { ?>
					</ul>
					<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>	
		</div>

		<script language="javascript">
			jQuery('select.academic-year-dropdown').on('change', function(e) {
				var selYear = jQuery(this).val();
				jQuery('.news-feed-title .title span').html(jQuery('select.academic-year-dropdown option:selected').text());
				jQuery('ul.news-list li.news-item').addClass('hide');
				jQuery('ul.news-list li.news-item.academic-year-'+selYear).removeClass('hide');
				//console.log('selYear', selYear);
			});
			<?php if ( $settings['use_slick'] === 'yes' && ! empty ( $settings['slick_class_name'] ) ) { ?>
			jQuery('.<?php echo $settings['slick_class_name']; ?>').slick({
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
			});
			<?php } ?>
		</script>

		<?php
	}
}
