<?php

add_action('rest_api_init', function () {
  /**
   * Table usuarios_capitulos
   */

  // GET
  register_rest_route('user-chapters', '/completed_chapters', array(
    'methods' => 'GET',
    'callback' => 'get_completed_chapters',
    'permission_callback' => function () {
      return '';
    }
  ));
  // GET
  register_rest_route('user-chapters', '/video_at', array(
    'methods' => 'GET',
    'callback' => 'get_chapter_video_at',
    'permission_callback' => function () {
      return '';
    }
  ));
  // PUT
  register_rest_route('user-chapters', '/update', array(
    'methods' => 'POST',
    'callback' => 'update_chapter_video_at',
    'permission_callback' => function () {
      return '';
    }
  ));
  // PUT
  register_rest_route('users', '/update', array(
    'methods' => 'POST',
    'callback' => 'update_user_poll',
    'permission_callback' => function () {
      return '';
    }
  ));
  // POST
  register_rest_route('user-chapters', '/post', array(
    'methods' => 'POST',
    'callback' => 'post_chapter_video',
    'permission_callback' => function ($data) {
      return $data;
    }
  ));

  /**
   * Table usuarios_modulos
   */
  // POST
  register_rest_route('user-modules', '/post', array(
    'methods' => 'POST',
    'callback' => 'post_module',
    'permission_callback' => function ($data) {
      return $data;
    }
  ));
  /**
   * Table usuarios_cursos
   */
  // GET
  register_rest_route('user-courses', '/list', array(
    'methods' => 'GET',
    'callback' => 'get_user_course_info',
    'permission_callback' => function () {
      return '';
    }
  ));
  // POST
  register_rest_route('user-courses', '/post', array(
    'methods' => 'POST',
    'callback' => 'post_course',
    'permission_callback' => function ($data) {
      return $data;
    }
  ));
});

/**
 * Table usuarios_capitulos
 */
function get_completed_chapters()
{
  global $wpdb;
  $userId = $_GET['userId'];
  $query = 'SELECT id_capitulo FROM usuarios_capitulos WHERE id_usuario = ' . $userId;
  $list = $wpdb->get_results($query);
  $chapterIds = [];
  foreach ($list as $item) {
    array_push($chapterIds, intval($item->id_capitulo));
  }
  return $chapterIds;
}

function get_chapter_video_at()
{
  global $wpdb;
  $chapterId = $_GET['chapterId'];
  $userId = $_GET['userId'];
  $query = 'SELECT id_capitulo, posicion_video FROM usuarios_capitulos WHERE id_capitulo = ' . $chapterId . ' AND id_usuario = ' . $userId;
  $list = $wpdb->get_results($query);
  if (count($list) > 0) {
    return $list[0];
  }
  return [];
}

function update_chapter_video_at($data)
{
  global $wpdb;
  $position = number_format($data->get_param('position'), 0);
  $chapterId = $data->get_param('id');
  $userId = $data->get_param('userId');
  $query = 'UPDATE usuarios_capitulos SET posicion_video = ' . $position . ' WHERE id_capitulo = ' . $chapterId . ' AND id_usuario = ' . $userId;
  $list = $wpdb->get_results($query);
  return json_encode(array('success' => true, 'message' => 'Updated chapter ' . $chapterId . '\'s watched time to ' . $position, 'list' => $list));
}

function post_chapter_video($data)
{
  global $wpdb;
  $userId = $data->get_param('userId');
  $chapterId = $data->get_param('chapterId');
  $date = date('Y-m-d H:i:s', time());
  $query = 'SELECT id FROM usuarios_capitulos WHERE id_usuario = ' . $userId . ' AND id_capitulo = ' . $chapterId;
  $list = $wpdb->get_results($query);
  if (count($list)) {
    return json_encode(array('success' => false, 'message' => 'Chapter ' . $chapterId . ' already exists'));
  } else {
    $query2 = 'INSERT INTO usuarios_capitulos (id_usuario, id_capitulo, fecha) VALUES ( ' . $userId . ', ' . $chapterId . ', "' . $date . '")';
    $list2 = $wpdb->get_results($query2);
    return json_encode(array('success' => true, 'message' => 'Chapter ' . $chapterId . ' completed', 'list' => $list2));
  }
}


/**
 * Table usuarios_modulos
 */
function post_module($data)
{
  global $wpdb;
  $userId = $data->get_param('userId');
  $moduleId = $data->get_param('moduleId');
  $date = date('Y-m-d H:i:s', time());
  $query = 'SELECT id FROM usuarios_modulos WHERE id_usuario = ' . $userId . ' AND id_modulo = ' . $moduleId;
  $list = $wpdb->get_results($query);
  if (count($list)) {
    return json_encode(array('success' => false, 'message' => 'Module ' . $moduleId . ' already exists'));
  } else {
    $query2 = 'INSERT INTO usuarios_modulos (id_usuario, id_modulo, fecha) VALUES ( ' . $userId . ', ' . $moduleId . ', "' . $date . '")';
    $wpdb->get_results($query2);
    return json_encode(array('success' => true, 'message' => 'Module ' . $moduleId . ' completed'));
  }
}

/**
 * Table usuarios_cursos
 */
function post_course($data)
{
  global $wpdb;
  $userId = $data->get_param('userId');
  $courseId = $data->get_param('courseId');
  $grade = $data->get_param('grade');
  $credits = str_replace(',', '.', $data->get_param('credits'));
  $completed = date('Y-m-d H:i:s');
  $completed_modules_query = 'SELECT COUNT(id_modulo) AS completed FROM usuarios_modulos WHERE id_usuario = ' . $userId . '';
  $completed_modules = $wpdb->get_results($completed_modules_query)[0]->completed;
  // 37 total chapters / completed chapters * 100 * 100
  $progress = 100 / 8 * $completed_modules;
  $already_completed = 'SELECT superado FROM usuarios_cursos WHERE id_usuario = ' . $userId . '';
  $already_completed_count = count($wpdb->get_results($already_completed));
  if ($already_completed_count > 0) {
    return json_encode(array('success' => false, 'message' => 'Course already completed'));
  } else {
    $query = 'INSERT INTO usuarios_cursos (id_usuario, id_curso, superado, progreso, creditos_obtenidos, nota) VALUES (' . $userId . ', ' . $courseId . ', "' . $completed . '", ' . $progress . ', ' . $credits . ', ' . $grade . ')';
    $wpdb->get_results($query);
    return json_encode(array('success' => true, 'message' => 'Completed course succesfully added'));
  }
}

function get_user_course_info()
{
  global $wpdb;
  $userId = $_GET['userId'];
  $query = 'SELECT * FROM usuarios_cursos WHERE id_usuario = ' . $userId . '';
  $list = $wpdb->get_results($query);
  if (count($list) > 0) {
    return $list[0];
  }
  return [];
}

// Table users
function update_user_poll($data)
{
  global $wpdb;
  $userId = $data->get_param('userId');
  $query = 'UPDATE `med_usermeta` SET `meta_value` = 1 WHERE `user_id` = ' . $userId . ' AND `meta_key` = "poll_completed"';
  echo $query;
  $list = $wpdb->get_results($query);
  return json_encode(array('success' => true, 'message' => 'User completed poll', 'list' => $list));
}
