<?php
/**
* Cartzilla WeDocs Class
*
* @package  cartzilla
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Cartzilla_WeDocs' ) ) :

/**
 * Cartzilla WeDocs Integration class
 */
class Cartzilla_WeDocs {

    /**
     * Setup class.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->init_hooks();
    }

    /**
     * Initialize Hooks
     *
     * @since 1.0.0
     */
    private function init_hooks(){
        add_action( 'wp_print_styles', array( $this, 'dequeue_default_wedoc_styles' ) );
        add_filter( 'wedocs_post_type', array( $this, 'post_type_args' ), 10 );
    }

    public function dequeue_default_wedoc_styles() {
        wp_dequeue_style( 'wedocs-styles' );
    }

    public function post_type_args( $args ) {
        $args['supports'][] = 'author';
        $args['supports'][] = 'excerpt';
        return $args;
    }
}

endif;

return new Cartzilla_WeDocs();
