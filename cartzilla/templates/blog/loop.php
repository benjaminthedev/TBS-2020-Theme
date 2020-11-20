<?php
/**
 * Template part for displaying the "List" blog layout (with sidebar)
 *
 * @author Createx Studio
 * @package Cartzilla
 */

$posts_layout = function_exists( 'cartzilla_posts_layout' ) ? cartzilla_posts_layout() : 'list';
get_template_part( 'templates/blog/loop', $posts_layout );
