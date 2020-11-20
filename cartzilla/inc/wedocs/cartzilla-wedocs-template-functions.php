<?php
/**
 * Cartzilla Template Functions used in WeDocs Integration
 *
 * @package Cartzilla/WeDocs
 *
 */

if ( ! function_exists( 'cz_wedocs_submit_request_modal' ) ) :
    /**
     * Displays Submit a Request button and the modal box
     *
     * @since 1.0.0
     */
    function cz_wedocs_submit_request_modal( $spacing_class = 'pt-5 mt-2' ) {
        $hide_action = get_theme_mod( 'cz_helpcenter_action_disable', false );
        $is_modal = get_theme_mod( 'cz_helpcenter_action_is_modal', true );

        if ($hide_action == false) {
            if ( wedocs_get_option( 'email', 'wedocs_settings', 'on' ) == 'on' ): ?>
                <section class="container text-center <?php echo esc_attr( $spacing_class ); ?>">
                    <h2 class="h4 pb-3" data-cz-customizer="action_title">
                        <?php echo wp_kses_post( get_theme_mod( 'cz_helpcenter_action_title', 'Haven\'t found the answer? We can help.' ) ); ?>
                    </h2>
                    <i class="<?php echo esc_attr( get_theme_mod( 'cz_helpcenter_action_icon_class', 'czi-help' ) ); ?> h3 text-primary d-block mb-4" data-cz-customizer="action_iconclass"></i>
                    <a<?php echo esc_attr( $is_modal == true ? ' id=wedocs-stuck-modal data-toggle=modal data-target=#wedocs-contact-modal' : '' ) ?> class="btn btn-primary" href="<?php echo esc_url( get_theme_mod( 'cz_helpcenter_action_link', '#' ) ); ?>" data-cz-customizer="action_btntext"><?php echo wp_kses_post( get_theme_mod( 'cz_helpcenter_action_btntext', 'Submit a request' ) ); ?></a>
                    <p class="font-size-sm pt-4" data-cz-customizer="action_subtitle">
                        <?php echo wp_kses_post( get_theme_mod( 'cz_helpcenter_action_subtitle', 'Contact us and we\'ll get back to you as soon as possible.' ) ); ?>
                    </p>
                </section>
                <?php wedocs_get_template_part( 'content', 'modal' ); ?>
            <?php endif;
        }
    }
endif;

if ( ! function_exists( 'cz_wedocs_submit_request_modal_home' ) ):
    /**
     * Displays Submit a Request button and the modal box in homepage
     *
     * @since 1.0.0
     */
    function cz_wedocs_submit_request_modal_home() {
        cz_wedocs_submit_request_modal( 'pt-1 pb-5 mb-2' );
    }
endif;

if ( ! function_exists( 'cz_wedocs_submit_request_modal_single_doc' ) ):
    /**
     * Displays Submit a Request button and the modal box in homepage
     *
     * @since 1.0.0
     */
    function cz_wedocs_submit_request_modal_single_doc() {
        cz_wedocs_submit_request_modal( 'pt-5 mt-2' );
    }
endif;

if ( ! function_exists( 'cz_wedocs_display_helpful_feedback' ) ):
    /**
     * Displays Helpful Feedback Links
     *
     * @since 1.0.0
     */
    function cz_wedocs_display_helpful_feedback() {
        if ( wedocs_get_option( 'helpful', 'wedocs_settings', 'on' ) == 'on' ) {
            wedocs_get_template_part( 'content', 'feedback' );
        }
    }
endif;

if ( ! function_exists( 'cz_wedocs_display_comments' ) ) :
    /**
     * Displays Comments for Single Docs
     *
     * @since 1.0.0
     */
    function cz_wedocs_display_comments() {
        if ( wedocs_get_option( 'comments', 'wedocs_settings', 'off' ) == 'on' ):
            if ( comments_open() || get_comments_number() ) : ?>
            <div id="comments" class="wedocs-comments-wrap pt-2 mt-5">
                <?php comments_template(); ?>
            </div>
            <?php endif;
        endif;
    }
endif;

if ( ! function_exists( 'cz_helpcenter_hero' ) ) :
    /**
     * Outputs Hero Section of Helpcenter
     *
     * @since 1.0.0
     */
    function cz_helpcenter_hero() {

        $hide_hero = get_theme_mod( 'cz_helpcenter_hero_disable', false );
        $attachmentid = get_theme_mod( 'cz_helpcenter_hero_bg' ); 
        $hero_bg_url = apply_filters( 'cartzilla_helpcenter_hero_bg_img_url', !empty( $attachmentid ) ? wp_get_attachment_url( $attachmentid ) : '' );

        if ($hide_hero == false) {
            ?><section class="bg-dark bg-size-cover bg-position-center-x position-relative py-5 mb-5" <?php if ( ! empty( $hero_bg_url ) ): ?>style="background-image: url(<?php echo esc_url( $hero_bg_url ); ?>);"<?php endif; ?>>
                <span class="bg-overlay bg-darker" style="opacity: .65;"></span>
                <div class="bg-overlay-content container py-4 my-3">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h1 class="text-light text-center" data-cz-customizer="cz_helpcenter_hero_title">
                                <?php echo wp_kses_post( get_theme_mod( 'cz_helpcenter_hero_title','How can we help?') ); ?>
                            </h1>
                            <p class="pb-3 text-light text-center"data-cz-customizer="cz_helpcenter_hero_subtitle">
                                <?php echo wp_kses_post( get_theme_mod( 'cz_helpcenter_hero_subtitle','Ask Questions. Browse Topics. Find Answers?') ); ?>
                            </p>
                            <?php cz_helpcenter_hero_search_form(); ?>
                            <?php cz_helpcenter_hero_tags_suggestions(); ?>
                        </div>
                    </div>
                </div>
            </section><?php 
        }
    }
endif;

if ( ! function_exists( 'cz_helpcenter_hero_search_form' ) ):
    /**
     * Displays Search Form in Hero
     *
     * @since 1.0.0
     */
    function cz_helpcenter_hero_search_form() {

        $dropdown_args = array(
            'post_type'         => 'docs',
            'echo'              => 0,
            'depth'             => 1,
            'show_option_none'  => esc_html__( 'All Docs', 'cartzilla' ),
            'option_none_value' => 'all',
            'name'              => 'search_in_doc',
            'class'             => 'custom-select-lg col-4'
        );

        if ( isset( $_GET['search_in_doc'] ) && 'all' != $_GET['search_in_doc'] ) {
            $dropdown_args['selected'] = (int) $_GET['search_in_doc'];
        }
        ?><form role="search" method="get" class="search-form wedocs-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="hidden" name="post_type" value="docs" />
            <div class="wedocs-search-input input-group input-group-overlay input-group-lg mb-3">
                <span class="sr-only screen-reader-text"><?php _ex( 'Search for:', 'label', 'cartzilla' ); ?></span>
                <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="czi-search"></i></span></div>
                <input type="search" class="search-field form-control prepended-form-control" placeholder="<?php echo esc_attr_x( 'Documentation Search &hellip;', 'placeholder', 'cartzilla' );?>" value="<?php echo get_search_query();?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'cartzilla' );?>" />
                <?php
                if ( apply_filters( 'cz_header_search_form_dropdown_enable', false ) ) {
                    echo wp_dropdown_pages( $dropdown_args );
                }
                ?>
            </div>
        </form><?php
    }
endif;

if ( ! function_exists( 'cz_helpcenter_hero_tags_suggestions' ) ):
    /**
     * Displays doc tags as suggestions
     *
     * @since 1.0.0.
     */
    function cz_helpcenter_hero_tags_suggestions() {

        $tags_args = apply_filters( 'cz_helpcenter_hero_tags_args', array(
            'taxonomy'   => 'doc_tag',
            'orderby'    => 'count',
            'order'      => 'DESC',
            'number'     => 4,
            'hide_empty' => false,
            'include' =>  get_theme_mod( 'cz_helpcenter_hero_tags', [] ),
        ) );


        $doc_tags  = get_terms( $tags_args );

        if ( ! empty( $doc_tags ) ): ?>
            <div class="font-size-sm">
                <span class="text-light opacity-50 mr-1"><?php esc_html_e( 'Suggestions:', 'cartzilla' ); ?></span>
                <?php foreach ( $doc_tags as $doc_tag ) : ?>
                <a class="nav-link-style nav-link-light mr-1 pb-1 border-bottom border-light" href="<?php echo esc_url( get_tag_link( $doc_tag->term_id ) ); ?>"><?php echo esc_html( $doc_tag->name ); ?></a>
                <?php endforeach; ?>
            </div><?php
        endif;
    }
endif;

if ( ! function_exists( 'cz_helpcenter_popular_articles' ) ):
    /**
     * Displays Popular Articles
     *
     * @since 1.0.0
     */
    function cz_helpcenter_popular_articles() {

        $hide_articles = get_theme_mod( 'cz_helpcenter_articles_disable', false );

        if ($hide_articles == false) {
            
            $popular_articles_query_args = apply_filters( 'hz_helpcenter_popular_articles_query_args', array(
                'post_type'      => 'docs',
                'post_status'    => 'publish',
                'posts_per_page' =>  get_theme_mod('cz_helpcenter_article_count' ,10),
            ) );

            $popular_articles_query = new wp_query( $popular_articles_query_args );

            if( $popular_articles_query->have_posts() ) :

                ?>
                <section class="container pt-4 pb-5">
                    <h2 class="h3 text-center"data-cz-customizer="cz_helpcenter_article_title">
                        <?php echo wp_kses_post( get_theme_mod( 'cz_helpcenter_article_title','Popular Articles') ); ?>
                    </h2>

                    <div class="pt-4">
                        <ul class="list-unstyled row mb-0">
                        <?php while( $popular_articles_query->have_posts() ): $popular_articles_query->the_post();  ?>
                            <li class="col-sm-6 mb-0">
                                <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                    <i class="czi-book text-muted mr-2"></i>
                                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark" class="nav-link-style"><?php the_title(); ?></a>
                                </div>
                            </li>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                        </ul>
                    </div>
                </section>
                <?php

            endif;
        }
    }
endif;


if ( ! function_exists( 'cz_helpcenter_wedocs' ) ) :
    /**
     * Displays [wedocs] shortcode
     *
     * @since 1.0.0
     */
    function cz_helpcenter_wedocs() {
        $hide_topics = get_theme_mod( 'cz_helpcenter_topics_disable', false );

        if ($hide_topics == false) {
            ?><section class="container py-3">
                <h2 class="h3 text-center" data-cz-customizer="cz_helpcenter_topic_title">
                    <?php echo wp_kses_post( get_theme_mod( 'cz_helpcenter_topic_title','Select a topic') ); ?>
                </h2>
                <?php cz_wedocs_display_docs();?>
            </section><?php
        }
    }
endif;

if ( ! function_exists( 'cz_wedocs_article_author' ) ):
    function cz_wedocs_article_author() {
        if ( apply_filters( 'cz_wedocs_article_author_show', false ) ): ?>
        ?><a class="blog-entry-meta-link wedocs-article-author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="author" itemscope itemtype="https://schema.org/Person">
            <meta itemprop="name" content="<?php echo esc_attr( get_the_author() ); ?>" />
            <meta itemprop="url" content="<?php echo esc_attr( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" />
            <div class="blog-entry-author-ava">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 26, '', esc_attr( get_the_author() ) ); ?>
            </div>
            <?php echo esc_html( get_the_author() ); ?>
        </a><?php
        endif;
    }
endif;

if ( ! function_exists( 'cz_wedocs_article_published_date' ) ):
    function cz_wedocs_article_published_date() {
        ?><meta itemprop="datePublished" content="<?php echo get_the_time( 'c' ); ?>"/>
        <time class="blog-entry-meta-link" itemprop="dateModified" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"   ><?php printf( esc_html__( 'Updated on %s', 'cartzilla' ), get_the_modified_date() ); ?></time><?php
    }
endif;

if ( ! function_exists( 'cz_wedocs_article_comment_icon' ) ):
    function cz_wedocs_article_comment_icon() {
        if ( wedocs_get_option( 'comments', 'wedocs_settings', 'off' ) == 'on' ):
            if ( comments_open() || get_comments_number() ) : ?>
            <a class="blog-entry-meta-link text-nowrap" href="#comments" data-scroll="">
                <i class="czi-message"></i><?php echo esc_html( get_comments_number() ); ?>
            </a>
            <?php endif;
        endif;
    }
endif;


if ( ! function_exists( 'cz_wedocs_article_print_icon' ) ):
    function cz_wedocs_article_print_icon() {
        if ( wedocs_get_option( 'print', 'wedocs_settings', 'on' ) == 'on' ): ?>
            <a href="#" class="blog-entry-meta-link text-nowrap wedocs-print-article wedocs-hide-print wedocs-hide-mobile" title="<?php echo esc_attr__( 'Print this article', 'cartzilla' ); ?>"><i class="czi-printer"></i></a>
        <?php endif;
    }
endif;

if ( ! function_exists( 'cz_wedocs_single_doc_meta' ) ):
    /**
     * Displays Single Doc Meta
     *
     * @since 1.0.0
     */
    function cz_wedocs_single_doc_meta() {
        ?><div class="d-flex flex-wrap justify-content-between align-items-center pb-4 mt-n1">
            <div class="d-flex align-items-center font-size-sm mb-2">
                <?php cz_wedocs_article_author(); ?>
                <?php if ( apply_filters( 'cz_wedocs_article_author_show', false ) ) : ?>
                <span class="blog-entry-meta-divider"></span>
                <?php endif; ?>
                <?php cz_wedocs_article_published_date(); ?>
            </div>
            <?php if ( wedocs_get_option( 'comments', 'wedocs_settings', 'off' ) == 'on'  || wedocs_get_option( 'print', 'wedocs_settings', 'on' ) == 'on' ) : ?>
            <div class="font-size-sm mb-2">
                <?php cz_wedocs_article_comment_icon(); ?>
                <?php if ( wedocs_get_option( 'comments', 'wedocs_settings', 'off' ) == 'on'  && wedocs_get_option( 'print', 'wedocs_settings', 'on' ) == 'on' ) : ?>
                <span class="blog-entry-meta-divider"></span>
                <?php endif;
                cz_wedocs_article_print_icon();
            ?></div>
            <?php endif; ?>
        </div><?php
    }
endif;

if ( ! function_exists( 'cz_wedocs_single_doc_content' ) ):
    function cz_wedocs_single_doc_content() {
        global $post;
        ?><div class="entry-content mt-0" itemprop="articleBody">
            <?php
                the_content( sprintf(
                    /* translators: %s: Name of current post. */
                    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'cartzilla' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );

                cz_wedocs_child_pages();

                $tags_list = wedocs_get_the_doc_tags( $post->ID, '', ', ' );

                if ( $tags_list ) {
                    printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                        _x( 'Tags', 'Used before tag names.', 'cartzilla' ),
                        $tags_list
                    );
                }
            ?>
        </div><!-- .entry-content --><?php
    }
endif;

if ( ! function_exists( 'cz_wedocs_sidebar_related_articles' ) ) :
    /**
     * Displays Related Articles in Sidebar
     *
     * @since 1.0.0
     */
    function cz_wedocs_sidebar_related_articles() {
        global $post;

        $orig_post = $post;

        $related_articles_number = apply_filters( 'cz_wedocs_related_articles_number', 12 );

        $tags       = wp_get_post_tags( $post->ID );
        $categories = get_the_category( $post->ID );

        if ( $tags ) {
            $tag_ids = array();
            foreach( $tags as $tag ) {
                $tag_ids[] = $tag->term_id;
            }

            $related_articles_query_args = apply_filters( 'cz_wedocs_related_articles_query_args', array(
                'tag__in'             => $tag_ids,
                'post__not_in'        => array( $post->ID ),
                'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
                'ignore_sticky_posts' => 1,
                'post_type'           => $post->post_type,
            ), 'tags', $tag_ids );
        } elseif ( $categories ) {
            $category_ids = array();

            foreach( $categories as $category ) {
                $category_ids[] = $category->term_id;
            }


            $related_articles_query_args = apply_filters( 'cz_wedocs_related_articles_query_args', array(
                'category__in'        => $category_ids,
                'post__not_in'        => array( $post->ID ),
                'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
                'ignore_sticky_posts' => 1,
                'post_type'           => $post->post_type,
            ), 'categories', $category_ids );
        } else {

            $related_articles_query_args = apply_filters( 'cz_wedocs_related_articles_query_args', array(
                'post__not_in'        => array( $post->ID ),
                'posts_per_page'      => $related_articles_number, // Number of related posts that will be shown.
                'ignore_sticky_posts' => 1,
                'post_type'           => $post->post_type,
            ) );

            if ( $post->post_parent ) {
                $related_articles_query_args['post_parent'] = $post->post_parent;
            } else {
                $related_articles_query_args['post_parent'] = $post->ID;
            }
        }

        $related_articles_query = new wp_query( $related_articles_query_args );

        if( $related_articles_query->have_posts() ):

        ?><div class="widget widget-links">
            <h3 class="widget-title"><?php esc_html_e( 'Related Articles', 'cartzilla' ); ?></h3>
            <ul class="widget-list"><?php
                while( $related_articles_query->have_posts() ): $related_articles_query->the_post();  ?>
                <li class="widget-list-item">
                    <a href="<?php the_permalink(); ?>" class="widget-list-link" rel="bookmark">
                        <i class="czi-book text-muted align-middle mt-n1 mr-1"></i>
                        <?php the_title(); ?>
                    </a>
                </li>
            <?php endwhile; ?>
            </ul>
        </div><?php

        endif;

        $post = $orig_post;
        wp_reset_postdata();
    }
endif;

if ( ! function_exists( 'cz_wedocs_child_pages' ) ) :
/**
 * List all child pages for this topic
 */
function cz_wedocs_child_pages( $post = null ) {

    if ( is_null( $post ) ) {
        global $post;
    }

    $child_pages_args = apply_filters( 'front_wedocs_child_pages_args', array(
        'title_li'  => '',
        'order'     => 'menu_order',
        'child_of'  => $post->ID,
        'echo'      => false,
        'post_type' => $post->post_type,
        'walker'    => new CZ_WeDocs_Page_Walker,
    ) );

    $children = wp_list_pages( $child_pages_args );

    $depth = cz_get_current_page_depth();

    if ( $children ) : ?>
        <div class="article-child">
            <ul class="list-unstyled<?php if ( $depth !== 1 ) : ?> row<?php endif; ?>">
            <?php echo wp_kses_post( $children ); ?>
            </ul>
        </div><?php
    endif;
}
endif;

if ( ! function_exists( 'cz_wedocs_featured_icon' ) ):
    /**
     * Displays Docs Featured Icon
     */
    function cz_wedocs_featured_icon( $thepostid = null ) {
        $featured_icon = cz_get_post_featured_icon( $thepostid );

        if ( $featured_icon ) {
            ?><i class="<?php echo esc_attr( $featured_icon );?> h2 mt-2 mb-4 text-primary"></i><?php
        } else {
            ?><i class="czi-user-circle h2 mt-2 mb-4 text-primary"></i><?php
        }
    }
endif;
