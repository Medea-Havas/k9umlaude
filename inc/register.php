<?php

/**
 * Template Name: Register
 *
 * @subpackage k9umlaude
 */
acf_form_head();

$context = Timber::get_context();

$context['form_args'] = [
  'post_id' => 'new_post',
  'post_title' => false,
  'post_content' => false,
  'post_custom_name' => true,
  'field_groups' => ['group_621f4268813c3'], // ACF group id
  'form' => true,
  'return' => '/login', // Redirect to login once created
  'html_before_fields' => '<div class="field">',
  'html_after_fields' => '</div>',
  'new_post' => [
    'post_status' => 'draft',
    'post_type' => 'student'
  ],
  'submit_value' => 'Crear estudiante'
];

Timber::render('register.twig', $context);
