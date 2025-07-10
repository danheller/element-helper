<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class News_JSON_Listing extends Element_El_Widget {
	
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
		return 'news-json-listing';
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
		return __( 'News JSON Listing', 'elementhelper' );
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
		return [ 'news', 'json', 'listing', 'newsjsonlisting' ];
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
			'news_category',
			[
				'label'              => __( 'News Category', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'' => __( 'News', 'elementhelper' ),
					'media-advisories' => __( 'Media Advisories', 'elementhelper' ),
					'redefined-blog' => __( 'Redefined Blog', 'elementhelper' ),
					//'news-election-law' => __( 'Election Law', 'elementhelper' ),
				],
				'default'            => '',
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
		$topicCategories = get_categories(
			array( 'parent' => $category['topics'] )
		);
		?>

		<div id="newsTop"></div>
		<div class="news-json-listing-wrapper <?php echo $settings['module_class']; ?>"></div>
		<div class="news-json-pagination-wrapper"></div>


		<script language="javascript">
(function ($) {
	$(document).ready(function () {
		
		function renderNews(data) {
			//console.log('data', data);
			var newsHTML = '';
			newsHTML += '<div class="news-json-listing-item-wrapper">';
			newsHTML += '<a href="'+data.news_link+'" class="full-size-link" target="_blank"></a>';
			newsHTML += '<div class="news-json-listing-item-image-wrapper">';
			newsHTML += '<a href="'+data.news_link+'" class="" target="_blank">';
			newsHTML += '<img src="'+(data.thumb || '/wp-content/uploads/2023/04/faculty-placeholder.png')+'" />';
			newsHTML += '</a>';
			newsHTML += '</div>';
			newsHTML += '<div class="news-json-listing-item-content-wrapper">';
			newsHTML += '<div class="news-json-listing-item-content-inner">';
			newsHTML += '<div class="news-json-listing-item-title-wrapper">';
			newsHTML += '<div class="news-json-listing-item-title">';
			newsHTML += '<a href="'+data.news_link+'" class="full-size-link" target="_blank">'+data.title+'</a>';
			newsHTML += '</div>';
			newsHTML += '</div>';
			newsHTML += '<div class="news-listing-item-description-wrapper">';
			newsHTML += '<div class="news-listing-item-description">'+data.description.replace('\"', '"')+'</div>';
			newsHTML += '</div>';
			newsHTML += '<div class="news-listing-item-date-source">';
			newsHTML += '<span class="news-listing-item-date">'+data.dateStr+'</span>';
			newsHTML += '</div>';
			newsHTML += '<div class="news-listing-item-footer-wrrapper">';
			newsHTML += '<span class="news-listing-item-more">';
			newsHTML += '<a href="'+data.news_link+'" target="_blank">Read More '+ '<?php echo icon_right_arrow(); ?>' +'</a>';
			newsHTML += '</span>';
			newsHTML += '</div>';
			newsHTML += '</div>';
			newsHTML += '</div>';
			newsHTML += '</div>';
			return newsHTML;
		}

		function generateNews(news) {
			var newsHTML = '';
			newsHTML += '<ul>';
			for( var i = 0; i < news.length; i++) {
				newsHTML += '<li>';
				newsHTML += renderNews(news[i], i);
				newsHTML += '</li>';
			}
			newsHTML += '</ul>';
			return newsHTML;
		}
		
		function generatePagination( cur, tot ) {
			//console.log('pagination', { cur, tot });
			var showNum = 7;
			var start = 1;
			var end = 7;
			var prevNum = 0;
			var nextNum = 0;
			if(cur > 4) {
				start = cur - 3;
				end = start + showNum - 1;
				if(end > tot) {
					var diff = tot - end;
					end = tot;
					start += diff;
				}
			}
			if(end > tot) {
				end = tot;
			}
			prevNum = cur > 1 ? cur - 1 : 1;
			nextNum = cur < tot ? cur + 1 : tot;
			var paginationHTML = '';
			paginationHTML += '<div class="news-pagination-inner">';
			paginationHTML += '<a href="#newsTop" class="goto-pageno arrow first '+ (cur === 1 ? ' disabled ' : '') + '" data-page="1"><i class="fa-solid fa-angles-left"></i></a>';
			paginationHTML += '<a href="#newsTop" class="goto-pageno arrow previous'+ (cur === 1 ? ' disabled ' : '') + '" data-page="'+prevNum+'"><i class="fa-solid fa-angle-left"></i></a>';
			paginationHTML += '<ul>';
			for ( var i = start; i <= end; i++ ) {
				paginationHTML += '<li><a href="#newsTop" class="goto-pageno '+(i === cur ? ' selected disabled ' : '')+' " data-page="' + i + '">' + i + '</a></li>';
			}
			paginationHTML += '</ul>';
			paginationHTML += '<a href="#newsTop" class="goto-pageno arrow next '+ (cur === tot ? ' disabled ' : '') + '" data-page="'+nextNum+'"><i class="fa-solid fa-angle-right"></i></a>';
			paginationHTML += '<a href="#newsTop" class="goto-pageno arrow last '+ (cur === tot ? ' disabled ' : '') + '" data-page="'+tot+'"><i class="fa-solid fa-angles-right"></i></a>';
			paginationHTML += '</div>';
			return paginationHTML;
		}
						
		function ajaxPost(pgNo) {
			var jsonFnameBase = '/wp-content/themes/usc/json/news/page' + (newsCategory.length ? '-' + newsCategory : '');
			var jsonFname = jsonFnameBase + '-' + pgNo + '.json';
			$.ajax({
				dataType: "json",
				url: jsonFname,
				crossDomain: true,
				success: function (news) {
					var newsHTML = generateNews(news.listing || []);
					var paginationHTML = generatePagination(news.pageNo, news.totPageNo);
					$('.news-json-listing-wrapper').html(newsHTML);
					$('.news-json-pagination-wrapper').html(paginationHTML);
					$('.news-json-pagination-wrapper a.goto-pageno').on('click', function(e) {
						if($(this).hasClass('disabled')) {
							e.preventDefault();
						} else {
							var loadPageNo = parseInt($(this).attr('data-page'));
							ajaxPost(loadPageNo);
							console.log('loadPageNo', loadPageNo);
						}
					});
					console.log('news', news);
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
		
		var curPg = (getUrlParam('pg')||'').length ? getUrlParam('pg') : 1;
		var newsCategory = '<?php echo $settings['news_category']; ?>';

		ajaxPost(curPg);

	});
})(jQuery);
		</script>

		<?php
	}

}