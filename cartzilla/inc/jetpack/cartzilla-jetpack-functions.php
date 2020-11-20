<?php
/**
 * Cartzilla jetpack functions.
 *
 * @package cartzilla
 */

if ( ! function_exists( 'cartzilla_shares_jetpack' ) ) {
    function cartzilla_shares_jetpack( $provider ) {
        $provider = 'jetpack';
        return $provider;
    }
}

add_filter( 'cartzilla_shares_provider', 'cartzilla_shares_jetpack' );

if ( ! function_exists( 'cartzilla_display_jetpack_shares' ) ) {
    function cartzilla_display_jetpack_shares() {
        if ( function_exists( 'sharing_display' ) ) {
            echo sharing_display();
        }
    }
}

add_action( 'cartzilla_shares_jetpack', 'cartzilla_display_jetpack_shares' );

if ( ! function_exists( 'cartzilla_jetpack_sharing_filters' ) ) {
    function cartzilla_jetpack_sharing_filters() {
        
        if ( apply_filters( 'cartzilla_enable_cartzilla_jetpack_sharing', true ) ) {
            $options = get_option( 'sharing-options' );
        
            if ( isset( $options['global']['button_style'] ) && ( 'icon' == $options['global']['button_style'] || 'icon-text' == $options['global']['button_style'] ) ) {
                add_filter( 'jetpack_sharing_display_classes', 'cartzilla_jetpack_sharing_display_classes', 10, 4 );
                add_filter( 'jetpack_sharing_headline_html', 'cartzilla_jetpack_sharing_headline_html', 10, 3 );
                add_filter( 'jetpack_sharing_display_markup', 'cartzilla_jetpack_sharing_display_markup', 10, 2 );
            }
        }
    }
}

add_action( 'cartzilla_single_post_before', 'cartzilla_jetpack_sharing_filters', 5 );
add_action( 'woocommerce_before_single_product', 'cartzilla_jetpack_sharing_filters', 5 );

if ( ! function_exists( 'cartzilla_jetpack_sharing_display_classes' ) ) {
    function cartzilla_jetpack_sharing_display_classes( $klasses, $sharing_source, $id, $args ) {
        if ( 'icon' == $sharing_source->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }

            $klasses[] = 'social-btn';
            $klasses[] = 'sb-' . $sharing_source->shortname;

            if( cartzilla_is_woocommerce_activated() && is_product() ) {
                $klasses[] = 'sb-outline';
                $klasses[] = 'sb-sm';
            }

            if ( is_a( $sharing_source, 'Share_Custom' ) ) {
                return $klasses;
            }

            if ( $sharing_source->shortname == 'print' ) {
                $klasses[] = 'czi-printer';
            } else {
                $klasses[] = 'czi-' . $sharing_source->shortname;
            }
        } elseif ( 'icon-text' == $sharing_source->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }

            $klasses[] = 'share-btn';
            $klasses[] = 'sb-' . $sharing_source->shortname;

            if ( is_a( $sharing_source, 'Share_Custom' ) ) {
                return $klasses;
            }

            if ( $sharing_source->shortname == 'print' ) {
                $klasses[] = 'czi-printer';
            } else {
                $klasses[] = 'czi-' . $sharing_source->shortname;
            }

        }

        return $klasses;
    }
}

if ( ! function_exists( 'cartzilla_jetpack_sharing_headline_html' ) ) {
    function cartzilla_jetpack_sharing_headline_html( $heading_html, $sharing_label, $action ) {
        return '<span class="sharing-title d-inline-block align-middle text-muted font-size-sm mr-2 mb-1">%s</span>';    
    }
}

if ( ! function_exists( 'cartzilla_jetpack_sharing_display_markup' ) ) {
    function cartzilla_jetpack_sharing_display_markup( $sharing_content, $enabled = array() ) {
        $sharing_content = str_replace( '<div class="sd-content"><ul>', '', $sharing_content );
        if( isset( $enabled['hidden'] ) && count( $enabled['hidden'] ) > 0 ) {
            $sharing_content = str_replace( '</ul><div class="sharing-hidden">', '<div class="sharing-hidden">', $sharing_content );
            $sharing_content = str_replace( '<ul style="background-image:none;">', '<div>', $sharing_content );
            $sharing_content = str_replace( '<ul>', '<div class="d-flex flex-wrap mr-n2 mb-n2">', $sharing_content );
            $sharing_content = str_replace( '</ul></div></div></div></div></div>', '</div></div></div></div></div>', $sharing_content );
            $sharing_content = str_replace( '<div class="inner" style="display: none;', '<div class="inner" style="display: none; width:102px;', $sharing_content );
        } else {
            $sharing_content = str_replace( '</ul></div></div></div>', '</div></div>', $sharing_content );
        }

        $sharing_content = str_replace( '<li class="share-end">', '<li class="share-end" style="display:none !important;">', $sharing_content );
        $sharing_content = str_replace( '</li>', '</span>', $sharing_content );
        $sharing_content = str_replace( '<span></span>', '<i></i>', $sharing_content );
        $sharing_content = str_replace( '<span style="background-image:', '<span style="display: block; background-position: center; background-size: contain; height: 100%; width: 100%; background-repeat: no-repeat; background-image:', $sharing_content );

        if( cartzilla_is_woocommerce_activated() && is_product() && cartzilla_get_single_product_style() === 'style-v3' ) {
            $sharing_content = str_replace( 'class="robots-nocontent', 'class="', $sharing_content );
            $sharing_content = str_replace( '<li class="share-', '<span class="d-inline-block align-middle ml-2 my-1 ', $sharing_content );
            $sharing_content = str_replace( '<li><a href="#" class="sharing-anchor sd-button share-more"><span>', '<span class="d-inline-block align-middle ml-2 my-1"><a href="#" class="align-middle social-btn share-btn sharing-anchor share-more czi-share-alt"><i></i><span class="sr-only">', $sharing_content );
        } else {
            $sharing_content = str_replace( 'class="robots-nocontent', 'class="mt-3', $sharing_content );
            $sharing_content = str_replace( '<li class="share-', '<span class="d-inline-block align-middle mr-2 mb-2 ', $sharing_content );
            $sharing_content = str_replace( '<li><a href="#" class="sharing-anchor sd-button share-more"><span>', '<span class="d-inline-block align-middle mr-2 mb-2"><a href="#" class="align-middle social-btn share-btn sharing-anchor share-more czi-share-alt"><i></i><span class="sr-only">', $sharing_content );
        }

        return $sharing_content;
    }
}
