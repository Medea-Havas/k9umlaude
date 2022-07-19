<?php

/**
 * Table usuarios_capitulos
 */
add_action('rest_api_init', function () {
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
  // POST
  register_rest_route('user-chapters', '/post', array(
    'methods' => 'POST',
    'callback' => 'post_chapter_video',
    'permission_callback' => function ($data) {
      return $data;
    }
  ));
});

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
  echo json_encode(array('success' => true, 'message' => 'Updated chapter ' . $chapterId . '\'s watched time to ' . $position, 'list' => $list));
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
    echo json_encode(array('success' => false, 'message' => 'Chapter ' . $chapterId . ' already exists'));
  } else {
    $query2 = 'INSERT INTO usuarios_capitulos (id_usuario, id_capitulo, fecha) VALUES ( ' . $userId . ', ' . $chapterId . ', "' . $date . '")';
    $list2 = $wpdb->get_results($query2);
    echo json_encode(array('success' => true, 'message' => 'Chapter ' . $chapterId . ' completed', 'list' => $list2));
  }
}
