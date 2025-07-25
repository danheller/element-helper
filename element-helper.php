<?php

/**
* Plugin Name: Element Helper
* Description: Element Helper is most userful widgets features for Elementor Page Builder.
* Version: 1.0.0
* Author: Sabber Hossain (Original Contractor)
* Text Domain: element-helper
* Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'ELH_VERSION', '1.0.1' );
define( 'ELH__FILE__', __FILE__ );
define( 'ELH_DIR_PATH', plugin_dir_path( ELH__FILE__ ) );
define( 'ELH_DIR_URL', plugin_dir_url( ELH__FILE__ ) );
define( 'ELH_ASSETS', trailingslashit( ELH_DIR_URL . 'assets' ) );

use \Elementor\Controls_Manager;
use \Elementor\Elements_Manager;

/**
 * Main Element Helper Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class ElementHelper {

	/**
	 * Plugin Version
	 *s
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.1';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.5';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var ElementHelperor The single instance of the class.
	 */
	private static $_instance = null;


	/**
	 * Instance of Elemenntor Frontend class.
	 *
	 * @var \Elementor\Frontend()
	 */
	public static $elementor_instance;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return ElementHelperor An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'element-helper' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {		
		
		// Included all files.
		require_once ELH_DIR_PATH . 'autoload.php';
		require_once ELH_DIR_PATH . 'inc/eh-function.php';

		\ElementHelper\Element_El_Assets::init();
		\ElementHelper\Element_El_Select2_Handler::init();
		\ElementHelper\Element_El_Icons::init();
		

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {

			self::$elementor_instance = \Elementor\Plugin::instance();

			add_action( 'elementor/init', [ $this, 'add_elementor_category' ], 1 );

			// Add Plugin actions
			add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_frontend_scripts' ], 10 );

			// Register Widget Styles
			add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_frontend_styles' ] );

			add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

			// Register custom controls
        	add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );

		}

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'element-helper' ),
			'<strong>' . esc_html__( 'Element Helper', 'element-helper' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'element-helper' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'element-helper' ),
			'<strong>' . esc_html__( 'Element Helper', 'element-helper' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'element-helper' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'element-helper' ),
			'<strong>' . esc_html__( 'Element Helper', 'element-helper' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'element-helper' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Add Elementor category.
	 */
	public function add_elementor_category() {
    	self::$elementor_instance->elements_manager->add_category('element-helper',
	      	array(
					'title' => __( 'Element Helper', 'element-helper' ),
					'icon'  => 'fa fa-plug',
	      	) 
	    );
	}

	/**
	* Register Frontend Scripts
	*
	*/
	public function register_frontend_scripts() {
		wp_register_script( 'element-helper', plugin_dir_url( __FILE__ ) . 'assets/js/elh-element.js', array( 'jquery' ), self::VERSION );
	}

	/**
	* Register Frontend styles
	*
	*/
	public function register_frontend_styles() {
		wp_register_style( 'element-helper', plugin_dir_url( __FILE__ ) . 'assets/css/elh-element.css', self::VERSION );
	}


	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 */
	public function init_widgets() {
		// Include Widget files
		$_widget_list = ElementHelper\Helper::get_widgets();
		foreach ( $_widget_list as $widget_key => $data ) {
            self::register_widget( $widget_key );
        }
	}

    protected static function register_widget( $widget_key ) {
        // Register widget
        $widget_class = '\ElementHelper\Widget\\' . ucwords(str_replace( '-', '_', $widget_key ));
        if ( class_exists( $widget_class ) ) {
            self::$elementor_instance->widgets_manager->register_widget_type( new $widget_class );
        }
    }

	/**
     * Register controls
     *
     * @param Controls_Manager $controls_Manager
     */
    public function register_controls( Controls_Manager $controls_Manager ) {
	    $select2 = '\ElementHelper\Element_El_Select2';
	    //add select2 to register control
	    self::$elementor_instance->controls_manager->register_control( $select2::TYPE, new $select2() );
    }

	/**
	 * Prints the Elementor Page content.
	 */
	public static function get_content( $id = 0 ) {
		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			echo do_shortcode( '[elementor-template id="' . $id . '"]' );
		} else {
			echo self::$elementor_instance->frontend->get_builder_content_for_display( $id );
		}
	}

}

ElementHelper::instance();
