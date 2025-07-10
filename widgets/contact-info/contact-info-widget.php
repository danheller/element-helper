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

class Contact_Info extends Element_El_Widget {

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
		return 'contact_info';
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
		return __( 'Contact Info', 'elementhelper' );
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
		return [ 'featured', 'list', 'icon' ];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_address_1',
			[
				'label' => __( 'Address', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		
		$this->add_control(
			'btn_image',
			[
				'label'   => __( 'Btn image', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);


		$this->add_control(
			'address_icon',
			[
				'label'   => __( 'Icon', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'address',
			[
				'label'       => __( 'Address', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_email_1',
			[
				'label' => __( 'Email', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'email_icon',
			[
				'label'   => __( 'Icon', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'email',
			[
				'label'       => __( 'Email', 'elementhelper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_social_1',
			[
				'label' => __( 'Social List', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => __( 'Social Icon', 'elementhelper' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => __( 'Link', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'social_lists',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print("Social Icon"); #>'
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_contact_1',
			[
				'label' => __( 'Contact Links', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();


		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => __( 'Link', 'elementhelper' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'menu_lists',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '<# print(title || "Contact Link"); #>'
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

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Style Tab', 'elementhelper' ),
				'type'  => Controls_Manager::HEADING,
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
		$settings     = $this->get_settings_for_display();
		$btn_image = ! empty( $settings['btn_image']['url'] ) ? wp_get_attachment_image_url( $settings['btn_image']['id'], 'full' ) : '';
		$address_icon = ! empty( $settings['address_icon']['url'] ) ? wp_get_attachment_image_url( $settings['address_icon']['id'], 'full' ) : '';
		$email_icon   = ! empty( $settings['email_icon']['url'] ) ? wp_get_attachment_image_url( $settings['email_icon']['id'], 'full' ) : '';
		?>
        <div class="contact-info-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="contact-info-wrap">
							<?php if ( ! empty( $settings['address'] ) ): ?>
                                <div class="info" data-aos="fade-up" data-aos-delay="300" data-aos-duration="2000">
                                    <div class="icon">
                                        <img src="<?php echo $address_icon; ?>" alt="icon">
                                    </div>
                                    <p>
										<?php echo elh_element_kses_intermediate( $settings['address'] ) ?>
                                    </p>
                                </div>
							<?php endif; ?>
							<?php if ( ! empty( $settings['email'] ) ): ?>
                                <div class="info" data-aos="fade-up" data-aos-delay="600" data-aos-duration="2000">
                                    <div class="icon">
                                        <img src="<?php echo $email_icon; ?>" alt="icon">
                                    </div>
                                    <p>
                                        <a href="mailto:<?php echo $settings['email']; ?>">
											<?php echo elh_element_kses_intermediate( $settings['email'] ) ?>
                                        </a>
                                    </p>
                                </div>
							<?php endif; ?>

							<?php if ( ! empty( ! empty( $settings['social_lists'] ) ) ): ?>
                                <div class="social" data-aos="fade-up" data-aos-delay="900" data-aos-duration="2000">
									<?php foreach ( $settings['social_lists'] as $list ):
										$image = ! empty( $list['image']['url'] ) ? wp_get_attachment_image_url( $list['image']['id'], 'full' ) : '';
										?>
                                        <a href="<?php echo esc_url( $list['link'] ) ?>">
                                            <img src="<?php echo $image; ?>" alt="icon">
                                        </a>
									<?php endforeach; ?>
                                </div>
							<?php endif; ?>

                        </div>
                    </div>
                </div>
				<div class="row justify-content-center text-center mt-100"  data-aos="fade-up" data-aos-delay="900" data-aos-duration="2000">
					<div class="col-xl-4 col-lg-4">
						<img src="<?php echo $btn_image; ?>" />
					</div>
				</div>
            </div>
            <div class="line-shape-1"></div>
            <div class="line-shape-2"></div>
        </div>

		<?php if ( ! empty( ! empty( $settings['social_lists'] ) ) ): ?>
            <div class="contact-links-area">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="contact-links" data-aos="fade-up" data-aos-delay="2000" data-aos-duration="2000"
                                 data-aos-anchor=".contact-info-wrap">
                                <ul>
									<?php foreach ( $settings['menu_lists'] as $list ): ?>
                                        <li>
                                            <a href="<?php echo esc_url( $list['link'] ) ?>">
												<?php echo elh_element_kses_intermediate( $list['title'] ) ?>
                                            </a>
                                        </li>
									<?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line-shape-1"></div>
                <div class="line-shape-2"></div>
            </div>
		<?php endif; ?>
		<?php
	}

}
