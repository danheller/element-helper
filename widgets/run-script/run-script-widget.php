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

class Run_Script extends Element_El_Widget {

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
		return 'run-script';
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
		return __( 'Run Script', 'elementhelper' );
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
		return 'eicon-video-camera';
	}

	public function get_keywords() {
		return [ 'run', 'script' ];
	}

	/**
	 * Register content related controls
	 */
	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Import Properties', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {

		$this->start_controls_section(
			'_section_media_style',
			[
				'label' => __( 'Icon / Image', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Style Tab', 'elementhelper' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->end_controls_section();

	}
	
	protected function get_all_faculty_news() {
		return get_posts([
			'post_type' => 'faculty_news',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function update_faculty_news_publish_date() {
		$dbNews = $this->get_all_faculty_news();
		var_dump(count($dbNews));
		$runUpdate = false;
		foreach ( $dbNews as $news ) {
			$import_date = get_gmt_from_date(get_post_meta( $news->ID, 'faculty_news_date', true ));
			if($runUpdate) {
				wp_update_post(
					array (
						'ID' => $news->ID, // ID of the post to update
						'post_date' => $import_date,
						'post_date_gmt' => $import_date
					)
				);
				var_dump($news->post_title, $import_date, get_gmt_from_date( $import_date )); echo '<br /><br />';
			}
		}
	}
	
	protected function get_all_posts($num=-1) {
		return get_posts([
			'post_type' => 'post',
			'post_status' => 'publish',
			'numberposts' => $num,
			'order'    => 'DESC',
		]);
	}
	
	protected function get_all_news() {
		return get_posts([
			'post_type' => 'news',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'DESC',
		]);
	}
	
	protected function get_all_faculties() {
		return get_posts([
			'post_type' => 'professors',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function get_all_lecturers() {
		return get_posts([
			'post_type' => 'lecturers',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function get_all_courses() {
		return get_posts([
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function get_all_publications() {
		return get_posts([
			'post_type' => 'publication',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function get_all_bad() {
		return get_posts([
			'post_type' => 'bad',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function update_posts_publish_date() {
		$dbposts = $this->get_all_posts();
		var_dump(count($dbposts));
		$runUpdate = false;
		foreach ( $dbposts as $post ) {
			$import_date = get_gmt_from_date(get_post_meta( $post->ID, 'news_date', true ));
			if($runUpdate) {
				wp_update_post(
					array (
						'ID' => $post->ID, // ID of the post to update
						'post_date' => $import_date,
						'post_date_gmt' => $import_date
					)
				);
				var_dump($post->post_title, $import_date, get_gmt_from_date( $import_date )); echo '<br /><br />';
			}
		}
	}
	
	protected function get_single_post($post_type, $post_id) {
		return get_posts([
			'post_type' => $post_type,
			'post_status' => 'publish',
			'numberposts' => 1,
			'p' => $post_id,
			'order'    => 'ASC',
		]);
	}
	
	protected function update_faculty_news_body() {
		$dbNews = $this->get_all_faculty_news();
		var_dump(count($dbNews));
		$runLoop = false;
		$runUpdate = false;
		//$thisPost = $this->get_single_post('faculty_news', 6935);
		//var_dump($thisPost);
		if($runLoop) {
			foreach ( $dbNews as $news ) {
				$import_date = get_gmt_from_date(get_post_meta( $news->ID, 'faculty_news_date', true ));
				if($runUpdate) {
					wp_update_post(
						array (
							'ID' => $news->ID, // ID of the post to update
							'post_date' => $import_date,
							'post_date_gmt' => $import_date
						)
					);
					//var_dump($news->post_title, $import_date, get_gmt_from_date( $import_date )); echo '<br /><br />';
				}
				//var_dump($news->post_title, $import_date, get_gmt_from_date( $import_date )); echo '<br /><br />';
			}			
		}
	}
	
	protected function migrate_usc_pages() {
		$urlStr = 'https://gould.usc.edu/academics/certificates/business/';
		var_dump($urlStr);
		//echo phpinfo();
		$html = file_get_contents($urlStr);
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$xpath = new DOMXpath($dom);
		$result = $xpath->query('//div[@id="center_column"]');
		if ($result->length > 0) {
			var_dump($result->item(0)->nodeValue);
		}
		function innerHTML(\DOMElement $element)
		{
			$doc = $element->ownerDocument;
			$html = '';
			foreach ($element->childNodes as $node) {
				//var_dump($node); echo '<br /><br />';
				$html .= $doc->saveHTML($node);
			}
			return $html;
		}
		function innerHTML2( \DOMNode $n, $include_target_tag = true ) {
		  $doc = new \DOMDocument();
		  $doc->appendChild( $doc->importNode( $n, true ) );
		  $html = trim( $doc->saveHTML() );
		  if ( $include_target_tag ) {
			  return $html;
		  }
		  return preg_replace( '@^<' . $n->nodeName .'[^>]*>|</'. $n->nodeName .'>$@', '', $html );
		}
		$urlStr = 'https://gould.usc.edu/academics/certificates/business/';
		$html = file_get_contents($urlStr);
		$dom = new DOMDocument();
		$dom->loadHtml($html);
		$xhtml = innerHTML($dom->getElementById('center_column'));
		//echo $xhtml;

	}
	
	protected function get_faculty_tag_id( $name) {
		$faculty_tag_id = get_term_by('name', $name, 'post_tag');
		//var_dump('$faculty_tag_id', $faculty_tag_id); echo '<br />';
		if($faculty_tag_id === false) {
			//echo 'new'; echo '<br />';
			$faculty_tag_id = wp_insert_term($name, 'post_tag');
			$new_faculty_tag_id = $faculty_tag_id['term_id'];
			//echo 'created';
		} else {
			//echo 'retrieve'; echo '<br />';
			$new_faculty_tag_id = $faculty_tag_id->term_id;
		}
		return $new_faculty_tag_id;
	}
	
	protected function updateProfessorTagId() {
		$all_faculty = get_posts([
			'post_type' => 'professors',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
		return;
		//var_dump($all_faculty);
		foreach( $all_faculty as $this_faculty ) {
			$faculty_tag_id = get_post_meta($this_faculty->ID, 'professor_tag_id');
			$faculty_name = get_post_meta($this_faculty->ID, 'professor_full_name');
			var_dump($faculty_tag_id); echo '<br />';
			if(!empty($faculty_tag_id[0])) {
				$new_faculty_tag_id = $faculty_tag_id[0];
				if(is_array($faculty_tag_id[0])) {
					$new_faculty_tag_id = (string) $faculty_tag_id[0]['term_id'];
				} else {
					$new_faculty_tag_id = $faculty_tag_id[0];
				}
				update_post_meta($this_faculty->ID, 'professor_tag_id', $new_faculty_tag_id);
				wp_set_object_terms($this_faculty->ID, intval($new_faculty_tag_id), 'post_tag', true);
				var_dump($faculty_name[0], $this_faculty->ID, $faculty_tag_id, $new_faculty_tag_id); echo '<br /><br />';
			} else {
				$new_faculty_tag_id = $this->get_faculty_tag_id($faculty_name[0]);
				var_dump('empty', $faculty_name[0], $new_faculty_tag_id); echo '<br />';
				update_post_meta( $this_faculty->ID, 'professor_tag_id', $new_faculty_tag_id );
				wp_set_object_terms($this_faculty->ID, $new_faculty_tag_id, 'post_tag', true);
				var_dump($new_faculty_tag_id); echo '<br />';
			}
		}
	}
	
	protected function updateCourseProfessorTagId() {
		$all_courses = get_posts([
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
		return;
		//$all_courses = array_slice($all_courses, 0, 5);
		foreach( $all_courses as $this_course ) {
			$faculty_tag_ids = get_post_meta($this_course->ID, 'course_professors');
			//var_dump(get_the_tags($this_course->ID));
			//var_dump($this_course->post_title, $new_faculty_tag_id); echo '<br />';
			if(is_array($faculty_tag_ids[0])) {
				foreach($faculty_tag_ids[0] as $idx => $this_faculty_id) {
					$thisTagId = get_the_tags(intval($this_faculty_id));
					var_dump($this_course->post_title, intval($this_faculty_id), $thisTagId[0]->term_id); echo '<br />';
					wp_set_object_terms($this_course->ID, $thisTagId[0]->term_id, 'post_tag', true);
				}
				//wp_set_object_terms($this_course->ID, $faculty_tag_ids[0], 'post_tag', true);
			}
		}
	}
	
	protected function updateFacultyNewsProfessorTagId() {
		$all_faculty_news = get_posts([
			'post_type' => 'faculty_news',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
		return;
		//$all_faculty_news = array_slice($all_faculty_news, 0, 10);
		//var_dump($all_faculty_news);
		//return;
		foreach( $all_faculty_news as $this_faculty_news ) {
			$faculty_fname = get_post_meta($this_faculty_news->ID, 'faculty_first_name');
			$faculty_lname = get_post_meta($this_faculty_news->ID, 'faculty_last_name');
			if(!empty($faculty_fname[0]) && !empty($faculty_lname[0])) {
				$faculty_name = $faculty_fname[0] . ' ' . $faculty_lname[0];
				//var_dump($this_faculty_news->post_title, $faculty_name); echo '<br />';
				$new_faculty_tag_id = $this->get_faculty_tag_id($faculty_name);
				//wp_set_object_terms($this_faculty_news->ID, $new_faculty_tag_id, 'post_tag', true);
				var_dump($this_faculty_news->post_title, $faculty_name, $new_faculty_tag_id); echo '<br />';
			}
		}
	}
	
	protected function checkPage() {
		//function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
		//$my_wp_query = new \WP_Query();
		//$all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'numberposts' => -1));
		//$thisPerm = get_permalink(8005);
		//$thisPages = get_page_children(8005, $all_wp_pages);
		// 84021
		$all_wp_pages = get_pages();
		$frontend = new \Elementor\Frontend();
		//var_dump(count($all_wp_pages));
		foreach ( $all_wp_pages as $idx => $eachpage ) {
			$elemPage = $frontend->get_builder_content_for_display( $eachpage->ID, $with_css = true );
			//var_dump($idx,str_contains($elemPage, 'http://goulddev.usc.edu'));
			if(!in_array($eachpage->post_parent, [1527,46515,8088]) && str_contains($elemPage, 'http://') && !str_contains($elemPage, 'http://www.w3.org/')  ) {
				$thisPerm = get_permalink($eachpage->ID);
				echo '<strong>' . $idx . '-' . $eachpage->post_parent . '-' . $eachpage->ID . '-' . $eachpage->post_title . '</strong><br />';
				echo $thisPerm . '<br />';
				//var_dump($elemPage);
				//$template_metas = get_post_meta($eachpage->ID);
				//var_dump($elemPage);
				//var_dump($eachpage->post_content);
				//var_dump($thisPerm, $eachpage->ID, $eachpage->post_title);  echo '<br />';
			}
		}
	}
	
	protected function checkPosts() {
		//function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
		//$my_wp_query = new \WP_Query();
		//$all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'numberposts' => -1));
		//$thisPerm = get_permalink(8005);
		//$thisPages = get_page_children(8005, $all_wp_pages);
		// 84021
		$all_wp_pages = get_posts( array('numberposts' => -1, 'post_type' => 'news') );
		$frontend = new \Elementor\Frontend();
		//var_dump(count($all_wp_pages));
		foreach ( $all_wp_pages as $idx => $eachpage ) {
			$thisNewsBody = get_post_meta( $eachpage->ID, 'news_body', true );
			if( str_contains($thisNewsBody, 'http://goulddev.usc.edu') ) {
				$thisPerm = get_permalink($eachpage->ID);
				echo '<strong>' . $idx . '-' . $eachpage->ID . '-' . $eachpage->post_title . '</strong><br />';
				echo $thisPerm . '<br />';
				//var_dump($elemPage);
				//$template_metas = get_post_meta($eachpage->ID);
				//var_dump($elemPage);
				//var_dump($eachpage->post_content);
				//var_dump($thisPerm, $eachpage->ID, $eachpage->post_title);  echo '<br />';
			}
		}
	}
	
	protected function copyPostToNews() {
		$dbposts = $this->get_all_posts();
		
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/news-design02.php' );
		$runUpdate = false;
		foreach ( $dbposts as $post ) {
			$curPostID = $post->ID;
			$post_categories = wp_get_post_categories( $curPostID );
			$post_tagsWP = wp_get_post_tags($curPostID);
			$post_tags = array();
			foreach($post_tagsWP as $idx => $post_tag) {
				$post_tags[] = $post_tag->name;
			}
			$post->ID = 0;
			$post->post_type = 'news';
			//var_dump($post_tags); echo '<br /><br />';
			if($runUpdate) {
				$postID = wp_insert_post($post);
				update_post_meta( $postID, '_wp_page_template', 'page-templates/news-design02.php' );
				update_post_meta( $postID, 'news_id', get_post_meta( $curPostID, 'news_id', true ) );
				update_post_meta( $postID, 'news_title', get_post_meta( $curPostID, 'news_title', true ) );
				update_post_meta( $postID, 'news_image', get_post_meta( $curPostID, 'news_image', true ) );
				update_post_meta( $postID, 'news_header_body_by', (get_post_meta( $curPostID, 'news_header_body_by', true ) === '' ? 'USC Gould School of Law' : get_post_meta( $curPostID, 'news_header_body_by', true )) ) ;
				update_post_meta( $postID, 'news_body', get_post_meta( $curPostID, 'news_body', true ) );
				update_post_meta( $postID, 'news_display', get_post_meta( $curPostID, 'news_display', true ) );
				update_post_meta( $postID, 'news_date', get_post_meta( $curPostID, 'news_date', true ) );
				update_post_meta( $postID, 'news_brief_description', get_post_meta( $curPostID, 'news_brief_description', true ) );
				update_post_meta( $postID, 'news_meta_description', get_post_meta( $curPostID, 'news_meta_description', true ) );
				update_post_meta( $postID, 'news_meta_robots', get_post_meta( $curPostID, 'news_meta_robots', true ) );
				wp_set_post_categories($postID, $post_categories);
				wp_set_post_tags( $postID, $post_tags);
			}
		}
	}
	
	protected function moveLecturerFromFaculty() {
		$dbposts = $this->get_all_faculties();
		var_dump($dbposts[0]);
		//update_post_meta( $allFaculties[0]->ID, '_wp_page_template', 'page-templates/faculty-design01.php' );
		$runUpdate = false;
		foreach ( $dbposts as $post ) {
			//update_post_meta( $thisFaculty->ID, '_wp_page_template', 'page-templates/faculty-design01.php' );
			$curPostID = $post->ID;
			$post_categories = wp_get_post_categories( $curPostID );
			$post_tagsWP = wp_get_post_tags($curPostID);
			$post_tags = array();
			foreach($post_tagsWP as $idx => $post_tag) {
				$post_tags[] = $post_tag->name;
			}
			$post->ID = 0;
			$post->post_type = 'lecturers';
			$thisType = get_post_meta( $curPostID, 'professor_type', true );
			//var_dump($thisType,$post); echo '<br /><br />';
			if($thisType === 'Lecturer in Law') {
				//$postToDraft = array( 'ID' => $curPostID, 'post_status' => 'draft' );
				//wp_update_post($postToDraft);
				//var_dump(get_post_meta( $curPostID, 'professor_full_name', true )); echo '<br />';
			if($runUpdate) {
				$postID = wp_insert_post($post);
				update_post_meta( $postID, '_wp_page_template', 'page-templates/faculty-design01.php' );
				update_post_meta( $postID, 'unique_id', get_post_meta( $curPostID, 'unique_id', true ) );
				update_post_meta( $postID, 'professor_first_name', get_post_meta( $curPostID, 'professor_first_name', true ) );
				update_post_meta( $postID, 'professor_middle_name', get_post_meta( $curPostID, 'professor_middle_name', true ) );
				update_post_meta( $postID, 'professor_last_name', get_post_meta( $curPostID, 'professor_last_name', true ) );
				update_post_meta( $postID, 'professor_full_name', get_post_meta( $curPostID, 'professor_full_name', true ) );
				update_post_meta( $postID, 'professor_page_link', get_post_meta( $curPostID, 'professor_page_link', true ) );
				update_post_meta( $postID, 'professor_division', (get_post_meta( $curPostID, 'professor_division', true ) === '' ? 'USC Gould School of Law' : get_post_meta( $curPostID, 'professor_division', true )) ) ;
				update_post_meta( $postID, 'professor_title', get_post_meta( $curPostID, 'professor_title', true ) );
				update_post_meta( $postID, 'professor_type', get_post_meta( $curPostID, 'professor_type', true ) );
				update_post_meta( $postID, 'professor_email', get_post_meta( $curPostID, 'professor_email', true ) );
				update_post_meta( $postID, 'professor_phone', get_post_meta( $curPostID, 'professor_phone', true ) );
				update_post_meta( $postID, 'professor_direct_line', get_post_meta( $curPostID, 'professor_direct_line', true ) );
				update_post_meta( $postID, 'professor_fax', get_post_meta( $curPostID, 'professor_fax', true ) );
				update_post_meta( $postID, 'professor_room', get_post_meta( $curPostID, 'professor_room', true ) );
				update_post_meta( $postID, 'professor_personal_website', get_post_meta( $curPostID, 'professor_personal_website', true ) );
				update_post_meta( $postID, 'professor_google_scholar_profile', get_post_meta( $curPostID, 'professor_google_scholar_profile', true ) );
				update_post_meta( $postID, 'professor_ssrn_author_page', get_post_meta( $curPostID, 'professor_ssrn_author_page', true ) );
				update_post_meta( $postID, 'professor_download_curriculum_vitae', get_post_meta( $curPostID, 'professor_download_curriculum_vitae', true ) );
				update_post_meta( $postID, 'professor_image', get_post_meta( $curPostID, 'professor_image', true ) );
				update_post_meta( $postID, 'professor_last_updated', get_post_meta( $curPostID, 'professor_last_updated', true ) );
				update_post_meta( $postID, 'professor_biography', get_post_meta( $curPostID, 'professor_biography', true ) );
				update_post_meta( $postID, 'professor_publications', get_post_meta( $curPostID, 'professor_publications', true ) );
				update_post_meta( $postID, 'professor_inactive', get_post_meta( $curPostID, 'professor_inactive', true ) );
				update_post_meta( $postID, 'professor_office_hours', get_post_meta( $curPostID, 'professor_office_hours', true ) );
				update_post_meta( $postID, 'professor_keywords', get_post_meta( $curPostID, 'professor_keywords', true ) );
				update_post_meta( $postID, 'professor_summary_of_expertise', get_post_meta( $curPostID, 'professor_summary_of_expertise', true ) );
				update_post_meta( $postID, 'professor_tag_id', get_post_meta( $curPostID, 'professor_tag_id', true ) );
				update_post_meta( $postID, 'professor_spotlight', get_post_meta( $curPostID, 'professor_spotlight', true ) );
				update_post_meta( $postID, 'professor_education', get_post_meta( $curPostID, 'professor_education', true ) );
				update_post_meta( $postID, 'professor_affiliation', get_post_meta( $curPostID, 'professor_affiliation', true ) );
				update_post_meta( $postID, 'professor_twitter', get_post_meta( $curPostID, 'professor_twitter', true ) );
				update_post_meta( $postID, 'professor_linkedln', get_post_meta( $curPostID, 'professor_linkedln', true ) );
				wp_set_post_categories($postID, $post_categories);
				wp_set_post_tags( $postID, $post_tags);
			}
			}
		}
	}
	
	function updateCourseDetailsFaculty() {
		$dbposts = $this->get_all_courses();
		//var_dump($dbposts);
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/courses-design01.php' );
		exit;
		foreach($dbposts as $idx => $post) {
			$curPostID = $post->ID;
			$postTitle = get_post_meta( $curPostID, 'course_name', true );
			$postFaculty = get_post_meta( $curPostID, 'course_professors', true );
			var_dump($postTitle); echo '<br />';
			$foundLecturer = false;
			$newPostFaculty = [];
			foreach($postFaculty as $i => $facId) {
				$thisFac = get_posts([
					'post_type' =>  ['professors','lecturers'],
					'post_status' => ['publish','draft'],
					'p' => intval($facId),
				]);
				if($thisFac[0]->post_status === 'publish') {
					$newPostFaculty[] = intval($facId);
				} else {
					$foundLecturer = true;
					$post_id = get_page_by_title($thisFac[0]->post_title, OBJECT, 'lecturers');
					$newPostFaculty[] = intval($post_id->ID);
					var_dump($facId, $post_id); echo '<br />';
				}
			}
			if($foundLecturer) {
				var_dump('new', $newPostFaculty);
				//update_post_meta( $curPostID, 'course_professors', $newPostFaculty );
			}
			echo '<br /><br />';
		}
	}
	
	function updatePublicationTemplate() {
		$dbposts = $this->get_all_publications();
		//var_dump($dbposts);
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/publication-design01.php' );
		foreach($dbposts as $idx => $post) {
			$curPostID = $post->ID;
			update_post_meta( $curPostID, '_wp_page_template', 'page-templates/publication-design01.php' );
		}
	}
	
	function updatePublicationYear() {
		$dbposts = $this->get_all_publications();
		//var_dump($dbposts);
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/publication-design01.php' );
		$runUpdate = false;
		$countDo = 0;
		$countDont = 0;
		foreach($dbposts as $idx => $post) {
			$curPostID = $post->ID;
			$thisPostYear = get_post_meta( $curPostID, 'publication_date', true );
			if(!empty($thisPostYear)) {
				$countDo++;
				$thisPostPublishDate = get_the_date('', $curPostID);
				//echo $idx . '-' . $thisPostYear . '-' . $thisPostPublishDate . '-' . $post->post_title . '<br />';
				if($runUpdate) {
					wp_update_post(
						array (
							'ID' => $post->ID, // ID of the post to update
							'post_date' => $import_date,
							'post_date_gmt' => $import_date
						)
					);
					var_dump($post->post_title, $import_date, get_gmt_from_date( $import_date )); echo '<br /><br />';
				}
			} else {
				$countDont++;
			}
			//update_post_meta( $curPostID, '_wp_page_template', 'page-templates/publication-design01.php' );
		}
		var_dump($countDo, $countDont);
	}
		
	function updateNewsImageDomain() {
		$dbposts = $this->get_all_news();
		//var_dump(count($dbposts));
		//$output = array_slice($dbposts, 0, 5);
		$runUpdate = false;
		$gouldDomain = 'https://gould.usc.edu';
		foreach ( $dbposts as $post ) {
			$curPostID = $post->ID;
			$thisNewsBody = get_post_meta( $curPostID, 'news_body', true );
			
			preg_match_all('/<img[^>]+>/i',$thisNewsBody, $imgTags);
			for ($i = 0; $i < count($imgTags[0]); $i++) {
				// get the source string
				preg_match('/src="([^"]+)/i',$imgTags[0][$i], $imgage);
				// remove opening 'src=' tag, can`t get the regex right
				$thisImgSrc = str_ireplace( 'src="', '',  $imgage[0]);
				$origImageSrc[] = $thisImgSrc;
				if(!empty($thisImgSrc)) {
					if(strpos($thisImgSrc, $gouldDomain) === false && strpos($thisImgSrc, 'http') === false) {
						$newImgSrc = $gouldDomain . $thisImgSrc;
						$thisNewsBody = str_replace($thisImgSrc, $newImgSrc, $thisNewsBody);
						update_post_meta( $curPostID, 'news_body', $thisNewsBody );
						//var_dump($curPostID, $thisImgSrc, $newImgSrc); echo '<br />';
					}
				}
				//echo '<br /><br />';
			}
			//echo $thisNewsBody;
		}
		//var_dump($origImageSrc); echo '<br /><br />';
	}
	
	protected function update_posts_news_display() {
		$dbposts = $this->get_all_news();
		//var_dump(count($dbposts));
		$runUpdate = false;
		foreach ( $dbposts as $post ) {
			$news_display = get_post_meta( $post->ID, 'news_display', true );
			if($news_display === '0') {
			var_dump($post->post_title, $news_display); echo '<br /><br />';
			}
			if($news_display === '0' && $runUpdate) {
				wp_update_post(
					array (
						'ID' => $post->ID, // ID of the post to update
						'post_status' => 'draft'
					)
				);
				var_dump($post->post_title, $import_date, get_gmt_from_date( $import_date )); echo '<br /><br />';
			}
		}
	}
	
	protected function updateFacultyPubOrder() {
		$dbposts = $this->get_all_faculties();
		//var_dump(count($dbposts));
		$runUpdate = false;
		foreach ( $dbposts as $post ) {
			$curPostID = $post->ID;
			$facultyOrder = get_post_meta( $curPostID, 'professor_selected_works_order', true );
			var_dump($facultyOrder); echo '<br /><br />';
			if($runUpdate) {
				update_post_meta( $curPostID, 'professor_selected_works_order', '' );
			}
		}
	}
	
	protected function migrateNewsCategories() {
		$dbposts = $this->get_all_posts();
		$dbNewsPosts = $this->get_all_news();
		$newsByTitle = array();
		$notFoundBySubject = array();
		$foundBySubject = array();
		foreach ( $dbNewsPosts as $idx => $newsPost ) {
			$newsByTitle[$newsPost->post_title] = $newsPost->ID;
		}
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/news-design02.php' );
		$runUpdate = false;
		foreach ( $dbposts as $post ) {
			$curPostID = $post->ID;
			$post_categories = wp_get_post_categories( $curPostID );
			//$post_tagsWP = wp_get_post_tags($curPostID);
			//$post_tags = array();
			//foreach($post_tagsWP as $idx => $post_tag) {
			//	$post_tags[] = $post_tag->name;
			//}
			//var_dump($post_tags); echo '<br /><br />';
			
			if($newsByTitle[$post->post_title] === NULL) {
				$notFoundBySubject[] = $post->post_title;
			} else {
				$foundBySubject[] = $post->post_title;
				var_dump($post->ID,$post->post_title); echo '<br />';
				var_dump($post_categories); echo '<br />';
				var_dump($newsByTitle[$post->post_title]); echo '<br />'; echo '<br />';
				if($runUpdate) {
					wp_set_post_categories($newsByTitle[$post->post_title], $post_categories);
					//wp_set_post_tags( $postID, $post_tags);
				}
			}
		}
		//var_dump(count($foundBySubject));
	}
	
	function mergePublications($postTitle, $pubs) {
		$isInsert = false;
		echo $postTitle . '<br />';
		$new = array(
			'post_title' => $postTitle,
			'post_status' => 'publish',
			'post_type' => 'bad'
		);
		if($isInsert) {
			$postID = wp_insert_post($new);
			update_post_meta( $postID, '_wp_page_template', 'page-templates/publication-design01.php' );
		}
		$thisIdx = 0;
		foreach($pubs as $idx => $pub) {
			$textType = get_post_meta( $pub->ID, 'publication_text_type', true );
			$textTypeUrl = get_post_meta( $pub->ID, 'publication_url', true );
			if($thisIdx === 0) {
				//var_dump($idx, $pub);
				$tagObj = get_the_tags( $pub->ID );
				$tagName = ! empty ($tagObj) ? $tagObj[0]->name : '';
				$thisCatIds = wp_get_post_categories($pub->ID);
				//var_dump($textType,$textTypeUrl);
				if($isInsert) {
					wp_set_post_tags( $postID, $tagName);
					wp_set_post_categories( $postID, $thisCatIds );
					update_post_meta( $postID, 'publication_text', get_post_meta( $pub->ID, 'publication_text', true ) );
					update_post_meta( $postID, 'publication_author', get_post_meta( $pub->ID, 'publication_author', true ) );
					update_post_meta( $postID, 'publication_description', get_post_meta( $pub->ID, 'publication_description', true ) );
					update_post_meta( $postID, 'publication_publisher', get_post_meta( $pub->ID, 'publication_publisher', true ) );
					update_post_meta( $postID, 'publication_date', get_post_meta( $pub->ID, 'publication_date', true ) );
					update_post_meta( $postID, 'publication_hosted_internally', get_post_meta( $pub->ID, 'publication_hosted_internally', true ) );
					update_post_meta( $postID, 'publication_internal_link', get_post_meta( $pub->ID, 'publication_internal_link', true ) );
				}
			}
			if($isInsert && !empty($textType) && !empty($textTypeUrl)) {
				if($textType === 'ssrn') {
					update_post_meta( $postID, 'publication_ssrn_link', $textTypeUrl );					
				} else if($textType === 'bepress') {
					update_post_meta( $postID, 'publication_bepress_link', $textTypeUrl );					
				} else if($textType === 'hein') {
					update_post_meta( $postID, 'publication_hein_link', $textTypeUrl );					
				} else if($textType === 'pdf') {
					update_post_meta( $postID, 'publication_pdf_link', $textTypeUrl );					
				} else {
					update_post_meta( $postID, 'publication_www_link', $textTypeUrl );					
				}
			} else if($isInsert && empty($textType) && !empty($textTypeUrl)) {
				update_post_meta( $postID, 'publication_www_link', $textTypeUrl );					
			}
			//var_dump($textType,$textTypeUrl); echo '<br />';
			if(empty($textType) && !empty($textTypeUrl)) {
				//echo $postTitle . '<br />';
				//var_dump($textType,$textTypeUrl); echo '<br />';
			}
			$thisIdx++;
		}
	}
	
	function updatePublicationDataToBad() {
		$dbposts = $this->get_all_publications();
		//var_dump($dbposts);
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/publication-design01.php' );
		$groupBySubject = array();
		$newGroupBySubject = array();
		foreach($dbposts as $idx => $post) {
			$curPostID = $post->ID;
			if($groupBySubject[$post->post_title] === NULL) {
				$groupBySubject[$post->post_title] = array();
			}
			$groupBySubject[$post->post_title][] = $post;
		}
		$index = 0;
		foreach($groupBySubject as $postTitle => $dataSubject) {
			if(true || $index < 10) {
				$newGroupBySubject[$subject] = $this->mergePublications($postTitle,$dataSubject);
				$index++;
			}
		}
		//var_dump($this->pubType);
	}
	
	function movePublicationToDraft() {
		$dbposts = $this->get_all_publications();
		//var_dump($dbposts);
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/publication-design01.php' );
		foreach($dbposts as $idx => $post) {
			$curPostID = $post->ID;
			$post = array( 'ID' => $curPostID, 'post_status' => 'draft' );
			//wp_update_post($post);
		}
		
	}
	
	function moveBadToPublication() {
		$dbposts = $this->get_all_bad();
		//var_dump($dbposts);
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/publication-design01.php' );
		$isInsert = false;
		$thisIdx = 0;
		foreach($dbposts as $idx => $post) {
			$curPostID = $post->ID;
			$postTitle = $post->post_title;
			//$isInsert = $thisIdx === 0;
			echo $postTitle . '<br />';
			$new = array(
				'post_title' => $postTitle,
				'post_status' => 'publish',
				'post_type' => 'publication'
			);
			if($isInsert) {
				$postID = wp_insert_post($new);
				update_post_meta( $postID, '_wp_page_template', 'page-templates/publication-design01.php' );
			}
			$tagObj = get_the_tags( $post->ID );
			$tagName = ! empty ($tagObj) ? $tagObj[0]->name : '';
			$thisCatIds = wp_get_post_categories($post->ID);
			var_dump($tagName,$thisCatIds); echo '<br /><br />';
			if($isInsert) {
				wp_set_post_tags( $postID, $tagName);
				wp_set_post_categories( $postID, $thisCatIds );
				update_post_meta( $postID, 'publication_text', get_post_meta( $post->ID, 'publication_text', true ) );
				update_post_meta( $postID, 'publication_author', get_post_meta( $post->ID, 'publication_author', true ) );
				update_post_meta( $postID, 'publication_description', get_post_meta( $post->ID, 'publication_description', true ) );
				update_post_meta( $postID, 'publication_publisher', get_post_meta( $post->ID, 'publication_publisher', true ) );
				update_post_meta( $postID, 'publication_date', get_post_meta( $post->ID, 'publication_date', true ) );
				update_post_meta( $postID, 'publication_ssrn_link', get_post_meta( $post->ID, 'publication_ssrn_link', true ) );
				update_post_meta( $postID, 'publication_bepress_link', get_post_meta( $post->ID, 'publication_bepress_link', true ) );
				update_post_meta( $postID, 'publication_hein_link', get_post_meta( $post->ID, 'publication_hein_link', true ) );
				update_post_meta( $postID, 'publication_www_link', get_post_meta( $post->ID, 'publication_www_link', true ) );
				update_post_meta( $postID, 'publication_pdf_link', get_post_meta( $post->ID, 'publication_pdf_link', true ) );
				update_post_meta( $postID, 'publication_hosted_internally', get_post_meta( $post->ID, 'publication_hosted_internally', true ) );
				update_post_meta( $postID, 'publication_internal_link', get_post_meta( $post->ID, 'publication_internal_link', true ) );

				update_post_meta( $postID, 'publication_type', get_post_meta( $post->ID, 'publication_type', true ) );
				update_post_meta( $postID, 'publication_unique_key', get_post_meta( $post->ID, 'publication_unique_key', true ) );
				update_post_meta( $postID, 'author_unique_id', get_post_meta( $post->ID, 'author_unique_id', true ) );
				update_post_meta( $postID, 'author_last_name', get_post_meta( $post->ID, 'author_last_name', true ) );
				update_post_meta( $postID, 'author_first_name', get_post_meta( $post->ID, 'author_first_name', true ) );
				update_post_meta( $postID, 'publication_section_title', get_post_meta( $post->ID, 'publication_section_title', true ) );
				update_post_meta( $postID, 'publication_text_type', get_post_meta( $post->ID, 'publication_text_type', true ) );
				update_post_meta( $postID, 'publication_url', get_post_meta( $post->ID, 'publication_url', true ) );
			}
			$thisIdx++;
		}
		
	}
	
	function getPageWithFacultyLink() {
		$dbposts = get_pages();
		//var_dump($dbposts);
		//update_post_meta( $dbposts[0]->ID, '_wp_page_template', 'page-templates/publication-design01.php' );
		foreach($dbposts as $idx => $post) {
			$curPostID = $post->ID;
			if(str_contains($post->post_content, 'https://gould.usc.edu/faculty/?id=')) {
				$thisPermalink = get_permalink($curPostID);
				echo $post->post_title . ' - ' . $thisPermalink . '<br />';
				//var_dump($post);
			}
		}
		
	}
	
	protected function get_all_scholarships() {
		return get_posts([
			'post_type' => 'faculty-scholarship',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	function update_scholarship_publish_date() {
		$dbPosts = $this->get_all_scholarships();
		var_dump(count($dbPosts));
		$runUpdate = false;
		foreach ( $dbPosts as $post ) {
			$import_date = get_gmt_from_date(get_post_meta( $post->ID, 'scholarship_publish_date', true ));
			if($runUpdate) {
				wp_update_post(
					array (
						'ID' => $post->ID, // ID of the post to update
						'post_date' => $import_date,
						'post_date_gmt' => $import_date
					)
				);
				var_dump($post->post_title, $import_date, get_gmt_from_date( $import_date )); echo '<br /><br />';
			}
			//var_dump($post->post_title, $import_date, get_gmt_from_date( $import_date )); echo '<br /><br />';
		}
	}
	
	protected function get_all_faculty() {
		return get_posts([
			'post_type' => 'professors',
			'post_status' => 'publish',
			'numberposts' => -1,
		]);
	}
	
	protected function get_all_lecturer() {
		return get_posts([
			'post_type' => 'lecturers',
			'post_status' => 'publish',
			'numberposts' => -1,
		]);
	}
	
	function hideNewsFromFaculty() {
		//$dbPosts = $this->get_all_faculty();
		$dbPosts = $this->get_all_lecturer();
		//var_dump($dbPosts);
		//return;
		//$dbPosts = array_slice($dbPosts, 0, 7);
		$runUpdate = false;
		foreach ( $dbPosts as $idx => $post ) {
			$hideNews = get_post_meta($post->ID, 'hide_news_section_from_faculty', true);
			$hideFNews = get_post_meta($post->ID, 'hide_faculty_news_section_from_faculty', true);
			if(!$hideNews || !$hideFNews) {
				echo $hideNews . '-' . $hideFNews . '-' . $post->post_title . '<br />';
				if($runUpdate) {
					update_post_meta( $post->ID, 'hide_news_section_from_faculty', true );
					update_post_meta( $post->ID, 'hide_faculty_news_section_from_faculty', true );
				}
			}
		}
	}
	
	function exportPublications() {
		$dbPosts = $this->get_all_publications();
		$csvArray = [];
		echo '<table>';
		foreach( $dbPosts as $idx => $dbPost ) {
			$thisYear = get_post_meta( $dbPost->ID, 'publication_date', true );
			$thisRow = [];
			$thisRow[0] = $dbPost->ID;
			$thisRow[1] = $thisYear;
			$thisRow[2] = strip_tags(str_replace(',',' ', $dbPost->post_title));
			$csvArray[] = $thisRow;
			echo '<tr>';
			echo '<td>' . $dbPost->ID . '</td>';
			echo '<td>' . $thisYear . '</td>';
			echo '<td>' . $dbPost->post_title . '</td>';
			echo '</tr>';
		}
		echo '</table>';
		//var_dump($csvArray);
		//echo implode(",",$csvArray);
	}
	
	function updateCoursesTemplate() {
		$dbPosts = $this->get_all_courses();
		//$dbPosts = array_slice($dbPosts, 0, 2);
		//var_dump($dbPosts);
		foreach( $dbPosts as $key => $each) {
			$thisTpl = get_post_meta($each->ID , '_wp_page_template', true );
			//update_post_meta($each->ID, '_wp_page_template', '');
			echo $key . ' - ' . $each->post_title . ' - ' . $thisTpl . '<br />';
		}
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		global $wpdb;
		$passKey = $_GET['xyz'] === '1';
		if($passKey) {
			//$this->update_faculty_news_publish_date();
			//$this->update_posts_publish_date();
			//$this->update_faculty_news_body();
			//$this->migrate_usc_pages();
			//$this->updateProfessorTagId();
			//$this->updateCourseProfessorTagId();
			//$this->updateFacultyNewsProfessorTagId();
			//$this->checkPage();
			//$this->checkPosts();
			//$this->copyPostToNews();
			//$this->moveLecturerFromFaculty();
			//$this->updateCourseDetailsFaculty();
			//$this->updatePublicationTemplate();
			//$this->updateNewsImageDomain();
			//$this->update_posts_news_display();
			//$this->updateFacultyPubOrder();
			//$this->migrateNewsCategories();
			//$this->updatePublicationDataToBad();
			//$this->movePublicationToDraft();
			//$this->moveBadToPublication();
			//$this->getPageWithFacultyLink();
			//$this->update_scholarship_publish_date();
			//$this->updatePublicationYear();
			//$this->hideNewsFromFaculty();
			//$this->exportPublications();
			$this->updateCoursesTemplate();
		}
		?>
        <div class="run-script pt-100 pb-100">
			<strong>Run Script: <?php if($passKey) { ?>Completed<?php } else { ?>What's the magic word?<?php } ?></strong>
        </div>
		<?php
	}
}
