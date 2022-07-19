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
$context['course'] = Timber::get_posts($courses)[0];

$modules = array(
  'post_type' => 'modulo',
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key' => 'belongs_to',
      'value' => $context['course']->id,
      'compare' => 'LIKE'
    )
  ),
);
$context['modules'] = Timber::get_posts($modules);

$chapters = array(
  'post_type' => 'capitulo',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['chapters'] = Timber::get_posts($chapters);

$committee = array(
  'post_type' => 'committee',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['committee'] = Timber::get_posts($committee);

$home_cards = array(
  'post_type' => 'home_cards',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['home_cards'] = Timber::get_posts($home_cards);

$home_intro = array(
  'post_type' => 'home_intro',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['home_intro'] = Timber::get_posts($home_intro);

Timber::render('home.twig', $context);
