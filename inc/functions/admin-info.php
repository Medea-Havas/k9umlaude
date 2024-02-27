<?php

add_action('admin_menu', 'custom_menu');

function custom_menu()
{
  add_menu_page('Info usuarios', 'Info usuarios', 'manage_options', 'stats', 'show_admin_info', 'dashicons-media-spreadsheet', 45);
}

function show_admin_info()
{
  global $wpdb;
  $query = "SELECT MU.ID, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'name') AS name, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'first_lastname') AS first_lastname, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'second_lastname') AS second_lastname, user_email, user_registered, superado, progreso, creditos_obtenidos, nota FROM med_users MU LEFT JOIN usuarios_cursos UC ON MU.ID = UC.id_usuario ORDER BY display_name";
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
          <td><?= $item->name . ' ' . $item->first_lastname . ' ' . $item->second_lastname ?></td>
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
  add_menu_page('Info encuesta', 'Info encuesta', 'manage_options', 'pollstats', 'show_admin_info2', 'dashicons-media-spreadsheet', 46);
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

  add_action('admin_menu', 'custom_menu3');

  function custom_menu3()
  {
    add_menu_page('Info Sanofi', 'Info Sanofi', 'manage_options', 'report', 'show_admin_info3', 'dashicons-media-spreadsheet', 47);
  }

  function show_admin_info3()
  {
    $usersInfo = [];
    $users = get_users();
    for ($i = 0; $i < count($users); $i++) {
      $user = $users[$i];
      $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
      $formatter->setPattern('dd-MM-yyyy');
      $userArray = array(
        "source" => 'K9um laude',
        "onekey" => '',
        "collegiateProvince" => substr(str_replace(' - ', '-', $user->collegiate_province), 3),
        "collegiateNumber" => $user->assigned_number,
        "email" => $user->user_email,
        "consent" => $user->personal_data == 1 ? 'CONSENT' : 'NO CONSENT',
        "name" => $user->name,
        "lastName" => $user->first_lastname . ' ' . $user->second_lastname,
        "registered" => $formatter->format(new DateTime($user->user_registered)),
        "optOut" => '',
        "province" => substr(str_replace(' - ', '-', $user->working_province), 3),
        "gender" => $user->gender == 'Femenino' ? 'F' : ($user->gender == 'Masculino' ? 'M' : 'N/E'),
        "onekeySpecialty" => $user->specialty,
        "phoneConsent" => '',
        "phone" => $user->phone,
      );
      array_push($usersInfo, $userArray);
    }

    include_once('admin-inc/provinces.php');
    include_once('admin-inc/specialties.php');
?>
<div id="admin-info">
  <p id="alert">Texto copiado</p>
  <div class="users-header">
    <h1>Informe Sanofi</h1>
    <div class="download-files">
      <a title="Mandar email" href="javascript: void(0);" onclick="sendMail()"><img src="<?= get_template_directory_uri() ?>/static/img/email.png"></a>
      <a title="Copiar texto email" href="javascript: void(0);" onclick="copyText()"><img src="<?= get_template_directory_uri() ?>/static/img/copy.png"></a>
      <a title="Descargar XLS" download="Integracion_Leads_TEMPLATE NUEVO CURSO_1 de enero_2024_.xls" href="#" onclick="exportExcel(this)"><img src="<?= get_template_directory_uri() ?>/static/img/xls.png"></a>
      <a title="Descargar CSV" download="Integracion_Leads_TEMPLATE NUEVO CURSO_1 de enero_2024_.csv" href="#" onclick="exportCSV(this)"><img src="<?= get_template_directory_uri() ?>/static/img/csv.png"></a>
    </div>
  </div>
  <div class="filters">
    <div class="form-field">
      <input id="hasConsent" type="checkbox">
      <label for="hasConsent">Consentimiento</label>
    </div>
    <div class="form-field date">
      <label for="dateFrom">Desde:</label>
      <input id="dateFrom" type="date">
    </div>
    <div class="form-field date">
      <label for="dateTo">Hasta:</label>
      <input id="dateTo" type="date">
    </div>
  </div>
  <table id="sanofiTable" class="sortable" cellpadding="8px">
    <caption style="margin-bottom: 1rem;text-align: left;">DESCARGAR Y ENVIAR A <a href="mailto:webexternas@sanofi.com" target="_blank" style="color: black; text-decoration: none;">WEBEXTERNAS@SANOFI.COM</a></caption>
    <tr>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Fuente</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">OneKey</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Provincia<br>colegiación</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Nº Colegiado</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Email</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">CONSENT</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Nombre</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Apellidos</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Fecha reg. consent<br>web</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Fecha OPT-OUT</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Provincia</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Género</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Especialidad OneKey</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">EP com.<br>móvil</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Recogida<br>consentimiento<br>móvil</th>
      <th style="background-color: #ED7D31;color:white;font-size:9px;">Nº móvil</th>
    </tr>
    <?php
    $countNoConsent = 0;
    for ($i = 0; $i < count($usersInfo); $i++) {
      $user = $usersInfo[$i];
      if ($user['consent'] == 'NO CONSENT') {
        $countNoConsent += 1;
      }
    ?>
      <tr data-registered="<?= $user['registered'] != '' ? $user['registered'] : '' ?>" class="<?= $user['consent'] == 'NO CONSENT' ? 'invisible' : '' ?>">
        <td><?= $user['source'] ?></td>
        <td><?= $user['onekey'] ?></td>
        <td><?= $user['collegiateProvince'] ?></td>
        <td><?= $user['collegiateNumber'] ?></td>
        <td><?= $user['email'] ?></td>
        <td class="consent"><?= $user['consent'] ?></td>
        <td><?= $user['name'] ?></td>
        <td><?= $user['lastName'] ?></td>
        <td><?= $user['registered'] ?></td>
        <td><?= $user['optOut'] ?></td>
        <td><?= $user['province'] ?></td>
        <td><?= $user['gender'] ?></td>
        <td><?= $user['onekeySpecialty'] ?></td>
        <td><?= $user['phone'] ?></td>
        <td><?= $user['phoneConsent'] ?></td>
        <td><?= $user['phone'] ?></td>
      </tr>
    <?php }
    ?>
  </table>
  <div class="hidden">
    <table id="datatable3"></table>
  </div>
  <div id="data">
    <div id="textToCopy">
      <p>Hola a todas,</p>
      <p>Compartimos la plantilla de integración de la BBDD con los inscritos al curso k9umlaude de la nueva edición. A los datos del Excel del curso nuevo habría que añadir <span class="noConsentCount"><?= $countNoConsent ?></span> usuarios que son NO CONSENT.</p>
      <p>La contraseña para acceder al Excel se enviará en otro email.</p>
      <p>Cualquier cuestión o duda, nos podéis consultar sin problema.</p>
      <p>Muchisimas gracias,</p>
      <p>Saludos!</p>
    </div>
    <p id="clickMessage">Haz click en la caja para copiar el contenido</p>
  </div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@2.1.0/dist/excellentexport.min.js"></script>
  <?php
    include_once('admin-inc/chartjs.php');
    include_once('admin-inc/chartjs-datalabels.php');
  ?>
  <?php include_once('admin-inc/sanofi-info.php'); ?>
  <div id="graphs">
    <canvas id="usersBySpecialty"></canvas>
    <canvas id="usersByProvince"></canvas>
    <canvas id="usersByGender"></canvas>
  </div>
</div>
<?php }

  add_action('admin_menu', 'custom_menu4');

  function custom_menu4()
  {
    add_menu_page('Info registros', 'Info registros', 'manage_options', 'registers', 'show_admin_info4', 'dashicons-media-spreadsheet', 48);
  }

  function show_admin_info4()
  {
    $usersInfo = [];
    $users = get_users();
    $course = array(
      "description" => get_post_meta(90, 'description')[0],
      "credits" => get_post_meta(90, 'credits')[0],
      "recordNo" => get_post_meta(90, 'record_num')[0],
      "certificateNo" => get_post_meta(90, 'certificate_num')[0],
    );

    $monthsArray = array(
      (object) [
        'month' => '202301',
        'users' => 0,
        'name' => 'enero',
        'passed' => 0
      ],
      (object) [
        'month' => '202302',
        'users' => 0,
        'name' => 'febrero',
        'passed' => 0
      ],
      (object) [
        'month' => '202303',
        'users' => 0,
        'name' => 'marzo',
        'passed' => 0
      ],
      (object) [
        'month' => '202304',
        'users' => 0,
        'name' => 'abril',
        'passed' => 0
      ],
      (object) [
        'month' => '202305',
        'users' => 0,
        'name' => 'mayo',
        'passed' => 0
      ],
      (object) [
        'month' => '202306',
        'users' => 0,
        'name' => 'junio',
        'passed' => 0
      ],
      (object) [
        'month' => '202307',
        'users' => 0,
        'name' => 'julio',
        'passed' => 0
      ],
      (object) [
        'month' => '202308',
        'users' => 0,
        'name' => 'agosto',
        'passed' => 0
      ],
      (object) [
        'month' => '202309',
        'users' => 0,
        'name' => 'septiembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202310',
        'users' => 0,
        'name' => 'octubre',
        'passed' => 0
      ],
      (object) [
        'month' => '202311',
        'users' => 0,
        'name' => 'noviembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202312',
        'users' => 0,
        'name' => 'diciembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202401',
        'users' => 0,
        'name' => 'enero',
        'passed' => 0
      ],
      (object) [
        'month' => '202402',
        'users' => 0,
        'name' => 'febrero',
        'passed' => 0
      ],
      (object) [
        'month' => '202403',
        'users' => 0,
        'name' => 'marzo',
        'passed' => 0
      ],
      (object) [
        'month' => '202404',
        'users' => 0,
        'name' => 'abril',
        'passed' => 0
      ],
      (object) [
        'month' => '202405',
        'users' => 0,
        'name' => 'mayo',
        'passed' => 0
      ],
      (object) [
        'month' => '202406',
        'users' => 0,
        'name' => 'junio',
        'passed' => 0
      ],
      (object) [
        'month' => '202407',
        'users' => 0,
        'name' => 'julio',
        'passed' => 0
      ],
      (object) [
        'month' => '202408',
        'users' => 0,
        'name' => 'agosto',
        'passed' => 0
      ],
      (object) [
        'month' => '202409',
        'users' => 0,
        'name' => 'septiembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202410',
        'users' => 0,
        'name' => 'octubre',
        'passed' => 0
      ],
      (object) [
        'month' => '202411',
        'users' => 0,
        'name' => 'noviembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202412',
        'users' => 0,
        'name' => 'diciembre',
        'passed' => 0
      ]
    );

    for ($i = 0; $i < count($users); $i++) {
      $user = $users[$i];
      $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
      $formatter->setPattern('dd-MM-yyyy hh:ss');

      global $wpdb;
      $query = "SELECT id, id_usuario, id_curso, superado, progreso, creditos_obtenidos, nota FROM usuarios_cursos WHERE id_usuario = " . $user->ID . " AND id_curso = 90";
      $result = $wpdb->get_results($query) ? $wpdb->get_results($query)[0] : '';

      for ($j = 0; $j < count($monthsArray); $j++) {
        $registerDate = $formatter->format(new DateTime($user->register_date));
        if (isset($registerDate[0])) {
          if ($monthsArray[$j]->month == $registerDate[6] . $registerDate[7] . $registerDate[8] . $registerDate[9] . $registerDate[3] . $registerDate[4]) {
            $monthsArray[$j]->users += 1;
            break;
          }
        }
      }

      $userArray = array(
        "id" => $result !== '' ? $result->id : '-',
        "userId" => $result !== '' ? $result->id_usuario : '-',
        "courseId" => $result !== '' ? $result->id_curso : '-',
        "passed" => $result !== '' ? $formatter->format(new DateTime($result->superado)) : '-',
        "progress" => $result !== '' ? $result->progreso . '%' : '-',
        "courseCredits" => $result !== '' ? $result->creditos_obtenidos : '-',
        "grade" => $result !== '' ? $result->nota . '%' : '-',
        "idUser" => $user->ID,
        "name" => get_user_meta($user->ID, 'name') ? get_user_meta($user->ID, 'name')[0] : '-',
        "firstLastname" => get_user_meta($user->ID, 'first_lastname') ? get_user_meta($user->ID, 'first_lastname')[0] : '-',
        "secondLastname" => get_user_meta($user->ID, 'second_lastname') ? get_user_meta($user->ID, 'second_lastname')[0] : '-',
        "gender" => $user->gender,
        "nif" => $user->dni_nie,
        "mobile" => $user->phone,
        "specialty" => $user->specialty,
        "society" => $user->medical_society,
        "collegiateProvince" => substr(str_replace(' - ', '-', $user->collegiate_province), 3),
        "workingProvince" => substr(str_replace(' - ', '-', $user->working_province), 3),
        "collegiateNumber" => $user->assigned_number,
        "legal" => $user->legal,
        "personal" => $user->personal_data,
        "registered" => $formatter->format(new DateTime($user->register_date)),
        "poll" => $user->poll_completed,
        "firstAccess" => $user->first_access,
        "lastAccess" => $user->last_access,
        "firstIPAddress" => $user->first_ip_address,
        "lastIPAddress" => $user->last_ip_address,
      );
      array_push($usersInfo, $userArray);
    } ?>
  <?php
    include_once('admin-inc/chartjs.php');
    include_once('admin-inc/chartjs-datalabels.php'); ?>
  <?php
    // var_dump(json_encode($monthsArray, JSON_PRETTY_PRINT));
    // global $wpdb;
    // $query = "SELECT MU.ID, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'name') AS name, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'first_lastname') AS first_lastname, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'second_lastname') AS second_lastname, user_email, user_registered, superado, progreso, creditos_obtenidos, nota FROM med_users MU LEFT JOIN usuarios_cursos UC ON MU.ID = UC.id_usuario ORDER BY display_name";
    // $list = $wpdb->get_results($query);
  ?>
  <?php include_once('admin-inc/provinces.php'); ?>
  <div id="admin-info">
    <p id="alert">Texto copiado</p>
    <div class="users-header">
      <h1>Información de registros bimensual</h1>
      <div class="download-files">
        <a title="Mandar email" href="javascript: void(0);" onclick="sendMail()"><img src="<?= get_template_directory_uri() ?>/static/img/email.png"></a>
        <a title="Copiar texto email" href="javascript: void(0);" onclick="copyText()"><img src="<?= get_template_directory_uri() ?>/static/img/copy.png"></a>
        <a title="Descargar XLS" download="registros_k9um.xls" href="#" onclick="downloadExcel(this)"><img src="<?= get_template_directory_uri() ?>/static/img/xls.png"></a>
        <a title="Descargar CSV" download="registros_k9um.csv" href="#" onclick="downloadCSV(this)"><img src="<?= get_template_directory_uri() ?>/static/img/csv.png"></a>
      </div>
    </div>
    <div class="filters">
      <div class="form-field date">
        <label for="dateFrom">Desde:</label>
        <input id="dateFrom" type="date">
      </div>
      <div class="form-field date">
        <label for="dateTo">Hasta:</label>
        <input id="dateTo" type="date">
      </div>
    </div>
    <table id="registerTable" class="sortable">
      <caption>
        <b>K9UM LAUDE</b><br>
        <b>Descripción:</b> <?= $course['description'] ?><br>
        <b>Créditos:</b> <?= $course['credits'] ?>&Tab;/&Tab;
        <b>Nº expediente:</b> <?= $course['recordNo'] ?>&Tab;/&Tab;
        <b>Nº certificado:</b> <?= $course['certificateNo'] ?>
      </caption>
      <tr>
        <th>Nombre</th>
        <th>Apellido 1</th>
        <th>Apellido 2</th>
        <th>Género</th>
        <th>NIF/NIE</th>
        <th>Tlf. móvil</th>
        <th>Especialidad</th>
        <th>Sociedad médica</th>
        <th>Provincia colegió</th>
        <th>Provincia trabaja</th>
        <th>Nº correlativo</th>
        <th>Aviso legal</th>
        <th>Datos personales</th>
        <th>Fecha registro</th>
        <th>Encuesta enviada</th>
        <th>1er acceso</th>
        <th>Últ. acceso</th>
        <th>Primera IP</th>
        <th>Últ. IP</th>
        <th title="Id usuario-curso">Id</th>
        <th>Id usuario</th>
        <th>Id curso</th>
        <th>Nº certificado</th>
        <th>Superado</th>
        <th>Progreso</th>
        <th>Créditos</th>
        <th>Nota</th>
      </tr>
      <?php
      setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'Spanish');
      $nmeng = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
      $nmsp = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

      $passed = 0;
      $registered = 0;
      $registeredTwoMonthsAgo = 0;
      $twoMonthsAgo = date("d-m-Y", strtotime("-2 months"));
      $twoMonthsAgoLong = str_ireplace($nmeng, $nmsp, date("d \d\\e F \d\\e Y", strtotime("-2 months")));
      ?>
      <?php for ($j = 0; $j < count($usersInfo); $j++) {
        $userInfo = $usersInfo[$j];
        if (isset($userInfo['passed']) && $userInfo['passed'] != '-') {
          for ($k = 0; $k < count($monthsArray); $k++) {
            $passed = $userInfo['passed'][6] . $userInfo['passed'][7] . $userInfo['passed'][8] . $userInfo['passed'][9] . $userInfo['passed'][3] . $userInfo['passed'][4];
            if ($passed == $monthsArray[$k]->month) {
              $monthsArray[$k]->passed += 1;
              break;
            }
          }
        }
        $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
        $formatter->setPattern('dd-MM-yyyy');
        if ($userInfo['passed'] != '-') {
          $passed += 1;
        }
        $date1 = new DateTime($userInfo['registered']);
        $date2 = new DateTime($twoMonthsAgo);
        if ($date1 > $date2) {
          $registeredTwoMonthsAgo += 1;
        }

        $registered += 1;
      ?>
        <tr data-registered="<?= $userInfo['registered'] ?>">
          <td><?= $userInfo['name'] ? $userInfo['name'] : '-' ?></td>
          <td><?= $userInfo['firstLastname'] ? $userInfo['firstLastname'] : '-' ?></td>
          <td><?= $userInfo['secondLastname'] ? $userInfo['secondLastname'] : '-' ?></td>
          <td><?= $userInfo['gender'] ? $userInfo['gender'] : '-' ?></td>
          <td><?= $userInfo['nif'] ? $userInfo['nif'] : '-' ?></td>
          <td><?= $userInfo['mobile'] ? $userInfo['mobile'] : '-' ?></td>
          <td><?= $userInfo['specialty'] ? $userInfo['specialty'] : '-' ?></td>
          <td><?= $userInfo['society'] ? $userInfo['society'] : '-' ?></td>
          <td><?= $userInfo['collegiateProvince'] ? $userInfo['collegiateProvince'] : '-' ?></td>
          <td><?= $userInfo['workingProvince'] ? $userInfo['workingProvince'] : '-' ?></td>
          <td><?= $userInfo['collegiateNumber'] ? $userInfo['collegiateNumber'] : '-' ?></td>
          <td><?= $userInfo['legal'] ? $userInfo['legal'] : '-' ?></td>
          <td><?= $userInfo['personal'] ? $userInfo['personal'] : '-' ?></td>
          <td sorttable_customkey="<?= strtotime($userInfo['registered']) ?>"><?= $userInfo['registered'] ?></td>
          <td><?= $userInfo['poll'] ? $userInfo['poll'] : '-' ?></td>
          <td><?= $userInfo['firstAccess'] ? $userInfo['firstAccess'] : '-' ?></td>
          <td><?= $userInfo['lastAccess'] ? $userInfo['lastAccess'] : '-' ?></td>
          <td><?= $userInfo['firstIPAddress'] ? $userInfo['firstIPAddress'] : '-' ?></td>
          <td><?= $userInfo['lastIPAddress'] ? $userInfo['lastIPAddress'] : '-' ?></td>
          <td><?= $userInfo['id'] ?></td>
          <td><?= $userInfo['userId'] ?></td>
          <td><?= $userInfo['courseId'] ?></td>
          <td><?= $course['certificateNo'] ?>-<?= $userInfo['idUser'] ?></td>
          <td><?= $userInfo['passed'] ?></td>
          <td><?= $userInfo['progress'] ?></td>
          <td><?= $userInfo['courseCredits'] ?></td>
          <td><?= $userInfo['grade'] ?></td>
        </tr>
      <?php } ?>
    </table>
    <script>
      var monthsData = <?php echo json_encode($monthsArray, JSON_PRETTY_PRINT); ?>;
    </script>
    <div id="data">
      <div id="textToCopy">
        <p>Hola a todas,</p>
        <p>Compartimos el pdf con los datos del curso <a href="https://k9umlaude.es" target="_blank">https://k9umlaude.es</a> de la nueva edición.</p>
        <!-- <p>Han aprobado <?= $passed ?> personas.<br>Número de inscritos: <?= $registered ?><br>Inscritos desde el <?= $twoMonthsAgoLong ?>: <?= $registeredTwoMonthsAgo ?> (de los cuales, <?= $registeredTwoMonthsAgo ?> inscritos únicos).</p> -->
        <p>Cualquier cuestión o duda, nos podéis consultar sin problema.</p>
        <p>Muchísimas gracias,</p>
        <p>Saludos!</p>
      </div>
      <p id="clickMessage">Haz click en la caja para copiar el contenido</p>
    </div>
    <table id="datatable4" class="hidden"></table>
  </div>
  <div id="graphs">
    <canvas id="usersByMonth"></canvas>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@2.1.0/dist/excellentexport.min.js"></script>
  <?php
    include_once('admin-inc/bimensual-info.php'); ?>

  <script>
    let textToCopy2 = document.getElementById('textToCopy');
    const options2 = {
      year: 'numeric',
      month: 'numeric',
      day: 'numeric',
    };
    const today2 = new Date().toLocaleDateString("es-ES", options2);

    function monthDiff(d1, d2) {
      var months;
      months = (d2.getFullYear() - d1.getFullYear()) * 12;
      months -= d1.getMonth();
      months += d2.getMonth();
      return months <= 0 ? 0 : months;
    }

    document.getElementById('dateFrom').addEventListener('change', function(e) {
      resetVisibility();
      checkRows();
    });
    document.getElementById('dateTo').addEventListener('change', function(e) {
      resetVisibility();
      checkRows();
    });
    document.getElementById('data').addEventListener('click', function(e) {
      copyText();
    });
    var rows = document.querySelectorAll('#registerTable th');
    for (var i = 0; i < rows.length; i++) {
      rows[i].addEventListener('click', function(e) {
        setTimeout(() => {
          // document.getElementById('datatable4').innerHTML = document.getElementById('registerTable').innerHTML;
          removeElementsByClass('off');
        }, 1500);
      });
    }

    function checkRows() {
      let rows = document.querySelectorAll("#registerTable tbody tr");
      let dFrom = document.getElementById('dateFrom').value;
      let dTo = document.getElementById('dateTo').value;

      for (var i = 0; i < rows.length; i++) {
        let reg = rows[i].dataset.registered;
        // From date
        if (dFrom !== null) {
          var fromDate = new Date(dFrom);
          fromDate.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: "2-digit",
            day: "2-digit"
          });
          var fromDateFormat = `${fromDate.getDate()}-${fromDate.getMonth() + 1}-${fromDate.getUTCFullYear()}`;
          var fromDateTime = fromDate.getTime();
        }
        // To date
        if (dTo !== null) {
          var toDate = new Date(dTo);
          toDate.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: "2-digit",
            day: "2-digit"
          });
          var toDateFormat = `${toDate.getDate()}-${toDate.getMonth() + 1}-${toDate.getUTCFullYear()}`;
          var toDateTime = toDate.getTime();
        }
        // Registered date
        var regDateArray = reg.split('-');
        var year = regDateArray[2].split(' ');
        var regDate = new Date(year[0], regDateArray[1] - 1, regDateArray[0]);
        var regDateTime = regDate.getTime();

        // From - null / To - value
        if (!dFrom && dTo) {
          if (regDateTime > toDateTime) {
            rows[i].classList.add('pokeepsy');
          } else {
            rows[i].classList.remove('pokeepsy');
          }
        }
        // From - value / To - value
        if (dFrom && dTo) {
          if (regDateTime < fromDateTime || regDateTime > toDateTime) {
            rows[i].classList.add('pokeepsy');
          } else {
            rows[i].classList.remove('pokeepsy');
          }
        }
        // From - value / To - null
        if (dFrom && !dTo) {
          if (regDateTime < fromDateTime) {
            rows[i].classList.add('pokeepsy');
          } else {
            rows[i].classList.remove('pokeepsy');
          }
        }
        toggleVisibility('pokeepsy', true);
      }
    }

    function copyText() {
      textToCopy2 = document.getElementById('textToCopy');
      navigator.clipboard.writeText(textToCopy2.innerText);
      document.getElementById('alert').style.top = '4rem';
      setTimeout(() => {
        document.getElementById('alert').style.top = '-100%';
      }, 3000);
    }

    function downloadCSV(dis) {
      document.getElementById('datatable4').innerHTML = document.getElementById('registerTable').innerHTML;
      removeElementsByClass('off');
      return ExcellentExport.csv(dis, 'datatable4');
    }

    function downloadExcel(dis) {
      document.getElementById('datatable4').innerHTML = document.getElementById('registerTable').innerHTML;
      removeElementsByClass('off');
      return ExcellentExport.excel(dis, 'datatable4');
    }

    function removeElementsByClass(className) {
      const elements = document.getElementById('datatable4').getElementsByClassName(className);
      while (elements.length > 0) {
        elements[0].parentNode.removeChild(elements[0]);
      }
    }

    function sendMail() {
      copyText();
      window.open('mailto:adrilg85@gmail.com?subject=Usuarios inscritos ' + today2 + '&body=' + encodeURIComponent(textToCopy2.innerText));
    }

    function toggleVisibility(className, checked) {
      const elements = document.getElementsByClassName(className);
      for (var u = 0; u < elements.length; u++) {
        if (checked) {
          elements[u].classList.add('off');
        } else {
          elements[u].classList.remove('off');
        }
      }
      // document.getElementById('datatable4').innerHTML = document.getElementById('registerTable').innerHTML;
      removeElementsByClass('off');
    }

    function resetVisibility() {
      const elements = document.querySelectorAll('#registerTable tr');
      for (var u = 0; u < elements.length; u++) {
        elements[u].classList.remove('off');
        elements[u].classList.remove('pokeepsy');
      }
    }
  </script>
<?php }
  add_action('admin_menu', 'custom_menu5');
  function custom_menu5()
  {
    add_menu_page('Informe gráficas', 'Info gráficas', 'manage_options', 'graphicstats', 'show_admin_info5', 'dashicons-chart-bar', 48);
  }
  function show_admin_info5()
  { ?>
  <div id="admin-info">
    <p id="alert">Texto copiado</p>
    <div class="graphs-header">
      <h1>Informe Sanofi gráficas</h1>
      <div>

        <a class="btnPDF" title="Copiar texto" href="javascript:void(0)" onclick="copyText()" style="background-image: url('<?= get_template_directory_uri() ?>/static/img/copy.png ?>');"></a>
        <a class="btnPDF" title="Descargar PDF" href="javascript:void(0)" onclick="generatePDF()" style="background-image: url('<?= get_template_directory_uri() ?>/static/img/pdf.png ?>');"></a>
      </div>
    </div>
    <div id="graphs">
      <canvas id="usersBySpecialty"></canvas>
      <canvas id="usersByProvince"></canvas>
      <canvas id="usersByGender"></canvas>
      <canvas id="usersByMonth"></canvas>
    </div>
    <div id="data">
      <div id="textToCopy">
        <p>Hola a todas,</p>
        <p>Compartimos el pdf con los datos del curso k9umlaude de la nueva edición.</p>
        <p>Cualquier cuestión o duda, nos podéis consultar sin problema.</p>
        <p>Muchisimas gracias,</p>
        <p>Saludos!</p>
      </div>
      <p id="clickMessage">Haz click en la caja para copiar el contenido</p>
    </div>
  </div>
  <?php
    $users = get_users();
    $monthsArray = array(
      (object) [
        'month' => '202301',
        'users' => 0,
        'name' => 'enero',
        'passed' => 0
      ],
      (object) [
        'month' => '202302',
        'users' => 0,
        'name' => 'febrero',
        'passed' => 0
      ],
      (object) [
        'month' => '202303',
        'users' => 0,
        'name' => 'marzo',
        'passed' => 0
      ],
      (object) [
        'month' => '202304',
        'users' => 0,
        'name' => 'abril',
        'passed' => 0
      ],
      (object) [
        'month' => '202305',
        'users' => 0,
        'name' => 'mayo',
        'passed' => 0
      ],
      (object) [
        'month' => '202306',
        'users' => 0,
        'name' => 'junio',
        'passed' => 0
      ],
      (object) [
        'month' => '202307',
        'users' => 0,
        'name' => 'julio',
        'passed' => 0
      ],
      (object) [
        'month' => '202308',
        'users' => 0,
        'name' => 'agosto',
        'passed' => 0
      ],
      (object) [
        'month' => '202309',
        'users' => 0,
        'name' => 'septiembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202310',
        'users' => 0,
        'name' => 'octubre',
        'passed' => 0
      ],
      (object) [
        'month' => '202311',
        'users' => 0,
        'name' => 'noviembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202312',
        'users' => 0,
        'name' => 'diciembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202401',
        'users' => 0,
        'name' => 'enero',
        'passed' => 0
      ],
      (object) [
        'month' => '202402',
        'users' => 0,
        'name' => 'febrero',
        'passed' => 0
      ],
      (object) [
        'month' => '202403',
        'users' => 0,
        'name' => 'marzo',
        'passed' => 0
      ],
      (object) [
        'month' => '202404',
        'users' => 0,
        'name' => 'abril',
        'passed' => 0
      ],
      (object) [
        'month' => '202405',
        'users' => 0,
        'name' => 'mayo',
        'passed' => 0
      ],
      (object) [
        'month' => '202406',
        'users' => 0,
        'name' => 'junio',
        'passed' => 0
      ],
      (object) [
        'month' => '202407',
        'users' => 0,
        'name' => 'julio',
        'passed' => 0
      ],
      (object) [
        'month' => '202408',
        'users' => 0,
        'name' => 'agosto',
        'passed' => 0
      ],
      (object) [
        'month' => '202409',
        'users' => 0,
        'name' => 'septiembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202410',
        'users' => 0,
        'name' => 'octubre',
        'passed' => 0
      ],
      (object) [
        'month' => '202411',
        'users' => 0,
        'name' => 'noviembre',
        'passed' => 0
      ],
      (object) [
        'month' => '202412',
        'users' => 0,
        'name' => 'diciembre',
        'passed' => 0
      ]
    ); ?>

  <?php
    include_once('admin-inc/chartjs.php');
    include_once('admin-inc/chartjs-datalabels.php');
    include_once('admin-inc/provinces.php');
    include_once('admin-inc/specialties.php');
  ?>

  <script>
    var specialtiesData = [];
    var gendersData = [];
    var provincesData = [];
    var passedData = [];
  </script>
  <?php
    for ($i = 0; $i < count($users); $i++) {
      $user = $users[$i];
      $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
      $formatter->setPattern('dd-MM-yyyy');

      global $wpdb;
      $query = "SELECT id, id_usuario, id_curso, superado, progreso, creditos_obtenidos, nota FROM usuarios_cursos WHERE id_usuario = " . $user->ID . " AND id_curso = 90";
      $result = $wpdb->get_results($query) ? $wpdb->get_results($query)[0] : 'WWW';
      for ($j = 0; $j < count($monthsArray); $j++) {
        $registerDate = $formatter->format(new DateTime($user->register_date));
        if (isset($registerDate[0])) {
          if ($monthsArray[$j]->month == $registerDate[6] . $registerDate[7] . $registerDate[8] . $registerDate[9] . $registerDate[3] . $registerDate[4]) {
            $monthsArray[$j]->users += 1;
          }
        }
        $passedDate = isset($result) && isset($result->superado) ? $formatter->format(new DateTime($result->superado)) : '';
        if (isset($passedDate[0])) {
          if ($monthsArray[$j]->month == $passedDate[6] . $passedDate[7] . $passedDate[8] . $passedDate[9] . $passedDate[3] . $passedDate[4]) {
            $monthsArray[$j]->passed += 1;
            break;
          }
        }
      }
  ?>
    <script>
      var monthsData = <?php echo json_encode($monthsArray, JSON_PRETTY_PRINT); ?>;
    </script>
    <?php if (isset($user->specialty)) {
    ?>
      <script>
        specialtiesData.push('<?= $user->specialty ?>');
        provincesData.push('<?= substr(str_replace(' - ', '-', $user->working_province), 3) ?>');
        gendersData.push('<?= $user->gender ?>');
      </script>
    <?php
      }

    ?>
<?php
    }
    include_once('admin-inc/charts.php');
  }
?>