<?php

$context = Timber::get_context();

$context['parent'] = get_post_field('belongs_to', null, $context);

$chapters = array(
  'post_type' => 'capitulo',
  'orderby' => 'title',
  'order' => 'ASC',
);
$context['chapters'] = Timber::get_posts($chapters);

$subchapters = array(
  'post_type' => 'subcapitulo',
  'meta_key' => 'order',
  'orderby' => 'meta_value',
  'order' => 'ASC'
);
$context['subchapters'] = Timber::get_posts($subchapters);

$materials = array(
  'post_type' => 'materials',
  'orderby' => 'title',
  'order' => 'ASC'
);
$context['materials'] = Timber::get_posts($materials);

$context['post'] = new Timber\Post();

Timber::render('module.twig', $context);
