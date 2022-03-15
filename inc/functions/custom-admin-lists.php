<?php
// -- Students
function custom_students_list($columns)
{
  unset($columns['title']);

  $columns['name']              = 'Nombre';
  $columns['first_lastname']    = 'Primer apellido';
  $columns['second_lastname']   = 'Segundo apellido';
  $columns['specialty']         = 'Especialidad';
  $columns['email']             = 'Email';
  $columns['phone']             = 'Móvil';
  return $columns;
}

function add_students_content($column)
{
  global $post;

  if ($column == 'name') {
    $typ = get_field('name');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'first_lastname') {
    $typ = get_field('first_lastname');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'second_lastname') {
    $typ = get_field('second_lastname');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'specialty') {
    $typ = get_field('specialty');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'email') {
    $typ = get_field('email');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'phone') {
    $typ = get_field('phone');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
}

add_action('manage_students_posts_custom_column', 'add_students_content');
add_filter('manage_students_posts_columns', 'custom_students_list');

// -- Courses
function custom_curso_list($columns)
{
  unset($columns['date']);

  $columns['hours']      = 'Horas';
  $columns['credits']    = 'Créditos';

  return $columns;
}

function add_curso_content($column)
{
  global $post;

  if ($column == 'hours') {
    $typ = get_field('hours');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'credits') {
    $typ = get_field('credits');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
}

add_action('manage_curso_posts_custom_column', 'add_curso_content');
add_filter('manage_curso_posts_columns', 'custom_curso_list');

// -- Modules
function custom_modulo_list($columns)
{
  unset($columns['title']);
  unset($columns['date']);

  $columns['module_number']    = 'Número';
  $columns['title']             = 'Nombre';
  $columns['minutes']           = 'Minutos';
  $columns['module_author']     = 'Autor';

  return $columns;
}

function add_modulo_content($column)
{
  global $post;

  if ($column == 'module_number') {
    $typ = get_field('module_number');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'title') {
    $typ = get_field('title');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'minutes') {
    $typ = get_field('minutes');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'module_author') {
    $typ = get_field('module_author');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
}

add_action('manage_modulo_posts_custom_column', 'add_modulo_content');
add_filter('manage_modulo_posts_columns', 'custom_modulo_list');

// -- Chapters
function custom_capitulo_list($columns)
{
  unset($columns['title']);
  unset($columns['date']);

  $columns['chapter_number']   = 'Número';
  $columns['chapter_name']     = 'Nombre';
  $columns['minutes']          = 'Minutos';

  return $columns;
}

function add_capitulo_content($column)
{
  global $post;

  if ($column == 'chapter_number') {
    $typ = get_field('chapter_number');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'chapter_name') {
    $typ = get_field('chapter_name');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'minutes') {
    $typ = get_field('minutes');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
}

add_action('manage_capitulo_posts_custom_column', 'add_capitulo_content');
add_filter('manage_capitulo_posts_columns', 'custom_capitulo_list');

// -- Subchapters
function custom_subcapitulo_list($columns)
{
  unset($columns['date']);

  $columns['order']   = 'Orden';
  $columns['time']    = 'Duración';

  return $columns;
}

function add_subcapitulo_content($column)
{
  global $post;

  if ($column == 'order') {
    $typ = get_field('order');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'time') {
    $typ = get_field('time');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
}

add_action('manage_subcapitulo_posts_custom_column', 'add_subcapitulo_content');
add_filter('manage_subcapitulo_posts_columns', 'custom_subcapitulo_list');
