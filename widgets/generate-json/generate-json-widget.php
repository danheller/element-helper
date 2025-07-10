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

class Generate_JSON extends Element_El_Widget {

	protected $faculty_data_loaded = [];
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
		return 'generate-json';
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
		return __( 'Generate JSON', 'elementhelper' );
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
		return [ 'generate', 'json' ];
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
	
	protected function get_all_faculty_news($settings = []) {
		return get_posts([
			'post_type' => 'faculty_news',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => $settings['order'] ? $settings['order'] : 'ASC',
		]);
	}
	
	protected function get_all_posts($num=-1) {
		return get_posts([
			'post_type' => 'post',
			'post_status' => 'publish',
			'numberposts' => $num,
			'order'    => 'DESC',
		]);
	}
	
	protected function get_all_news($settings = []) {
		return get_posts([
			'post_type' => 'news',
			'post_status' => 'publish',
			'numberposts' => -1,
			'order'    => $settings['order'] ? $settings['order'] : 'ASC',
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
	
	protected function get_more_professor_info($professor) {
		//var_dump($professor); echo '<br /><br />';
		$professor->professor_first_name = get_post_meta($professor->ID, 'professor_first_name');
		$professor->professor_middle_name = get_post_meta($professor->ID, 'professor_middle_name');
		$professor->professor_last_name = get_post_meta($professor->ID, 'professor_last_name');
		$professor->professor_page_link = get_post_meta($professor->ID, 'professor_page_link');
		//$professor->professor_division = get_post_meta($professor->ID, 'professor_division');
		//$professor->professor_title = get_post_meta($professor->ID, 'professor_title');
		//$professor->professor_email = get_post_meta($professor->ID, 'professor_email');
		//$professor->professor_phone = get_post_meta($professor->ID, 'professor_phone');
		//$professor->professor_fax = get_post_meta($professor->ID, 'professor_fax');
		//$professor->professor_room = get_post_meta($professor->ID, 'professor_room');
		//$professor->professor_personal_website = get_post_meta($professor->ID, 'professor_personal_website');
		//$professor->professor_google_scholar_profile = get_post_meta($professor->ID, 'professor_google_scholar_profile');
		//$professor->professor_ssrn_author_page = get_post_meta($professor->ID, 'professor_ssrn_author_page');
		//$professor->professor_download_curriculum_vitae = get_post_meta($professor->ID, 'professor_download_curriculum_vitae');
		//$professor->professor_image = get_post_meta($professor->ID, 'professor_image');
		$professor->professor_last_updated = get_post_meta($professor->ID, 'professor_last_updated');

		$professor->professor_image = get_the_post_thumbnail_url($professor->ID) ?  get_the_post_thumbnail_url($professor->ID) : get_field('professor_image', $professor->ID);
		$professor->professor_image_alt = get_post_thumbnail_id($professor->ID) ? get_post_meta(get_post_thumbnail_id($professor->ID), '_wp_attachment_image_alt', TRUE) : '';
		//var_dump($professor); exit;
		//$professor->professor_biography = get_post_meta($professor->ID, 'professor_biography');
		//$professor->professor_publications = get_post_meta($professor->ID, 'professor_publications');
		$professor->professor_inactive = get_post_meta($professor->ID, 'professor_inactive');
		return $professor;
	}
	
	protected function get_professor_info($professor) {
		$professor_data = [];
		if(count($professor) && !empty($professor[0])) {
			if($this->faculty_data_loaded[intval($professor[0]->ID)] === NULL) {
				$args = array(
					'post_type'   => ['professors','lecturers'],
					'p' => intval($professor[0]->ID),
				);
				//var_dump($args); echo '<br /><br />';
				$tmp = get_posts($args);
				$professor_data = count($tmp) ? $tmp[0] : [];
				$this->get_more_professor_info($professor_data);
				$this->faculty_data_loaded[intval($professor[0]->ID)] = $professor_data;
			} else {
				$professor_data = $this->faculty_data_loaded[intval($professor[0]->ID)];
			}
		}
		return $professor_data;
	}
	
	function getTopicCategories() {
		return get_term_children(22, 'category');
	}
	
	protected function get_more_faculty_in_the_news_info($fitn) {
		$fitn->faculty_source = get_field('faculty_source', $fitn->ID);
		$fitn->faculty_news_title = get_field('faculty_news_title', $fitn->ID);
		$fitn->faculty_news_description = get_field('faculty_news_description', $fitn->ID);
		$fitn->faculty_news_link = get_field('faculty_news_link', $fitn->ID);
		//$fitn->faculty_news_date = date_format(date_create($fitn->post_date),"Ymd");
		//$fitn->faculty_news_date_str = date_format(date_create($fitn->post_date),"F j, Y");
		$fitn_tags = get_the_tags($fitn->ID);
		$args = array(
			'post_type'   => ['professors','lecturers'],
			'tag__in' => intval($fitn_tags[0]->term_id),
		);
		$tmp = get_posts($args);
		//var_dump($args, $tmp); echo '<br /><br />';
		$fitn->faculty_info = $this->get_professor_info($tmp);
		$fitn_categories = get_the_category($fitn->ID);
		$topicCategories = $this->getTopicCategories();
		//var_dump($fitn_categories); echo '<br /><br />';
		$fitn->topicCats = [];
		for( $idx = 0; $idx < count($fitn_categories); $idx++ ) {
			if(in_array($fitn_categories[$idx]->term_id, $topicCategories)) {
				$fitn_categories[$idx]->category_link = get_category_link( $fitn_categories[$idx]->term_id );
				array_push($fitn->topicCats, $fitn_categories[$idx]);
			}
		}
		//var_dump($thisIncludedCat); echo '<br /><br />';
		//return $fitn;
	}
	
	protected function selected_fitn($post) {
		$selPost = [];
		$professorFeaturedImage = get_the_post_thumbnail_url($post->faculty_info->ID);
		//$selPost['thumb'] = ( !empty($post->faculty_info) && !empty($post->faculty_info->professor_image[0]) ? $post->faculty_info->professor_image[0] : '/wp-content/uploads/2023/01/Shield_RegUse_Card_RGB-e1689801525916.jpg');
		$selPost['thumb'] = stripAllDomainForCronJob(! empty($professorFeaturedImage) ? $professorFeaturedImage : (!empty($post->faculty_info) && !empty($post->faculty_info->professor_image) ? $post->faculty_info->professor_image : '/wp-content/uploads/2023/01/Shield_RegUse_Card_RGB-e1689801525916.jpg') );
		$selPost['thumb_alt'] = $post->faculty_info->professor_image_alt;
		$selPost['year'] = date_format(date_create($post->post_date),"Y");
		$selPost['dateNum'] = date_format(date_create($post->post_date),"Ymd");
		$selPost['dateStr'] = date_format(date_create($post->post_date),"F j, Y");
		$selPost['source'] = $post->faculty_source;
		$selPost['title'] = $post->faculty_news_title;
		$selPost['description'] = str_replace(array("\n", "\r"), '', $post->faculty_news_description);
		$selPost['faculty_fname'] = $post->faculty_info->professor_first_name[0];
		$selPost['faculty_lname'] = $post->faculty_info->professor_last_name[0];
		$selPost['faculty_name'] = $selPost['faculty_fname'] . ' ' . $selPost['faculty_lname'];
		//$selPost['faculty_link'] = $post->faculty_info->professor_page_link[0];
		$selPost['faculty_link'] = stripAllDomainForCronJob(get_permalink($post->faculty_info->ID));
		//var_dump(get_permalink($post->faculty_info->ID)); echo '<br /><br />';
		$selPost['faculty_post_name'] = $post->faculty_info->post_name;

		$thisTopics = [];
		for( $tx = 0; $tx < count($post->topicCats); $tx++ ) {
			$thisTopics[] = Array( "title" => $post->topicCats[$tx]->name, "link" => stripAllDomainForCronJob($post->topicCats[$tx]->category_link), "tag" => $post->topicCats[$tx]->category_nicename );
		}
		$selPost['topic'] = $thisTopics;
		$selPost['link'] = $post->faculty_news_link;
		if(false && $post->ID === 83999) {
			//var_dump($post);
			var_dump($selPost);
		}
		return $selPost;
	}
	
	protected function generate_fitn() {
		$postPerPage = 20;
		$settings['order'] = 'DESC';
		$dbPosts = $this->get_all_faculty_news($settings);
		$totPageNo = ceil(count($dbPosts) / $postPerPage);
		$pageNum = 1;
		$curPosts = array();
		$postByName = array();
		$allPosts = array();
		$postByYear = array();
		$postByCategory = array();
		$postAllName = array();
		$postAllYear = array();
		$postAllCategories = array();
		$curNum = 0;
		$updateJson = true;
		foreach ( $dbPosts as $idx => $post ) {
			$this->get_more_faculty_in_the_news_info($post);
			$thisPost = $this->selected_fitn($post);
			if( ! empty($thisPost['faculty_post_name']) ) {
				if( $postByName[$thisPost['faculty_post_name']] === NULL ) {
					$postByName[$thisPost['faculty_post_name']] = array();
					$postAllName[$thisPost['faculty_post_name']] = $thisPost['faculty_name'];
					//$postAllName[$thisPost['faculty_post_name']] = $thisPost['faculty_name'];
				}
				$postByName[$thisPost['faculty_post_name']][] = $thisPost;
			}
			if( ! empty($thisPost['year']) ) {
				if( $postByYear[$thisPost['year']] === NULL ) {
					$postByYear[$thisPost['year']] = array();
					$postAllYear[] = $thisPost['year'];
				}
				$postByYear[$thisPost['year']][] = $thisPost;
			}
			if( ! empty($thisPost['topic']) ) {
				//var_dump($thisPost); echo '<br /><br />';
				foreach( $thisPost['topic'] as $idx => $eachTopic ) {
					if( $postByCategory[$eachTopic['tag']] === NULL ) {
						$postByCategory[$eachTopic['tag']] = array();
						$postAllCategories[$eachTopic['tag']] = $eachTopic['title'];
					}
					$postByCategory[$eachTopic['tag']][] = $thisPost;
				}
			}
			$allPosts[] = $thisPost;
			if($curNum < $postPerPage) {
				$curPosts[] = $thisPost;
				$curNum++;
			} else {
				$exportPost = array( "listing" => $curPosts, "pageNo" => $pageNum, "totPageNo" => $totPageNo);
				$jsonPost = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
				//$jsonPost = json_encode($exportPost, JSON_HEX_QUOT);
				$jsonFname = 'page-' .$pageNum .'.json';
				$jsonFile = get_template_directory()."/json/faculty-in-the-news/".$jsonFname;
				if($updateJson) {
					file_put_contents($jsonFile, $jsonPost);
				}
				$pageNum++;
				$curNum = 0;
				$curPosts = [];
				$curPosts[] = $thisPost;
				$curNum++;
			}
		}
		//var_dump($curPosts); exit;
		
		if( !empty($curPosts)) {
			$exportPost = array( "listing" => $curPosts, "pageNo" => $pageNum, "totPageNo" => $totPageNo);
			$jsonPost = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
			//$jsonPost = json_encode($exportPost, JSON_HEX_QUOT);
			$jsonFname = 'page-' .$pageNum .'.json';
			$jsonFile = get_template_directory()."/json/faculty-in-the-news/".$jsonFname;
			if($updateJson) {
				file_put_contents($jsonFile, $jsonPost);
			}
		}
		//var_dump($pageNum, count($curPosts)); echo '<br />';
		
		//$jsonAllPost = json_encode($allPosts, JSON_HEX_QUOT | JSON_HEX_TAG);
		//var_dump($jsonAllPost);
		//$jsonFile = get_template_directory()."/json/faculty-in-the-news/page-all.json";
		//file_put_contents($jsonFile, $jsonAllPost);

		// Generate JSON by Faculty Name
		ksort($postByName);
		foreach ($postByName as $key => $val) {
			//var_dump($key, count($val)); echo '<br /><br />';
			$exportPost = array( "listing" => $val, "recNo" => 1, "totRecNo" => count($val));
			$postByNameVal = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
			$jsonFile = get_template_directory()."/json/faculty-in-the-news/page-".$key.".json";
			//var_dump($jsonFile, $postByNameVal); echo '<br /><br />';
			if($updateJson) {
				file_put_contents($jsonFile, $postByNameVal);
			}
		}
		
		ksort($postAllName);
		//var_dump($postAllName);
		$postAllNameVal = json_encode($postAllName, JSON_HEX_QUOT | JSON_HEX_TAG);
		$jsonFile = get_template_directory()."/json/faculty-in-the-news/page-all-names.json";
		//var_dump($jsonFile, $postAllNameVal); echo '<br /><br />';
		if($updateJson) {
			file_put_contents($jsonFile, $postAllNameVal);
		}
		
		// Generate JSON by Year Name
		//var_dump($postByYear);
		foreach ($postByYear as $key => $val) {
			//var_dump($key, count($val)); echo '<br /><br />';
			$exportPost = array( "listing" => $val, "recNo" => 1, "totRecNo" => count($val));
			$postByYearVal = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
			$jsonFile = get_template_directory()."/json/faculty-in-the-news/page-year-".$key.".json";
			//var_dump($jsonFile, $postByYearVal); echo '<br /><br />';
			if($updateJson) {
				file_put_contents($jsonFile, $postByYearVal);
			}
		}
		
		arsort($postAllYear);
		//var_dump($postAllYear);
		$postAllNameVal = json_encode($postAllYear, JSON_HEX_QUOT | JSON_HEX_TAG);
		$jsonFile = get_template_directory()."/json/faculty-in-the-news/page-all-years.json";
		//var_dump($jsonFile, $postAllNameVal); echo '<br /><br />';
		if($updateJson) {
			file_put_contents($jsonFile, $postAllNameVal);
		}
		
		// Generate JSON by Category Name
		ksort($postByCategory);
		//var_dump($postByCategory);
		foreach ($postByCategory as $key => $val) {
			//var_dump($key, count($val)); echo '<br /><br />';
			$exportPost = array( "listing" => $val, "recNo" => 1, "totRecNo" => count($val));
			$postByCategoryVal = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
			$jsonFile = get_template_directory()."/json/faculty-in-the-news/page-cat-".$key.".json";
			//var_dump($jsonFile, $postByYearVal); echo '<br /><br />';
			if($updateJson) {
				file_put_contents($jsonFile, $postByCategoryVal);
			}
		}
		
		ksort($postAllCategories);
		//var_dump($postAllName);
		$postAllCategoriesVal = json_encode($postAllCategories, JSON_HEX_QUOT | JSON_HEX_TAG);
		$jsonFile = get_template_directory()."/json/faculty-in-the-news/page-all-categories.json";
		//var_dump($jsonFile, $postAllNameVal); echo '<br /><br />';
		if($updateJson) {
			file_put_contents($jsonFile, $postAllCategoriesVal);
		}
		
		
		//var_dump($dbPosts);
	}
	
	protected function get_more_news_info($news) {
		$thisID = $news->ID;
		$news->news_title = get_field('news_title', $thisID);
		$news->news_image = get_field('news_image', $thisID);
		$news->news_header_body_by = get_field('news_header_body_by', $thisID);
		$news->news_body = get_field('news_body', $thisID);
		$news->news_display = get_field('news_display', $thisID);
		$news->news_brief_description = get_field('news_brief_description', $thisID);
		$news->news_meta_description = get_field('news_meta_description', $thisID);
		$news->news_meta_robots = get_field('news_meta_robots', $thisID);
		$news_tags = get_the_tags($thisID);
		$news_categories = get_the_category($thisID);
		$topicCategories = $this->getTopicCategories();
		//var_dump($news_categories); echo '<br /><br />';
		$news->topicCats = [];
		for( $idx = 0; $idx < count($news_categories); $idx++ ) {
			if(true || in_array($news_categories[$idx]->term_id, $topicCategories)) {
				$news_categories[$idx]->category_link = get_category_link( $news_categories[$idx]->term_id );
				array_push($news->topicCats, $news_categories[$idx]);
			}
		}
		//var_dump($thisIncludedCat); echo '<br /><br />';
		//return $fitn;
	}

	protected function selected_news($post) {
		$selPost = [];
		$selFeaturedImage = get_the_post_thumbnail_url($post->ID, 'large');
		$selFeaturedImage = str_replace("http://goulddev.usc.edu", "", $selFeaturedImage);
		$selPost['thumb'] = ! empty($selFeaturedImage) ? $selFeaturedImage : ( ! empty($post->news_image) ? $post->news_image : '/wp-content/uploads/2023/04/faculty-placeholder.png');
		$selPost['year'] = date_format(date_create($post->post_date),"Y");
		$selPost['dateNum'] = date_format(date_create($post->post_date),"Ymd");
		$selPost['dateStr'] = date_format(date_create($post->post_date),"F j, Y");
		$selPost['title'] = $post->post_title;
		$selPost['description'] = $post->news_brief_description;
		$selPost['news_link'] = get_permalink($post->ID);

		$thisTopics = [];
		$thisTopicTags = [];
		for( $tx = 0; $tx < count($post->topicCats); $tx++ ) {
			$thisTopics[] = Array( "title" => $post->topicCats[$tx]->name, "link" => $post->topicCats[$tx]->category_link, "tag" => $post->topicCats[$tx]->category_nicename );
			array_push($thisTopicTags, $post->topicCats[$tx]->category_nicename);
		}
		$selPost['topic'] = $thisTopics;
		$selPost['topic_tag'] = $thisTopicTags;
		$selPost['link'] = $post->faculty_news_link;
		return $selPost;
	}
	
	protected function generate_json_pp($allPosts, $postPerPage, $pageName, $jsonPath, $updateJson) {
		$totPageNo = intval(ceil(count($allPosts) / $postPerPage));
		$pageNum = 1;
		$curPosts = array();
		$curNum = 0;
		foreach ( $allPosts as $idx => $post ) {
			if($curNum < $postPerPage) {
				$curPosts[] = $post;
				$curNum++;
			} else {
				$exportPost = array( "listing" => $curPosts, "pageNo" => $pageNum, "totPageNo" => $totPageNo);
				$jsonPost = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
				$jsonFname = $pageName . '-' .$pageNum .'.json';
				$jsonFile = get_template_directory().$jsonPath.$jsonFname;
				if($updateJson) {
					file_put_contents($jsonFile, $jsonPost);
				}
				$pageNum++;
				$curNum = 0;
				$curPosts = [];
				$curPosts[] = $post;
				$curNum++;
			}
		}
		if( !empty($curPosts)) {
			$exportPost = array( "listing" => $curPosts, "pageNo" => $pageNum, "totPageNo" => $totPageNo);
			$jsonPost = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
			$jsonFname = $pageName . '-' . $pageNum .'.json';
			$jsonFile = get_template_directory().$jsonPath.$jsonFname;
			if($updateJson) {
				file_put_contents($jsonFile, $jsonPost);
			}
		}
		if( !empty($allPosts)) {
			$exportAllPost = array( "listing" => $allPosts, "pageNo" => 1, "totPageNo" => 1, "totalRecord" => count($allPosts));
			$jsonAllPost = json_encode($exportAllPost, JSON_HEX_QUOT | JSON_HEX_TAG);
			$jsonAllFname = $pageName . '.json';
			$jsonAllFile = get_template_directory().$jsonPath.$jsonAllFname;
			if($updateJson) {
				file_put_contents($jsonAllFile, $jsonAllPost);
			}
		}
	}
	
	function generate_news() {
		$subTags = array();
		$subTagsPosts = array();
		$topicCategories = get_categories(
			array( 'parent' => 22 )
		);
		foreach ( $topicCategories as $idx => $topicCategory ) {
			$subTagsPosts['news-' . $topicCategory->category_nicename] = array();
			$subTagsPosts['media-advisories-' . $topicCategory->category_nicename] = array();
			$subTagsPosts['redefined-blog-' . $topicCategory->category_nicename] = array();
			$subTags[] = $topicCategory->category_nicename;
		};
		$additionalCategories = ['undergraduate-law','jd','gip','alumni','clinics','giving','faculty','student','staff'];
		$subTags = array_merge($subTags, $additionalCategories);
		foreach ( $additionalCategories as $idx => $category ) {
			$subTagsPosts['news-' . $category] = array();
			$subTagsPosts['media-advisories-' . $category] = array();
			$subTagsPosts['redefined-blog-' . $category] = array();
		};
		//var_dump($subTagsPosts);
		$postPerPage = 24;
		$settings['order'] = 'DESC';
		$dbPosts = $this->get_all_news($settings);
		//var_dump($dbPosts);
		//$dbPosts = array_slice($dbPosts, 0, 24);
		$totPageNo = intval(ceil(count($dbPosts) / $postPerPage));
		$pageNum = 1;
		$curPosts = array();
		$mediaPosts = array();
		$redefinedPosts = array();
		$postAllYear = [];
		$curNum = 0;
		$updateJson = false;
		foreach ( $dbPosts as $idx => $post ) {
			//var_dump($post); echo '<br /><br />';
			$this->get_more_news_info($post);
			$thisPost = $this->selected_news($post);
			//var_dump($thisPost['topic_tag'], in_array('hidden-articles', $thisPost['topic_tag'])); echo '<br />';
			if(!in_array('hidden-articles', $thisPost['topic_tag'])) {
				if(!in_array($thisPost['year'], $postAllYear)) {
					$postAllYear[] = $thisPost['year'];
				}
				if( ! isset($subTagsPosts['news-year-' . $thisPost['year']])) {
					$subTagsPosts['news-year-' . $thisPost['year']] = array();
				}
				$subTagsPosts['news-year-' . $thisPost['year']][] = $thisPost;
				if(in_array('media-advisories', $thisPost['topic_tag'])) {
					$mediaPosts[] = $thisPost;
					if( ! isset($subTagsPosts['media-advisories-year-' . $thisPost['year']])) {
						$subTagsPosts['media-advisories-year-' . $thisPost['year']] = array();
					}
					$subTagsPosts['media-advisories-year-' . $thisPost['year']][] = $thisPost;
				}
				if(in_array('redefined-blog', $thisPost['topic_tag'])) {
					$redefinedPosts[] = $thisPost;
					if( ! isset($subTagsPosts['redefined-blog-year-' . $thisPost['year']])) {
						$subTagsPosts['redefined-blog-year-' . $thisPost['year']] = array();
					}
					$subTagsPosts['redefined-blog-year-' . $thisPost['year']][] = $thisPost;
				}
				foreach($subTags as $ix => $subTag) {
					if(in_array($subTag, $thisPost['topic_tag'])) {
						$subTagsPosts['news-' . $subTag][] = $thisPost;
						if(in_array('media-advisories', $thisPost['topic_tag'])) {
							$subTagsPosts['media-advisories-' . $subTag][] = $thisPost;
						}
						if(in_array('redefined-blog', $thisPost['topic_tag'])) {
							$subTagsPosts['redefined-blog-' . $subTag][] = $thisPost;
						}
					}
				}
				//var_dump(in_array('media-advisories', $thisPost['topic_tag']),$thisPost); echo '<br /><br />';
				if($curNum < $postPerPage) {
					$curPosts[] = $thisPost;
					$curNum++;
				} else {
					$exportPost = array( "listing" => $curPosts, "pageNo" => $pageNum, "totPageNo" => $totPageNo);
					$jsonPost = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
					$jsonFname = 'page-' .$pageNum .'.json';
					$jsonFile = get_template_directory()."/json/news/".$jsonFname;
					if($updateJson) {
						file_put_contents($jsonFile, $jsonPost);
					}
					$pageNum++;
					$curNum = 0;
					$curPosts = [];
					$curPosts[] = $thisPost;
					$curNum++;
				}
			}
		}
		if( !empty($curPosts)) {
			$exportPost = array( "listing" => $curPosts, "pageNo" => $pageNum, "totPageNo" => $totPageNo);
			$jsonPost = json_encode($exportPost, JSON_HEX_QUOT | JSON_HEX_TAG);
			//$jsonPost = json_encode($exportPost, JSON_HEX_QUOT);
			$jsonFname = 'page-' .$pageNum .'.json';
			$jsonFile = get_template_directory()."/json/news/".$jsonFname;
			if($updateJson) {
				file_put_contents($jsonFile, $jsonPost);
			}
		}
		
		// Generate JSON by Media Advisories Category
		if( ! empty($mediaPosts) ) {
			$this->generate_json_pp($mediaPosts, $postPerPage, 'page-media-advisories', '/json/news/', $updateJson);
		}

		// Generate JSON by Media Advisories Category
		if( ! empty($redefinedPosts) ) {
			$this->generate_json_pp($redefinedPosts, $postPerPage, 'page-redefined-blog', '/json/news/', $updateJson);
		}

		foreach ( array_keys($subTagsPosts) as $key ) {
			$thisPageName = 'page-' . $key;
			//var_dump($key, count($subTagsPosts[$key]), $thisPageName); echo '<br />';
			$this->generate_json_pp($subTagsPosts[$key], $postPerPage, $thisPageName, '/json/news/', $updateJson);
		}
		
		// Generate Year json
		arsort($postAllYear);
		//var_dump($postAllYear);
		$postAllNameVal = json_encode($postAllYear, JSON_HEX_QUOT | JSON_HEX_TAG);
		$jsonFile = get_template_directory()."/json/news/page-all-years.json";
		//var_dump($jsonFile, $postAllNameVal); echo '<br /><br />';
		if($updateJson) {
			file_put_contents($jsonFile, $postAllNameVal);
		}
		//var_dump($postAllYear);

	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		global $wpdb;
		$passKey = $_GET['xyz'] === '1';
		$mode = $_GET['mode'] !== NULL ? $_GET['mode'] : '';
		$modeName = 'No match';
		if($mode === 'fitn') {
			$modeName = 'Faculty in the News';
		} else if($mode === 'news') {
			$modeName = 'News';
		} else if($mode === 'scholarship') {
			$modeName = 'Scholarship';
		}
		
		if($passKey) {
			?>
			<div class="generate-json pt-25 pb-25">
				<strong>Generating JSON: <?php echo $modeName; ?></strong>
			</div>
			<?php
			if($mode === 'fitn') {
				$this->generate_fitn();
			}
			if($mode === 'news') {
				// function is in inc/cron_jobs.php
				generate_news_json_cron_action();
			}
			if($mode === 'scholarship') {
				// function is in inc/cron_jobs.php
				generate_scholarship_json_cron_action();
			}
		} else {
			?>
			<div class="generate-json pt-100 pb-100">
				<strong>Generate JSON: What's the magic word?</strong>
			</div>
			<?php
		}
		?>
		<?php
	}
}
