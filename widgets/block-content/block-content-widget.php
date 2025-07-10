<?php

namespace ElementHelper\Widget;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Block_Content extends Element_El_Widget {

	public function get_nav_menus() {
		$menus = get_terms( 'nav_menu' );
		$menus = array_combine( wp_list_pluck( $menus, 'term_id' ), wp_list_pluck( $menus, 'name' ) );
		$menuObj = [];
		foreach($menus as $menu) {
			$menuObj[$menu] = $menu;
		}
		return $menuObj;
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
		return 'content_block';
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
		return __( 'Block Content', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.com/ElementHelper/contentBlock/';
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
		return [ 'block', 'content', 'm-widget', 'contentBlock' ];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_title',
			[
				'label' => __( 'Title & Description', 'elementhelper' ),
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
				'label'       => __( 'Section Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label'       => __( 'Section Sub-Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'flip_title_subtitle',
			[
				'label'        => __( 'Flip Title & SubTitle', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'show_search_before_description',
			[
				'label'        => __( 'Show Search Before Description', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
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
			'image_background_external',
			[
				'label'       => __( 'Image Background External URL', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'image_backgroud',
			[
				'label'   => __( 'Image Background', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$this->add_control(
			'image_before_header_external',
			[
				'label'       => __( 'Image Before Header External URL', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'image_before_header',
			[
				'label'   => __( 'Image Before Header', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);
		
		$this->add_control(
			'show_caption_image_before_header',
			[
				'label'        => __( 'Show Caption Image Before Header', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'caption_title_image_before_header',
			[
				'label'       => __( 'Title Caption on Image Before Header', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'caption_sub_title_image_before_header',
			[
				'label'       => __( 'Sub-Title Caption on Image Before Header', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'caption_description_image_before_header',
			[
				'label'       => __( 'Description Caption on Image Before Header', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'image_after_header_external',
			[
				'label'       => __( 'Image After Header External URL', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'image_after_header',
			[
				'label'   => __( 'Image After Header', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);
		
		$this->add_control(
			'image_after_description_external',
			[
				'label'       => __( 'Image After Description External URL', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'image_after_description',
			[
				'label'   => __( 'Image After Description', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);
		
		$this->add_control(
			'show_link_after_description',
			[
				'label'        => __( 'Show Link After Description', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'label_link_after_description',
			[
				'label'       => __( 'Label link after description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'link_after_description',
			[
				'label'       => __( 'Link after description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'link_after_description_aria_label',
			[
				'label'       => __( 'Link after description Aria-Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'show_cta',
			[
				'label'        => __( 'Show CTA', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$repeater = new Repeater();

		$repeater->add_control(
			'cta_text',
			[
				'label'       => __( 'CTA Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$repeater->add_control(
			'cta_link',
			[
				'label'       => __( 'CTA Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'cta_target',
			[
				'label'       => __( 'CTA Target', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '_self',
			]
		);

		$repeater->add_control(
			'cta_class',
			[
				'label'       => __( 'CTA Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'btn btn-primary',
			]
		);
		
		$repeater->add_control(
			'cta_image_before_text',
			[
				'label'       => __( 'CTA Image Before Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater->add_control(
			'cta_aria_label',
			[
				'label'       => __( 'CTA Aria Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'cta_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(cta_text || "Item"); #>',
				'prevent_empty' => false,
			]
		);
		
		$this->add_control(
			'show_second_cta',
			[
				'label'        => __( 'Show Second CTA', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'second_cta_label',
			[
				'label'       => __( 'Second CTA Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater4 = new Repeater();

		$repeater4->add_control(
			'second_cta_text',
			[
				'label'       => __( 'Second CTA Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$repeater4->add_control(
			'second_cta_link',
			[
				'label'       => __( 'Second CTA Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater4->add_control(
			'second_cta_target',
			[
				'label'       => __( 'Second CTA Target', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '_self',
			]
		);

		$repeater4->add_control(
			'second_cta_class',
			[
				'label'       => __( 'Second CTA Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'btn btn-primary',
			]
		);
		
		$repeater4->add_control(
			'second_cta_image_before_text',
			[
				'label'       => __( 'Second CTA Image Before Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater4->add_control(
			'second_cta_aria_label',
			[
				'label'       => __( 'Second CTA Aria Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'second_cta_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater4->get_controls(),
				'title_field' => '<# print(second_cta_text || "Item"); #>',
				'prevent_empty' => false,
			]
		);
		
		$this->add_control(
			'show_accordion',
			[
				'label'        => __( 'Show Accordion', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'accordion_group_name',
			[
				'label'       => __( 'Accordion ID', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater2 = new Repeater();

		$repeater2->add_control(
			'accordion_label',
			[
				'label'       => __( 'Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$repeater2->add_control(
			'accordion_default',
			[
				'label'        => __( 'Default Open', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$repeater2->add_control(
			'accordion_content',
			[
				'label'       => __( 'Content', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'accordion_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater2->get_controls(),
				'title_field' => '<# print(accordion_label || "Item"); #>',
				'prevent_empty' => false,
			]
		);
		
		$this->add_control(
			'show_slidein',
			[
				'label'        => __( 'Show SlideIn', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'slidein_group_name',
			[
				'label'       => __( 'SlideIn ID', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'slidein_wrapper_class',
			[
				'label'       => __( 'SlideIn Class Name', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'slidein_title_tag',
			[
				'label'              => __( 'SlideIn Title Tag', 'elementhelper' ),
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
			'slidein_title',
			[
				'label'       => __( 'SlideIn Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'slidein_content_before_list',
			[
				'label'       => __( 'SlideIn Content Before List', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'slidein_content_after_list',
			[
				'label'       => __( 'SlideIn Content After List', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'slidein_cta_text_after_list',
			[
				'label'       => __( 'CTA Text After List', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$this->add_control(
			'slidein_cta_link_after_list',
			[
				'label'       => __( 'CTA Link After List', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'slidein_cta_target_after_list',
			[
				'label'       => __( 'CTA Target After List', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '_self',
			]
		);
		
		$this->add_control(
			'slidein_cta_class_after_list',
			[
				'label'       => __( 'CTA Class After List', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'btn btn-primary',
			]
		);
		
		$repeater3 = new Repeater();

		$repeater3->add_control(
			'slidein_label',
			[
				'label'       => __( 'Label', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$repeater3->add_control(
			'slidein_title_tag',
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
		
		$repeater3->add_control(
			'slidein_title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$repeater3->add_control(
			'slidein_content',
			[
				'label'       => __( 'Content', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$repeater3->add_control(
			'slidein_cta_text',
			[
				'label'       => __( 'CTA Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);

		$repeater3->add_control(
			'slidein_cta_link',
			[
				'label'       => __( 'CTA Link', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater3->add_control(
			'slidein_cta_target',
			[
				'label'       => __( 'CTA Target', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '_self',
			]
		);
		
		$repeater3->add_control(
			'slidein_cta_class',
			[
				'label'       => __( 'CTA Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'btn btn-primary',
			]
		);
		
		$this->add_control(
			'slidein_list',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater3->get_controls(),
				'title_field' => '<# print(slidein_label || "Item"); #>',
				'prevent_empty' => false,
			]
		);
		
		$this->add_control(
			'show_bottom_description_in_content',
			[
				'label'        => __( 'Show Bottom Description in Content', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'bottom_description',
			[
				'label'       => __( 'Bottom Description', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'show_explore_menu',
			[
				'label'        => __( 'Show Explore Menu', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'explore_menu_text',
			[
				'label'       => __( 'Explore Menu Text', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'menu_selected',
			[
				'label'              => __( 'Select Menu', 'elementhelper' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => $this->get_nav_menus(),
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
			'header_wrap_class',
			[
				'label'       => __( 'Header Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'title_class',
			[
				'label'       => __( 'Title Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'description_wrapper_class',
			[
				'label'       => __( 'Description Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mt-20 mb-30',
			]
		);
		
		$this->add_control(
			'bottom_description_wrapper_class',
			[
				'label'       => __( 'Bottom Description Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mt-20 mb-30',
			]
		);
		
		$this->add_control(
			'image_before_header_class',
			[
				'label'       => __( 'Image before Header Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mb-25',
			]
		);
		
		$this->add_control(
			'image_after_header_class',
			[
				'label'       => __( 'Image after Header Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mb-25',
			]
		);
		
		$this->add_control(
			'image_after_description_class',
			[
				'label'       => __( 'Image after Description Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => 'mb-25',
			]
		);
		
		$this->add_control(
			'cta_wrapper_class',
			[
				'label'       => __( 'CTA Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'second_cta_wrapper_class',
			[
				'label'       => __( 'Second CTA Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'collapse_wrapper_class',
			[
				'label'       => __( 'Collapse Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'add_main_container',
			[
				'label'        => __( 'Add Main Container', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'add_div_before_wrap',
			[
				'label'        => __( 'Add Div Before Wrap', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'div_before_wrap_class',
			[
				'label'       => __( 'Div Before Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'is_page_hero_background',
			[
				'label'        => __( 'Is Page Hero Background', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'add_div_title_description_cta_wrap',
			[
				'label'        => __( 'Add Content Container', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'add_div_title_description_cta_inner_wrap',
			[
				'label'        => __( 'Add Content Container Inner', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'div_title_description_cta_wrap_class',
			[
				'label'       => __( 'Div Content Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'add_div_title_image_after_header_wrap',
			[
				'label'        => __( 'Add Title Image After Header Container', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'div_title_image_after_header_wrap_class',
			[
				'label'       => __( 'Div Title Image After Header Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'add_div_image_after_header_description_wrap',
			[
				'label'        => __( 'Add Image After Header Description Container', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'add_div_description_cta_wrap',
			[
				'label'        => __( 'Add Content + CTA Container', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'div_description_cta_wrap_class',
			[
				'label'       => __( 'Div Content + CTA Wrap Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'add_breadcrumb_after_cta',
			[
				'label'        => __( 'Add Breadcrumb After CTA', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'div_auto_breadcrump_wrapper_class',
			[
				'label'       => __( 'Div Auto Breadcrump Wrapper Class', 'elementhelper' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'      => '',
			]
		);
		
		$this->add_control(
			'offset_toggle',
			[
				'label'        => __( 'Offset', 'elementhelper' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'elementhelper' ),
				'label_on'     => __( 'Custom', 'elementhelper' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		$image    = ! empty( $settings['image']['url'] ) ? wp_get_attachment_image_url( $settings['image']['id'], 'full' ) : '';
		$image_background    = ! empty( $settings['image_backgroud']['url'] ) ? wp_get_attachment_image_url( $settings['image_backgroud']['id'], 'full' ) : '';
		$image_before_header    = ! empty( $settings['image_before_header']['url'] ) ? wp_get_attachment_image_url( $settings['image_before_header']['id'], 'full' ) : '';
		$image_after_header    = ! empty( $settings['image_after_header']['url'] ) ? wp_get_attachment_image_url( $settings['image_after_header']['id'], 'full' ) : '';
		$image_after_description    = ! empty( $settings['image_after_description']['url'] ) ? wp_get_attachment_image_url( $settings['image_after_description']['id'], 'full' ) : '';
		$altTextImageBeforeHeader = ! empty( $settings['image_before_header']['url'] ) ? get_post_meta($settings['image_before_header']['id'], '_wp_attachment_image_alt', TRUE) : '';
		$altTextImageAfterHeader = ! empty( $settings['image_after_header']['url'] ) ? get_post_meta($settings['image_after_header']['id'], '_wp_attachment_image_alt', TRUE) : '';
		$altTextImageAfterDescription = ! empty( $settings['image_after_description']['url'] ) ? get_post_meta($settings['image_after_description']['id'], '_wp_attachment_image_alt', TRUE) : '';
		$breadHtml = $settings['add_breadcrumb_after_cta'] === 'yes' ?  auto_breadcrump_generation() : '';

		if($settings['show_explore_menu'] === 'yes') {
			$selMenu = wp_get_nav_menu_items($settings['menu_selected']);
			$selMenu = $selMenu === false ? [] : $selMenu;
			//var_dump($selMenu);
		}
		
		$has_cta_link = false;
		$first_cta_link = '';
		$first_cta_target = '_self';
		$first_cta_aria_label = '';
		if($settings['show_cta'] === 'yes' && count($settings['cta_list'])) {
			$has_cta_link = true;
			$first_cta_link = $settings['cta_list'][0]['cta_link'];
			$first_cta_target = $settings['cta_list'][0]['cta_target'];
			$first_cta_aria_label = $settings['cta_list'][0]['cta_aria_label'];
		}
		//var_dump($first_cta_link);
		//var_dump($settings['cta_list']);
		//var_dump($settings['show_bottom_description_in_content']);
		?>

        <div class="block-content-wrapper no-lazyload <?php echo $settings['module_class']; ?>" style="<?php if ( ( ! empty($image_background) || ! empty( $settings['image_background_external'] ) ) && $settings['is_page_hero_background'] !== 'yes' ) { ?> background-image: url(<?php echo ! empty( $settings['image_background_external'] ) ? $settings['image_background_external'] : $image_background; ?>); <?php } ?>">
			<?php if ( (! empty($image_background) || ! empty( $settings['image_background_external'] ) ) && $settings['is_page_hero_background'] === 'yes' ) { ?>
				<img src="<?php echo ! empty( $settings['image_background_external'] ) ? $settings['image_background_external'] : $image_background; ?>" class="page-hero-background" alt="Hero Background Image" />
			<?php } ?>
			<?php if($settings['add_main_container'] === 'yes') { ?>
			<div class="container">
			<?php } ?>
			<?php if($settings['add_div_before_wrap'] === 'yes') { ?>
			<div class="block-content-before-wrap <?php echo $settings['div_before_wrap_class']; ?>">
			<?php } ?>
			<div class="block-content-wrap <?php echo $settings['module_wrap_class']; ?>" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php if($settings['aos_animate_once'] === 'yes') { ?>data-aos-once="true" <?php } ?><?php } ?>>
				<?php if ( ! empty( $image_before_header ) || ! empty( $settings['image_before_header_external'] ) ): ?>
				<div class="image-before-header-wrap <?php echo $settings['image_before_header_class']; ?> <?php if( ! empty ($settings['caption_description_image_before_header'] ) ) { echo 'has-hover-caption'; } ?>">
					<?php if($settings['show_caption_image_before_header'] === 'yes') { ?>
					<div class="caption-initial-stage-wrapper">
						<?php if( ! empty ($settings['caption_title_image_before_header'] ) ) { ?>
						<div class="caption-title-image-before-header">
							<?php echo $settings['caption_title_image_before_header']; ?>
						</div>
						<?php } ?>
						<?php if( ! empty ($settings['caption_sub_title_image_before_header'] ) ) { ?>
						<div class="caption-sub-title-image-before-header">
							<?php echo $settings['caption_sub_title_image_before_header']; ?>
						</div>
						<?php } ?>
					</div>
					<?php if( ! empty ($settings['caption_description_image_before_header'] ) ) { ?>
					<div class="caption-hover-stage-wrapper">
						<?php echo $settings['caption_description_image_before_header']; ?>
					</div>
					<?php } ?>
					<?php } ?>
					<?php if($has_cta_link && $first_cta_link) { ?>
					<a href="<?php echo $first_cta_link; ?>" target="<?php echo $first_cta_target; ?>" aria-label="<?php echo $first_cta_aria_label; ?>">			
					<?php } ?>
					<img src="<?php echo ! empty( $settings['image_before_header_external'] ) ? $settings['image_before_header_external'] : $image_before_header; ?>" alt="<?php echo $altTextImageBeforeHeader; ?>">
					<?php if($has_cta_link && $first_cta_link) { ?>
					</a>
					<?php } ?>
				</div>
				<?php endif; ?>
				<?php if($settings['add_div_title_description_cta_wrap'] === 'yes') { ?>
				<div class="title-description-cta-wrapper <?php echo $settings['div_title_description_cta_wrap_class']; ?>">
				<?php } ?>
				<?php if($settings['add_div_title_description_cta_inner_wrap'] === 'yes') { ?>
				<div class="title-description-cta-inner-wrapper">
				<?php } ?>
				<?php if($settings['add_div_title_image_after_header_wrap'] === 'yes') { ?>
				<div class="title-image-after-header-wrapper <?php echo $settings['div_title_image_after_header_wrap_class']; ?>">
				<?php } ?>
				<?php if ( ! empty( $settings['title'] ) OR ! empty( $settings['sub_title'] ) ): ?>
				<div class="header-wrap <?php echo $settings['header_wrap_class']; ?>">
					<?php endif; ?>
					<?php if($settings['flip_title_subtitle'] === 'yes' && ! empty( $settings['sub_title'] )) { ?>
					<div class="sub-title">
						<?php echo $settings['sub_title'] ?>
					</div>
					<?php } ?>
					<?php if ( ! empty( $settings['title'] ) ): ?>
					<?php echo '<' . $settings['title_tag'] . ' class="title ' . $settings['title_class'] . '">'; ?>
					<span><?php echo $settings['title'] ?></span>
					<?php echo '</' . $settings['title_tag'] . '>'; ?>
					<?php endif; ?>
					<?php if ( $settings['flip_title_subtitle'] !== 'yes' && ! empty( $settings['sub_title'] ) ): ?>
					<div class="sub-title">
						<?php echo $settings['sub_title'] ?>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['title'] ) OR ! empty( $settings['sub_title'] ) ): ?>
				</div>
				<?php endif; ?>
				<?php if($settings['add_div_image_after_header_description_wrap'] === 'yes') { ?>
				<div class="image-after-header-description-wrap">					
				<?php } ?>
				<?php if ( ! empty( $image_after_header ) || ! empty( $settings['image_after_header_external'] ) ): ?>
				<div class="image-after-header-wrap <?php echo $settings['image_after_header_class']; ?>">
					<img src="<?php echo ! empty( $settings['image_after_header_external'] ) ? $settings['image_after_header_external'] : $image_after_header; ?>" alt="<?php echo $altTextImageAfterHeader; ?>">
				</div>
				<?php endif; ?>
				<?php if($settings['add_div_title_image_after_header_wrap'] === 'yes') { ?>
				</div>
				<?php } ?>
				<?php if( $settings['show_search_before_description'] === 'yes' ) { ?>
				<div class="block-search-before-description">
					<div class="block-search-before-description-inner">
						<form method="GET" action="https://gould.law.usc.edu/s/286542/kGEwwIwNMHr6KOsG8fBCVKiwyU1dfGSi">
							<button class="desktop-go-search"><i class="fa-solid fa-magnifying-glass"></i></button>
							<input type="text" name="q" placeholder="Try searching for something else..." class="desktop-header-search-keyword">
						</form>
					</div>
				</div>
				<?php } ?>
				<?php if($settings['add_div_description_cta_wrap'] === 'yes') { ?>
				<div class="description-cta-wrapper <?php echo $settings['div_description_cta_wrap_class']; ?>">
				<?php } ?>
				<?php if ( ! empty( $settings['description'] ) ): ?>
				<div class="description-wrapper  <?php echo $settings['description_wrapper_class']; ?>">
					<?php echo $settings['description'] ?>
				</div>
				<?php endif; ?>
				<?php if($settings['add_div_image_after_header_description_wrap'] === 'yes') { ?>
				</div>
				<?php } ?>
				<?php if ( ! empty( $image_after_description ) || ! empty( $settings['image_after_description_external'] ) ): ?>
				<div class="image-after-description-wrap">
					<img src="<?php echo ! empty( $settings['image_after_description_external'] ) ? $settings['image_after_description_external'] : $image_after_description; ?>" alt="<?php echo $altTextImageAfterDescription; ?>">
				</div>
				<?php endif; ?>
				<?php if($settings['show_link_after_description'] === 'yes') { ?>
				<?php
				$linkAfterDescriptionLabel = ! empty($settings['link_after_description_aria_label']) ? $settings['link_after_description_aria_label'] : $settings['label_link_after_description'] . ' of ' . $settings['title'];
				?>
				<div class="link-after-description-wrapper">
					<a href="<?php echo $settings['link_after_description']; ?>" aria-label="<?php echo $linkAfterDescriptionLabel; ?>">
						<?php echo $settings['label_link_after_description']; ?>
						<svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0807 11.5855L13.581 12.0816L19.3712 6.34061L13.581 0.59961L13.0807 1.09575L18.013 5.98622L1 5.98622L1 6.69499L18.013 6.69499L13.0807 11.5855Z" fill="#990000" stroke="#990000" stroke-width="0.5"></path></svg>
					</a>
				</div>
				<?php } ?>
				<?php if($settings['show_cta'] === 'yes' && count($settings['cta_list'])) { ?>
				<div class="cta-wrapper <?php echo $settings['cta_wrapper_class']; ?>">
					<?php foreach( $settings['cta_list'] as $ctaItem ) { ?>
					<?php
						$thisAriaLabel = ! empty($ctaItem['cta_aria_label']) ? $ctaItem['cta_aria_label'] : 'Click to ' . ( ! empty($settings['title']) ? $settings['title'] : 'link page');
					?>
					<a href="<?php echo $ctaItem['cta_link']; ?>" <?php if( ! empty($thisAriaLabel) ) { ?> aria-label="<?php echo $thisAriaLabel; ?>" <?php } ?> target="<?php echo $ctaItem['cta_target']; ?>" class="<?php echo $ctaItem['cta_class']; ?>">
						<?php if( ! empty($ctaItem['cta_image_before_text']) ) { echo '<img src="'.$ctaItem['cta_image_before_text'].'" class="cta-image-before-text" alt="" />'; } ?>
						<span><?php echo $ctaItem['cta_text']; ?></span>
					</a>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if ( ! empty( $settings['bottom_description'] ) && $settings['show_bottom_description_in_content'] === 'yes' ): ?>
				<div class="bottom-description-wrapper  <?php echo $settings['bottom_description_wrapper_class']; ?>">
					<?php echo $settings['bottom_description'] ?>
				</div>
				<?php endif; ?>
				<?php if($settings['add_div_description_cta_wrap'] === 'yes') { ?>
				</div>
				<?php } ?>
				<?php if($settings['show_second_cta'] === 'yes' && count($settings['second_cta_list'])) { ?>
				<div class="second-cta-wrapper <?php echo $settings['second_cta_wrapper_class']; ?>">
					<?php if( ! empty($settings['second_cta_label']) ) { ?>
					<label><?php echo $settings['second_cta_label']; ?></label>
					<?php } ?>
					<?php foreach( $settings['second_cta_list'] as $ctaItem ) { ?>
					<a href="<?php echo $ctaItem['second_cta_link']; ?>" <?php if( ! empty($ctaItem['second_cta_aria_label']) ) { ?> aria-label="<?php echo $ctaItem['second_cta_aria_label']; ?>" <?php } ?> target="<?php echo $ctaItem['second_cta_target']; ?>" class="<?php echo $ctaItem['second_cta_class']; ?>">
						<?php if( ! empty($ctaItem['second_cta_image_before_text']) ) { echo '<img src="'.$ctaItem['second_cta_image_before_text'].'" class="second-cta-image-before-text" alt="" />'; } ?>
						<span><?php echo $ctaItem['second_cta_text']; ?></span>
					</a>
					<?php } ?>
				</div>
				<?php } ?>
				<?php if($settings['add_div_title_description_cta_inner_wrap'] === 'yes') { ?>
				</div>
				<?php } ?>
				<?php if($settings['add_div_title_description_cta_wrap'] === 'yes') { ?>
				</div>
				<?php } ?>
				<?php if($settings['show_accordion'] === 'yes' && count($settings['accordion_list'])) { ?>
				<div class="accordion-wrapper <?php echo $settings['accordion_wrapper_class']; ?>">
					<div class="accordionMe" id="<?php echo $settings['accordion_group_name'] ?>">
					<?php foreach( $settings['accordion_list'] as $accordionItem ) { ?>
						<div class="accordion-item <?php if($accordionItem['accordion_default'] === 'yes') { ?> active <?php } ?>">
							<div class="header"><?php echo $accordionItem['accordion_label']; ?> <img src="https://gould.usc.edu/assets/images/shared/toggle-down.gif" class="accordion-arrow" alt="toggle arrow icon" /></div>
							<div class="accordion-body">
								<div class="accordion-body-text"><?php echo $accordionItem['accordion_content']; ?></div>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
				<script language="javascript">
					window.accordionList.push('<?php echo $settings['accordion_group_name'] ?>');
				</script>
				<?php } ?>
				<?php if($settings['show_slidein'] === 'yes' && count($settings['slidein_list'])) { ?>
				<div class="slidein-wrapper <?php echo $settings['slidein_wrapper_class']; ?>" id="<?php echo $settings['slidein_group_name'] ?>">
					<div class="slideinMe-item">
					<?php if ( ! empty( $settings['slidein_title'] ) ): ?>
						<?php echo '<' . $settings['slidein_title_tag'] . ' class="slidein-title">'; ?>
						<?php echo $settings['slidein_title'] ?>
						<?php echo '</' . $settings['slidein_title_tag'] . '>'; ?>
					<?php endif; ?>
					<?php if ( ! empty( $settings['slidein_content_before_list'] ) ): ?>
						<div class="slideinMe-content-before-list">
						<?php echo $settings['slidein_content_before_list'] ?>
						</div>
					<?php endif; ?>
					<?php foreach( $settings['slidein_list'] as $idx => $slideinItem ) { ?>
						<div class="slidein-item">
							<div class="slidein-header <?php echo $idx === 0 ? ' active ' : ''; ?>" data-parent="<?php echo $settings['slidein_group_name']; ?>" data-id="<?php echo $settings['slidein_group_name'] . '-' . $idx; ?>"><span><?php echo $slideinItem['slidein_label']; ?></span> <img src="/wp-content/uploads/2023/03/icon-right-arrow.png" class="slidein-arrow" /></div>
						</div>
					<?php } ?>
					<?php if ( ! empty( $settings['slidein_content_after_list'] ) ): ?>
						<div class="slideinMe-content-after-list">
						<?php echo $settings['slidein_content_after_list'] ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['slidein_cta_text_after_list'] ) ): ?>
						<a href="<?php echo $settings['slidein_cta_link_after_list']; ?>" target="<?php echo $settings['slidein_cta_target_after_list']; ?>" class="slidein-cta <?php echo $settings['slidein_cta_class_after_list']; ?>">
							<?php echo $settings['slidein_cta_text_after_list']; ?>
						</a>
					<?php endif; ?>
					</div>
					<div class="slideinMe-detail">
						<div class="slideinMe-detail-wrapper">
						<?php foreach( $settings['slidein_list'] as $idx => $slideinItem ) { ?>
							<div class="slidein-detail <?php echo $idx === 0 ? ' show ' : ''; ?>"  id="<?php echo $settings['slidein_group_name'] . '-' . $idx; ?>">
								<div class="slidein-body">
									<?php if ( ! empty( $slideinItem['slidein_title'] ) ): ?>
									<?php echo '<' . $slideinItem['slidein_title_tag'] . ' class="slidein-title">'; ?>
									<?php echo $slideinItem['slidein_title'] ?>
									<?php echo '</' . $slideinItem['slidein_title_tag'] . '>'; ?>
									<?php endif; ?>
									<div class="slidein-body-text"><?php echo $slideinItem['slidein_content']; ?></div>
									<?php if ( ! empty( $slideinItem['slidein_cta_text'] ) ): ?>
									<a href="<?php echo $slideinItem['slidein_cta_link']; ?>" target="<?php echo $slideinItem['slidein_cta_target']; ?>" class="slidein-cta <?php echo $slideinItem['slidein_cta_class']; ?>">
										<?php echo $slideinItem['slidein_cta_text']; ?>
									</a>
									<?php endif; ?>
								</div>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
				<script language="javascript">
					window.slideinList.push('<?php echo $settings['slidein_group_name'] ?>');
				</script>
				<?php } ?>
				<?php if ( ! empty( $settings['bottom_description'] ) && $settings['show_bottom_description_in_content'] !== 'yes' ): ?>
				<div class="bottom-description-wrapper  <?php echo $settings['bottom_description_wrapper_class']; ?>">
					<?php echo $settings['bottom_description'] ?>
				</div>
				<?php endif; ?>
				<?php if($settings['add_breadcrumb_after_cta'] === 'yes') { ?>
				<div class="breadcrumb-after-cta-wrapper">
					<div class="auto-breadcrumb-wrap <?php echo $settings['div_auto_breadcrump_wrapper_class']; ?>">
						<?php echo $breadHtml; ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php if($settings['add_div_before_wrap'] === 'yes') { ?>
			</div>
			<?php } ?>
			<?php if($settings['show_explore_menu'] === 'yes') { ?>
				<?php
				?>
				<div class="explore-menu-wrapper">
					<div class="explore-menu-inner" aria-label="Click here to <?php echo $settings['explore_menu_text']; ?>" role="navigation">
						<label><?php echo $settings['explore_menu_text']; ?></label>
						<i class="fa-solid fa-chevron-down"></i>
					</div>
					<div class="explore-menu-items-wrapper">
						<?php foreach ( $selMenu as $item ): ?>
						<?php $activePage = $item->object === 'page' && intval($item->object_id) === get_the_ID(); ?>
						<?php if($item->menu_item_parent === '0') { ?>
						<div class="explore-menu-item-wrapper <?php echo $activePage ? 'active' : ''; ?>">
							<a href="<?php echo $item->url; ?>">
							<div class="explore-menu-item-arrow-pre">
								<img src="/wp-content/uploads/2023/06/right-arrow-white-explore-menu.png" />
							</div>
							<div class="explore-menu-item-text">
								<?php echo $item->title; ?>
							</div>
							<div class="explore-menu-item-arrow-post">
								<img src="/wp-content/uploads/2023/06/right-arrow-white-explore-menu.png" />
							</div>
							</a>
						</div>
						<?php } ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php } ?>
			<?php if($settings['add_main_container'] === 'yes') { ?>
			</div>
			<?php } ?>

        </div>

		<?php if($settings['show_explore_menu'] === 'yes') { ?>
		<script language="javascript">
(function ($) {
	$(document).ready(function () {
		$('.explore-menu-inner').on('click', function(e) {
			e.preventDefault();
			if($('.explore-menu-wrapper').hasClass('open')) {
				$('.explore-menu-wrapper').removeClass('open');
			} else {
				$('.explore-menu-wrapper').addClass('open');
			}
		})
	});
})(jQuery);
		</script>
		<?php } ?>

		<?php
	}

}

