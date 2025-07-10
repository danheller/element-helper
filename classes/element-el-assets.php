<?php
namespace ElementHelper;

use \Elementor\Core\Files\CSS\Post as Post_CSS;

defined('ABSPATH') || die();

class Element_El_Assets {

    /**
     * Bind hook and run internal methods here
     */
    public static function init() {
        // Frontend scripts
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'frontend_register' ] );
        //add_action( 'wp_enqueue_scripts', [ __CLASS__, 'frontend_enqueue' ], 99 );
        add_action( 'elementor/css-file/post/enqueue', [ __CLASS__, 'frontend_enqueue_exceptions' ] );

        // Edit and preview enqueue
        add_action( 'elementor/preview/enqueue_styles', [ __CLASS__, 'enqueue_preview_style' ] );

        // Enqueue editor scripts
        add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_editor_scripts' ] );

        // Placeholder image replacement
        add_filter( 'elementor/utils/get_placeholder_image_src', [ __CLASS__, 'set_placeholder_image' ] );

        // Paragraph toolbar registration
        add_filter( 'elementor/editor/localize_settings', [ __CLASS__, 'add_inline_editing_intermediate_toolbar' ] );
    }

    /**
     * Register inline editing paragraph toolbar
     *
     * @param array $config
     * @return array
     */
    public static function add_inline_editing_intermediate_toolbar( $config ) {

        if ( ! isset( $config['inlineEditing'] ) ) {
            return $config;
        }

        $tools = [
            'bold',
            'underline',
            'italic',
            'createlink',
        ];

        if ( isset( $config['inlineEditing']['toolbar'] ) ) {

            $config['inlineEditing']['toolbar']['intermediate'] = $tools;
        } 
        else {
            $config['inlineEditing'] = [
                'toolbar' => [
                    'intermediate' => $tools,
                ],
            ];
        }

        return $config;
    }

    public static function set_placeholder_image() {

        return ELH_ASSETS . 'img/placeholder.png';
    }

    public static function frontend_register() {
        
        $suffix = elh_element_is_script_debug_enabled() ? '.' : '.min.';

        wp_enqueue_style(
            'elementhelper-main',
            ELH_ASSETS . 'css/elh-element.css',
            null,
            ELH_VERSION
        );

        //Localize scripts
        wp_localize_script('elh-element', 'elhLocalize', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('elh_element_nonce'),
        ]);

        wp_register_script(
            'elh-element',
            ELH_ASSETS . 'js/elh-element.js',
            ['jquery'],
            ELH_VERSION,
            true
        );
    }

    /**
     * Handle exception cases where regular enqueue won't work
     *
     * @param Post_CSS $file
     */
    public static function frontend_enqueue_exceptions( Post_CSS $file ) {

    }

    public static function frontend_enqueue() {

        if ( ! is_singular() ) {
            return;
        }

    }

    public static function enqueue_editor_scripts() {

        wp_enqueue_style(
            'elementhelper-editor',
            ELH_ASSETS . 'admin/css/editor.min.css',
            null,
            ELH_VERSION
        );

        wp_enqueue_script(
            'elementhelper-editor',
            ELH_ASSETS . 'admin/js/editor.min.js',
            null,
            ELH_VERSION
        );

        $localize_data = [
            'editorPanelHomeLinkURL'      => elh_element_get_dashboard_link(),
            'editorPanelWidgetsLinkURL'   => elh_element_get_dashboard_link('#widgets'),
            'i18n' => [
                'editorPanelHomeLinkTitle'    => esc_html__( 'elhAddons - Home', 'elh-element' ),
                'editorPanelWidgetsLinkTitle' => esc_html__( 'elhAddons - Widgets', 'elh-element' ),
                'promotionDialogHeader' => esc_html__( '%s Widget', 'elh-element' ),
                'promotionDialogMessage' => esc_html__( 'Use %s widget with other exclusive pro widgets and 100% unique features to extend your toolbox and build sites faster and better.', 'elh-element' ),
            ],
            'proWidgets' => [],
            'hasPro' => elh_element_has_pro(),
            'select2Secret' => wp_create_nonce( 'elh_element_Select2_Secret' ),
        ];

        if ( ! elh_element_has_pro() && elh_element_is_elementor_version( '>=', '2.9.0' ) ) {
            $localize_data['proWidgets'] = '';
        }

        wp_localize_script(
            'elementhelper-editor',
            'ElementHelperor',
            $localize_data
        );
    }

    public static function enqueue_preview_style() {}
}