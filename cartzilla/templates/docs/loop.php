<?php
/**
 * Template part for displaying the docs loop
 *
 * @author  MadrasThemes
 * @package Cartzilla
 */

/**
 * Fires before the docs section
 */
do_action( 'cartzilla_docs_before' ); ?>

<div class="container">
    <div class="wedocs-docs-list row pt-4">
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="wedocs-docs-single mb-grid-gutter col-lg-4 col-sm-6">
            <a class="card border-0 box-shadow" href="<?php the_permalink(); ?>">
                <div class="card-body text-center">
                    
                    <i class="czi-user-circle h2 mt-2 mb-4 text-primary"></i>
                    
                    <h6><?php the_title(); ?></h6>
                    
                    <?php the_excerpt(); ?>
                    
                    <div class="wedocs-doc-link btn btn-outline-primary btn-sm mb-2"><?php echo esc_html__( 'View More', 'cartzilla' ); ?></div>
                
                </div>
            </a>
        </div>
    <?php endwhile; ?>
    </div>
</div>