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
        "lastName" => $user->last_name,
        "registered" => $formatter->format(new DateTime($user->user_registered)),
        "optOut" => '',
        "province" => substr(str_replace(' - ', '-', $user->working_province), 3),
        "gender" => $user->gender == 'Femenino' ? 'F' : ($user->gender == 'Masculino' ? 'F' : 'N/E'),
        "onekeySpecialty" => $user->specialty,
        "phoneConsent" => '',
        "phone" => $user->phone,
      );
      array_push($usersInfo, $userArray);
    }

?>
<div id="admin-info">
  <div class="users-header">
    <h1>Informe Sanofi</h1>
    <div class="download-files">
      <a title="Descargar XLS" download="informe_sanofi.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatable3', 'Informe K9umlaude');"><img src="<?= get_template_directory_uri() ?>/static/img/xls.png"></a>
      <a title="Descargar CSV" download="informe_sanofi.csv" href="#" onclick="return ExcellentExport.csv(this, 'datatable3');"><img src="<?= get_template_directory_uri() ?>/static/img/csv.png"></a>
    </div>
  </div>
  <div class="filters">
    <div class="form-field">
      <input id="hasConsent" type="checkbox">
      <label for="hasConsent">Consentimiento</label>
    </div>
  </div>
  <table id="sanofiTable" class="sortable" cellpadding="8px">
    <tr>
      <td align="left" colspan="16" style="color: black; font-size: 16px;font-weight:bold;text-transform:uppercase;">DESCARGAR Y ENVIAR A <a href="mailto:webexternas@sanofi.com" target="_blank" style="color: black; text-decoration: none;">WEBEXTERNAS@SANOFI.COM</a></td>
    </tr>
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
    <?php for ($i = 0; $i < count($usersInfo); $i++) { ?>
      <?php $user = $usersInfo[$i] ?>
      <tr class="<?= $user['consent'] == 'NO CONSENT' ? 'invisible' : '' ?>">
        <td><?= $user['source'] ?></td>
        <td><?= $user['onekey'] ?></td>
        <td><?= $user['collegiateProvince'] ?></td>
        <td><?= $user['collegiateNumber'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['consent'] ?></td>
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
    <?php } ?>
  </table>
  <div class="hidden">
    <table id="datatable3"></table>
  </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@2.1.0/dist/excellentexport.min.js"></script>
<script>
  document.getElementById('hasConsent').addEventListener('change', function(e) {
    var isChecked = document.getElementById('hasConsent').checked;
    toggleVisibility('invisible', isChecked);

    function toggleVisibility(className, checked) {
      const elements = document.getElementsByClassName(className);
      for (var u = 0; u < elements.length; u++) {
        if (checked) {
          elements[u].classList.add('off');
        } else {
          elements[u].classList.remove('off');
        }
      }
      document.getElementById('datatable3').innerHTML = document.getElementById('sanofiTable').innerHTML;
      removeElementsByClass('off');
    }

    function removeElementsByClass(className) {
      const elements = document.getElementById('datatable3').getElementsByClassName(className);
      while (elements.length > 0) {
        elements[0].parentNode.removeChild(elements[0]);
      }
    }
  });
</script>
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
    for ($i = 0; $i < count($users); $i++) {
      $user = $users[$i];
      $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
      $formatter->setPattern('dd-MM-yyyy hh:ss');
      $userArray = array(
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
    }
    // global $wpdb;
    // $query = "SELECT MU.ID, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'name') AS name, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'first_lastname') AS first_lastname, (SELECT meta_value FROM med_usermeta WHERE user_id = MU.ID AND meta_key = 'second_lastname') AS second_lastname, user_email, user_registered, superado, progreso, creditos_obtenidos, nota FROM med_users MU LEFT JOIN usuarios_cursos UC ON MU.ID = UC.id_usuario ORDER BY display_name";
    // $list = $wpdb->get_results($query);
?>
  <div id="admin-info">
    <div class="users-header">
      <h1>Información de registros bimensual</h1>
      <div class="download-files">
        <a title="Descargar XLS" download="registros_k9um.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatable4', 'Información de registros K9umlaude');"><img src="<?= get_template_directory_uri() ?>/static/img/xls.png"></a>
        <a title="Descargar CSV" download="registros_k9um.csv" href="#" onclick="return ExcellentExport.csv(this, 'datatable4');"><img src="<?= get_template_directory_uri() ?>/static/img/csv.png"></a>
      </div>
    </div>
    <table id="datatable4" class="sortable">
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
      </tr>
      <?php for ($j = 0; $j < count($usersInfo); $j++) {
        $userInfo = $usersInfo[$j];
        $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
        $formatter->setPattern('dd-MM-yyyy'); ?>
        <tr>
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

        </tr>
      <?php } ?>
    </table>
  </div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@2.1.0/dist/excellentexport.min.js"></script>
<?php }
?>