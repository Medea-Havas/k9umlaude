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

$committee = array(
  'post_type' => 'committee',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['committee'] = Timber::get_posts($committee);

Timber::render('home.twig', $context);
