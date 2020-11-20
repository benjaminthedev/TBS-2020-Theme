<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cartzilla
 */

?>
    </main>
    <?php
    /**
     * Fires right before the site footer
     */
    do_action( 'cartzilla_footer_before' );


    /**
     * Fires right the site footer
     */
    do_action( 'cartzilla_footer' );

    /**
     * Fires right after the site footer
     */
    do_action( 'cartzilla_footer_after' );

    ?>
</div>

<?php wp_footer(); ?>

</body>
</html>
