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

  $columns['credits']    = 'Créditos';

  return $columns;
}

function add_curso_content($column)
{
  global $post;

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

  $columns['title']             = 'Nombre';
  $columns['module_author']     = 'Autor';
  $columns['belongs_to']     = 'Pertenece a';

  return $columns;
}

function add_modulo_content($column)
{
  global $post;

  if ($column == 'title') {
    $typ = get_field('title');
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
  if ($column == 'belongs_to') {
    $typ = get_field('belongs_to');
    if ($typ) {
      echo $typ->post_title;
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

  $columns['chapter_name']     = 'Nombre';
  $columns['video']          = 'Vídeo';
  $columns['belongs_to']   = 'Pertenece a';
  $columns['minutes']          = 'Minutos';

  return $columns;
}

function add_capitulo_content($column)
{
  global $post;

  if ($column == 'chapter_name') {
    $typ = get_field('chapter_number');
    $typ2 = get_field('chapter_name');
    if ($typ && $typ2) {
      echo $typ . ' ' . $typ2;
    } else {
      echo '-';
    }
  }
  if ($column == 'video') {
    $typ = get_field('video');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'belongs_to') {
    $typ = get_field('belongs_to');
    if ($typ) {
      echo $typ->post_title;
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
