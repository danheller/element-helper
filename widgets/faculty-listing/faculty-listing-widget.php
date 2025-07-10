<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Faculty_Listing extends Element_El_Widget {

	public function get_all_professors() {
		$faculties = get_posts([
			'post_type' => ['professors','lecturers'],
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
		$all_faculties = [];
		foreach($faculties as $faculty) {
			$all_faculties[$faculty->ID] = $faculty->post_title;
		}
		return $all_faculties;
	}
	
	function group_alpha_professors($professors) {
		$alpha_professors = [ ];
		for ( $idx = 0; $idx < count($professors); $idx++ ) {
			$this->get_more_professor_info($professors[$idx]);
			//var_dump($professors[$idx]->professor_inactive); echo '<br /><br />';
			if($professors[$idx]->professor_inactive !== true) {
				$firstLetter = strtoupper(substr($professors[$idx]->post_title, 0, 1));
				if(!isset($alpha_professors[$firstLetter])) {
					$alpha_professors[$firstLetter] = array();
				}
				array_push($alpha_professors[$firstLetter], $professors[$idx]);
			}
		}
		return $alpha_professors;
	}
	
	function get_more_professor_info($professor) {
		$professor->professor_first_name = get_field('professor_first_name', $professor->ID);
		$professor->professor_middle_name = get_field('professor_middle_name', $professor->ID);
		$professor->professor_last_name = get_field('professor_last_name', $professor->ID);
		//$professor->professor_page_link = get_field('professor_page_link', $professor->ID);
		$professor->professor_page_link = get_permalink( $professor->ID );
		//var_dump($professor->ID, $professor->professor_page_link, get_permalink(1659)); echo '<br />';
		$professor->professor_title = get_field('professor_title', $professor->ID);
		$professor->professor_type = get_field('professor_type', $professor->ID);
		/*$professor->professor_division = get_field('professor_division', $professor->ID);
		$professor->professor_email = get_field('professor_email', $professor->ID);
		$professor->professor_phone = get_field('professor_phone', $professor->ID);
		$professor->professor_fax = get_field('professor_fax', $professor->ID);
		$professor->professor_room = get_field('professor_room', $professor->ID);
		$professor->professor_personal_website = get_field('professor_personal_website', $professor->ID);
		$professor->professor_google_scholar_profile = get_field('professor_google_scholar_profile', $professor->ID);
		$professor->professor_ssrn_author_page = get_field('professor_ssrn_author_page', $professor->ID);
		$professor->professor_download_curriculum_vitae = get_field('professor_download_curriculum_vitae', $professor->ID);*/
		$professor->professor_image = get_field('professor_image', $professor->ID);
		$professorFeaturedImage = get_the_post_thumbnail_url($professor->ID);
		$professor->professor_image = ! empty($professorFeaturedImage) ? $professorFeaturedImage : (! empty($professor->professor_image) ? $professor->professor_image : '/wp-content/uploads/2023/01/Shield_RegUse_Card_RGB-e1689801525916.jpg');
		$professor->professor_image_alt = get_post_thumbnail_id($professor->ID) ? get_post_meta(get_post_thumbnail_id($professor->ID), '_wp_attachment_image_alt', TRUE) : '';
		/*$professor->professor_last_updated = get_field('professor_last_updated', $professor->ID);
		$professor->professor_publications = get_field('professor_publications', $professor->ID);*/
		$professor->professor_biography = strip_tags(get_field('professor_biography', $professor->ID));
		$professor->professor_inactive = get_field('professor_inactive', $professor->ID);
		$professor->professor_categories = wp_get_post_categories( $professor->ID );
		return $professor;
	}
	
	public function get_professor_info($professor) {
		$professor_data = NULL;
		//var_dump($professor);
		if(count($professor) && !empty($professor[0])) {
			$args = array(
				'post_type'   => 'professors',
				'p' => intval($professor[0]),
			);
			$tmp = get_posts($args);
			//var_dump($tmp); echo '<br /><br />';
			$professor_data = count($tmp) ? $tmp[0] : NULL;
			$this->get_more_professor_info($professor_data);
		}
		return $professor_data;
	}
	
	function get_more_course_info($course) {
		$course->course_name = get_field('course_name', $course->ID);
		$course->course_number = get_field('course_number', $course->ID);
		$course->course_link = get_field('course_link', $course->ID);
		$course->course_description = get_field('course_description', $course->ID);
		$course->course_units = get_field('course_units', $course->ID);
		$course->course_grading_options = get_field('course_grading_options', $course->ID);
		$course->course_exam_type = get_field('course_exam_type', $course->ID);
		$course->writing_requirement = get_field('writing_requirement', $course->ID);
		$course->skillsexperiential_requirement = get_field('skillsexperiential_requirement', $course->ID);
		$course->enrollment_limit = get_field('enrollment_limit', $course->ID);
		$course->note_below = get_field('note_below', $course->ID);
		$course->professor_1_info = $this->get_professor_info(get_post_meta($course->ID, 'professor_1'));
		$course->professor_2_info = $this->get_professor_info(get_post_meta($course->ID, 'professor_2'));
		$course->professor_3_info = $this->get_professor_info(get_post_meta($course->ID, 'professor_3'));
		return $course;
	}

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
		return 'faculty-listing';
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
		return __( 'Faculty Listing', 'elementhelper' );
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
	
	protected function get_all_categories() {
		$categories = get_categories();
		//var_dump($categories);
		$all_categories = [];
		foreach ( $categories as $idx => $category ) {
			$all_categories[$category->term_id] = $category->cat_name;
		}
		return $all_categories;
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
			'show_header',
			[
				'label'        => __( 'Show Header', 'elementhelper' ),
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
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Sub-Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'note',
			[
				'label'       => __( 'Note', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
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
			'show_filter',
			[
				'label'        => __( 'Show Filter', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'show_spotlight',
			[
				'label'        => __( 'Show Spotlight', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'spotlight_faculty',
			[
				'label'       => __( 'Select faculty in spotlight', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'            => $this->get_all_professors(),
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);
		
		$this->add_control(
			'show_faculty_only',
			[
				'label'        => __( 'Show Faculty Only', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		
		$this->add_control(
			'show_selected_faculty_by_categories',
			[
				'label'        => __( 'Show Selected Faculty by Categories', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'faculty_categories',
			[
				'label'        => __( 'Select Faculty Categories', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_categories(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'show_selected_faculty',
			[
				'label'        => __( 'Show Selected Faculty', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'selected_faculty',
			[
				'label'        => __( 'Select Faculties', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_professors(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'show_show_more',
			[
				'label'        => __( 'Show Show More Button', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'initial_show_item',
			[
				'label'       => __( 'Initial Show Number', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'	=> 6,
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
	
	protected function icon_filter() {
		return '<svg width="30" height="22" viewBox="0 0 30 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_360_21024)"><path d="M0.760223 4.51736H19.9442C20.3547 4.51736 20.707 4.16535 20.707 3.75453C20.707 3.3437 20.355 2.9917 19.9442 2.9917H0.760223C0.349709 2.9917 -0.00260544 3.3437 -0.00260544 3.75453C-0.00260544 4.16535 0.349396 4.51736 0.760223 4.51736Z" /><path d="M25.9328 4.51736H28.9247C29.3352 4.51736 29.6875 4.16535 29.6875 3.75453C29.6875 3.3437 29.3355 2.9917 28.9247 2.9917H25.9328C25.5223 2.9917 25.17 3.3437 25.17 3.75453C25.17 4.16535 25.4635 4.51736 25.9328 4.51736Z" /><path d="M0.762115 11.7332H5.80748C6.218 11.7332 6.57031 11.3812 6.57031 10.9703C6.57031 10.5595 6.21831 10.2075 5.80748 10.2075H0.762115C0.351602 10.2075 -0.000714302 10.5595 -0.000714302 10.9703C-0.000714302 11.3812 0.351288 11.7332 0.762115 11.7332Z" /><path d="M11.7939 11.7332H28.9247C29.3352 11.7332 29.6875 11.3812 29.6875 10.9703C29.6875 10.5595 29.3355 10.2075 28.9247 10.2075H11.7939C11.3834 10.2075 11.0311 10.5595 11.0311 10.9703C11.0311 11.3812 11.3831 11.7332 11.7939 11.7332Z" /><path d="M0.760223 19.0081H19.9442C20.3547 19.0081 20.707 18.6561 20.707 18.2453C20.707 17.8344 20.355 17.4824 19.9442 17.4824H0.760223C0.349709 17.4824 -0.00260544 17.8344 -0.00260544 18.2453C-0.00260544 18.6561 0.349396 19.0081 0.760223 19.0081Z" /><path d="M25.9328 19.008H28.9247C29.3352 19.008 29.6875 18.656 29.6875 18.2452C29.6875 17.7758 29.3355 17.4238 28.9247 17.4238H25.9328C25.5223 17.4238 25.17 17.7758 25.17 18.1867C25.1112 18.656 25.4635 19.008 25.9328 19.008Z" /><path d="M22.9367 7.50939C24.9899 7.50939 26.6914 5.80789 26.6914 3.75469C26.6914 1.7015 24.9899 0 22.9367 0C20.8835 0 19.182 1.7015 19.182 3.75469C19.182 5.80789 20.8247 7.50939 22.9367 7.50939ZM22.9367 1.52534C24.1689 1.52534 25.1661 2.52284 25.1661 3.75469C25.1661 4.98655 24.1686 5.98404 22.9367 5.98404C21.7049 5.98404 20.7074 4.98655 20.7074 3.75469C20.7074 2.52284 21.7049 1.52534 22.9367 1.52534Z" /><path d="M8.79999 14.7257C10.8532 14.7257 12.5547 13.0242 12.5547 10.971C12.5547 8.91781 10.8532 7.21631 8.79999 7.21631C6.7468 7.21631 5.0453 8.91781 5.0453 10.971C5.0453 13.0242 6.68798 14.7257 8.79999 14.7257ZM8.79999 8.74165C10.0322 8.74165 11.0293 9.73915 11.0293 10.971C11.0293 12.2029 10.0318 13.2004 8.79999 13.2004C7.56814 13.2004 6.57064 12.2029 6.57064 10.971C6.57064 9.73915 7.56814 8.74165 8.79999 8.74165Z" /><path d="M22.9367 22.0001C24.9899 22.0001 26.6914 20.2986 26.6914 18.2454C26.6914 16.1922 24.9899 14.4907 22.9367 14.4907C20.8835 14.4907 19.182 16.1922 19.182 18.2454C19.1232 20.2986 20.8247 22.0001 22.9367 22.0001ZM22.9367 16.0161C24.1689 16.0161 25.1661 17.0136 25.1661 18.2454C25.1661 19.4773 24.1686 20.4748 22.9367 20.4748C21.7049 20.4748 20.7074 19.4773 20.7074 18.2454C20.7074 17.0136 21.7049 16.0161 22.9367 16.0161Z" /></g><defs><clipPath id="clip0_360_21024"><rect width="29.6859" height="22" transform="matrix(-1 0 0 1 29.6875 0)"/></clipPath></defs></svg>';
	}
	
	protected function icon_right_arrow() {
		return '<svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0807 11.5855L13.581 12.0816L19.3712 6.34061L13.581 0.59961L13.0807 1.09575L18.013 5.98622L1 5.98622L1 6.69499L18.013 6.69499L13.0807 11.5855Z" fill="#990000" stroke="#990000" stroke-width="0.5"/></svg>';
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$image    = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';
		$faculty_post_type = ['professors'];
		if( !$settings['show_faculty_only'] ) {
			$faculty_post_type[] = 'lecturers';
		}
		//var_dump($faculty_post_type);
		$args = array(
			'post_type'   => $faculty_post_type,
			'p' => intval($settings['spotlight_faculty']),
		);
		$spotlight = get_posts($args);
		$selected_spotlight = count($spotlight) ? $spotlight[0] : [];
		$this->get_more_professor_info($selected_spotlight);
		$args = array(
			'post_type' => $faculty_post_type,
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
			'orderby' => 'title',
		);
		$all_professors = get_posts($args);
		$alpha_professors = $this->group_alpha_professors($all_professors);
		
		
		$args = array(
			'post_type' => $faculty_post_type,
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
			'meta_query'    => array(
				array(
					'key'       => 'professor_inactive',
					'value'     => true,
					'compare'   => '!=',
				),
			),
		);
		if( ! empty ( $settings['faculty_categories'] ) ) {
			$args['category__and'] = $settings['faculty_categories'];
		} else if( ! empty ( $settings['selected_faculty']) ) {
			$args['include'] = $settings['selected_faculty'];
		}
		//var_dump($args);
		$selected_professors = get_posts($args);
		//var_dump($selected_professors);
		foreach( $selected_professors as $each_faculty) {
			$this->get_more_professor_info($each_faculty);
		}
		
		$category = array();
		$category['centers'] = 90;
		$category['clinics'] = 56;
		$category['topics'] = 22;
		$centerCategories = get_categories(
			array( 'parent' => $category['centers'] )
		);
		$clinicCategories = get_categories(
			array( 'parent' => $category['clinics'] )
		);
		$topicCategories = get_categories(
			array( 'parent' => $category['topics'] )
		);
		
		//var_dump($alpha_professors);
		
		?>

		<div class="faculty-listing-wrapper <?php echo $settings['module_class']; ?>">
			<?php if($settings['show_header'] === 'yes' ) { ?>
			<div class="faculty-listing-header-wrapper">
				<div class="container">
					<?php if ( ! empty( $settings['title'] ) ): ?>
					<div class="faculty-listing-title">
						<?php echo '<' . $settings['title_tag'] . ' class="title">'; ?>
						<span><?php echo $settings['title'] ?></span>
						<?php echo '</' . $settings['title_tag'] . '>'; ?>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['subtitle'] ) ): ?>
					<div class="faculty-listing-subtitle">
						<span><?php echo $settings['subtitle'] ?></span>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php } ?>
			<?php if($settings['show_filter'] === 'yes' ) { ?>
			<div class="faculty-listing-filter-wrapper">
				<div class="container">
					<div class="row">
						<div class="col-xl-8 col-sm-7 mb-xs-15">
							<div class="faculty-listing-filter">
								<div class="faculty-filter-drawer type">
									<label data-id="type" for="faculty-type">Type
									<div class="faculty-fd type">
										<ul class="faculty-fd-type-list">
											<li class="faculty-fd-type-item">
												<input type="radio" name="faculty-type" value="Faculty" checked="checked" aria-label="Select facutly"> Faculty
											</li>
											<li class="faculty-fd-type-item">
												<input type="radio" name="faculty-type" value="Lecturer in Law" aria-label="Select lecturer"> Lecturer in Law
											</li>
										</ul>
									</div>
										</label>
								</div>
								<div class="faculty-filter-drawer topics">
									<label for="faculty-filter-topics">
										Topics
										<select name="faculty-filter-topics" aria-label="Select topic">
											<option value="">Show All</option>
											<?php foreach ( $topicCategories as $eachItem ) { ?>
											<option value="cat-<?php echo $eachItem->term_id; ?>"><?php echo $eachItem->name; ?></option>
											<?php } ?>
										</select>
									</label>
								</div>
							</div>
						</div>
						<div class="col-sm-5 col-xl-4 mb-xs-15">
							<div class="faculty-listing-search">
								<label for="search-faculty-name">Search
								<input type="text" name="search-faculty-name" id="search-faculty-name" placeholder="Search by Name or Keyword" />
									</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<?php if($settings['show_spotlight'] === 'yes' && ! empty ($selected_spotlight) ) { ?>
			<div class="faculty-spotlight-description-wrapper">
				<div class="background-orange-color"></div>
				<div class="faculty-spotlight-description row">
					<div class="col-sm-6 faculty-spotlight-wrapper">
						<div class="faculty-spotlight">
							<div class="faculty-listing-img">
								<img src="http://goulddev.usc.edu/wp-content/uploads/2023/01/thumb-33.png" />
							</div>
							<div class="spotlight-content">
								<div class="faculty-spotlight-name">
									<?php echo $selected_spotlight->professor_first_name . ' ' . $selected_spotlight->professor_middle_name. ' ' . $selected_spotlight->professor_last_name; ?>
								</div>
								<div class="faculty-spotlight-title">
									<?php echo $selected_spotlight->professor_title; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 faculty-listing-sub-wrapper">
						<div class="faculty-listing-subtitle-note">
							<div class="faculty-listing-subtitle">
								<?php echo $settings['subtitle']; ?>
							</div>
							<div class="faculty-listing-note">
								<?php echo $settings['note']; ?>
							</div>
						</div>
						<div class="faculty-listing-description">
							<?php echo $settings['description']; ?>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			
			<?php 
				if( ($settings['show_selected_faculty'] === 'yes' && ! empty ($settings['selected_faculty'])) || $settings['show_selected_faculty_by_categories'] === 'yes' ) {
				$startHidingIndex = $settings['show_show_more'] === 'yes' && $settings['initial_show_item'] ? $settings['initial_show_item'] : count($selected_professors);
			?>
			<div class="selected-faculty-list-wrapper">
				<div class="selected-faculty-list-inner">
					<ul class="row">
						<?php foreach ( $selected_professors as $idx => $each_faculty ) { ?>
						<li class="col-sm-4 col-xs-12 <?php echo $startHidingIndex > $idx ? '' : 'hide'; ?>">
							<div class="each-faculty-wrapper">
								<div class="faculty-image">
									<a href="<?php echo $each_faculty->professor_page_link; ?>" aria-label="Click to go to <?php echo $each_faculty->professor_first_name . ' ' . $each_faculty->professor_last_name; ?> page"><img src="<?php echo $each_faculty->professor_image; ?>" alt="<?php echo $each_faculty->professor_image_alt; ?>" /></a>
								</div>
								<div class="faculty-details">
									<div class="faculty-name">
										<a href="<?php echo $each_faculty->professor_page_link; ?>"><?php echo $each_faculty->professor_first_name . ' ' . $each_faculty->professor_last_name; ?></a>
									</div>
									<div class="faculty-title">
										<?php echo $each_faculty->professor_title; ?>
									</div>
									<div class="faculty-profile-link">
										<a href="<?php echo $each_faculty->professor_page_link; ?>" class="faculty-profile-view" aria-label="Click to view <?php echo $each_faculty->professor_first_name . ' ' . $each_faculty->professor_last_name; ?> profile">View Profile <?php echo $this->icon_right_arrow(); ?></a>
									</div>
								</div>
							</div>
						</li>
						<?php } ?>
					</ul>
				</div>
				<?php if( $settings['show_show_more'] === 'yes' && count($selected_professors) > $settings['initial_show_item'] ) { ?>
				<div class="selected-faculty-show-more">
					<a href='#"' class="show-more-selected-faculty">Show More</a>
				</div>
				<?php } ?>
			</div>
			
			<?php } else { ?>
			
			<div class="faculty-list-wrapper">
				<div class="container">
					<div class="faculty-listing-description">
						<?php echo $settings['description']; ?>
					</div>
					<div class="faculty-fd letter">
						<ul class="list-inline alpha-filter">
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="A">A</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="B">B</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="C">C</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="D">D</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="E">E</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="F">F</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="G">G</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="H">H</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="I">I</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="J">J</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="K">K</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="L">L</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="M">M</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="N">N</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="O">O</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="P">P</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="Q">Q</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="R">R</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="S">S</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="T">T</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="U">U</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="V">V</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="W">W</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="X">X</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="Y">Y</a></li>
							<li class="list-inline-item"><a href="#" class="filter-by-alpha-action" data-id="Z">Z</a></li>
						</ul>
					</div>
					<div class="faculty-list-outer"></div>
				</div>
			</div>
			
			<?php } ?>
		</div>

<script language="javascript">
(function ($) {

	var alphaProfessors = [];
	var alphaProfResult = [];
	var faculty_options = [];
	var selectedAlphaFilter = [];
	var searchKeywordVal = '';
	
	function closeFdDrawer() {
		$('.faculty-filter-drawer-wrapper').removeClass('open');
		$('body').removeClass('overflow-hidden');
	}
	
	function renderFacultyIndy(eachProf) {
		//console.log('eachProf', eachProf);
		var facultyHtml = '';
		facultyHtml += '<div class="col-xl-4 col-lg-4 col-md-6 mb-25">';
		facultyHtml += '<div class="faculty-profile-content-wrap">';
		facultyHtml += '<div class="faculty-profile-thumb">';
		facultyHtml += '<a href="'+eachProf.link+'" aria-label="Click to view '+eachProf.name+' profile"><img decoding="async" src="'+eachProf.thumb+'" alt="'+eachProf.thumb_alt+'"></a>';
		facultyHtml += '</div>';
		facultyHtml += '<div class="faculty-profile-content">';
		facultyHtml += '<div class="faculty-profile-info">';
		facultyHtml += '<div class="faculty-profile-name"><a href="'+eachProf.link+'" aria-label="Click to view '+eachProf.name+' profile">'+eachProf.name+'</a></div>';
		facultyHtml += '<p>'+eachProf.title+'</p>';
		facultyHtml += '</div>';
		facultyHtml += '<a href="'+eachProf.link+'" class="faculty-profile-view" aria-label="Click to view '+eachProf.name+' profile">View Profile <img decoding="async" src="/wp-content/uploads/2023/03/icon-right-arrow.png" alt=""></a>';
		facultyHtml += '</div>';
		facultyHtml += '</div>';
		facultyHtml += '</div>';
		return facultyHtml;
	}
	
	function renderFacultyAlpha(alphaProf, alpha) {
		var facultyHtml = '';
		//console.log('alphaProf', alpha, alphaProf);
		facultyHtml += '<div class="faculty-list-inner">';
		facultyHtml += '<div class="row pb-25">';
		facultyHtml += '<div class="col-xl-12">';
		facultyHtml += '<div class="faculty-letter-wrap" id="letter'+alpha+'">';
		facultyHtml += '<h2>'+alpha+'</h2>';
		facultyHtml += '</div>';
		facultyHtml += '</div>';
		facultyHtml += '</div>';
		facultyHtml += '<div class="row">';
		for ( var i = 0; i < alphaProf.length; i++ ) {
			facultyHtml += renderFacultyIndy(alphaProf[i]);
		}
		facultyHtml += '</div>';
		facultyHtml += '</div>';
		return facultyHtml;
	}
	
	function renderFacultyListing() {
		var facultyHtml = '';
		/*var alphaKeys = Object.keys(alphaProfessors).sort();
		for( var i = 0; i < alphaKeys.length; i++ ) {
			facultyHtml += renderFacultyAlpha(alphaProfessors[alphaKeys[i]], alphaKeys[i]);
		}*/
		var alphaKeys = Object.keys(alphaProfResult).sort();
		for( var i = 0; i < alphaKeys.length; i++ ) {
			if(alphaProfResult[alphaKeys[i]].length) {
				facultyHtml += renderFacultyAlpha(alphaProfResult[alphaKeys[i]], alphaKeys[i]);
			}
		}
		$('.faculty-list-outer').html(facultyHtml);
	}
	
	function updateAlphaFilter() {
		$('.filter-by-alpha-action').addClass('disabled');
		$('.filter-by-alpha-action').attr('aria-label', 'Remove');
		var alphaKeys = Object.keys(alphaProfessors).sort();
		//console.log('alphaKeys', alphaKeys);
		for( var i = 0; i < alphaKeys.length; i++ ) {
			$('.filter-by-alpha-action[data-id='+alphaKeys[i]+']').removeClass('disabled');
			$('.filter-by-alpha-action[data-id='+alphaKeys[i]+']').attr('aria-label', '');
			//facultyHtml += renderFacultyAlpha(alphaProfessors[alphaKeys[i]], alphaKeys[i]);
		}
	}
	
	function getCheckedCheckboxes(checkboxes) {
		var checkedVal = [];
		for (var i = 0; i < checkboxes.length; i++) {
			if(checkboxes[i].checked) {
				checkedVal.push(checkboxes[i].value);
			}
		}
		return checkedVal;
	}
	
	function profDataByFilters(data) {
		//console.log('profDataByFilters',{faculty_options,data});
		var result = [];
		for( var i = 0; i < data.length; i++ ) {
			var found = false;
			var foundType = false;
			var foundClinic = false;
			var foundCenter = false;
			var foundTopic = false;
			//console.log('data[i]', data[i]);
			if( faculty_options['type'].length && faculty_options['type'].includes(data[i].type) ) {
				foundType = true;
			}
			if( faculty_options['clinic'].length || faculty_options['center'].length || faculty_options['topic'].length ) {
				if( faculty_options['clinic'].length ) {
					for( var j = 0; j < faculty_options['clinic'].length; j++ ) {
						foundClinic = data[i].categories.includes(faculty_options['clinic'][j]) || foundClinic;
					}
				} else {
					//foundClinic = true;
				}
				if( faculty_options['center'].length ) {
					for( var j = 0; j < faculty_options['center'].length; j++ ) {
						foundCenter = data[i].categories.includes(faculty_options['center'][j]) || foundCenter;
					}
				} else {
					//foundCenter = true;
				}
				if( faculty_options['topic'].length ) {
					for( var j = 0; j < faculty_options['topic'].length; j++ ) {
						foundTopic = data[i].categories.includes(faculty_options['topic'][j]) || foundTopic;
					}
				} else {
					//foundTopic = true;
				}
			} else {
				foundClinic = foundCenter = foundTopic = true;
				
			}
			if( foundType && ( foundClinic || foundCenter || foundTopic ) ) {
				result.push(data[i]);
			}
		}
		//console.log('result', result);
		return result;
	}
	
	function fuzzySearch(items, query) {
		// Split up the query by space
		var search = query.split(' ');
		var found = [];
		items.forEach(i => {
			// Extra step here to count each search query item (after splitting by space)
			var matches = 0;
			search.forEach(s => {
				var props = 0;
				for (var prop in i) {
					// Check if property value contains search
					if (typeof i[prop] === 'string' && i[prop].toLowerCase().indexOf(s) > -1) {
						props++;
					}
				}
				if (props >= 1) {
					// Found a matching prop, increase our match count
					matches++;
				}
			})
			if (matches == search.length) {
				// if all search paramters were found
				found.push(i);
			}
		})
		return found;
	}
	
	function updateProfDataByFilters() {
		alphaProfResult = [];
		var alphaKeys = Object.keys(alphaProfessors).sort();
		faculty_options = [];
		faculty_options['type'] = getCheckedCheckboxes(document.getElementsByName('faculty-type'));
		faculty_options['clinic'] = getCheckedCheckboxes(document.getElementsByName('faculty-clinics'));
		faculty_options['center'] = getCheckedCheckboxes(document.getElementsByName('faculty-centers'));
		//faculty_options['topic'] = getCheckedCheckboxes(document.getElementsByName('faculty-topics'));
		faculty_options['topic'] = $('select[name=faculty-filter-topics]').val().length ? [$('select[name=faculty-filter-topics]').val()] : [];
		//console.log('faculty_options', faculty_options);
		for( var i = 0; i < alphaKeys.length; i++ ) {
			if(!selectedAlphaFilter.length || selectedAlphaFilter.includes(alphaKeys[i])) {
				alphaProfResult[alphaKeys[i]] = alphaProfessors[alphaKeys[i]];
			}
			if(searchKeywordVal.length) {
				alphaProfResult[alphaKeys[i]] = fuzzySearch(alphaProfResult[alphaKeys[i]], searchKeywordVal);
				//console.log('keyword', searchKeywordVal, foundData);
			}

			if( alphaProfResult[alphaKeys[i]] !== undefined ) {
				alphaProfResult[alphaKeys[i]] = profDataByFilters( alphaProfResult[alphaKeys[i]] );
			}
		}
	}
	
    $(document).ready(function () {
		$('.faculty-drawer-action').on('click', function(e) {
			e.preventDefault();
			$('.faculty-filter-drawer-wrapper').addClass('open');
			$('body').addClass('overflow-hidden');
		});
		$('.close-faculty-drawer').on('click', function(e) {
			e.preventDefault();
			closeFdDrawer();
		});
		$('.show-more-selected-faculty').on('click', function(e) {
			e.preventDefault();
			$('.selected-faculty-list-wrapper ul li').removeClass('hide');
			$('.selected-faculty-show-more').addClass('hide');
		});
		$('.faculty-filter-drawer > label').on('click', function(e) {
			var filterType = $(this).attr('data-id');
			var isOpen = $('.faculty-filter-drawer.'+filterType).hasClass('open');
			if(isOpen) {
				$('.faculty-filter-drawer.'+filterType).removeClass('open');
			} else {
				$('.faculty-filter-drawer.'+filterType).addClass('open');
			}
		});
		$('.faculty-filter-apply a.apply-btn').on('click', function(e) {
			e.preventDefault();
			closeFdDrawer();
		});
		
		var thisCat = '';
		
		<?php foreach (range('A', 'Z') as $letter) { ?>
			<?php if(isset($alpha_professors[$letter]) && count($alpha_professors[$letter])) { ?>
			alphaProfessors['<?php echo $letter; ?>'] = [];
				<?php for( $ix = 0; $ix < count($alpha_professors[$letter]); $ix++ ) { ?>
				thisCat = [];
				<?php foreach( $alpha_professors[$letter][$ix]->professor_categories as $each_cat ) { ?>
				thisCat.push('cat-<?php echo $each_cat; ?>');
				<?php } ?>
				alphaProfessors['<?php echo $letter; ?>'].push( {
					thumb: '<?php echo ( !empty($alpha_professors[$letter][$ix]->professor_image) ? $alpha_professors[$letter][$ix]->professor_image : '/wp-content/uploads/2023/01/Shield_RegUse_Card_RGB-e1689801525916.jpg'); ?>',
					thumb_alt: '<?php echo $alpha_professors[$letter][$ix]->professor_image_alt; ?>',
					name: '<?php echo addslashes($alpha_professors[$letter][$ix]->professor_first_name) . ' ' . addslashes($alpha_professors[$letter][$ix]->professor_last_name); ?>',
					title: '<?php echo $alpha_professors[$letter][$ix]->professor_title; ?>',
					link: '<?php echo $alpha_professors[$letter][$ix]->professor_page_link; ?>',
					type: '<?php echo $alpha_professors[$letter][$ix]->professor_type; ?>',
					categories: thisCat,
					letter: '<?php echo $letter; ?>',
					biography: '<?php echo str_replace(array("\r", "\n"), '', addslashes($alpha_professors[$letter][$ix]->professor_biography)); ?>',
				} );
				<?php } ?>
			<?php } ?>
		<?php } ?>
		
		<?php if($settings['show_filter'] === 'yes' ) { ?>
		updateAlphaFilter();
		updateProfDataByFilters();
		renderFacultyListing();
		//console.log('alphaProfessors',alphaProfessors);
		<?php } ?>
		
		$('.filter-by-alpha-action').on('click', function(e) {
			e.preventDefault();
			var isDisabled = $(this).hasClass('disabled');
			var isSelected = $(this).hasClass('selected');
			var letter = $(this).attr('data-id');
			if(!isDisabled) {
				if(isSelected) {
					$(this).removeClass('selected');
					if(selectedAlphaFilter.includes(letter)) {
						var letterIndex = selectedAlphaFilter.indexOf(letter);
						selectedAlphaFilter.splice(letterIndex, 1);
					}
				} else {
					$(this).addClass('selected');
					if(!selectedAlphaFilter.includes(letter)) {
						selectedAlphaFilter.push(letter);
					}
				}
				updateProfDataByFilters();
				renderFacultyListing();
			}			
		});
		
		var ftopics = $("input[type=checkbox][name=faculty-topics]");
		ftopics.change(function() {
			faculty_options['topic'] = ftopics
				.filter(":checked") // Filter out unchecked boxes.
				.map(function() { // Extract values using jQuery map.
				  return this.value;
				}) 
				.get();
				updateProfDataByFilters();
				renderFacultyListing();
		});
		var fcenters = $("input[type=checkbox][name=faculty-centers]");
		fcenters.change(function() {
			faculty_options['center'] = fcenters
				.filter(":checked") // Filter out unchecked boxes.
				.map(function() { // Extract values using jQuery map.
				  return this.value;
				}) 
				.get();
				updateProfDataByFilters();
				renderFacultyListing();
		});
		var fclinics = $("input[type=checkbox][name=faculty-clinics]");
		fclinics.change(function() {
			faculty_options['clinic'] = fclinics
				.filter(":checked") // Filter out unchecked boxes.
				.map(function() { // Extract values using jQuery map.
				  return this.value;
				}) 
				.get();
				updateProfDataByFilters();
				renderFacultyListing();
		});
		var ftypes = $("input[type=radio][name=faculty-type]");
		ftypes.change(function() {
			faculty_options['clinic'] = ftypes
				.filter(":checked") // Filter out unchecked boxes.
				.map(function() { // Extract values using jQuery map.
				  return this.value;
				}) 
				.get();
			if(faculty_options['clinic'].includes('Lecturer in Law')) {
				$('select[name=faculty-filter-topics]').val('')
				$('.faculty-filter-drawer.topics').addClass('hide');
			} else {
				$('.faculty-filter-drawer.topics').removeClass('hide');
			}
				updateProfDataByFilters();
				renderFacultyListing();
		});
		var stopics = $('select[name=faculty-filter-topics]');
		stopics.change(function() {
			//console.log('changed', $(this).val());
			updateProfDataByFilters();
			renderFacultyListing();
		})
				
		$(window).click(function() {
			if( $('.faculty-filter-drawer-wrapper.open').length ) {
				//console.log('clicked', $(this));
				//console.log($(this).hasClass('faculty-filter-drawer-inner'));
			}
		});
		
		const debounce = (func, wait) => {
			let timeout;

			return function executedFunction(...args) {
				const later = () => {
					clearTimeout(timeout);
					func(...args);
				};

				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
			};
		};
		
		function fetchResults() {
			searchKeywordVal = document.getElementById("search-faculty-name").value.toLowerCase();
			updateProfDataByFilters();
			renderFacultyListing();
		}
		const WAIT_TIME = 500;
		const processChange = debounce(() => fetchResults(), WAIT_TIME);
		if(document.getElementById("search-faculty-name") !== null) {
			document.getElementById("search-faculty-name").addEventListener("keyup", processChange);
		}
		
		//window.addEventListener('')

		//console.log('alphaProfessors', alphaProfessors);
	});
})(jQuery);

</script>

		<?php
	}
}