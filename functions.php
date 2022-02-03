<?php
//------- ADMIN COLOR SCHEME -------
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

// Add admin menu separator at indexes
add_action('admin_menu', function () {
  global $menu;
  $menu[35] = ['', 'read', '', '', 'wp-menu-separator'];
  $menu[40] = ['', 'read', '', '', 'wp-menu-separator'];
});

// Responsive embeds (single.php)
add_action('after_setup_theme', function () {
  add_theme_support('responsive-embeds');
});

///------- GUTENBERG -------
// Styles
function gutenberg_css()
{
  add_theme_support('editor-styles');
  add_editor_style('assets/css/style-editor.min.css');
}
add_action('after_setup_theme', 'gutenberg_css');

// Disable Gutenberg for post types
function prefix_disable_gutenberg($current_status, $post_type)
{
  if (
    $post_type === 'home'
    || $post_type === 'about'
    || $post_type === 'services'
    || $post_type === 'projects'
    || $post_type === 'clients'
    || $post_type === 'news'
    || $post_type === 'contact'
    || $post_type === 'others'
  ) return false;
  return $current_status;
}
add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);

// Theme custom font sizes
add_theme_support(
  'editor-font-sizes',
  array(
    array(
      'name'      => __('Pequeña', 'medea'),
      'shortName' => __('Sm', 'medea'),
      'size'      => 14,
      'slug'      => 'small'
    ),
    array(
      'name'      => __('Base', 'medea'),
      'shortName' => __('B', 'medea'),
      'size'      => 16,
      'slug'      => 'base'
    ),
    array(
      'name'      => __('Normal', 'medea'),
      'shortName' => __('N', 'medea'),
      'size'      => 18,
      'slug'      => 'regular'
    ),
    array(
      'name'      => __('Mediana S', 'medea'),
      'shortName' => __('Ms', 'medea'),
      'size'      => 20,
      'slug'      => 'medium-s'
    ),
    array(
      'name'      => __('Mediana L', 'medea'),
      'shortName' => __('Ml', 'medea'),
      'size'      => 22,
      'slug'      => 'medium-l'
    ),
    array(
      'name'      => __('Grande', 'medea'),
      'shortName' => __('G', 'medea'),
      'size'      => 30,
      'slug'      => 'big'
    ),
    array(
      'name'      => __('Enorme', 'medea'),
      'shortName' => __('E', 'medea'),
      'size'      => 60,
      'slug'      => 'huge'
    )
  )
);

// Disable Gutenberg custom font size
add_theme_support('disable-custom-font-sizes');

// ------- LOGIN PAGE -------
function my_login_stylesheet()
{
  wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/assets/css/style-login.min.css');
}
add_action('login_enqueue_scripts', 'my_login_stylesheet');

// ------- TIMBER CONFIG -------
/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber')) {
  add_action(
    'admin_notices',
    function () {
      echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
    }
  );

  add_filter(
    'template_include',
    function ($template) {
      return get_stylesheet_directory() . '/static/no-timber.html';
    }
  );
  return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site
{
  /** Add timber support. */
  public function __construct()
  {
    add_action('after_setup_theme', array($this, 'theme_supports'));
    add_filter('timber/context', array($this, 'add_to_context'));
    add_filter('timber/twig', array($this, 'add_to_twig'));
    add_action('init', array($this, 'register_post_types'));
    add_action('init', array($this, 'register_taxonomies'));
    parent::__construct();
  }
  /** This is where you can register custom post types. */
  public function register_post_types()
  {
  }
  /** This is where you can register custom taxonomies. */
  public function register_taxonomies()
  {
  }

  /** This is where you add some context
   *
   * @param string $context context['this'] Being the Twig's {{ this }}.
   */
  public function add_to_context($context)
  {
    $context['menu']  = new Timber\Menu();
    $context['site']  = $this;
    return $context;
  }

  public function theme_supports()
  {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
          * Let WordPress manage the document title.
          * By adding theme support, we declare that this theme does not use a
          * hard-coded <title> tag in the document head, and expect WordPress to
          * provide it for us.
          */
    add_theme_support('title-tag');

    /*
          * Enable support for Post Thumbnails on posts and pages.
          *
          * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
          */
    add_theme_support('post-thumbnails');

    /*
          * Switch default core markup for search form, comment form, and comments
          * to output valid HTML5.
          */
    add_theme_support(
      'html5',
      array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
      )
    );

    /*
          * Enable support for Post Formats.
          *
          * See: https://codex.wordpress.org/Post_Formats
          */
    add_theme_support(
      'post-formats',
      array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
      )
    );

    add_theme_support('menus');
  }

  /** This is where you can add your own functions to twig.
   *
   * @param string $twig get extension.
   */
  public function add_to_twig($twig)
  {
    $twig->addExtension(new Twig\Extension\StringLoaderExtension());
    $twig->addFilter(new Twig\TwigFilter('myfoo', array($this, 'myfoo')));
    return $twig;
  }
}

new StarterSite();
