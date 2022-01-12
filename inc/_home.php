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

$modules = array(
  'post_type' => 'modulo',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['modules'] = Timber::get_posts($modules);

$chapters = array(
  'post_type' => 'capitulo',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['chapters'] = Timber::get_posts($chapters);

Timber::render('home.twig', $context);
