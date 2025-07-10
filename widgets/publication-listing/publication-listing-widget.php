<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Publication_Listing extends Element_El_Widget {

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
		$course->course_link = get_field('course_link', $course->ID);
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
		return 'publication-listing';
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
		return __( 'Publication Listing', 'elementhelper' );
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
		return [ 'publication', 'listing', 'publicationlisting' ];
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
			'publication_categories',
			[
				'label'        => __( 'Select Publication Categories', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_categories(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'selected_publication',
			[
				'label'        => __( 'Select publication', 'elementhelper' ),
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

	protected function render() {
		$settings = $this->get_settings_for_display();
		$image    = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';
		
		$max_count = $settings['max_result'] > 0 ? $settings['max_result'] : -1;
		
		$args = array(
			'post_type' => 'publication',
			'post_status' => 'publish',
			'numberposts' => $max_count,
			'meta_key' => 'publication_sort_order',
			'orderby' => 'meta_value_num',
			'meta_type' => 'INT',
			'order' => 'ASC',
		);
		if( ! empty ( $settings['publication_categories'] ) ) {
			$args['category__and'] = $settings['publication_categories'];
		} else if( ! empty ( $settings['selected_publication']) ) {
			$args['include'] = $settings['selected_publication'];
		}
		//var_dump($args);
		$publications = get_posts($args);
		foreach( $publications as $publication) {
			$this->get_more_course_info($publication);
			$publications_groups = $this->morePublicationGroupByTitle($publications);
		}
		//var_dump($publications_groups);
		?>

		<div class="publication-listing-wrapper <?php echo $settings['module_class']; ?>">
			<?php if ( ! empty( $settings['title'] ) ): ?>
			<div class="publication-listing-title">
				<?php echo '<' . $settings['title_tag'] . ' class="title">'; ?>
					<span><?php echo $settings['title'] ?></span>
				<?php echo '</' . $settings['title_tag'] . '>'; ?>
			</div>
			<?php endif; ?>
			<div class="publications-wrapper">
				<?php if($publications_groups['Articles and Book Chapters'] !== NULL) { ?>
				<h4><img src="/wp-content/uploads/2023/03/icon-article-book-work.png" alt="Star label icon" /> Articles and Book Chapters</h4>
				<ul class="publications-listing-group">							
					<?php foreach( $publications_groups['Articles and Book Chapters'] as $thisPub ) { ?>
					<li class="publication-item">
						<div class="publication-wrapper">
							<div class="publication-text"><?php echo $thisPub->publication_text; ?></div>
							<div class="article-more">
								<?php 
								foreach ( $thisPub->arr_type as $thisType ) { 
									if(!empty($thisPub->{$thisType})) {
										$thisType = $thisType === 'general' ? 'link' : $thisType;
								?>
								<a href="<?php echo $thisPub->{$thisType}; ?>" target="<?php echo $thisPub->publication_link_target; ?>"><img src="/wp-content/uploads/2023/03/icon-external-link.png" alt="External link icon" /><?php echo $thisType; ?></a>
								<?php } } ?>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>
			<div class="publications-wrapper">
				<?php if($publications_groups['Other Works'] !== NULL) { ?>
				<h4><img src="/wp-content/uploads/2023/03/icon-article-book-work.png" alt="Star label icon" /> Other Works</h4>
				<ul class="publications-listing-group">							
					<?php foreach( $publications_groups['Other Works'] as $thisPub ) { ?>
					<li class="publication-item">
						<div class="publication-wrapper">
							<div class="publication-text"><?php echo $thisPub->publication_text; ?></div>
							<div class="article-more">
								<?php 
								foreach ( $thisPub->arr_type as $thisType ) { 
									if(!empty($thisPub->{$thisType})) {
										$thisType = $thisType === 'general' ? 'link' : $thisType;
								?>
								<a href="<?php echo $thisPub->{$thisType}; ?>" target="<?php echo $thisPub->publication_link_target; ?>"><img src="/wp-content/uploads/2023/03/icon-external-link.png" alt="External link icon" /><?php echo $thisType; ?></a>
								<?php } } ?>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>
		</div>

		<?php
	}

}