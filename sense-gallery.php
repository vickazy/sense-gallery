<?php

/*
Plugin Name: Sense Gallery
Plugin URI: http://sense.id
Description: Simple Gallery Plugins
Version: 1.0.0
Author: sense
Author URI: https://sense.id/
Text Domain: _sense
License: GPL v3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	
class SenseGallery {

	protected static $_instance = null;

	public function __construct(){
		$this->constant();
		$this->includes();
		$this->init();

		senseEnqueue::$version = '1.0.0';
	}

	public static function instance(){
		null === self::$_instance and self::$_instance = new self;
		return self::$_instance;
	}

	private function init(){
		add_action( 'init', array( 'senseEnqueue', 'init' ) );
		register_activation_hook( __FILE__, array( $this, 'add_album_archive_page' ) );

	}

	public function add_album_archive_page(){
		if( get_page_by_title( 'Galleries' ) == false ) {
			$page = array(
				'post_title'    => 'Galleries',
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'		=> 'page',
				'post_slug'		=> 'gallery'
			);
			$page_id = wp_insert_post( $page );
		}
	}

	private function includes() {
		$files = array(
			'inc/class.post-type',
			'inc/class.metabox',
			'inc/class.enqueue',
			'inc/class.templating'
		);

		foreach ($files as $file) {
			include_once SG_PLUGIN_DIR . $file . '.php';
		}
	}

	private function constant() {
		define( 'SG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'SG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}

}

SenseGallery::instance();