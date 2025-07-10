<?php
namespace ElementHelper;

defined( 'ABSPATH' ) || die();

class Element_El_Icons {

      public static function init() {
        add_filter( 'elementor/icons_manager/additional_tabs', [ __CLASS__, 'add_elh_el_eleganticons_tab' ] );
        add_filter( 'elementor/icons_manager/additional_tabs', [ __CLASS__, 'add_elh_el_icons_tab' ] );
        add_filter( 'elementor/icons_manager/additional_tabs', [ __CLASS__, 'add_elh_el_regular_icons_tab' ] );
        add_filter( 'elementor/icons_manager/additional_tabs', [ __CLASS__, 'add_elh_el_flat_icons_tab' ] );
      }

      public static function add_elh_el_icons_tab( $tabs ) {
        $tabs['element-helper-icons'] = [
            'name' => 'element-helper-icons',
            'label' => __( 'Fontawesome Pro Light', 'element-helper' ),
            'url' => ELH_ASSETS . 'fonts/css/fontawesome.pro.min.css',
            'enqueue' => [ ELH_ASSETS . 'fonts/css/fontawesome.pro.min.css' ],
            'prefix' => 'fa-',
            'displayPrefix' => 'fal',
            'labelIcon' => 'fas fa-icons',
            'ver' => ELH_VERSION,
            'fetchJson' => ELH_ASSETS . 'fonts/elh-element-icons.js?v=' . ELH_VERSION,
            'native' => false,
        ];
        return $tabs;
      }

      public static function add_elh_el_eleganticons_tab( $tabs ) {
        $tabs['element-helper-eleganticons'] = [
            'name' => 'element-helper-eleganticons',
            'label' => __( 'ElegantIcons', 'element-helper' ),
            'url' => ELH_ASSETS . 'fonts/css/elegantFont.css',
            'enqueue' => [ ELH_ASSETS . 'fonts/css/elegantFont.css' ],
            'prefix' => '',
            'displayPrefix' => '',
            'labelIcon' => 'fas fa-icons',
            'ver' => ELH_VERSION,
            'fetchJson' => ELH_ASSETS . 'fonts/elh-element-eleganticons.js?v=' . ELH_VERSION,
            'native' => false,
        ];
        return $tabs;
      }

      public static function add_elh_el_regular_icons_tab( $tabs ) {

        $tabs['elh-el-regular-icons'] = [
            'name' => 'elh-el-regular-icons',
            'label' => __( 'Fontawesome Pro Regular', 'element-helper' ),
            'url' => ELH_ASSETS . 'fonts/css/fontawesome.pro.min.css',
            'enqueue' => [ ELH_ASSETS . 'fonts/css/fontawesome.pro.min.css' ],
            'prefix' => 'fa-',
            'displayPrefix' => 'far',
            'labelIcon' => 'fas fa-icons',
            'ver' => ELH_VERSION,
            'fetchJson' => ELH_ASSETS . 'fonts/elh-element-regular-icons.js?v=' . ELH_VERSION,
            'native' => false,
        ];

        return $tabs;
      }

      public static function add_elh_el_flat_icons_tab( $tabs ) {
        $tabs['element-helper-flaticons'] = [
            'name' => 'element-helper-flat-icons',
            'label' => __( 'FlatIcons', 'element-helper' ),
            'url' => ELH_ASSETS . 'fonts/css/flaticon.css',
            'enqueue' => [ ELH_ASSETS . 'fonts/css/flaticon.css' ],
            'prefix' => '',
            'displayPrefix' => '',
            'labelIcon' => 'flaticon-business-and-finance-1',
            'ver' => ELH_VERSION,
            'fetchJson' => ELH_ASSETS . 'fonts/elh-element-flaticons.js?v=' . ELH_VERSION,
            'native' => false,
        ];
        return $tabs;
      }

}