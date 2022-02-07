<?php

/**
 * Template Name: Contact
 *
 * @subpackage k9umlaude
 */
$context = Timber::get_context();

$context['post'] = new Timber\Post();

Timber::render('contact.twig', $context);
