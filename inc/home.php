<?php

/**
 * Template Name: Home
 *
 * @subpackage k9umlaude
 */
$context = Timber::get_context();

$courses = array(
  'post_type' => 'curso',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['courses'] = Timber::get_posts($courses);

Timber::render('home.twig', $context);
