<?php

namespace ElementHelper\Widget;

use \Elementor\Repeater;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Utils;


defined( 'ABSPATH' ) || die();

class Upcoming_Events extends Element_El_Widget {


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
		return 'upcoming-events';
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
		return __( 'Upcoming Events', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/gradient-heading/';
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
		return [ 'upcoming', 'events' ];
	}

	protected function register_content_controls() {

		//desc
		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title & Embed', 'elementhelper' ),
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
			'event_mode',
			[
				'label'              => __( 'Display event by', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'Weekly' => __( 'weekly', 'elementhelper' ),
					'Monthly' => __( 'monthly', 'elementhelper' ),
				],
				'default'            => 'Weekly',
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
			'add_aos_animate',
			[
				'label'        => __( 'Add AOS Animate', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'aos_animate_once',
			[
				'label'        => __( 'AOS Animate Once', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
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

		$this->add_control(
			'module_wrap_class',
			[
				'label'       => __( 'Module Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mb-25',
			]
		);
		
		$this->add_control(
			'header_wrap_class',
			[
				'label'       => __( 'Header Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mb-25',
			]
		);
		
		$this->end_controls_section();

	}
	
	protected function rangeMonth ($datestr) {
		date_default_timezone_set (date_default_timezone_get());
		$dt = strtotime ($datestr);
		return array (
			"start" => date ('Y-m-d', strtotime ('first day of this month', $dt)),
			"end" => date ('Y-m-d', strtotime ('last day of this month', $dt))
		);
	}

	protected function rangeWeek ($datestr) {
		date_default_timezone_set (date_default_timezone_get());
		$dt = strtotime ($datestr);
		return array (
			"start" => date ('N', $dt) == 1 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('sunday 0 week', $dt)),
			"end" => date('N', $dt) == 7 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('next sunday', $dt))
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		?>
		
		<!--<div id="localist-widget-6849496" class="localist-widget"></div><script defer type="text/javascript"
src="https://events.law.usc.edu/widget/combo?schools=uscgould&days=365&num=50&experience=inperson&container=localist-widget-6849496&template=modern"></script><div id="lclst_widget_footer"><a style="margin-left:auto;margin-right:auto;display:block;width:81px;margin-top:10px;" title="Widget powered by Localist Event Calendar Software" href="https://www.localist.com?utm_source=widget&utm_campaign=widget_footer&utm_medium=branded%20link"><img src="//d3e1o4bcbhmj8g.cloudfront.net/assets/platforms/default/about/widget_footer.png" alt="Localist Online Calendar Software" style="vertical-align: middle;" width="81" height="23"></a></div>-->


		<div class="upcoming-events-wrapper">
			<div class="upcoming-events-wrap" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php if($settings['aos_animate_once'] === 'yes') { ?>data-aos-once="true" <?php } ?><?php } ?>>
				<div class="header-wrap <?php echo $settings['header_wrap_class']; ?>">
					<?php echo '<' . $settings['title_tag'] . ' class="title">'; ?>
					<?php echo '</' . $settings['title_tag'] . '>'; ?>
				</div>
				<div class="events-wrapper">
					<div class="events-options weekly hide">
						<a href="#" class="prev-week">Previous Week</a> | 
						<a href="#" class="next-week">Next Week</a> | 
						<a href="#" class="switch-monthly">Switch to Monthly</a>
					</div>
					<div class="events-options monthly hide">
						<a href="#" class="prev-month">Previous Month</a> | 
						<a href="#" class="next-month">Next Month</a> | 
						<a href="#" class="switch-weekly">Switch to Weekly</a>
					</div>
					<div class="events-wrap">
						<div id="localist-widget-6849496" class="localist-widget"></div>
						<div id="lclst_widget_footer"><a style="margin-left:auto;margin-right:auto;display:block;width:81px;margin-top:10px;" title="Widget powered by Localist Event Calendar Software" href="https://www.localist.com?utm_source=widget&utm_campaign=widget_footer&utm_medium=branded%20link" target="_blank"><img src="//d3e1o4bcbhmj8g.cloudfront.net/assets/platforms/default/about/widget_footer.png" alt="Localist Online Calendar Software" style="vertical-align: middle;" width="81" height="23"></a></div>
					</div>
				</div>
			</div>
		</div>
<!--<script defer type="text/javascript"
src="https://events.law.usc.edu/widget/combo?start=<?php echo $thisWeek; ?>&schools=uscgould&days=21&num=50&experience=inperson&container=localist-widget-6849496&template=modern"></script>-->
<script language="javascript">
	function getTodayDateOrUrlParam(urlParam) {
        var selUrlParam = decodeURIComponent(getUrlParam(urlParam,''));
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        return selUrlParam.length ? selUrlParam : mm + '/' + dd + '/' + yyyy;
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
            urlparameter = getUrlVars()[parameter];
        }
        return urlparameter;
    }
	function constructDate(d, format) {
		const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		if(format === 'MM/DD/YYYY') {
			return ((d.getMonth() + 1)+'').padStart(2,0) + '/'+(d.getDate() +'').padStart(2,0)+'/'+d.getFullYear();
		} else if (format === 'YYYY-MM-DD') {
			return d.getFullYear() + '-' + ((d.getMonth() + 1)+'').padStart(2,0) + '-' + (d.getDate() +'').padStart(2,0);
		} else if (format === 'MMMM YYYY') {
			return monthNames[d.getMonth()] + ' ' + d.getFullYear();
		}
	}
	//var url = 'https://events.law.usc.edu/widget/view.html?callback=minicalendar_3504.updateEvents\u0026experience=inperson\u0026noevents=1\u0026num=50\u0026schools=uscgould\u0026start=2023-03-06\u0026template=modern';
	
	var event_mode = '<?php echo $settings['event_mode']; ?>';
	var isWeekly = getUrlParam('mode', event_mode) === 'Weekly';
	var curr = new Date(getTodayDateOrUrlParam('sdate'));
	var curStr = constructDate(curr, 'MM/DD/YYYY');
	if(isWeekly) {
		jQuery('.events-options.weekly').removeClass('hide');
	} else {
		jQuery('.events-options.monthly').removeClass('hide');
	}
	
	var firstday = new Date(curStr);
	firstday = new Date(firstday.setDate(curr.getDate() - firstday.getDay() ));
	var lastday = new Date(curStr);
	lastday = new Date(lastday.setDate(curr.getDate() - lastday.getDay()+6));
	var nextWeekday = new Date(lastday);
	nextWeekday = new Date(nextWeekday.setDate(nextWeekday.getDate() + 1));
	var prevWeekday = new Date(firstday);
	prevWeekday = new Date(prevWeekday.setDate(prevWeekday.getDate() - prevWeekday.getDay()-7));
	
	var firstMonthDate = new Date(curr.getFullYear(), curr.getMonth(), 1);
	var lastMonthDate = new Date(curr.getFullYear(), curr.getMonth()+1, 0);
	var prevMonthDate = new Date(firstMonthDate);
	prevMonthDate.setDate(prevMonthDate.getDate() - 1);
	prevMonthDate = new Date(prevMonthDate.getFullYear(), prevMonthDate.getMonth(), 1);
	var nextMonthDate = new Date(lastMonthDate);
	nextMonthDate.setDate(nextMonthDate.getDate() + 1);
	
	var thisStartDateStr = isWeekly ? constructDate(firstday, 'YYYY-MM-DD') : constructDate(firstMonthDate, 'YYYY-MM-DD');
	var thisNumStr = isWeekly ? 7 : new Date(firstday.getFullYear(), firstday.getMonth() + 1, 0).getDate();
	var thisWeekStr = 'Events for ' + constructDate(firstday, 'MM/DD/YYYY') + ' - ' + constructDate(lastday, 'MM/DD/YYYY');
	var thisMonthStr = 'Events for ' + constructDate(firstMonthDate, 'MMMM YYYY');
	var nextMonth = (new Date(firstMonthDate).getMonth()+1)%12 + 1
	var thisTitleStr = isWeekly ? thisWeekStr : thisMonthStr;
	var basic_url = 'https://events.law.usc.edu/widget/combo?schools=uscgould&num=50&experience=inperson&container=localist-widget-6849496&template=modern';
	var extra = '&start='+thisStartDateStr+'&days='+thisNumStr;
	var url = basic_url + extra;
	console.log('starting', {curr, curStr, firstday, lastday, nextWeekday, prevWeekday, firstMonthDate, lastMonthDate, prevMonthDate, nextMonthDate});
	jQuery('.upcoming-events-wrapper .header-wrap .title').html(thisTitleStr);
	var el = document.createElement('script');
	el.type = 'text/javascript';
	el.src = url;
	document.body.appendChild(el);
	jQuery('a.switch-monthly').attr('href', window.location.pathname + '?mode=Monthly');
	jQuery('a.switch-weekly').attr('href', window.location.pathname + '?mode=Weekly');
	jQuery('a.next-week').attr('href', window.location.pathname + '?mode=Weekly&sdate='+constructDate(nextWeekday, 'MM/DD/YYYY'));
	jQuery('a.prev-week').attr('href', window.location.pathname + '?mode=Weekly&sdate='+constructDate(prevWeekday, 'MM/DD/YYYY'));
	jQuery('a.prev-month').attr('href', window.location.pathname + '?mode=Monthly&sdate='+constructDate(prevMonthDate, 'MM/DD/YYYY'));
	jQuery('a.next-month').attr('href', window.location.pathname + '?mode=Monthly&sdate='+constructDate(nextMonthDate, 'MM/DD/YYYY'));
	
	jQuery('ul.lw_event_list li.lw_event_item a').on('click', function(e) {
		e.preventDefault();
	});
</script>

		<?php
	}
}
