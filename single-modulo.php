<?php
global $wpdb;
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

$context['current_user'] = new Timber\User();

$context['cust'] = $wpdb->get_results("SELECT * FROM usuarios_subcapitulos WHERE id_usuario = 8");

$context['post'] = new Timber\Post();

Timber::render('module.twig', $context);
