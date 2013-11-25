<?php
/*
Plugin Name: Hearts and Eyes Custom Post Types
Plugin URI: http://heartsandeyes.co.za
Description: Declares a plugin that will create custom post types for Hearts and Eyes.
Version: 1.0
Author: Arno Esterhuizen
Author URI: https://www.facebook.com/arno.esterhuizen
License: GPLv2
*/

add_action( 'init', 'hne_cpt_init_productions', 0 );
add_action( 'init', 'hne_cpt_init_people', 0 );
add_action( 'init', 'hne_sc_init', 0 );
register_activation_hook( __FILE__, 'hne_plugin_activation' );

function hne_plugin_activation() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    hne_cpt_init_productions();
    hne_cpt_init_people();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}

// Hearts and Eyes Custom Post Types -- Productions
function hne_cpt_init_productions() {
	$production_labels = array(
		'name'                => _x( 'Productions', 'Post Type General Name', 'hne' ),
		'singular_name'       => _x( 'Production', 'Post Type Singular Name', 'hne' ),
		'menu_name'           => __( 'Productions', 'hne' ),
		'parent_item_colon'   => __( '', 'hne' ),
		'all_items'           => __( 'All Productions', 'hne' ),
		'view_item'           => __( 'View Production', 'hne' ),
		'add_new_item'        => __( 'Add New Production', 'hne' ),
		'add_new'             => __( 'Add New', 'hne' ),
		'edit_item'           => __( 'Edit Production', 'hne' ),
		'update_item'         => __( 'Update Production', 'hne' ),
		'search_items'        => __( 'Search productions', 'hne' ),
		'not_found'           => __( 'No productions found', 'hne' ),
		'not_found_in_trash'  => __( 'No productions found in Trash', 'hne' ),
	);

	$production_rewrite = array(
		'slug'                => 'productions',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);

	$production_args = array(
		'label'               => __( 'production', 'hne' ),
		'description'         => __( 'Production information pages', 'hne' ),
		'labels'              => $production_labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $production_rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'production', $production_args );
}

// Hearts and Eyes Custom Post Types -- People
function hne_cpt_init_people() {
	// create a new taxonomy
	$role_labels = array(
		'name'                       => _x( 'The Collective', 'Taxonomy General Name', 'hne' ),
		'singular_name'              => _x( 'The Collective', 'Taxonomy Singular Name', 'hne' ),
		'menu_name'                  => __( 'Roles', 'hne' ),
		'all_items'                  => __( 'All Roles', 'hne' ),
		'parent_item'                => __( '', 'hne' ),
		'parent_item_colon'          => __( '', 'hne' ),
		'new_item_name'              => __( 'New Role', 'hne' ),
		'add_new_item'               => __( 'Add New Role', 'hne' ),
		'edit_item'                  => __( 'Edit Role', 'hne' ),
		'update_item'                => __( 'Update Role', 'hne' ),
		'separate_items_with_commas' => __( 'Separate roles with commas', 'hne' ),
		'search_items'               => __( 'Search roles', 'hne' ),
		'add_or_remove_items'        => __( 'Add or remove roles', 'hne' ),
		'choose_from_most_used'      => __( 'Choose from the most used roles', 'hne' ),
	);
	$role_args = array(
		'labels'                     => $role_labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'collective', 'person', $role_args );

	$person_labels = array(
		'name'                => _x( 'People', 'Post Type General Name', 'hne' ),
		'singular_name'       => _x( 'Person', 'Post Type Singular Name', 'hne' ),
		'menu_name'           => __( 'People', 'hne' ),
		'parent_item_colon'   => __( '', 'hne' ),
		'all_items'           => __( 'All People', 'hne' ),
		'view_item'           => __( 'View Person', 'hne' ),
		'add_new_item'        => __( 'Add New Person', 'hne' ),
		'add_new'             => __( 'Add New', 'hne' ),
		'edit_item'           => __( 'Edit Person', 'hne' ),
		'update_item'         => __( 'Update Person', 'hne' ),
		'search_items'        => __( 'Search people', 'hne' ),
		'not_found'           => __( 'No people found', 'hne' ),
		'not_found_in_trash'  => __( 'No people found in Trash', 'hne' ),
	);
	$person_rewrite = array(
		'slug'                => 'people',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$person_args = array(
		'label'               => __( 'person', 'hne' ),
		'description'         => __( 'Person information pages', 'hne' ),
		'labels'              => $person_labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', ),
		'taxonomies'          => array( 'collective' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $person_rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'person', $person_args );
}

// Hearts and Eyes Shortcodes -- Productions
function hne_sc_init () {
	add_shortcode( 'production', 'hne_sc_dfn_productions' );
	add_shortcode( 'person',     'hne_sc_dfn_people' );

	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      //add_filter( 'mce_external_plugins', 'hearts_and_eyes_add_plugin' );
      //add_filter( 'mce_buttons', 'hearts_and_eyes_register_buttons' );
   }
}

// Add Shortcode
function hne_sc_dfn_productions( $atts , $content = null ) {
	return hne_sc_dfn ($atts, $content, 'production');
}
function hne_sc_dfn_people( $atts , $content = null ) {
	return hne_sc_dfn ($atts, $content, 'person');
}

function hne_sc_dfn ( $atts , $content = null , $shortcode ) {
	// Attributes
	extract( shortcode_atts(
		array(
			'id' => null,
			'name' => null,
		), $atts )
	);

	$page = null;

	// try a passed id parameter first
	if (null != $id && is_numeric($id)) {
		$page = get_post($id, ARRAY_A, $shortcode);
	}

	// try a passed name parameter second
	if (null == $page && null != $name && '' != $name) {
		$page = get_page_by_title($name, ARRAY_A, $shortcode);
	}

	// try the enclosed text as post name last
	if (null == $page) {
		$page = get_page_by_title($content, ARRAY_A, $shortcode);
	}

	if (null != $page) {
		$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($page['ID']), 'thumbnail', true);

		//return '<pre>' . var_dump(wp_get_attachment_image_src(get_post_thumbnail_id($page['ID']), 'thumbnail', true)) . '</pre>';
		return '<a href="' . get_permalink($page['ID']) . '" title="' . esc_attr( $page['post_title'] ) . '" data-thumbnail="' . $thumbnail[0] . '" data-summary="' . substr($page['post_content'], 0, 140) . '">' . $content . '</a> <aside class="pullquote">' . '<a href="' . get_permalink($page['ID']) . '" title="' . esc_attr( $page['post_title'] ) . '">' . get_the_post_thumbnail($page['ID'], array(64, 64)) . '</a>' .substr($page['post_content'], 0, 140) . '<a href="' . get_permalink($page['ID']) . '" title="Read more: ' . esc_attr( $page['post_title'] ) . '">&hellip;</a>' . '</aside>';
	}

	return $content;
}

function custom_excerpt_length( $length ) {
	return 10;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function hearts_and_eyes_register_buttons( $buttons ) {
   array_push( $buttons, "|", "people", "productions" );
   return $buttons;
}

function hearts_and_eyes_add_plugin( $plugin_array ) {
   $plugin_array['hne_cpt_tinymce'] = get_template_directory_uri() . '/js/hne_cpt_tinymce.js';
   return $plugin_array;
}