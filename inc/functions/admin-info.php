<?php

add_action('admin_menu', 'custom_menu');

function custom_menu()
{
  add_menu_page('Información', 'Información', 'manage_options', 'stats', 'show_admin_info', 'dashicons-welcome-learn-more', 42);
}

function show_admin_info()
{
  global $wpdb;
  $query = 'SELECT MU.ID, display_name, user_email, user_registered, superado, progreso, creditos_obtenidos, nota FROM med_users MU LEFT JOIN usuarios_cursos UC ON MU.ID = UC.id_usuario ORDER BY display_name';
  $list = $wpdb->get_results($query);
?>
  <div id="admin-info">
    <h1>Información</h1>
    <table>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Fecha de registro</th>
        <th>Fecha superación examen</th>
        <th>Progreso hasta superar examen</th>
        <th>Créditos obtenidos</th>
        <th>Nota de examen</th>
      </tr>
      <?php foreach ($list as $item) { ?>
        <tr>
          <td><?= $item->ID ?></td>
          <td><?= $item->display_name ?></td>
          <td><?= $item->user_email ?></td>
          <td><?php if (isset($item->user_registered)) echo date('d/m/y H:i:s', strtotime($item->user_registered)) ?></td>
          <td><?php if (isset($item->superado)) echo date('d/m/y', strtotime($item->superado)) ?></td>
          <td><?php if (isset($item->progreso)) echo $item->progreso . '%' ?></td>
          <td><?php if (isset($item->creditos_obtenidos)) echo $item->creditos_obtenidos ?></td>
          <td><?php if (isset($item->nota)) echo $item->nota . '%' ?></td>
        </tr>
      <?php } ?>
    </table>
  </div>
<?php } ?>