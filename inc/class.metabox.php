<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class senseMetabox {

	private static $metaboxes = array();

	public static function init() {
		self::$metaboxes = self::metaboxes();
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'save_post', array( __CLASS__, 'save' ) );
	}

	private static function metaboxes(){
		$metaboxes = array(
			array(
				'id' => 'sense_gallery_type',
				'name' => __( 'Gallery Type', '_sense' ),
				'context' => 'side',
				'priority' => 'default',
				'fields' => array(
					'name' => '_gallery_type',
					'type' => 'gallery_type'
				)
			),
			array(
				'id' => 'sense_upload_images',
				'name' => __( 'Upload Images', '_sense' ),
				'context' => 'normal',
				'priority' => 'default',
				'fields' => array(
					'name' => '_sense_photo',
					'type' => 'images_uploader'
				)
			),
			array(
				'id' => 'sense_video_html',
				'name' => __( 'Embed Video', '_sense' ),
				'context' => 'normal',
				'priority' => 'default',
				'fields' => array(
					'name' => '_sense_video',
					'type' => 'video_embed'
				)
			)	
		);

		return $metaboxes;
	}

	public static function add_meta_boxes() {
		foreach ( self::$metaboxes as $mb ) {
			add_meta_box( 
				$mb['id'], 
				$mb['name'], 
				array( __CLASS__, 'render_content' ), 
				'sense_gallery', 
				$mb['context'], 
				$mb['priority'],
				$mb['fields']
			);
		}

	}

	public static function render_content( $post, $mb ){
		$field = $mb['args'];
		$meta = get_post_meta($post->ID, $field['name'], true);

		wp_nonce_field( 'sense_gallery', 'sense_nonce' );

		switch ( $field['type'] ) {
			case 'gallery_type':
				$gallery_type = get_post_meta( $post->ID, '_gallery_type', true ); ?>
		            <input class="gallery-format" id="gallery-format-image" name="gallery_type" type="radio" value="image" <?php echo $gallery_type == 'image' ? 'checked="checked"' : ''; ?>>
		            <label class="post-format-icon post-format-image" for="gallery-format-image">Image</label><br>
		            <input class="gallery-format" id="gallery-format-video" name="gallery_type" type="radio" value="video" <?php echo $gallery_type == 'video' ? 'checked="checked"' : ''; ?>>
		            <label class="post-format-icon post-format-video" for="gallery-format-video">Video</label><br><?php
				break;
			case 'video_embed':
				$sense_video = '';
				if ( metadata_exists( 'post', $post->ID, $field['name'] ) ) {
					$sense_video = get_post_meta( $post->ID, $field['name'], true );
				} ?>
	        	<label class="screen-reader-text" for="sense_video"><?php _e( 'Video Embed', '_sense' ); ?></label>
	        	<textarea id="sense_video" name="<?php echo $field['name']; ?>" style="width: 100%; height: 4em;"><?php echo esc_attr( $sense_video ); ?></textarea><?php
    			break;
    		case 'images_uploader': ?>
				<div class="sense-photos">
					<ul id="sense-images">
						<?php
							if ( metadata_exists( 'post', $post->ID, '_sense_photos' ) ) {
								$sense_photo = get_post_meta( $post->ID, '_sense_photos', true );
							} else {
								$attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_woocommerce_exclude_image&meta_value=0' );
								$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
								$sense_photo = implode( ',', $attachment_ids );
							}

							$attachments = array_filter( explode( ',', $sense_photo ) );

							if ( ! empty( $attachments ) ) {
								foreach ( $attachments as $attachment_id ) {
									echo '
										<li data-image_id="' . esc_attr( $attachment_id ) . '">
											' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
											<a href="#" class="delete">x</a>
										</li>';
								}
							}
						?>
					</ul>
					<input type="hidden" id="sense_photo" name="<?php echo $field['name']; ?>" value="<?php echo esc_attr( $sense_photo ); ?>" />
				</div>
				<div class="sense-uploads hide-if-no-js">
					<button id="sense-upload" class="button" name="uploads"><?php _e( 'Add Images', '_sense' ); ?></button>
				</div><?php
				break;
		}
	}

	public static function save( $post_id ) {

		if ( ! isset( $_POST['sense_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sense_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'sense_gallery' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'sense_gallery' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$gallery_type = self::sanitize( $_POST['gallery_type'] );
		update_post_meta( $post_id, '_gallery_type', $gallery_type );

		$video = self::sanitize( $_POST['_sense_video'] );
		update_post_meta( $post_id, '_sense_video', $video );

		$img_ids = self::sanitize( $_POST['_sense_photo'] );
		update_post_meta( $post_id, '_sense_photos', $img_ids );


	}

	private static function sanitize( $data ){
		return stripslashes( htmlspecialchars( $data ) );
	}
}
senseMetabox::init();