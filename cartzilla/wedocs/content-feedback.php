<?php global $post; ?>

<div class="wedocs-feedback-wrap wedocs-hide-print text-center border-top mt-5 pt-5">
    <?php
    $positive = (int) get_post_meta( $post->ID, 'positive', true );
    $negative = (int) get_post_meta( $post->ID, 'negative', true );

    $positive_title = $positive ? sprintf( _n( '%d person found this useful', '%d persons found this useful', $positive, 'cartzilla' ), number_format_i18n( $positive ) ) : esc_html__( 'No votes yet', 'cartzilla' );
    $negative_title = $negative ? sprintf( _n( '%d person found this not useful', '%d persons found this not useful', $negative, 'cartzilla' ), number_format_i18n( $negative ) ) : esc_html__( 'No votes yet', 'cartzilla' );
    ?>

    <h4 class="h6 mb-4"><?php esc_html_e( 'Was this article helpful to you?', 'cartzilla' ); ?></h4>

    <span class="vote-link-wrap">
        <a href="#" class="wedocs-tip positive btn btn-sm btn-outline-primary mx-1" data-id="<?php the_ID(); ?>" data-type="positive" title="<?php echo esc_attr( $positive_title ); ?>">
            <i class="czi-thumb-up mr-1"></i>
            <?php esc_html_e( 'Yes, thanks!', 'cartzilla' ); ?>
        </a>
        <a href="#" class="wedocs-tip negative btn btn-sm btn-outline-primary mx-1" data-id="<?php the_ID(); ?>" data-type="negative" title="<?php echo esc_attr( $negative_title ); ?>">
            <i class="czi-thumb-up mr-1"></i>
            <?php esc_html_e( 'Not really', 'cartzilla' ); ?>
        </a>
    </span>
</div>