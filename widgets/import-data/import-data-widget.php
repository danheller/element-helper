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

class Import_Data extends Element_El_Widget {

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
		return 'import-data';
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
		return __( 'Import Data', 'elementhelper' );
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
		return [ 'import', 'data' ];
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

		$this->add_control(
			'selected_import_type',
			[
				'label'       => __( 'Select Import Type', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'            => array('Publications' => 'Publications', 'Scholarships' => 'Scholarships', 'Courses' => 'Courses', 'Faculties' => 'Faculties', 'News' => 'News', 'Faculty News' => 'Faculty News', 'URL Pages' => 'URL Pages', "Meta Data" => "Meta Data"),
				'frontend_available' => true,
				'style_transfer'     => true,
			]
		);
		
		$this->add_control(
			'import_file',
			[
				'label'   => __( 'Import File csv', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
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
	
	protected function get_all_publications() {
		return get_posts([
			'post_type' => 'publication',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function insertPubliation($importData) {
		echo '<br /><br />INSERTING...<br />';
		//$importData = array_slice($importData, 0, 1);
		//$thisCatIds = $this->get_cat_ids('Books');
		//wp_set_post_categories( 57515, $thisCatIds );
		//wp_set_post_tags( 57513, 'Alexander Capron');
		//$tplId = get_post_meta(56523 , '_wp_page_template', true );
		//var_dump($thisCatIds);
		//var_dump(get_the_tags(56523));
		//var_dump(term_exists($importData[0][0]));
		//wp_set_post_tags( 56523, $importData[0][0]);
		//wp_set_object_terms(11678, $faculty_tag_id->term_id, 'post_tag', true);
		//var_dump( get_faculty_tag_id( $importData[0][3] . ' ' . $importData[0][2] ) );
		return;
		/*
			CSV data mapping
			1. Current Row						- NOT USED
			2. Author UID						- NOT USED
			3. Author Last Name					- author_last_name
			4. Author First Name				- author_first_name
			5. Publication Category				- publication_categories
			6. Publication Sort Order			- NOT USED
			7. Publication Description			- publication_description
			8. Publication Text Type			- publication_text_type
			9. Publication URL					- publication_url
			10. Publication Hosted Internally 	- publication_hosted_internally
			11. Publication Title				- publication_text
			12. Publication Faculty Tag			- publication_tag
			13. Publication Author(s)			- publication_author
			14. Publication Source				- publication_publisher
			15. Publication Year				- publication_date
		*/
		$fields = [
			'',
			'',
			'author_last_name',
			'author_first_name',
			'publication_categories',
			'',
			'publication_description',
			'publication_text_type',
			'publication_url',
			'publication_hosted_internally',
			'publication_text',
			'publication_tag',
			'publication_author',
			'publication_publisher',
			'publication_date'
		];
		foreach ( $importData as $newData ) {
			$postTitle = $this->cleanUp($newData[10]);
			$new = array(
				'post_title' => $postTitle,
				'post_status' => 'publish',
				'post_type' => 'publication'
			);
			$newPostId = wp_insert_post( $new );
			//var_dump($newPostId,$postTitle); echo '<br />';
			foreach ( $fields as $key => $field ) {
				if(!empty($field)) {
					//var_dump($field, $newData[$key]); echo '<br />';
					$thisKeyVal = $newData[$key];
					if($field === 'publication_categories') {
						$thisCatIds = $this->get_cat_ids($newData[4]);
						//echo 'publication_category - ' . var_dump($thisCatIds) . '<br />';
						wp_set_post_categories( $newPostId, $thisCatIds ); 
					} else if($field === 'publication_tag') {
						//echo 'publication_tag - ' . $newData[11] . '<br />';
						wp_set_post_tags( $newPostId, $newData[11]);
					} else if($field === 'publication_hosted_internally') {
						$thisKeyVal = $thisKeyVal === 'Yes' ? '1' : '0';
						//echo 'publication_hosted_internally - ' . $thisKeyVal . '<br />';
						update_post_meta( $newPostId, $field, $thisKeyVal );
					} else {
						//echo $field . '-' . $thisKeyVal . '<br />';
						update_post_meta( $newPostId, $field, $thisKeyVal );
					}
				}
				//echo '<br />';
			}
			update_post_meta($newPostId, '_wp_page_template', 'page-templates/publication-design01.php');
			update_post_meta( $newPostId, 'publication_sort_order', 1 );
		}
		//var_dump($importData);
	}
	
	protected function updatePublication($importData) {
		echo '<br /><br />INSERTING...<br />';
		$dbPosts = $this->get_all_publications();
		//$importData = array_slice($importData, 0, 1);
		//var_dump($importData);
		return;
		/*
			CSV data mapping
			1. WP ID			- Wordpress ID
			2. Year				- NOT USED
			3. Title			- NOT USED
			4. Publish Year		- publish_year
		*/
		$counter = 0;
		$updatePub = false;
		$tmpDate = get_gmt_from_date('August 4, 2003');
		foreach ( $dbPosts as $idx => $post ) {
			if($importData[$post->ID] !== null) {
				//echo $post->ID . '-' . $post->post_title . '<br />';
				//update_post_meta( $dbFaculty->ID, $field, $importData[$dbUniqueId][$key] );
				$thisYear = get_post_meta( $post->ID, 'publication_date', true );
				$publish_date = get_the_date('', $post->ID);
				if($updatePub) {
					echo 'updating...';
					$publish_date = get_gmt_from_date(substr_replace($publish_date, $importData[$post->ID][3], -4, 4));
					update_post_meta( $post->ID, 'publication_date', $importData[$post->ID][3] );
					wp_update_post(
						array (
							'ID' => $post->ID, // ID of the post to update
							'post_date' => $publish_date,
							'post_date_gmt' => $publish_date,
						)
					);
				}
				echo $post->ID . '-' . $publish_date . '-' . $thisYear . '-' . $importData[$post->ID][3] . '<br />';
			}
			$counter++;
		}
		//var_dump($importData);
	}
	
	protected function get_all_scholarships() {
		return get_posts([
			'post_type' => 'faculty-scholarship',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function insertScholarship($importData) {
		echo '<br /><br />INSERTING<br />'; 
		//$dbCats = $this->get_all_categories();
		//$importData = array_slice($importData, 0, 1);
		//$dbPosts = $this->get_all_scholarships();
		//$wpPosts = [];
		//foreach ( $dbPosts as $dbPost ) {
		//	if($wpPosts[$dbPost->post_title] === NULL) {
		//		$wpPosts[$dbPost->post_title] = $dbPost;
		//	} else {
				//echo $dbPost->ID . '-' . $dbPost->post_title . '<br />';
				//echo $wpPosts[$dbPost->post_title]->ID . '-' . $wpPosts[$dbPost->post_title]->post_title . '<br /><br />';
		//	}
		//}
		//$template_metas = get_post_meta(13157); //11638
		//$tmp_post = get_post( 13157 );
		//var_dump($tmp_post);
		//$thisCatIds = $this->get_cat_ids('Articles and Book Chapters');
		//var_dump($importData);
		return;
		/*
			CSV data mapping
			1. Scholarship Author ID			- scholarship_author_unique_id
			2. Scholarship Author First Name	- scholarship_author_first_name
			3. Scholarship Author Last Name		- scholarship_author_last_name
			4. Scholarship Date					- scholarship_date
			5. Scholarship Publish Date			- scholarship_publish_date
			6. Scholarship Category				- 
			7. Scholarship Content				- scholarship_content
			
		*/
		$fields = [
			'scholarship_author_unique_id',
			'scholarship_author_first_name',
			'scholarship_author_last_name',
			'scholarship_date',
			'scholarship_publish_date',
			'scholarship_category',
			'scholarship_content',
		];
		/*$insertFlag = false;
		$counter = 1;
		$nfcounter = 1;
		foreach ( $importData as $newData ) {
			$thisTitle = $this->cleanUp(sanitize_text_field($newData[6]));
			$thisFound = false;
			$foundPost = [];
			foreach($wpPosts as $idx => $wpPost) {
				if(!$thisFound && (str_contains($idx, $thisTitle) || str_contains($thisTitle,$idx)) ) {
					$thisFound = true;
					$foundPost = $wpPost;
				}
			}
			if($thisFound) {
				$thisScholarDate = explode(' ', $newData[3])[0];
				$thisPublishDate = explode(' ', $newData[4])[0];
				$tmp1 = explode('/', $thisScholarDate);
				$tmp2 = explode('/', $thisPublishDate);
				$newScholarDate = (intval($tmp1[0]) < 10 ? '0'.$tmp1[0] : $tmp1[0]) . '/' . (intval($tmp1[1]) < 10 ? '0'.$tmp1[1] : $tmp1[1]) . '/' . '20'.$tmp1[2];
				$newPublishDate = (intval($tmp2[0]) < 10 ? '0'.$tmp2[0] : $tmp2[0]) . '/' . (intval($tmp2[1]) < 10 ? '0'.$tmp2[1] : $tmp2[1]) . '/' . '20'.$tmp2[2];
				$publish_date = get_gmt_from_date($newScholarDate);
				if(true || $foundPost->ID === 65996) {
				//echo $counter . '-<strong>FOUND</strong>-' . $foundPost->ID . '-' . $publish_date . '-' . $newPublishDate . '-' . $foundPost->post_title . '<br /><br />';
				//update_post_meta( $foundPost->ID, 'scholarship_date', $newScholarDate );
				//update_post_meta( $foundPost->ID, 'scholarship_publish_date', $newPublishDate );
				//wp_update_post( array ( 'ID' => $foundPost->ID, 'post_date' => $publish_date, 'post_date_gmt' => $publish_date ) );
				}
				$counter++;
			} else {
				echo $nfcounter . '-<strong>NOT FOUND</strong>-' . $thisTitle . '<br /><br />';
				$nfcounter++;
			}
		}*/
		$insertFlag = false;
		//echo $counter . '-' . $nfcounter;
		foreach ( $importData as $newData ) {
			$postTitle = $this->cleanUp(sanitize_text_field($newData[6]));
				$thisScholarDate = explode(' ', $newData[3])[0];
				$thisPublishDate = explode(' ', $newData[4])[0];
				$tmp1 = explode('/', $thisScholarDate);
				$tmp2 = explode('/', $thisPublishDate);
				$newScholarDate = (intval($tmp1[0]) < 10 ? '0'.$tmp1[0] : $tmp1[0]) . '/' . (intval($tmp1[1]) < 10 ? '0'.$tmp1[1] : $tmp1[1]) . '/' . '20'.$tmp1[2];
				$newPublishDate = (intval($tmp2[0]) < 10 ? '0'.$tmp2[0] : $tmp2[0]) . '/' . (intval($tmp2[1]) < 10 ? '0'.$tmp2[1] : $tmp2[1]) . '/' . '20'.$tmp2[2];
				$publish_date = get_gmt_from_date($newScholarDate);
			//$publish_date = get_gmt_from_date($newData[3]);
			$new = array(
				'post_title' => $postTitle,
				'post_status' => 'publish',
				'post_type' => 'faculty-scholarship',
			);
			echo $postTitle . '-' . $newScholarDate . '<br />';
			if($insertFlag) {
				$newPostId = wp_insert_post( $new );
			}
			foreach ( $fields as $key => $field ) {
				if(!empty($field)) {
					//var_dump($field, $newData[$key]); echo '<br />';
					$thisKeyVal = $newData[$key];
					if($field === 'scholarship_category') {
						$thisCatIds = $this->get_cat_ids($newData[5]);
						echo 'category-' . $thisCatIds . '<br />';
						if($insertFlag) {
							wp_set_post_categories( $newPostId, $thisCatIds ); 
						}
					} else if($field === 'scholarship_date') {
						echo $field . '-' . $newScholarDate . '<br />';
						if($insertFlag) {
							update_post_meta( $newPostId, $field, $newScholarDate );
						}
					} else if($field === 'scholarship_publish_date') {
						echo $field . '-' . $newPublishDate . '<br />';
						if($insertFlag) {
							update_post_meta( $newPostId, $field, $newPublishDate );
						}
					} else {
						echo $field . '-' . $thisKeyVal . '<br />';
						if($insertFlag) {
							update_post_meta( $newPostId, $field, $thisKeyVal );
						}
					}
				}
			}
			$tagName = $newData[1] . ' ' . $newData[2];
			$faculty_tag_id = $this->get_faculty_tag_id( $tagName );
			echo 'tag-term-id-' . $faculty_tag_id->term_id . '<br /><br />';
			if($insertFlag) {
				wp_set_object_terms($newPostId, $faculty_tag_id->term_id, 'post_tag', true);
				wp_update_post(
					array (
						'ID' => $newPostId, // ID of the post to update
						'post_date' => $publish_date,
						'post_date_gmt' => $publish_date
					)
				);
			}
		}
		//var_dump($importData);
	}
	
	protected function cleanUp($str)
	{
		$str = utf8_decode($str);
		//$str = str_replace("&quot;", "", $str);
		$str = str_replace("&nbsp;", " ", $str);
		$str = preg_replace("/\s+/", " ", $str);
		$str = trim($str);
		return $str;
	}
		
	protected function get_all_faculty() {
		return get_posts([
			'post_type' => 'professors',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);;
	}
	
	protected function get_all_lecturer() {
		return get_posts([
			'post_type' => 'lecturers',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);;
	}
	
	protected function dup_faculty_detail_page($templateId, $title, $facultyId, $facultyPageId = 0) {
		$template_metas = get_post_meta($templateId);
		//var_dump($template_metas);
		$new_page = get_post( $templateId );
		if($facultyPageId === 0) {
			unset($new_page->ID);
			//echo 'new faculty page - ' . $facultyId . '<br />';
		} else {
			$new_page->ID = $facultyPageId;
			//echo 'update faculty page - ' . $facultyId . '<br />';
		}
		$new_page->post_title = $title;
		$new_page->post_name = $title;
		$new_page->post_content = '';
		$new_faculty_id = wp_insert_post($new_page);
		foreach ( $template_metas as $key => $val ) {
			//echo 'key = ' . $key . '<br />';
			$real_value = $val[0];
			if($key === '_elementor_data') {
				$real_value = json_decode($real_value);
				//var_dump($real_value[0]->elements[0]->elements[0]->settings->selected_faculty);
				$real_value[0]->elements[0]->elements[0]->settings->selected_faculty = (string) $facultyId;
			}
			$real_value = json_encode($real_value);
				//echo 'val = ' . $real_value . '<br />';
			if( !in_array($key, array('_elementor_page_assets','_elementor_css')) ) {
				update_post_meta($new_faculty_id, $key, $real_value);
			}
		}
		update_post_meta($new_faculty_id, '_wp_page_template', 'elementor_header_footer');
		return $new_faculty_id;
	}
	
	protected function get_faculty_tag_id( $name) {
		$faculty_tag_id = get_term_by('name', $name, 'post_tag');
		if($faculty_tag_id === false) {
			//echo 'new';
			$faculty_tag_id = wp_insert_term($name, 'post_tag');
		}
		return $faculty_tag_id;
	}

	
	protected function insertFaculty($importData) {
		echo 'INSERTING/UPDATING Faculty<br />';
		$dbFaculties = $this->get_all_faculty();
		//var_dump($dbFaculties);
				
		// This is to restore broken page
		//$tmp_id = 2833;
		//$tmp_post = get_post( $tmp_id );
		//delete_post_meta($tmp_id, '_edit_lock');
		//delete_post_meta($tmp_id, '_wp_page_template');
		//delete_post_meta($tmp_id, '_elementor_edit_mode');
		//delete_post_meta($tmp_id, '_elementor_template_type');
		//$template_metas = get_post_meta($tmp_id);
		//var_dump($template_metas); echo '<br /><br />';
		
		// This is to compare with good one
		//$tmp_id = 2760;
		//$tmp_meta = get_post_meta($tmp_id);
		//var_dump($tmp_meta); echo '<br /><br />';
		//$tmp_id = 2857;
		//delete_post_meta($tmp_id, '_elementor_page_assets');
		//delete_post_meta($tmp_id, '_elementor_css');
		//$tmp_meta = get_post_meta($tmp_id);
		//var_dump($tmp_meta); echo '<br /><br />';
		
		//$tmp_id = 1405;
		//var_dump(get_permalink($tmp_id));
		//var_dump(sanitize_text_field('http://goulddev.usc.edu/faculty/clare-pastore/'));
		//var_dump($importData);
		//$profLink = 'http://goulddev.usc.edu/faculty/hannah-r-garry/';
		//var_dump(url_to_postid($profLink));
		//$tagName = 'Faculty Tag';
		//$tagId = get_term_by('name', $tagName, 'post_tag');
		//if($tagId === false) {
		//	echo 'not found';
		//}
		//var_dump($tagId);
		return;
		
		/*
			CSV data mapping
			1. Row ID					- 
			2. Unique ID				- unique_id
			3. Last Updted				- professor_last_updated
			4. First Name				- professor_first_name
			5. Last Name				- professor_last_name
			6. Title					- professor_title
			6. Type						- professor_type
			7. Email					- professor_email
			8. Phone					- professor_phone
			9. Direct Line				- professor_direct_line
			10. Fax 					- professor_fax
			11. Personal Website		- professor_personal_website
			12. Google Scholar Profile	- professor_google_scholar_profile
			13. SSRN Author Page		- professor_ssrn_author_page
			14. Room #					- professor_room
			15. Office Hours			- professor_office_hours
			16. Profile Photo			- professor_image
			17. CV						- professor_download_curriculum_vitae
			18. Bio						- professor_biography
			19. Keywords				- professor_keywords
			20. Summary of Expertise	- professor_summary_of_expertise
		*/
		$fields = [
			'',
			'unique_id',
			'professor_last_updated',
			'professor_first_name',
			'professor_last_name',
			'professor_title',
			'professor_type',
			'professor_email',
			'professor_phone',
			'professor_direct_line',
			'professor_fax',
			'professor_personal_website',
			'professor_google_scholar_profile',
			'professor_ssrn_author_page',
			'professor_room',
			'professor_office_hours',
			'professor_image',
			'professor_download_curriculum_vitae',
			'professor_biography',
			'professor_keywords',
			'professor_summary_of_expertise',
		];
		foreach ( $dbFaculties as $dbFaculty ) {
			$dbUniqueId = get_field('unique_id', $dbFaculty->ID);
			if($dbUniqueId !== NULL && $importData[$dbUniqueId] !== NULL) {
				$postTitle = $importData[$dbUniqueId][4] . ', ' . $importData[$dbUniqueId][3];
				$pageLinkTitle = $importData[$dbUniqueId][3] . ' ' . $importData[$dbUniqueId][4];
				$new_title = mb_convert_case( $postTitle, MB_CASE_TITLE, "UTF-8" );
				// if $new_title is defined, but it matches the current title, return
				if ( $dbFaculty->post_title !== $new_title ) {
					// place the current post and $new_title into array
					$post_update = array(
						'ID'         => $dbFaculty->ID,
						'post_title' => $new_title
					);
					wp_update_post( $post_update );
				}
				
				foreach ( $fields as $key => $field ) {
					if(!empty($field)) {
						//var_dump($key, $field); echo '<br />';
						//update_post_meta( $dbFaculty->ID, $field, sanitize_text_field( $importData[$dbUniqueId][$key] ) );
						update_post_meta( $dbFaculty->ID, $field, $importData[$dbUniqueId][$key] );
						//$thisField = get_post_meta( $dbFaculty->ID, $field, true );
						//echo $field . '=' . $importData[$dbUniqueId][$key] . '=' . $thisField . '<br /><br />';
					}
				}
				update_post_meta( $dbFaculty->ID, 'professor_full_name', $pageLinkTitle );
				//var_dump($pageLinkTitle);
				$profPageLink = get_post_meta( $dbFaculty->ID, 'professor_page_link', true );
				$profPageId = url_to_postid($profPageLink);
				$faculty_template_id = 2760;
				$new_faculty_id = $this->dup_faculty_detail_page($faculty_template_id, $pageLinkTitle, $dbFaculty->ID, $profPageId);
				$newPermalink = get_permalink($new_faculty_id);
				update_post_meta( $dbFaculty->ID, 'professor_page_link', sanitize_text_field( $newPermalink ) );
				if($dbFaculty->professor_type === 'Faculty') {
					//echo 'faculty';
					$faculty_tag_id = $this->get_faculty_tag_id($pageLinkTitle);
					update_post_meta( $dbFaculty->ID, 'professor_tag_id', $faculty_tag_id );
					//var_dump($faculty_tag_id);
				}
				unset($importData[$dbUniqueId]);
			}
		}
		foreach ( $importData as $newData ) {
			$postTitle = $newData[4] . ', ' . $newData[3];
			$pageLinkTitle = $newData[3] . ' ' . $newData[4];
			$new_title = mb_convert_case( $postTitle, MB_CASE_TITLE, "UTF-8" );
			$new = array(
				'post_title' => $new_title,
				'post_status' => 'publish',
				'post_type' => 'professors'
			);
			$newPostId = wp_insert_post( $new );
			foreach ( $fields as $key => $field ) {
				if(!empty($field)) {
					//var_dump($key, $field); echo '<br />';
					update_post_meta( $newPostId, $field, sanitize_text_field( $newData[$key] ) );
					//$thisField = get_post_meta( $dbFaculty->ID, $field, true );
					//echo $field . '=' . $importData[$dbUniqueId][$key] . '=' . $thisField . '<br /><br />';
				}
			}
			update_post_meta( $newPostIdD, 'professor_full_name', $pageLinkTitle );
			$faculty_template_id = 2760;
			$new_faculty_id = $this->dup_faculty_detail_page($faculty_template_id, $pageLinkTitle, $newPostId);
			$newPermalink = get_permalink($new_faculty_id);
			update_post_meta( $newPostId, 'professor_page_link', sanitize_text_field( $newPermalink ) );
			if($newData[6] === 'Faculty') {
				//echo 'faculty';
				$faculty_tag_id = $this->get_faculty_tag_id($pageLinkTitle);
				update_post_meta( $newPostId, 'professor_tag_id', $faculty_tag_id );
			}
		}
		var_dump($importData);
	}
	
	protected function insertLecturer($importData) {
		echo 'INSERTING/UPDATING Lecturer<br />';
		$dbFaculties = $this->get_all_lecturer();
		$importLecturerOnly = [];
		//var_dump($importData);
		foreach ( $importData as $each ) {
			if($each[6] === 'Lecturer in Law') {
				$importLecturerOnly[] = $each;
			}
		}
		$importData = $importLecturerOnly;
		//var_dump($importData);
		return;
		
		/*
			CSV data mapping
			1. Row ID					- 
			2. Unique ID				- unique_id
			3. Last Updted				- professor_last_updated
			4. First Name				- professor_first_name
			5. Last Name				- professor_last_name
			6. Title					- professor_title
			6. Type						- professor_type
			7. Email					- professor_email
			8. Phone					- professor_phone
			9. Direct Line				- professor_direct_line
			10. Fax 					- professor_fax
			11. Personal Website		- professor_personal_website
			12. Google Scholar Profile	- professor_google_scholar_profile
			13. SSRN Author Page		- professor_ssrn_author_page
			14. Room #					- professor_room
			15. Office Hours			- professor_office_hours
			16. Profile Photo			- professor_image
			17. CV						- professor_download_curriculum_vitae
			18. Bio						- professor_biography
			19. Publication				- professor_publication
			19. Keywords				- professor_keywords
			20. Summary of Expertise	- professor_summary_of_expertise
		*/
		$fields = [
			'',
			'unique_id_disabled',
			'professor_last_updated_disabled',
			'professor_first_name',
			'professor_last_name',
			'professor_title',
			'professor_type',
			'professor_email',
			'professor_phone',
			'professor_direct_line',
			'professor_fax_disabled',
			'professor_personal_website',
			'professor_google_scholar_profile',
			'professor_ssrn_author_page',
			'professor_room',
			'professor_office_hours',
			'professor_image',
			'professor_download_curriculum_vitae',
			'professor_biography',
			'professor_publications_disabled',
			'professor_keywords_disabled',
			'professor_summary_of_expertise_disabled',
		];
		/*foreach ( $dbFaculties as $dbFaculty ) {
			$dbUniqueId = get_field('unique_id', $dbFaculty->ID);
			if($dbUniqueId !== NULL && $importData[$dbUniqueId] !== NULL) {
				$postTitle = $importData[$dbUniqueId][4] . ', ' . $importData[$dbUniqueId][3];
				$pageLinkTitle = $importData[$dbUniqueId][3] . ' ' . $importData[$dbUniqueId][4];
				$new_title = mb_convert_case( $postTitle, MB_CASE_TITLE, "UTF-8" );
				// if $new_title is defined, but it matches the current title, return
				if ( $dbFaculty->post_title !== $new_title ) {
					// place the current post and $new_title into array
					$post_update = array(
						'ID'         => $dbFaculty->ID,
						'post_title' => $new_title
					);
					wp_update_post( $post_update );
				}
				
				foreach ( $fields as $key => $field ) {
					if(!empty($field)) {
						//var_dump($key, $field); echo '<br />';
						//update_post_meta( $dbFaculty->ID, $field, sanitize_text_field( $importData[$dbUniqueId][$key] ) );
						update_post_meta( $dbFaculty->ID, $field, $importData[$dbUniqueId][$key] );
						//$thisField = get_post_meta( $dbFaculty->ID, $field, true );
						//echo $field . '=' . $importData[$dbUniqueId][$key] . '=' . $thisField . '<br /><br />';
					}
				}
				update_post_meta( $dbFaculty->ID, 'professor_full_name', $pageLinkTitle );
				//var_dump($pageLinkTitle);
				$profPageLink = get_post_meta( $dbFaculty->ID, 'professor_page_link', true );
				$profPageId = url_to_postid($profPageLink);
				$faculty_template_id = 2760;
				$new_faculty_id = $this->dup_faculty_detail_page($faculty_template_id, $pageLinkTitle, $dbFaculty->ID, $profPageId);
				$newPermalink = get_permalink($new_faculty_id);
				update_post_meta( $dbFaculty->ID, 'professor_page_link', sanitize_text_field( $newPermalink ) );
				if($dbFaculty->professor_type === 'Faculty') {
					//echo 'faculty';
					$faculty_tag_id = $this->get_faculty_tag_id($pageLinkTitle);
					update_post_meta( $dbFaculty->ID, 'professor_tag_id', $faculty_tag_id );
					//var_dump($faculty_tag_id);
				}
				unset($importData[$dbUniqueId]);
			}
		}*/
		$insertMode = false;
		foreach ( $importData as $newData ) {
			$postTitle = $newData[4] . ', ' . $newData[3];
			$pageLinkTitle = $newData[3] . ' ' . $newData[4];
			$new_title = mb_convert_case( $postTitle, MB_CASE_TITLE, "UTF-8" );
			echo $new_title . '<br />';
			$new = array(
				'post_title' => $new_title,
				'post_status' => 'publish',
				'post_type' => 'lecturers'
			);
			if($insertMode) {
			$newPostId = wp_insert_post( $new );
			}
			foreach ( $fields as $key => $field ) {
				if(!empty($field)) {
					//var_dump($key, $field); echo '<br />';
					if($insertMode) {
					update_post_meta( $newPostId, $field, $newData[$key] );
					}
					//echo $field . '=' . $importData[$dbUniqueId][$key] . '=' . $thisField . '<br /><br />';
				}
			}
			//$faculty_template_id = 2760;
			//$new_faculty_id = $this->dup_faculty_detail_page($faculty_template_id, $pageLinkTitle, $newPostId);
			//$newPermalink = get_permalink($new_faculty_id);
			$faculty_tag_id = $this->get_faculty_tag_id($pageLinkTitle);
			$faculty_tag_id = ! empty($faculty_tag_id) ? $faculty_tag_id->term_id : -1;
			//var_dump($faculty_tag_id); echo '<br />';
			if($insertMode) {
			update_post_meta( $newPostId, '_wp_page_template', 'page-templates/faculty-design01.php' );
			update_post_meta( $newPostId, 'professor_page_link', $newPermalink );
			update_post_meta( $newPostId, 'professor_full_name', $pageLinkTitle );
			//update_post_meta( $newPostId, 'professor_tag_id', $faculty_tag_id );
			wp_set_object_terms($newPostId, $faculty_tag_id, 'post_tag', true);
			}
		}
		//var_dump($importData);
	}
	
	protected function get_all_course() {
		return get_posts([
			'post_type' => 'courses',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function get_faculty_by_string($str) {
		//var_dump($str); echo '<br />';
		$faculties = false;
		if(!empty(trim($str))) {
			$args = array(
				'post_type' => ['professors','lecturers'],
				'post_status' => 'publish',
				'numberposts' => -1,
				'order'    => 'ASC',
				'meta_query'    => array(
					array(
						'key'       => 'professor_full_name',
						'value'     => array_map('trim', explode(",",$str)),
						'compare'	=> 'IN',
					),
				),
			);
			//var_dump($args);
			$courseProfessors = get_posts($args);
			foreach($courseProfessors as $eachProfessor) {
				//$faculties[] = (string) $eachProfessor->ID;
				$faculties[] = $eachProfessor->ID;
			}
		}
		return $faculties;
	}
	
	protected function dup_course_detail_page($templateId, $title, $courseId, $coursePageId = 0) {
		global $wpdb;
		$template_metas = get_post_meta($templateId);
		//var_dump($template_metas);
		$new_page = get_post( $templateId );
		if($coursePageId === 0) {
			unset($new_page->ID);
			//echo 'new faculty page - ' . $facultyId . '<br />';
		} else {
			$new_page->ID = $coursePageId;
			//echo 'update faculty page - ' . $facultyId . '<br />';
		}
		$new_page->post_title = $title;
		$new_page->post_name = $title;
		$new_page->post_content = '';
		$new_course_id = wp_insert_post($new_page);
		foreach ( $template_metas as $key => $val ) {
			//echo 'key = ' . $key . '<br />';
			$real_value = $val[0];
			if($key === '_elementor_data') {
				$real_value = json_decode($real_value);
				//var_dump($real_value); echo '<br /><br />';
				//var_dump($real_value[0]->elements[0]->elements[1]->elements[1]->elements[1]->settings->selected_course);
				$real_value[0]->elements[0]->elements[1]->elements[1]->elements[1]->settings->course_selected = (string) $courseId;
				$real_value[0]->elements[0]->elements[1]->elements[1]->elements[1]->settings->selected_course = (string) $courseId;
			}
			$real_value = json_encode($real_value);
			if($key === '_elementor_data') {
				$real_value = addslashes($real_value);
				//$real_value = str_replace('\/','\\\/', $real_value);				
			}
				//echo 'val = ' . $real_value . '<br />';
			if( !in_array($key, array('_elementor_page_assets','_elementor_css')) ) {
				update_post_meta($new_course_id, $key, $real_value);
			}
		}
		update_post_meta($new_course_id, '_wp_page_template', 'elementor_header_footer');
		return $new_course_id;
	}
	
	function convertCourseNumber($str) {
		$cNum = htmlentities($str, null, 'utf-8');
		$cNum = str_replace("&nbsp;", "", $cNum);
		$cNum = html_entity_decode($cNum);
		return $cNum;
	}
	
	function getAllFacultyPostTags($posts) {
		$tags = array();
		foreach($posts as $eachPost) {
			$thisTags = wp_get_post_tags($eachPost);
			foreach($thisTags as $thisTag) {
				if( ! in_array($thisTag->term_id, $tags) ) {
					$tags[] = $thisTag->term_id;
				}
				//var_dump($thisTag->term_id); echo '<br />';
			}
		}
		return $tags;
	}
	
	protected function insertCourse($importData) {
		echo 'INSERTING<br />';
		global $wpdb;
		//$dbCourses = $this->get_all_course();
		//$allowUpdateCourse = false;		// Allow doing update Post
		
		//$newImport[array_key_first($importData)] = $importData[array_key_first($importData)];
		//$newImport['819'] = $importData['819'];
		/*foreach ( $dbCourses as $dbCourse ) {
			$dbUniqueId = get_field('course_number', $dbCourse->ID);
			if($newImport[$dbUniqueId] !== NULL) {
				$course_professors = $this->get_faculty_by_string($newImport[$dbUniqueId][6]);
				$facultyTags = $this->getAllFacultyPostTags($course_professors);
				update_post_meta( $dbCourse->ID, 'course_professors', $course_professors );
				wp_set_object_terms($dbCourse->ID, $facultyTags, 'post_tag', true);
				var_dump($dbCourse->ID, $newImport[$dbUniqueId][3], $newImport[$dbUniqueId][6], $course_professors, $facultyTags); echo '<br />';
			}
		}*/
		//var_dump($newImport);
		// This is to compare with good one
		//$tmp_id = 3310;
		//$tmp_meta = get_post_meta($tmp_id);
		//$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$tmp_id");
		//var_dump($post_meta_infos); echo '<br /><br />';
		//$tmp_id = 3318;
		//delete_post_meta($tmp_id, '_elementor_data');
		//delete_post_meta($tmp_id, '_elementor_page_assets');
		//delete_post_meta($tmp_id, '_elementor_css');
		//$tmp_meta = get_post_meta($tmp_id);
		//$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$tmp_id");
		//var_dump($post_meta_infos); echo '<br /><br />';
		/*foreach($importData as $key => $val) {
			echo $key . '<br />';
			if($key === 'Access to Justice Practicum') {
				var_dump($val);
			}
		}*/
		//$importData = array_slice($importData, 0, 1);
		//var_dump($importData);
		//$tmpAbc = $this->get_faculty_by_string('Phyllis Pollack');
		//var_dump($tmpAbc);
		//wp_set_object_terms(76423, [437,98], 'post_tag', true);
		// 1317 76313
		//$abc = get_the_tags(1317);
		//var_dump($abc);
		return;
		/*
			CSV data mapping
			1. Curriculum ID			- Curriculum ID
			2. Visible					- course_visible
			3. Category					- course_category
			4. Course Name				- course_name
			5. Course Number			- course_number
			6. Units					- course_units
			7. Description				- course_description
			8. Instructor Name			- course_professors
			9. User ID					- User ID
			10. Detail ID				- Detail ID
			11. Grading Option			- course_grading_options
			12. Exam type				- course_exam_type
			13. Writing Requirement		- writing_requirement
			14. Skills/Experiential 	- skillsexperiential_requirement
			15. Enrollment Limit		- enrollment_limit
			16. Prerequisite			- course_prerequisite
			17. Corequisite				- course_corequisite
			18. Recommend Prep			- course_recommend_prep
			19. Note					- course_note
			20. Date Created			- Date Created
			21. Date Last Updated		- Date Last Updated
			22. Updated User ID			- Updated User ID
		*/
		$fields = [
			'',
			'course_visible',
			'course_category',
			'course_name',
			'course_number',
			'course_units',
			'course_description',
			'course_professors',
			'',
			'',
			'course_grading_options',
			'course_exam_type',
			'writing_requirement',
			'skillsexperiential_requirement',
			'enrollment_limit',
			'course_prerequisite',
			'course_corequisite',
			'course_recommend_prep',
			'course_note',
			'',
			'',
			''
		];
		/*foreach ( $dbCourses as $dbCourse ) {
			$dbUniqueId = get_field('course_number', $dbCourse->ID);
			if($dbUniqueId !== NULL && $importData[$dbUniqueId] !== NULL) {
				$pageLinkTitle = $importData[$dbUniqueId][2] . ' - LAW-' . $importData[$dbUniqueId][3];
				$postTitle = $importData[$dbUniqueId][2];
				$new_title = $postTitle;
				// if $new_title is defined, but it matches the current title, return
				if( $allowUpdateCourse ) {
					if ( $dbCourse->post_title !== $new_title ) {
						// place the current post and $new_title into array
						$post_update = array(
							'ID'         => $dbCourse->ID,
							'post_title' => $new_title
						);
						wp_update_post( $post_update );
					}

					foreach ( $fields as $key => $field ) {
						if(!empty($field)) {
							//var_dump($key, $field); echo '<br />';
							if($field === 'course_professors') {
								$course_professors = $this->get_faculty_by_string($importData[$dbUniqueId][$key]);
								update_post_meta( $dbCourse->ID, $field, $course_professors );
								$facultyTags = $this->getAllFacultyPostTags($course_professors);
								wp_set_object_terms($dbCourse->ID, $facultyTags, 'post_tag', true);
							} else {
								update_post_meta( $dbCourse->ID, $field, sanitize_text_field( $importData[$dbUniqueId][$key] ) );
							}
							//$thisField = get_post_meta( $dbCourse->ID, $field, true );
							//echo $field . '=' . $importData[$dbUniqueId][$key] . '=' . $thisField . '<br /><br />';
						}
					}
					$courseLink = get_post_meta( $dbCourse->ID, 'course_link', true );
					$coursePageId = url_to_postid($courseLink);
					$course_template_id = 3310;
					$new_course_id = $this->dup_course_detail_page($course_template_id, $pageLinkTitle, $dbCourse->ID, $coursePageId);
					$newPermalink = get_permalink($new_course_id);
					update_post_meta( $dbCourse->ID, 'course_link', sanitize_text_field( $newPermalink ) );
					//if(empty($courseLink)) {
					//	var_dump($pageLinkTitle);
					//	$course_template_id = 3310;
					//	$new_course_id = $this->dup_course_detail_page($course_template_id, $pageLinkTitle, $dbCourse->ID);
					//	$newPermalink = get_permalink($new_course_id);
					//	update_post_meta( $dbCourse->ID, 'course_link', sanitize_text_field( $newPermalink ) );
					//	var_dump($newPermalink);
					//}
				}
				unset($importData[$dbUniqueId]);
			}
		}*/
		$allowInsertCourse = false;		// Allow doing insert Post
		foreach ( $importData as $newData ) {
			$postTitle = $newData[3];
			$pageLinkTitle = $newData[3] . ' - LAW-' . $newData[4];
			//$new_title = mb_convert_case( $postTitle, MB_CASE_TITLE, "UTF-8" );
			$new_title = $postTitle;
			$new = array(
				'post_title' => $new_title,
				'post_status' => 'publish',
				'post_type' => 'courses'
			);
			$thisCourseFaculty = [];
			if( $allowInsertCourse ) {
			$newPostId = wp_insert_post( $new );
			} else {
				echo $new_title . '<br />';
			}
			foreach ( $fields as $key => $field ) {
				if(!empty($field)) {
					if($field === 'course_professors') {
						if( $allowInsertCourse ) {
						update_post_meta( $newPostId, $field, $this->get_faculty_by_string($newData[$key]) );
						$splitFaculty = explode(",", $newData[$key]);
						foreach($splitFaculty as $key => $val) {
							$tmpTest = $this->get_faculty_by_string(trim($val));
							if(!empty($tmpTest)) {
								$thisTagId = get_the_tags($tmpTest[0]);
								if(!empty($thisTagId)) {
									$thisCourseFaculty[] = $thisTagId[0]->term_id;
								}
							}
						}
						} else {
							$splitFaculty = explode(",", $newData[$key]);
							var_dump($newData[$key]); echo '<br />';
							foreach($splitFaculty as $key => $val) {
								//echo '-'.trim($val).'-<br/>';
								$tmpTest = $this->get_faculty_by_string(trim($val));
								if(!empty($tmpTest)) {
									$thisTagId = get_the_tags($tmpTest[0]);
									//var_dump($thisTagId);
									if(!empty($thisTagId)) {
										//echo 'iam here<br />';
										var_dump($thisTagId[0]->term_id);
										$thisCourseFaculty[] = $thisTagId[0]->term_id;
									}
								}
								//var_dump($tmpTest); echo '<br />';
							}
						}
					} else {
						if( $allowInsertCourse ) {
						update_post_meta( $newPostId, $field, sanitize_text_field( $newData[$key] ) );
						}
					}
				}
			}
			//var_dump($pageLinkTitle);
			//$course_template_id = 3310;
			//$new_course_id = $this->dup_course_detail_page($course_template_id, $pageLinkTitle, $newPostId);
			//$newPermalink = get_permalink($new_course_id);
			//update_post_meta( $newPostId, 'course_link', sanitize_text_field( $newPermalink ) );
			if( $allowInsertCourse ) {
			update_post_meta( $newPostId, '_wp_page_template', 'page-templates/courses-design01.php' );
			wp_set_object_terms($newPostId, $thisCourseFaculty, 'post_tag', true);
			} else {
				var_dump($thisCourseFaculty);
			}
			//var_dump($thisCourseFaculty);
			//update_post_meta( $newPostId, 'course_link', $newPermalink );
		}
		//var_dump($importData);
	}
	
	protected function get_all_news() {
		return get_posts([
			'post_type' => 'post',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function get_all_categories() {
		$categories = [];
		$cats = get_terms(array('taxonomy' => 'category', 'hide_empty' => false));
		foreach($cats as $cat) {
			$categories[$cat->name] = $cat->term_id;
		}
		return $categories;
	}
	
	protected function get_cat_ids($str) {
		$catIds = [];
		$thisCats = explode(",", $str);
		$thisCats = array_map('trim', $thisCats);
		$dbCats = $this->get_all_categories();
		//var_dump($dbCats); echo '<br /><br />';
		//echo $str . '<br />';
		foreach ( $thisCats as $thisCat ) {
			//var_dump(explode(" ", $thisCat));
			$thisCat = implode(" ", array_map('trim', array_filter(explode(" ", $thisCat))));
			//echo var_dump($thisCat, 'Hidden Articles') . '<br />';
			if($dbCats[$thisCat] !== NULL) {
				array_push($catIds, $dbCats[$thisCat]);
			} else {
				$catArr = array('cat_name' => $thisCat);
				$thisCatId = wp_insert_category($catArr);
				array_push($catIds, $thisCatId);
			}
		}
		return $catIds;
	}
	
	protected function insertNews($importData) {
		echo 'INSERTING<br />';
		global $wpdb;
		$dbNews = $this->get_all_news();
		$allowUpdatePost = false;		// Allow doing update Post
		
		//var_dump(count($importData));
		//$import_date = get_gmt_from_date(get_post_meta( 45580, 'news_date', true ));
		//wp_update_post( array ( 'ID' => 45580, 'post_date' => $import_date, 'post_date_gmt' => $import_date ) );
		//var_dump($import_date);
		//$importData = array_slice($importData, 0, 1);
		//foreach ( $importData as $newData ) {
		//	$importcat = $this->get_cat_ids($newData[9]);
		//	var_dump($newData[9], $importcat); echo '<br />';
		//}
		//var_dump($importData);
		//var_dump($dbNews);

		// This is to compare with good one
		//$tmp_id = 3310;
		//$tmp_meta = get_post_meta($tmp_id);
		//$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$tmp_id");
		//var_dump($post_meta_infos); echo '<br /><br />';
		//$tmp_id = 3318;
		//delete_post_meta($tmp_id, '_elementor_data');
		//delete_post_meta($tmp_id, '_elementor_page_assets');
		//delete_post_meta($tmp_id, '_elementor_css');
		//$tmp_meta = get_post_meta($tmp_id);
		//$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$tmp_id");
		//var_dump($post_meta_infos); echo '<br /><br />';
		
		//$cats = get_terms('category');
		//var_dump($cats);
		//$dbCategories = $this->get_all_categories();
		//$dbCats = $this->get_all_categories();
		//var_dump($dbCats); echo '<br /><br />';
		//var_dump($importData);
		return;
		/*
			CSV data mapping
			1. Row ID					- Row ID
			2. News ID					- news_id
			3. News Title				- news_title
			4. Image					- news_image
			5. Body						- news_body
			6. Display					- news_display
			7. Publish Date				- news_date
			8. Brief Description		- news_brief_description
			9. Flickr Slideshow			- Flickr Slideshow
			10. Meta Description			- news_meta_description
			11. Meta Robots				- news_meta_robots
			12. Categories				- 
		*/
		$fields = [
			'',
			'news_id',
			'news_title',
			'news_image',
			'news_body',
			'news_display',
			'news_date',
			'news_brief_description',
			'',
			'news_meta_description',
			'news_meta_robots',
			'news_categories',
		];
		/*foreach ( $dbNews as $dbNew ) {
			$dbUniqueId = intval(get_field('news_id', $dbNew->ID));
			if($dbUniqueId !== NULL && $importData[$dbUniqueId] !== NULL) {
				$postTitle = $importData[$dbUniqueId][1];
				$new_title = $postTitle;
				// if $new_title is defined, but it matches the current title, return
				if( $allowUpdatePost ) {
					if ( $dbNew->post_title !== $new_title ) {
						// place the current post and $new_title into array
						$post_update = array(
							'ID'         => $dbNew->ID,
							'post_title' => $new_title
						);
						wp_update_post( $post_update );
					}

					foreach ( $fields as $key => $field ) {
						if(!empty($field)) {
							if($field === 'news_categories') {
								$thisCatIds = $this->get_cat_ids($importData[$dbUniqueId][$key]);
								wp_set_post_categories( $dbNew->ID, $thisCatIds ); 
							} else if($field === 'news_display') {
								$thisDisplay = $importData[$dbUniqueId][$key] === 'Yes' ? '1' : '0';
								update_post_meta( $dbNew->ID, $field, sanitize_text_field( $thisDisplay ) );
							} else {
								update_post_meta( $dbNew->ID, $field, $importData[$dbUniqueId][$key] );
							}
						}
					}
				}
				unset($importData[$dbUniqueId]);
			}
		}*/
		//$importData = array_slice($importData, 0, 1);
		$allowInsertPost = false;		// Allow doing insert Post
		foreach ( $importData as $newData ) {
			$postTitle = $newData[2];
			$new_title = $postTitle;
			$new = array(
				'post_title' => $new_title,
				'post_status' => 'publish',
				'post_type' => 'news'
			);
			if( $allowInsertPost ) {
			$newPostId = wp_insert_post( $new );
			}
			echo $new_title . '-' . $newPostId . '<br />';
			foreach ( $fields as $key => $field ) {
				if(!empty($field)) {
					if($field === 'news_categories') {
						$thisCatIds = $this->get_cat_ids($newData[$key]);
						//echo $newData[$key] . '<br />';
						//var_dump($thisCatIds);
						//echo '<br />';
						if( $allowInsertPost ) {
						wp_set_post_categories( $newPostId, $thisCatIds );
						}
					} else if($field === 'news_display') {
						$thisDisplay = $newData[$key] === 'Yes' ? '1' : '0';
						if( $allowInsertPost ) {
						update_post_meta( $newPostId, $field, sanitize_text_field( $thisDisplay ) );
						}
					} else {
						if( $allowInsertPost ) {
						update_post_meta( $newPostId, $field, $newData[$key] );
						}
					}
				}
			}
			$import_date = get_gmt_from_date(get_post_meta( $newPostId, 'news_date', true ));
			if( $allowInsertPost ) {
			update_post_meta( $newPostId, '_wp_page_template', 'page-templates/news-design02.php' );
			wp_update_post( array ( 'ID' => $newPostId, 'post_date' => $import_date, 'post_date_gmt' => $import_date ) );
			}
		}
		//var_dump($importData);
	}
	
	protected function get_all_faculty_news() {
		return get_posts([
			'post_type' => 'faculty_news',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => 'ASC',
		]);
	}
	
	protected function insertFacultyNews($importData) {
		echo 'INSERTING<br />';
		global $wpdb;
		//$dbNews = $this->get_all_faculty_news();
		//$importData = array_slice($importData, 0, 1);
		//var_dump($importData);

		//return;
		/*
			CSV data mapping
			1. Faculty Unique ID		- faculty_id
			2. Faculty First Name		- faculty_first_name
			3. Faculty Last Name		- faculty_last_name
			4. Faculty					- faculty_news_faculty
			5. Source					- faculty_source
			6. Title					- faculty_news_title
			7. Description				- faculty_news_description
			8. Hyperlink				- faculty_news_link
			9. Start Date				- faculty_news_date
		*/
		$fields = [
			'faculty_id',
			'faculty_first_name',
			'faculty_last_name',
			'faculty_news_faculty',
			'faculty_source',
			'faculty_news_title',
			'faculty_news_description',
			'faculty_news_link',
			'faculty_news_date',
		];
		/*foreach ( $dbNews as $dbNew ) {
			$dbUniqueId = get_field('unique_id', $dbNew->ID);
			if($dbUniqueId !== NULL && $importData[$dbUniqueId] !== NULL) {
				$postTitle = $importData[$dbUniqueId][5];
				$new_title = mb_convert_case( $postTitle, MB_CASE_TITLE, "UTF-8" );
				if ( $dbNew->post_title !== $new_title ) {
					// place the current post and $new_title into array
					$post_update = array(
						'ID'         => $dbNew->ID,
						'post_title' => $new_title
					);
					wp_update_post( $post_update );
				}
				
				foreach ( $fields as $key => $field ) {
					if(!empty($field)) {
						update_post_meta( $dbNew->ID, $field, $importData[$dbUniqueId][$key] );
					}
				}
				unset($importData[$dbUniqueId]);
			}
		}*/
		//$importData = array_slice($importData, 0, 1);
		$allowInsertPost = false;
		foreach ( $importData as $newData ) {
			$term = intval(term_exists( $newData[3] ));
			if($term === 0) {
				//var_dump($newData[3], $term); 
				echo '<strong>' . $newData[3]. '</strong><br />';
			}
			if ( $term === 0 || $term === null ) {
				$term_obj = wp_insert_term( $newData[3], 'post_tag' );
				//$term = $term_obj['term_id'];
			}

			$postTitle = $newData[5];
			$new = array(
				'post_title' => $postTitle,
				'post_status' => 'publish',
				'post_type' => 'faculty_news'
			);
			if($allowInsertPost) {
			$newPostId = wp_insert_post( $new );
			}
			echo $postTitle . '<br />';
			foreach ( $fields as $key => $field ) {
				if(!empty($field)) {
					if($allowInsertPost) {
					update_post_meta( $newPostId, $field, $newData[$key] );
					}
				}
			}
			$import_date = get_gmt_from_date(get_post_meta( $newPostId, 'faculty_news_date', true ));
			echo $import_date . '<br />';
			if($allowInsertPost) {
			wp_set_post_tags( $newPostId, $newData[3]);
			wp_update_post( array ( 'ID' => $newPostId, 'post_date' => $import_date, 'post_date_gmt' => $import_date ) );
			}
		}
		//var_dump($importData);
	}
	
	protected function insertNewUrlPages($title, $date, $parent_id) {
		$templateId = 24330;
		$template_metas = get_post_meta($templateId);
		//var_dump($template_metas);
		$new_page = get_post( $templateId );
		unset($new_page->ID);
		$new_page->post_title = ucwords($title);
		$new_page->post_name = ucwords($title);
		$new_page->post_parent = $parent_id;
		$new_page->post_date = get_gmt_from_date( $date );
		$new_page->post_date_gmt = get_gmt_from_date( $date );
		$new_page->post_content = '';
		$new_page_id = wp_insert_post($new_page);
		foreach ( $template_metas as $key => $val ) {
			//echo 'key = ' . $key . '<br />';
			$real_value = $val[0];
			if($key === '_elementor_data') {
				$real_value = json_decode($real_value);
			}
			$real_value = json_encode($real_value);
			if($key === '_elementor_data') {
				$real_value = addslashes($real_value);
			}
			if( !in_array($key, array('_elementor_page_assets','_elementor_css')) ) {
				update_post_meta($new_page_id, $key, $real_value);
			}
		}
		update_post_meta($new_page_id, '_wp_page_template', 'elementor_header_footer');
		return $new_page_id;
	}
	
	protected function insertUrlPages($importData) {
		echo '<br /><br />INSERTING<br />'; 
		//$importData = array_slice($importData, 899, 10);
		$domainUrl = 'https://gould.usc.edu';
		$parent_id = 0;
		var_dump($importData);
		return;
		foreach( $importData as $key => $val ) {
			$thisUrl = str_replace($domainUrl, '', $val[0]);
			$thisPostDate = $val[1];
			$page_id = url_to_postid($thisUrl);
			$splitUrl = array_values(array_filter(explode('/', $thisUrl)));
				var_dump($thisUrl,$page_id); echo '<br />';
			if($page_id === 0) {
				var_dump($thisUrl); echo '<br />';
				$curPathUrl = '';
				foreach($splitUrl as $idx => $urlElement) {
					$curPathUrl .= (empty($curPathUrl) ? '/' : '') . $urlElement . '/';
					$checking_page_id = url_to_postid($curPathUrl);
					if($checking_page_id === 0) {
						$created_page_id = $this->insertNewUrlPages($urlElement, $thisPostDate, $parent_id);
					}
					$parent_id = $checking_page_id === 0 ? $created_page_id : $checking_page_id;
					var_dump($curPathUrl, $checking_page_id, $created_page_id, $parent_id); echo '<br />';
				}
				//$this->insertNewUrlPages($thisUrl);
				echo '<br />';
			}
			$page_id = url_to_postid($thisUrl);
			$publishPage = get_post( $page_id );
			//var_dump($page_id,$publishPage); echo '<br />';
		}
		//$page_id = url_to_postid('_admin');
		//var_dump($page_id);
		//var_dump($importData);
		return;
		
	}
	
	protected function updateMetadata($importData) {
		echo '<br /><br />INSERTING<br />';
		$all_wp_pages = get_pages();
		//$all_wp_pages = array_slice($all_wp_pages, 0, 20);
		//$importData = array_slice($importData, 0, 2);
		//var_dump($importData);
		//var_dump(get_permalink($tmp[20]->ID));
		return;
		$updateMeta = false;
		for($idx = 0; $idx < count($all_wp_pages); $idx++) {
			$thisPageUrl = get_permalink($all_wp_pages[$idx]->ID);
			if(!empty($importData[$thisPageUrl])) {
				//$pageMeta = get_post_meta($all_wp_pages[$idx]->ID);
				$thisMetaTitle = get_post_meta( $all_wp_pages[$idx]->ID, '_yoast_wpseo_title');
				$thisMetaDesc = get_post_meta( $all_wp_pages[$idx]->ID, '_yoast_wpseo_metadesc');
				$newMetaTitle = $importData[$thisPageUrl][2];
				$newMetaDesc = $importData[$thisPageUrl][3];
				if($updateMeta) {
				update_post_meta( $all_wp_pages[$idx]->ID, '_yoast_wpseo_title', $newMetaTitle );
				update_post_meta( $all_wp_pages[$idx]->ID, '_yoast_wpseo_metadesc', $newMetaDesc );
				}
				var_dump($thisMetaTitle,$thisMetaDesc);
				echo $thisPageUrl . '<br />';
			}
		}
		return;		
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		global $wpdb;
		$passKey = $_GET['xyz'] === '1';
		if($passKey && $settings['selected_import_type'] === 'Publications') {
			if(!empty($settings['import_file']['url'])) {
				$publicationData = array();
				$csvArray = array_map('str_getcsv', file($settings['import_file']['url']));
				$labelArray = array_shift($csvArray);
				/*for($i = 0; $i < count($csvArray); $i++) {
					$publicationData[] = $csvArray[$i];
				}
				var_dump($publicationData);
				$this->insertPubliation($publicationData);*/
				for($i = 0; $i < count($csvArray); $i++) {
					$publicationData[$csvArray[$i][0]] = $csvArray[$i];
				}				
				//$this->updatePublication($publicationData);
			}
		} else if($passKey && $settings['selected_import_type'] === 'Scholarships') {
			if(!empty($settings['import_file']['url'])) {
				$scholarshipData = array();
				$csvArray = array_map('str_getcsv', file($settings['import_file']['url']));
				$labelArray = array_shift($csvArray);
				for($i = 0; $i < count($csvArray); $i++) {
					$scholarshipData[] = $csvArray[$i];
				}
				$this->insertScholarship($scholarshipData);
			}
		} else if($passKey && $settings['selected_import_type'] === 'Faculties') {
			if(!empty($settings['import_file']['url'])) {
				$facultyData = array();
				$csvArray = array_map('str_getcsv', file($settings['import_file']['url']));
				$labelArray = array_shift($csvArray);
				for($i = 0; $i < count($csvArray); $i++) {
					$facultyData[$csvArray[$i][1]] = $csvArray[$i];
				}
				//$this->insertFaculty($facultyData);
				//$this->insertLecturer($facultyData);
			}
		} else if($passKey && $settings['selected_import_type'] === 'Courses') {
			if(!empty($settings['import_file']['url'])) {
				$courseData = array();
				$csvArray = array_map('str_getcsv', file($settings['import_file']['url']));
				$labelArray = array_shift($csvArray);
				for($i = 0; $i < count($csvArray); $i++) {
					//$csvArray[$i][3] = str_replace(' ', '', $csvArray[$i][3]);
					$csvArray[$i][3] = rtrim($csvArray[$i][3]);
					$csvArray[$i][7] = rtrim($csvArray[$i][7]);
					$courseData[$csvArray[$i][3]] = $csvArray[$i];
				}
				//var_dump($courseData);
				//$this->insertCourse($courseData);
			}
		} else if($passKey && $settings['selected_import_type'] === 'News') {
			if(!empty($settings['import_file']['url'])) {
				$NewsData = array();
				$csvArray = array_map('str_getcsv', file($settings['import_file']['url']));
				$labelArray = array_shift($csvArray);
				for($i = 0; $i < count($csvArray); $i++) {
					$NewsData[$csvArray[$i][1]] = $csvArray[$i];
				}
				//var_dump($NewsData);
				//$this->insertNews($NewsData);
			}
		}  else if($passKey && $settings['selected_import_type'] === 'Faculty News') {
			if(!empty($settings['import_file']['url'])) {
				$facultyNewsData = array();
				$csvArray = array_map('str_getcsv', file($settings['import_file']['url']));
				$labelArray = array_shift($csvArray);
				for($i = 0; $i < count($csvArray); $i++) {
					$facultyNewsData[] = $csvArray[$i];
				}
				//var_dump($facultyNewsData);
				//$this->insertFacultyNews($facultyNewsData);
			}
		}  else if($passKey && $settings['selected_import_type'] === 'URL Pages') {
			if(!empty($settings['import_file']['url'])) {
				$urlPages = array();
				$csvArray = array_map('str_getcsv', file($settings['import_file']['url']));
				$labelArray = array_shift($csvArray);
				for($i = 0; $i < count($csvArray); $i++) {
					$urlPages[] = $csvArray[$i];
				}
				//var_dump($facultyNewsData);
				//$this->insertUrlPages($urlPages);
			}
		}  else if($passKey && $settings['selected_import_type'] === 'Meta Data') {
			if(!empty($settings['import_file']['url'])) {
				$urlPages = array();
				$csvArray = array_map('str_getcsv', file($settings['import_file']['url']));
				$labelArray = array_shift($csvArray);
				$metaUrlExist = array();
				$domainUrl = 'https://www.goulddev.com/';
				for($i = 0; $i < count($csvArray); $i++) {
					//echo substr($csvArray[$i][1],0,25) . '<br />';
					if(substr($csvArray[$i][1],0,strlen($domainUrl)) === $domainUrl) {
						$metaUrlExist[$csvArray[$i][1]] = $csvArray[$i];
					}
				}
				//$this->updateMetadata($metaUrlExist);
			}
		}
		?>
        <div class="import-data pt-100 pb-100">
			<strong>Data Import: </strong> <?php echo $settings['selected_import_type']; ?><br />
			<strong>Import File: </strong> <?php echo $settings['import_file']['url']; ?><br />
			<strong>Completed</strong>
        </div>
		<?php
	}
}
