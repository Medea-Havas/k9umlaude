<?php

/**
 * Table usuarios_capitulos
 */
add_action('rest_api_init', function () {
  // GET
  register_rest_route('user-chapters', '/video_at', array(
    'methods' => 'GET',
    'callback' => 'get_chapter_video_at',
    'permission_callback' => function () {
      return '';
    }
  ));
  // POST
  register_rest_route('user-chapters', '/update', array(
    'methods' => 'POST',
    'callback' => 'update_chapter_video_at',
    'permission_callback' => function () {
      return '';
    }
  ));
});

function get_chapter_video_at()
{
  global $wpdb;
  $chapterId = $_GET['chapterId'];
  $userId = $_GET['userId'];
  $query = 'SELECT id_capitulo, posicion_video  FROM usuarios_capitulos WHERE id_capitulo = ' . $chapterId . ' AND id_usuario = ' . $userId;
  $list = $wpdb->get_results($query);
  if (count($list) > 0) {
    return $list[0];
  }
  return [];
}

function update_chapter_video_at($data)
{
  global $wpdb;
  $position = number_format($data->get_param('position'), 2, '.', '');
  $id = $data->get_param('id');
  $userId = $data->get_param('userId');
  $query = 'UPDATE usuarios_capitulos SET posicion_video = ' . $position . ' WHERE id_capitulo = ' . $id . ' AND id_usuario = ' . $userId;
  $list = $wpdb->get_results($query);
  echo json_encode(array('success' => true, 'message' => 'Updated chapter ' . $id . '\'s watched time to ' . $position, 'list' => $list));
}
