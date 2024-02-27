<?php

/**
 * Template Name: Certificates
 *
 * @subpackage k9umlaude
 */
$context = Timber::get_context();

$userId = isset($_GET['data']) ? str_replace('med', '', $_GET['data']) : null;


// $context['user'] = new Timber\User($userId);
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

$user = $wpdb->get_results("SELECT * FROM `med_usermeta` WHERE `user_id` = " . $userId . " AND (`meta_key` = 'name' OR `meta_key` = 'first_lastname' OR `meta_key` = 'second_lastname' OR `meta_key` = 'dni_nie' OR `meta_key` = 'working_province')");
$context['user'] = $user;


$certificateType = $wpdb->get_var("SELECT DATEDIFF(superado, '2023-05-24') FROM usuarios_cursos WHERE id_usuario = $userId");
$context['certificate_type'] = $certificateType;

Timber::render('certificate.twig', $context);
