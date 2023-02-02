<?php

add_action('rest_api_init', 'wp_rest_user_endpoints');
/**
 * Register a new user
 *
 * @param  WP_REST_Request $request Full details about the request.
 * @return array $args.
 **/

function wp_rest_user_endpoints($request)
{
  /**
   * Handle Register User request.
   */
  register_rest_route('wp/v2', 'users/register', array(
    'methods' => 'POST',
    'callback' => 'wc_rest_user_endpoint_handler',
    'permission_callback' => 'wrong_permission'
  ));
}

function wrong_permission()
{
  return 'Wrong permission user/register';
}

function cleanData($dataToClean)
{
  // remove dots, trim beginning and final spaces, lowercase all characters and uppercase firsts
  $dataToClean = ucwords(trim(str_replace('.', '', $dataToClean)));
  return $dataToClean;
}

function wc_rest_user_endpoint_handler($request = null)
{
  $response = array();
  $parameters = $request->get_json_params();

  $email = $parameters['email'];
  $password = $parameters['password'];
  $name = cleanData($parameters['name']);
  $first_lastname = cleanData($parameters['first_lastname']);
  $second_lastname = cleanData($parameters['second_lastname']);
  $gender = $parameters['gender'];
  $dni_nie = $parameters['dni_nie'];
  $phone = $parameters['phone'];
  $specialty = $parameters['specialty'];
  $medical_society = $parameters['medical_society'];
  $working_province = $parameters['working_province'];
  $collegiate_province = $parameters['collegiate_province'];
  $assigned_number = $parameters['assigned_number'];
  $legal = $parameters['legal'];
  $personal_data = $parameters['personal_data'];
  $poll_completed = $parameters['poll_completed'];

  $error = new WP_Error();

  if (empty($email)) {
    $error->add(400, __("'Email' field is required.", 'wp-rest-user'));
    return $error;
  }
  if (!is_email($email)) {
    $error->add(400, __("Email has invalid format.", 'wp-rest-user'));
    return $error;
  }
  if (empty($password)) {
    $error->add(400, __("Password field 'password' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($name)) {
    $error->add(400, __("'Name' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($first_lastname)) {
    $error->add(400, __("'First last name' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($second_lastname)) {
    $error->add(400, __("'Second last name' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($gender)) {
    $error->add(400, __("'Gender' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($dni_nie)) {
    $error->add(400, __("'DNI/NIE' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($phone)) {
    $error->add(400, __("'Phone' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($specialty)) {
    $error->add(400, __("'Specialty' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($working_province)) {
    $error->add(400, __("'Working province' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($working_province)) {
    $error->add(400, __("'Working province' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($collegiate_province)) {
    $error->add(400, __("'Collegiate province' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($assigned_number)) {
    $error->add(400, __("'Assigned number' is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($legal)) {
    $error->add(400, __("'Legal' is required.", 'wp-rest-user'));
    return $error;
  }
  if (intval($legal) !== 1) {
    $error->add(400, __("'Legal' must be accepted.", 'wp-rest-user'));
    return $error;
  }

  $username = cleanData($name . ' ' . $first_lastname . ' ' . $second_lastname);
  $user_id = username_exists($username);
  if (!$user_id && email_exists($email) == false) {
    $user_id = wp_create_user($username, $password, $email);
    if (!is_wp_error($user_id)) {
      // Get User Meta Data (Sensitive, Password included. DO NOT pass to front end.)
      $user = get_user_by('id', $user_id);
      $user->set_role('subscriber');

      // Register date
      date_default_timezone_set('Europe/Madrid');
      $register_date = date('d-m-Y H:i');
      update_field('register_date', $register_date, 'user_' . $user->id . '');

      update_field('name', $name, 'user_' . $user->id . '');
      update_field('first_lastname', $first_lastname, 'user_' . $user->id . '');
      update_field('second_lastname', $second_lastname, 'user_' . $user->id . '');
      update_field('gender', $gender, 'user_' . $user->id . '');
      update_field('dni_nie', $dni_nie, 'user_' . $user->id . '');
      update_field('phone', $phone, 'user_' . $user->id . '');
      update_field('specialty', $specialty, 'user_' . $user->id . '');
      if (!empty($medical_society)) {
        update_field('medical_society', $medical_society, 'user_' . $user->id . '');
      }
      update_field('working_province', $working_province, 'user_' . $user->id . '');
      update_field('collegiate_province', $collegiate_province, 'user_' . $user->id . '');
      update_field('assigned_number', $assigned_number, 'user_' . $user->id . '');
      update_field('legal', $legal, 'user_' . $user->id . '');
      if (!empty($personal_data)) {
        update_field('personal_data', $personal_data, 'user_' . $user->id . '');
      }
      update_field('poll_completed', $poll_completed, 'user_' . $user->id . '');
      update_field('first_access', date("Y-m-d H:i:s"), 'user_' . $user->id . '');
      update_field('first_ip_address', $_SERVER['REMOTE_ADDR'], 'user_' . $user->id . '');

      // Get User Data (Non-Sensitive, Pass to front end.)
      $response['code'] = 200;
      $response['message'] = __("User '" . $username . "' registered succesfully", "wp-rest-user");
      $response['data'] = "Created";
    } else {
      $response['code'] = 400;
      $response['message'] = __("Oops, '" . $username . "', something went wrong...", "wp-rest-user");
      $response['data'] = "Wrong";
      return $user_id;
    }
  } else {
    $error->add(400, __("Email already exists, please try 'Reset Password'", 'wp-rest-user'), "Exists");
    return $error;
  }
  return new WP_REST_Response($response, 123);
}


add_action('rest_api_init', 'wp_rest_exam_endpoints');
/**
 * Check answers in final test
 *
 * @param  WP_REST_Request $request Full details about the request.
 * @return array $args.
 **/

function wp_rest_exam_endpoints($request)
{
  /**
   * Handle Register User request.
   */
  register_rest_route('wp/v2', 'exam', array(
    'methods' => 'POST',
    'callback' => 'wc_rest_exam_endpoint_handler',
    'permission_callback' => 'wrong_permission_exam'
  ));
}

function wrong_permission_exam()
{
  return 'Wrong permission exam';
}

function wc_rest_exam_endpoint_handler($request = null)
{
  $response = array();
  $error = new WP_Error();
  $parameters = $request->get_json_params();

  $question01 = sanitize_text_field($parameters['question01']);
  $question02 = sanitize_text_field($parameters['question02']);
  $question03 = sanitize_text_field($parameters['question03']);
  $question04 = sanitize_text_field($parameters['question04']);
  $question05 = sanitize_text_field($parameters['question05']);

  if (empty($question01)) {
    $error->add(400, __("'Question 01' field is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($question02)) {
    $error->add(400, __("'Question 02' field is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($question03)) {
    $error->add(400, __("'Question 03' field is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($question04)) {
    $error->add(400, __("'Question 04' field is required.", 'wp-rest-user'));
    return $error;
  }
  if (empty($question05)) {
    $error->add(400, __("'Question 05' field is required.", 'wp-rest-user'));
    return $error;
  }

  $response['code'] = 200;
  $response['message'] = `Pregunta 1: ${$question01}\nPregunta 2: ${$question02}\nPregunta 3: ${$question03}\nPregunta 4: ${$question04}\nPregunta 5: ${$question05}`;
  $response['data'] = "";

  return new WP_REST_Response($response, 123);
}
