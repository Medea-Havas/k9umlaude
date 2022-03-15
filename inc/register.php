<?php

/**
 * Template Name: Register
 *
 * @subpackage k9umlaude
 */
acf_form_head();

$context = Timber::get_context();
$siteUrl = site_url();

$context['form_args'] = [
  'post_id' => 'new_post',
  'post_title' => true,
  'post_content' => false,
  'post_custom_name' => true,
  'field_groups' => ['group_621f4268813c3'], // ACF group id
  'form' => true,
  'return' => $siteUrl . '/login',
  'new_post' => [
    'post_status' => 'publish',
    'post_type' => 'students'
  ],
  'submit_value' => 'Crear estudiante'
];

Timber::render('register.twig', $context);
