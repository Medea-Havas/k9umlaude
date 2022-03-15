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
  ));
}

function wc_rest_user_endpoint_handler($request = null)
{
  $response = array();
  $parameters = $request->get_json_params();

  $email = sanitize_text_field($parameters['email']);
  $password = sanitize_text_field($parameters['password']);
  $name = sanitize_text_field($parameters['name']);
  $first_lastname = sanitize_text_field($parameters['first_lastname']);
  $second_lastname = sanitize_text_field($parameters['second_lastname']);
  $gender = sanitize_text_field($parameters['gender']);
  $dni_nie = sanitize_text_field($parameters['dni_nie']);
  $phone = sanitize_text_field($parameters['phone']);
  $specialty = sanitize_text_field($parameters['specialty']);
  $medical_society = sanitize_text_field($parameters['medical_society']);
  $working_province = sanitize_text_field($parameters['working_province']);
  $collegiate_province = sanitize_text_field($parameters['collegiate_province']);
  $assigned_number = sanitize_text_field($parameters['assigned_number']);
  $legal = sanitize_text_field($parameters['legal']);
  $personal_data = sanitize_text_field($parameters['personal_data']);

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

  $username = $name . ' ' . $first_lastname . ' ' . $second_lastname;
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
