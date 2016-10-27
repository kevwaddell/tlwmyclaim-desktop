<?php
if ( ! function_exists( 'tlwmyclaim_setup' ) ) :

function tlwmyclaim_setup() {

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'user-menu' => __( 'User Menu',      'tlwmyclaim' ),
		'footer-menu'  => __( 'Footer Menu', 'tlwmyclaim' ),
		'admin-menu'  => __( 'Admin Menu', 'tlwmyclaim' )
	) );
	
if ( function_exists( 'register_sidebar' ) ) {
	
	$login_sb_args = array(
	'name'          => "User actions",
	'id'            => "user-actions",
	'description'   => 'Actions for logged in Users',
	'class'         => 'user-links',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '',
	'after_title'   => '' 
	);
	register_sidebar( $login_sb_args );
}

}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'tlwmyclaim_setup' );	
	
function tlwmyclaim_scripts() {
	// Load stylesheets.
	wp_enqueue_style( 'bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '3.3.6', 'screen' );
	wp_enqueue_style( 'tlwmyclaim-style', get_stylesheet_directory_uri().'/_/css/styles.css', array('bootstrap-style'), filemtime( get_stylesheet_directory().'/_/css/styles.css' ), 'screen' );
	
	// Load JS
	wp_enqueue_script( 'jQuery');
	wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );
	wp_enqueue_script( 'tlwmyclaim-script', get_template_directory_uri() . '/_/js/functions.js', array( 'jquery', 'bootstrap-js' ), filemtime( get_stylesheet_directory().'/_/js/functions.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'tlwmyclaim_scripts' );

?>