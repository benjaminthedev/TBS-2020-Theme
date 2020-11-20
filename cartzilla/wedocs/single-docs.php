<?php
/**
 * The template for displaying a single doc
 *
 * To customize this template, create a folder in your current theme named "wedocs" and copy it there.
 *
 * @package weDocs
 */

$skip_sidebar = ( get_post_meta( $post->ID, 'skip_sidebar', true ) == 'yes' ) ? true : false;

if ( cz_has_children() ) {
    $skip_sidebar = true;
}

get_header(); ?>

    <?php
        /**
         * @since 1.4
         *
         * @hooked wedocs_template_wrapper_start - 10
         */
        do_action( 'wedocs_before_main_content' );
    ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <div class="bg-secondary py-4">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
                <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                    <?php cartzilla_wedocs_breadcrumbs(); ?>
                </div>
                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <?php the_title( '<span class="entry-title h3 mb-0">', '</span>' ); ?>
                </div>
            </div>
        </div>

        <div class="wedocs-single-wrap container py-5 mt-md-2 mb-2">
            <div class="row">
                <?php if ( ! $skip_sidebar ) : ?>
                <div class="col-lg-3">
                    <?php wedocs_get_template_part( 'docs', 'sidebar' ); ?>
                </div>
                <?php endif; ?>

                <div class="<?php if ( $skip_sidebar ) : ?>col-lg-12<?php else: ?>col-lg-9<?php endif; ?>">
                    <div class="wedocs-single-content">
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">
                            <header class="entry-header sr-only">
                                <?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
                            </header><!-- .entry-header -->

                            <?php cz_wedocs_single_doc_meta(); ?>

                            <?php cz_wedocs_single_doc_content(); ?>

                            <footer class="entry-footer wedocs-entry-footer"><?php
                            /**
                             * 
                             */
                            do_action( 'cartzilla_wedocs_entry_footer' ); 

                            ?></footer>

                        </article><!-- #post-## -->
                    </div>
                </div>
            </div><!-- .wedocs-single-content -->
        </div><!-- .wedocs-single-wrap -->

    <?php endwhile; ?>

    <?php
        /**
         *
         * @hooked wedocs_template_wrapper_end - 10
         */
        do_action( 'wedocs_after_main_content' );
    ?>

<?php get_footer(); ?>
