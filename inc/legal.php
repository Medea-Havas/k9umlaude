<?php

/**
 * Template Name: Legal
 *
 * @subpackage k9umlaude
 */
$context = Timber::get_context();

$context['post'] = new Timber\Post();

Timber::render('legal.twig', $context);
