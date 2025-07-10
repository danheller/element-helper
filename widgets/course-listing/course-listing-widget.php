<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Course_Listing extends Element_El_Widget {

	public function get_all_courses($courses) {
		$arg = [
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'orderby' => 'title',
			'order'    => 'ASC',
			'meta_query'    => array(
				array(
					'key'       => 'course_visible',
					'value'     => true,
					'compare'   => '=',
				),
			),
		];
		if(! empty ( $courses )) {
			$arg['include'] = $courses;
		}
		$courses = get_posts($arg);
		return $courses;
	}
	
	public function get_all_courses_dropdown() {
		$courses = get_posts([
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'orderby' => 'title',
			'order'    => 'ASC',
			'meta_query'    => array(
				array(
					'key'       => 'course_visible',
					'value'     => true,
					'compare'   => '=',
				),
			),
		]);
		$all_faculties = [];
		foreach($courses as $course) {
			$all_courses[$course->ID] = $course->post_title;
		}
		return $all_courses;
	}
	
	function get_more_professor_info($professor) {
		$professor->professor_first_name = get_post_meta($professor->ID, 'professor_first_name');
		$professor->professor_middle_name = get_post_meta($professor->ID, 'professor_middle_name');
		$professor->professor_last_name = get_post_meta($professor->ID, 'professor_last_name');
		$professor->professor_division = get_post_meta($professor->ID, 'professor_division');
		$professor->professor_title = get_post_meta($professor->ID, 'professor_title');
		$professor->professor_email = get_post_meta($professor->ID, 'professor_email');
		$professor->professor_phone = get_post_meta($professor->ID, 'professor_phone');
		$professor->professor_fax = get_post_meta($professor->ID, 'professor_fax');
		$professor->professor_room = get_post_meta($professor->ID, 'professor_room');
		$professor->professor_personal_website = get_post_meta($professor->ID, 'professor_personal_website');
		$professor->professor_google_scholar_profile = get_post_meta($professor->ID, 'professor_google_scholar_profile');
		$professor->professor_ssrn_author_page = get_post_meta($professor->ID, 'professor_ssrn_author_page');
		$professor->professor_download_curriculum_vitae = get_post_meta($professor->ID, 'professor_download_curriculum_vitae');
		$professor->professor_image = get_post_meta($professor->ID, 'professor_image');
		$professor->professor_last_updated = get_post_meta($professor->ID, 'professor_last_updated');
		$professor->professor_biography = get_post_meta($professor->ID, 'professor_biography');
		$professor->professor_publications = get_post_meta($professor->ID, 'professor_publications');
		$professor->professor_inactive = get_post_meta($professor->ID, 'professor_inactive');
		return $professor;
	}
	
	public function get_professor_info($professor) {
		$professor_data = [];
		if(count($professor) && !empty($professor[0])) {
			$args = array(
				'post_type'   => 'professors',
				'p' => intval($professor[0]),
			);
			$tmp = get_posts($args);
			$professor_data = count($tmp) ? $tmp[0] : [];
			$this->get_more_professor_info($professor_data);
		}
		return $professor_data;
	}
	
	function get_more_course_info($course) {
		$course->course_name = get_field('course_name', $course->ID);
		$course->course_number = get_field('course_number', $course->ID);
		//$course->course_link = get_field('course_link', $course->ID);
		$course->course_link = get_permalink($course->ID);
		$course->course_description = get_field('course_description', $course->ID);
		$course->course_units = get_field('course_units', $course->ID);
		$course->course_grading_options = get_field('course_grading_options', $course->ID);
		$course->course_exam_type = get_field('course_exam_type', $course->ID);
		$course->writing_requirement = get_field('writing_requirement', $course->ID);
		$course->skillsexperiential_requirement = get_field('skillsexperiential_requirement', $course->ID);
		$course->enrollment_limit = get_field('enrollment_limit', $course->ID);
		$course->note_below = get_field('note_below', $course->ID);
		//$course->professor_1_info = $this->get_professor_info(get_post_meta($course->ID, 'professor_1'));
		//$course->professor_2_info = $this->get_professor_info(get_post_meta($course->ID, 'professor_2'));
		//$course->professor_3_info = $this->get_professor_info(get_post_meta($course->ID, 'professor_3'));
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
		return 'course-listing';
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
		return __( 'Course Listing', 'elementhelper' );
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
		return [ 'course', 'description', 'coursedescription' ];
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
			'course_categories',
			[
				'label'        => __( 'Select Course Categories', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_categories(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'selected_courses',
			[
				'label'        => __( 'Select Post Categories', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_courses_dropdown(),
				'default' => [ ],
			]
		);
			
		$this->add_control(
			'show_red_right_arrow_image',
			[
				'label'        => __( 'Show Right Arrow Image', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
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

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$image    = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';
		
		
		/*$course_listing = $this->get_all_courses($settings['selected_courses']);
		for( $idx = sizeof($course_listing) - 1; $idx >= 0; $idx-- ) {
			$course_listing[$idx]->course_inactive = get_post_meta($course->ID, 'course_inactive');
			if($course_listing[$idx]->course_inactive) {
				unset($course_listing[$idx]);
			} else {
				$this->get_more_course_info($course_listing[$idx]);
			}
		}*/
		//var_dump($course_listing);
		
		$args = array(
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'orderby' => 'title',
			'order'    => 'ASC',
			'meta_query'    => array(
				array(
					'key'       => 'course_visible',
					'value'     => true,
					'compare'   => '=',
				),
			),
		);
		if( ! empty ( $settings['course_categories'] ) ) {
			$args['category__and'] = $settings['course_categories'];
		} else if( ! empty ( $settings['selected_courses']) ) {
			$args['include'] = $settings['selected_courses'];
		}
		//var_dump($args);
		$course_listing = get_posts($args);
		foreach( $course_listing as $each_course) {
			$this->get_more_course_info($each_course);
		}
		$startHidingIndex = $settings['show_show_more'] === 'yes' && $settings['initial_show_item'] ? $settings['initial_show_item'] : count($course_listing);
		
		?>

		<?php if(!empty($course_listing)) { ?>
		<div class="course-listing-wrapper <?php echo $settings['module_class']; ?>">
			<h2><span>Courses</span></h2>
			<div class="course-listing-inner">
				<?php if ( ! empty( $settings['title'] ) ): ?>
				<div class="course-listing-title">
					<?php echo '<' . $settings['title_tag'] . ' class="title">'; ?>
						<span><?php echo $settings['title'] ?></span>
					<?php echo '</' . $settings['title_tag'] . '>'; ?>
				</div>
				<?php endif; ?>
				<?php for( $ix = 0; $ix < count($course_listing); $ix++ ) { ?>
				<div class="course-wrapper <?php echo ($ix % 2 === 0 ? 'odd' : 'even'); ?> <?php echo $startHidingIndex > $ix ? '' : 'hide'; ?>">
					<div class="course-name">
						<?php if(!empty($course_listing[$ix]->course_link)) { echo '<a href="' . $course_listing[$ix]->course_link .'">'; } ?>
						<?php echo $course_listing[$ix]->post_title; ?>
						<?php if ( $settings['show_red_right_arrow_image'] === 'yes' ) { ?>
						<img src="/wp-content/uploads/2023/03/icon-right-arrow.png" />
						<?php } ?>
						<?php if(!empty($course_listing[$ix]->course_link)) { echo '</a>'; } ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php if( $settings['show_show_more'] === 'yes' && count($course_listing) > $settings['initial_show_item'] ) { ?>
			<div class="course-listing-show-more">
				<a href='#"' class="show-more-course-lisitng">Show More</a>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		

<script language="javascript">
(function ($) {
    $(document).ready(function () {
		$('.show-more-course-lisitng').on('click', function(e) {
			e.preventDefault();
			$('.course-listing-wrapper .course-wrapper').removeClass('hide');
			$('.course-listing-show-more').addClass('hide');
		});
	});
})(jQuery);

</script>
		<?php
	}

}