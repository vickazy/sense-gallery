<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class senseTemplating{

	public static function init(){
		add_filter( 'template_include', array( __CLASS__, 'get_sense_template' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'custom_front_page' ) );
	}

	public static function get_sense_template( $template ){	
		if( get_post_type( get_the_ID() ) == 'sense_gallery' ) {
			if( is_single() ) {
				$template = self::sense_get_template( 'single-sense_gallery' );
			} elseif( is_post_type_archive( 'sense_gallery' ) ) {
				$template = self::sense_get_template( 'archive-sense_gallery' );
			} elseif( is_tax( 'galleries_cat' ) || is_tax( 'galleries_tag' ) ) {
				$template = self::sense_get_template( 'taxonomy-gallery_cat' );
			} else {
				$template = self::sense_get_template( 'archive-sense_gallery' );
			}
		}
		return $template;
	}

	private static function sense_get_template( $template_slug ){

		$template = $template_slug . '.php';
		$file = '';

		if ( $theme_file = locate_template( array( 'template/' . $template ) ) ) {
			$file = $theme_file;
		}
		else {
			$file = SG_PLUGIN_DIR . 'template/' . $template;
		}

		return apply_filters( 'sg_template_' . $template, $file );
	}

	public static function custom_front_page( $q ){
		if( is_admin() ) {
			return;
		}

		if( $q->get( 'page_id' ) == get_option('page_on_front') && $q->get( 'page_id' ) == get_page_by_path( 'galleries' )->ID ):
			$q->set( 'post_type', 'sense_gallery' );
			$q->set( 'page_id', '' );

			$q->is_page = false;
			$q->is_singular = false;
			$q->is_post_type_archive = true;
			$q->is_archive = true;

		endif;
	}

	public static function gallery_url(){
		return esc_url( home_url( '/gallery' ) );
	}

}

senseTemplating::init();