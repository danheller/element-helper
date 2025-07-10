<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Research_Scholarship_Listing extends Element_El_Widget {

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
	
	/*function get_more_professor_info($professor) {
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
	}*/
	
	/*public function get_professor_info($professor) {
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
	}*/
	
	function get_more_research_scholarship_info($rands) {
		$rands->scholarship_author_last_name = get_field('scholarship_author_last_name', $rands->ID);
		$rands->scholarship_author_first_name = get_field('scholarship_author_first_name', $rands->ID);
		$rands->scholarship_content = get_field('scholarship_content', $rands->ID);
		$rands->scholarship_publish_date = get_field('scholarship_publish_date', $rands->ID);
		$rands->scholarship_date = get_field('scholarship_date', $rands->ID);
		$randsTags = get_the_tags($rands->ID);
		//var_dump($rands); echo '<br /><br />';
		if($randsTags !== false) {
			$args = array(
				'post_type' => 'professors',
				'post_status' => 'publish',
				'numberposts' => 1,
				'tag_id' => (count($randsTags) ? $randsTags[0]->term_id : 0)
			);
			$randsFacultyTag = get_posts($args);
			$rands->author_permalink = count($randsFacultyTag) ? get_permalink($randsFacultyTag[0]->ID) : '';
		} else {
			$rands->author_permalink = '';
		}
		//var_dump(get_permalink($randsFacultyTag[0]->ID),$randsFacultyTag[0]->ID);
		/*$course->course_name = get_field('course_name', $course->ID);
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
		return $course;*/
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
		return 'research-scholarship-listing';
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
		return __( 'Research & Scholarship Listing', 'elementhelper' );
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
		return [ 'research', 'scholarship', 'researchscholarship' ];
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
			'is_main_scholarship',
			[
				'label'        => __( 'Is Main Scholarship Page', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'description_below_dropdown',
			[
				'label'       => __( 'Description Below Dropdown', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'research_scholarship_categories',
			[
				'label'        => __( 'Select Research & Scholarship Categories', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_categories(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'selected_research_scholarship',
			[
				'label'        => __( 'Select Research & Scholarship', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_courses_dropdown(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'max_result',
			[
				'label'       => __( 'Maximum Result', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 3,
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
		
		$max_count = $settings['max_result'] > 0 ? $settings['max_result'] : -1;
		
		$args = array(
			'post_type' => 'faculty-scholarship',
			'post_status' => 'publish',
			'numberposts' => $max_count,
			'meta_key' => 'scholarship_publish_date',
			'orderby' => 'meta_value_num',
			'meta_type' => 'DATE',
			'order' => 'DESC',
		);
		if( ! empty ( $settings['research_scholarship_categories'] ) ) {
			$args['category__and'] = $settings['research_scholarship_categories'];
		} else if( ! empty ( $settings['selected_research_scholarship']) ) {
			$args['include'] = $settings['selected_research_scholarship'];
		}
		//var_dump($args); echo '<br /><br />';
		$research_scholarship = get_posts($args);
		//var_dump($research_scholarship); echo '<br /><br />';
		foreach( $research_scholarship as $each_rands) {
			$this->get_more_research_scholarship_info($each_rands);
		}
		//var_dump($research_scholarship);
		?>

		<div class="research-scholarship-listing-wrapper <?php echo $settings['module_class']; ?>">
			<?php if ( ! empty( $settings['title'] ) ): ?>
			<div class="research-scholarship-listing-title">
				<?php echo '<' . $settings['title_tag'] . ' class="title">'; ?>
					<span><?php echo $settings['title'] ?></span>
				<?php echo '</' . $settings['title_tag'] . '>'; ?>
			</div>
			<?php endif; ?>
			<?php if ( $settings['is_main_scholarship'] === 'yes' ) { ?>
			<div class="research-scholarship-data-wrapper">
				<label >
					<strong style="color:#131313;">Select Publication:</strong>
					<select id="selectDate" name="selectDate" ></select>
				</label>
			</div>
			<?php if( ! empty ($settings['description_below_dropdown'] ) ) { ?>
			<div class="description-below-dropdown-wrapper">
				<?php echo $settings['description_below_dropdown']; ?>
			</div>
			<?php } ?>
			<div class="month-label-wrapper">
				<h2 class="title">
					<span></span>
				</h2>
			</div>
			<div class="scholarship-results-wrapper">
				
			</div>
			<?php } else { ?>
			<ul class="row list-unstyled">
				<?php foreach($research_scholarship as $each_rands) { ?>
				<li class="col-sm-4">
					<div class="rs-wrapper">
						<div class="rs-name">
							<?php if(!empty($each_rands->author_permalink)) { ?>
							<a href="<?php echo $each_rands->author_permalink; ?>">
							<?php } ?>
							<?php echo $each_rands->scholarship_author_first_name . ' ' . $each_rands->scholarship_author_last_name; ?>
							<?php if($each_rands->author_permalink) { ?>
							</a>
							<?php } ?>
						</div>
						<div class="rs-quote">
							<?php echo $each_rands->scholarship_content; ?>
						</div>
						<div class="rs-date">
							<?php echo date_format(date_create($each_rands->scholarship_publish_date), "F j, Y"); ?>
						</div>
					</div>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</div>
<?php if ( $settings['is_main_scholarship'] === 'yes' ) { ?>
<script language="javascript">
(function ($) {
	$(document).ready(function () {
		var topicOrder = ['publications','acceptances','presentations-lectures-workshops','working-papers','other']
		var jsonFnameBase = '/wp-content/themes/usc/json/scholarships/';
		var jsonDateDropdownFname = jsonFnameBase + 'month-index.json';
		function generateScholarshipHtml(groupInfo) {
			//console.log('groupInfo',groupInfo,groupInfo.cat_name);
			var sHtml = '';
			sHtml += '<div class="scholarship-section-wrapper">';
			sHtml += '<h3>' + groupInfo.cat_name + '</h3>';
			for(var j = 0; j < groupInfo.scholarship_data.length; j++) {
				sHtml += '<ul class="scholarship-item-wrapper">';
				sHtml += '<li>';
				sHtml += '<div class="scholarship-item-info">';
				sHtml += '<a href="' + groupInfo.scholarship_data[j].professor_permalink + '">' + groupInfo.scholarship_data[j].professor_name + '</a>';
				sHtml += '<div>' + groupInfo.scholarship_data[j].scholarship_title + '</div>';
				sHtml += '</div>';
				sHtml += '</li>';
				sHtml += '</ul>';
			}
			sHtml += '</div>';
			$('.scholarship-results-wrapper').append(sHtml)
		}
		function getScholarshipJson(jsonFname) {
			$.ajax({
				dataType: "json",
				url: jsonFname,
				crossDomain: true,
				success: function (scholarshipData) {
					//console.log('scholarshipData', scholarshipData);
					const topicList = Object.keys(scholarshipData);
					console.log('topicList',topicList);
					$('.scholarship-results-wrapper').html('');
					for( var j = 0; j < topicOrder.length; j++) {
						if(scholarshipData[topicOrder[j]] !== undefined) {
							const thisGroup = scholarshipData[topicOrder[j]];
							generateScholarshipHtml(thisGroup);							
						}
					}
				},
				error: function (jqXHR, error, errorThrown) {
					if (jqXHR.status && jqXHR.status == 400) {
						console.log(jqXHR.responseText);
					} else {
						console.log("Something went wrong - ", error);
					}
				},
			});
		}
		$('select#selectDate').on('change', function(e) {
			const selectedMonth = $('#selectDate').val();
			var jsonDateDropdownFname = jsonFnameBase + selectedMonth + '.json';
			var selectedMonthLabel = $("select#selectDate option:selected").text();
			$('.month-label-wrapper .title span').html(selectedMonthLabel);
			getScholarshipJson(jsonDateDropdownFname);
		});
		function ajaxDateDropdown(jsonDateDropdownFname) {
			$.ajax({
				dataType: "json",
				url: jsonDateDropdownFname,
				crossDomain: true,
				success: function (dDropdown) {
					const mDropdown = Object.keys(dDropdown);
					//console.log('mDropdown', mDropdown);
					for ( var i = 0; i < mDropdown.length; i++ ) {
						$('#selectDate').append('<option value="'+ mDropdown[i] +'">' + dDropdown[mDropdown[i]] + '</option>');
					}
					const selectedMonth = $('#selectDate').val();
					const selectedMonthLabel = dDropdown[selectedMonth];
					$('.month-label-wrapper .title span').html(selectedMonthLabel);
					getScholarshipJson(jsonFnameBase + selectedMonth + '.json')
				},
				error: function (jqXHR, error, errorThrown) {
					if (jqXHR.status && jqXHR.status == 400) {
						console.log(jqXHR.responseText);
					} else {
						console.log("Something went wrong - ", error);
					}
				},
			});
		}
		ajaxDateDropdown(jsonDateDropdownFname);
	});
})(jQuery);
</script>
<?php } ?>
		<?php
	}

}