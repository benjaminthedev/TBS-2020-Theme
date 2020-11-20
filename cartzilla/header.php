<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package cartzilla
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'cartzilla_before_site' ); ?>

<div id="page" class="hfeed site">

    <?php

    /**
     * Fires right before the site header
     */
    do_action( 'cartzilla_header_before' );

    /**
     * Fires right the site header
     */
    do_action( 'cartzilla_header' );

    /**
     * Fires right after the site header
     */
    do_action( 'cartzilla_header_after' );

    /**
     * Functions hooked in to cartzilla_before_content
     *
     */
    do_action( 'cartzilla_before_content' );
    ?>

    <main id="content" role="main" tabindex="-1" class="<?php echo cartzilla_header_layout() === 'grocery' ? 'sidebar-fixed-enabled': 'site-main';?>">

        <?php
        do_action( 'cartzilla_content_top' );
