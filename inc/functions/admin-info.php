<?php

add_action('admin_menu', 'custom_menu');

function custom_menu()
{
  add_menu_page('Información', 'Información', 'manage_options', 'stats', 'show_admin_info', 'dashicons-welcome-learn-more', 42);
}

function show_admin_info()
{
  global $wpdb;
  $query = 'SELECT ID, display_name, user_email, user_registered FROM med_users ORDER BY display_name';
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
      </tr>
      <?php foreach ($list as $item) { ?>
        <tr>
          <td><?= $item->ID ?></td>
          <td><?= $item->display_name ?></td>
          <td><?= $item->user_email ?></td>
          <td><?= date('d/m/y H:i:s', strtotime($item->user_registered)) ?></td>
        </tr>
      <?php } ?>
    </table>
  </div>
<?php } ?>