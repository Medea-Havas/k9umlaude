<?php

add_action('admin_menu', 'custom_menu');

function custom_menu()
{
  add_menu_page('Información usuarios', 'Información usuarios', 'manage_options', 'stats', 'show_admin_info', 'dashicons-welcome-learn-more', 42);
}

function show_admin_info()
{
  global $wpdb;
  $query = 'SELECT MU.ID, display_name, user_email, user_registered, superado, progreso, creditos_obtenidos, nota FROM med_users MU LEFT JOIN usuarios_cursos UC ON MU.ID = UC.id_usuario ORDER BY display_name';
  $list = $wpdb->get_results($query);
?>
  <div id="admin-info">
    <div class="users-header">
      <h1>Información de usuarios</h1>
      <div class="download-files">
        <a title="Descargar XLS" download="usuarios_k9um.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatable2', 'Usuarios K9umlaude');"><img src="<?= get_template_directory_uri() ?>/static/img/xls.png"></a>
        <a title="Descargar CSV" download="usuarios_k9um.csv" href="#" onclick="return ExcellentExport.csv(this, 'datatable2');"><img src="<?= get_template_directory_uri() ?>/static/img/csv.png"></a>
      </div>
    </div>
    <table id="datatable2" class="sortable">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Móvil</th>
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
          <td><?= get_user_meta($item->ID, 'phone', true) ?></td>
          <td sorttable_customkey="<?= strtotime($item->user_registered) ?>"><?php if (isset($item->user_registered)) echo date('d/m/y H:i:s', strtotime($item->user_registered)) ?></td>
          <td sorttable_customkey="<?= strtotime($item->superado) ?>"><?php if (isset($item->superado)) echo date('d/m/y', strtotime($item->superado)) ?></td>
          <td><?php if (isset($item->progreso)) echo $item->progreso . '%' ?></td>
          <td><?php if (isset($item->creditos_obtenidos)) echo $item->creditos_obtenidos ?></td>
          <td><?php if (isset($item->nota)) echo $item->nota . '%' ?></td>
        </tr>
      <?php } ?>
    </table>
  </div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@2.1.0/dist/excellentexport.min.js"></script>
<?php }
add_action('admin_menu', 'custom_menu2');

function custom_menu2()
{
  add_menu_page('Información encuesta', 'Información encuesta', 'manage_options', 'pollstats', 'show_admin_info2', 'dashicons-welcome-write-blog', 44);
}

function show_admin_info2()
{
  $polls = get_posts(array(
    'posts_per_page'    => -1,
    'post_type'         => 'poll',
    'order' => 'ASC',
    'orderby' => 'meta_value_num',
    'meta_key' => 'user_name'
  )); ?>
  <div id="admin-polls">
    <?php if ($polls) : ?>
      <div class="polls-header">
        <h1>Encuestas</h1>
        <div class="download-files">
          <a title="Descargar XLS" download="encuesta_k9um.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatable', 'Encuesta K9umlaude');"><img src="<?= get_template_directory_uri() ?>/static/img/xls.png"></a>
          <a title="Descargar CSV" download="encuesta_k9um.csv" href="#" onclick="return ExcellentExport.csv(this, 'datatable');"><img src="<?= get_template_directory_uri() ?>/static/img/csv.png"></a>
        </div>
      </div>
      <table id="datable" class="sortable">
        <tr>
          <th onclick="pressTh(0)" title="ID de usuario">ID</th>
          <th onclick="pressTh(1)" title="Nombre de usuario">Nombre</th>
          <th onclick="pressTh(2)" title="Estructura del curso">Estructura</th>
          <th onclick="pressTh(3)" title="Contenidos científicos">Científico</th>
          <th onclick="pressTh(4)" title="Aportación a mis conocimientos">Conocimiento</th>
          <th onclick="pressTh(5)" title="Utilidad en la práctica clínica">Clínica</th>
          <th onclick="pressTh(6)" title="Duración del curso">Duración</th>
          <th onclick="pressTh(7)" title="Utilidad del material de apoyo">Materiales</th>
          <th onclick="pressTh(8)" title="Entorno y organización">Organización</th>
          <th onclick="pressTh(9)" title="Expectativas satisfechas">Expectativas</th>
          <th onclick="pressTh(10)" title="¿Recomendaría esta actividad a un compañero?">Recomendaría</th>
          <th></th>
        </tr>
        <?php foreach ($polls as $poll) : ?>
          <tr>
            <td><?= get_post_meta($poll->ID, 'user_id', true) ?></td>
            <td><a href="<?= site_url() ?>/wp-admin/user-edit.php?user_id=<?= get_post_meta($poll->ID, 'user_id', true) ?>"><?= get_post_meta($poll->ID, 'user_name', true) ?></a></td>
            <td sorttable_customkey="<?= stringToNums(get_post_meta($poll->ID, 'structure', true)) ?>"><?= stringToStars(get_post_meta($poll->ID, 'structure', true)) ?></td>
            <td sorttable_customkey="<?= stringToNums(get_post_meta($poll->ID, 'scientific', true)) ?>"><?= stringToStars(get_post_meta($poll->ID, 'scientific', true)) ?></td>
            <td sorttable_customkey="<?= stringToNums(get_post_meta($poll->ID, 'knowledge', true)) ?>"><?= stringToStars(get_post_meta($poll->ID, 'knowledge', true)) ?></td>
            <td sorttable_customkey="<?= stringToNums(get_post_meta($poll->ID, 'clinics', true)) ?>"><?= stringToStars(get_post_meta($poll->ID, 'clinics', true)) ?></td>
            <td sorttable_customkey="<?= stringToNums(get_post_meta($poll->ID, 'duration', true)) ?>"><?= stringToStars(get_post_meta($poll->ID, 'duration', true)) ?></td>
            <td sorttable_customkey="<?= stringToNums(get_post_meta($poll->ID, 'materials', true)) ?>"><?= stringToStars(get_post_meta($poll->ID, 'materials', true)) ?></td>
            <td sorttable_customkey="<?= stringToNums(get_post_meta($poll->ID, 'organization', true)) ?>"><?= stringToStars(get_post_meta($poll->ID, 'organization', true)) ?></td>
            <td sorttable_customkey="<?= stringToNums(get_post_meta($poll->ID, 'expectations', true)) ?>"><?= stringToStars(get_post_meta($poll->ID, 'expectations', true)) ?></td>
            <td sorttable_customkey="<?= stringToNumsThumbs(get_post_meta($poll->ID, 'recommend', true)) ?>" class="<?= get_post_meta($poll->ID, 'recommend', true) == 'no' ? 'highlight' : '' ?>"><?= stringToThumbs(get_post_meta($poll->ID, 'recommend', true)) ?></td>
            <td class="toggler">Ver respuestas ↓</td>
          </tr>
          <tr class="toggle-row">
            <td colspan="12">
              <p><em>1. ¿Qué es lo que destacaría de este curso?</em> <?= get_post_meta($poll->ID, 'highlight', true) ?></p>
              <p><em>2. ¿Qué cambiaría para ediciones posteriores?</em> <?= get_post_meta($poll->ID, 'change', true) ?></p>
              <p><em>3. ¿Qué tema ampliaría o trataría más en profundidad?</em> <?= get_post_meta($poll->ID, 'theme', true) ?></p>
              <p><em>4. ¿En qué otros cursos le podemos ayudar?</em> <?= get_post_meta($poll->ID, 'other', true) ?></p>
              <hr>
              <p>Comentarios y sugerencias:<br><?= get_post_meta($poll->ID, 'comments', true) ?></p>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
      <table id="datatable" class="hidden sortable">
        <tr>
          <th title="ID de usuario">ID</th>
          <th title="Nombre de usuario">Nombre</th>
          <th title="Estructura del curso">Estructura</th>
          <th title="Contenidos científicos">Científico</th>
          <th title="Aportación a mis conocimientos">Conocimiento</th>
          <th title="Utilidad en la práctica clínica">Clínica</th>
          <th title="Duración del curso">Duración</th>
          <th title="Utilidad del material de apoyo">Materiales</th>
          <th title="Entorno y organización">Organización</th>
          <th title="Expectativas satisfechas">Expectativas</th>
          <th title="¿Recomendaría esta actividad a un compañero?">Recomendaría</th>
          <th title="1. ¿Qué es lo que destacaría de este curso?">Destacaría</th>
          <th title="2. ¿Qué cambiaría para ediciones posteriores?">Cambiaría</th>
          <th title="3. ¿Qué tema ampliaría o trataría más en profundidad?">Ampliaría</th>
          <th title="4. ¿En qué otros cursos le podemos ayudar?">Otros</th>
          <th title="Comentarios y sugerencias">Comentarios</th>
          <th></th>
        </tr>
        <?php foreach ($polls as $poll) : ?>
          <tr>
            <td><?= get_post_meta($poll->ID, 'user_id', true) ?></td>
            <td><a href="<?= site_url() ?>/wp-admin/user-edit.php?user_id=<?= get_post_meta($poll->ID, 'user_id', true) ?>"><?= get_post_meta($poll->ID, 'user_name', true) ?></a></td>
            <td><?= stringToNums(get_post_meta($poll->ID, 'structure', true)) ?></td>
            <td><?= stringToNums(get_post_meta($poll->ID, 'scientific', true)) ?></td>
            <td><?= stringToNums(get_post_meta($poll->ID, 'knowledge', true)) ?></td>
            <td><?= stringToNums(get_post_meta($poll->ID, 'clinics', true)) ?></td>
            <td><?= stringToNums(get_post_meta($poll->ID, 'duration', true)) ?></td>
            <td><?= stringToNums(get_post_meta($poll->ID, 'materials', true)) ?></td>
            <td><?= stringToNums(get_post_meta($poll->ID, 'organization', true)) ?></td>
            <td><?= stringToNums(get_post_meta($poll->ID, 'expectations', true)) ?></td>
            <td class="<?= get_post_meta($poll->ID, 'recommend', true) == 'no' ? 'highlight' : '' ?>"><?= stringToNumsThumbs(get_post_meta($poll->ID, 'recommend', true)) ?></td>
            <td><?= get_post_meta($poll->ID, 'highlight', true) ?></td>
            <td><?= get_post_meta($poll->ID, 'change', true) ?></td>
            <td><?= get_post_meta($poll->ID, 'theme', true) ?></td>
            <td><?= get_post_meta($poll->ID, 'other', true) ?></td>
            <td><?= get_post_meta($poll->ID, 'comments', true) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
  </div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@2.1.0/dist/excellentexport.min.js"></script>
  <script>
    var elements = document.getElementsByClassName('toggler');
    Array.from(elements).forEach(function(element) {
      element.addEventListener('click', function() {
        this.parentElement.nextElementSibling.classList.toggle('visible');
        if (this.parentElement.nextElementSibling.classList.contains('visible'))
          this.textContent = 'Ocultar ↑';
        else {
          this.textContent = 'Ver respuestas ↓';
        }
      });
    });
    var elements2 = document.getElementsByClassName('toggle-row');
    Array.from(elements2).forEach(function(element) {
      element.addEventListener('click', function() {
        this.classList.remove('visible');
        this.previousElementSibling.getElementsByClassName('toggler')[0].textContent = 'Ver respuestas ↓';
      });
    });

    function pressTh(index) {
      sorttable.innerSortFunction.apply(document.getElementById('datatable').getElementsByTagName('th')[index], []);
      sorttable.innerSortFunction.apply(document.getElementById('datable').getElementsByTagName('th')[index], []);
      sorttable.innerSortFunction.apply(document.getElementById('datable').getElementsByTagName('th')[index], []);
    }
  </script>
<?php endif;
  }
  function stringToStars($stringNumber)
  {
    $multiplier = 0;
    switch ($stringNumber) {
      case 'one':
        $multiplier = 1;
        break;
      case 'two':
        $multiplier = 2;
        break;
      case 'three':
        $multiplier = 3;
        break;
      case 'four':
        $multiplier = 4;
        break;
      case 'five':
        $multiplier = 5;
        break;
      default:
        $multiplier = 0;
        break;
    }
    $starsLeft = 5 - $multiplier;
    return str_repeat('<img src="' . get_template_directory_uri() . '/static/img/svg/star.svg">', $multiplier) . '' . str_repeat('<img src="' . get_template_directory_uri() . '/static/img/svg/star2.svg">', $starsLeft);
  }
  function stringToNums($stringNumber)
  {
    switch ($stringNumber) {
      case 'one':
        return 1;
      case 'two':
        return 2;
      case 'three':
        return 3;
      case 'four':
        return 4;
      case 'five':
        return 5;
      default:
        return -1;
    }
  }
  function stringToThumbs($string)
  {
    switch ($string) {
      case 'yes':
        return '<img src="' . get_template_directory_uri() . '/static/img/svg/thumbs-up.svg">';
      case 'no':
        return '<img class="thumbs-down" src="' . get_template_directory_uri() . '/static/img/svg/thumbs-up.svg">';
      default:
        return;
    }
  }
  function stringToNumsThumbs($string)
  {
    switch ($string) {
      case 'yes':
        return 'Sí';
      case 'no':
        return 'No';
      default:
        return '-';
    }
  }
?>