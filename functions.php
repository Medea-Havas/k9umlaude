<?php

//------- STYLES AND SCRIPTS -------
function k9umlaude_scripts()
{
  // CSS
  /* Use in Production */
  //wp_enqueue_style('k9umlaude-main-style', get_stylesheet_directory_uri() . '/assets/css/styles.min.css');
  wp_enqueue_style('k9umlaude-main-style', get_stylesheet_directory_uri() . '/assets/css/styles.css');
  // GOOGLE FONTS
  wp_enqueue_style('k9umlaude-google-fonts', 'https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap', false);
  // JS
  wp_dequeue_script('jquery');
  wp_enqueue_script('jquery', false, array(), false, true);
  wp_register_script('k9umlaude-vendor-script', get_stylesheet_directory_uri() . '/assets/js/vendor.min.js');
  wp_enqueue_script('k9umlaude-vendor-script', array('jquery'), '1.0', true, true);
  /* Use in Production */
  //wp_register_script('k9umlaude-main-script', get_stylesheet_directory_uri() . '/assets/js/main.min.js');
  wp_register_script('k9umlaude-main-script', get_stylesheet_directory_uri() . '/assets/js/main.js');
  /* Path available to JS */
  $translation_array = array(
    'stylesheetUrl' => get_stylesheet_directory_uri(),
    'rootUrl' => get_site_url(),
    'uploadsUrl' => wp_upload_dir()
  );
  wp_localize_script('k9umlaude-main-script', 'directory_uri', $translation_array);
  wp_enqueue_script('k9umlaude-main-script', array('jquery'), '1.0', true, true);
}
add_action('wp_enqueue_scripts', 'k9umlaude_scripts');

// Responsive embeds (single.php)
add_action('after_setup_theme', function () {
  add_theme_support('responsive-embeds');
});

//-----------------------------
//------- ADMIN -------
//-----------------------------

// Add admin menu separator at indexes
add_action('admin_menu', function () {
  global $menu;
  $menu[30] = ['', 'read', '', '', 'wp-menu-separator'];
  $menu[40] = ['', 'read', '', '', 'wp-menu-separator'];
});

// Add admin color scheme
function additional_admin_color_schemes()
{
  $theme_dir = get_template_directory_uri();

  wp_admin_css_color(
    'adri',
    __('Adri'),
    $theme_dir . '/assets/css/colors.min.css',
    array('#004d56', '#fff', '#2e2e2e', '#3f939c')
  );
}
add_action('admin_init', 'additional_admin_color_schemes');

//-----------------------------
//------- LOGIN PAGE -------
//-----------------------------
function my_login_stylesheet()
{
  wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/assets/css/style-login.min.css');
}
add_action('login_enqueue_scripts', 'my_login_stylesheet');

//-----------------------------
//------- HIDE TOOLBAR -------
//-----------------------------
function tf_check_user_role($roles)
{
  /* Check user logged-in */
  if (is_user_logged_in()) :
    /* Get current logged-in user data */
    $user = wp_get_current_user();
    /* Fetch only roles */
    $currentUserRoles = $user->roles;
    /* Intersect both array to check any matching value */
    $isMatching = array_intersect($currentUserRoles, $roles);
    $response = false;
    /* If any role matched then return true */
    if (!empty($isMatching)) :
      $response = true;
    endif;
    return $response;
  endif;
}
$roles = ['subscriber'];
if (tf_check_user_role($roles)) :
  add_filter('show_admin_bar', '__return_false');
endif;

require_once(__DIR__ . '/inc/functions/gutenberg.php');
require_once(__DIR__ . '/inc/functions/timber.php');
require_once(__DIR__ . '/inc/functions/register-form.php');
require_once(__DIR__ . '/inc/functions/custom-admin-lists.php');
require_once(__DIR__ . '/inc/functions/rest-api.php');
