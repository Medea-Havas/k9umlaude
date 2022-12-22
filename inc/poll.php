<?php

/**
 * Template Name: Poll
 *
 * @subpackage k9umlaude
 */
acf_form_head();

$context = Timber::get_context();

$user = new Timber\User();

$context['post'] = new TimberPost();

$context['poll_args'] = [
  'post_id' => 'new_post',
  'form' => true,
  'post_title' => true,
  'new_post' => [
    'post_type' => 'poll',
    'post_status'   => 'publish'
  ],
  'submit_value' => 'Enviar encuesta',
  'updated_message' => 'Encuesta enviada',
  'html_submit_button'  => '<input type="submit" data-id="' . $user->ID . '" data-usr="' . $user->user_login . '" class="button" value="%s" />',
];

$updated = isset($_GET['updated']) ? $_GET['updated'] : false;

$context['alert'] = $updated;


Timber::render('poll.twig', $context);
