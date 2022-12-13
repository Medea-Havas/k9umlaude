<?php

/**
 * Template Name: Certificates
 *
 * @subpackage k9umlaude
 */
$context = Timber::get_context();

$userId = isset($_GET['data']) ? str_replace('med', '', $_GET['data']) : null;


$context['user'] = new Timber\User($userId);
$context['course'] = new Timber\Post(90);

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

Timber::render('certificate.twig', $context);
