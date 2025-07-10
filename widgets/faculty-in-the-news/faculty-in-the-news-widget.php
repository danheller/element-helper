<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Faculty_In_The_News extends Element_El_Widget {

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
	
	function get_more_faculty_in_the_news_info($fitn) {
		$fitn->faculty_first_name = get_field('faculty_first_name', $fitn->ID);
		$fitn->faculty_last_name = get_field('faculty_last_name', $fitn->ID);
		$fitnTags = get_the_tags($fitn->ID);
		//var_dump($fitnTags); echo '<br /><br />';
		if($fitnTags !== false) {
			$args = array(
				'post_type' => 'professors',
				'post_status' => 'publish',
				'numberposts' => 1,
				'tag_id' => (count($fitnTags) ? $fitnTags[0]->term_id : 0)
			);
			$fitnFacultyTag = get_posts($args);
			$newFacultyNameArr = explode(",", $fitnFacultyTag[0]->post_title);
			$fitn->faculty_first_name = trim($newFacultyNameArr[1]);
			$fitn->faculty_last_name = trim($newFacultyNameArr[0]);
			$fitn->faculty_permalink = count($fitnFacultyTag) ? get_permalink($fitnFacultyTag[0]->ID) : '';
		} else {
			$fitn->faculty_permalink = '';
		}
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
		return 'faculty-in-the-news';
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
		return __( 'Faculty In The News', 'elementhelper' );
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
		return [ 'faculty', 'in', 'the', 'news', 'facultyinthenews' ];
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
			'faculty_in_the_news_name',
			[
				'label'        => __( 'Select Faculty in the News Name', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				//'multiple' => true,
				'options' => $this->get_all_professors(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'faculty_in_the_news_categories',
			[
				'label'        => __( 'Select Faculty in the News Categories', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_categories(),
				'default' => [ ],
			]
		);
		
		$this->add_control(
			'show_selected_post_categories',
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
			'selected_faculty_in_the_news',
			[
				'label'        => __( 'Select Faculty in the News', 'elementhelper' ),
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
		
		$faculty_as_tagId = 0;
		$faculty_tag_detail = null;
		if( ! empty ( $settings['faculty_in_the_news_name']) ) {
			$this_tag_id = get_the_tags(intval($settings['faculty_in_the_news_name']));
			$faculty_as_tagId = $this_tag_id ? $this_tag_id[0]->term_id : 0;
			$faculty_tag_detail = get_post(intval($settings['faculty_in_the_news_name']));
			$faculty_tag_detail->professor_first_name = get_post_meta($faculty_tag_detail->ID, 'professor_first_name')[0];
			$faculty_tag_detail->professor_last_name = get_post_meta($faculty_tag_detail->ID, 'professor_last_name')[0];
			$faculty_tag_detail->professor_page_link = get_post_meta($faculty_tag_detail->ID, 'professor_page_link')[0];
			//var_dump($faculty_tag_detail->professor_first_name);
		}
		
		$args = array(
			'post_type' => 'faculty_news',
			'post_status' => 'publish',
			'numberposts' => $max_count,
			//'meta_key' => 'faculty_news_date',
			//'orderby' => 'meta_value_num',
			//'meta_type' => 'DATE',
			'order' => 'DESC',
		);
		if( ! empty ( $settings['faculty_in_the_news_categories'] ) ) {
			$args['category__and'] = $settings['faculty_in_the_news_categories'];
		} else if( ! empty ( $settings['selected_faculty_in_the_news']) ) {
			$args['include'] = $settings['selected_faculty_in_the_news'];
		} else if( $faculty_as_tagId ) {
			$args['tag__in'] = $faculty_as_tagId;
		} 
		
		//var_dump($args);
		$faculty_in_the_news = get_posts($args);
		foreach( $faculty_in_the_news as $each_fitn) {
			$this->get_more_faculty_in_the_news_info($each_fitn);
		}
		//var_dump($faculty_in_the_news);
		?>

		<div class="faculty-in-the-news-wrapper <?php echo $settings['module_class']; ?>">
			<?php if ( ! empty( $settings['title'] ) ): ?>
			<div class="faculty-in-the-news-title">
				<?php echo '<' . $settings['title_tag'] . ' class="title">'; ?>
					<span><?php echo $settings['title'] ?></span>
				<?php echo '</' . $settings['title_tag'] . '>'; ?>
			</div>
			<?php endif; ?>
			<ul class="row list-unstyled">
				<?php foreach($faculty_in_the_news as $faculty_news) { ?>
				<?php 
				$this_post_categories = get_the_category($faculty_news->ID);
				$selected_post_categories = [];
				if( $settings['show_selected_post_categories'] === 'yes' ) {
					foreach( $this_post_categories as $this_post_category ) {
						//var_dump($this_post_category->term_id);
						if(in_array($this_post_category->term_id, $settings['faculty_in_the_news_categories'])) {
							array_push($selected_post_categories, $this_post_category);
						}
					}
				}
				?>
				<li class="col-sm-4">
					<div class="fd-quoted-item">
						<div class="fd-quote-faculty">
							<?php if( ! empty($faculty_news->faculty_first_name) || ! empty($faculty_news->faculty_last_name) ) { ?>
							<a href="<?php echo $faculty_news->faculty_permalink; ?>"><?php echo $faculty_news->faculty_first_name . ' ' . $faculty_news->faculty_last_name; ?></a>
							<?php } ?>
						</div>
						<?php if( count($selected_post_categories) || !empty( $faculty_tag_detail ) ) { ?>
						<div class="fd-quoted-tags">
						<?php foreach( $selected_post_categories as $selected_post_category ) { ?>
							<a href="#" class="fd-quoted-tag-link"><?php echo $selected_post_category->cat_name ; ?></a>
						<?php } ?>
						<?php if( !empty( $faculty_tag_detail ) ) { ?>
							<a href="<?php echo $faculty_tag_detail->professor_page_link; ?>" class="fd-quoted-tag-link"><?php echo $faculty_tag_detail->professor_first_name . ' ' . $faculty_tag_detail->professor_last_name ; ?></a>
						<?php } ?>
						</div>
						<?php } ?>
						<div class="fd-quoted-title">
							<?php echo $faculty_news->faculty_news_title; ?>
						</div>
						<div class="fd-quoted-date">
							<?php echo $faculty_news->faculty_source; ?> 
							<!--&bull; <?php echo date_format(date_create($faculty_news->faculty_news_date), "F j, Y"); ?></1--&bull;>-->
						</div>
						<div class="fd-quoted-more">
							<a href="<?php echo $faculty_news->faculty_news_link; ?>" target="_blank" aria-label="Click to read more about <?php echo $faculty_news->faculty_news_title; ?>">Read More <img src="/wp-content/uploads/2023/03/icon-right-arrow.png" alt="Right arrow icon" /></a>
						</div>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>

		<?php
	}

}