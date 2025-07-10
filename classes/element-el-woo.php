<?php
namespace ElementHelper;

defined( 'ABSPATH' ) || die();

class Element_El_Woo {

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
    public function __construct() {}

    function get_product_categories() {
        $args = [
            'number' => 100,
        ];

        $list = ['Select Category' => ''];

        if ( elh_WOOCOMMERCE_ACTIVED ) {

            $product_categories = get_terms( 'product_cat', $args );
            if ( !empty( $product_categories ) ) {

                foreach ( $product_categories as $product_categorie ) {
                    $list[$product_categorie->name] = $product_categorie->slug;
                }
            }
        }
        return $list;
    }

    function add_to_cart_button( $style = 2 ) {

        if ( elh_WOOCOMMERCE_ACTIVED ) {

            if ( $style == 2 ) {
                $span = esc_html__( '+ Add To Cart', 'element-helper' );
                $cssclass = '';
            } else {
                $span = esc_html__( 'Add To Cart', 'element-helper' );
                $cssclass = 'pro-btn add-to-cart';
            }

            global $product;

            if ( $product ) {
                $defaults = [
                    'quantity' => 1,
                    'class'    => implode( ' ', array_filter( [
                        '',
                        'product_type_' . $product->get_type(),
                        $product->is_purchasable() && $product->is_in_stock() ? '' : '',
                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                    ] ) ),
                ];

                extract( $defaults );

                return sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s add_to_cart_button ' . $cssclass . '">' . $span . '</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                    esc_attr( $product->get_id() ),
                    esc_attr( $product->get_sku() ),
                    esc_attr( isset( $class ) ? $class : 'button' )
                );
            }
        }

        return '';
    }

    function get_feature_product( $size = [135, 238], $uperdiv = true ) {

        global $product;

        $output = '';
        if ( $uperdiv ) {
            $output .= '<div class="tm-pa-single-wrap large-pro">';
        }

        $output .= '<div class="tm-pa-single large">';
        $output .= '<div class="tm-pa-thumb">';
        $output .= tanzim_vc_get_product_thumb( get_post_thumbnail_id( $product->get_id() ), $size );
        $output .= '</div>';
        $output .= '<div class="tm-pa-content">';
        $output .= '<h2>' . get_the_title() . '</h2>';
        $output .= '<div class="price-box">';
        $output .= tanzim_woo_product_price( $product, true );
        $output .= '</div>';
        $output .= '<div class="ratting-box">';
        $output .= tanzim_vc_woo_ration( $product->get_average_rating() );
        $output .= '</div>';
        $output .= '<div class="product-action compare">';
        $output .= tanzim_product_add_tocart_button();
        $output .= tanzim_vc_yith_wishlist();
        $output .= tanzim_vc_price_compare();
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        if ( $uperdiv ) {
            $output .= '</div>';
        }

        return $output;
    }

    function get_yith_wishlist( $style = 1 ) {

        global $product;

        $cssclass = 'wishlist-rd';
        $mar = 'tanzim-mar-top';

        if ( $style != 2 ) {
            $cssclass = 'pro-btn';
            $mar = '';
        }

        $id = $product->get_id();
        $type = $product->get_type();
        $link = get_site_url();

        $img = '<img src="' . $link . '/wp-content/plugins/yith-woocommerce-wishlist/assets/images/wpspin_light.gif" class="ajax-loading tanzim_wi_loder" alt="loading" width="16" height="16" style="visibility:hidden">';
        $markup = '';

        if ( elh_WISHLIST_ACTIVED ) {

            $markup .= '<div class="yith-wcwl-add-to-wishlist ' . $mar . ' add-to-wishlist-' . $id . '">';
            $markup .= '<div class="yith-wcwl-add-button wishlist show" style="display:block">';
            $markup .= '<a href="' . $link . '/shop/?add_to_wishlist=' . $id . '" rel="nofollow" data-product-id="' . $id . '" data-product-type="' . $type . '" class="add_to_wishlist ' . $cssclass . '">';
            $markup .= '<i class="fas fa-heart"></i></a>';
            $markup .= $img;
            $markup .= '</div>';
            $markup .= '<div class="yith-wcwl-wishlistaddedbrowse wishlist hide" style="display:none;">';
            $markup .= '<a href="' . $link . '/wishlist/view/" rel="nofollow" class=" ' . $cssclass . '"><i class="fas fa-heart"></i></a>';
            $markup .= $img;
            $markup .= '</div>';
            $markup .= '<div class="yith-wcwl-wishlistexistsbrowse wishlist  hide" style="display:none">';
            $markup .= '<a href="' . $link . '/wishlist/view/" rel="nofollow" class=" ' . $cssclass . '"><i class="fas fa-heart"></i></a>';
            $markup .= $img;
            $markup .= '</div>';
            $markup .= '<div style="clear:both"></div>';
            $markup .= '<div class="yith-wcwl-wishlistaddresponse"></div>';
            $markup .= '</div>';
        }

        return $markup;
    }

    function get_product_price( $product, $oldp = false ) {

        $price = $product->get_regular_price();
        $old = '';

        if ( $product->get_sale_price() != '' ) {

            $price = $product->get_sale_price();

            if ( $oldp ) {
                $old = '<span class="old-price">' . get_woocommerce_currency_symbol( get_woocommerce_currency() ) . $product->get_regular_price() . '</span>';
            }

        }

        $price = get_woocommerce_currency_symbol( get_woocommerce_currency() ) . $price;

        return '<span class="price">' . $price . '<span>' . $old;
    }

    function get_product_thumb_gallery( $size = [370, 425] ) {

        $markup = '';
        global $post, $product, $woocommerce;

        $attachment_ids = $product->get_gallery_image_ids();
        $fea_image = [get_post_thumbnail_id()];
        $attachment_ids = array_merge( $fea_image, $attachment_ids );
        $i = 1;

        if ( !empty( $attachment_ids ) ) {

            $markup .= '<a href="' . get_the_permalink() . '">';
            foreach ( $attachment_ids as $attachment_id ) {
                if ( $i == 3 ) {
                    break;
                }

                $class = ( $i == 1 ) ? 'front-img' : 'back-img';
                $image_attributes = wp_get_attachment_image_src( $attachment_id, $size );
                if ( $image_attributes[0] != '' ) {
                    $markup .= '<img class="' . $class . '" src="' . $image_attributes[0] . '" alt="' . esc_html__( 'image', 'element-helper' ) . '" >';
                }
                $i++;
            }
            $markup .= '</a>';
        }

        return $markup;
    }

    function get_product_thumb( $id, $size = [] ) {

        $markup = '';
        $image_attributes = wp_get_attachment_image_src( $id, $size );

        if ( !empty( $image_attributes ) ) {

            $markup = '<img src="' . current( $image_attributes ) . '" alt="' . esc_attr( 'product img', 'element-helper' ) . '">';
        }

        return $markup;
    }

    function get_loop_product_thumb() {

        $markup = '';
        global $post, $product, $woocommerce;
        $attachment_ids = $product->get_gallery_image_ids();
        $fea_image = [get_post_thumbnail_id()];
        $attachment_ids = array_merge( $fea_image, $attachment_ids );
        $i = 1;
        if ( !empty( $attachment_ids ) ) {
            $markup .= '<a href="' . get_the_permalink() . '">';
            foreach ( $attachment_ids as $attachment_id ) {
                if ( $i == 3 ) {
                    break;
                }

                $class = ( $i == 1 ) ? 'front-img' : 'back-img';
                $image_attributes = wp_get_attachment_image_src( $attachment_id, [300, 300] );
                if ( $image_attributes[0] != '' ) {
                    $markup .= '<img class="' . $class . '" src="' . $image_attributes[0] . '" alt="' . esc_html__( 'image', 'element-helper' ) . '" >';
                }
                $i++;
            }
            $markup .= '</a>';
        }
        return $markup;
    }

    function get_woo_rating( $rating ) {

        $review = 'Rating ' . $rating . ' out of 5';

        $html = '';
        $html .= '<div class="item-rating" title="' . $review . '">';

        for ( $i = 0; $i <= 4; $i++ ) {

            if ( $i < floor( $rating ) ) {

                $html .= '<i class="fas fa-star"></i>';
            } else {

                $html .= '<i class="far fa-star"></i>';
            }
        }

        $html .= '</div>';

        return $html;
    }

    function elh_vc_price_compare( $style = 1 ) {
        global $product;
        $id = $product->get_id();
        $output = '';

        if ( elh_WOOCOMMERCE_COMPARE_ACTIVED ) {

            if ( $style == 2 ) {

                $output .= '<a href="' . get_site_url() . '?action=yith-woocompare-add-product&amp;id=' . $id . '" class="tanzim-com-2 compare popup" data-product_id="' . $id . '" rel="nofollow"></a>';
            } else {

                $output .= '<a href="' . get_site_url() . '?action=yith-woocompare-add-product&amp;id=' . $id . '" class="tanzim-com pro-btn compare popup" data-product_id="' . $id . '" rel="nofollow"></a>';
            }

        }

        return $output;
    }

    /**
     * taxonomy category
     */
    function get_woo_get_terms( $id, $tax ) {

        $terms = get_the_terms( get_the_ID(), $tax );

        $list = '';
        if ( $terms && !is_wp_error( $terms ) ):
            $i = 1;
            $cats_count = count( $terms );

            foreach ( $terms as $term ) {
                $exatra = ( $cats_count > $i ) ? ', ' : '';
                $list .= $term->name . $exatra;
                $i++;
            }
        endif;
        return trim( $list, ',' );
    }

    public static function crowd_funding_raised( $campaign_id = 0 ) {
        global $wpdb, $post;
        $db_prefix = $wpdb->prefix;
        if ( $campaign_id == 0 ) {
            $campaign_id = $post->ID;
        }

        $product = wc_get_product( $campaign_id );

        if ( is_object( $product ) AND $product->get_type() == 'crowdfunding' ) {

            // WPML compatibility.
            if ( apply_filters( 'wpml_setting', false, 'setup_complete' ) ) {
                $type = apply_filters( 'wpml_element_type', get_post_type( $campaign_id ) );
                $trid = apply_filters( 'wpml_element_trid', null, $campaign_id, $type );
                $translations = apply_filters( 'wpml_get_element_translations', null, $trid, $type );
                $campaign_ids = wp_list_pluck( $translations, 'element_id' );
            } else {
                $campaign_ids = [$campaign_id];
            }
            $placeholders = implode( ',', array_fill( 0, count( $campaign_ids ), '%d' ) );

            $query = "SELECT SUM(ltoim.meta_value) as total_sales_amount
                    FROM {$wpdb->prefix}woocommerce_order_itemmeta woim
                    LEFT JOIN {$wpdb->prefix}woocommerce_order_items oi ON woim.order_item_id = oi.order_item_id
                    LEFT JOIN {$wpdb->prefix}posts wpposts ON order_id = wpposts.ID
                    LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta ltoim ON ltoim.order_item_id = oi.order_item_id AND ltoim.meta_key = '_line_total'
                    WHERE woim.meta_key = '_product_id' AND woim.meta_value IN ($placeholders) AND wpposts.post_status = 'wc-completed';";

            $wp_sql = $wpdb->get_row( $wpdb->prepare( $query, $campaign_ids ) );

            return $wp_sql->total_sales_amount;
        }
    }

    public static function crowd_funding_goal( $campaign_id ) {
        return $funding_goal = get_post_meta( $campaign_id, '_nf_funding_goal', true );
    }

    public static function crowd_funding_raised_percent( $campaign_id = 0 ) {
        global $post;
        $percent = 0;
        if ( $campaign_id == 0 ) {
            $campaign_id = $post->ID;
        }

        $product = wc_get_product( $campaign_id );
        if ( is_object( $product ) AND $product->get_type() == 'crowdfunding' ) {

            $total = self::crowd_funding_raised( $campaign_id );
            $goal = self::crowd_funding_goal( $campaign_id );

            if ( $total > 0 && $goal > 0 ) {
                $percent = ( $goal < $total ) ? '100' : number_format( $total / $goal * 100, 2, '.', '' );
            }
            return $percent;
        }
    }

    public static function crowd_funding_video( $campaign_id ) {
        $funding_video = trim( get_post_meta( $campaign_id, 'wpneo_funding_video', true ) );
        return $funding_video;
    }

}

elh_El_Woo::instance();