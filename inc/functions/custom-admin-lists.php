<?php
// -- ORDER BY
/* make CPT posts in admin order by title */
/* Sort posts in wp_list_table by column in ascending or descending order. */
function custom_post_order($query)
{
  /*
      Set post types.
      _builtin => true returns WordPress default post types.
      _builtin => false returns custom registered post types.
  */
  /* set the _builtin to false which will order our Custom post types by title */
  $post_types = get_post_types(array('_builtin' => false), 'names');
  /* The current post type. */
  $post_type = $query->get('post_type');
  /* Check post types. */
  if (in_array($post_type, $post_types)) {
    /* Post Column: e.g. title */
    if ($query->get('orderby') == '') {
      $query->set('orderby', 'title');
    }
    /* Post Order: ASC / DESC */
    if ($query->get('order') == '') {
      $query->set('order', 'ASC');
    }
  }
}
if (is_admin()) {
  add_action('pre_get_posts', 'custom_post_order');
}

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

// -- Committee members
function custom_committee_list($columns)
{
  unset($columns['date']);

  $columns['description']    = 'Descripción';

  return $columns;
}

function add_committee_content($column)
{
  global $post;

  if ($column == 'description') {
    $typ = get_field('description');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
}

add_action('manage_committee_posts_custom_column', 'add_committee_content');
add_filter('manage_committee_posts_columns', 'custom_committee_list');


// -- Exam questions
function custom_questions_list($columns)
{
  unset($columns['date']);
  unset($columns['title']);

  $columns['title']        = 'Título';
  $columns['question']     = 'Pregunta';
  $columns['answer_01']   = 'Respuesta 1';
  $columns['answer_2']   = 'Respuesta 2';
  $columns['answer_3']   = 'Respuesta 3';
  $columns['answer_4']   = 'Respuesta 4';
  $columns['right_answer']   = 'Correcta';
  $columns['belongs_to']   = 'Pertenece a';

  return $columns;
}

function add_question_content($column)
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
  if ($column == 'question') {
    $typ = get_field('question');
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
  if ($column == 'answer_01') {
    $typ = get_field('answer_01');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'answer_2') {
    $typ = get_field('answer_2');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'answer_3') {
    $typ = get_field('answer_3');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'answer_4') {
    $typ = get_field('answer_4');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
  if ($column == 'right_answer') {
    $typ = get_field('right_answer');
    if ($typ) {
      echo $typ;
    } else {
      echo '-';
    }
  }
}

add_action('manage_test_posts_custom_column', 'add_question_content');
add_filter('manage_test_posts_columns', 'custom_questions_list');


// -- Users
function custom_users_list($columns)
{
  unset($columns['username']);
  unset($columns['name']);
  unset($columns['role']);
  unset($columns['posts']);
  unset($columns['email']);

  $columns['fullName']    = 'Nombre';
  $columns['email']    = 'Email';
  $columns['phone']    = 'Teléfono';
  $columns['specialty']    = 'Especialidad';

  return $columns;
}

function add_users_content($typ, $column, $user_id)
{
  if ($column == 'phone') {
    $typ = count(get_user_meta($user_id, 'phone')) ? get_user_meta($user_id, 'phone')[0] : null;
    if ($typ) {
      return $typ;
    } else {
      return '-';
    }
  }

  if ($column == 'fullName') {
    $name = count(get_user_meta($user_id, 'name')) ? get_user_meta($user_id, 'name')[0] : get_userdata($user_id)->user_login;
    $first_lastname = count(get_user_meta($user_id, 'first_lastname')) ? get_user_meta($user_id, 'first_lastname')[0] : null;
    $second_lastname = count(get_user_meta($user_id, 'second_lastname')) ? get_user_meta($user_id, 'second_lastname')[0] : null;
    $fullname = $name . ' ' . $first_lastname . ' ' . $second_lastname;
    $typ = '<a href="' . site_url() . '/wp-admin/user-edit.php?user_id=' . $user_id . '&wp_http_referer=%2Fk9umlaude%2Fwp-admin%2Fusers.php">' . $fullname . '</a>';
    if ($typ) {
      return $typ;
    } else {
      return '-';
    }
  }

  if ($column == 'specialty') {
    $typ = count(get_user_meta($user_id, 'specialty')) ? get_user_meta($user_id, 'specialty')[0] : null;
    if ($typ) {
      return $typ;
    } else {
      return '-';
    }
  }
}
add_action('manage_users_custom_column', 'add_users_content', 10, 3);
add_filter('manage_users_columns', 'custom_users_list');
add_filter('manage_users_sortable_columns', function ($columns) {
  $columns['fullName'] = 'Nombre';
  $columns['phone'] = 'Teléfono';
  $columns['specialty'] = 'Especialidad';
  return $columns;
});
