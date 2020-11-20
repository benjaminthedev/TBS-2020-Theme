<?php

$column_classes = 'col-lg-'. ( 12 / $col ) .' col-sm-6';

if ( $docs ) : ?>

<div class="wedocs-shortcode-wrap">
    <div class="wedocs-docs-list row pt-4">

        <?php foreach ( $docs as $main_doc ) : ?>
            <div class="wedocs-docs-single mb-grid-gutter <?php echo esc_attr( $column_classes ); ?>">
                <a class="card border-0 box-shadow" href="<?php echo esc_url( get_permalink( $main_doc['doc']->ID ) ); ?>">
                    <div class="card-body text-center">
                        <?php cz_wedocs_featured_icon( $main_doc['doc']->ID ); ?>

                        <h6><?php echo esc_html( $main_doc['doc']->post_title ); ?></h6>

                        <?php if ( ! empty( $main_doc['doc']->post_excerpt ) ) : ?>
                        <p class="font-size-sm text-muted pb-2"><?php echo esc_html( $main_doc['doc']->post_excerpt ); ?></p>
                        <?php endif; ?>

                        <div class="wedocs-doc-link btn btn-outline-primary btn-sm mb-2"><?php echo wp_kses_post( $more ); ?></div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?php endif;
