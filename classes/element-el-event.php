<?php

namespace ElementHelper;

defined('ABSPATH') || die();

class _Event
{

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var ElementHelper The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @return ElementHelper An instance of the class.
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     */
    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    public static function tribe_get_venue( $postId = null ) {
        $venue_id = tribe_get_venue_id( $postId );
        $venue    = ( $venue_id > 0 ) ? esc_html( get_the_title( $venue_id ) ) : null;

        /**
         * Allows customization of the retrieved venue name for a specified event.
         *
         * @since ??
         * @since 4.5.12 Added docblock and venue ID to filter.
         *
         * @param string $venue The name of the retrieved venue.
         * @param int $venue_id The venue ID.
         */
        return apply_filters( 'tribe_get_venue', $venue, $venue_id );
    }

    public static function tribe_get_cost( $post_id = null, $with_currency_symbol = false ) {
        $cost_utils = tribe( 'tec.cost-utils' );
        $cost = $cost_utils->get_formatted_event_cost( $post_id, $with_currency_symbol );

        return apply_filters( 'tribe_get_cost', $cost, $post_id, $with_currency_symbol );
    }


}

El_Helper_Event::instance();