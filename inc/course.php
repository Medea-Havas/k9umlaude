<?php

/**
 * Template Name: Course
 *
 * @subpackage k9umlaude
 */

$context = Timber::get_context();

$courses = array(
  'post_type' => 'cursos',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['courses'] = Timber::get_posts($courses);

$modules = array(
  'post_type' => 'modulos',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['modules'] = Timber::get_posts($modules);

// $chapters = array(
//   'post_type' => 'capitulo',
//   'orderby' => 'title',
//   'order' => 'ASC',
// );
// $context['chapters'] = Timber::get_posts($chapters);

// $subchapters = array(
//   'post_type' => 'apartado',
//   'orderby' => 'title',
//   'order' => 'ASC',
// );
// $context['subchapters'] = Timber::get_posts($subchapters);

Timber::render('course.twig', $context);
