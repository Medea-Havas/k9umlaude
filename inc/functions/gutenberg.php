<?php

// Styles
function gutenberg_css()
{
  add_theme_support('editor-styles');
  add_editor_style('assets/css/style-editor.min.css');
}
add_action('after_setup_theme', 'gutenberg_css');

// Disable Gutenberg for post types
function prefix_disable_gutenberg($current_status, $post_type)
{
  if (
    $post_type === 'home'
    || $post_type === 'about'
    || $post_type === 'services'
    || $post_type === 'projects'
    || $post_type === 'clients'
    || $post_type === 'news'
    || $post_type === 'contact'
    || $post_type === 'others'
  ) return false;
  return $current_status;
}
add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);

// Theme custom font sizes
add_theme_support(
  'editor-font-sizes',
  array(
    array(
      'name'      => __('Pequeña', 'medea'),
      'shortName' => __('Sm', 'medea'),
      'size'      => 14,
      'slug'      => 'small'
    ),
    array(
      'name'      => __('Base', 'medea'),
      'shortName' => __('B', 'medea'),
      'size'      => 16,
      'slug'      => 'base'
    ),
    array(
      'name'      => __('Normal', 'medea'),
      'shortName' => __('N', 'medea'),
      'size'      => 18,
      'slug'      => 'regular'
    ),
    array(
      'name'      => __('Mediana S', 'medea'),
      'shortName' => __('Ms', 'medea'),
      'size'      => 20,
      'slug'      => 'medium-s'
    ),
    array(
      'name'      => __('Mediana L', 'medea'),
      'shortName' => __('Ml', 'medea'),
      'size'      => 22,
      'slug'      => 'medium-l'
    ),
    array(
      'name'      => __('Grande', 'medea'),
      'shortName' => __('G', 'medea'),
      'size'      => 30,
      'slug'      => 'big'
    ),
    array(
      'name'      => __('Enorme', 'medea'),
      'shortName' => __('E', 'medea'),
      'size'      => 60,
      'slug'      => 'huge'
    )
  )
);

// Disable Gutenberg custom font size
add_theme_support('disable-custom-font-sizes');
