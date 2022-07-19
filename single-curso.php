<?php

$context = Timber::get_context();

$currentUser = new Timber\User();
$context['current_user'] = $currentUser;

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

$context['completed_modules'] = $wpdb->get_results("SELECT id_modulo, fecha FROM usuarios_modulos WHERE id_usuario = $currentUser->id");
$context['completed_chapters'] = $wpdb->get_results("SELECT id_capitulo, fecha FROM usuarios_capitulos WHERE id_usuario = $currentUser->id");

$context['mega_query'] = $wpdb->get_results("SELECT id_capitulo, fecha FROM usuarios_capitulos INNER JOIN med_posts ON usuarios_capitulos.id_capitulo=med_posts.id WHERE usuarios_capitulos.id_usuario = $currentUser->id");
$context['mega_query2'] = $wpdb->get_results("SELECT id_modulo, fecha FROM usuarios_modulos INNER JOIN med_posts ON usuarios_modulos.id_modulo=med_posts.id WHERE usuarios_modulos.id_usuario = $currentUser->id");

$context['post'] = new Timber\Post();

Timber::render('course.twig', $context);
