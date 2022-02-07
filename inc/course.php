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

Timber::render('course.twig', $context);
