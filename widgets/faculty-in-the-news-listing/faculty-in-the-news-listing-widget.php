<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Faculty_In_The_News_Listing extends Element_El_Widget {


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
		return 'faculty-in-the-news-listing';
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
		return __( 'Faculty In The News Listing', 'elementhelper' );
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
		return [ 'faculty', 'in', 'the', 'news', 'listing', 'facultyinthenewslisting' ];
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
			'show_header',
			[
				'label'        => __( 'Show Header', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
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
			'subtitle',
			[
				'label'       => __( 'Sub-Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'note',
			[
				'label'       => __( 'Note', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => __( 'Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
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
			'faculty_in_the_news_name',
			[
				'label'        => __( 'Select Faculty in the News Name', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_all_professors(),
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
			'number_per_page',
			[
				'label'       => __( 'Number per page', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 20,
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
			<?php if($settings['show_header'] === 'yes' ) { ?>
			<div class="faculty-in-the-news-listing-header-wrapper">
				<div class="container">
					<?php if ( ! empty( $settings['title'] ) ): ?>
					<div class="faculty-in-the-news-listing-title">
						<?php echo '<' . $settings['title_tag'] . ' class="title">'; ?>
						<span><?php echo $settings['title'] ?></span>
						<?php echo '</' . $settings['title_tag'] . '>'; ?>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['subtitle'] ) ): ?>
					<div class="faculty-in-the-news-listing-subtitle">
						<span><?php echo $settings['subtitle'] ?></span>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php } ?>
			<?php if($settings['show_filter'] === 'yes' ) { ?>
			<div class="faculty-in-the-news-listing-filter-wrapper">
				<div class="container">
					<div class="fitn-filter">
						<a href="#" class="open-page-drawer-action" aria-label="Click to open filter drawer"><img src="/wp-content/uploads/2023/06/icon-filter.png" alt="Filter icon"> Filter Faculty in the News</a>
						<span class="selected-filter-wrapper hide"></span>
					</div>
				</div>
			</div>

<div class="page-drawer-wrapper">
	<div class="page-drawer-inner">
		<div class="page-filter-close">
			<a href="#" class="close-page-drawer"></a>
		</div>
		<div class="page-drawer-label">
			<img src="/wp-content/uploads/2023/06/icon-filter.png" alt="Filter icon"> Filter
		</div>
		<div class="page-filter-drawer faculty open">
			<label data-id="faculty">Faculty <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content faculty">
				<select class="faculty-dropdown" name="faculty">
				</select>
			</div>
		</div>
		<div class="page-filter-drawer year open">
			<label data-id="year">Year <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content year">
				<select class="year-dropdown" name="year">
				</select>
			</div>
		</div>
		<div class="page-filter-drawer topics open">
			<label data-id="topics">Topic <i class="fa-solid fa-chevron-up"></i></label>
			<div class="page-filter-content topics">
				<select class="topic-dropdown" name="topic">
				</select>
			</div>
		</div>
		<div class="page-filter-apply">
			<a href="#" class="filter-apply-action btn btn-primary btn-wider">Apply</a>
		</div>
	</div>
</div>

			<?php } ?>
			<div class="fitn-listing-wrapper background-ltgrey pt-50 pb-50">
				<div class="container">
					<div class="fitn-listing-items" id="fitnTop"></div>
					<div class="fitn-pagination-wrapper"></div>
				</div>
			</div>
		</div>

		<script language="javascript">
(function ($) {
	$(document).ready(function () {
		
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
			if(isOpen) {
				//$('.page-filter-drawer.'+filterType).removeClass('open');
			} else {
				$('.page-filter-drawer.'+filterType).addClass('open');
			}
		});
		$('.page-filter-apply a.apply-btn').on('click', function(e) {
			e.preventDefault();
			closeFdDrawer();
		});
		
		function renderFITN(data) {
			//console.log('data', data);
			var fitnHTML = '<div class="fitn-listing-item-wrapper">';
			fitnHTML += '<div class="fitn-listing-item-image-wrapper">';
			fitnHTML += '<img src="'+(data.thumb || '/wp-content/uploads/2023/01/Shield_RegUse_Card_RGB-e1689801525916.jpg')+'" alt="' + (data.thumb_alt || '') + '" />';
			fitnHTML += '</div>';
			fitnHTML += '<div class="fitn-listing-item-content-wrapper">';
			fitnHTML += '<div class="fitn-listing-item-date-source">';
			fitnHTML += '<span class="fitn-listing-item-date">'+data.dateStr+'</span> &bull; ';
			fitnHTML += '<span class="fitn-listing-item-source">';
			if((data.link||'').length) {
				fitnHTML += '<a href="'+data.link+'" target="_blank">';
			}
			fitnHTML += data.source;
			if((data.link||'').length) {
				fitnHTML += '</a>';
			}
			fitnHTML += '</span>';
			fitnHTML += '</div>';
			fitnHTML += '<div class="fitn-listing-item-title-wrapper">';
			fitnHTML += '<div class="fitn-listing-item-title">'+data.title+'</div>';
			fitnHTML += '</div>';
			fitnHTML += '<div class="fitn-listing-item-description-wrapper">';
			fitnHTML += '<div class="fitn-listing-item-description">'+data.description.replace('\"', '"')+'</div>';
			fitnHTML += '</div>';
			fitnHTML += '<div class="fitn-listing-item-footer-wrrapper">';
			fitnHTML += '<span class="fitn-listing-item-faculty-topic">';
			fitnHTML += '<span class="fitn-listing-item-faculty">';
			if( (data.faculty_fname||'').length) {
				fitnHTML += '<strong>Faculty:</strong> <a href="'+data.faculty_link+'">'+data.faculty_fname+' '+data.faculty_lname+'</a>';
			}
			fitnHTML += '</span>';
			fitnHTML += '<span class="fitn-listing-item-topic">';
			if(data.topic.length) {
				fitnHTML += '<strong>Topic:</strong> ';
				for( var i = 0; i < data.topic.length; i++ ) {
					fitnHTML += '<a href="'+data.topic[i].link+'">'+data.topic[i].title+'</a> ';
				}
			}
			fitnHTML += '</span>';
			fitnHTML += '</span>';
			fitnHTML += '<span class="fitn-listing-item-more">';
			if((data.link||'').length) {
				fitnHTML += '<a href="'+data.link+'" target="_blank">View More <img src="/wp-content/uploads/2023/03/icon-right-arrow.png" alt="Right arrow icon"></a>';
			}
			fitnHTML += '</span>';
			fitnHTML += '</div>';
			fitnHTML += '</div>';
			fitnHTML += '</div>';
			return fitnHTML;
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
		
		function generateFITN(fitn) {
			//console.log('generateFITN', fitn);
			var fitnHTML = '';
			for( var i = 0; i < fitn.length; i++) {
				fitnHTML += renderFITN(fitn[i]);
			}
			return fitnHTML;
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
			paginationHTML += '<div class="fitn-pagination-inner">';
			paginationHTML += '<a href="#fitnTop" class="goto-pageno arrow first '+ (cur === 1 ? ' disabled ' : '') + '" data-page="1" aria-label="Go to first page"><i class="fa-solid fa-angles-left"></i></a>';
			paginationHTML += '<a href="#fitnTop" class="goto-pageno arrow previous'+ (cur === 1 ? ' disabled ' : '') + '" data-page="'+prevNum+'" aria-label="Go to previous page"><i class="fa-solid fa-angle-left"></i></a>';
			paginationHTML += '<ul>';
			for ( var i = start; i <= end; i++ ) {
				paginationHTML += '<li><a href="#fitnTop" class="goto-pageno '+(i === cur ? ' selected disabled ' : '')+' " data-page="' + i + '" aria-label="Go to page '+i+'">' + i + '</a></li>';
			}
			paginationHTML += '</ul>';
			paginationHTML += '<a href="#fitnTop" class="goto-pageno arrow next '+ (cur === tot ? ' disabled ' : '') + '" data-page="'+nextNum+'" aria-label="Go to next page"><i class="fa-solid fa-angle-right"></i></a>';
			paginationHTML += '<a href="#fitnTop" class="goto-pageno arrow last '+ (cur === tot ? ' disabled ' : '') + '" data-page="'+tot+'" aria-label="Go to last page"><i class="fa-solid fa-angles-right"></i></a>';
			paginationHTML += '</div>';
			return paginationHTML;
		}
		
		function findMatchTopic(thisTopic) {
			for( var j = 0; j < thisTopic.length; j++ ) {
				if(thisTopic[j].tag === topicVal) {
					return 1;
				}
			}
			return 0;
		}
		
		function filteredFitnData(fitn) {
			var matchCount = 0;
			var maxCount = 0;
			if(jsonMode === 'faculty' && (yearVal.length || topicVal.length)) {
				maxCount = (yearVal.length ? 1 : 0) + (topicVal.length ? 1 : 0);
				for(var i = (fitn.listing.length-1); i >= 0; i--) {
					matchCount = 0;
					var thisYear = fitn.listing[i].year;
					var thisTopic = fitn.listing[i].topic;
					matchCount += yearVal.length && thisYear === yearVal ? 1 : 0;
					matchCount += (topicVal.length && thisTopic.length ? findMatchTopic(thisTopic) : 0);
					if(matchCount < maxCount) {
						fitn.listing.splice(i, 1);
					}
				}
				//console.log('faculty', {fitn});
			} else if(jsonMode === 'year' && topicVal.length) {
				maxCount = 1;
				for(var i = (fitn.listing.length-1); i >= 0; i--) {
					matchCount = 0;
					var thisTopic = fitn.listing[i].topic;
					matchCount += (topicVal.length && thisTopic.length ? findMatchTopic(thisTopic) : 0);
					if(matchCount < maxCount) {
						fitn.listing.splice(i, 1);
					}
				}
				//console.log('year', {fitn});
			} else if(jsonMode === 'topic') {
				//console.log('topic', {fitn});
			}
		}
		
		function ajaxPost(jsonFname, pgNo) {
			$('.fitn-listing-items').html('');
			$('.fitn-pagination-wrapper').html('');
			if(jsonMode !== 'page' && selectedListing.listing.length) {
				jQuery('html, body').animate({
					scrollTop: 0
				}, 500, function(){ }).promise().then(function() {
					fitn = $.extend(true,{}, selectedListing);
					fitn.pageNo = pgNo;
					fitn.totPageNo = Math.ceil(selectedListing.listing.length / recPerPage);
					var start = (fitn.pageNo - 1) * recPerPage;
					var end = (fitn.pageNo * recPerPage) - 1;
					if(end > fitn.totRecNo) {
						end = fitn.totRecNo;
					}
					fitn.listing = fitn.listing.slice(start, end);
					fitnHTML = generateFITN(fitn.listing || []);
					fitnPaginationHTML = generatePagination(fitn.pageNo, fitn.totPageNo);
					$('.fitn-listing-items').html(fitnHTML);
					$('.fitn-pagination-wrapper').html(fitnPaginationHTML);
					$('a.goto-pageno').on('click', function(e) {
						e.preventDefault();
						if(!$(this).hasClass('disabled')) {
							var thisPg = parseInt($(this).attr('data-page'));
							ajaxPost(jsonFname, thisPg);
						}
					});
				});;
			} else {
				$.ajax({
					dataType: "json",
					url: jsonFname,
					crossDomain: true,
					success: function (fitn) {
						if(jsonMode !== 'page') {
							filteredFitnData(fitn);
							selectedListing = $.extend(true,{}, fitn);
							fitn.listing.length = fitn.listing.length > recPerPage ? recPerPage : fitn.listing.length;
							fitn.pageNo = 1;
							fitn.totPageNo = Math.ceil(selectedListing.listing.length / recPerPage);
							//console.log('fitn', {fitn,jsonMode,selectedListing});
						}
						//console.log('fitn', {fitn,jsonMode,selectedListing});
						var fitnHTML = generateFITN(fitn.listing || []);
						var fitnPaginationHTML = generatePagination(fitn.pageNo, fitn.totPageNo);
						$('.fitn-listing-items').html(fitnHTML);
						$('.fitn-pagination-wrapper').html(fitnPaginationHTML);
						$('a.goto-pageno').on('click', function(e) {
							e.preventDefault();
							if(!$(this).hasClass('disabled')) {
								var thisPg = parseInt($(this).attr('data-page'));
								if(jsonMode === 'page') {
									jsonFname = '/wp-content/themes/usc/json/faculty-in-the-news/page-'+thisPg+'.json';
									ajaxPost(jsonFname, thisPg);
								} else {
									ajaxPost(jsonFname, thisPg);
								}
							}
						});
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
		}
		
		function ajaxPostFilterData(jsonFname, mode) {
			$.ajax({
				dataType: "json",
				url: jsonFname,
				crossDomain: true,
				success: function (fdata) {
					//console.log(mode, fdata);
					if(mode === 'faculty') {
						var fkey = Object.keys(fdata);
						$('.faculty-dropdown').append('<option value=""></option>');
						for ( var i = 0; i < fkey.length; i++ ) {
							$('.faculty-dropdown').append('<option value="'+ fkey[i] +'">' + fdata[fkey[i]] + '</option>');
						}
						$('.faculty-dropdown').select2({ placeholder: 'Search by Name', allowClear: true });
					}
					if(mode === 'year') {
						$('.year-dropdown').append('<option value=""></option>');
						for ( var i = 0; i < fdata.length; i++ ) {
							$('.year-dropdown').append('<option value="'+ fdata[i] +'">' + fdata[i] + '</option>');
						}
						$('.year-dropdown').select2({ placeholder: 'Search by Year', allowClear: true });
					}
					if(mode === 'topic') {
						var fkey = Object.keys(fdata);
						$('.topic-dropdown').append('<option value=""></option>');
						for ( var i = 0; i < fkey.length; i++ ) {
							$('.topic-dropdown').append('<option value="'+ fkey[i] +'">' + fdata[fkey[i]] + '</option>');
						}
						$('.topic-dropdown').select2({ placeholder: 'Search by Topic', allowClear: true });
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
		
		var jsonFacultyNames = '/wp-content/themes/usc/json/faculty-in-the-news/page-all-names.json';
		var jsonYearNames = '/wp-content/themes/usc/json/faculty-in-the-news/page-all-years.json';
		var jsonCategoryNames = '/wp-content/themes/usc/json/faculty-in-the-news/page-all-categories.json';
		ajaxPostFilterData(jsonFacultyNames, 'faculty');
		ajaxPostFilterData(jsonYearNames, 'year');
		ajaxPostFilterData(jsonCategoryNames, 'topic');

		var facultyVal = '';
		var yearVal = '';
		var topicVal = '';
		var jsonMode = 'page';
		var selectedListing = { listing: [] };
		var recPerPage = 20;

		var curPg = (getUrlParam('pg')||'').length ? getUrlParam('pg') : 1;
		var jsonFname = '/wp-content/themes/usc/json/faculty-in-the-news/page-'+curPg+'.json';
		ajaxPost(jsonFname, curPg);

		$('a.filter-apply-action').on('click', function(e) {
			e.preventDefault();
			facultyVal = $('select[name=faculty]').val();
			yearVal = $('select[name=year]').val();
			topicVal = $('select[name=topic]').val();
			selectedListing = { listing: [] }
			var jsonName = '';
			if(facultyVal.length) {
				jsonFname = '/wp-content/themes/usc/json/faculty-in-the-news/page-'+facultyVal+'.json';
				jsonMode = 'faculty';
			} else if (yearVal.length) {
				jsonFname = '/wp-content/themes/usc/json/faculty-in-the-news/page-year-'+yearVal+'.json';
				jsonMode = 'year';
			} else if (topicVal.length) {
				jsonFname = '/wp-content/themes/usc/json/faculty-in-the-news/page-cat-'+topicVal+'.json';
				jsonMode = 'topic';
			} else {
				jsonFname = '/wp-content/themes/usc/json/faculty-in-the-news/page-1.json';
				jsonMode = 'page';
			}
			ajaxPost(jsonFname, 1);
			$('.selected-filter-wrapper').html('');
			if(facultyVal.length || yearVal.length || topicVal.length) {
				if(facultyVal.length) {
					$('.selected-filter-wrapper').append('<div><label>Faculty:</label> <strong>' + $( "select[name=faculty] option:selected" ).text() + '</strong></div>');
				}
				if(yearVal.length) {
					$('.selected-filter-wrapper').append('<div><label>Year:</label> <strong>' + $( "select[name=year] option:selected" ).text() + '</strong></div>');
				}
				if(topicVal.length) {
					$('.selected-filter-wrapper').append('<div><label>Topic:</label> <strong>' + $( "select[name=topic] option:selected" ).text() + '</strong></div>');
				}
				$('.selected-filter-wrapper').removeClass('hide');
			}
		});
		
	});
})(jQuery);
		</script>

		<?php
	}

}