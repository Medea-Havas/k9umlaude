<?php

$context = Timber::get_context();

$modules = array(
  'post_type' => 'modulo',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['modules'] = Timber::get_posts($modules);

$context['post'] = new Timber\Post();

Timber::render('course.twig', $context);
