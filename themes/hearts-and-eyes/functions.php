<?php
/**
 * Hearts And Eyes functions and definitions
 *
 * @package Hearts And Eyes
 */

if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/**
 * change path of the media type icon that gets returned
 */
/*
add_filter( 'icon_dir',     'hne_theme_icon_directory' );
add_filter( 'icon_dir_uri', 'hne_theme_icon_uri' );

function hne_theme_icon_directory( $icon_dir ) {
	return get_stylesheet_directory() . '/images';
}

function hne_theme_icon_uri( $icon_dir ) {
	return get_stylesheet_directory_uri() . '/images'; 
} */

if ( ! function_exists( 'hearts_and_eyes_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function hearts_and_eyes_setup() {
	load_theme_textdomain( 'hearts-and-eyes', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link') );
	add_theme_support( 'custom-background', apply_filters( 'hearts_and_eyes_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'hearts-and-eyes' ),
	) );
}
endif; // hearts_and_eyes_setup
add_action( 'after_setup_theme', 'hearts_and_eyes_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function hearts_and_eyes_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'hearts-and-eyes' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'hearts_and_eyes_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function hearts_and_eyes_scripts() {
	wp_enqueue_style( 'hearts-and-eyes-style', get_stylesheet_uri() );

	wp_enqueue_script( 'hearts-and-eyes-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'hearts-and-eyes-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'hearts-and-eyes-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'hearts_and_eyes_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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

add_action( 'wp_head', 'hne_favicon');
function hne_favicon(){
	echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/img/favicon.ico" sizes="16x16 24x24 32x32 64x64"/>' . "\n";
	echo '<link rel="icon" href="' . get_stylesheet_directory_uri() . '/img/favicon-32.png" sizes="32x32"/>' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" href="' . get_stylesheet_directory_uri() . '/img/favicon-152.png" sizes="152x152">' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" href="' . get_stylesheet_directory_uri() . '/img/favicon-144.png" sizes="144x144">' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" href="' . get_stylesheet_directory_uri() . '/img/favicon-120.png" sizes="120x120">' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" href="' . get_stylesheet_directory_uri() . '/img/favicon-114.png" sizes="114x114">' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" href="' . get_stylesheet_directory_uri() . '/img/favicon-72.png" sizes="72x72">' . "\n";
	echo '<link rel="apple-touch-icon-precomposed" href="' . get_stylesheet_directory_uri() . '/img/favicon-57.png" sizes="57x57">' . "\n";
	echo '<meta name="msapplication-TileColor" content="#BB1100">' . "\n";
	echo '<meta name="msapplication-TileImage" content="' . get_stylesheet_directory_uri() . '/img/favicon-144-msapplication-tileimage.png">' . "\n";
	echo '<link rel="icon" href="' . get_stylesheet_directory_uri() . '/img/favicon-228.png" sizes="228x228"/>' . "\n";
	echo '<meta property="og:image" content="' . get_stylesheet_directory_uri() . '/img/favicon-512.png">' . "\n";
}


// Add Shortcode
function header_shortcode( $atts , $content = null ) {
	// Attributes
	extract( shortcode_atts(
		array(
			'img' => '',
		), $atts )
	);

	// Code
	return '</section><section><header style="background-image:url(' . $img . ')">' . $content . '</header>';
}
add_shortcode( 'header', 'header_shortcode' );


//show the following post types in the default feed
function my_get_posts( $query ) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'post', 'page', 'productions', 'people') );
	}
	return $query;
}
//add_filter( 'pre_get_posts', 'my_get_posts' );