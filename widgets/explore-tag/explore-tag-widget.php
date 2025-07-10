<?php

namespace ElementHelper\Widget;

use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Explore_Tag extends Element_El_Widget {

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
		return 'explore_tag';
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
		return __( 'Explore Tags', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/widgets/icon-box/';
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
		return 'eicon-preview-medium';
	}

	public function get_keywords() {
		return [ 'explore', 'list', 'icon' ];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_design_title',
			[
				'label' => __( 'Design Style', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'design_style',
			[
				'label'              => __( 'Design Style', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'style_1' => __( 'Style 1', 'elementhelper' ),
					'style_2' => __( 'Style 2', 'elementhelper' ),
				],
				'default'            => 'style_1',
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
			]
		);

		$this->end_controls_section();

		// section title
		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Heading', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => __( 'Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'lists',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Item"); #>'
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {

		$this->start_controls_section(
			'_section_media_style',
			[
				'label' => __( 'Icon / Image', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		/*$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Style Tab', 'elementhelper' ),
				'type'  => Controls_Manager::HEADING,
			]
		);*/
		
		$this->add_control(
			'add_aos_animate',
			[
				'label'        => __( 'Add AOS Animate', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Used to generate the final HTML displayed on the frontend.
	 *
	 * Note that if skin is selected, it will be rendered by the skin itself,
	 * not the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$args = array('child_of' => 22);	// 22 = Topics
		$categories = get_categories( $args );
		//var_dump($categories);
		?>
		<?php if ( ! empty( $settings['design_style'] ) and $settings['design_style'] == 'style_2' ): ?>
            <div class="sb-interest-wrapper">
				<?php if ( ! empty( $settings['title'] ) ): ?>
                    <div class="sb-interest-title">
                        <h3><?php echo $settings['title'] ?></h3>
                    </div>
				<?php endif; ?>
                <div class="sb-interest-content">
					<?php foreach ( $settings['lists'] as $item ): ?>
                        <a href="<?php echo $item['link'] ?>">
							<?php echo $item['title'] ?>
                        </a>
					<?php endforeach; ?>
                </div>
            </div>
		<?php else: ?>
            <div class="explore-area pt-75 pb-105">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
							<?php if ( ! empty( $settings['title'] ) ): ?>
                                <div class="tag-title" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php } ?>>
                                    <h3><?php echo $settings['title'] ?></h3>
                                </div>
							<?php endif; ?>

                            <div class="tag-content" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000" <?php } ?>>
								<?php if(false) { foreach ( $settings['lists'] as $item ): ?>
                                    <span class="tag-item-wrapper"><a href="<?php echo $item['link'] ?>">
										<?php echo $item['title'] ?>
                                    </a></span>
								<?php endforeach; } ?>
								<?php foreach ( $categories as $item ): ?>
                                    <span class="tag-item-wrapper"><a href="<?php echo get_category_link( $item->term_id ); ?>">
										<?php echo $item->cat_name ?>
                                    </a></span>
								<?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

		<?php endif; ?>
		<?php
	}

}