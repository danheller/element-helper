<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class News_Listing extends Element_El_Widget {
	
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
		return 'news-listing';
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
		return __( 'News Listing', 'elementhelper' );
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
		return [ 'news', 'listing', 'facultyinthenewslisting' ];
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

		<div class="faculty-in-the-news-listing-wrapper <?php echo $settings['module_class']; ?>">
			<?php if($settings['show_filter'] === 'yes' ) { ?>

<div class="page-drawer-wrapper">
	<div class="page-drawer-inner">
		<div class="page-filter-close">
			<a href="#" class="close-page-drawer"></a>
		</div>
		<div class="page-drawer-label">
			<img src="/wp-content/uploads/2023/06/icon-filter.png" alt="Filter icon"> Filter
		</div>
		<div class="page-filter-drawer type open always-open">
			<label data-id="type">News Type <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content type">
				<select class="type-dropdown" name="type">
					<option value="news">USC Gould News</option>
					<option value="media-advisories">Media Advisories</option>
					<option value="redefined-blog">Redefined Blog</option>
				</select>
			</div>
		</div>
		<div class="page-filter-drawer interest">
			<label data-id="interest">Area of Interest <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content interest">
				<select class="interest-dropdown" name="interest">
					<option value=""></option>
				</select>
			</div>
		</div>
		<div class="page-filter-drawer year">
			<label data-id="year">Year <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content year">
				<select class="year-dropdown" name="year">
					<option value=""></option>
				</select>
			</div>
		</div>
		<div class="page-filter-drawer academics">
			<label data-id="academics">Academics <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content academics">
				<select class="academics-dropdown" name="academics">
					<option value=""></option>
					<option value="undergraduate-law">Undergraduate Law Programs</option>
					<option value="jd">JD Program</option>
					<option value="gip">Graduate & International Programs</option>
				</select>
			</div>
		</div>
		<div class="page-filter-drawer community">
			<label data-id="community">Community Stories <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content community">
				<select class="community-dropdown" name="community">
					<option value=""></option>
					<option value="alumni">Alumni</option>
					<option value="clinics">Clinics</option>
					<option value="giving">Giving</option>
					<option value="faculty">Faculty</option>
					<option value="staff">Staff</option>
					<option value="student">Students</option>
				</select>
			</div>
		</div>
		<div class="page-filter-drawer magazine">
			<label data-id="magazine">USC Law Magazine Issue <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content magazine">
				<select class="magazine-dropdown" name="magazine">
					<option value=""></option>
				</select>
			</div>
		</div>
		<div class="page-filter-apply">
			<a href="#" class="filter-apply-action btn btn-primary btn-wider">Apply</a>
		</div>
	</div>
</div>

			<?php } ?>
			<!--<div class="news-listing-wrapper background-ltgrey pt-50 pb-50">
				<div class="news-listing-items" id="newsTop"></div>
				<div class="news-pagination-wrapper"></div>
			</div>-->
		</div>


		<script language="javascript">
(function ($) {
	$(document).ready(function () {
		
		<?php if($settings['show_filter'] === 'yes' ) { ?>
		$('.news-listing-filter-wrapper').html(generateFilterWrapper());
		<?php } ?>
		
		function closeFdDrawer() {
			$('.page-drawer-wrapper').removeClass('open');
			$('body').removeClass('overflow-hidden');
		}
		
		$('.open-page-drawer-action').on('click', function(e) {
			e.preventDefault();
			$('.page-drawer-wrapper').addClass('open');
			$('body').addClass('overflow-hidden');
		});
		$('.close-page-drawer').on('click', function(e) {
			e.preventDefault();
			closeFdDrawer();
		});
		
		$('.page-filter-drawer > label').on('click', function(e) {
			var filterType = $(this).attr('data-id');
			var isOpen = $('.page-filter-drawer.'+filterType).hasClass('open');
			var isAlwaysOpen = $('.page-filter-drawer.'+filterType).hasClass('always-open');
			if(isOpen && !isAlwaysOpen) {
				$('.page-filter-drawer.'+filterType).removeClass('open');
			} else {
				$('.page-filter-drawer.'+filterType).addClass('open');
			}
		});
		$('.page-filter-apply a.apply-btn').on('click', function(e) {
			e.preventDefault();
			closeFdDrawer();
		});
		
		function renderNews(data) {
			//console.log('data', data);
			var newsHTML = '';
			newsHTML += '<div class="news-listing-item-wrapper">';
			newsHTML += '<a href="'+data.news_link+'" class="full-size-link" target="_self" aria-label="Click to read more about '+data.title+'"><span class="hide">Click here</span></a>';
			newsHTML += '<div class="news-listing-item-image-wrapper">';
			newsHTML += '<a href="'+data.news_link+'" class="" target="_self" aria-label="Click to read more about '+data.title+'">';
			newsHTML += '<img src="'+(data.thumb || '/wp-content/uploads/2023/04/faculty-placeholder.png')+'" alt="'+(data.thumb_alt || '')+'" />';
			newsHTML += '</a>';
			newsHTML += '</div>';
			newsHTML += '<div class="news-listing-item-content-wrapper">';
			newsHTML += '<div class="news-listing-item-content-inner">';
			newsHTML += '<div class="news-listing-item-topic">';
			if(data.topic.length) {
				for( var i = 0; i < data.topic.length; i++ ) {
					newsHTML += '<span><a href="'+data.topic[i].link+'">'+data.topic[i].title+'</a></span>';
				}
			}
			newsHTML += '</div>';
			newsHTML += '<div class="news-listing-item-title-wrapper">';
			newsHTML += '<div class="news-listing-item-title">'+data.title+'</div>';
			newsHTML += '</div>';
			newsHTML += '<div class="news-listing-item-date-source">';
			newsHTML += '<span class="news-listing-item-date">'+data.dateStr+'</span>';
			newsHTML += '</div>';
			newsHTML += '<div class="news-listing-item-description-wrapper">';
			newsHTML += '<div class="news-listing-item-description">'+data.description.replace('\"', '"')+'</div>';
			newsHTML += '</div>';
			newsHTML += '<div class="news-listing-item-footer-wrrapper">';
			newsHTML += '<span class="news-listing-item-more">';
			newsHTML += '<a href="'+data.news_link+'" target="_self" aria-label="Click to read more about '+data.title+'">Read More '+ '<?php echo icon_right_arrow(); ?>' +'</a>';
			newsHTML += '</span>';
			newsHTML += '</div>';
			newsHTML += '</div>';
			newsHTML += '</div>';
			newsHTML += '</div>';
			return newsHTML;
		}

		function getUrlVars() {
			var vars = {};
			var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
				vars[key] = value;
			});
			return vars;
		}

		function getUrlParam(parameter, defaultvalue){
			var urlparameter = defaultvalue;
			if(window.location.href.indexOf(parameter) > -1){
				urlparameter = getUrlVars()[parameter] || defaultvalue;
			}
			return urlparameter;
		}
		
		function generateNewsRest(news) {
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
		
		function generateNews(news) {
			//console.log('generateNews', news);
			var newsHTML = '';
			var topNewsHTML = '';
			var bottomNewsHTML = '';
			var isSplit = false;
			var hasOpenUL = false;
			for( var i = 0; i < news.length; i++) {
				if(!isSplit) {
					if(bigNewsPos.includes(i)) {
						if(hasOpenUL) {
							topNewsHTML += '</ul>';
							topNewsHTML += '</div>';
							hasOpenUL = false;
						}
						topNewsHTML += '<div class="main-news">';
						topNewsHTML += '<div class="container">';
						topNewsHTML += renderNews(news[i], i);
						topNewsHTML += '</div>';
						topNewsHTML += '</div>';
					} else {
						if(i === 14) {
							if(hasOpenUL) {
								topNewsHTML += '</ul>';
								topNewsHTML += '</div>';
								hasOpenUL = false;
							}
							isSplit = true;
							bottomNewsHTML += '<div class="container">';
							bottomNewsHTML += '<ul>';
							hasOpenUL = true;
							bottomNewsHTML += '<li>';
							bottomNewsHTML += renderNews(news[i], i);
							bottomNewsHTML += '</li>';
						} else {
							if(!hasOpenUL) {
								topNewsHTML += '<div class="container">';
								topNewsHTML += '<ul>';
								hasOpenUL = true;
							}
							topNewsHTML += '<li>';
							topNewsHTML += renderNews(news[i], i);
							topNewsHTML += '</li>';
						}
					}
				} else {
					if(bigNewsPos.includes(i)) {
						if(hasOpenUL) {
							bottomNewsHTML += '</ul>';
							bottomNewsHTML += '</div>';
							hasOpenUL = false;
						}
						bottomNewsHTML += '<div class="main-news">';
						bottomNewsHTML += '<div class="container">';
						bottomNewsHTML += renderNews(news[i], i);
						bottomNewsHTML += '</div>';
						bottomNewsHTML += '</div>';
					} else {
						if(!hasOpenUL) {
							bottomNewsHTML += '<div class="container">';
							bottomNewsHTML += '<ul>';
							hasOpenUL = true;
						}
						bottomNewsHTML += '<li>';
						bottomNewsHTML += renderNews(news[i], i);
						bottomNewsHTML += '</li>';
					}					
				}
			}
			if(!isSplit) {
				if(hasOpenUL) {
					topNewsHTML += '</ul>';
					topNewsHTML += '</div>';
				}
			} else {
				if(hasOpenUL) {
					bottomNewsHTML += '</ul>';
					bottomNewsHTML += '</div>';
				}
			}
			//console.log('newsHTML',{newsHTML});
			return {top: topNewsHTML, bottom: bottomNewsHTML};
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
		
		function generateFilterWrapper() {
			var filterHTML = '';
			filterHTML += '<div class="container">';
			filterHTML += '<div class="news-filter">';
			filterHTML += '<a href="#" class="open-page-drawer-action" aria-label="Click to open filter drawer"><img src="/wp-content/uploads/2023/06/icon-filter.png" alt="Filter icon"> Filter News</a>';
			filterHTML += '<span class="selected-filter-wrapper hide"></span>';
			filterHTML += '</div>';
			filterHTML += '</div>';
			return filterHTML;
		}
		
		function findMatchTopic(thisTopic) {
			for( var j = 0; j < thisTopic.length; j++ ) {
				if(thisTopic[j].tag === topicVal) {
					return 1;
				}
			}
			return 0;
		}
		
		function filteredNewsData(news) {
			var addtl = additionalFilter.length;
			for(var i = news.listing.length - 1; i >= 0; i--) {
				var count = addtl;
				for(var j = 0; j < additionalFilter.length; j++) {
					count -= (news.listing[i].topic_tag.includes(additionalFilter[j]) ? 1 : 0);
				}
				if(count > 0) {
					news.listing.splice(i, 1);
				}
			}
			selectedListing = $.extend(true,{}, news);
			news.listing = news.listing.splice(0,recPerPage);
		}
		
		function ajaxPost(jsonFname, pgNo) {
			$.ajax({
				dataType: "json",
				url: jsonFname,
				crossDomain: true,
				success: function (news) {
					//console.log('news', news);
					var newsHTML = '';
					if(subCatCount >= 2) {
						filteredNewsData(news);
						news.totPageNo = Math.ceil(selectedListing.listing.length / recPerPage);
					} else {
						
					}
					if(pgNo === 1) {
						newsHTML = generateNews(news.listing || []);
						$('.news-listing-top-wrapper').html(newsHTML.top);
						$('.news-listing-bottom-wrapper').html(newsHTML.bottom);
					} else {
						newsHTML = generateNewsRest(news.listing || []);
						$('.load-more-item-wrapper .container').append(newsHTML);
					}
					if(news.pageNo < news.totPageNo) {
						$('a.load-more-btn').attr('next-page', news.pageNo + 1);
					} else {
						$('a.load-more-btn').addClass('hide');
					}
					//console.log('news', {jsonFname,news,jsonMode,selectedListing,additionalFilter});
					closeFdDrawer();
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
		
		function ajaxPostFilterData(jsonFname, mode) {
			$.ajax({
				dataType: "json",
				url: jsonFname,
				crossDomain: true,
				success: function (fdata) {
					//console.log(mode, fdata);
					if(mode === 'year') {
						for ( var i = 0; i < fdata.length; i++ ) {
							$('.year-dropdown').append('<option value="'+ fdata[i] +'">' + fdata[i] + '</option>');
						}
						$('.year-dropdown').select2({ placeholder: 'Search by Year', allowClear: true });
					}
					if(mode === 'interest') {
						var fkey = Object.keys(fdata);
						for ( var i = 0; i < fkey.length; i++ ) {
							$('.interest-dropdown').append('<option value="'+ fkey[i] +'">' + fdata[fkey[i]] + '</option>');
						}
						$('.interest-dropdown').select2({ placeholder: 'Search by Topic', allowClear: true });
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
		
		$('a.load-more-btn').on('click', function(e) {
			e.preventDefault();
			var nextPage = parseInt($(this).attr('next-page'));
			//console.log('nextPage', {jsonMode,nextPage});
			if(subCatCount >= 2) {
				var news = { listing: [], pageNo: nextPage, totPageNo:nextPage  };
				news.totPageNo = Math.ceil(selectedListing.listing.length / recPerPage);
				news.listing = selectedListing.listing.splice( (nextPage - 1) * recPerPage, recPerPage );
				//console.log('nextPage', {selectedListing, news});
				var newsHTML = generateNewsRest(news.listing || []);
				$('.load-more-item-wrapper .container').append(newsHTML);
				if(news.pageNo < news.totPageNo) {
					$('a.load-more-btn').attr('next-page', news.pageNo + 1);
				} else {
					$('a.load-more-btn').addClass('hide');
				}
			} else {
				jsonFname = jsonFnameBase + '-' + nextPage + '.json';
				ajaxPost(jsonFname, nextPage);
			}
		});
		
		$('.type-dropdown').select2({ });
		$('.academics-dropdown').select2({ placeholder: 'Search by Academics', allowClear: true }).val(null).trigger('change');
		$('.community-dropdown').select2({ placeholder: 'Search by Community', allowClear: true }).val('').trigger('change');
		
		var jsonYearNames = '/wp-content/themes/usc/json/news/page-all-years.json';
		var jsonInterestNames = '/wp-content/themes/usc/json/news/page-all-categories.json';
		ajaxPostFilterData(jsonYearNames, 'year');
		ajaxPostFilterData(jsonInterestNames, 'interest');

		var typeVal = getUrlParam('type', '');
		var interestVal = '';
		var yearVal = '';
		var academicsVal = '';
		var communityVal = '';
		var magazineVal = '';
		var jsonMode = 'news';
		var selectedListing = { listing: [] };
		var recPerPage = 24;
		var bigNewsPos = [0,7,17];
		var subCatCount = 0;
		var additionalFilter = [];

		var curPg = (getUrlParam('pg')||'').length ? getUrlParam('pg') : 1;
		var jsonFnameBase = '/wp-content/themes/usc/json/news/page';
		var jsonFname = jsonFnameBase + '-' + curPg + '.json';
		ajaxPost(jsonFname, curPg);

		function getSubCategoryFilter() {
			if(yearVal.length) {
				//console.log('yearVal', {yearVal,subCatCount});
				if(typeVal === 'media-advisories') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-media-advisories-year-' + yearVal;
				} else if (typeVal === 'redefined-blog') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-redefined-blog-year-' + yearVal;
				} else {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-news-year-' + yearVal;
				}
				jsonFname = jsonFnameBase + (subCatCount === 1 ? '-1' : '') + '.json';
				additionalFilter = [interestVal,academicsVal,communityVal];
			} else if (interestVal.length) {
				//console.log('interestVal', {interestVal,subCatCount});
				if(typeVal === 'media-advisories') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-media-advisories-' + interestVal;
				} else if (typeVal === 'redefined-blog') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-redefined-blog-' + interestVal;
				} else {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-news-' + interestVal;
				}
				jsonFname = jsonFnameBase + (subCatCount === 1 ? '-1' : '') + '.json';
				additionalFilter = [academicsVal,communityVal];
			} else if (academicsVal.length) {
				//console.log('academicsVal', {academicsVal,subCatCount});
				if(typeVal === 'media-advisories') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-media-advisories-' + academicsVal;
				} else if (typeVal === 'redefined-blog') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-redefined-blog-' + academicsVal;
				} else {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-news-' + academicsVal;
				}
				jsonFname = jsonFnameBase + (subCatCount === 1 ? '-1' : '') + '.json';
				additionalFilter = [communityVal];
			} else if (communityVal.length) {
				//console.log('communityVal', {communityVal,subCatCount});
				if(typeVal === 'media-advisories') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-media-advisories-' + communityVal;
				} else if (typeVal === 'redefined-blog') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-redefined-blog-' + communityVal;
				} else {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-news-' + communityVal;
				}
				jsonFname = jsonFnameBase + (subCatCount === 1 ? '-1' : '') + '.json';
			} else if (magazineVal.length) {
				//console.log('magazineVal', {magazineVal,subCatCount});
				if(typeVal === 'media-advisories') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-media-advisories-' + magazineVal;
				} else if (typeVal === 'redefined-blog') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-redefined-blog-' + magazineVal;
				} else {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-news-' + magazineVal;
				}
				jsonFname = jsonFnameBase + (subCatCount === 1 ? '-1' : '') + '.json';
			} else {
				if(typeVal === 'media-advisories') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-media-advisories';
				} else if (typeVal === 'redefined-blog') {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page-redefined-blog';
				} else {
					jsonFnameBase = '/wp-content/themes/usc/json/news/page';
				}
				jsonFname = jsonFnameBase + '-1.json';
			}
			return jsonFname;
		}
		
		$('a.filter-apply-action').on('click', function(e) {
			e.preventDefault();
			typeVal = $('select[name=type]').val();
			interestVal = $('select[name=interest]').val();
			yearVal = $('select[name=year]').val();
			academicsVal = $('select[name=academics]').val();
			communityVal = $('select[name=community]').val();
			magazineVal = $('select[name=magazine]').val();
			selectedListing = { listing: [] }
			var jsonName = '';
			subCatCount = (interestVal.length ? 1 : 0) + (yearVal.length ? 1 : 0) + (academicsVal.length ? 1 : 0) + (communityVal.length ? 1 : 0) + (magazineVal.length ? 1 : 0);
			jsonMode = typeVal;
			jsonFname = getSubCategoryFilter();
			additionalFilter = additionalFilter.filter(Boolean);
			//console.log('typeVal', {typeVal,jsonFname});
			$('.selected-filter-wrapper').html('');
			$('.load-more-item-wrapper .container').html('');
			$('a.load-more-btn').removeClass('hide');
			ajaxPost(jsonFname, 1);
		});
		
	});
})(jQuery);
		</script>

		<?php
	}

}