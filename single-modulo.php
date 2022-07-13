<?php
global $wpdb;
$context = Timber::get_context();

$context['parent'] = get_post_field('belongs_to', null, $context);

$chapters = array(
  'post_type' => 'capitulo',
  'number_posts' => 50,
  'orderby' => 'title',
  'order' => 'ASC'
);
$context['chapters'] = Timber::get_posts($chapters);

$materials = array(
  'post_type' => 'materials',
  'orderby' => 'title',
  'order' => 'ASC'
);
$context['materials'] = Timber::get_posts($materials);

$currentUser = new Timber\User();
$context['current_user'] = $currentUser;

$context['module_ids'] = $wpdb->get_results("SELECT id_modulo FROM usuarios_modulos WHERE id_usuario = $currentUser->id");
$context['chapter_ids'] = $wpdb->get_results("SELECT id_capitulo FROM usuarios_capitulos WHERE id_usuario = $currentUser->id");

$context['post'] = new Timber\Post();

Timber::render('module.twig', $context);
