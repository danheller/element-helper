<?php

namespace ElementHelper;

class Helper {

	/**
	 * Get widgets list
	 */
	public static function get_widgets() {

		return [
			'practicums-card'       => [
				'title' => __( 'Practicums Card', 'elementhelper' )
			],
			'practicums-clinics'    => [
				'title' => __( 'Practicums Clinics', 'elementhelper' )
			],
			'practicums-list'       => [
				'title' => __( 'Practicums List', 'elementhelper' )
			],
			'practicums-details'    => [
				'title' => __( 'Practicums Details', 'elementhelper' )
			],
			'landing-details'       => [
				'title' => __( 'Landing Details', 'elementhelper' )
			],
			'program-cta'           => [
				'title' => __( 'Program Cta', 'elementhelper' )
			],
			'program-list'          => [
				'title' => __( 'Program List', 'elementhelper' )
			],
			'program-opportunities' => [
				'title' => __( 'Program Opportunities', 'elementhelper' )
			],
			'program-details'       => [
				'title' => __( 'Program Details', 'elementhelper' )
			],
			'staff-details'         => [
				'title' => __( 'Staff Details', 'elementhelper' )
			],

			'staff-list' => [
				'title' => __( 'Staff List', 'elementhelper' )
			],

			'staffmenu' => [
				'title' => __( 'Staff Menu', 'elementhelper' )
			],

			'staff-bio' => [
				'title' => __( 'Staff Bio', 'elementhelper' )
			],

			'breadcrumbs' => [
				'title' => __( 'Breadcrumbs', 'elementhelper' )
			],

			'sidebar' => [
				'title' => __( 'Sidebar', 'elementhelper' )
			],

			'hero' => [
				'title' => __( 'Hero', 'elementhelper' )
			],

			'instagram-feed' => [
				'title' => __( 'Instagram Feed', 'elementhelper' )
			],

			'post-list' => [
				'title' => __( 'Post list', 'elementhelper' )
			],

			'post-tab' => [
				'title' => __( 'Post Tab', 'elementhelper' )
			],

			'expertise' => [
				'title' => __( 'Expertise', 'elementhelper' )
			],

			'programs' => [
				'title' => __( 'Programs', 'elementhelper' )
			],

			'practice' => [
				'title' => __( 'Practice', 'elementhelper' )
			],

			'spotlight' => [
				'title' => __( 'Spotlight', 'elementhelper' )
			],

			'featured' => [
				'title' => __( 'Featured', 'elementhelper' )
			],

			'commitment' => [
				'title' => __( 'Commitment', 'elementhelper' )
			],

			'study' => [
				'title' => __( 'Study', 'elementhelper' )
			],

			'explore-tag' => [
				'title' => __( 'Explore Tag', 'elementhelper' )
			],

			'featured-list' => [
				'title' => __( 'Featured list', 'elementhelper' )
			],

			'service' => [
				'title' => __( 'Service', 'elementhelper' )
			],

			'testimonial' => [
				'title' => __( 'Testimonial', 'elementhelper' )
			],

			'cta' => [
				'title' => __( 'Cta', 'elementhelper' )
			],

			'brands' => [
				'title' => __( 'Brands', 'elementhelper' )
			],

			'about' => [
				'title' => __( 'About', 'elementhelper' )
			],
			'block-content'       => [
				'title' => __( 'Content Block', 'elementhelper' )
			],
			'program-cta-menu'           => [
				'title' => __( 'Program Cta Menu', 'elementhelper' )
			],
			'course-description'           => [
				'title' => __( 'Course Description', 'elementhelper' )
			],
			'course-listing'           => [
				'title' => __( 'Course Listing', 'elementhelper' )
			],
			'faculty-listing'           => [
				'title' => __( 'Faculty Listing', 'elementhelper' )
			],
			'faculty-details'           => [
				'title' => __( 'Faculty Details', 'elementhelper' )
			],
			'import-data'           => [
				'title' => __( 'Import Data', 'elementhelper' )
			],
			'wufoo-form'           => [
				'title' => __( 'Wufoo Form', 'elementhelper' )
			],
			'run-script'           => [
				'title' => __( 'Run Script', 'elementhelper' )
			],
			'upcoming-events'           => [
				'title' => __( 'Upcoming Events', 'elementhelper' )
			],
			'raw-content'           => [
				'title' => __( 'Raw Content', 'elementhelper' )
			],
			'auto-breadcrumbs'           => [
				'title' => __( 'Auto Breadcrumbs', 'elementhelper' )
			],
			'news-feed'           => [
				'title' => __( 'News Feed', 'elementhelper' )
			],
			'video-listing'           => [
				'title' => __( 'Video Listing', 'elementhelper' )
			],
			'faculty-in-the-news'           => [
				'title' => __( 'Faculty in the News', 'elementhelper' )
			],
			'research-scholarship-listing'           => [
				'title' => __( 'Research & Scholarship Listing', 'elementhelper' )
			],
			'publication-listing'           => [
				'title' => __( 'Publication Listing', 'elementhelper' )
			],
			'page-listing'           => [
				'title' => __( 'Page Listing', 'elementhelper' )
			],
			'faculty-in-the-news-listing'           => [
				'title' => __( 'Faculty in the News Listing', 'elementhelper' )
			],
			'cta-listing'           => [
				'title' => __( 'CTA Listing', 'elementhelper' )
			],
			'generate-json'           => [
				'title' => __( 'Generate JSON', 'elementhelper' )
			],
			'news-listing'           => [
				'title' => __( 'News Listing', 'elementhelper' )
			],
			'generic-listing'           => [
				'title' => __( 'Generic Listing', 'elementhelper' )
			],
			'news-json-listing'           => [
				'title' => __( 'News JSON Listing', 'elementhelper' )
			],
		];
	}

	/**
	 *  Get WooCommerce widgets list
	 **/
	public static function get_woo_widgets() {

		return [
			'woo-product' => [
				'title' => __( 'Woo Product', 'elementhelper' ),
				'icon'  => 'fa fa-card'
			]
		];
	}
}


