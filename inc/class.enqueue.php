<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class senseEnqueue{

	public static $version;

	public static function init(){
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
	}

	public static function admin_enqueue(){
		wp_enqueue_style( 'admin-sense-gallery', plugins_url() . '/sense-gallery/assets/css/admin.css', false, self::$version, 'all' );

		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'sense-metabox', plugins_url() . '/sense-gallery/assets/js/metabox.js', array( 'jquery' ), self::$version, true );
		wp_localize_script( 'sense-metabox', 'sensevar', array(
				'select_text' => __( 'Select or Upload Images', '_sense' ),
				'btn_text' => __( 'Use Photos', '_sense' ),
			) );
	}

	public static function enqueue(){
		wp_enqueue_style( 'sense-lightbox', plugins_url() . '/sense-gallery/assets/css/lightbox.css', false, self::$version, 'all' );
		wp_enqueue_style( 'sense-gallery', plugins_url() . '/sense-gallery/assets/css/sense.gallery.css', false, self::$version, 'all' );

		wp_enqueue_script( 'sense-imgloaded', plugins_url() . '/sense-gallery/assets/js/imagesloaded.min.js', false, self::$version, true );
		wp_enqueue_script( 'sense-masonry', plugins_url() . '/sense-gallery/assets/js/masonry.min.js', array( 'sense-imgloaded' ), self::$version, true );
		wp_enqueue_script( 'sense-lightbox', plugins_url() . '/sense-gallery/assets/js/lightbox.js', array( 'jquery' ), self::$version, true );
		wp_enqueue_script( 'sense-frontend', plugins_url() . '/sense-gallery/assets/js/sense.gallery.js', array( 'sense-imgloaded', 'sense-lightbox' ), self::$version, true );
	}

}