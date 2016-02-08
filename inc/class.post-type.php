<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class sensePostType{

	public static function init(){
		add_action( 'init', array( __CLASS__, '_sense_gallery_init' ) );
		add_action( 'init', array( __CLASS__, '_sense_gallery_taxonomy' ) );
		add_action( 'manage_sense_gallery_posts_columns', array( __CLASS__, '_sense_set_galleries_columns' ) );
	}

	public static function _sense_gallery_init() {
		$labels = array(
			'name'               => _x( 'Galleries', 'post type general name', '_sense' ),
			'singular_name'      => _x( 'Gallery', 'post type singular name', '_sense' ),
			'menu_name'          => _x( 'Galleries', 'admin menu', '_sense' ),
			'name_admin_bar'     => _x( 'Gallery', 'add new on admin bar', '_sense' ),
			'add_new'            => _x( 'Add New Gallery', 'Gallery', '_sense' ),
			'add_new_item'       => __( 'Add New Gallery', '_sense' ),
			'new_item'           => __( 'New Gallery', '_sense' ),
			'edit_item'          => __( 'Edit Gallery', '_sense' ),
			'view_item'          => __( 'View Gallery', '_sense' ),
			'all_items'          => __( 'All Galleries', '_sense' ),
			'search_items'       => __( 'Search Galleries', '_sense' ),
			'parent_item_colon'  => __( 'Parent Galleries:', '_sense' ),
			'not_found'          => __( 'No galleries found.', '_sense' ),
			'not_found_in_trash' => __( 'No galleries found in Trash.', '_sense' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', '_sense' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'gallery' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'sense_gallery', $args );
	}

	public static function _sense_gallery_taxonomy() {

		$labels = array(
			'name'              => _x( 'Gallery Categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Gallery Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Gallery Categories' ),
			'all_items'         => __( 'All Gallery Categories' ),
			'parent_item'       => __( 'Parent Gallery Category' ),
			'parent_item_colon' => __( 'Parent Gallery Category:' ),
			'edit_item'         => __( 'Edit Gallery Category' ),
			'update_item'       => __( 'Update Gallery Category' ),
			'add_new_item'      => __( 'Add New Gallery Category' ),
			'new_item_name'     => __( 'New Gallery Category Name' ),
			'menu_name'         => __( 'Gallery Category' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'gallery-category' ),
		);

		register_taxonomy( 'gallery_cat', array( 'sense_gallery' ), $args );

		$labels = array(
			'name'                       => _x( 'Gallery Tags', 'taxonomy general name' ),
			'singular_name'              => _x( 'Gallery Tags', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Gallery Tags' ),
			'popular_items'              => __( 'Popular Gallery Tags' ),
			'all_items'                  => __( 'All Gallery Tags' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Gallery Tag' ),
			'update_item'                => __( 'Update Gallery Tag' ),
			'add_new_item'               => __( 'Add New Gallery Tag' ),
			'new_item_name'              => __( 'New Gallery Tag Name' ),
			'separate_items_with_commas' => __( 'Separate gallery tag with commas' ),
			'add_or_remove_items'        => __( 'Add or remove gallery tags' ),
			'choose_from_most_used'      => __( 'Choose from the most used gallery tags' ),
			'not_found'                  => __( 'No gallery tags found.' ),
			'menu_name'                  => __( 'Gallery Tags' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'galleries-tag' ),
		);

		register_taxonomy( 'gallery_tag', 'sense_gallery', $args );
	}

	public static function _sense_set_galleries_columns( $columns ){
		unset(
			$columns['author'],
			$columns['comments']
		);
		return $columns;
	}

}
sensePostType::init();
