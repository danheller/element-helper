<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Faculty_Details extends Element_El_Widget {

	public function get_all_professors() {
		$faculties = get_posts([
			'post_type' => 'professors',
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
			$firstLetter = strtoupper(substr($professors[$idx]->post_title, 0, 1));
			if(!isset($alpha_professors[$firstLetter])) {
				$alpha_professors[$firstLetter] = array();
			}
			$this->get_more_professor_info($professors[$idx]);
			array_push($alpha_professors[$firstLetter], $professors[$idx]);
		}
		return $alpha_professors;
	}
	
	protected function morePublicationGroupByTitle($publication) {
		$newPub = array();
		foreach ( $publication as $pub ) {
			$thisTitle = $pub->post_title;
			//var_dump($thisTitle); echo '<br /><br />';
			if($newPub[$thisTitle] === NULL) {
				//echo 'empty';
				$newPub[$thisTitle] = $pub;
				$newPub[$thisTitle]->publication_type = get_field('publication_type', $pub->ID);
				$newPub[$thisTitle]->publication_sort_order = get_field('publication_sort_order', $pub->ID);
				$newPub[$thisTitle]->publication_section_title = get_field('publication_section_title', $pub->ID);
				$newPub[$thisTitle]->publication_text = get_field('publication_text', $pub->ID);
				$newPub[$thisTitle]->publication_hosted_internally = get_field('publication_hosted_internally', $pub->ID);
				$newPub[$thisTitle]->publication_link_target = $newPub[$thisTitle]->publication_hosted_internally === '0' ? '_blank' : '_blank';
				$thisPubTextType = get_field('publication_text_type', $pub->ID);
				$thisPubUrl = get_field('publication_url', $pub->ID);
				if(!empty($thisPubTextType)) {
					$newPub[$thisTitle]->{$thisPubTextType} = $thisPubUrl;
					$newPub[$thisTitle]->arr_type = array($thisPubTextType);
				} else {
					$newPub[$thisTitle]->general = $thisPubUrl;
					$newPub[$thisTitle]->arr_type = array('general');
				}
			} else {
				$thisPubTextType = get_field('publication_text_type', $pub->ID);
				$thisPubUrl = get_field('publication_url', $pub->ID);
				if(!empty($thisPubTextType)) {
					$newPub[$thisTitle]->{$thisPubTextType} = $thisPubUrl;
					$newPub[$thisTitle]->arr_type[] = $thisPubTextType;
				} else {
					$newPub[$thisTitle]->general = $thisPubUrl;
					$newPub[$thisTitle]->arr_type[] = 'general';
				}
			}
		}
		$newGroupPub = array();
		foreach($newPub as $eachPub) {
			//var_dump($eachPub->publication_type); echo '<br /><br />';
			if($newGroupPub[$eachPub->publication_type] === NULL) {
				$newGroupPub[$eachPub->publication_type] = array();
			}
			$newGroupPub[$eachPub->publication_type][] = $eachPub;
		}
		//var_dump($newGroupPub);
		return $newGroupPub;
	}
	
	protected function morePublicationGroupByCategory($publication) {
		$newGroupPub = array();
		$pubCategories = $this->getPublicationCategories();
		foreach ( $publication as $pub ) {
			$thisTitle = $pub->post_title;
			$thisCategories = get_the_category($pub->ID);
			$thisIncludedCat = [];
			for( $idx = 0; $idx < count($thisCategories); $idx++ ) {
				if(in_array($thisCategories[$idx]->term_id, $pubCategories)) {
					array_push($thisIncludedCat, $thisCategories[$idx]);
				}
			}
			$pub->publication_type = get_field('publication_type', $pub->ID);
			$pub->publication_sort_order = get_field('publication_sort_order', $pub->ID);
			$pub->publication_section_title = get_field('publication_section_title', $pub->ID);
			$pub->publication_text = get_field('publication_text', $pub->ID);
			$pub->publication_text = !empty($pub->publication_text) ? $pub->publication_text : $thisTitle;
			$pub->publication_hosted_internally = get_field('publication_hosted_internally', $pub->ID);
			$pub->publication_link_target = $newPub[$thisTitle]->publication_hosted_internally === '0' ? '_blank' : '_blank';
			$thisPubTextType = get_field('publication_text_type', $pub->ID);
			$pub->publication_link_url = get_field('publication_url', $pub->ID);
			if(!empty($thisPubTextType)) {
				//$pub->{$thisPubTextType} = $thisPubUrl;
				$pub->arr_type = array($thisPubTextType);
			} else {
				//$pub->general = $thisPubUrl;
				$pub->arr_type = array('general');
			}
			
			foreach( $thisIncludedCat as $key => $thisCat ) {
				//var_dump($newGroupPub[$thisCat->name]);
				if($newGroupPub[$thisCat->name] === NULL) {
					$newGroupPub[$thisCat->name] = array();
				}
				array_push($newGroupPub[$thisCat->name], $pub);
			}
			//var_dump($newGroupPub); echo '<br /><br />';
			
			
			
			
			/*if($newPub[$thisTitle] === NULL) {
				//echo 'empty';
				$newPub[$thisTitle] = $pub;
				$newPub[$thisTitle]->publication_type = get_field('publication_type', $pub->ID);
				$newPub[$thisTitle]->publication_sort_order = get_field('publication_sort_order', $pub->ID);
				$newPub[$thisTitle]->publication_section_title = get_field('publication_section_title', $pub->ID);
				$newPub[$thisTitle]->publication_text = get_field('publication_text', $pub->ID);
				$newPub[$thisTitle]->publication_hosted_internally = get_field('publication_hosted_internally', $pub->ID);
				$newPub[$thisTitle]->publication_link_target = $newPub[$thisTitle]->publication_hosted_internally === '0' ? '_blank' : '_self';
				$thisPubTextType = get_field('publication_text_type', $pub->ID);
				$thisPubUrl = get_field('publication_url', $pub->ID);
				if(!empty($thisPubTextType)) {
					$newPub[$thisTitle]->{$thisPubTextType} = $thisPubUrl;
					$newPub[$thisTitle]->arr_type = array($thisPubTextType);
				} else {
					$newPub[$thisTitle]->general = $thisPubUrl;
					$newPub[$thisTitle]->arr_type = array('general');
				}
			} else {
				$thisPubTextType = get_field('publication_text_type', $pub->ID);
				$thisPubUrl = get_field('publication_url', $pub->ID);
				if(!empty($thisPubTextType)) {
					$newPub[$thisTitle]->{$thisPubTextType} = $thisPubUrl;
					$newPub[$thisTitle]->arr_type[] = $thisPubTextType;
				} else {
					$newPub[$thisTitle]->general = $thisPubUrl;
					$newPub[$thisTitle]->arr_type[] = 'general';
				}
			}*/
		}
		
		/*foreach($newPub as $eachPub) {
			//var_dump($eachPub->publication_type); echo '<br /><br />';
			if($newGroupPub[$eachPub->publication_type] === NULL) {
				$newGroupPub[$eachPub->publication_type] = array();
			}
			$newGroupPub[$eachPub->publication_type][] = $eachPub;
		}*/
		//var_dump(array_keys($newGroupPub));
		//var_dump($newGroupPub['International Judgments Worked On']);
		return $newGroupPub;
	}
	
	function getPublicationCategories() {
		return get_term_children(540, 'category');
	}
	
	function get_more_professor_info($professor) {
		$professor->professor_unique_id = get_field('unique_id', $professor->ID);
		$professor->professor_first_name = get_field('professor_first_name', $professor->ID);
		$professor->professor_middle_name = get_field('professor_middle_name', $professor->ID);
		$professor->professor_last_name = get_field('professor_last_name', $professor->ID);
		//$professor->professor_page_link = get_field('professor_page_link', $professor->ID);
		$professor->professor_page_link = get_permalink($professor->ID);
		$professor->professor_title = get_field('professor_title', $professor->ID);
		$professor->professor_division = get_field('professor_division', $professor->ID);
		$professor->professor_email = get_field('professor_email', $professor->ID);
		$professor->professor_phone = get_field('professor_phone', $professor->ID);
		$professor->professor_fax = get_field('professor_fax', $professor->ID);
		$professor->professor_room = get_field('professor_room', $professor->ID);
		$professor->professor_personal_website = get_field('professor_personal_website', $professor->ID);
		$professor->professor_google_scholar_profile = get_field('professor_google_scholar_profile', $professor->ID);
		$professor->professor_ssrn_author_page = get_field('professor_ssrn_author_page', $professor->ID);
		$professor->professor_download_curriculum_vitae = get_field('professor_download_curriculum_vitae', $professor->ID);
		$professor->professor_image = get_field('professor_image', $professor->ID);
		$professor->professor_last_updated = get_field('professor_last_updated', $professor->ID);
		$professor->professor_biography = get_field('professor_biography', $professor->ID);
		$professor->professor_publications = get_field('professor_publications', $professor->ID);
		$professor->professor_office_hours = get_field('professor_office_hours', $professor->ID);
		$professor->professor_inactive = get_field('professor_inactive', $professor->ID);
		$professor->professor_spotlight = get_field('professor_spotlight', $professor->ID);
		$professor->professor_education = get_field('professor_education', $professor->ID);
		$professor->professor_affiliation = get_field('professor_affiliation', $professor->ID);
		$professor->professor_twitter = get_field('professor_twitter', $professor->ID);
		$professor->professor_linkedln = get_field('professor_linkedln', $professor->ID);
		$professor->professor_tag_id = get_field('professor_tag_id', $professor->ID);
		//var_dump($professor->professor_tag_id);
		$professor->course_list = [];
		$field_value = sprintf( '^%1$s$|s:%2$u:"%1$s";', (string) $professor->ID, strlen( (string) $professor->ID ) );
		$course_list = get_posts([
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
			'meta_query'    => array(
				array(
					'key'       => 'course_professors',
					'value'     => $field_value,
					'compare'	=> 'REGEXP',
				),
			),
		]);
		//$template_metas1 = get_post_meta( 2641, 'course_professors', true );
		//var_dump($template_metas1); echo '<br /><br />';
		foreach($course_list as $course) {
			$course->course_link = get_field('course_link', $course->ID);
			$course->course_name = get_field('course_name', $course->ID);
			$course->course_prefix_number = get_field('course_prefix_number', $course->ID);
			$course->course_number = get_field('course_number', $course->ID);
			$professor->course_list[] = $course;
		}
		
		$professor->faculty_news = [];
		$faculty_news = get_posts([
			'post_type' => 'faculty_news',
			'post_status' => 'publish',
			'numberposts' => 3,
			'meta_query'    => array(
				array(
					'key'       => 'faculty_id',
					'value'     => $professor->professor_unique_id,
					'compare'	=> '=',
				),
			),
			//'meta_key' => 'faculty_news_date',
			//'orderby' => 'meta_value_num',
			//'meta_type' => 'DATE',
			'orderby' => 'post_date',
			'order' => 'DESC',
		]);
		$faculty_news = array_slice($faculty_news, 0, 3);
		//$template_metas1 = get_post_meta( 5511, 'faculty_id', true );
		//var_dump($professor->professor_page_link); echo '<br /><br />';
		foreach($faculty_news as $fnew) {
			$fnew->faculty_news_date = get_field('faculty_news_date', $fnew->ID);
			$fnew->faculty_news_title = get_field('faculty_news_title', $fnew->ID);
			$fnew->faculty_source = get_field('faculty_source', $fnew->ID);
			$fnew->faculty_news_link = get_field('faculty_news_link', $fnew->ID);
			$fnew->faculty_news_faculty = get_field('faculty_news_faculty', $fnew->ID);
			$professor->faculty_news[] = $fnew;
		}
		//$professor->faculty_news = array_slice($professor->faculty_news, 0, 4);
		//var_dump($faculty_news);
		$professor->faculty_posts = [];
		$professor->tag_id = get_the_tags($professor->ID) === false ? 0 : get_the_tags($professor->ID)[0]->term_id;
		$faculty_posts = get_posts([
			'post_type' => 'post',
			'post_status' => 'publish',
			'numberposts' => 3,
			'category' => '3',
			'tag__and' => $professor->tag_id,
			//'meta_key' => 'news_date',
			//'orderby' => 'meta_value_num',
			//'meta_type' => 'DATE',
			'order' => 'DESC',
			'orderby' => 'date',
		]);
		//var_dump($faculty_posts);
		//$faculty_posts = array_slice($faculty_posts, 0, 3);
		foreach($faculty_posts as $post) {
			$post->news_date = get_field('news_date', $post->ID);
			$post->news_title = get_field('news_title', $post->ID);
			$post->news_featured_image = get_the_post_thumbnail_url($post->ID) ?  get_the_post_thumbnail_url($post->ID, 'large') : get_field('news_image', $post->ID);
			$post->news_brief_description = get_field('news_brief_description', $post->ID);
			$post->news_link = get_permalink($post->ID);
			//var_dump($post->news_link);
			$professor->faculty_posts[] = $post;
		}
		$professor->faculty_scholarship = [];
		$faculty_scholarship = get_posts([
			'post_type' => 'scholarships',
			'post_status' => 'publish',
			'numberposts' => 3,
			'order'    => 'ASC',
			'tag__in' => $professor->tag_id,
			'meta_key' => 'scholarship_publish_date',
			'orderby' => 'meta_value_num',
			'meta_type' => 'DATE',
			'order' => 'DESC',
		]);
		//$faculty_scholarship = array_slice($faculty_scholarship, 0, 3);
		foreach($faculty_scholarship as $scholarship) {
			$scholarship->scholarship_content = get_field('scholarship_content', $scholarship->ID);
			$scholarship->scholarship_publish_date = get_field('scholarship_publish_date', $scholarship->ID);
			$scholarship->scholarship_author_last_name = get_field('scholarship_author_last_name', $scholarship->ID);
			$scholarship->scholarship_author_first_name = get_field('scholarship_author_first_name', $scholarship->ID);
			$professor->faculty_scholarship[] = $scholarship;
		}
		
		//var_dump($professor->professor_tag_id);
		//$template_metas1 = get_post_meta( 11676, 'author_unique_id', true );
		//var_dump($template_metas1); echo '<br /><br />';
		$pubCategories = $this->getPublicationCategories();
		//var_dump($allIncludedCategoriesIds);
		$faculty_publications_args = [
			'post_type' => 'publication',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
			'tag__in' => $professor->professor_tag_id,
			'category__in' => $pubCategories,
			'meta_key' => 'publication_sort_order',
			'orderby' => 'meta_value_num',
			'meta_type' => 'INT',
			'order' => 'ASC',
		];
		//var_dump($faculty_publications_args);
		$faculty_publications = get_posts($faculty_publications_args);
		//var_dump($professor->professor_tag_id);
		//var_dump($faculty_publications);
		$professor->faculty_publications = $this->morePublicationGroupByCategory($faculty_publications);
		//var_dump(array_keys($professor->faculty_publications));
		//var_dump($professor->faculty_publications['Articles']);
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
		return 'faculty-details';
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
		return __( 'Faculty Details', 'elementhelper' );
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
		return [ 'faculty', 'details', 'facultydetails' ];
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
			'selected_faculty',
			[
				'label'       => __( 'Select faculty', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'            => $this->get_all_professors(),
				'frontend_available' => true,
				'style_transfer'     => true,
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
	
	protected function icon_right_arrow() {
		return '<svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0807 11.5855L13.581 12.0816L19.3712 6.34061L13.581 0.59961L13.0807 1.09575L18.013 5.98622L1 5.98622L1 6.69499L18.013 6.69499L13.0807 11.5855Z" fill="#990000" stroke="#990000" stroke-width="0.5"/></svg>';
	}
	
	protected function getPagePermalinkByCategories($categories) {
		$link = '#';
		$page_by_categories = get_posts([
			'post_type' => 'page',
			'post_status' => 'publish',
			'numberposts' => 1,
			'category__and' => $categories,
		]);
		if( ! empty($page_by_categories) ) {
			$link = get_permalink($page_by_categories[0]->ID);
		}
		return $link;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$image    = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';
		$facultyListingUrl = '/faculty/';
		$args = array(
			'post_type'   => 'professors',
			'p' => intval($settings['selected_faculty']),
		);
		$faculty = get_posts($args);
		$selected_faculty = count($faculty) ? $faculty[0] : [];
		$this->get_more_professor_info($selected_faculty);
		
		//var_dump($selected_faculty->faculty_scholarship); exit;
		
		/*$courseId1 = 2561;
		$courseId2 = 2559;
		$coursIds = array($courseId1,$courseId2);
		$course_list = get_posts([
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
			'post__in' => $coursIds,
		]);
		$template_metas1 = get_post_meta( $courseId1, 'course_professors', true );
		$template_metas2 = get_post_meta( $courseId2, 'course_professors', true );
		var_dump($course_list); echo '<br /><br />';
		var_dump($template_metas1); echo '<br /><br />';
		var_dump($template_metas2); echo '<br /><br />';

		$search_value = '1695'; // whatever
		$field_value = sprintf( '^%1$s$|s:%2$u:"%1$s";', $search_value, strlen( $search_value ) );
		$course_list2 = get_posts([
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
			'meta_query'    => array(
				array(
					'key'       => 'course_professors',
					'value'     => $field_value,
					'compare'	=> 'REGEXP',
				),
			),
		]);
		$template_metas = get_field('course_professors', $course_list2[0]->ID);;
		var_dump($course_list2); echo '<br /><br />';*/
		//var_dump($template_metas);
		//var_dump($selected_faculty->ID);
		$assign_category = [];
		$assign_category['Clinics'] = 56;
		$assign_category['Centers Institues'] = 90;
		$assign_category['Topics'] = 22;
		
		$this_post_categories = get_the_category($selected_faculty->ID);
		$selected_post_categories = [];
		$related_interest_categories = [];
		$gould_affiliation_categories = [];
		foreach( $this_post_categories as $this_post_category ) {
			array_push($selected_post_categories, $this_post_category);
			if(in_array($this_post_category->category_parent, array($assign_category['Clinics']) )) {
				$this_post_category->post_link = $this->getPagePermalinkByCategories(array($assign_category['Clinics'],$this_post_category->term_id));
				array_push($gould_affiliation_categories, $this_post_category);
			}
			if(in_array($this_post_category->category_parent, array($assign_category['Centers Institues']) )) {
				$this_post_category->post_link = $this->getPagePermalinkByCategories(array($assign_category['Centers Institues'],$this_post_category->term_id));
				array_push($gould_affiliation_categories, $this_post_category);
			}
			if(in_array($this_post_category->category_parent, array($assign_category['Topics']) )) {
				$this_post_category->post_link = $this->getPagePermalinkByCategories(array($assign_category['Topics'],$this_post_category->term_id));
				array_push($related_interest_categories, $this_post_category);
			}
		}
		
		
		//var_dump($related_interest_categories);
		?>
	
<script type="text/javascript">
(function ($) {
    $(document).ready(function () {
		var bioHeight = document.querySelector('.fd-bio').offsetHeight || 5000;
		if(bioHeight > 400) {
			//$('.fd-bio').addClass('cut-short');
		}
		$('.fd-bio-read-more-action').on('click', function(e) {
			e.preventDefault();
			console.log('clicked');
			$('.fd-bio').removeClass('cut-short');
			$('.fd-bio-read-more').addClass('hidden');
		});
	});
})(jQuery);
</script>

<div class="faculty-details-wrapper">
	<div class="fd-top-background">
		<div class="container">
			<div class="fd-top-bg-row">
				<!--<div class="left-section"></div>
				<div class="right-section"></div>-->
			</div>
		</div>
	</div>
	<style>
		.sticky-child {
		  position: sticky;
		  top: 0;
		}
	</style>
	<div class="container">
		<div class="wrapper">
			<div class="sidebar">
				<div class="fd-back-link">
					<a href="/faculty/"><?php echo $this->icon_right_arrow(); ?> Back to View All Faculty</a>
				</div>
				<div class="sticky-child">
					<div class="fd-title-contact-row mobile">
						<div class="fd-title-wrapper">
							<h2><?php echo $selected_faculty->professor_first_name . ' ' . $selected_faculty->professor_last_name ?></h2>
							<div><?php echo $selected_faculty->professor_title; ?></div>
						</div>
					</div>
					<img src="<?php echo $selected_faculty->professor_image; ?>" />
					<div class="fd-contact-wrapper">
						<!--<h4 class="font-weight-400">Contact information</h4>-->
						<?php if(!empty($selected_faculty->professor_email)) { ?>
						<div class="each-contact-wrapper">
							<span class="each-contact-label"><span class="icon-email"><img src="/wp-content/uploads/2023/03/icon-email.png" /></span> EMAIL</span>
							<span class="each-contact-value"><a href="mailto:<?php echo $selected_faculty->professor_email; ?>"><?php echo $selected_faculty->professor_email; ?></a></span>
						</div>
						<?php } ?>
						<?php if(!empty($selected_faculty->professor_phone)) { ?>
						<div class="each-contact-wrapper">
							<span class="each-contact-label"><span class="icon-phone"><img src="/wp-content/uploads/2023/03/icon-phone.png" /></span> PHONE</span>
							<span class="each-contact-value"><?php echo $selected_faculty->professor_phone; ?></span>
						</div>
						<?php } ?>
						<?php if(!empty($selected_faculty->professor_room)) { ?>
						<div class="each-contact-wrapper">
							<span class="each-contact-label"><span class="icon-ext"><img src="/wp-content/uploads/2023/03/icon-ext.png" /></span> OFFICE</span>
							<span class="each-contact-value"><?php echo $selected_faculty->professor_room; ?></span>
						</div>
						<?php } ?>
						<?php if(!empty($selected_faculty->professor_office_hours)) { ?>
						<div class="each-contact-wrapper">
							<span class="each-contact-label"><span class="icon-hours"><img src="/wp-content/uploads/2023/03/icon-hours.png" /></span> HOURS</span>
							<span class="each-contact-value"><?php echo $selected_faculty->professor_office_hours; ?></span>
						</div>
						<?php } ?>
					</div>
					<div class="links-wrapper">
						<span class="download-cv">
							<?php if(!empty($selected_faculty->professor_download_curriculum_vitae)) { ?>
							<a href="<?php echo $selected_faculty->professor_download_curriculum_vitae; ?>" target="_blank">Download CV</a>
							<?php } ?>
							<?php if(!empty($selected_faculty->professor_google_scholar_profile)) { ?>
							<a href="<?php echo $selected_faculty->professor_google_scholar_profile; ?>" target="_blank">Google Scholar Profile</a>
							<?php } ?>
							<?php if(!empty($selected_faculty->professor_ssrn_author_page)) { ?>
							<a href="<?php echo $selected_faculty->professor_ssrn_author_page; ?>" target="_blank">SSRN Author Page</a>
							<?php } ?>
						</span>
						<span class="linkedin-twitter">
							<?php if(!empty($selected_faculty->professor_twitter)) { ?>
							<a href="<?php echo $selected_faculty->professor_twitter; ?>" target="_blank"><i class="fa-brands fa-twitter"></i> Twitter</a>
							<?php } ?>
							<?php if(!empty($selected_faculty->professor_linkedln)) { ?>
							<a href="<?php echo $selected_faculty->professor_linkedln; ?>" target="_blank"><i class="fa-brands fa-linkedin"></i> Linkedin</a>
							<?php } ?>
						</span>
					</div>
				</div>
			</div>
			<div class="main-content">
				<div class="fd-title-contact-row">
					<div class="fd-title-wrapper">
						<h2><?php echo $selected_faculty->professor_first_name . ' ' . $selected_faculty->professor_last_name ?></h2>
						<div><?php echo $selected_faculty->professor_title; ?></div>
					</div>
				</div>
				<div class="last-updated">
					Last Updated: <?php echo date_format(date_create($selected_faculty->professor_last_updated), "F j, Y"); ?>
				</div>
				<?php if(!empty($selected_faculty->professor_biography)) { ?>
				<div class="fd-bio">
					<?php echo $selected_faculty->professor_biography; ?>
					<!--<div class="fd-bio-read-more">
						<a href="#" class="fd-bio-read-more-action">
							Read More
							<i class="fa-solid fa-chevron-down"></i>
						</a>
					</div>-->
				</div>
				<?php } ?>
				<?php if(!empty($selected_faculty->professor_education) || !empty($selected_faculty->professor_affiliation)) { ?>
					<div class="row fd-education-affiliation">
					<?php if(!empty($selected_faculty->professor_education)) { ?>
					<div class="fd-education col-sm-6">
						<h3 class="font-weight-400"><span>Education</span></h3>
						<?php echo $selected_faculty->professor_education; ?>
					</div>
					<?php } ?>
					<?php if(!empty($gould_affiliation_categories)) { ?>
					<div class="fd-affiliation col-sm-6">
						<h3 class="font-weight-400"><span>Gould Affiliations</span></h3>
						<ul>
						<?php foreach($gould_affiliation_categories as $selected_post_category) { ?>
						<li><span><a href="<?php echo $selected_post_category->post_link; ?>" class="faculty-gould-affiliation-link"><?php echo $selected_post_category->cat_name; ?></a></span></li>
						<?php } ?>
						</ul>
						<?php //echo $selected_faculty->professor_affiliation; ?>
					</div>
					<?php } ?>
					</div>
				<?php } ?>
				<?php if( !empty ($related_interest_categories) ) { ?>
				<div class="faculty-related-interests">
					<strong>Related Interests: </strong>
					<?php foreach($related_interest_categories as $selected_post_category) { ?>
					<span><a href="<?php echo $selected_post_category->post_link; ?>" class="faculty-related-interest-link"><?php echo $selected_post_category->cat_name; ?></a></span>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if(!empty($selected_faculty->professor_spotlight)) { ?>
				<div class="spotlight-wrapper">
					<?php echo $selected_faculty->professor_spotlight; ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="faculty-selected-work-wrapper">
	<div class="container">
		<div class="selected-work-wrapper">
			<div class="fd-articles-book-wrapper">
				<h2 class="cardinal-text-color"><span><?php //echo $selected_faculty->professor_first_name . ' ' . $selected_faculty->professor_last_name ?> <span class="black-text-color">Selected Works</span></span></h2>
				<div class="fd-articles-book <?php echo $selected_faculty->faculty_publications['Other Works'] !== NULL ? 'has-other-works' : ''; ?>">
					<h4><img src="/wp-content/uploads/2023/03/icon-article-book-work.png" alt="Icon" /> Articles and Book Chapters</h4>
					<div class="fd-articles">
						<?php if($selected_faculty->faculty_publications['Articles and Book Chapters'] !== NULL) { ?>
						<?php foreach( $selected_faculty->faculty_publications['Articles and Book Chapters'] as $thisPub ) { ?>
						<div class="fd-article">
							<div class="publication-text"><?php echo $thisPub->publication_text; ?></div>
							<div class="article-more">
								<?php 
									foreach ( $thisPub->arr_type as $thisType ) { 
										//if(!empty($thisPub->{$thisType})) {
											$thisType = $thisType === 'general' ? 'link' : $thisType;
								?>
								<a href="<?php echo $thisPub->{$thisType}; ?>" target="<?php echo $thisPub->publication_link_target; ?>"><img src="/wp-content/uploads/2023/03/icon-external-link.png" alt="Icon" /><?php echo $thisType; ?></a>
								<?php } ?>
								<?php //} ?>
							</div>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
				<div class="fd-other-works">
					<?php 
					//if($selected_faculty->faculty_publications['Other Works'] !== NULL) { 
					?>
					<?php //foreach( $selected_faculty->faculty_publications['Other Works'] as $thisPub ) { ?>
					<?php foreach( array_keys($selected_faculty->faculty_publications) as $thisCat ) { $thisPubs = $selected_faculty->faculty_publications[$thisCat] ?>
					<?php if( $thisCat !== 'Articles and Book Chapters' && $thisCat !== 'Other Works') { ?>
					<h4><img src="/wp-content/uploads/2023/03/icon-article-book-work.png" alt="Icon" /> Other Works <span><?php echo $thisCat; ?></span></h4>
					<div class="fd-others">
						<?php foreach( $thisPubs as $thisPub ) { ?>
						<div class="fd-other">
							<div class="publication-text"><?php echo $thisPub->publication_text; ?></div>
							<div class="article-more">
								<?php 
									foreach ( $thisPub->arr_type as $thisType ) { 
										//if(!empty($thisPub->{$thisType})) {
											$thisType = $thisType === 'general' ? 'link' : $thisType;
								?>
								<a href="<?php echo $thisPub->publication_link_url; ?>" target="<?php echo $thisPub->publication_link_target; ?>"><?php echo $thisType; ?></a>
								<?php //} ?>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div>
					<?php } ?>
					<?php } ?>
					<?php //} ?>
				</div>
			</div>
		</div>
	</div>
	<?php if(count($selected_faculty->faculty_posts)) { ?>
	<div class="recent-stories-wrapper">
		<div class="container">
			<h2><span>Related Stories</span></h2>
		
			<div class="fd-news">
				<ul class="row list-unstyled">
					<?php foreach($selected_faculty->faculty_posts as $faculty_post) { ?>
					<li class="col-sm-4">
						<div class="fd-news-item">
							<div class="fd-news-image">
								<a href="<?php echo $faculty_post->news_link; ?>" target="_blank"><img src="<?php echo $faculty_post->news_featured_image; ?>" alt="Featured Image" /></a>
							</div>
							<div class="fd-news-content">
								<div class="fd-news-tags">
									<a href="#">News</a>
								</div>
								<div class="fd-news-title">
									<a href="<?php echo $faculty_post->news_link; ?>" target="_blank"><?php echo $faculty_post->news_title; ?></a>
								</div>
								<div class="fd-news-brief-description">
									<a href="<?php echo $faculty_post->news_link; ?>" target="_blank"><?php echo $faculty_post->news_brief_description; ?></a>
								</div>
								<div class="fd-news-more">
									<a href="<?php echo $faculty_post->news_link; ?>" target="_blank">Read More <?php echo $this->icon_right_arrow(); ?></a>
								</div>
								<div class="fd-news-date">
									<?php echo date_format(date_create($faculty_post->news_date), "F j, Y"); ?>
								</div>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div class="text-center">
					<a href="/about/news/" class="btn btn-primary">View All Gould News</a>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if(count($selected_faculty->faculty_news)) { ?>
	<div class="in-the-news-wrapper">
		<div class="container">
			<h2><span>In the News</span></h2>
			<ul class="row list-unstyled">
				<?php foreach($selected_faculty->faculty_news as $faculty_news) { ?>
				<li class="">
					<div class="fd-quoted-item">
						<div class="fd-quoted-faculty-name">
							<a href="<?php echo $professor->professor_page_link; ?>"><?php echo $faculty_news->faculty_news_faculty; ?></a>
						</div>
						<div class="fd-quoted-title">
							<?php echo $faculty_news->faculty_news_title; ?>
						</div>
						<div class="fd-quoted-date">
							<?php echo $faculty_news->faculty_source; ?> &bull; <?php echo date_format(date_create($faculty_news->faculty_news_date), "F j, Y"); ?>
						</div>
						<div class="fd-quoted-more">
							<a href="<?php echo $faculty_news->faculty_news_link; ?>" target="_blank">Read More <img src="/wp-content/uploads/2023/03/icon-right-arrow.png" /></a>
						</div>
					</div>
				</li>
				<?php } ?>
			</ul>
			<div class="text-center">
				<a href="/faculty/news/" class="btn btn-primary">View all Faculty in the News</a>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if( false && count($selected_faculty->faculty_scholarship)) { ?>
	<div class="research-scholarship-wrapper">
		<div class="container">
			<div class="fd-research-scholarship">
				<h2>Research & Scholarship Updates</h2>
				<ul class="row list-unstyled">
					<?php foreach($selected_faculty->faculty_scholarship as $faculty_scholarship) { ?>
					<li class="col-sm-4">
						<div class="">
							<?php echo $faculty_scholarship->scholarship_content; ?>
						</div>
						<div clss="">
							<?php echo date_format(date_create($faculty_scholarship->scholarship_publish_date), "F j, Y"); ?>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div class="text-center">
					<a href="/faculty/scholarship/" class="btn btn-cardinal-yellow">View All USC Gould Research & Scholarship Updates</a>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="courses-wrapper">
		<div class="container">
			<div class="fd-courses">
				<h2><span><?php //echo $selected_faculty->professor_first_name . ' ' . $selected_faculty->professor_last_name ?> <span class="black-text-color">Courses</span></span></h2>
				<ul class="list-unstyled">
					<?php foreach($selected_faculty->course_list as $each_course) { ?>
					<li class=""><a href="<?php echo $each_course->course_link; ?>"><?php echo $each_course->course_name . ': ' . $each_course->course_prefix_number . '-' . $each_course->course_number; ?> <img src="/wp-content/uploads/2023/03/icon-right-arrow.png" alt="Arrow Icon" /></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>

		<?php
	}

}