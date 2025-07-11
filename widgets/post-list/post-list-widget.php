<?php

namespace ElementHelper\Widget;

use \Elementor\Core\Schemes\Typography;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;
use \Elementor\Core\Schemes;
use \Elementor\Group_Control_Background;
use \ElementHelper\Element_El_Select2;

defined( 'ABSPATH' ) || die();


class Post_List extends Element_El_Widget {

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
		return 'post_list';
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
		return __( 'Post List', 'elementhelper' );
	}

	public function get_custom_help_url() {
		return 'http://elementor.sabber.net/widgets/post-list/';
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
		return 'eicon-parallax';
	}

	public function get_keywords() {
		return [ 'posts', 'post', 'post-list', 'list', 'news' ];
	}

	/**
	 * Get a list of All Post Types
	 *
	 * @return array
	 */
	public function get_post_types() {
		$post_types = elh_element_get_post_types( [], [ 'elementor_library', 'attachment' ] );

		return $post_types;
	}
	
	protected function get_all_post_categories() {
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
					'style_3' => __( 'Style 3', 'elementhelper' ),
					'style_4' => __( 'Style 4', 'elementhelper' ),
				],
				'default'            => 'style_1',
				'frontend_available' => true,
				'style_transfer'     => true,
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
			'feature_section',
			[
				'label'        => __( 'Feature Section', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		
		$this->add_control(
			'show_view_all_news',
			[
				'label'        => __( 'Show View All News', 'elementhelper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'elementhelper' ),
				'label_off'    => esc_html__( 'Hide', 'elementhelper' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_post_list',
			[
				'label' => __( 'List', 'elementhelper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'   => __( 'Source', 'elementhelper' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_post_types(),
				'default' => key( $this->get_post_types() ),
			]
		);

		$this->add_control(
			'show_post_by',
			[
				'label'   => __( 'Show post by:', 'elementhelper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'recent',
				'options' => [
					'recent'   => __( 'Recent Post', 'elementhelper' ),
					'selected' => __( 'Selected Post', 'elementhelper' ),
				],

			]
		);
		
		$this->add_control(
			'posts_additional_category',
			[
				'label'        => __( 'Select Additional Post Categories', 'elementhelper' ),
				'label_block'  => true,
				'type'         => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $this->get_all_post_categories(),
				'default' => [ ],
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'show_post_by' => [ 'recent' ]
				]
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'     => __( 'Item Limit', 'elementhelper' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'show_post_by' => [ 'recent' ]
				]
			]
		);


		$repeater = [];

		foreach ( $this->get_post_types() as $key => $value ) {

			$repeater[ $key ] = new Repeater();

			$repeater[ $key ]->add_control(
				'title',
				[
					'label'       => __( 'Title', 'elementhelper' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => __( 'Customize Title', 'elementhelper' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);


			$repeater[ $key ]->add_control(
				'post_id',
				[
					'label'        => __( 'Select ', 'elementhelper' ) . $value,
					'label_block'  => true,
					'type'         => Element_El_Select2::TYPE,
					'multiple'     => false,
					'placeholder'  => 'Search ' . $value,
					'data_options' => [
						'post_type' => $key,
						'action'    => 'elh_element_post_list_query'
					],
				]
			);
			
			$repeater[ $key ]->add_control(
				'cat_id',
				[
					'label'        => __( 'Select Post Categories', 'elementhelper' ),
					'label_block'  => true,
					'type'         => \Elementor\Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => $this->get_all_post_categories(),
					'default' => [ ],
				]
			);
			
			$repeater[ $key ]->add_control(
				'post_image_class',
				[
					'label'       => __( 'Post Image Class', 'elementhelper' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'      => '',
				]
			);

			$this->add_control(
				'selected_list_' . $key,
				[
					'label'       => '',
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater[ $key ]->get_controls(),
					'title_field' => '{{ title }}',
					'condition'   => [
						'show_post_by' => 'selected',
						'post_type'    => $key
					],
				]
			);
		}

		$this->end_controls_section();

	}

	protected function register_style_controls() {

		$this->start_controls_section(
			'_section_media_style',
			[
				'label' => __( 'Classes', 'elementhelper' ),
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
				'default'      => 'yes',
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

		$this->end_controls_section();

	}
	
	protected function icon_right_arrow() {
		return '<svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0807 11.5855L13.581 12.0816L19.3712 6.34061L13.581 0.59961L13.0807 1.09575L18.013 5.98622L1 5.98622L1 6.69499L18.013 6.69499L13.0807 11.5855Z" fill="#990000" stroke="#990000" stroke-width="0.5"/></svg>';
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		if ( ! $settings['post_type'] ) {
			return;
		}
		$args = [
			'post_status' => 'publish',
			'post_type'   => $settings['post_type'],
		];
		if ( 'recent' === $settings['show_post_by'] ) {
			$args['posts_per_page'] = $settings['posts_per_page'];
		}
		if ( ! empty( $settings['posts_additional_category'] ) ) {
			$args['cat'] = $settings['posts_additional_category'];
		}

		$selected_post_type = 'selected_list_' . $settings['post_type'];

		$customize_title = [];
		$ids = [];
		if ( 'selected' === $settings['show_post_by'] ) {
			$args['posts_per_page'] = - 1;
			$lists = $settings[ 'selected_list_' . $settings['post_type'] ];
			if ( ! empty( $lists ) ) {
				foreach ( $lists as $index => $value ) {
					$post_id = ! empty( $value['post_id'] ) ? $value['post_id'] : 0;
					$ids[]   = $post_id;
					if ( $value['title'] ) {
						$customize_title[ $post_id ] = $value['title'];
					}
					if ( $value['cat_id'] ) {
						$customize_cat_id[ $post_id ] = $value['cat_id'];
					}
					if ( $value['post_image_class'] ) {
						$customize_post_image_class[ $post_id ] = $value['post_image_class'];
					}
				}
			}
			$args['post__in'] = (array) $ids;
			$args['orderby']  = 'post__in';
		}
		
		if ( 'selected' === $settings['show_post_by'] && empty( $ids ) ) {
			$posts = [];
		} else {
			$posts = new \WP_Query( $args );
		}
		//var_dump($args);
		//var_dump($posts->posts);
		$title = elh_element_kses_basic( $settings['title'] );

		$this->add_render_attribute( 'title', 'class', 'item_title' );

		if ( ! empty( $settings['design_style'] ) and $settings['design_style'] == 'style_4' ): ?>
			<?php
			if ( ! empty( $posts->have_posts() ) && $settings['feature_section'] === 'yes' ): ?>
                <div class="row pt-40 pb-60">
					<?php while ( $posts->have_posts() ): $posts->the_post();
						$featured = get_post_meta( get_the_ID(), 'featured', true );
						if ( empty( ! $featured ) ):
							?>
                            <div class="col-xl-12">
                                <div class="l-career-wrapper">
                                    <div class="l-career-thumb-wrapper">
                                        <div class="l-career-thumb">
											<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
                                        </div>
                                        <div class="tag">
											<?php
											$categories = get_the_category();
											foreach ( $categories as $category ) {
												?>
                                                <a href="<?php echo get_category_link( $category->term_id ) ?>">
													<?php echo $category->cat_name; ?>
                                                </a>
												<?php
											}
											?>
                                        </div>
                                    </div>
                                    <div class="l-career-content-wrapper">
                                        <div class="inner-content">
                                            <h2><?php the_title(); ?></h2>
                                            <div class="text">
	                                            <?php the_excerpt(); ?>
                                            </div>
                                            <div class="read-more">
                                                <a href="<?php echo get_the_permalink(); ?>" aria-label="Click to read more about <?php the_title(); ?>">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php endif; endwhile;
					wp_reset_query(); ?>
                </div>
			<?php
			endif;
			?>

            <div class="l-news-bg">
				<?php
				if ( ! empty( $posts->have_posts() ) ): ?>
                    <div class="row pb-70">
						<?php while ( $posts->have_posts() ): $posts->the_post();
							$featured = get_post_meta( get_the_ID(), 'featured', true );
							if ( empty( $featured ) ):
								?>
                                <div class="col-xl-4 col-md-6">
                                    <div class="l-news-wrapper mb-30">
                                        <div class="l-news-thumb">
											<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
                                            <div class="tag">
												<?php
												$categories = get_the_category();
												foreach ( $categories as $category ) {
													?>
                                                    <a href="<?php echo get_category_link( $category->term_id ) ?>">
														<?php echo $category->cat_name; ?>
                                                    </a>
													<?php
												}
												?>
                                            </div>
                                        </div>
                                        <div class="l-news-content">
                                            <h3>
												<?php $title = get_the_title();
												if ( 'selected' === $settings['show_post_by'] && array_key_exists( get_the_ID(), $customize_title ) ) {
													$title = $customize_title[ get_the_ID() ];
												}
												printf( '<h3 %1$s><a href="%3$s">%2$s</a></h3>',
													'class=""',
													esc_html( $title ),
													esc_url( get_the_permalink( get_the_ID() ) )
												);

												?>
                                            </h3>
                                            <p><?php echo get_the_date( 'j M, Y' ) ?></p>
                                        </div>
                                    </div>
                                </div>
							<?php endif; endwhile;
						wp_reset_query(); ?>
                    </div>
				<?php
				else:
					printf( '%1$s %2$s %3$s',
						__( 'No ', 'elementhelper' ),
						esc_html( $settings['post_type'] ),
						__( 'Found', 'elementhelper' )
					);
				endif;
				?>
            </div>
		<?php elseif ( ! empty( $settings['design_style'] ) and $settings['design_style'] == 'style_3' ): ?>
            <div class="n-related-area">
                <div class="container">
					<?php if ( ! empty( $settings['title'] ) ) : ?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="n-related-title text-center">
                                    <h2><?php echo elh_element_kses_basic( $settings['title'] ); ?></h2>
                                </div>
                            </div>
                        </div>
					<?php endif; ?>
                    <div class="row">
						<?php
						if ( ! empty( $posts->have_posts() ) ): ?>
							<?php while ( $posts->have_posts() ): $posts->the_post();
								?>
                                <div class="col-xl-4 col-md-6">
                                    <div class="n-related-content-wrapper">
                                        <div class="n-related-thumb">
											<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
                                            <div class="tag">
												<?php
												$categories = get_the_category();
												foreach ( $categories as $category ) {
													?>
                                                    <a href="<?php echo get_category_link( $category->term_id ) ?>">
														<?php echo $category->cat_name; ?>
                                                    </a>
													<?php
												}
												?>
                                            </div>
                                        </div>
                                        <div class="n-related-content">
											<?php $title = get_the_title();
											if ( 'selected' === $settings['show_post_by'] && array_key_exists( get_the_ID(), $customize_title ) ) {
												$title = $customize_title[ get_the_ID() ];
											}
											printf( '<a href="%2$s">%1$s</a>',
												esc_html( $title ),
												esc_url( get_the_permalink( get_the_ID() ) )
											);
											?>
                                            <p><?php echo get_the_date( 'd M, Y' ) ?> 2022</p>
                                        </div>
                                    </div>
                                </div>
							<?php endwhile;
							wp_reset_query(); ?>
						<?php
						else:
							printf( '%1$s %2$s %3$s',
								__( 'No ', 'elementhelper' ),
								esc_html( $settings['post_type'] ),
								__( 'Found', 'elementhelper' )
							);
						endif;
						?>
                    </div>
                </div>
            </div>
		<?php elseif ( ! empty( $settings['design_style'] ) and $settings['design_style'] == 'style_2' ): ?>
            <div class="row">
				<?php if ( ! empty( $settings['title'] ) ) : ?>
                    <div class="col-xl-12">
                        <div class="sb-news-title">
                            <h3><?php echo elh_element_kses_basic( $settings['title'] ); ?></h3>
                        </div>
                    </div>
				<?php endif; ?>
				<?php
				if ( ! empty( $posts->have_posts() ) ): ?>
					<?php while ( $posts->have_posts() ): $posts->the_post();
						?>
                        <div class="col-xl-4 col-md-6 mb-30">
                            <div class="sb-news-content-wrapper">
                                <div class="sb-news-thumb">
                                    <a href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>">
										<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
                                    </a>
                                </div>
                                <div class="tag">
									<?php
									$categories = get_the_category();
									foreach ( $categories as $category ) {
										?>
                                        <a href="<?php echo get_category_link( $category->term_id ) ?>">
											<?php echo $category->cat_name; ?>
                                        </a>
										<?php
									}
									?>
                                </div>
                                <div class="sb-news-content">
									<?php $title = get_the_title();
									if ( 'selected' === $settings['show_post_by'] && array_key_exists( get_the_ID(), $customize_title ) ) {
										$title = $customize_title[ get_the_ID() ];
									}
									printf( '<a href="%2$s">%1$s</a>',
										esc_html( $title ),
										esc_url( get_the_permalink( get_the_ID() ) )
									);
									?>
                                    <p><?php echo get_the_date( 'd M,' ) ?> <br> <?php echo get_the_date( 'Y' ) ?></p>
                                </div>
                            </div>
                        </div>
					<?php endwhile;
					wp_reset_query(); ?>
				<?php
				else:
					printf( '%1$s %2$s %3$s',
						__( 'No ', 'elementhelper' ),
						esc_html( $settings['post_type'] ),
						__( 'Found', 'elementhelper' )
					);
				endif;
				?>
            </div>
		<?php else: ?>
            <div class="post-list-wrapper <?php echo $settings['module_class']; ?>">
				<?php if($settings['add_main_container'] === 'yes') { ?>
				<div class="container">
				<?php } ?>
				<?php if ( ! empty( $settings['title'] ) OR ! empty( $settings['sub_title'] ) ): ?>
				<div class="header-wrap <?php echo $settings['header_wrap_class']; ?>">
				<?php endif; ?>
					<?php if ( ! empty( $settings['title'] ) ): ?>
					<?php echo '<' . $settings['title_tag'] . ' class="title ' . $settings['title_class'] . '">'; ?>
					<span><?php echo $settings['title'] ?></span>
					<?php echo '</' . $settings['title_tag'] . '>'; ?>
					<?php endif; ?>
					<?php if ( ! empty( $settings['sub_title'] ) ): ?>
					<div class="sub-title">
						<?php echo $settings['sub_title'] ?>
					</div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['title'] ) OR ! empty( $settings['sub_title'] ) ): ?>
				</div>
				<?php endif; ?>
				<?php if ( ! empty( $posts->have_posts() ) && $settings['feature_section'] === 'yes' ): ?>
				<?php 
					$featuredPost = array_shift($posts->posts);
					$featuredImage = get_the_post_thumbnail_url($featuredPost->ID) ?  get_the_post_thumbnail_url($featuredPost->ID) : get_field('news_image', $featuredPost->ID);
					$featuredImgId = get_post_thumbnail_id($featuredPost->ID);
					$featuredAltText = get_post_meta($featuredImgId, '_wp_attachment_image_alt', TRUE);
					$featuredExcerpt = get_the_excerpt($featuredPost->ID);
					$featuredExcerpt = !empty($featuredExcerpt) ? $featuredExcerpt : get_post_meta( $featuredPost->ID, 'news_brief_description', true );
				?>
				<?php 
					if($featuredPost !== NULL) {
				?>
					<div class="row" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" <?php } ?>>
						<div class="main-post-wrapper col-xl-12">
							<div class="post-wrapper">
								<div class="vision-thumb">
									<a href="<?php echo get_permalink($featuredPost->ID); ?>" class=""><img src="<?php echo $featuredImage; ?>" class="<?php echo $customize_post_image_class [ $featuredPost->ID ]; ?>" alt="<?php echo $featuredAltText; ?>" /></a>
								</div>
								<div class="vision-content">
									<div class="vision-content-inner">
										<div class="vision-tag">
										<?php
										$categories = get_the_category($featuredPost->ID);
										foreach ( $categories as $category ) {
											if( $customize_cat_id [ $featuredPost->ID ] === NULL  || ($customize_cat_id [ $featuredPost->ID ] !== NULL && in_array($category->term_id, $customize_cat_id [ $featuredPost->ID ]))) {
										?>
											<a href="<?php echo get_category_link( $category->term_id ) ?>">
												<?php echo $category->cat_name; ?>
											</a>
										<?php
											}
										}
										?>
										</div>
										<?php if($customize_title[ $featuredPost->ID ] !== NULL) { ?>
										<div class="customize-title"><span><?php echo $customize_title[ $featuredPost->ID ]; ?></span></div>
										<?php } ?>
										<a href="<?php echo get_permalink($featuredPost->ID); ?>" class=""><h2><?php echo get_the_title($featuredPost->ID); ?></h2></a>
										<p><?php echo $featuredExcerpt; ?></p>
										<div class="read-more">
											<a href="<?php echo get_permalink($featuredPost->ID); ?>" class="btn btn-cardinal-text-only" aria-label="Click to read more about <?php echo get_the_title($featuredPost->ID); ?>">
												Read More <img src="/wp-content/uploads/2023/03/icon-right-arrow.png" />
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php 
						?>
					</div>
					<?php
						}
					?>
					<?php endif; ?>
					<?php
						//var_dump($posts);
						if ( ! empty( $posts->posts ) ): 
					?>
                        <div class="row rest-of-posts" <?php if($settings['add_aos_animate'] === 'yes') { ?>data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000" <?php } ?>>
							<?php 
								while ( $posts->have_posts() ): $posts->the_post();
									//$featuredImage = get_post_meta( get_the_ID(), 'news_image', true );
									//$featuredImage = !empty($featuredImage) ? $featuredImage : get_the_post_thumbnail_url( get_the_ID(), 'full' );
									$featuredImage = get_the_post_thumbnail_url(get_the_ID()) ?  get_the_post_thumbnail_url(get_the_ID(), 'large') : get_field('news_image', get_the_ID());
									$featuredExcerpt = get_the_excerpt(get_the_ID());
									//var_dump(get_post_meta( get_the_ID(), 'news_brief_description', true ));
									$featuredImgId = get_post_thumbnail_id(get_the_ID());
									$featuredAltText = get_post_meta($featuredImgId, '_wp_attachment_image_alt', TRUE);
									$featuredExcerpt = !empty($featuredExcerpt) ? $featuredExcerpt : get_post_meta( get_the_ID(), 'news_brief_description', true );
									$news_brief_description = get_post_meta( get_the_ID(), 'news_brief_description', true );
								//$featured = get_post_meta( get_the_ID(), 'featured', true );
								if ( get_the_ID() ):
									$title = get_the_title();
							?>
								<div class="rest-of-post">
									<div class="vision-card-wrapper">
										<a href="<?php echo get_permalink(get_the_ID()); ?>" class="full-size-link" aria-label="Click to read more about <?php echo $title; ?>"><span class="hide"><?php echo $title; ?></span></a>
										<div class="vision-card-inner">
											<div class="vision-c-thumb">
												<img src="<?php echo $featuredImage; ?>" class="<?php if( isset( $customize_post_image_class [ get_the_ID() ] ) ) { echo $customize_post_image_class [ get_the_ID() ]; } ?>" alt="<?php echo $featuredAltText; ?>" />
											</div>
											<div class="card-content">
												<div class="card-title-content">
												<?php 
													if ( 'selected' === $settings['show_post_by'] && array_key_exists( get_the_ID(), $customize_title ) ) {
														$title = $customize_title[ get_the_ID() ];
													}
													printf( '<h3 %1$s>%2$s</h3>',
														   'class="news-title"',
														   esc_html( $title ),
														   esc_url( get_the_permalink( get_the_ID() ) )
														  );
													printf( '<h3 %1$s>%2$s</h3>',
														   'class="news-brief-description"',
														   esc_html( $news_brief_description ),
														   esc_url( get_the_permalink( get_the_ID() ) )
														  );
		
												?>
												</div>
												<div class="read-more">
													<a href="<?php echo get_permalink(get_the_ID()); ?>" class="btn btn-cardinal-text-only" aria-label="Click to read more about <?php echo $title; ?>">
														Read More <?php echo $this->icon_right_arrow(); ?>
													</a>
												</div>
												<div class="cat">
													<?php
													$categories = get_the_category();
													foreach ( $categories as $category ) {
														//var_dump($category); echo '<br />';
														if( isset( $customize_cat_id [ get_the_ID() ] ) && ( ($customize_cat_id [ get_the_ID() ] === NULL && in_array($category->parent, ALLOWED_PARENT_CATEGORYIDS)) || ($customize_cat_id [ get_the_ID() ] !== NULL && in_array($category->term_id, $customize_cat_id [ get_the_ID() ])))) {
													?>
													<a href="<?php echo get_category_link( $category->term_id ) ?>">
														<?php echo $category->cat_name; ?>
													</a>
													<?php
														}
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php 
								endif; 
								endwhile;
								wp_reset_query(); 
							?>
                        </div>
						<script language="javascript">
							jQuery('.rest-of-posts').slick({
								slidesToShow: 3,
								responsive: [
									{
										breakpoint: 768,
										settings: {
											slidesToShow: 1,
											centerMode: true,
											centerPadding: '35px'
										}
									
									}
								]
							});
						</script>
					<?php
					/*else:
						printf( '%1$s %2$s %3$s',
							__( 'No ', 'elementhelper' ),
							esc_html( $settings['post_type'] ),
							__( 'Found', 'elementhelper' )
						);*/
					endif;
					?>
					<?php if ( $settings['show_view_all_news'] === 'yes' ) { ?>
					<div class="view-all-news-wrapper">
						<a href="/news/" class="btn btn-primary">View All News</a>
					</div>
					<?php } ?>
				<?php if($settings['add_main_container'] === 'yes') { ?>
				</div>
				<?php } ?>
            </div>
		<?php endif;
	}
}
