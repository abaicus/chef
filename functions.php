<?php
/**
 * Chef functions and definitions
 *
 * @package Chef
 */


if ( ! function_exists( 'chef_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function chef_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Chef, use a find and replace
	 * to change 'chef' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'chef', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

  // Set the content width based on the theme's design and stylesheet.
  global $content_width;
  if ( ! isset( $content_width ) ) {
    $content_width = 640;
  }

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
  add_image_size('chef-featured-big', 570, 400, true);
  add_image_size('chef-featured-small', 285, 200, true);
  add_image_size('chef-thumb', 800);

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'chef' ),
    'social' => __( 'Social', 'chef' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'chef_custom_background_args', array(
		'default-color' => 'f99a97',
		'default-image' => get_template_directory_uri() . '/images/bg.jpg',
	) ) );
}
endif; // chef_setup
add_action( 'after_setup_theme', 'chef_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function chef_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'chef' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
  register_sidebar( array(
    'name'          => __( 'Home page', 'chef' ),
    'id'            => 'sidebar-2',
    'description'   => __( 'To use this widget area you need to assign the Front Page template to your static front page.', 'chef' ),
    'before_widget' => '<section id="%1$s" class="front-block clearfix %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="block-title">',
    'after_title'   => '</h3>',
  ) );

  register_widget( 'Chef_Recipes_A' );
  register_widget( 'Chef_Recipes_B' );
  register_widget( 'Chef_Courses_List' );
  register_widget( 'Chef_Cuisines_List' );
  register_widget( 'Chef_Random_Recipes' );
  register_widget( 'Chef_Video' );
  register_widget( 'Chef_Recent_Posts' );
  register_widget( 'Chef_Recent_Comments' );
}
add_action( 'widgets_init', 'chef_widgets_init' );

require get_template_directory() . "/widgets/recipes-type-a.php";
require get_template_directory() . "/widgets/recipes-type-b.php";
require get_template_directory() . "/widgets/courses-list.php";
require get_template_directory() . "/widgets/cuisines-list.php";
require get_template_directory() . "/widgets/random-recipes.php";
require get_template_directory() . "/widgets/video-widget.php";
require get_template_directory() . "/widgets/recent-posts.php";
require get_template_directory() . "/widgets/recent-comments.php";

/**
 * Enqueue scripts and styles.
 */
function chef_scripts() {

	wp_enqueue_style( 'chef-bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), true );


  if ( get_theme_mod('body_font_name') !='' ) {
    wp_enqueue_style( 'chef-body-fonts', '//fonts.googleapis.com/css?family=' . esc_attr(get_theme_mod('body_font_name')) );
  } else {
    wp_enqueue_style( 'chef-body-fonts', '//fonts.googleapis.com/css?family=Fira+Sans:400,700,400italic,700italic');
  }

  if ( get_theme_mod('headings_font_name') !='' ) {
    wp_enqueue_style( 'chef-headings-fonts', '//fonts.googleapis.com/css?family=' . esc_attr(get_theme_mod('headings_font_name')) );
  } else {
    wp_enqueue_style( 'chef-headings-fonts', '//fonts.googleapis.com/css?family=Oswald:400,700');
  }

	wp_enqueue_style( 'chef-style', get_stylesheet_uri() );

	wp_enqueue_style( 'chef-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.min.css' );

	wp_enqueue_script( 'chef-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), true );

	wp_enqueue_script( 'chef-slicknav', get_template_directory_uri() . '/js/jquery.slicknav.min.js', array(), true );

	wp_enqueue_script( 'chef-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), true );

	wp_enqueue_script( 'chef-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'chef_scripts' );

/**
 * Change the excerpt length
 */
function gourmet_excerpt_length( $length ) {

  $excerpt = get_theme_mod('exc_lenght', '55');
  return $excerpt;

}
add_filter( 'excerpt_length', 'gourmet_excerpt_length', 999 );

/**
 * Load html5shiv
 */
function chef_html5shiv() {
    echo '<!--[if lt IE 9]>' . "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/js/html5shiv.js' ) . '"></script>' . "\n";
    echo '<![endif]-->' . "\n";
}
add_action( 'wp_head', 'chef_html5shiv' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Recipe Hero compatibility file.
 */
require get_template_directory() . '/recipe-hero/recipe-customs.php';

/**
 * Slider
 */

require get_template_directory() . '/inc/slider/slider.php';

/**
 * Slider
 */
require get_template_directory() . '/styles.php';

/**
 * Slider
 */
require get_template_directory() . '/inc/svg.php';


/**
 *TGM Plugin activation.
 */
require_once get_template_directory() . '/class-tgm-plugin-activation.php';

/**
 * TGMPA register
 */
function chef_register_required_plugins() {
		$plugins = array(
			array(
				'name'               => 'Recipe Hero',
				'slug'               => 'recipe-hero',
				'required'           => false,
			),

			array(
				'name'      => 'WP Product Reviews',
				'slug'      => 'wp-product-reviews',
				'required'  => false,
			),

			array(
				'name'      => 'Intergeo Maps - Google Maps Plugin',
				'slug'      => 'intergeo-maps',
				'required'  => false
			),

			array(
				'name'     => 'Pirate Forms',
				'slug' 	   => 'pirate-forms',
				'required' => false
			));

	$config = array(
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'chef' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'chef' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'chef' ),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'chef' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'chef' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'chef' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'chef' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'chef' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'chef' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'chef' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'chef' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'chef' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'chef' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'chef' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'chef' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'chef' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'chef' ),
            'nag_type'                        => 'updated'
        )
    );

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'chef_register_required_plugins' );
